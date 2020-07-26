function AddEpl(data, callBack) {
    if (!data) {
        return false;
    }
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/epl",
        data: data,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
//            alert(JSON.stringify(xhr.responseJSON.errors));
            $.each(xhr.responseJSON.errors, function (index, value) {
//                Toast.fire({
//                type: 'error',
//                title: '<p><h1>'+index+'<h1></p>'
//            });
                toastr.error(index + " " + value)
//alert(index +" "+ value);
            });
        }
    });
}
