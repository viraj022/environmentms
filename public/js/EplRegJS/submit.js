function AddEpl(type, data, callBack) {
    var url = '';
    if (type == 'epl') {
        url = "/api/epl";
    } else if (type == 'site_clearance') {
        url = "/api/site_clearance_new";
    }
    if (!data) {
        $('#btnSave').removeClass('d-none');
        return false;
    }
    let formData = new FormData();
    // populate fields
    $.each(data, function (k, val) {
        formData.append(k, val);
    });
    ulploadFile2(url, formData, function (result) {
        $('#btnSave').removeClass('d-none');
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}
