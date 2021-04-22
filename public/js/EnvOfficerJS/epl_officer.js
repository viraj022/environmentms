function loadEnvOfficers_combo( callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/epl/envirnment_officers",
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
                    combo += "<option value='" + value.env_id + "'>" + value.first_name + ' ' + value.last_name + "</option>";
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
    $('#assigned_epl_table tbody').html('<tr><td colspan="3">No Data Found</td></tr>');
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
            if (result.length == 0 || result == undefined) {
                tbl = "<tr><td> No Data Found</td></tr>";
            } else {
                $.each(result, function (index, value) {
                    tbl += "<tr>";
                    tbl += "<td>" + ++index + "</td>";
                    tbl += "<td>" + value.code + "</td>";
                    tbl += "<td><a class='btn btn-dark' href='epl_profile/client/" + value.client_id + "/profile/" + value.id + "'  target='_blank'>View</a></td>";
                    tbl += "</tr>";
                });
            }
            $('#assigned_epl_table tbody').html(tbl);
            $("#assigned_epl_table").DataTable();
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}