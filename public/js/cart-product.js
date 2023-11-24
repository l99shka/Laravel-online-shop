$('.add-button').click(function(e) {
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

            url: '/deleteToCartProduct',
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

