function AddEpl(data, callBack) {
    if (!data) {
        return false;
    }
    let formData = new FormData();
    // populate fields
    $.each(data, function (k, val) {
        formData.append(k, val);
    });
    ulploadFile2('/api/epl', formData, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}
