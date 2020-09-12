function loadAssistantDirectorCombo(callBack) { // Load Assustant Direcotr Combo
    ajaxRequest('GET', "/api/AssistantDirector/active", null, function (dataSet) {
        var combo = "";
        if (dataSet.length == 0) {
            combo += "<option value=''>NO DATA FOUND</option>";
        } else {
            $.each(dataSet, function (index, value) {
                combo += "<option value='" + value.id + "'>" + value.first_name + ' ' + value.last_name + "</option>";
            });
        }
        $('.combo_AssistantDirector').html(combo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}

function getAdPendingList(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/nt/id/" + id;
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function loadAdPendingListTable(id) {
    getAdPendingList(id, function (result) {
        var tbl = "";
        var id = 1;
        if (result.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(result, function (index, row) {
                tbl += '<tr>';
                tbl += '</tr>';
            });
        }
        $('#tblPendingAdList tbody').html(tbl);
    });
}