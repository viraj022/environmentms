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
function setProcessingTypeAPI(site_clear_ses,data, callBack) {
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