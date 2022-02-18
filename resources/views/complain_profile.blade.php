@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')

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
    <!--//Tab Section START//-->
    <section class="content-header">
        <div class="card card-success card-outline card-outline-tabs col-md-12">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                            href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                            aria-selected="false">Profile Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-attachments-tab" data-toggle="pill"
                            href="#custom-tabs-three-attachments" role="tab" aria-controls="custom-tabs-three-attachments"
                            aria-selected="false">Attachments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="complain-assign-tab" data-toggle="pill" href="#complain-assign"
                            role="tab" aria-controls="complain-assign" aria-selected="false">Assign Complain</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel"
                        aria-labelledby="custom-tabs-three-home-tab">
                        <!--//Industry Profile Start//-->
                        <section class="content-header">
                            <!--show lient details START-->
                            <div class="view-Client ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <input type="text" id="complain_profile_id" value="{{ $complain_id }}"
                                                class="d-none">
                                            <div class="card-body">
                                                <h6><b>Assigned: </b><span id="assigned_officer"></span></h6>
                                                <h6><b>Created By: </b><span id="created_user"></span></h6>
                                                <dl class="row">
                                                    <dt class="col-sm-4">Code : </dt>
                                                    <dd class="col-sm-6" id="comp_code"></dd>
                                                    <dt class="col-sm-4">Complainer Name : </dt>
                                                    <dd class="col-sm-6" id="comp_name"></dd>
                                                    <dt class="col-sm-4">Compainer Address:</dt>
                                                    <dd class="col-sm-6" id="comp_address"></dd>
                                                    <dt class="col-sm-4">Complainer Contact No:</dt>
                                                    <dd class="col-sm-6" id="comp_contact_no"></dd>
                                                    <dt class="col-sm-4">Description :</dt>
                                                    <dd class="col-sm-6" id="comp_desc"></dd>
                                                    <dt class="col-sm-4">Status : </dt>
                                                    <dd class="col-sm-6">
                                                        <div class="bg-success d-none" id="comp_status_completed">Completed
                                                        </div>
                                                        <div class="bg-warning d-none" id="comp_status_pending">Pending
                                                        </div>
                                                    </dd>
                                                    <dt class="col-sm-4">Complain By :</dt>
                                                    <dd class="col-sm-6" id="comp_by">Call</dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!--//Industry Profile END//-->
                    </div>
                    <div class="tab-pane" id="custom-tabs-three-attachments" role="tabpanel"
                        aria-labelledby="custom-tabs-three-attachments">
                        <section class="content-header">
                            <hr>
                            <dt class="text-center"> <b>Upload Attachments</b> </dt>
                            <hr>
                            <div class="form-group" id="fileUpDiv">

                                <label id="uploadLabel">File Upload </label>
                                <input id="fileUploadInput" type="file" class="col-12" accept=".png, .jpg, .jpeg"
                                    multiple>
                                <div class="col-12">
                                    <span id="attached_files"></span>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary mt-2" data-upload_file="attachments"
                                        id="upld_attach"> Upload Attachment </button>
                                </div>
                            </div>
                            <hr>
                            <dt class="text-center"> <b>Uploaded Attachments</b> </dt>
                            <hr>
                            <span id="file_attachments"></span>
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
                                                            <button type="button" class="btn btn-primary"
                                                                id="assign_complain"> Assign To </button>
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
                                                                    <th>Assigner</th>
                                                                    <th>Assigned Time</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <div class="form-group mt-5">
                                                        <button id="confirm" class="btn btn-info d-none">Confirm</button>
                                                        <button id="reject" class="btn btn-warning d-none">Reject</button>
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
                                                        <input type="text" id="comp_comnt_hid_id" name="comp_comnt_hid_id"
                                                            value="{{ $complain_id }}" hidden>
                                                        <div class="form-group">
                                                            <label for="comment">Comment: </label>
                                                            <input type="text" id="comment" class="form-control"
                                                                name="comment" placeholder="Please type the comment">
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary" id="add_comment">
                                                                Add Comment </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-8 mt-3" id="comment_section"></div>
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
                                                            <input type="text" id="comp_minute_hid_id"
                                                                name="comp_minute_hid_id" value="{{ $complain_id }}"
                                                                hidden>
                                                            <label for="minute">Minute: </label>
                                                            <input type="text" id="minute" class="form-control"
                                                                name="minute" placeholder="Please type the minute">
                                                        </div>

                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary" id="add_minute">
                                                                Add Minute </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-8 mt-3" id="minute_section"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
<script src="{{ asset('/js/complains/complainProfile.js') }}" type="text/javascript"></script>
@section('pageScripts')
    <script>
        $(document).ready(function() {
            loadProfileData();
            load_user_by_level($('#user_level').val());
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

        $('#upld_attach').click(function() {
            update_attachments();
        });

        $('#fileUploadInput').change(function() {
            let index = 0;
            let html = "";
            $.each($('#fileUploadInput')[0].files, function(key, val) {
                html += "<img src='" + window.URL.createObjectURL(val) + "' width='100em' height='100em'/>";
            });
            $('#attached_files').html(html);
        });
    </script>
@endsection
