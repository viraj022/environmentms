@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
<style>
    table.dataTable td {
        word-break: break-word;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Complain Profile </h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Profile Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-three-attachments" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Attachments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#complain-assign" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Assign Complain</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-letters-tab" data-toggle="pill" href="#letters" role="tab" aria-controls="custom-tabs-two-letters" aria-selected="false">letter</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                    <div class="card-body box-profile">
                        <input type="text" id="complain_profile_id" value="{{ $complain_id }}" class="d-none">
                        <div class="text-center">
                            <h3 class="profile-username text-center"><b>Assigned Officer:</b><span id="assigned_officer">></span></h3>
                            <h2 class="profile-username text-center"><b>Created By :</b><span id="created_user">></span>
                            </h2>

                        </div>

                        <ul class="list-group list-group-unbordered mt-5 mb-3">

                            <li class="list-group-item">
                                <b>Code :</b> <a class="float-right" id="comp_code"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Complainer Name :</b> <a class="float-right" id="comp_name"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Complainer Contact No:</b> <a class="float-right" id="comp_contact_no"></a>
                            </li>
                            <li class="list-group-item">
                                <b>Description</b> <a class="float-right" id="comp_desc"></a>
                            </li>

                            <li class="list-group-item">
                                <b>Status : </b> <a class="float-right"><span id="comp_status" class=""></span></a>
                            </li>
                            <li class="list-group-item">
                                <b>Complain By :</b> <a class="float-right" id="comp_by"></a>
                            </li>

                        </ul>
                    </div>
                    <!--//Industry Profile Start//-->
                    {{-- <section class="content-header">
                            <!--show lient details START-->
                            <div class="view-Client">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <input type="text" id="complain_profile_id" value="{{ $complain_id }}"
                    class="d-none">
                    <div class="card-header">
                        <h6><b>Assigned Officer: </b><span id=""></span></h6>
                        <hr>
                        <h6><b>Created By: </b><span id="created_user"></span></h6>
                        <hr>
                    </div>
                    <div class="card-body">

                        <dl class="row">

                            <dt class="col-sm-5">Code : </dt>
                            <dd class="col-sm-7" id="comp_code"></dd>

                            <dt class="col-sm-5">Complainer Name : </dt>
                            <dd class="col-sm-7" id="comp_name"></dd>
                            <dt class="col-sm-5">Compainer Address:</dt>
                            <dd class="col-sm-7" id="comp_address"></dd>
                            <dt class="col-sm-5">Complainer Contact No:</dt>
                            <dd class="col-sm-7" id="comp_contact_no"></dd>
                            <dt class="col-sm-5">Description :</dt>
                            <dd class="col-sm-7" id="comp_desc"></dd>
                            <dt class="col-sm-5">Status : </dt>
                            <dd class="col-sm-7">
                                <div class="text-success d-none" id="comp_status_completed">Completed
                                </div>
                                <div class="text-warning d-none" id="comp_status_pending">Pending
                                </div>
                            </dd>
                            <dt class="col-sm-4">Complain By :</dt>
                            <dd class="col-sm-6" id="comp_by"></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<!--//Industry Profile END//-->
</div>
<div class="tab-pane" id="custom-tabs-three-attachments" role="tabpanel" aria-labelledby="custom-tabs-three-attachments">
    <section class="content-header">
        <hr>
        <dt class="text-center"> <b>Upload Attachments</b> </dt>
        <hr>
        <div class="form-group" id="fileUpDiv">

            <label id="uploadLabel">File Upload </label>
            <input id="fileUploadInput" type="file" class="col-12" accept=".png, .jpg, .jpeg, .pdf" multiple>
            <div class="col-12">
                <div id="attached_files"></div>
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary mt-2" data-upload_file="attachments" id="upld_attach"> Upload Attachment </button>
            </div>
        </div>
        <hr>
        <div class="row" id="file_attachments">

        </div>
    </section>
</div>
<div class="tab-pane" id="complain-assign" role="tabpanel" aria-labelledby="complain-assign">
    <section class="content-header">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card card-light">
                    <div class="card-header">
                        <h1> Complain assignment for user </h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <form id="complain_assign_frm" class="w-100">
                                    <div class="form-group">
                                        <label for="user_level">User Level: </label>
                                        <select id="user_level" class="custom-select">
                                            <option value="1">Local</option>
                                            <option value="2">Director</option>
                                            <option value="3">Assistant Director</option>
                                            <option value="4">Environment Officer</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="user">User: </label>
                                        <select id="user" class="custom-select"></select>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="assign_complain"> Assign To </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-9">
                                <div class="card card-light p-5">
                                    <div class="form-group">
                                        <h6><label>Assigned User: </label></h6>
                                        <span id="assigned_user"></span>
                                    </div>
                                    <table class="table table-bordered" id="forward_history">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Assignee</th>
                                                <th>Assignor</th>
                                                <th>Assigned Time</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                    <div class="form-group mt-5">
                                        <button id="confirm" class="btn btn-info d-none">Confirm</button>
                                        <button id="reject" class="btn btn-warning d-none">Reject</button>
                                        <button id="forward_letter_preforation" class="btn btn-success">Forward to letter preforation</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-light">
                    <div class="card-header">
                        <h1> Add comment for complains </h1>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <form id="comments_frm" class="w-100">
                                    <input type="text" id="comp_comnt_hid_id" name="comp_comnt_hid_id" value="{{ $complain_id }}" hidden>
                                    <div class="form-group">
                                        <label for="comment">Comment: </label>
                                        <input type="text" id="comment" class="form-control" name="comment" placeholder="Please type the comment">
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary" id="add_comment">
                                            Add Comment </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8 mt-3">
                                <div class="row">
                                    <div class="col-md-4"><b>#</b></div>
                                    <div class="col-md-4"><b>Comment</b></div>
                                    <div class="col-md-4"><b>Commented User</b></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="comment_section"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-light">
                            <div class="card-header">
                                <h1> Add minutes for complains </h1>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <form id="minutes_frm">
                                            <div class="form-group">
                                                <input type="text" id="comp_minute_hid_id" name="comp_minute_hid_id" value="{{ $complain_id }}" hidden>
                                                <label for="minute">Minute: </label>
                                                <input type="text" id="minute" class="form-control" name="minute" placeholder="Please type the minute">
                                            </div>

                                            <div class="form-group">
                                                <button type="button" class="btn btn-primary" id="add_minute">
                                                    Add Minute </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-8 mt-3">
                                        <div class="row">
                                            <div class="col-md-4"><b>#</b></div>
                                            <div class="col-md-4"><b>Minute</b></div>
                                            <div class="col-md-4"><b>Minute Added User</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" id="minute_section"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
</div>
<div class="tab-pane" id="letters" role="tabpanel" aria-labelledby="letters">
    <div class="row">
        <div class="col-md-3">
            <section class="content-header">
                <button id="create_letter_btn" type="button" class="btn btn-secondary">Create
                    Letter</button>
                <div id="letter_title_frm" class="form-group d-none">
                    <label for="letter_title">Letter Title: </label>
                    <input type="text" id="letter_title" class="form-control" placeholder="Enter the letter title" value="">
                    <button type="button" class="btn btn-success mt-2" id="save_letter_title">Save</button>
                </div>
            </section>
        </div>
        <div class="col-md-9">
            <section class="content-header">
                <div class="card card-light">
                    <div class="card-header">
                        <h1> Letter List </h1>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="letter_list" style="word-break: break-word;">
                            <thead>
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th style="width: 25%">Letter Title</th>
                                    <th style="width: 15%">Status</th>
                                    <th>Created User</th>
                                    <th>Letter Date</th>
                                    <th style="width: 25%">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-light">
                <div class="card-header">
                    <h4>File Assign</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="client_id">File No: </label>
                        <select class="custom-select select2" id="client_id"></select>
                        <button type="button" id="assign_file" class="btn btn-success mt-1">Assign
                            File</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</section>
@endsection

@section('pageScripts')
<script src="{{ asset('/js/complains/complainProfile.js') }}" type="text/javascript"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script>
    $(document).ready(function() {

        // Loaded via <script> tag, create shortcut to access PDF.js exports.
        var pdfjsLib = window['pdfjs-dist/build/pdf'];

        // The workerSrc property shall be specified.
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

        loadProfileData();
        let complain_id = "{{ $complain_id }}";
        load_forward_history_table(complain_id);
        load_user_by_level($('#user_level').val());
        load_letters(complain_id);
        load_file_no();
    });

    $('#create_letter_btn').click(function() {
        $(this).addClass('d-none');
        $('#letter_title_frm').removeClass('d-none');
    });

    $('#user_level').on('change', function() {
        load_user_by_level($(this).val());
    });

    $('#assign_complain').click(function() {
        let complain_id = "{{ $complain_id }}";
        assign_user_to_complain(complain_id, $('#user').val());
    });

    $('#add_comment').click(function() {
        comment_on_complain();
    });

    $('#add_minute').click(function() {
        add_minute_to_complain();
    });

    $('#save_letter_title').click(function() {
        save_title();
    });

    $('#assign_file').click(function() {
        let complain_id = "{{ $complain_id }}";
        let client_id = $('#client_id').val();
        assign_file_no(complain_id, client_id);
    });

    $(document).on('click', '.remove_attach', function() {
        let data = {
            "id": "{{ $complain_id }}",
            "file_path": $(this).attr('data-name'),
        };
        let url = '/api/delete_attach';
        ajaxRequest('DELETE', url, data, function(resp) {
            if (resp.status == 1) {
                swal.fire('success', 'Complain attachments successfully removed', 'success');
                loadProfileData();
            } else {
                swal.fire('failed', 'Complain attachments removal was unsuccessful', 'warning');
            }
        });

    });

    function save_title() {
        let complain_id = "{{ $complain_id }}";
        let data = {
            "title": $('#letter_title').val(),
            "complain_id": complain_id
        };
        let url = '/api/save_document';
        if (data.title != '') {
            ajaxRequest('POST', url, data, function(resp) {
                if (resp.status == 1) {
                    swal.fire('success', 'letter title adding is successfull', 'success');
                    $('#letter_title').val('');
                    load_letters(complain_id);
                } else {
                    swal.fire('failed', 'letter title adding was unsuccessful', 'warning');
                }
            });
        } else {
            swal.fire('failed', 'Title is required !', 'warning');
        }
    }

    $('#confirm').click(function() {
        Swal.fire({
            title: 'Do you want to confirm?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'confirm',
            denyButtonText: `Don't confirm`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.value) {
                let complain_id = "{{ $complain_id }}";
                confirm_complain(complain_id);
            } else if (result.isDenied) {
                Swal.fire('Canceled!', 'Confirmation was cancelled', 'info')
            }
        })
    });

    $('#reject').click(function() {
        Swal.fire({
            title: 'Do you want to reject?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'reject',
            denyButtonText: `Don't reject`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.value) {
                let complain_id = "{{ $complain_id }}";
                reject_complain(complain_id);
            } else if (result.isDenied) {
                Swal.fire('Canceled!', 'Rejection was cancelled', 'info')
            }
        })
    });

    $('#forward_letter_preforation').click(function() {
        Swal.fire({
            title: 'Do you want to forward for letter preforation?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'confirm',
            denyButtonText: `Don't confirm`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.value) {
                let complain_id = "{{ $complain_id }}";
                forward_letter_preforation(complain_id);
            } else if (result.isDenied) {
                Swal.fire('Canceled!', 'Confirmation was cancelled', 'info')
            }
        })
    });

    $('#upld_attach').click(function() {
        update_attachments();
    });

    $('#fileUploadInput').change(function() {
        let index = 0;
        let html = "";
        $.each($('#fileUploadInput')[0].files, function(key, val) {
            let file = val;

            let default_url = window.location.origin + "/dist/img/pdf-view.png";
            if (val.type == "application/pdf") {
                html += "<img src='" + default_url + "' width='100em' height='100em'></img>";

            } else {
                html += "<img src='" + window.URL.createObjectURL(val) +
                    "' width='100em' height='100em'></img>";

            }
            $('#attached_files').html(html);
        });
    });

    function load_letters(complain_id) {
        let url = '/api/get_letters_by_complain/complain/' + complain_id;
        ajaxRequest('GET', url, null, function(resp) {
            var letter_view_tbl = "";
            // $('#letter_view_tbl').DataTable().destroy();
            // $('#letter_list').DataTable({
            //     responsive: true,
            //     aLengthMenu: [
            //         [10, 25, 50, 100, -1],
            //         [10, 25, 50, 100, "All"]
            //     ],
            //     "bDestroy": true,
            //     iDisplayLength: 10
            // });
            $.each(resp, function(key, value2) {
                key++;

                let edit_btn = (value2.status != 'COMPLETED') ? '<a href="/get_letter_content/letter/' +
                    value2.id + '" class="btn btn-success">Edit</a>' : '';
                letter_view_tbl += "<tr><td>" + key + "</td><td>" + value2.letter_title + "</td><td>" +
                    value2.status + "</td><td>" + value2.user_name + "</td><td>" +
                    value2.created_at + "</td><td><a href='/get_letter/letter/" + value2.id +
                    "' class='btn btn-primary mr-2'>View</a>" + edit_btn + "</td></tr>";
            });
            $('#letter_list tbody').html(letter_view_tbl);

        });
    }
</script>
@endsection