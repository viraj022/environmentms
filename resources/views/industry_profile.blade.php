@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
<!-- Select2 -->
<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
@if($pageAuth['is_read']==1 || false)
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Industry Profile</h1>
            </div>
        </div>
    </div>
</section>
<!--//Tab Section START//-->
<section class="content-header">
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="false">Industry Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link oldAttachTab disabled" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Old Attachments</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-three-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                    <!--//Industry Profile Start//-->
                    <section class="content-header">
                        <!--show lient details START-->
                        <div class="view-Client ">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-user"></i> Client Details

                                                    </h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Name:</dt>
                                                        <dd class="col-sm-6" id="client_name"></dd>
                                                        <dt class="col-sm-4">Address:</dt>
                                                        <dd class="col-sm-6" id="client_address"></dd>
                                                        <dt class="col-sm-4">Contact No:</dt>
                                                        <dd class="col-sm-6" id="client_cont"></dd>
                                                        <dt class="col-sm-4">Contact Email:</dt>
                                                        <dd class="col-sm-6" id="client_amil"></dd>
                                                    </dl>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title"><i class="fas fa-address-card"></i> Services</h3>
                                                </div>
                                                <!-- /.card-header -->

                                                <div class="card-body">
                                                    <div class="callout callout-danger">

                                                        <button type="button" onclick="location.href = '/epl_assign';" class="btn btn-dark" data-dismiss="modal">Assign/Change Environment Officer</button>
                                                        <!--<p>There is a problem that we need to</p>-->
                                                    </div>

                                                    <div class="newEPL d-none info-box mb-3 bg-success">
                                                        <span class="info-box-icon">
                                                            <button class="btn btn-lg btn-default" id="newEPL"><i class="fa fa-plus"></i></button></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Create new environment protection license file</span>
                                                            <span class="info-box-number">New EPL</span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>
                                                    <div class="viewEPL info-box mb-3 bg-success d-none">
                                                        <span class="info-box-icon">
                                                            <a class="btn btn-lg btn-default" href="" id="setEPlLink"><i class="fa fa-plus"></i></a></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Environment protection license file</span>
                                                            <span class="info-box-number">View <a id="setEPLCode"></a></span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>

                                                    <div class="info-box mb-3 bg-info">
                                                        <span class="info-box-icon">
                                                            <button class="btn btn-lg btn-default" id="newSiteClearence" ><i class="fa fa-plus"></i></button></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Create new site clearance file</span>
                                                            <span class="info-box-number">New Site Clearance</span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>

                                                    <div class="info-box mb-3 bg-info">
                                                        <span class="info-box-icon">
                                                            <button class="btn btn-lg btn-default" id="teli" ><i class="fa fa-plus"></i></button></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Create new telecommunication site clearance file</span>
                                                            <span class="info-box-number">Telecommunication Site Clearance</span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>

                                                    <div class="info-box mb-3 bg-info">
                                                        <span class="info-box-icon">
                                                            <button class="btn btn-lg btn-default" id="scheduleWaste"><i class="fa fa-plus"></i></button></span>

                                                        <div class="info-box-content">
                                                            <span class="info-box-text">Create new schedule waste management certificate</span>
                                                            <span class="info-box-number">Schedule Waste</span>
                                                        </div>
                                                        <!-- /.info-box-content -->
                                                    </div>

                                                </div>
                                                <!-- /.card-body -->

                                                <div class="serviceSectionCnf dark">
                                                    <a class="text-white">Not Allowed To Add New EPL For Old Profile!</a>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-address-card"></i> EPL Details
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <h6 id="env_firstname">Environment Officer: Not Assigned</h6>
                                            <dt>Name : <a id="obj_name"></a></dt>
                                            <dt>BR No : <a id="obj_regno"></a></dt>                       
                                            <dt>Investment : Rs <a id="obj_invest"></a>.00</dt>
                                            <dt>Location : <a id="obj_name"></a></dt>
                                            <div id="map" style="width: 100%; height: 400px;"></div>
                                            <dt>Download Application :</dt>

                                            <a href="" class="btn btn-dark navToFile1" target="_blank">View Road Map</a>
                                            <a href="" class="btn btn-dark navToFile2" target="_blank">View Deed of the land</a>
                                            <a href="" class="btn btn-dark navToFile3" target="_blank">View Survey Plan</a>

                                            <button type="button" class="btn btn-success d-none" data-upload_file="Road Map" id="upld_roadMap">Upload Road Map</button>
                                            <button type="button" class="btn btn-success d-none" data-upload_file="Deed Of The Land" id="upld_deed">Upload Deed of the land </button>
                                            <button type="button" class="btn btn-success d-none" data-upload_file="Survey Plan" id="upld_SurveyPlan">Upload Survey Plan</button>
                                            <div class="form-group d-none" id="fileUpDiv">
                                                <hr>
                                                <label id="uploadLabel">File Upload </label>
                                                <input id="fileUploadInput" type="file" class=""  accept="image/*, .pdf">
                                                <div class="progress d-none">
                                                    <div class="progress-bar bg-primary progress-bar-striped Uploadprogress" id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                        <!--<span class="sr-only">40% Complete (success)</span>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div> 
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-address-card"></i> Customer EPL List</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <table class="table table-active" id="clientEplList">
<!--                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Buiseness Name</th>
                                                        <th>EPL</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>-->
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Search Client By NIC END-->

                        <div class="modal fade" id="modal-danger">
                            <div class="modal-dialog">
                                <div class="modal-content bg-danger">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Delete Selected Item</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><b>Are you sure you want to permanently delete this Item? </b></p>
                                        <p>Once you continue, this process can not be undone. Please Procede with care.</p>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                                        <button id="btnDelete" type="submit" class="btn btn-outline-light" data-dismiss="modal">Delete Permanently</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </section>
                    <!--//Industry Profile END//-->
                </div>
                <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                    <!--//Old Attachments Start//-->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Other Attachments</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="card-body table-responsive" style="height: 450px;">
                                    <div class="form-group uploadAttachments">
                                        <label>Upload: </label>
                                        <input id="otherFiles" type="file">
                                        @if($pageAuth['is_create']==1 || false)
                                        <button disabled id="btnUpload" type="submit" class="btn btn-success">Upload</button>
                                        @endif
                                    </div>
                                    <div class="card-body injectViewAttachs">                                
                                        <a href="#" target="_blank">Loading Attachments...</a>                          
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="card confirmRemoval">
                            <div class="card-body p-0">
                                <div class="card-body d-none isNotConfiremd">
                                    <a>Did you finish attaching all old files for this client?</a>
                                    <button id="btnConfirm" class="btn btn-dark">Confirm</button>
                                </div>
                                <div class="card-body d-none isConfirmed">
                                    <h4>File Checked And Confirmed</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--//Old Attachments END//-->
                </div>
            </div>
        </div>
    </div>  
