function loadInspectionStatusAPI(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/inspection/id/" + id;
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}