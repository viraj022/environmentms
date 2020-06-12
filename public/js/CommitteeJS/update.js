function updateCommittee(id, data, callBack) {
    $.ajax({
        type: "PUT",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/committee/id/" + id,
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

function Validiteupdate(data) {
    var response = true;
    if (data.first_name.length === 0) {
        $('#valFname').removeClass('d-none');
        response = false;
    }
    if (data.nic.length) {
        if (data.nic.length > 0) {
            if (data.nic.length != 12) {
                if (data.nic.length == 10) {
                    var str = data.nic;
                    var res = str.slice(0, 9);
                    if (!isNaN(res)) {
                        $('#valNic').removeClass('d-none');
                        return false;
                    }
                    var firstVal = data.nic.charAt(9);
//        alert(firstVal);
                    if (firstVal != "v" && firstVal != "x") {
                        $('#valNic').removeClass('d-none');
                        response = false;
                    }
                } else {
                    $('#valNic').removeClass('d-none');
                    return false;
                }
            } else {
                if (!$.isNumeric(data.nic)) {
                    $('#valNic').removeClass('d-none');
                    return false;
                }
            }
        }
    }
    if (data.contact_no.length) {
        if (data.contact_no.length === 0) {
            response = true;
        }
        if (data.contact_no.length < 10) {
            $('#valContact').removeClass('d-none');
            response = false;
        }
        var firstVal = data.contact_no.charAt(0);
        if (firstVal != 0) {
            $('#valContact').removeClass('d-none');
            response = false;
        }
    }
    return response;
}