</section>
<!--//Tab Section END//-->  
<section>
    <div class="viewClientData d-none">
        <p>Here Is Our Client Data!</p>
    </div>
</section>

@endif
@endsection



@section('pageScripts')
<!-- Page script -->

<!-- Bootstrap4 Duallistbox 
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>-->
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../js/commonFunctions/file_upload.js" type="text/javascript"></script>
<script src="../../js/IndustryProfileJS/industry_profile.js" type="text/javascript"></script>
<script src="../../js/IndustryProfileJS/upload_old_attachment.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyaUNtnrMrJwLqWQmHoUbeHaLk6q4msXE&callback=initMap"></script>
<script>
                                                            PROFILE_ID = '{{$id}}';
                                                            $(function () {
                                                                getaProfilebyId(PROFILE_ID, function (parameters) {
                                                                    setProfileDetails(parameters);
                                                                    sectionProtector(parameters.is_old);
                                                                    loadAllOldAttachments(parameters, function () {
                                                                    });
                                                                    oldFileConfirmSection(parameters.is_old);
                                                                    checkEPLstatus(parameters.epls);
                                                                });
                                                                $('#newEPL').click(function () {
                                                                    if (isNaN(parseInt(PROFILE_ID))) {
                                                                        return false;
                                                                    }
                                                                    window.location = "/epl_register/id/" + PROFILE_ID;
                                                                });
                                                                //new
                                                                $('#upld_roadMap, #upld_deed, #upld_SurveyPlan').click(function () {
                                                                    $('#uploadLabel').html('Select ' + $(this).data('upload_file') + ' File To Upload');
                                                                    $('#fileUploadInput').data('fileType', $(this).data('upload_file'));
                                                                    $('#fileUpDiv').removeClass('d-none');
                                                                });

                                                                //file upload click
                                                                $('#fileUploadInput').change(function () {
                                                                    if (!confirm('Are you sure you want to save this attachment?')) {
                                                                        return false;
                                                                    }
                                                                    let uploadFileType = $(this).data('fileType');
                                                                    let formData = new FormData();
                                                                    let fileCat = '';
                                                                    // populate fields
                                                                    let file = $(this)[0].files[0];// file
                                                                    formData.append('file', file);
                                                                    switch (uploadFileType) {
                                                                        case 'EPL':
                                                                            fileCat = 'file';
                                                                            break;
                                                                        case 'Road Map':
                                                                            fileCat = 'file1';
                                                                            break;
                                                                        case 'Deed Of The Land':
                                                                            fileCat = 'file2';
                                                                            break;
                                                                        case 'Survey Plan':
                                                                            fileCat = 'file3';
                                                                            break;

                                                                        default:

                                                                            break;
                                                                    }
                                                                    ulploadFile2('/api/epl/upload/epl/' + PROFILE_ID + '/file/' + fileCat, formData, function (parameters) {
                                                                        show_mesege(parameters);
                                                                        getaProfilebyId(PROFILE_ID, function (result) {
                                                                            setProfileDetails(result);
                                                                        });
                                                                    });
                                                                });

                                                            });

