async function elementUpdate(selector) {
    try {
        var html = await (await fetch(location.href)).text();
        var newdoc = new DOMParser().parseFromString(html, 'text/html');
        document.querySelector(selector).outerHTML = newdoc.querySelector(selector).outerHTML;
        console.log('Элемент '+selector+' был успешно обновлен');
        return true;
    } catch(err) {
        console.log('При обновлении элемента '+selector+' произошла ошибка:');
        console.dir(err);
        return false;
    }
}

$('#product-card').on('click', '.add-button' ,function (e) {
    e.preventDefault()

    var id = this.dataset.id;

    $.ajax({

        url: '/addToCartProduct',
        type: "POST",
        datatype: 'json',
        data: {
            id: id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (data) => {
            console.log(data);

            elementUpdate('span#icon')
        }
    });
});


$('.minus-btn').on('click', function (e) {
    e.preventDefault()

    var id = this.dataset.id;

    $.ajax({

        url: '/updateQuantityMinus',
        type: "POST",
        datatype: 'json',
        data: {
            id: id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (data) => {
            console.log(data)

            window.location.reload();
        },
        error: (data) => {
            console.log(data)
        }

    });
});


$('.plus-btn').on('click', function (e) {
    e.preventDefault()

    var id = this.dataset.id;

    $.ajax({

        url: '/addToCartProduct',
        type: "POST",
        datatype: 'json',
        data: {
            id: id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (data) => {
            console.log(data)

            window.location.reload();
        },
        error: (data) => {
            console.log(data)
        }

    });
});


$('.delete-btn').on('click', function (e) {
    e.preventDefault()

    var id = this.dataset.id;

    $.ajax({

        url: '/deleteAll',
        type: "POST",
        data: {
            id: id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: (data) => {
            console.log(data)

            window.location.reload();
        },
        error: (data) => {
            console.log(data)
        }
    });
});

