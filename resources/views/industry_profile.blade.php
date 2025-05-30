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
                        <h1>Industry Profile - <span class="right badge badge-primary is_oldProf">-</span>
                            {{ $client->file_no }}</h1>
                    </div>
                </div>
            </div>
        </section>
        <!--//Tab Section START//-->
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
                            <a class="nav-link oldAttachTab" id="custom-tabs-three-profile-tab" data-toggle="pill"
                                href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile"
                                aria-selected="false">Attachments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link profileListTab" id="custom-tabs-three-profileListTab-tab" data-toggle="pill"
                                href="#custom-tabs-three-profileListTab" role="tab"
                                aria-controls="custom-tabs-three-profileListTab" aria-selected="false">Issued List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link userDataTab" id="custom-tabs-three-userDataTab-tab" data-toggle="pill"
                                href="#custom-tabs-three-userDataTab" role="tab"
                                aria-controls="custom-tabs-three-userDataTab" aria-selected="false">Profile Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link profileSettingsTab" id="custom-tabs-three-profileSettingsTab-tab"
                                data-toggle="pill" href="#custom-tabs-three-profileSettingsTab" role="tab"
                                aria-controls="custom-tabs-three-profileSettingsTab" aria-selected="false">Profile
                                Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link siteInspectionTab" id="custom-tabs-three-siteInspectionTab-tab"
                                data-toggle="pill" href="#custom-tabs-three-siteInspectionTab" role="tab"
                                aria-controls="custom-tabs-three-siteInspectionTab" aria-selected="false">Site
                                Inspection</a>
                        </li>
                        <!--                <li class="nav-item">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <a class="nav-link locationTab" id="custom-tabs-three-locationTab-tab" data-toggle="pill" href="#custom-tabs-three-locationTab" role="tab" aria-controls="custom-tabs-three-locationTab" aria-selected="false">Location</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </li>-->
                        <li class="nav-item">
                            <a class="nav-link paymentsTab" id="custom-tabs-three-paymentsTab-tab" data-toggle="pill"
                                href="#custom-tabs-three-paymentsTab" role="tab"
                                aria-controls="custom-tabs-three-paymentsTab" aria-selected="false">Payments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link minutesTab" id="custom-tabs-three-minutesTab-tab" data-toggle="pill"
                                href="#custom-tabs-three-minutesTab" role="tab"
                                aria-controls="custom-tabs-three-minutesTab" aria-selected="false">Minutes</a>
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
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card card-gray">
                                                        <div class="card-header">
                                                            <h3 class="card-title"><i class="fas fa-address-card"></i>
                                                                Services</h3>
                                                        </div>
                                                        <!-- /.card-header -->

                                                        <div class="card-body">
                                                            <div class="newEPL d-none info-box mb-3 bg-success">
                                                                <span class="info-box-icon">
                                                                    <button class="btn btn-lg btn-default"
                                                                        id="newEPL"><i
                                                                            class="fa fa-plus"></i></button></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Create new environment
                                                                        protection<br> license file</span>
                                                                    <span class="info-box-number">New EPL</span>
                                                                </div>
                                                                <!-- /.info-box-content -->
                                                            </div>
                                                            <div class="viewEPL info-box mb-3 bg-success d-none">
                                                                <span class="info-box-icon">
                                                                    <a class="btn btn-lg btn-default" href=""
                                                                        id="setEPlLink"><i
                                                                            class="fa fa-plus"></i></a></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Environment protection<br>
                                                                        license file</span>
                                                                    <span class="info-box-number">View <a
                                                                            id="setEPLCode"></a></span>
                                                                </div>
                                                                <!-- /.info-box-content -->
                                                            </div>

                                                            <div class="info-box mb-3 bg-success setSiteClear d-none">
                                                                <span class="info-box-icon">
                                                                    <a class="btn btn-lg btn-default" id="setSiteClear"><i
                                                                            class="fa fa-plus"></i></a></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">View site clearance
                                                                        file</span>
                                                                    <span class="info-box-number" id="">View <a
                                                                            id="setSiteCleanceCode"></a></span>
                                                                </div>
                                                                <!-- /.info-box-content -->
                                                            </div>
                                                            <div class="info-box mb-3 bg-info newSiteClear d-none">
                                                                <span class="info-box-icon">
                                                                    <button class="btn btn-lg btn-default"
                                                                        id="newSiteClear"><i
                                                                            class="fa fa-plus"></i></button></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Create new site clearance
                                                                        file</span>
                                                                    <span class="info-box-number" id="">New Site
                                                                        Clearance</span>
                                                                </div>
                                                                <!-- /.info-box-content -->
                                                            </div>

                                                            <div class="info-box mb-3 bg-info">
                                                                <span class="info-box-icon">
                                                                    <button class="btn btn-lg btn-default"
                                                                        id="scheduleWaste"><i
                                                                            class="fa fa-plus"></i></button></span>

                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">Create new schedule
                                                                        waste<br> management certificate</span>
                                                                    <span class="info-box-number">Schedule Waste</span>
                                                                </div>
                                                                <!-- /.info-box-content -->
                                                            </div>

                                                        </div>
                                                        <!-- /.card-body -->

                                                        <div class="serviceSectionCnf dark">
                                                            <a class="text-white">Not Allowed To Add New EPL For Old
                                                                Profile!</a>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="text-center" id="fileQr">
                                                                {!! $qrCode !!}
                                                                <br>
                                                                <span
                                                                    style="font-size: 1.6em;">{{ $client->file_no }}</span>
                                                            </div>
                                                            <button class="btn btn-sm btn-dark" type="button"
                                                                id="printQr"><i class="fa fa-qrcode"></i> Print</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-8">
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
                                                        @if ($client->file_problem_status_description != null)
                                                            {{ $client->file_problem_status_description }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card card-gray">
                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <i class="fas fa-address-card"></i> Details
                                                    </h3>
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">

                                                    <span style='font-size: 18px; color: green'><b>Industry
                                                            Details</b></span>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="text-success">File Status:<small><b
                                                                        class="setCurrentFstatus"></b></small></h5>
                                                            <h6 id="env_firstname"><b>Environment Officer: </b><a
                                                                    class="text-danger">Not Assigned</a></h6>
                                                            <dl class="row">
                                                                <dt class="col-sm-4">Name : </dt>
                                                                <dd class="col-sm-6" id="obj_name"></dd>
                                                                <dt class="col-sm-4">BR No:</dt>
                                                                <dd class="col-sm-6" id="obj_regno"></dd>
                                                                <dt class="col-sm-4">Investment :(RS)</dt>
                                                                <dd class="col-sm-6" id="obj_invest"></dd>
                                                                <dt class="col-sm-4">Industry Address :</dt>
                                                                <dd class="col-sm-6" id="obj_industrySub"></dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <span style='font-size: 18px; color: green'><b>Client
                                                            Details</b></span>
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <dl class="row">
                                                                <dt class="col-sm-4">Client Name:</dt>
                                                                <dd class="col-sm-6" id="client_name"></dd>
                                                                <dt class="col-sm-4">Client Address:</dt>
                                                                <dd class="col-sm-6" id="client_address"></dd>
                                                                <dt class="col-sm-4">Client Contact No:</dt>
                                                                <dd class="col-sm-6" id="client_cont"></dd>
                                                                <dt class="col-sm-4">Client Contact Email:</dt>
                                                                <dd class="col-sm-6" id="client_amil"></dd>
                                                            </dl>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <dt>Download & Upload Application :</dt>

                                                    <a href="" class="btn btn-dark navToFile1"
                                                        target="_blank">View Road
                                                        Map</a>
                                                    <a href="" class="btn btn-dark navToFile2"
                                                        target="_blank">View Deed of
                                                        the land</a>
                                                    <a href="" class="btn btn-dark navToFile3"
                                                        target="_blank">View Survey
                                                        Plan</a>

                                                    <button type="button" class="btn btn-primary d-none"
                                                        data-upload_file="Road Map" id="upld_roadMap">Upload Road
                                                        Map</button>
                                                    <button type="button" class="btn btn-primary d-none"
                                                        data-upload_file="Deed Of The Land" id="upld_deed">Upload Deed of
                                                        the land </button>
                                                    <button type="button" class="btn btn-primary d-none"
                                                        data-upload_file="Survey Plan" id="upld_SurveyPlan">Upload Survey
                                                        Plan</button>
                                                    <div class="form-group d-none" id="fileUpDiv">
                                                        <hr>
                                                        <label id="uploadLabel">File Upload </label>
                                                        <input id="fileUploadInput" type="file" class=""
                                                            accept="image/*, .pdf">
                                                        <div class="progress d-none">
                                                            <div class="progress-bar bg-primary progress-bar-striped Uploadprogress"
                                                                id="Uploadprogress" role="progressbar" aria-valuenow="40"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                                <!--<span class="sr-only">40% Complete (success)</span>-->
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><b>Are you sure you want to permanently delete this Item? </b></p>
                                                <p>Once you continue, this process can not be undone. Please Procede with
                                                    care.</p>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-outline-light"
                                                    data-dismiss="modal">Close</button>
                                                <button id="btnDelete" type="submit" class="btn btn-outline-light"
                                                    data-dismiss="modal">Delete Permanently</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </section>
                            <!--//Industry Profile END//-->
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel"
                            aria-labelledby="custom-tabs-three-profile-tab">
                            <!--//Old Attachments Start//-->
                            <div class="col-md-12">
                                <div class="card card-gray">
                                    <div class="card-header">
                                        <h3 class="card-title">Attachments</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group col-4">
                                            <label>Description: </label>
                                            <input id="getDesc" type="text" maxlength="45"
                                                class="form-control form-control-sm" placeholder="Enter Description..."
                                                value="">
                                        </div>
                                        <div class="row">
                                            <div class="form-group uploadAttachments m-3">
                                                <label>Upload: </label><br>
                                                <input id="otherFiles" accept="image/*,application/pdf" type="file">
                                                @if ($pageAuth['is_create'] == 1 || false)
                                                    <button disabled id="btnUpload" type="submit"
                                                        class="btn btn-success">Upload</button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row injectViewAttachs" style="height: 450px; overflow-y: auto;">

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
                                            <h4 class="text-success">File Checked And Confirmed <i
                                                    class="fa fa-check-circle"></i></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--//Old Attachments END//-->
                        </div>
                        <!--//All Profile Open//-->
                        <div class="tab-pane fade" id="custom-tabs-three-profileListTab" role="tabpanel"
                            aria-labelledby="custom-tabs-three-profileListTab-tab">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-gray">
                                            <div class="card-header">
                                                <h3 class="card-title">EPL</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                        data-card-widget="collapse"><i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body" style="display: block;">
                                                <table class="table table-active" id="clientEplList">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>EPL Code</th>
                                                            <th>Certificate Number</th>
                                                            <th>Reference No</th>
                                                            <th>Issue Date</th>
                                                            <th>Expire Date</th>
                                                            <!--<th>Action</th>-->
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-gray">
                                            <div class="card-header">
                                                <h3 class="card-title">Site Clearance</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                        data-card-widget="collapse"><i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body" style="display: block;">
                                                <table class="table table-active" id="clientSiteclearList">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Site Clearance Code</th>
                                                            <th>Issued Date</th>
                                                            <th>Expired Data</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($siteClearance as $sc)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td><a
                                                                        href="{{ route('site_clearance.index', [$id, $sc->site_clearence_session_id]) }}">{{ $sc->session_code }}</a>
                                                                </td>
                                                                <td>:{{ empty($sc->issue_date) ? '-' : Carbon\carbon::parse($sc->issue_date)->format('Y-m-d') }}
                                                                </td>
                                                                <td>{{ empty($sc->expire_date) ? '-' : Carbon\carbon::parse($sc->expire_date)->format('Y-m-d') }}
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4">No certificates available</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-gray">
                                            <div class="card-header">
                                                <h3 class="card-title">Telecommunication Site Clearance</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                        data-card-widget="collapse"><i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body" style="display: block;">
                                                No data found
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card card-gray">
                                            <div class="card-header">
                                                <h3 class="card-title">Schedule Waste</h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool"
                                                        data-card-widget="collapse"><i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-body" style="display: block;">
                                                No data found
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--//All Profile END//-->
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
                                                        <b>Started Date</b> <a class="float-right assign_date">-</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Address</b> <a class="float-right cl_address">-</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Email</b> <a class="float-right cl_email">-</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Contact No</b> <a class="float-right cl_contact_no">-</a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>NIC</b> <a class="float-right cl_nic">-</a>
                                                    </li>
                                                </ul>
                                                <a href="/file_summary/{{ $id }}" target="_blank"
                                                    class="btn btn-primary"><i class="fa fa-print"></i> Print File
                                                    Summary</a>
                                                <a href="/attachments/{{ $id }}" target="_blank"
                                                    class="btn btn-primary">Download All Attachments</a>
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
                                                        <b>BR No</b> <a
                                                            class="float-right tabf_industry_registration_no"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Industry Category</b> <a
                                                            class="float-right tabf_industry_cat_name"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Industry Sub-Category</b> <a
                                                            class="float-right tabf_subindustry_cat"></a>
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
                                                        <b>Investment(Rs)</b> <a
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
                                    <div class="col-md-12">
                                        <div id="map" style="width: 100%; height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--//All User Data END//-->
                        <!--//All User Profile Settings Open//-->
                        <div class="tab-pane fade" id="custom-tabs-three-profileSettingsTab" role="tabpanel"
                            aria-labelledby="custom-tabs-three-profileSettingsTab-tab">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="callout callout-danger">
                                                    <h4>Inspection Status: <a class="setupInspectStatus text-success"></a>
                                                    </h4>
                                                    <button type="button" onclick="location.href = '';"
                                                        class="btn btn-dark addToSiteIns d-none" data-dismiss="modal"><i
                                                            class="fa fa-plus"></i>&nbsp Add To Site Inspection</button>
                                                    <button type="button" value="needed"
                                                        class="btn btn-info setInspectUI d-none"><i
                                                            class="fa fa-plus"></i>&nbsp Set Inspection</button>
                                                    <button type="button" value="no_needed"
                                                        class="btn btn-warning noNeedInspect d-none"><i
                                                            class="fa fa-exclamation"></i>&nbsp No Need Inspection</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="callout callout-info">
                                                    <dt>Update Uploaded Applications :</dt>
                                                    <button type="button" class="btn btn-warning upld_roadMap"
                                                        data-upload_file="Road Map">Update Road Map</button>
                                                    <button type="button" class="btn btn-warning upld_deed"
                                                        data-upload_file="Deed Of The Land">Update Deed of the land
                                                    </button>
                                                    <button type="button" class="btn btn-warning upld_SurveyPlan"
                                                        data-upload_file="Survey Plan">Update Survey Plan</button>
                                                    <div class="form-group fileUpDiv d-none">
                                                        <hr>
                                                        <label class="uploadLabel">File Upload </label>
                                                        <input type="file" class="fileUploadInput"
                                                            accept=".png,.jpg,.jpeg, .pdf">
                                                        <div class="progress d-none">
                                                            <div class="progress-bar bg-primary progress-bar-striped Uploadprogress"
                                                                role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                                                aria-valuemax="100" style="width: 0%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="callout callout-info">
                                                    <dt>Deed List :</dt>
                                                    <div class="deedListUsr">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="callout callout-danger">
                                                    <button type="button" onclick="location.href = '/epl_assign';"
                                                        class="btn btn-dark" data-dismiss="modal">Assign/Change
                                                        Environment
                                                        Officer</button>
                                                    <!--<p>There is a problem that we need to</p>-->
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="callout callout-danger">
                                                    <button type="button" class="btn btn-danger reportIssueView"><i
                                                            class="fa fa-file"></i> Report Problem</button>
                                                    <button type="button"
                                                        class="btn btn-success markIssueClean d-none"><i
                                                            class="fa fa-file"></i> Mark Problem Cleared</button>
                                                    <div class="reportView d-none">
                                                        <div class="form-group">
                                                            <label>Report File Problem</label>
                                                            <textarea class="form-control" id="reportTxtArea" rows="3" placeholder="Enter ..." autocomplete="off"></textarea>
                                                        </div>
                                                        {{-- <div class="form-group">
                                                            <hr>
                                                            <input id="problemFileUpload" type="file" class=""
                                                                accept="image/*, .pdf">
                                                            <div class="progress d-none">
                                                                <div class="progress-bar bg-primary progress-bar-striped Uploadprogress"
                                                                    id="Uploadprogress" role="progressbar"
                                                                    aria-valuenow="40" aria-valuemin="0"
                                                                    aria-valuemax="100" style="width: 0%">
                                                                    <!--<span class="sr-only">40% Complete (success)</span>-->
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                        <div class="form-group">
                                                            <button type="button" id="reportSubmit"
                                                                class="btn btn-success"><i class="fa fa-check"></i>
                                                                Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="callout callout-danger">
                                                    <button type="button" id="removeFileBtn" class="btn btn-danger"><i
                                                            class="fas fa-times"></i> Remove File</button>
                                                    <a href="/update_client/id/{{ $id }}"
                                                        class="btn btn-warning"><i class="far fa-edit"></i> Update This
                                                        Client</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="callout callout-success">
                                                    <a href="{{ route('create.file.letter', [$id]) }}"
                                                        class="btn btn btn-primary text-white"
                                                        style="text-decoration: none" target="_blank"><i
                                                            class="far fa-edit"></i> New Letter</a>
                                                    <a href="{{ route('file.letter.view', [$id]) }}"
                                                        class="btn btn-success text-white" style="text-decoration: none"
                                                        target="_blank"><i class="far fa-file"></i> View Letters</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="callout callout-danger">
                                                    <a href="{{ route('set-profile-payments', [$id]) }}"
                                                        class="btn btn btn-info text-white" style="text-decoration: none"
                                                        target="_blank"><i class="fa fa-plus"></i>&nbsp Set Payments</a>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($oldOwnerDetails)
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="callout callout-info">
                                                        <h4>Old Profile Details</h4>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <table class="table border">
                                                                    <tr>
                                                                        <th colspan="2">
                                                                            <h5>Client Details</h5>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <td>{{ $oldOwnerDetails->name_title }}
                                                                            {{ $oldOwnerDetails->first_name }}
                                                                            {{ $oldOwnerDetails->last_name }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Address</th>
                                                                        @if ($oldOwnerDetails->address)
                                                                            <td>{{ $oldOwnerDetails->address }}</td>
                                                                        @else
                                                                            <td>-</td>
                                                                        @endif
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Email</th>
                                                                        @if ($oldOwnerDetails->email)
                                                                            <td>{{ $oldOwnerDetails->email }}</td>
                                                                        @else
                                                                            <td>-</td>
                                                                        @endif
                                                                    </tr>
                                                                    <tr>
                                                                        <th>NIC</th>
                                                                        @if ($oldOwnerDetails->nic)
                                                                            <td>{{ $oldOwnerDetails->nic }}</td>
                                                                        @else
                                                                            <td>-</td>
                                                                        @endif
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Contact Number</th>
                                                                        @if ($oldOwnerDetails->contact_no)
                                                                            <td>{{ $oldOwnerDetails->contact_no }}</td>
                                                                        @else
                                                                            <td>-</td>
                                                                        @endif
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <table class="table border">
                                                                    <tr>
                                                                        <th colspan="2">
                                                                            <h5>Industry Details</h5>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Industry Name</th>
                                                                        <td>{{ $oldOwnerDetails->industry_name }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Industry Contact Number</th>
                                                                        @if ($oldOwnerDetails->industry_contact_no)
                                                                            <td>{{ $oldOwnerDetails->industry_contact_no }}
                                                                            </td>
                                                                        @else
                                                                            <td>-</td>
                                                                        @endif
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Industry Address</th>
                                                                        <td>{{ $oldOwnerDetails->industry_address }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Industry Email</th>
                                                                        @if ($oldOwnerDetails->industry_email)
                                                                            <td>{{ $oldOwnerDetails->industry_email }}</td>
                                                                        @else
                                                                            <td>-</td>
                                                                        @endif
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--//All Profile Settings END//-->
                        </div>
                        <!--//All User Site Inspection Open//-->
                        <div class="tab-pane fade" id="custom-tabs-three-siteInspectionTab" role="tabpanel"
                            aria-labelledby="custom-tabs-three-siteInspectionTab-tab">
                            <div class="col-md-12">
                                <div class="card card-gray">
                                    <div class="card-header">
                                        <h3 class="card-title">All Site Inspections</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="card-body table-responsive" style="height: 450px;">
                                            <table class="table table-condensed" id="tblAllInspections">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>Status</th>
                                                        <th>Schedule Date</th>
                                                        <th style="width: 140px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                        <!--//Location Open//-->
                        <div class="tab-pane fade" id="custom-tabs-three-locationTab" role="tabpanel"
                            aria-labelledby="custom-tabs-three-locationTab-tab">
                            <div class="col-md-12">
                                <div id="map" style="width: 100%; height: 400px;"></div>
                            </div>
                        </div>
                        <!--//Payments Open//-->
                        <div class="tab-pane fade" id="custom-tabs-three-paymentsTab" role="tabpanel"
                            aria-labelledby="custom-tabs-three-paymentsTab-tab">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card card-gray">
                                        <div class="card-header">
                                            <h3 class="card-title">All Payment Details</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="card-body table-responsive" style="height: 450px;">
                                                <table class="table table-condensed" id="tblAllPayments">

                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Cashier Name</th>
                                                            <th>Invoice No</th>
                                                            <th>Status</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card card-gray">
                                        <div class="card-header">
                                            <h3 class="card-title">Online Payment History</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            @if ($onlineTransactions->isEmpty())
                                                <div class="alert alert-primary m-3" role="alert">
                                                    <span class="fa fa-info-circle"></span> No Online Payment Records
                                                </div>
                                            @else
                                                <div class="card-body table-responsive" style="height: 450px;">
                                                    <table class="table table-condensed" id="onlinePaymentRecords">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Invoice No</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $i = 1;
                                                            @endphp
                                                            @foreach ($onlineTransactions as $onlineTransaction)
                                                                @foreach ($onlineTransaction->transactionItems as $transactionItem)
                                                                    <tr>
                                                                        <td>{{ $i++ }}</td>
                                                                        <td>{{ $onlineTransaction->invoice_no }}</td>
                                                                        <td>
                                                                            @if ($onlineTransaction->status == 1)
                                                                                Complete
                                                                            @elseif($onlineTransaction->status == 0)
                                                                                Pending
                                                                            @elseif ($onlineTransaction->status == 3)
                                                                                Cancelled
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ $transactionItem->amount }}</td>
                                                                        <td>{{ Carbon\Carbon::parse($onlineTransaction->created_at)->format('Y-m-d') }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--//minutesTab Open//-->
                        <div class="tab-pane fade" id="custom-tabs-three-minutesTab" role="tabpanel"
                            aria-labelledby="custom-tabs-three-minutesTab-tab">
                            <div class="col-md-12">
                                <div class="col-md-12 loadMinCard" id="printable_minutes">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="overlay dark loadingRenderUI">
            <i class="fas fa-2x fa-sync-alt"></i>
        </div> --}}
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
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../js/commonFunctions/file_upload.js" type="text/javascript"></script>
    <script src="../../js/IndustryProfileJS/industry_profile.js" type="text/javascript"></script>
    <script src="../../js/IndustryProfileJS/upload_old_attachment.js" type="text/javascript"></script>
    <script src="../../js/MinuteJS/minute_data_s.js" type="text/javascript"></script>
    <!-- AdminLTE App -->

    <script type="text/JavaScript" src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.0/jQuery.print.js"></script>

    <script async="" defer=""
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyaUNtnrMrJwLqWQmHoUbeHaLk6q4msXE&callback=initMap"></script>
    <script>
        PROFILE_ID = '{{ $id }}';
       const FILE_BASE_PATH = '{{ env('DO_URL') }}/';
        var FILE_DETAILS = null;
        $(function() {
            $(".loadingRenderUI").remove();
            $('.minutesTab').click(function() { //<--load min when click on min tab
                getCardOfTableUI();
            });
            $('.paymentsTab').click(function() { //<--load min when click on payment tab
                pendingPaymentsTable(PROFILE_ID); //<-- Load pending payment table
            });
            deedList(PROFILE_ID, FILE_BASE_PATH);
            getaProfilebyId(PROFILE_ID, function(parameters) {
                FILE_DETAILS = parameters;
                setCurrentFileStatus(parameters);
                setProfileDetails(parameters,FILE_BASE_PATH);
                setIndustryAndClientDb(parameters);
                updateAttachmentData(parameters);
                $(document).on('click', '.oldAttachTab', function() {
                    loadAllOldAttachments(parameters.old_files, FILE_BASE_PATH);
                });
                oldFileConfirmSection(parameters.is_old);
                checkEPLstatus(parameters.epls);
                loadAllEPLTable({
                    epls: parameters.epls,
                    certificates: parameters.certificates
                });
                // loadAllSiteClearTable(parameters.site_clearence_sessions);
                setupInspectionUI(parameters.need_inspection);
                checkFileIssueStatus(parameters);
                checkCompletedStatus(parameters.file_status, parameters.epls, parameters
                    .site_clearence_sessions);
                // $(".loadingRenderUI").remove(); //<--Check Loading Status
            });

            //trigger barcode print
            $(document).on('click', '#printQr', function() {
                $('#fileQr').print({
                    mediaPrint: true
                });
            });

            $('#newEPL').click(function() {
                if (isNaN(parseInt(PROFILE_ID))) {
                    return false;
                }
                window.location = "/epl_register/id/" + PROFILE_ID + "/type/epl";
            });
            $('#newSiteClear').click(function() {
                if (isNaN(parseInt(PROFILE_ID))) {
                    return false;
                }
                window.location = "/epl_register/id/" + PROFILE_ID + "/type/site_clearance";
            });
            //new
            $('#upld_roadMap, #upld_deed, #upld_SurveyPlan').click(function() {
                $('#uploadLabel').html('Select ' + $(this).data('upload_file') + ' File To Upload');
                $('#fileUploadInput').data('fileType', $(this).data('upload_file'));
                $('#fileUpDiv').removeClass('d-none');
            });
            $('.upld_roadMap, .upld_deed, .upld_SurveyPlan').click(function() {
                $('.uploadLabel').html('Select ' + $(this).data('upload_file') + ' File To Upload');
                $('.fileUploadInput').data('fileType', $(this).data('upload_file'));
                $('.fileUpDiv').removeClass('d-none');
            });
            //file upload click
            $('#fileUploadInput , .fileUploadInput').change(function() {
                if (!confirm('Are you sure you want to save this attachment?')) {
                    return false;
                }
                let uploadFileType = $(this).data('fileType');
                let formData = new FormData();
                let fileCat = '';
                // populate fields
                let file = $(this)[0].files[0]; // file
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
                ulploadFile2('/api/epl/upload/epl/' + PROFILE_ID + '/file/' + fileCat, formData, function(
                    parameters) {
                    show_mesege(parameters);
                    getaProfilebyId(PROFILE_ID, function(result) {
                        setProfileDetails(result,FILE_BASE_PATH);
                    });
                    deedList(PROFILE_ID,FILE_BASE_PATH, function() {
                        $('.fileUploadInput').val('');
                    });
                });
            });
        });
        //btnCustomerVa button action
        $(document).on('click', '.btnCustomerVa', function() {
            var row = JSON.parse(decodeURIComponent($(this).data('row')));
            setClientDetails(row);
            setSectionVisible('view-Client');
        });

        function disWarnPay() {
            toastr.error('Assign Environment Officer & Try Again!');
        }
        //Upload Old Attachments
        $('#btnUpload').click(function() {
            var file = $('#otherFiles')[0].files[0];
            var descrip = $('#getDesc').val();
            uploadOldAttacments(PROFILE_ID, 'file', file, descrip, function(result) {
                show_mesege(result);
                if (result.id == 1) {
                    $('#getDesc').val('');
                    $('#otherFiles')[0].files[null];
                }
                getaProfilebyId(PROFILE_ID, function(parameters) {
                    loadAllOldAttachments(parameters.old_files, FILE_BASE_PATH);
                });
            });
        });
        //Remove Old Attachments
        $(document).on('click', '.removeAttachs', function() {
            if (confirm('Do you sure!')) {
                alert('File will be Removed!');
                var getRemoveId = $(this).attr('id');
                deleteOldAttachments(getRemoveId, function(result) {
                    show_mesege(result);
                    getaProfilebyId(PROFILE_ID, function(parameters) {
                        loadAllOldAttachments(parameters.old_files, FILE_BASE_PATH);
                    });
                });
            } else {
                alert('You have cancelled!');
            }
        });
        //Confirm Button
        $('#btnConfirm').click(function() {
            if (FILE_DETAILS.epls.length == 0 && FILE_DETAILS.site_clearence_sessions.length == 0) {
                alert('Please enter EPL or Site Clearance Details First!');
                return false;
            }
            if (confirm("Not able to be reversed! Are you sure?")) {
                ConfirmUploadingAttachs(PROFILE_ID, function(respo) {
                    show_mesege(respo);
                    if (respo.id == 1) {
                        location.reload();
                    }
                });
            }
        });

        //Handle Upload Button
        $(document).ready(function() {
            $('#otherFiles').bind('change', function() {
                uploadButtonHandler($('#otherFiles').val());
            });
        });
        $(document).ready(function() {
            $('#otherFiles').bind('change', function() {
                uploadButtonHandler($('#otherFiles').val());
            });
        });
        //Load Inspections//-
        loadAllSiteInspectionTable(PROFILE_ID);
        $('.setInspectUI').on('click', function() {
            checkInspectionStatus(PROFILE_ID, $(this).val(), function(rep) {
                getaProfilebyId(PROFILE_ID, function(parameters) {
                    setupInspectionUI(parameters.need_inspection);
                });
                show_mesege(rep);
            });
            $(this).addClass('d-none');
        });
        $('.noNeedInspect').on('click', function() {
            checkInspectionStatus(PROFILE_ID, $(this).val(), function(rep) {
                getaProfilebyId(PROFILE_ID, function(parameters) {
                    setupInspectionUI(parameters.need_inspection);
                });
                show_mesege(rep);
            });
            $(this).addClass('d-none');
        });
        //Sumbit Report
        $('.reportIssueView').on('click', function() { //<-- Get View to report file
            $(this).addClass('d-none');
            $('.reportView').removeClass('d-none');
        });
        $('#reportSubmit').on('click', function() { // Report Issue Btn
            var data = {
                file_problem_status_description: $('#reportTxtArea').val(),
                file_problem_status: 'problem',
                // file: $('#problemFileUpload')[0].files[0],
                file_catagory: 'PROBLEM'
            };
            reportFileIssueAPI(PROFILE_ID, data, function(resp) {
                show_mesege(resp);
                // // $('.reportView').addClass('d-none');
                // // $('.reportIssueView').addClass('d-none');
                // $('.markIssueClean').removeClass('d-none');
                // getaProfilebyId(PROFILE_ID, function (parameters) {
                //     checkFileIssueStatus(parameters);
                // });
                if (resp.id == 1) {
                    location.reload();
                }
            });
        });
        $('.markIssueClean').on('click', function() { // Mark As Cleared Btn
            var data = {
                file_problem_status: 'clean',
                file_problem_status_description: 'NO-PROBLEM',
                //                                                file: $('#problemFileUpload')[0].files[0],
                file_catagory: 'PROBLEM'
            };
            reportFileIssueAPI(PROFILE_ID, data, function(resp) {
                show_mesege(resp);
                $('.reportIssueView').removeClass('d-none');
                $('.markIssueClean').addClass('d-none');
                getaProfilebyId(PROFILE_ID, function(parameters) {
                    checkFileIssueStatus(parameters);
                });
            });
        });
        $('#removeFileBtn').on('click', function() { // Remove File Btn
            if (confirm('Are you sure you want to remove this file?')) {
                removeClientFileAPI(PROFILE_ID, function(reps) {
                    show_mesege(reps);
                    if (reps.id == 1) {
                        window.location.href = "/";
                    }
                });
            }
        });
        $(document).on('click', '.printBarcode', function() { //<-- Print Bar Code In Payment Tab
            var btnValue = $(this).val();
            var btnName = $(this).data("name");
            toastr.info('Printing Barcode.Please Wait...');

        });
        $(document).on('click', '.removeBarcode', function() { //<-- Remove Button In Payment Tab
            var btnValue = $(this).val();
            if (confirm('Are you sure you want to remove this payment?')) {
                removeEPLPaymentAPI(btnValue, function(resp) {
                    show_mesege(resp);
                    if (resp.id === 1) {
                        pendingPaymentsTable(PROFILE_ID);
                    }
                });
            }
        });
    </script>
@endsection
