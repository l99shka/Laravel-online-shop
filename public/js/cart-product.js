$('.cart-product-button').click(function(e) {
    e.preventDefault()

    var id = this.dataset.id;

    $.ajax({

        url: '/add-to-cart',
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

            if (data.status === false) {
                window.location.href = '/login';
            } else {
                window.location.reload();
            }
        }
    });
});


$(document).ready(function () {
    $('.minus-btn').on('click', function() {
        refreshPage()

        var id = this.dataset.id;

        $.ajax({

            url: '/updateQuantityMinus',
            type: "POST",
            data: {
                id: id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                console.log(data)
            },
            error: (data) => {
                console.log(data)
            }

        });
        function refreshPage(){
            window.location.reload();
        }
    });
})


$(document).ready(function () {
    $('.plus-btn').on('click', function() {
        refreshPage()

        var id = this.dataset.id;

        $.ajax({

            url: '/updateQuantityPlus',
            type: "POST",
            data: {
                id: id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                console.log(data)
            },
            error: (data) => {
                console.log(data)
            }

        });
        function refreshPage(){
            window.location.reload();
        }
    });

});

$(document).ready(function () {
    $('.delete-btn').on('click', function() {
        refreshPage()

        var id = this.dataset.id;

        $.ajax({

            url: '/deleteProduct',
            type: "POST",
            data: {
                id: id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                console.log(data)
            },
            error: (data) => {
                console.log(data)
            }

        });
        function refreshPage(){
            window.location.reload();
        }
    });
})

