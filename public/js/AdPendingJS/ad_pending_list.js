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
    var url = "/api/files/pending/assistance_director/" + id;
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function loadAdPendingListTable(id) {
    getAdPendingList(id, function (result) {
        var Obj = {1: 'New EPL', 2: 'Renew EPL', 3: 'New Site Clearance', 4: 'Site Clearance'};
        var tbl = "";
        var id = 1;
        if (result.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(result, function (index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td>' + row.industry_name + '</td>';
                tbl += '<td><a href="/industry_profile/id/' + row.id + '" target="_blank">' + row.file_no + '</a></td>';
                tbl += '<td>' + Obj[row.cer_type_status] + '</td>';
                tbl += '<td><a href="/certificate_perforation/id/' + row.id + '" class="btn btn-success">Update Certificate<a></td>';
                tbl += '</tr>';
            });
        }
        $('#tblPendingAdList tbody').html(tbl);
    });
}