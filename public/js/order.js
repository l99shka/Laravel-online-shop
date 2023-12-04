$(document).on('click', '#orderPay-button', function(e) {
        e.preventDefault()

        var formData = new FormData($('#survey-form')[0]);

        $.ajax({

            url: '/add-orders',
            type: "POST",
            datatype: 'json',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            cache: false,
            success: (data) => {
                if (data.alert) {
                    alert(data.alert);
                } else {
                    window.location = data.link;
                }
            },
            error: function (reject) {
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function (key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });
