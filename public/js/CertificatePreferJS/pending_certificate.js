function getaProfilebyId(callBack) {
    let status = $('#cert_filter').val();
    var url = "/api/files/certificate_drafting/status/" + status;
    var certificate_status = { 0: 'pending', 1: 'Drafting', 2: 'Drafted', 3: 'AD Pending', 4: 'Director Pending', 5: 'Director Approved', 6: 'Issued', '-1': 'Hold' };
    var certificate_type = { 0: 'pending', 1: 'New EPL', 2: 'Renew EPL', 3: 'New Site Clearance', 4: 'Site Clearance Extended' };

    pending_list = $('#tblPendingCertificate').DataTable({
        "destroy": true,
        "processing": true,
        "colReorder": true,
        "serverSide": false,
        "stateSave": true,
        "pageLength": 10,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        language: {
            searchPlaceholder: "Search..."
        },
        "ajax": {
            "url": url,
            "type": "GET",
            "dataSrc": "",
            headers: {
                "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
                "Accept": "application/json"
            },
        },
        "columns": [{
                "data": "",
                "defaultContent": "-"
            },
            {
                "data": "",
                "render": function(data, type, row, meta) {
                    return row.name_title + ' ' + row.first_name + ' ' + row.last_name;
                },
                "defaultContent": "-"
            },
            {
                "data": "industry_name",
                "defaultContent": "-"
            },
            {
                "data": "",
                "defaultContent": "-"
            },
            {
                "data": "",
                "defaultContent": "-"
            },
            {
                "data": "",
                "defaultContent": "-"
            },
            {
                "data": "certificate_comment",
                "defaultContent": "--"
            },
            {
                "data": "",
                "defaultContent": "-"

            },
            {
                "data": "created_at",
                "defaultContent": "-"

            },
            {
                "data": "",
                "defaultContent": "-"
            },
        ],
        "columnDefs": [{
                "targets": 3,
                "data": "0",
                "render": function(data, type, full, meta) {
                    let td = '-';
                    if (full.epls.length != 0) {
                        td = full.epls[0].code;
                    }
                    return td;
                }
            },
            {
                "targets": 4,
                "data": "0",
                "render": function(data, type, row) {
                    if (row.site_clearence_sessions != '') {
                        return row.site_clearence_sessions[0].code;
                    } else {
                        return null;
                    }
                },
            },
            {
                "targets": 5,
                "data": "0",
                "render": function(data, type, full, meta) {
                    return '<a href="/industry_profile/id/' + full['id'] + '" target="_blank">' + full['file_no'] + '</a>(' + certificate_type[full['cer_type_status']] + ')';
                }
            },
            {
                "targets": 7,
                "data": "0",
                "render": function(data, type, full, meta) {
                    return certificate_status[full['cer_status']];
                }
            },
            {
                "targets": 9,
                "data": "0",
                "render": function(data, type, full, meta) {
                    return '<a href="/certificate_perforation/id/' + full['id'] + '" class="btn btn-success">Certificate<a>';
                }
            }
        ],
        createdRow: function(row, data, dataIndex) {
            if (data['cer_status'] == "2") {
                $(row).addClass('status-two');
            }
        },
        "order": [
            [0, "desc"]
        ],
    });

    $(function() {
        var t = $("#tblPendingCertificate").DataTable();
        t.on('order.dt search.dt', function() {
            t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });

    //data table error handling
    $.fn.dataTable.ext.errMode = 'none';
    $('#tblPendingCertificate').on('error.dt', function(e, settings, techNote, message) {
        console.log('DataTables error: ', message);
    });


    // ajaxRequest('GET', url, null, function (result) {
    //     var tbl = '';
    //     if (result.length == 0) {
    //         tbl += '<td colspan="5">Data Not Found</td>';
    //     } else {
    //         $.each(result, function (index, row) {
    //             let tr_style = '';
    //             if (row.cer_status == 2) {
    //                 tr_style = 'background-color: #f1f1f1;';
    //             }
    //             tbl += '<tr style="' + tr_style + '">';
    //             tbl += '<td>' + ++index + '</td>';
    //             tbl += '<td>' + row.industry_name + '</td>';
    //             tbl += '<td>' + row.code_epl + '</td>';
    //             tbl += '<td><a href="/industry_profile/id/' + row.id + '" target="_blank">' + row.file_no + '</a>(' + certificate_type[row.cer_type_status] + ')</td>';
    //             tbl += '<td title="' + row.certificate_comment + '">' + row.certificate_comment + '</td>';
    //             tbl += '<td>' + certificate_status[row.cer_status] + '</td>';
    //             tbl += '<td><a href="/certificate_perforation/id/' + row.id + '" class="btn btn-success">Certificate<a></td>';
    //             tbl += '</tr>';
    //         });
    //     }

    //     $('#tblPendingCertificate').DataTable({
    //         columnDefs: [{
    //             targets: 3,
    //             render: function (data, type, row) {
    //                 return data.length > 10 ?
    //                     data.substr(0, 10) + '…' :
    //                     data;
    //             }
    //         }]
    //     });
    //     $('#tblPendingCertificate tbody').html(tbl);



    // });
    if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
        callBack(result);
    }
}