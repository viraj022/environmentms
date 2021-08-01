
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
                combo += "<option value='" + value.id + "'>" + value.user.first_name + ' ' + value.user.last_name + "</option>";
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
//    $('#assigned_epl_table tbody').html('<td colspan="3">No Data Found</td></tr>');
    if (isNaN(officer_id)) {
        return false;
    }
//    $('#assigned_epl_table').DataTable().destroy();
//    $.ajax({
//        type: "GET",
//        headers: {
//            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
//            "Accept": "application/json"
//        },
//        url: "api/epl/env_officer/" + officer_id,
//        data: null,
//        dataType: "json",
//        cache: false,
//        processDaate: false,
//        success: function (result) {
//            var tbl = "";
//            $.each(result, function (index, value) {
//                tbl += "<tr>";
//                tbl += "<td>" + ++index + "</td>";
//                tbl += "<td>" + value.industry_name + "&nbsp&nbsp<a href='/industry_profile/id/" + value.id + "'  target='_blank' data-toggle='tooltip' data-placement='top' title='" + TYPE + "'>(" + CODE + ")</a></td>";
//                tbl += '<td><button type="button" class="btn btn-danger removePendingEpl" value="' + value.id + '">Remove</button></td>';
//                tbl += "</tr>";
//            });
//            if (!(result.length == 0 || result == undefined)) {
//                $('#assigned_epl_table tbody').html(tbl);
//                $('#assigned_epl_table').DataTable();
//            }
//            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//                callBack(result);
//            }
//        }
//    });

    assigned_epl = $('#assigned_epl_table').DataTable({
        "destroy": true,
        "processing": true,
        "colReorder": true,
        "serverSide": false,
        "pageLength": 10,
        language: {
            searchPlaceholder: "Search..."
        },
        ajax: {
            "url": "api/epl/env_officer/" + officer_id,
            "type": "GET",
            "dataSrc": "",
            "headers": {
                "Accept": "application/json",
                "Content-Type": "text/json; charset=utf-8",
                "Authorization": "Bearer " + $('meta[name=api-token]').attr("content")
            },
        },
        "columns": [{
                "data": ""
            },
            {
                "data": "",
                render: function (data, type, row) {
                    let CODE = row.code_epl;
                    let TYPE = 'EPL';
                    if (CODE == 'N/A') {
                        CODE = row.code_site;
                        TYPE = 'Site Clearance';
                        if (CODE == 'N/A') {
                            CODE = row.file_no;
                            TYPE = 'File No';
                        }
                    }
                    return "<td>" + row.industry_name + "&nbsp&nbsp<a href='/industry_profile/id/" + row.id + "'  target='_blank' data-toggle='tooltip' data-placement='top' title='" + TYPE + "'>(" + CODE + ")</a></td>";
                },
                "defaultContent": "-"
            },
            {
                "data": "",
                render: function (data, type, row) {
                    return '<td><button type="button" class="btn btn-danger removePendingEpl" value="' + row.id + '">Remove</button></td>';
                },
                "defaultContent": "-"
            },
        ],
        "order": [
            [1, "asc"]
        ],
    }
    );

    $(function () {
        var t = $("#assigned_epl_table").DataTable();
        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    //data table error handling
    $.fn.dataTable.ext.errMode = 'none';
    $('#assigned_epl_table').on('error.dt', function (e, settings, techNote, message) {
        console.log('DataTables error: ', message);
    });
}
function pending_EPL_table(director_id, callBack) {
//    $('#pending_epl_table tbody').html('<td colspan="3">No Data Found</td></tr>');
    if (isNaN(director_id)) {
        return false;
    }
//    $('#pending_epl_table').DataTable().destroy();
//    $.ajax({
//        type: "GET",
//        headers: {
//            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
//            "Accept": "application/json"
//        },
//        url: "api/epl/assistance_director/" + director_id,
//        data: null,
//        dataType: "json",
//        cache: false,
//        processDaate: false,
//        success: function (result) {
//            var tbl = "";
//            $.each(result, function (index, value) {
//                let CODE = value.code_epl;
//                let TYPE = 'EPL';
//                if (CODE == 'N/A') {
//                    CODE = value.code_site;
//                    TYPE = 'Site Clearance';
//                    if (CODE == 'N/A') {
//                        CODE = value.file_no;
//                        TYPE = 'File No';
//                    }
//                }
//                tbl += "<tr>";
//                tbl += "<td>" + ++index + "</td>";
//                tbl += "<td>" + value.industry_name + "&nbsp&nbsp<a href='/industry_profile/id/" + value.id + "'  target='_blank' data-toggle='tooltip' data-placement='top' title='" + TYPE + "'>(" + CODE + ")</a></td>";
//                tbl += '<td><button type="button" class="btn btn-success selPendingEpl" value="' + value.id + '">Add</button></td>';
//                tbl += "</tr>";
//            });
//            if (!(result.length == 0 || result == undefined)) {
//                $('#pending_epl_table tbody').html(tbl);
//                $("#pending_epl_table").DataTable();
//            }
//            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//                callBack(result);
//            }
//        }
//    });

    pending_epl = $('#pending_epl_table').DataTable({
        "destroy": true,
        "processing": true,
        "colReorder": true,
        "serverSide": false,
        "pageLength": 10,
        language: {
            searchPlaceholder: "Search..."
        },
        ajax: {
            "url": "api/epl/assistance_director/" + director_id,
            "type": "GET",
            "dataSrc": "",
            "headers": {
                "Accept": "application/json",
                "Content-Type": "text/json; charset=utf-8",
                "Authorization": "Bearer " + $('meta[name=api-token]').attr("content")
            },
        },
        "columns": [{
                "data": ""
            },
            {
                "data": "",
                render: function (data, type, row) {
                let CODE = row.code_epl;
                let TYPE = 'EPL';
                if (CODE == 'N/A') {
                    CODE = row.code_site;
                    TYPE = 'Site Clearance';
                    if (CODE == 'N/A') {
                        CODE = row.file_no;
                        TYPE = 'File No';
                    }
                }
                    return "<td>" + row.industry_name + "&nbsp&nbsp<a href='/industry_profile/id/" + row.id + "'  target='_blank' data-toggle='tooltip' data-placement='top' title='" + TYPE + "'>(" + CODE + ")</a></td>";
                },
                "defaultContent": "-"
            },
            {
                "data": "",
                render: function (data, type, row) {
                    return '<td><button type="button" class="btn btn-success selPendingEpl" value="' + row.id + '">Add</button></td>';
                },
                "defaultContent": "-"
            },
        ],
        "order": [
            [1, "asc"]
        ],
    }
    );

    $(function () {
        var t = $('#pending_epl_table').DataTable();
        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    //data table error handling
    $.fn.dataTable.ext.errMode = 'none';
   $('#pending_epl_table').on('error.dt', function (e, settings, techNote, message) {
        console.log('DataTables error: ', message);
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