function AddCommittee(data, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/committee",
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
    if (data.first_name.length == 0) {
        $('#valFname').removeClass('d-none');
        $('#valUnique').addClass('d-none');
        response = false;
    }
    if (data.nic.length < 10) {
        $('#valNic').removeClass('d-none');
        response = false;
    }
    if (data.contact_no.length < 10) {
        $('#valContact').removeClass('d-none');
        response = false;
    }
    return response;
}