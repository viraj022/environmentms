@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')
    {{-- @if ($pageAuth['is_read'] == 1 || false) --}}
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
        <div class="card card-success card-outline card-outline-tabs col-md-8">
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
                            <dt>Download & Upload Application :</dt>

                            <div class="form-group" id="fileUpDiv">
                                <hr>
                                <label id="uploadLabel">File Upload </label>
                                <input id="fileUploadInput" type="file" class="col-12"
                                    onchange="document.getElementById('attached_file').src = window.URL.createObjectURL(this.files[0])"
                                    accept="image/*, .pdf">
                                <div class="col-12">
                                    <img id="attached_file" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                        alt="Attachment" width="100" height="100" />
                                </div>
                                <div class="progress d-none">
                                    <div class="progress-bar bg-primary progress-bar-striped Uploadprogress"
                                        id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                        aria-valuemax="100" style="width: 0%">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btn btn-primary mt-2" data-upload_file="attachments"
                                        id="upld_attach"> Upload Attachment </button>
                                </div>
                            </div>
                            <div class="form-group" id="file_attachments">

                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- @endif --}}
@endsection

@section('pageScripts')
    <script>
        $(document).ready(function() {
            loadProfileData();
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
                        console.log(value);
                        image += "<img src='"+base_url + '/storage/' + value.img_path+"' width='10%'' height='10%''>";
                    });
                    
                    $('#file_attachments').html(image);
                }
            });
        }
    </script>
@endsection
