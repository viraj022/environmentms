//Load AssisDirector Combo
function loadAssDirCombo(callBack) {
    var url = '/api/assistant_directors/level';
    let cbo = '';
    ajaxRequest('GET', url, null, function(dataSet) {
        if (dataSet.length == 0) {
            cbo = "<option value=''>No Data Found</option>";
        } else {
            $.each(dataSet, function(index, row) {
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
    ajaxRequest('GET', url, null, function(dataSet) {
        if (dataSet.length == 0) {
            cbo = "<option value='4A616B65'>No Data Found</option>";
        } else {
            $.each(dataSet, function(index, row) {
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
    ajaxRequest('GET', "/api/inspections/file/date/" + schedule_date + "/id/" + id, null, function(dataSet) {
        var tbl = "";
        if (dataSet.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(dataSet, function(index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td><a href="/industry_profile/id/' + row.client_id + '" target="_blank">' + row.client.file_no + '</a></td>';
                tbl += '<td><button href="#" value="' + row.id + '" class="btn btn-sm btn-danger removeInspecBtn"><i class="fas fa-times"></i> Remove</button></td>';
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
    ajaxRequest('GET', "/api/files/need_inspection/officer/id/" + id, null, function(dataSet) {
        var ui = "";
        if (dataSet.length == 0) {
            ui = "<p class='text-danger'>No Data Found</p>";
        } else {
            $.each(dataSet, function(index, row) {
                if (row.cer_type_status == 0) {

                    ui += '<div class="tooltip-hoover external-event bg-danger" data-toggle="tooltip" data-placement="right" title="' + row.industry_name + '" data-id="' + row.id + '">' + row.file_no + '</div>';
                } else {
                    ui += '<div class="tooltip-hoover external-event bg-info" data-bs-toggle="tooltip" data-placement="right" title="' + row.industry_name + '" data-id="' + row.id + '">' + row.file_no + '</div>';
                }
            });
        }
        $('.external-event').tooltip('dispose');
        $('#external-events').html(ui);
        $('.external-event').tooltip();
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

//Save When Drag Into Calender
function personalInspectionCreateApi(id, data, callBack) {
    if (!data) {
        return false;
    }
    let url = "/api/automatic_inspection/create/id/" + id;
    ajaxRequest("POST", url, data, function(parameters) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(parameters);
        }
    });
}
//Remove Inspections
function InspectionRemoveApi(id, callBack) {
    if (!id) {
        return false;
    }
    let url = "/api/inspection/delete/id/" + id;
    ajaxRequest("DELETE", url, null, function(parameters) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(parameters);
        }
    });
}
//Load Calender
function loadCalenderApi(id, callBack) {
    let eventList = [];
    if (!id) {
        return false;
    }
    let url = "/api/files/need_inspection/pending/officer/id/" + id;
    ajaxRequest("GET", url, null, function(parameters) {
        $.each(parameters, function(index, row) {

            eventList.push({
                title: row.file_no,
                //                start: new Date(y, m, 1),
                start: row.inspection_sessions[0].schedule_date_only,
                backgroundColor: '#403d3d', //dark
                borderColor: '#000000', //black
                textColor: '#ffffff', //white
                allDay: false
            });
        });
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(eventList);
        }
    });
}

//Load Table After Clicking Date
function displayClientDataFromEvent(u_id, callBack) {
    ajaxRequest('GET', "/api/client/id/" + u_id, null, function(dataSet) {
        var tbl = "";
        if (dataSet.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            console.log(dataSet);
            tbl += '<tr>';
            tbl += '<th>Industry Name:</th>';
            tbl += '<td>' + dataSet.industry_name + '</td>';
            tbl += '</tr>';
            tbl += ' <tr>';
            tbl += ' <th>Owner:</th>';
            tbl += ' <td>' + dataSet.first_name + ' ' + dataSet.last_name + '</td>';
            tbl += '</tr>';
            tbl += '    <tr>';
            tbl += ' <th>Industry Category:</th>';
            tbl += ' <td>' + dataSet.industry_category.name + '</td>';
            tbl += '</tr>';
            tbl += '<tr>';
            tbl += ' <th>Site Address:</th>';
            tbl += ' <td>' + dataSet.industry_address + '</td>';
            tbl += '</tr>';
            tbl += '<tr>';
            tbl += ' <th>Pradesheeyasaba:</th>';
            tbl += ' <td>' + dataSet.pradesheeyasaba.name + '</td>';
            tbl += '</tr>';
        }
        $('#tblUserData').html(tbl);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}