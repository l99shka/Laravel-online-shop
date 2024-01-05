$('.add-button').click(function (e) {
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

            window.location.reload();
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

