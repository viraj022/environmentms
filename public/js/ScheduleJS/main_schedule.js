//Load AssisDirector Combo
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
//Load Env Officer Combo
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

//Load Table After Clicking Date
function inspectionsByDateAPI(schedule_date, id, callBack) {
    ajaxRequest('GET', "/api/inspections/file/date/" + schedule_date + "/id/" + id, null, function (dataSet) {
        var tbl = "";
        if (dataSet.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(dataSet, function (index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td>' + row.industry_registration_no + '</td>';
                tbl += '<td><a href="/industry_profile/id/' + row.id + '" type="button" class="btn btn-sm btn-dark">View Profile</a>&nbsp<a href="/register_old_data/id/' + row.id + '" type="button" class="btn btn-sm btn-success">Add Data</a></td>';
                tbl += '</tr>';
            });
        }
        $('#tblSchedules tbody').html(tbl);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
