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
//Set Inspection Needed Files
function setInspectionNeededApi(id, callBack) {
    ajaxRequest('GET', "/api/files/need_inspection/officer/id/" + id, null, function (dataSet) {
        var ui = "";
        if (dataSet.length == 0) {
            ui = "<div class='external-event bg-danger'>No Data Found</div>";
        } else {
            $.each(dataSet, function (index, row) {
                ui += '<div class="external-event bg-info" data-id="' + row.id + '">' + row.industry_registration_no + '</div>';
            });
        }
        $('#external-events').html(ui);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

//Save When Drag Into Calender
function PersonalInspectionCreateApi(id, data, callBack) {
    if (!data) {
        return false;
    }
    let url = "/api/automatic_inspection/create/id/" + id;
    ajaxRequest("POST", url, data, function (parameters) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(parameters);
        }
    });
}
//Load Calender
function loadCalenderApi(id, callBack) {
    let eventList = [];
    let url = "/api/files/need_inspection/pending/officer/id/" + id;
    ajaxRequest("GET", url, null, function (parameters) {
        $.each(parameters, function (index, row) {
            eventList.push({
                title: row.file_no,
//                start: new Date(y, m, 1),
                start: row.assign_date,
                backgroundColor: '#f56954', //red
                borderColor: '#f56954', //red
                allDay: false
            });
        });
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(parameters);
        }
    });
}
