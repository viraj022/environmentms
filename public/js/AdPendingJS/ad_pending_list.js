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
        var dataObj = {0: 'pending', 1: 'AD File Approval Pending', 2: 'Certificate Preparation', 3: 'AD Certificate Pending Approval', 4: 'D Certificate Approval Prenidng', 5: 'Complete', 6: 'Issued', '-1': 'Rejected', '-2': 'Hold'};
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
                tbl += '<td>' + dataObj[row.file_status] + '</td>';
                if (row.file_status != 0) {
                    tbl += '<td><button value="' + escape(JSON.stringify(row)) + '" class="btn btn-success actionDetails">Action</button></td>';
                } else {
                    tbl += '<td>N/A</td>';
                }
                tbl += '</tr>';
            });
        }
        $('#tblPendingAdList tbody').html(tbl);
    });
}

function preCertificateApi(file_id, assDir_id, DATA, callBack) {
    if (file_id.length == 0) {
        return false;
    }
    var url = "/api/assistant_director/approve/" + assDir_id + "/" + file_id;
    ajaxRequest('PATCH', url, DATA, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}
function certificateApproveApi(file_id, assDir_id, DATA, callBack) {
    if (file_id.length == 0) {
        return false;
    }
    var url = "/api/assistant_director/approve_certificate/" + assDir_id + "/" + file_id;
    ajaxRequest('PATCH', url, DATA, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}
function certificateRejectApi(file_id, assDir_id, DATA, callBack) {
    if (file_id.length == 0) {
        return false;
    }
    var url = "/api/assistant_director/reject_certificate/" + assDir_id + "/" + file_id;
    ajaxRequest('PATCH', url, DATA, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function fileRejectApi(file_id, assDir_id, DATA, callBack) {
    if (file_id.length == 0) {
        return false;
    }
    var url = "/api/assistant_director/reject/" + assDir_id + "/" + file_id;
    ajaxRequest('PATCH', url, DATA, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}