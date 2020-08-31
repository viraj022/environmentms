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
function forTypeFiles_table(obj, callBack) {
    var tbl = "";
    if (obj.length == 0) {
        tbl = "<tr><td colspan='5'>No Data Found</td></tr>";
    } else {
        $.each(obj, function (index, row) {
            var myDate = new Date(row.created_at);
            var fixMydate = myDate.toISOString().split('T')[0];
            tbl += '<tr>';
            tbl += '<td>' + ++index + '</td>';
            tbl += '<td>' + row.industry_name + '</td>';
            tbl += '<td><a href="/industry_profile/id/' + row.id + '" target="_blank">' + row.file_no + '</a></td>';
            tbl += '<td class="">' + fixMydate + '</td>';
            if (row.is_working != 1) {
                tbl += '<td><button type="button" value="' + row.id + '" data-toggle="modal" data-target="#modal-xl" class="btn btn-success setInspeBtn">Set Inspection</button></td>';
            }
            tbl += '</tr>';
        });
    }
    $('.setCurrentEnvProf').html($('#getAsDirect option:selected').html() + ' - ' + $('#getEnvOfficer option:selected').html() + ' - ' + $('#getFileType option:selected').html());
    $('#tblAllFiles tbody').html(tbl);
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}