function getAllOldFilesApi(count, callBack) {
    var table = $('#tblOldFiles').DataTable();
    table.clear().draw();

//    ajaxRequest('GET', "/api/files/old/" + count, null, function (dataSet) {
//        var tbl = "";
//        if (dataSet.length == 0) {
//            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
//        } else {
//            $.each(dataSet, function (index, row) {
//                tbl += '<tr>';
//                tbl += '<td>' + ++index + '</td>';
//                tbl += (row.industry_registration_no == null) ? '<td>-</td>' : '<td>' + row.industry_registration_no + '</td>';
//                tbl += '<td>' + row.file_no + '</td>';
//                tbl += '<td>' + row.first_name + row.last_name + '</td>';
//                (row.epls.length == 0) ? tbl += '<td>-</td>' : tbl += '<td><i class="fa fa-check"></i></td>';
//                (row.old_files.length == 0) ? tbl += '<td>-</td>' : tbl += '<td><i class="fa fa-check"></i></td>';
//                (row.environment_officer_id == null) ? tbl += '<td>-</td>' : tbl += '<td><i class="fa fa-check"></i></td>';
//                tbl += '<td> <div  class="btn-group">  <a href="/industry_profile/id/' + row.id + '" type="button" class="btn btn-xs btn-dark">View Profile</a>&nbsp<a href="/register_old_data/id/' + row.id + '" type="button" class="btn btn-xs btn-success">Add Data</a></div></td>';
//                tbl += '</tr>';
//            });
//        }
//        $('#tblOldFiles tbody').html(tbl);
//        $.fn.DataTable.ext.pager.numbers_length = 9;
//        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//            callBack(dataSet);
//        }
//    });

    old_file_list = $('#tblOldFiles').DataTable({
        initComplete: function() { $('.oldFilesCount').text('Records: ' + this.api().data().length) },
        "destroy": true,
        "processing": true,
        "colReorder": true,
        "serverSide": false,
        "pageLength": 10,
        language: {
            searchPlaceholder: "Search..."
        },
        ajax: {
            "url": "/api/files/old/" + count,
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
                "data": "industry_registration_no",
                "defaultContent": "-"
            },
            {
                "data": "file_no",
                "defaultContent": "-"
            },
            {
                "data": "",
                render: function (data, type, row) {
                    return row.first_name + ' ' + row.last_name;
                },
                "defaultContent": "-"
            },
            {
                "data": "",
                render: function (data, type, row) {
                    if(row.epls.length != 0){
                        return "<td><i class='fa fa-check'></i></td>";
                    }
                    if(row.epls.length == 0){
                        return "<td>-</td>";
                    }
                },
                "defaultContent": "-"
            },
            {
                "data": "",
                render: function (data, type, row) {
                    if(row.old_files.length != 0){
                        return "<td><i class='fa fa-check'></i></td>";
                    }
                    if(row.old_files.length == 0){
                        return "<td>-</td>";
                    }
                },
                "defaultContent": "-"
            },
            {
                "data": "",
                render: function (data, type, row) {
                    if(row.environment_officer_id != null){
                        return "<td><i class='fa fa-check'></i></td>";
                    }
                    if(row.environment_officer_id == null){
                        return "<td>-</td>";
                    }
                },
                "defaultContent": "-"
            },
            {
                "data": "",
                render: function (data, type, row) {
                    return "<div  class='btn-group'>  <a href='/industry_profile/id/" + row.id + "' type='button' class='btn btn-xs btn-dark'>View Profile</a>&nbsp<a href='/register_old_data/id/" + row.id + "' type=\"button\" class=\"btn btn-xs btn-success\">Add Data</a></div>";
                }
            },
        ],
        "order": [
            [1, "asc"]
        ],
    }
    );

    $(function () {
        var t = $("#tblOldFiles").DataTable();
        t.on('order.dt search.dt', function () {
            t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    //data table error handling
    $.fn.dataTable.ext.errMode = 'none';
    $('#tblOldFiles').on('error.dt', function (e, settings, techNote, message) {
        console.log('DataTables error: ', message);
    });
}