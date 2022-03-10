function AddEnvOfficer(data,id, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/approval/officer/id/"+id,
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
function AddAssDir(data2,id, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/approval/a_director/id/"+id,
        data: data2,
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
function AddDir(data3,id, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/approval/director/id/"+id,
        data: data3,
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
    if (data.date.length == 0) {
        $('#valPayCat').removeClass('d-none');
        response = false;
    }
    if (data.comment.length == 0) {
        $('#valName').removeClass('d-none');
        response = false;
    }
    return response;
}
function Validiteinsert2(data) {
    var response = true;
    if (data.date.length == 0) {
        $('#valPayCat').removeClass('d-none');
        response = false;
    }
    if (data.comment.length == 0) {
        $('#valName').removeClass('d-none');
        response = false;
    }
    return response;
}
function Validiteinsert3(data) {
    var response = true;
    if (data.date.length == 0) {
        $('#valPayCat').removeClass('d-none');
        response = false;
    }
    if (data.comment.length == 0) {
        $('#valName').removeClass('d-none');
        response = false;
    }
    return response;
}
