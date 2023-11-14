$(document).ready(function () {
    $('.cart-button').on('click', function() {

        var id = this.dataset.id;

        $.ajax({

            url: '/add-to-cart',
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
    });
})



$(document).ready(function () {
    $('.minus-btn').on('click', function() {
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

        // var $this = $(this);
        // var $input = $this.closest('div').find('input');
        // var value = parseInt($input.val());
        //
        // if (value > 2) {
        //     value = value - 1;
        // } else {
        //     value = 1;
        // }
        //
        // $input.val(value);

    });
})


$(document).ready(function () {
    $('.plus-btn').on('click', function() {

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

        // var $this = $(this);
        // var $input = $this.closest('div').find('input');
        // var value = parseInt($input.val());
        //
        // if (value < 100) {
        //     value = value + 1;
        // } else {
        //     value =100;
        // }
        //
        // $input.val(value);
    });

});

$(document).ready(function () {
    $('.delete-btn').on('click', function() {

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
    });
})

