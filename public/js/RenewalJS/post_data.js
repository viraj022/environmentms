function saveRenew(id, data, callBack) {

    var url = '/api/epl/renew/id/' + id;

    if (!data) {
        return false;
    }
    ajaxRequest("POST", url, data, function (result) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function Validiteinsert(data) {
    var response = true;
    if (data.remark.length == 0) {
        toastr.error('Remark is required')
        $('#getRemarkVal').addClass('is-invalid');
        response = false;
    } else {
        $('#getRemarkVal').removeClass('is-invalid');
    }
    if (data.submit_date.length == 0) {
        toastr.error('Date is required')
        $('#renewDate').addClass('is-invalid');
        response = false;
    } else {
        $('#renewDate').removeClass('is-invalid');
    }
    if (data.file.length == 0) {
        toastr.error('Renewal Application is required')
        response = false;
    }
    return response;
}