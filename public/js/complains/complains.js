function gen_complain_code() {
    var code = Math.random().toString(36).substring(2, 5) + Math.random().toString(36).substring(2, 5);
    var d = new Date();
    var date = d.getFullYear();
    var prs = $("#ps option:selected").data('ps_code');
    $('#complainer_code').val(date + '/' + prs + '/' + code);
}

function load_complains() {
    let index = 1;
    complain_list = $('#complain_tbl').DataTable({
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
            url: "/api/get_complain_data",
            type: "GET",
            headers: {
                "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept": "application/json",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            dataSrc: "",
        },
        "columns": [{
                "data": ""
            },
            {
                "data": "complainer_code",
                "defaultContent": "-"
            },
            {
                "data": "complainer_name",
                "defaultContent": "-"
            },
            {
                "data": "comp_contact_no",
                "defaultContent": "-"
            },
            {
                "data": "id"
            }
        ],
        "columnDefs": [{
                "targets": 0,
                "data": "0",
                "render": function() {
                    return index++;
                }
            },
            {
                "targets": 4,
                "data": "0",
                "render": function(data, type, full, meta) {
                    if (full['recieve_type'] == 1) {
                        return "<span class='bg-success p-1 rounded'>Call</span>";
                    } else if (full['recieve_type'] == 2) {
                        return "<span class='bg-success p-1 rounded'>Written</span>";
                    } else {
                        return "<span class='bg-success p-1 rounded'>Verbal</span>";
                    }
                }
            },
            {
                "targets": 5,
                "data": "0",
                "render": function(data, type, full, meta) {
                    if (full['status'] == 1) {
                        return "<span class='bg-success p-1 rounded'>Completed</span>";
                    } else if (full['status'] == -1) {
                        return "<span class='bg-danger p-1 rounded'>Rejected</span>";
                    } else {
                        return "<span class='bg-warning p-1 rounded'>Pending</span>";
                    }
                }
            },
            {
                "targets": 6,
                "data": "0",
                "render": function(data, type, full, meta) {
                    return getJtableBtnHtml(full);
                }
            }
        ],
        "order": [
            [0, "asc"]
        ],
    });

    // $(function() {
    //     var t = $("#complain_tbl").DataTable({

    //     });
    //     t.on('order.dt search.dt', function() {
    //         t.column(0, {
    //             search: 'applied',
    //             order: 'applied'
    //         }).nodes().each(function(cell, i) {
    //             cell.innerHTML = i + 1;
    //         });
    //     }).draw();
    // });

    //data table error handling
    $.fn.dataTable.ext.errMode = 'none';
    $('#complain_tbl').on('error.dt', function(e, settings, techNote, message) {
        console.log('DataTables error: ', message);
    });
}



function getJtableBtnHtml(full) {
    var html = '';
    html += '<div class="btn-group" role="group"  aria-label="" > ';
    html += ' <button type="button" class="btn btn-sm btn-primary btn-edit mr-1" value="' + full["id"] +
        '" data-toggle="tooltip" title="Edit"><i class="fas fa-edit" aria-hidden="true"></i></button>';
    html += ' <a href="/complain_profile/id/' + full['id'] +
        '" class="btn btn-sm btn-success mr-1" role="button" data-toggle="tooltip" title="profile"><i class="fa fa-info-circle" style="width: 10px" aria-hidden="true" alt="profile"></i></a>';
    html += ' <button type="button" class="btn btn-sm btn-danger btn-del" value="' + full["id"] +
        '"data-toggle="tooltip" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
    html += '</div>';
    return html;
}

function save_complain() {
    let url = '/api/save_complain';
    let data = {
        complainer_code: $('#complainer_code').val(),
        complainer_name_ipt: $('#complainer_name_ipt').val(),
        complainer_address_ipt: $('#complainer_address_ipt').val(),
        contact_complainer_ipt: $('#contact_complainer_ipt').val(),
        complain_desc_ipt: $('#complain_desc_ipt').val(),
        recieve_type_ipt: $('#recieve_type_ipt').val(),
        pradeshiya_saba_id: $('#ps').val(),
    };
    let arr = [];
    let index = 0;
    $.each($('#complain_attach')[0].files, function(key, val) {
        arr[index++] = val;
    });
    ulploadFileWithData(url, data, function(resp) {
        $('#save').attr('disabled', false);

        if (resp.status == 1) {
            $('#complain_frm')[0].reset();
            $('#complain_tbl').DataTable().ajax.reload();
            gen_complain_code();
            $('img').addClass('d-none');
            swal.fire('success', 'Successfully save the complains', 'success');
        } else {
            swal.fire('failed', 'Complain saving is unsuccessful', 'warning');
        }
    }, false, arr);
}

function update_complain() {
    let id = $('#hidden_id').val();
    let url = '/api/update_complain/id/' + id;
    let data = {
        complainer_code: $('#complainer_code').val(),
        complainer_name_ipt: $('#complainer_name_ipt').val(),
        complainer_address_ipt: $('#complainer_address_ipt').val(),
        contact_complainer_ipt: $('#contact_complainer_ipt').val(),
        complain_desc_ipt: $('#complain_desc_ipt').val(),
        recieve_type_ipt: $('#recieve_type_ipt').val(),
        pradeshiya_saba_id: $('#ps').val(),
    };
    let arr = [];
    let index = 0;
    $.each($('#complain_attach')[0].files, function(key, val) {
        arr[index++] = val;
    });
    ulploadFileWithData(url, data, function(resp) {
        if (resp.status == 1) {
            window.location.href = "/complains";
            swal.fire('success', 'Successfully update the complains', 'success');
        } else {
            swal.fire('failed', 'Complain updating is unsuccessful', 'warning');
        }
    }, false, arr);
}

function delete_complain(id) {
    let url = '/api/delete_complain/id/' + id;
    ajaxRequest('DELETE', url, null, function(resp) {
        if (resp.status == 1) {
            $('#complain_tbl').DataTable().ajax.reload();
            swal.fire('success', resp.msg, 'success');
        } else {
            swal.fire('failed', resp.msg, 'warning');
        }
    });
}

function loadPradeshiyaSabha(callBack) {
    var cbo = "";
    ajaxRequest('GET', "/api/pradesheeyasabas", null, function(dataSet) {
        if (dataSet) {
            $.each(dataSet, function(index, row) {
                cbo += '<option value="' + row.id + '" data-ps_code="' + row.code + '">' + row.code + ' - ' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#ps').html(cbo);
        $('.select2').select2();
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
