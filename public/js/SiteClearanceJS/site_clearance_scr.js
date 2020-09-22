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