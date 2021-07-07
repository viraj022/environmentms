var cer_status = {0: 'pending', 1: 'Drafting', 2: 'Drafted', 3: 'AD Approval Pending', 4: 'Director Approval pending', 5: 'Director Approved', 6: 'Certificate Issued', '-1': 'Certificate Director Holded'};
var cer_type_status = {0: 'pending', 1: 'New EPL', 2: 'EPL Renew', 3: 'Site Clearance', 4: 'Extend Site Clearance'};
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
        return false;
    }
    ajaxRequest('GET', "/api/files/all/officer/id/" + env_id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
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
function loadWorkingFilesApi(env_id, callBack) {
    if (isNaN(env_id)) {
        return false;
    }
    ajaxRequest('GET', "/api/files/working/officer/id/" + env_id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
function loadNewFilesApi(env_id, callBack) {
    if (isNaN(env_id)) {
        return false;
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
        return false;
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
        if (resp === null) {
            tbl = "<tr><td colspan='5'>No Data Found</td></tr>";
        } else {
            $("#tblAllFiles").DataTable().destroy();
            $.each(resp, function (index, row) {
                let status_Lable = '';
                if (row.file_status == 2) {
                    status_Lable = '(' + cer_status[row.cer_status] + ')';
                } else if (row.file_status == 0) {
                    if (row.need_inspection == null) {
                        status_Lable = '(Set Inspction Status)';
                    } else if (row.need_inspection == 'Pending') {
                        status_Lable = '(Inpection Result Pending)';
                    } else {
                        status_Lable = '(' + row.need_inspection + ')';
                    }
                    
                }
                
                var myDate = new Date(row.created_at);
                var fixMydate = myDate.toISOString().split('T')[0];
                if ((row.file_status == file_status) || (file_status == 'all')) {
                    let tr_style = '';
                    if ((row.file_status == 0) && (row.need_inspection == null)) {
                        tr_style = '    background-color: #dcf3e0;';
                    } else if (row.file_status == 5) {
                        tr_style = '    background-color: #bac6e88a;';
                    } else if (row.file_status == -1) {
                        tr_style = '    background-color: #f3dcdc75;';
                    }
                    if (row.is_old != 0) {
                        tbl += '<tr style="' + tr_style + '">';
                        tbl += '<td>' + ++index + '</td>';
                        tbl += '<td>' + row.industry_name + '</td>';
                        tbl += '<td><a href="/industry_profile/id/' + row.id + '" class="btn btn-dark" target="_blank">' + row.file_no + '</a></td>';
                        tbl += '<td class="">' + cer_type_status[row.cer_type_status] + '(' + fixMydate + ')</td>';
                        tbl += '<td>' + file_status_list[row.file_status] + status_Lable + '</td>';
//                    if ((row.file_status == 0) && (row.need_inspection == null)) {
//                        tbl += '<td><button type="button" value="' + row.id + '" data-toggle="modal" data-target="#modal-xl" class="btn btn-success setInspeBtn">Set Inspection</button></td>';
//                    } else {
//                        tbl += '<td>' + row.need_inspection + '</td>';
//                    }
                        if (row.file_status != 5) {
                            tbl += '<td class="text-center"><button type="button" value="' + escape(JSON.stringify(row)) + '" class="btn btn-info detailsData">Details</button></td>';
                        } else {
                            tbl += '<td class="text-center"><i class="fa fa-check fa-lg text-success"></i></td>';
                        }
                        tbl += '</tr>';
                    }
                }
            });
        }
        $('#tblAllFiles tbody').html(tbl);
        $("#tblAllFiles").DataTable();
    });
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}


//Approval API Btn
function approvalApi(file_id, env_offi, DATA, callBack) {
    if (isNaN(file_id)) {
        return false;
    }
    if (DATA.minutes.length == null || DATA.minutes.length == 0) {
        alert('Please Enter Minute Text !');
        return false;
    }
    ajaxRequest('PATCH', "/api/environment_officer/approve/" + env_offi + "/" + file_id, DATA, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

//Sumbit For AD Certificate Approval Btn
function adCertificateApproval(file_id, env_offi, DATA, callBack) {
    if (isNaN(file_id)) {
        return false;
    }
    ajaxRequest('PATCH', "/api/environment_officer/approve_certificate/" + env_offi + "/" + file_id, DATA, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
//Rejection For AD Certificate Btn
function rejectCertificateApproval(file_id, env_offi, DATA, callBack) {
    if (isNaN(file_id)) {
        return false;
    }
    ajaxRequest('PATCH', "/api/environment_officer/reject_certificate/" + env_offi + "/" + file_id, DATA, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
