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
                <h1>Certificate Perforation (<a id="cer_status"></a>)</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="card card-success card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="false">Industry Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link userDataTab" id="custom-tabs-three-userDataTab-tab" data-toggle="pill" href="#custom-tabs-three-userDataTab" role="tab" aria-controls="custom-tabs-three-userDataTab" aria-selected="false">Profile Details</a>
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
                                                    <hr>
                                                    <dt>Name : <a id="obj_name"></a></dt>
                                                    <dt>File No : <a id="obj_regno"></a></dt>                       
                                                    <dt>Industry Name : <a id="342"></a></dt>                       
                                                    <dt>Industry Address : <a id="34"></a></dt> 
                                                </div>
                                                <button class="btn btn-primary genCertificateNum d-none"><i class="fa fa-gear"></i> Generate Certificate Number</button>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="col-md-12 showReportInfoUi d-none">
                                        <div class="card card-danger collapsed-card">
                                            <div class="card-header">
                                                <h3 class="card-title"> There was a problem with  file. Please Check it.</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool text-white" data-card-widget="collapse">Read More..
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body reportInfo" style="display: none;">
                                                Unknown Error!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-address-card"></i> Certificate Details
                                            </h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <h6 id="certificate_Num">Application/Licence Number: <a class="text-danger">Not Assigned</a></h6>                      
                                            <h6 id="created_at">Created At:</h6>                      
                                            <h6 id="updated_at">Updated At:</h6>                      
                                            <hr>
                                            <div id="uploadFileSection">
                                                <dt>Upload Application :</dt>
                                                <button class="btn btn-dark navToFile1"><i class="fas fa-file-upload"></i> Upload Certificate/Application</button>   
                                            </div>
                                            <hr>
                                            <div class="form-group d-none" id="fileUpDiv">
                                                <hr>
                                                <label id="uploadLabel">File Upload </label>
                                                <input id="fileUploadInput" type="file" class=""  accept="application/pdf">
                                                <button id="uploadCerfile" class="btn btn-success"><i class="fas fa-file-upload"></i> Upload</button>
                                                <div class="progress d-none">
                                                    <div class="progress-bar bg-primary progress-bar-striped Uploadprogress" id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                        <!--<span class="sr-only">40% Complete (success)</span>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="text-success d-none" id="certificateSubmittedLable">Certificate Submitted</h4>
                                            <button class="btn btn-primary complCertificate d-none"><i class="fa fa-check"></i> Complete Certificate</button>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="fileShowUi d-none" style=" height: 200px;">
                                                        <hr>
                                                        <a data-toggle="tooltip" data-placement="top" title="Click to view file" id="fileuploadedPath" href="" target="_blank">
                                                            <p>Drafted Certificate</p>
                                                            <img class="rounded" alt="PDF" style="width: 100%; height: 80%;" src="/dist/img/pdf-view.png" data-holder-rendered="true">
                                                        </a>
                                                    </div>       
                                                </div>   
                                                <div class="col-6">
                                                    <div class="originalCertificateShowUi d-none" style=" height: 200px;">
                                                        <hr>
                                                        <a data-toggle="tooltip" data-placement="top" title="Click to view file" id="originalCertificatePath" href="" target="_blank">
                                                            <p>Original Certificate</p>
                                                            <img class="rounded" alt="PDF" style="width: 100%; height: 80%;" src="/dist/img/pdf-view.png" data-holder-rendered="true">
                                                        </a>
                                                    </div>
                                                </div>   
                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                        <div class="overlay certificateDetails dark">
                                            <i class="fas fa-2x fa-sync-alt"></i>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <!--Search Client By NIC END-->
                    </section>
                    <!--//Industry Profile END//-->
                </div>
                <!--//All User Data Open//-->
                <div class="tab-pane fade" id="custom-tabs-three-userDataTab" role="tabpanel" aria-labelledby="custom-tabs-three-userDataTab-tab">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-success card-outline">
                                    <div class="card-body box-profile">
                                        <h3 class="profile-username text-center">Client Details</h3>

                                        <p class="text-muted text-center firstL_name">{Client Name}</p>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>File No</b> <a class="float-right file_no"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Assign Date</b> <a class="float-right assign_date"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Address</b> <a class="float-right cl_address"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email</b> <a class="float-right cl_email"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Contact No</b> <a class="float-right cl_contact_no"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>NIC</b> <a class="float-right cl_nic"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-success card-outline">
                                    <div class="card-body box-profile">
                                        <h3 class="profile-username text-center">Industry Details</h3>

                                        <p class="text-muted text-center tabf_industry_name">{industry name}</p>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Registration No</b> <a class="float-right tabf_industry_registration_no"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Industry Category</b> <a class="float-right tabf_industry_cat_name"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Business Scale</b> <a class="float-right tabf_business_scale"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>PradesheeyaSaba</b> <a class="float-right tabf_pradesheeyasaba"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Start Date</b> <a class="float-right tabf_industry_start_date"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Investment</b> <a class="float-right tabf_industry_investment"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Address</b> <a class="float-right tabf_industry_address"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Contact No</b> <a class="float-right tabf_industry_contact_no"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email</b> <a class="float-right tabf_industry_email"></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Environment Officer</b> <a class="float-right tabf_environment_officer"></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                   
                </div>                
            </div>
        </div>
        <!--        <div class="overlay dark loadingRenderUI">
                    <i class="fas fa-2x fa-sync-alt"></i>
                </div>-->
    </div>  