//btnCustomerVa button action 
                                                            $(document).on('click', '.btnCustomerVa', function () {
                                                                var row = JSON.parse(decodeURIComponent($(this).data('row')));
                                                                setClientDetails(row);
                                                                setSectionVisible('view-Client');
                                                            });
                                                            function disWarnPay() {
                                                                toastr.error('Assign Environment Officer & Try Again!');
                                                            }
                                                            //Upload Old Attachments
                                                            $('#btnUpload').click(function () {
                                                                var file = $('#otherFiles')[0].files[0];
                                                                uploadOldAttacments(PROFILE_ID, 'file', file, function (result) {
                                                                    show_mesege(result);
//                                                                    regenCLientData(PROFILE_ID);
                                                                });
                                                            });
                                                            //Remove Old Attachments
                                                            $(document).on('click', '.removeAttachs', function () {
                                                                var getRemoveId = $(this).attr('id');
                                                                deleteOldAttachments(getRemoveId, function (result) {
                                                                    show_mesege(result);
//                                                                    regenCLientData(PROFILE_ID);
                                                                });
                                                            });
                                                            //Confirm Button
                                                            $('#btnConfirm').click(function () {
                                                                if (confirm("Not able to be reversed! Are you sure?")) {
                                                                    ConfirmUploadingAttachs(PROFILE_ID, function (respo) {
                                                                        show_mesege(respo);
                                                                        location.reload();
                                                                    });
                                                                } else {
                                                                    return false;
                                                                }
                                                            });
//Handle Upload Button
                                                            $(document).ready(function () {
                                                                $('#otherFiles').bind('change', function () {
                                                                    uploadButtonHandler($('#otherFiles').val());
                                                                });
                                                            });
</script>
@endsection
