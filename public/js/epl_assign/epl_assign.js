
function loadAssistantDirectorCombo(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/assistant_directors/level",
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            var combo = "";
            $.each(result, function (index, value) {
                combo += "<option value='" + value.id + "'>" + value.first_name + ' ' + value.last_name + "</option>";
            });
            $('.combo_AssistantDirector').html(combo);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });

}
function loadEnvOfficers_combo(ass_dir_id, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/environment_officers/assistant_director/id/" + ass_dir_id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            var combo = "";
            if (result.length == 0 || result == undefined) {
                combo = "<option value=''>-No data Found-</option>";
            } else {
                $.each(result, function (index, value) {
                    combo += "<option value='" + value.id + "'>" + value.first_name + ' ' + value.last_name + "</option>";
                });
            }
            $('.combo_envOfficer').html(combo);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });

}
function assigned_EPL_table(officer_id, callBack) {
    $('#assigned_epl_table tbody').html('<td colspan="3">No Data Found</td></tr>');
    if (isNaN(officer_id)) {
        return false;
    }
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/epl/env_officer/" + officer_id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            var tbl = "";
            $.each(result, function (index, value) {
                tbl += "<tr>";
                tbl += "<td>" + ++index + "</td>";
                tbl += "<td>" + value.industry_name +"&nbsp&nbsp<a href='/industry_profile/id/" + value.id + "'  target='_blank'>("+ value.file_no + ")</a></td>";
                tbl += '<td><button type="button" class="btn btn-danger removePendingEpl" value="' + value.id + '">Remove</button></td>';
                tbl += "</tr>";
            });
            if (!(result.length == 0 || result == undefined)) {
                $('#assigned_epl_table tbody').html(tbl);
            }
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}
function pending_EPL_table(director_id, callBack) {
    $('#pending_epl_table tbody').html('<td colspan="3">No Data Found</td></tr>');
    if (isNaN(director_id)) {
        return false;
    }
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/epl/assistance_director/" + director_id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            var tbl = "";
            $.each(result, function (index, value) {
                tbl += "<tr>";
                tbl += "<td>" + ++index + "</td>";
                tbl += "<td>" + value.industry_name +"&nbsp&nbsp<a href='/industry_profile/id/" + value.id + "'  target='_blank'>("+ value.file_no + ")</a></td>";
                tbl += '<td><button type="button" class="btn btn-success selPendingEpl" value="' + value.id + '">Add</button></td>';
                tbl += "</tr>";
            });
            if (!(result.length == 0 || result == undefined)) {
                $('#pending_epl_table tbody').html(tbl);
            }
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}
function assign_epl_to_officer(data, callBack) {
    if (isNaN(data.environment_officer_id)) {
        Toast.fire({
            type: 'error',
            title: 'Enviremontal MS</br>Invalid Envoirenmtn Officer !'
        });
        return false;
    }
    if (isNaN(data.epl_id)) {
        alert('Invalid EPL !');
        return false;
    }
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/epl/assign/id/" + data.epl_id,
        data: data,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}
function remove_epl_from_officer(epl_id, callBack) {
    if (isNaN(epl_id)) {
        return false;
    }
    $.ajax({
        type: "DELETE",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/epl/remove/id/" + epl_id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}