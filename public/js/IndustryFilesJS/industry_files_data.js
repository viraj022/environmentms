function loadAssDirCombo(callBack) {
    var url = '/api/assistant_directors/level';
    let cbo = '';
    ajaxRequest('GET', url, null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.user_id + '">' + row.user.first_name + " " + row.user.last_name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
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
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.user_id + '">' + row.user.first_name + " " + row.user.last_name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
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


//----- Load Tables----//
function forTypeFiles_table(obj, callBack) {
    var tbl = "";
    if (obj.length == 0) {
        tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
    } else {
        $.each(obj, function (index, row) {
            var myDate = new Date(row.created_at);
            var fixMydate = myDate.toISOString().split('T')[0];
            tbl += '<tr>';
            tbl += '<td>' + ++index + '</td>';
            tbl += '<td>' + row.industry_name + '</td>';
            tbl += '<td class="">' + fixMydate + '</td>';
            tbl += '<td><a href="/industry_profile/id/' + row.id + '" type="button" class="btn btn-success">View Profile</a></td>';
            tbl += '</tr>';
        });
    }
    $('#tblAllFiles tbody').html(tbl);
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}