function AddPayments(data, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "api/payment",
        data: data,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
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
    if (data.payment_type_id.length == 0) {
        $('#valPayCat').removeClass('d-none');
        response = false;
    }
    if (data.name.length == 0) {
        $('#valName').removeClass('d-none');
        response = false;
    }
    if (data.type.length == 0) {
        $('#valPayType').removeClass('d-none');
        response = false;
    }
    return response;
}
