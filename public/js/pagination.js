var page = 1;
$("#showmore-button").click(function () {
    page++;
    infinteLoadMore(page);
});

function infinteLoadMore(page) {
    $.ajax({
        url: "/?page=" + page,
        datatype: "html",
        type: "get",
    })
        .done(function (response) {
            $("#product-card").append(response.html);
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occurred');
        });
}

$("#showmore-button-category").click(function () {
    page++;

    var categoryElement = document.getElementById('showmore-button-category');
    var id = categoryElement.dataset.id || categoryElement.getAttribute('data-id');

    infinteLoadMoreCategory(page, id);

});

function infinteLoadMoreCategory(page, id) {

    $.ajax({
        url: "/category/" + id + "?page=" + page,
        datatype: "html",
        type: "get"
    })
        .done(function (response) {
            $("#product-card").append(response.html);
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occurred');
        });
}
