function AddClient(data, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/client",
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
            alert(textStatus + ':' + errorThrown);
        }
    });
}

function Validiteinsert(data) {
    var response = true;
    if (data.first_name.length === 0) {
        $('#valPayCat').removeClass('d-none');
        response = false;
    }
    if (data.last_name.length === 0) {
        $('#valLName').removeClass('d-none');
        response = false;
    }
//    if (data.nic.length === 0) {
//        $('#valnicName').removeClass('d-none');
//        response = false;
//    }
//    if (data.address.length === 0) {
//        $('#valAddName').removeClass('d-none');
//        response = false;
//    }
//    if (data.contact_no.length === 0) {
//        $('#valConName').removeClass('d-none');
//        response = false;
//    }
    return response;
}