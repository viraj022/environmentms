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
    @if ($pageAuth['is_read'] == 1 || false)
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                        <h1>Certificate Preparation (<a id="cer_status"></a>)</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <div class="card card-success card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill"
                                href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home"
                                aria-selected="false">Industry Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link userDataTab" id="custom-tabs-three-userDataTab-tab" data-toggle="pill"
                                href="#custom-tabs-three-userDataTab" role="tab"
                                aria-controls="custom-tabs-three-userDataTab" aria-selected="false">Profile Details</a>
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
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-success">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                <i class="fas fa-user"></i> <b>Client Details</b>
                                                            </h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body">
                                                            <dl class="row">
                                                                <dt class="col-sm-4">Name:</dt>
                                                                <dd class="col-sm-7" id="client_name"></dd>
                                                                <dt class="col-sm-4">Address:</dt>
                                                                <dd class="col-sm-7" id="client_address"></dd>
                                                                <dt class="col-sm-4">Contact No:</dt>
                                                                <dd class="col-sm-7" id="client_cont"></dd>
                                                                <dt class="col-sm-4">Contact Email:</dt>
                                                                <dd class="col-sm-7" id="client_amil"></dd>
                                                            </dl>
                                                        </div>
                                                        <!--                                                <button class="btn btn-primary genCertificateNum d-none"><i class="fa fa-gear"></i> Generate Certificate Number</button>
                                                                                         /.card-body -->
                                                    </div>
                                                    <div class="card card-success">
                                                        <div class="card-header">
                                                            <h3 class="card-title">
                                                                <i class="fas fa-user"></i> <b>Industry Details</b>
                                                            </h3>
                                                        </div>
                                                        <!-- /.card-header -->
                                                        <div class="card-body">
                                                            <dl class="row">
                                                                <dt class="col-sm-4">Name :</dt>
                                                                <dt class="col-sm-7"><a id="obj_name"
                                                                        style='font-weight:normal'></a></dt>
                                                                <dt class="col-sm-4">File No : </dt>
                                                                <dt class="col-sm-7"><a id="obj_regno"></a></dt>
                                                                <dt class="col-sm-4">Industry Name : </dt>
                                                                <dt class="col-sm-7"><a id="342"></a></dt>
                                                                <dt class="col-sm-4">Industry Address : </dt>
                                                                <dt class="col-sm-7"><a id="34"></a></dt>
                                                                <dt class="col-sm-7">
                                                                    <input type="hidden" id="cert_id" value="">
                                                                    <div class="form-group mt-2">
                                                                        <input type="text" id="man_cert_ref_no"
                                                                            class="form-control"
                                                                            placeholder="Enter reference number here">
                                                                        <button type="button" id="save_man_ref_no"
                                                                            class="btn btn-success mt-2">Save Reference
                                                                            No</button>
                                                                    </div>
                                                                </dt>
                                                            </dl>
                                                        </div>
                                                        <button class="btn btn-primary genCertificateNum m-1 d-none"><i
                                                                class="fa fa-gear"></i> Generate Certificate
                                                            Number</button>
                                                        <!-- /.card-body -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="col-md-12 showReportInfoUi d-none">
                                                <div class="card card-danger collapsed-card">
                                                    <div class="card-header">
                                                        <h3 class="card-title"> There was a problem with file. Please
                                                            Check it.</h3>
                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool text-white"
                                                                data-card-widget="collapse">Read More..
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body reportInfo" style="display: none;">
                                                        Unknown Error!
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card card-success">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-address-card"></i> Certificate Details
                                                    </h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <h6 id="certificate_Num">Application/Licence Number: <a
                                                            class="text-danger">Not Assigned</a></h6>
                                                    <h6 id="ref_Num">Reference No: <a class="text-danger">N/A</a></h6>
                                                    <h6 id="created_at">Created At:</h6>
                                                    <h6 id="updated_at">Updated At:</h6>

                                                    <div id="uploadFileSection">
                                                        <hr>
                                                        <dt>Upload Application :</dt>
                                                        <button class="btn btn-dark navToFile1"><i
                                                                class="fas fa-file-upload"></i> Upload
                                                            Certificate/Application</button>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group">
                                                        <label>Issue Date*</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input id="issue_date" name="datepickerUi" type="text"
                                                                max="2999-12-31" class="form-control form-control-sm"
                                                                placeholder="Enter Issue Date..." value=""
                                                                autocomplete="off">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Expire Date*</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input id="expire_date" name="datepickerUi" type="text"
                                                                max="2999-12-31" class="form-control form-control-sm "
                                                                placeholder="Enter Expire Date..." value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group fileUpDiv">
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="fileUploadInput">PDF Upload: </label><br>
                                                                    <input id="fileUploadInput" type="file" accept=".doc, .docx, .pdf">
                                                                    <button id="uploadCerfile" class="btn btn-success"><i class="fas fa-file-upload"></i> Upload</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="progress d-none">
                                                            <div class="progress-bar bg-primary progress-bar-striped Uploadprogress"
                                                                id="Uploadprogress" role="progressbar" aria-valuenow="40"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                                <!--<span class="sr-only">40% Complete (success)</span>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group showCorrectedFileUi d-none">
                                                        <label for="uploadLabel">Word File Upload: </label><br>
                                                        <input id="correctedFile" type="file" class="" accept=".doc, .docx, .pdf">
                                                        <button id="uploadcorrectedFile" class="btn btn-success"><i
                                                                class="fas fa-file-upload"></i> Upload</button>
                                                        <div class="progress d-none">
                                                            <div class="progress-bar bg-primary progress-bar-striped Uploadprogress"
                                                                id="Uploadprogress" role="progressbar" aria-valuenow="40"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                                <!--<span class="sr-only">40% Complete (success)</span>-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h4 class="text-success d-none" id="certificateSubmittedLable">
                                                        Certificate Submitted</h4>
                                                    <button class="btn btn-primary complCertificate d-none"><i
                                                            class="fa fa-check"></i> Complete Certificate</button>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="fileShowUi d-none" style=" height: 200px;">
                                                                <hr>
                                                                <a data-toggle="tooltip" data-placement="top"
                                                                    title="Click to view file" id="fileuploadedPath" href=""
                                                                    target="_blank">
                                                                    <p>Drafted Certificate</p>
                                                                    <img id="drafted_cert_view" class="img-fluid rounded" alt="PDF"
                                                                        style="width: 128px; height: 128px;"
                                                                        src="/dist/img/pdf-view.png"
                                                                        data-holder-rendered="true">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="originalCertificateShowUi d-none"
                                                                style=" height: 200px;">
                                                                <hr>
                                                                <a data-toggle="tooltip" data-placement="top"
                                                                    title="Click to view file" id="originalCertificatePath"
                                                                    href="" target="_blank">
                                                                    <p>Original Certificate</p>
                                                                    <img id="original_cert_view" class="img-fluid rounded" alt="PDF"
                                                                        style="width: 128px; height: 128px;"
                                                                        src="/dist/img/pdf-view.png"
                                                                        data-holder-rendered="true">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="correctedFileShowUi d-none" style=" height: 200px;">
                                                                <hr>
                                                                <a data-toggle="tooltip" data-placement="top"
                                                                    title="Click to view file" id="correctedCertificatePath"
                                                                    href="" target="_blank">
                                                                    <p>Corrected File</p>
                                                                    <img class="img-fluid rounded" id="file_view" alt="PDF"
                                                                        style="width: 128px; height: 128px;"
                                                                        src=""
                                                                        data-holder-rendered="true">
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
                        <div class="tab-pane fade" id="custom-tabs-three-userDataTab" role="tabpanel"
                            aria-labelledby="custom-tabs-three-userDataTab-tab">
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
                                                        <b>Registration No</b> <a
                                                            class="float-right tabf_industry_registration_no"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Industry Category</b> <a
                                                            class="float-right tabf_industry_cat_name"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Business Scale</b> <a
                                                            class="float-right tabf_business_scale"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>PradesheeyaSaba</b> <a
                                                            class="float-right tabf_pradesheeyasaba"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Start Date</b> <a
                                                            class="float-right tabf_industry_start_date"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Investment</b> <a
                                                            class="float-right tabf_industry_investment"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Address</b> <a class="float-right tabf_industry_address"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Contact No</b> <a
                                                            class="float-right tabf_industry_contact_no"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Email</b> <a class="float-right tabf_industry_email"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Environment Officer</b> <a
                                                            class="float-right tabf_environment_officer"></a>
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
    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <script src="../../js/CertificatePreferJS/certificate_perf.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script>
        var PROFILE_ID = '{{ $id }}';
        var FILE_STATUS = '';
        var CER_STATUS = '';
        var CERTIFICATE_ID = '';
        $(function() {
            //Load table
            getaProfilebyId(PROFILE_ID, function(parameters) {
                FILE_STATUS = parseInt(parameters.file_status);
                CER_STATUS = parseInt(parameters.cer_status);
                
                setProfileDetails(parameters);
                setIndustryAndClientDb(parameters);
                $(".loadingRenderUI").remove(); //<--Check Loading Status
                //Control Gen Certificate Btn View
                if (FILE_STATUS === 6 && CER_STATUS === 6) {
                    $(".genCertificateNum").remove();
                }
            });
        });

        //Show Certificate Details
        getCertificateDetails(PROFILE_ID, function(resp) {
            if (resp.length != 0) {
                FILE_STATUS = parseInt(resp.client.file_status);
                CERTIFICATE_ID = parseInt(resp.id);
            }
        });

        //Gen Certificate Number
        $('.genCertificateNum').click(function() {
            if (confirm('Are you sure you want to create certificate number?')) {
                genCertificateNumbyId(PROFILE_ID, function(resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        getCertificateDetails(PROFILE_ID, function(resp) {
                            CERTIFICATE_ID = parseInt(resp.id);
                        });
                    }
                });
            }
        });

        $('.navToFile1').click(function() {
            //        $('.fileUpDiv').removeClass('d-none');
            $('#issue_date', '#expire_date').val('');
            daterangepicker.setValue(null);
        });

        $('#uploadCerfile').click(function() {
            let url_upload = '';
            if (isNaN(CERTIFICATE_ID)) {
                alert('Certificate ID Error!');
                return false;
            }
            let file = $('#fileUploadInput')[0].files[0];
            let DATA = {
                file: file
            };
            if ($('#fileUploadInput')[0].files.length === 0) {
                alert('No File Selected!');
                return false;
            }
            if (FILE_STATUS == 5) {
                url_upload = '/api/certificate/original/';
                DATA['issue_date'] = $('#issue_date').val().trim();
                DATA['expire_date'] = $('#expire_date').val().trim();
                if (DATA.issue_date.length == 0 || DATA.expire_date.length == 0) {
                    alert('Invalid Date !');
                    return false
                }
            } else if (FILE_STATUS == 2) {
                url_upload = '/api/certificate/draft/';

            }
            
            submitDataWithFile(url_upload + CERTIFICATE_ID, DATA, function(resp) {
                show_mesege(resp);
                if (resp.id == 1) {
                    getCertificateDetails(PROFILE_ID, function(resp) {
                        CERTIFICATE_ID = parseInt(resp.id);
                        FILE_STATUS = parseInt(resp.client.file_status);
                        $('#fileUploadInput').val('');
                    });
                }
            });
        });

        $('#uploadcorrectedFile').click(function() { //upload corrected file
            let url_upload = '';
            if (isNaN(CERTIFICATE_ID)) {
                alert('Certificate ID Error!');
                return false;
            }
            let file = $('#correctedFile')[0].files[0];
            let DATA = {
                file: file
            }
            if ($('#correctedFile')[0].files.length === 0) {
                alert('No File Selected!');
                return false;
            }
            url_upload = '/api/certificate/corrected_file/';
            submitDataWithFile(url_upload + CERTIFICATE_ID, DATA, function(resp) {
                show_mesege(resp);
                if (resp.id == 1) {
                    getCertificateDetails(PROFILE_ID, function(resp) {
                        CERTIFICATE_ID = parseInt(resp.id);
                        FILE_STATUS = parseInt(resp.client.file_status);
                        $('#correctedFile').val('');
                    });
                } else {
                    // show errors

                    // location.reload();
                }
            });
            
        });

        $('.complCertificate').click(function() {
            if (confirm('Are you sure you want to complete this certificate?')) {
                var dataB = {
                    issue_date: $('#issue_date').val().trim(),
                    expire_date: $('#expire_date').val().trim()
                };
                completeCertificateAPI(CERTIFICATE_ID, FILE_STATUS, dataB, function(resp) {
                    show_mesege(resp);
                    // if (resp.id === 1) {
                    //     window.location.href = "/industry_profile/id/" + PROFILE_ID;
                    // }
                    $('#certificateSubmittedLable').removeClass('d-none');
                    $('.complCertificate').addClass('d-none');
                    
                    getCertificateDetails(PROFILE_ID, function(resp) {
                        CERTIFICATE_ID = parseInt(resp.id);
                        FILE_STATUS = parseInt(resp.client.file_status);
                    });
                });
            }
        });

        $('#issue_date').on('change', function() { //<--On change issue date configer expire date
            var issueDate = new Date($(this).val());
            console.log(issueDate);
            var year = issueDate.getFullYear() + 1;
            var month = issueDate.getMonth() + 1;
            var date = issueDate.getDate();
            var expireDate = year + "-" + ('0' + month).slice(-2) + "-" + ('0' + date).slice(-2);
            console.log(expireDate);
            $('#expire_date').val(expireDate);
        });

        $('#expire_date').on('change', function() {
            console.log($(this).val());
            console.log($('#issue_date').val());
        });

        // $('input[name="datepickerUi"]').daterangepicker({
        //     singleDatePicker: true,
        //     locale: {
        //         format: 'YYYY-MM-DD'
        //     }
        // });

        $('#save_man_ref_no').click(function() {
            const data = {
                cert_id: CERTIFICATE_ID,
                cert_ref_no: $('#man_cert_ref_no').val()
            };

            if (data['cert_id'] != '' && data['cert_ref_no'] != '') {
                ajaxRequest('POST', "/api/save_reference_no", data, function(resp) {
                    if (resp.status == 1) {
                        swal.fire('success', 'Reference Number Saved Successfully', 'success');
                        $('#man_cert_ref_no').val('');
                        getCertificateDetails(PROFILE_ID)
                    } else {
                        swal.fire('Failed', 'Reference Number Saving was Successfully', 'error');
                    }
                });
            } else {
                swal.fire('Failed', 'Please enter reference no to save', 'error');
            }
        });
    </script>
@endsection
