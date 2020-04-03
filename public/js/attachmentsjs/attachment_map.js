function submitData(data, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/applicationType",
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
function GetApplications(callBack) {
    let cmb = '';
    $('.applicationType').html('');
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/applicationTypes",
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            $.each(result, function (index, value) {
                cmb += "<option value=" + value.id + ">" + value.name + "</option>";
            });
            $('.applicationType').html(cmb);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}
function GetAllDetails(appId, callBack) {
    let tbl = '';
    $('#allAt_tbl tbody').html(tbl);
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/applicationType/allAtachmentWithStatus/id/" + appId,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            $.each(result, function (index, value) {
                tbl += "<tr>";
                if (value.st == 1) {
                    tbl += '<td><input type="checkbox" name="atachCheck" value="' + value.id + '" checked=""></td>';
                } else {
                    tbl += '<td><input type="checkbox" name="atachCheck" value="' + value.id + '"></td>';
                }
                tbl += '<td>' + value.name + '</td>';
                tbl += "</tr>";
            });
            $('#allAt_tbl tbody').html(tbl);

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}
function GetAssignedList(appId, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/applicationType/assigned/id/" + appId,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            ASSIGNED = result;
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}
function Validiteinsert(data) {
    var response = true;
    if (data.name.length == 0) {
        $('#valAttachment').removeClass('d-none');
        $('#valUnique').addClass('d-none');
        response = false;
    }
    return response;
}