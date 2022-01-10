@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')

@section('content')

    <link href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-primary mt-5 col-md-3">
                    <div class="card-header">Complains</div>
                    <div class="card-body">
                        <input type="text" id="hidden_id" value="" hidden>
                        <form enctype="multipart/form-data" id="complain_frm">
                            <div class="form-group">
                                <label>Complain Code*</label>
                                <input id="complainer_code" name="complainer_code" type="text" maxlength="45"
                                    class="form-control form-control-sm cutenzReq" readonly>
                            </div>
                            <div class="form-group">
                                <label>Complainer Name*</label>
                                <input id="complainer_name_ipt" name="complainer_name_ipt" type="text" maxlength="45"
                                    class="form-control form-control-sm cutenzReq" placeholder="Enter complainer name..."
                                    value="" required>
                                <div id="comp_name_valid" class="d-none">
                                    <p class="text-danger">Container Name is required</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Complain Recieve Type</label>
                                <select id="recieve_type_ipt" name="recieve_type_ipt" class="form-control form-control-sm">
                                    <option value="1">Call</option>
                                    <option value="2">Written</option>
                                    <option value="3">Verbal</option>
                                </select>
                                <div id="recieve_type_valid" class="d-none">
                                    <p class="text-danger">Recieve type required</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Complainer Address*</label>
                                <input id="complainer_address_ipt" name="complainer_address_ipt" type="text" maxlength="45"
                                    class="form-control form-control-sm cutenzReq" placeholder="Enter complainer address..."
                                    value="" required>
                                <div id="comp_address_valid" class="d-none">
                                    <p class="text-danger">Container Address is required</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Complainer Contact Number*</label>
                                <input id="contact_complainer_ipt" name="contact_complainer_ipt" onKeyDown="if (this.value.length == 10 && event.keyCode != 8)
                                                                                                    return false;"
                                    type="number" class="form-control form-control-sm"
                                    placeholder="Enter Contact Number of complainer..." value="" required>
                                <div id="contact_complainer_valid" class="d-none">
                                    <p class="text-danger">Complainer Contact Number is required</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Complain Description*</label>
                                <textarea id="complain_desc_ipt" name="complain_desc_ipt"
                                    class="form-control form-control-sm" placeholder="Enter complain Description..."
                                    value="" required></textarea>
                                <div id="complain_desc_valid" class="d-none">
                                    <p class="text-danger">Complain description required</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Attachment</label>
                                <input type="file" id="complain_attach" name="complain_attach" multiple>
                                <div id="complain_attach_valid" class="d-none">
                                    <p class="text-danger">Complain attachment required</p>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="form-group col-12">
                                    <button type="button" class="btn btn-lg btn-success" id="save">Save</button>
                                    <button type="button" class="btn btn-lg btn-warning d-none" id="update">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card card-primary mt-5 col-md-9">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <table class="table table-bordered" id="complain_tbl">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Contact Number</th>
                                    <th>Description</th>
                                    <th>Created User</th>
                                    <th>Assigned User</th>
                                    <th>Recieved By</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="9" class="text-center"><b>No Data</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('pageScripts')
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Page script -->
    <script>
        $(document).ready(function() {
            load_complains();
            gen_complain_code();
        });

        $('#save').click(function() {
            let is_valid = jQuery("#complain_frm").valid();
            if (is_valid) {
                save_complain();
            } else {
                swal.fire('failed', 'Required fields must fill', 'warning');
            }

        });

        $('#update').click(function() {
            let is_valid = jQuery("#complain_frm").valid();
            if (is_valid) {
                update_complain();
            } else {
                swal.fire('failed', 'Required fields must fill', 'warning');
            }
        });


        function gen_complain_code() {
            var code = Math.random().toString(36).substring(2, 5) + Math.random().toString(36).substring(2, 5);
            $('#complainer_code').val(code);
        }

        function load_complains() {
            let url = '/api/complain_data';
            let index = 1;
            complain_list = $('#complain_tbl').DataTable({
                "destroy": true,
                "processing": true,
                "colReorder": true,
                "serverSide": false,
                "stateSave": true,
                "pageLength": 10,
                language: {
                    searchPlaceholder: "Search..."
                },
                "ajax": {
                    "url": "/api/get_complain_data/",
                    "type": "GET",
                    "dataSrc": ""
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
                        "data": "complainer_address",
                        "defaultContent": "-"
                    },
                    {
                        "data": "comp_contact_no",
                        "defaultContent": "-"
                    },
                    {
                        "data": "complain_des",
                        "defaultContent": "-"

                    },
                    {
                        "data": "created_user.user_name",
                        "defaultContent": "-"
                    },
                    {
                        "data": "assigned_user.user_name",
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
                        "targets": 8,
                        "data": "0",
                        "render": function(data, type, full, meta) {
                            if (full['recieve_type'] == 1) {
                                return "<span class='bg-success'>Call</span>";
                            } else if (full['recieve_type'] == 2) {
                                return "<span class='bg-success'>Written</span>";
                            } else {
                                return "<span class='bg-success'>Verbal</span>";
                            }
                        }
                    },
                    {
                        "targets": 9,
                        "data": "0",
                        "render": function(data, type, full, meta) {
                            if (full['status'] == 1) {
                                return "<span class='bg-success'>Completed</span>";
                            } else {
                                return "<span class='bg-warning'>Pending</span>";
                            }
                        }
                    },
                    {
                        "targets": 10,
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

            $(function() {
                var t = $("#complain_tbl").DataTable({
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: true,
                });
                t.on('order.dt search.dt', function() {
                    t.column(0, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = i + 1;
                    });
                }).draw();
            });

            //data table error handling
            $.fn.dataTable.ext.errMode = 'none';
            $('#complain_tbl').on('error.dt', function(e, settings, techNote, message) {
                console.log('DataTables error: ', message);
            });
        }

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).val();
            let url = '/api/complain_profile_data/id/' + id;
            ajaxRequest('GET', url, null, function(resp) {
                $('#complainer_code').val(resp.complainer_code);
                $('#complainer_name_ipt').val(resp.complainer_name);
                $('#complainer_address_ipt').val(resp.complainer_address);
                $('#contact_complainer_ipt').val(resp.comp_contact_no);
                $('#complain_desc_ipt').val(resp.complain_des);
                $('#recieve_type_ipt').val(resp.recieve_type);
                $('#hidden_id').val(resp.id);
            });

            $('#save').addClass('d-none');
            $('#update').removeClass('d-none');
        });

        $(document).on('click', '.btn-del', function() {
            let id = $(this).val();
            delete_complain(id);
        });

        function getJtableBtnHtml(full) {
            var html = '';
            html += '<div class="btn-group" role="group"  aria-label="" >';
            html += '<button type="button" class="btn btn-primary btn-edit" value="' + full["id"] +
                '" data-toggle="tooltip" title="Edit"><i class="fas fa-edit" aria-hidden="true"></i></button>';
            html += '<a href="/complain_profile/id/' + full['id'] +
                '" class="btn btn-success" role="button" data-toggle="tooltip" title="profile"><i class="fa fa-info-circle" style="width: 10px" aria-hidden="true" alt="profile"></i></a>';
            html += '<button type="button" class="btn btn-danger btn-del" value="' + full["id"] +
                '" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button>';
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
            };
            let arr = [];
            let index = 0;
            $.each($('#complain_attach')[0].files, function(key, val) {
                arr[index++] = val;
            });
            ulploadFileWithData(url, data, function(resp) {
                if (resp.status == 1) {
                    $('#complain_frm')[0].reset();
                    $('#complain_tbl').DataTable().ajax.reload();
                    gen_complain_code();
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
            };
            data.complain_attach = $('#complain_attach')[0].files;
            ulploadFileWithData(url, data, function(resp) {
                if (resp.status == 1) {
                    $('#complain_frm')[0].reset();
                    $('#complain_tbl').DataTable().ajax.reload();
                    $('#save').removeClass('d-none');
                    $('#update').addClass('d-none');
                    gen_complain_code();
                    swal.fire('success', 'Successfully Updated the complains', 'success');
                } else {
                    swal.fire('failed', 'Complain Updating is unsuccessful', 'warning');
                }
            }, 'POST');
        }

        function delete_complain(id) {
            let url = '/api/delete_complain/id/' + id;
            ajaxRequest('DELETE', url, null, function(resp) {
                if (resp.status == 1) {
                    $('#complain_tbl').DataTable().ajax.reload();
                    swal.fire('success', 'Successfully deleted the complains', 'success');
                } else {
                    swal.fire('failed', 'Complain deleting is unsuccessful', 'warning');
                }
            });
        }
    </script>

@endsection
