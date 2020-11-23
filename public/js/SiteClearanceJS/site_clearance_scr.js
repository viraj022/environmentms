//Get Site Clear By ID
function getSiteClearanceAPI(id, callBack) {
    if (isNaN(id)) {
        return false;
    }
    var url = "/api/site_clearance/" + id;
    ajaxRequest('GET', url, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
//Set Processing Type
function setProcessingTypeAPI(site_clear_ses, data, callBack) {
    if (isNaN(site_clear_ses)) {
        return false;
    }
    var url = "/api/site_clearance/processing_status/" + site_clear_ses;
    ajaxRequest('PATCH', url, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
//Upload Tor Files & Data
function setUploadTorAPI(site_clear_ses, data, callBack) {
    if (isNaN(site_clear_ses)) {
        return false;
    }
    var url = "/api/tor/" + site_clear_ses;
    submitDataWithFile(url, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    }, 'POST');
}
//Upload Client Report Files & Data
function setUploadClientAPI(site_clear_ses, data, callBack) {
    if (isNaN(site_clear_ses)) {
        return false;
    }
    var url = "/api/client_report/" + site_clear_ses;
    submitDataWithFile(url, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    }, 'POST');
}
//Upload Site Clearance Extention
function setSiteClearanceExtenAPI(site_clear_exten, data, callBack) {
    if (isNaN(site_clear_exten)) {
        return false;
    }
    var url = "/api/client_clearance/extend/" + site_clear_exten;
    submitDataWithFile(url, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    }, 'POST');
}

//View COntent Files
function viewUploadContentData(content_arr) {
    if (content_arr.client_report != null) {
        $('#expireClientReport').val(content_arr.client_report.expire_date);
        $("#viewActiveClientRep").attr("href", '/' + content_arr.client_report.path);
        $('.sectionActiveClientRep').removeClass('d-none');
    }
    if (content_arr.tor != null) {
        $('#expireDateTor').val(content_arr.tor.expire_date);
        $('#validDateTor').val(content_arr.tor.valid_date);
        $("#viewActiveTor").attr("href", '/' + content_arr.tor.path);
        $('.sectionActiveTor').removeClass('d-none');
    }
}