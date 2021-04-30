function rate_post(post_id, rating){
    var params ={'post_id':post_id,'rating':rating }
    var token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/rating',
        type: "POST",
        data: params,
        cache: false,
        headers: {
            'X-CSRF-Token': token,
        },
        success: function (data) {
            console.log(data);
        },
        error: function (data, textStatus, errorThrown) {
            console.log(data);

        },
    });
}

