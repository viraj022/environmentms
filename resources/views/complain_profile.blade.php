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
                            <span id="file_attachments">

                            </span>
                        </section>
                    </div>
                    <div class="tab-pane" id="complain-assign" role="tabpanel" aria-labelledby="complain-assign">
                        <section class="content-header">
                            <form id="complain_assign_frm">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="user_level">User Level: </label>
                                        <select id="user_level" class="custom-select">
                                            <option value="1">Local</option>
                                            <option value="2">Director</option>
                                            <option value="3">Assistant Director</option>
                                            <option value="4">Environment Officer</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="user">User: </label>
                                        <select id="user" class="custom-select"></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <button type="button" class="btn btn-primary" id="assign_complain"> Assign To
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Assigned User: </label><span id="assigned_user"></span>
                                    </div>
                                </div>
                            </form>
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
            let user_level = $('#user_level').val();
            let complain_id = "{{ $complain_id }}";
            load_user_by_level(user_level);
            load_assigned_user(complain_id);
        });

        $('#user_level').on('change', function() {
            let user_level = $(this).val();
            load_user_by_level(user_level);
        });

        $('#assign_complain').click(function() {
            let user_id = $('#user').val();
            let complain_id = "{{ $complain_id }}";
            assign_user_to_complain(complain_id, user_id, function(){
                load_assigned_user(complain_id);
            });
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

        function loadProfileData() {
            let id = $('#complain_profile_id').val();
            let url = '/api/complain_profile_data/id/' + id;
            ajaxRequest('GET', url, null, function(resp) {
                $('#comp_code').html(resp.complainer_code);
                if (resp.assigned_user != null) {
                    $('#assigned_officer').html(resp.assigned_user.user_name);
                } else {
                    $('#assigned_officer').html('N/A');
                }
                if (resp.created_user != null) {
                    $('#created_user').html(resp.created_user.user_name);
                } else {
                    $('#created_user').html('N/A');
                }
                $('#comp_name').html(resp.complainer_name);
                $('#comp_address').html(resp.complainer_address);
                $('#comp_contact_no').html(resp.comp_contact_no);
                $('#comp_desc').html(resp.complain_des);
                if (resp.comp_status == 1) {
                    $('#comp_status_completed').removeClass('d-none');
                } else {
                    $('#comp_status_pending').removeClass('d-none');
                }
                let image = '';
                if (resp.attachment != null || resp.attachment.length != 0) {
                    let data = JSON.parse(unescape(resp.attachment));
                    let base_url = "{{ url('/') }}";
                    $.each(data, function(key, value) {
                        image += "<img src='" + base_url + '/storage/' + value.img_path +
                            "' width='100em' height='100em'>";
                    });

                    $('#file_attachments').html(image);
                }
            });
        }
    </script>
@endsection
