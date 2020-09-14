var cer_status = {0: 'pending', 1: 'Drafting', 2: 'Drafted', 3: 'AD Approval Pending', 4: 'Director Approval pending', 5: 'Director Approved', 6: 'Certificate Issued', '-1': 'Certificate Director Holded'};
function loadAssDirCombo(callBack) {
    var url = '/api/assistant_directors/level';
    let cbo = '';
    ajaxRequest('GET', url, null, function (dataSet) {
        if (dataSet.length == 0) {
            cbo = "<option value=''>No Data Found</option>";
        } else {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '">' + row.user.first_name + " " + row.user.last_name + '</option>';
            });
        }
        $('#getAsDirect').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function loadEnvOfficerCombo(uid, callBack) {
    var url = '/api/environment_officer/level/assistant_director_id/' + uid;
    let cbo = '';
    ajaxRequest('GET', url, null, function (dataSet) {
        if (dataSet.length == 0) {
            cbo = "<option value=''>No Data Found</option>";
        } else {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '">' + row.user.first_name + " " + row.user.last_name + '</option>';
            });
        }
        $('#getEnvOfficer').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
//Get File Data Open---
function loadAllFilesApi(env_id, callBack) {
    if (isNaN(env_id)) {
        env_id = 0;
    }
    ajaxRequest('GET', "/api/files/all/officer/id/" + env_id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
function loadWorkingFilesApi(env_id, callBack) {
    if (isNaN(env_id)) {
        env_id = 0;
    }
    ajaxRequest('GET', "/api/files/working/officer/id/" + env_id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
function loadNewFilesApi(env_id, callBack) {
    if (isNaN(env_id)) {
        env_id = 0;
    }
    ajaxRequest('GET', "/api/files/new/officer/id/" + env_id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
//Get File Data End-----

//Check Inspection Need Or Not
function checkInspectionStatus(id, combo_val, callBack) {
    if (isNaN(id)) {
        id = 0;
    }
    ajaxRequest('PATCH', "/api/inspection/" + combo_val + "/file/" + id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}


//----- Load Tables----//
function forTypeFiles_table(env_id, file_status, file_status_list, callBack) {
    var tbl = "";
    loadAllFilesApi(env_id, function (resp) {
        if (resp.length == 0) {
            tbl = "<tr><td colspan='5'>No Data Found</td></tr>";
        } else {
            $.each(resp, function (index, row) {
                let status_Lable = '';
                if (row.file_status == 2) {
                    status_Lable = '(' + cer_status[row.cer_status] + ')';
                } else if (row.file_status == 0) {
                    if (row.need_inspection == null) {
                        status_Lable = '(Set Inspction Status)';
                    } else {
                        status_Lable = '(' + row.need_inspection + ')';
                    }

                }

                var myDate = new Date(row.created_at);
                var fixMydate = myDate.toISOString().split('T')[0];
                if ((row.file_status == file_status) || (file_status == 'all')) {
                    tbl += '<tr>';
                    tbl += '<td>' + ++index + '</td>';
                    tbl += '<td>' + row.industry_name + '</td>';
                    tbl += '<td><a href="/industry_profile/id/' + row.id + '" class="btn btn-dark" target="_blank">' + row.file_no + '</a></td>';
                    tbl += '<td class="">' + fixMydate + '</td>';
                    tbl += '<td>' + file_status_list[row.file_status] + status_Lable + '</td>';
                    if ((row.file_status == 0) && (row.need_inspection == null)) {
                        tbl += '<td><button type="button" value="' + row.id + '" data-toggle="modal" data-target="#modal-xl" class="btn btn-success setInspeBtn">Set Inspection</button></td>';
                    } else {
                        tbl += '<td>' + row.need_inspection + '</td>';
                    }
                    tbl += '<td><button type="button" value="' + escape(JSON.stringify(row)) + '" class="btn btn-info detailsData">Details</button></td>';
                    tbl += '</tr>';
                }
            });
            $('#tblAllFiles tbody').html(tbl);
        }
    });
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}


//Approval API Btn
function approvalApi(file_id, env_offi, callBack) {
    if (isNaN(file_id)) {
        file_id = 0;
    }
    ajaxRequest('PATCH', "/api/environment_officer/approve/" + env_offi + "/" + file_id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

//Sumbit For AD Certificate Approval Btn
function adCertificateApproval(file_id, env_offi, callBack) {
    if (isNaN(file_id)) {
        file_id = 0;
    }
    ajaxRequest('PATCH', "/api/environment_officer/approve_certificate/" + env_offi + "/" + file_id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
//Rejection For AD Certificate Btn
function rejectCertificateApproval(file_id, env_offi, callBack) {
    if (isNaN(file_id)) {
        file_id = 0;
    }
    ajaxRequest('PATCH', "/api/environment_officer/reject_certificate/" + env_offi + "/" + file_id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}