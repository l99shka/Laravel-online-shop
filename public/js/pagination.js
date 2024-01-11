$(document).ready(function() {
    var page = 1;

$("#showmore-button").click(function () {
    page++;
    infinteLoadMore(page);
});
});

function infinteLoadMore(page) {
    $.ajax({
        url: "/?page=" + page,
        datatype: "html",
        beforeSend: function() {
            $('#showmore-button').html('Подождите...');
            $('#showmore-button').attr('disabled', true);
        },
        type: "get",
    })
        .done(function (response) {
            $("#product-card").append($(response.html).hide().fadeIn(1000));

            $('#showmore-button').html('Показать еще');
            $('#showmore-button').attr('disabled', false);

            if (!response.hasMoreProducts) {
                $('#showmore-button').hide()
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occurred');
        });
}

$(document).ready(function() {
    var page = 1;

$("#showmore-button-category").click(function () {
    page++;

    var categoryElement = document.getElementById('showmore-button-category');
    var id = categoryElement.dataset.id || categoryElement.getAttribute('data-id');

    infinteLoadMoreCategory(page, id);
});
});

function infinteLoadMoreCategory(page, id) {

    $.ajax({
        url: "/category/" + id + "?page=" + page,
        datatype: "html",
        beforeSend: function() {
            $('#showmore-button-category').html('Loading...');
            $('#showmore-button-category').attr('disabled', true);
        },
        type: "get"
    })
        .done(function (response) {
            $("#product-card").append($(response.html).hide().fadeIn(1000));

            $('#showmore-button-category').html('Показать еще');
            $('#showmore-button-category').attr('disabled', false);

            if (!response.hasMoreProducts) {
                $('#showmore-button-category').hide()
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occurred');
        });
}
