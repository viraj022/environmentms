function getDirectorPendingList(callBack) {
    var url = "/api/files/pending/director";
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function DirectorFinalApproval(file_id, data, callBack) {
    if (!data) {
        return false;
    }
    var url = "/api/director_final_approve/file_id/" + file_id;
    ajaxRequest('POST', url, data, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function loadDirectorPendingListTable() {
    getDirectorPendingList(function (result) {
        var dataObj = { 0: 'pending', 1: 'AD File Approval Pending', 2: 'Certificate Preparation', 3: 'AD Certificate Pending Approval', 4: 'D Certificate Approval Peniding', 5: 'Complete', 6: 'Issued', '-1': 'Rejected', '-2': 'Hold' };
        var cer_type_status = { 0: 'pending', 1: 'New EPL', 2: 'EPL Renew', 3: 'Site Clearance', 4: 'Extend Site Clearance' };


        var tbl = "";
        if (result.length == 0) {
            tbl = "<tr><td colspan='8'>No Data Found</td></tr>";
        } else {
            $.each(result, function (index, row) {
                var myDate = new Date(row.created_at);
                var fixMydate = myDate.toISOString().split('T')[0];
                var codes = [];
                if (row.epls.length != 0) {
                    codes.push(row.epls[0].code);
                }
                if (row.site_clearence_sessions.length != 0) {
                    codes.push(row.site_clearence_sessions[0].code);
                }

                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td>' + row.industry_name + '</td>';
                tbl += '<td>' + row.first_name + ' ' + row.last_name + '</td>';
                tbl += '<td>';
                tbl += codes.join('<br>');
                tbl += '</td>';
                tbl += '<td><a href="/industry_profile/id/' + row.id + '" target="_blank">' + row.file_no + '</a></td>';
                tbl += '<td class="">' + cer_type_status[row.cer_type_status] + '(' + fixMydate + ')</td>';
                tbl += '<td>' + dataObj[row.file_status] + '</td>';
                if (row.file_status != 0) {
                    tbl += '<td><button value="' + escape(JSON.stringify(row)) + '" class="btn btn-success actionDetails">Action</button></td>';
                } else {
                    tbl += '<td>N/A</td>';
                }
                tbl += '</tr>';
            });
        }
        var t = $('#tblPendingAdList').DataTable({
            stateSave: true
        });
        t.clear().destroy();
        $('#tblPendingAdList tbody').html(tbl);
        $('#tblPendingAdList').DataTable();
    });
}

function loadDirectorApprovedListTable(callBack) {
    let url = "/api/files/approved/director";
    ajaxRequest('GET', url, null, function (result) {
        var dataObj = { 0: 'pending', 1: 'AD File Approval Pending', 2: 'Certificate Preparation', 3: 'AD Certificate Pending Approval', 4: 'D Certificate Approval Peniding', 5: 'Director Approved', 6: 'Issued', '-1': 'Rejected', '-2': 'Hold' };
        var tbl = "";
        if (result.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $('#tblApprovedAdList').DataTable().destroy();
            $.each(result, function (index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td>' + row.industry_name + '</td>';
                if (row.epls.length != 0) {
                    tbl += '<td>' + row.epls[0].code + '</td>';
                } else {
                    tbl += '<td>-</td>';
                }
                tbl += '<td><a href="/industry_profile/id/' + row.id + '" target="_blank">' + row.file_no + '</a></td>';
                tbl += '<td>' + dataObj[row.file_status] + '</td>';
                console.log(row.file_status);
                if (row.file_status != 0) {
                    tbl += '<td><a href="/certificate_perforation/id/' + row.id + '" class="btn btn-sm btn-success">Upload Certificate</a></td>';
                } else {
                    tbl += '<td>N/A</td>';
                }
                tbl += '</tr>';
            });
        }
        $('#tblApprovedAdList tbody').html(tbl);
        $('#tblApprovedAdList').DataTable({
            stateSave: true
        });
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function preCertificateApi(file_id, DATA, met, callBack) {
    if (met === 1) {
        met = 'approve_certificate';
    } else if (met === 2) {
        met = 'reject';
    } else if (met === 3) {
        met = 'hold';
    } else if (met === 4) {
        met = 'un_hold';
    } else {
        return false;
    }
    if (file_id.length == 0) {
        return false;
    }
    var url = "/api/director/" + met + "/" + file_id;
    ajaxRequest('PATCH', url, DATA, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function loadCertificatePathsApi(file_id, callBack) {
    if (isNaN(file_id)) {
        return false;
    }
    ajaxRequest('GET', "/api/files/certificate/officer/id/" + file_id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
