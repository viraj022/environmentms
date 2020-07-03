function IssueEpl(epl_id, data, callBack) {
    if (!data) {
        return false;
    }
    let url = "/api/epl/issue/id/" + epl_id;
    ajaxRequest("POST", url, data, function (parameters) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(parameters);
        }
    });
}

function getEplCertificateDetails(EplId,callBack) {
    let url = "/api/epl/id/" + EplId;
    ajaxRequest("GET", url, null, function (parameters) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(parameters);
        }
    })
}