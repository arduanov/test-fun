function openModal(url) {
    var el = $('#myModal');
    el.modal('show');

    if(!url){
        el.find('.modal-body').text("Something went wrong");
        return;
    }

    $.ajax({
        url: url,
    })
        .done(function (data) {
            el.find('.modal-body').text(data);
        })
        .fail(function () {
            el.find('.modal-body').text("Something went wrong");
        });
}
