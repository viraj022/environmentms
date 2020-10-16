//Method API
function activityStatusGetData(data, method, id, callBack) {
    //Current Usage Explained - POST/1 , PUT/2 , DELETE/3 , GET/4
    let DATA_METHOD = '';
    let URL = '';

    if (method === 1) {
        DATA_METHOD = 'POST';
        URL = '/api/file_log/' + id;
    } else if (method === 2) {
        DATA_METHOD = 'PUT';
        URL = '/api/file_log/' + id;
    } else if (method === 3) {
        DATA_METHOD = 'DELETE';
        URL = '/api/file_log/' + id;
    } else if (method === 4) {
        DATA_METHOD = 'GET';
        URL = '/api/file_log/' + id;
    } else {
        return false;
    }
    ajaxRequest(DATA_METHOD, URL, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}