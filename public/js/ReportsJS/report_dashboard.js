function env_officer_byAD(ad_id, callBack) {
    if (isNaN(ad_id)) {
        return false;
    }
    let cbo = '';
    ajaxRequest('GET', 'api/environment_officers/assistant_director/id/' + ad_id, null, function (dataSet) {
        if (dataSet.length == 0) {
            cbo = "<option value=''>No Data Found</option>";
        } else {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '">' + row.first_name + " " + row.last_name + '</option>';
            });
        }
        $('#eoCombo').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function loadAssDirCombo(callBack) {
    var url = '/api/AssistantDirector/active';
    let cbo = '';
    ajaxRequest('GET', url, null, function (dataSet) {
        if (dataSet.length == 0) {
            cbo = "<option value=''>No Data Found</option>";
        } else {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '">' + row.first_name + " " + row.last_name + '</option>';
            });
        }
        $('#getAsDirect').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}