</section>
<!--//Tab Section END//-->  
@endif
@endsection

@section('pageScripts')
<!-- Page script -->
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../js/CertificatePreferJS/certificate_perf.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    var PROFILE_ID = '{{$id}}';
    var FILE_STATUS = '';
    var CERTIFICATE_ID = '';
    $(function () {
//Load table
        getaProfilebyId(PROFILE_ID, function (parameters) {
            setProfileDetails(parameters);
            setIndustryAndClientDb(parameters);
            $(".loadingRenderUI").remove(); //<--Check Loading Status
        });

//select button action 
        $(document).on('click', '.btnAction', function () {
        });
    });

//Show Certificate Details
    getCertificateDetails(PROFILE_ID, function (resp) {
        FILE_STATUS = parseInt(resp.client.file_status);
        CERTIFICATE_ID = parseInt(resp.id);
    });
//Gen Certificate Number
    $('.genCertificateNum').click(function () {
        genCertificateNumbyId(PROFILE_ID, function (resp) {
            show_mesege(resp);
            if (resp.id == 1) {
                getCertificateDetails(PROFILE_ID, function (resp) {
                    CERTIFICATE_ID = parseInt(resp.id);
                    location.reload();
                });
            }
        });
    });
    $('.navToFile1').click(function () {
        $('#fileUpDiv').removeClass('d-none');
    });

    $('#uploadCerfile').click(function () {
        let url_upload = '';
        if (isNaN(CERTIFICATE_ID)) {
            alert('Certificate ID Error!');
            return false;
        }
        let file = $('#fileUploadInput')[0].files[0];
        if ($('#fileUploadInput')[0].files.length === 0) {
            alert('No File Selected!');
            return false;
        }
        if (FILE_STATUS == 4) {
            url_upload = '/api/certificate/original/';
        } else if (FILE_STATUS == 2) {
            url_upload = '/api/certificate/draft/';
        }
        console.log(FILE_STATUS);
        submitDataWithFile(url_upload + CERTIFICATE_ID, {file: file}, function (resp) {
            show_mesege(resp);
            if (resp.id == 1) {
                getCertificateDetails(PROFILE_ID, function (resp) {
                    CERTIFICATE_ID = parseInt(resp.id);
                    FILE_STATUS = parseInt(resp.client.file_status);
                });
            }
        });
    });

    $('.complCertificate').click(function () {
        if (confirm('Are you sure you want to cimplete this certificate?')) {
            completeCertificateAPI(CERTIFICATE_ID, FILE_STATUS, function (resp) {
                show_mesege(resp);
                getCertificateDetails(PROFILE_ID, function (resp) {
                    CERTIFICATE_ID = parseInt(resp.id);
                    FILE_STATUS = parseInt(resp.client.file_status);
                });
            });
        }
    });

</script>
@endsection
