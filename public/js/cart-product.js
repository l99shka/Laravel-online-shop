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

            notifySuccess()
            elementUpdate('span#icon')
        }
    });
});


function notify(type, message) {
    (() => {
        let notificationArea = document.getElementById("notification-area");
        let existingNotification = notificationArea.querySelector(`.${type}`);

        if (existingNotification) { // Если существует уведомление с таким же типом, удаляем его
            existingNotification.remove();
        }

        let notification = document.createElement("div");
        let id = Math.random().toString(36).substr(2, 10);

        notification.setAttribute("id", id);
        notification.classList.add("notification", type);
        notification.innerText = message;

        notificationArea.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    })();
}



function notifySuccess(){
    notify("success","Товар добавлен в корзину!");
}


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

