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
<style>
    #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
    }
</style>
<!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
@if($pageAuth['is_read']==1 || false)
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h1>File No: (<a href="/industry_profile/id/{{$client}}" class="setFileNoTitile">Loading..</a>) - Site Clearance Number: <span class="right badge badge-primary">{{$code}}</span></h1>
            </div>
        </div>
    </div>
</section>
<section class="conte        nt-header">
    <div class="container-fluid view-Profile">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i> Client Details

                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <h4 class="siteClearType text-success"></h4>
                        <h5 class="processingMethod text-success"></h5>
                        <dt class="">Name : <a id="client_name"></a></dt>            
                        <dt class="">Address : <a id="client_address"></a></dt>
                        <dt class="">Contact Number : <a id="client_cont"></a></dt>
                        <dt class="">Contact Email : <a id="client_amil"></a></dt>
                        <dt class="">NIC : <a id="client_nic"> </a></dt>
                        <hr>
                        <div class="col-md-8">
                            <dt >Industry Name : <a id="obj_name"></a></dt>
                            <dt >Industry Registration No : <a id=" obj_regno"></a></dt>
                            <dt >Industry Code : <a id="obj_code"></a></dt>
                            <dt >Industry Investment :  <a  id="obj_invest"></a></dt>
                            <dt >Industry Remark : <a  id="obj_remark"></a></dt>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>                                                                        
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i> Links
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="height: 350px; overflow-y: scroll;">
                        <div class="callout callout-danger">
                            <h6><a id="disPaylink" href="/epl_payments/id/{{$profile}}/type/site_clearance" class="text-success isOld2">Payments</a></h6>
                            <p>All Payment (EPL, Fine,Inspection Fee, Certificate)</p>
                        </div>
                        <div class="callout callout-danger">
                            <h6><a href="/epl_profile/atachments/{{$profile}}" class="text-success isOld2">Attachments</a></h6>
                            <p>Upload EPL Attachments</p>
                        </div>
                        <div class="callout callout-danger">
                            <h6><a href="/remarks/epl/{{$profile}}" class="text-success isOld2">Remarks</a></h6>
                            <p>Add Comments</p>
                        </div>
                        <div class="callout callout-danger">
                            <h6><a href="/issue_certificate/id/{{$profile}}" class="text-success ">Certificate Information</a></h6>
                            <p>Issue Certificate / Certificate Information</p>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="linkSectionCnf overlay dark">
                        <a class="text-white">File Not Confirmed!</a>
                    </div>

                </div>                                    
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-address-card"></i> EPL Data
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group disType">
                            <input id="currentProStatus" type="text" class="d-none">
                            <label>Processing Type*</label>
                            <select id="setSiteType" class="form-control form-control-sm cutenzReq" style="width: 100%;">
                                <option value="0">Pending</option>
                                <option value="1">Site Clearance</option>
                                <option value="2">EIA</option>
                                <option value="3">IEA</option>
                            </select>
                        </div>
                        <button id="changeProcessingBtn" class="btn btn-dark">Change</button>
                        <hr>
                        <dt>Download Application :</dt>
                        <a href="" class="btn btn-dark navTodownload" target="_blank">View Application</a>

                        <button type="button" class="btn btn-success d-none" data-upload_file="EPL" id="upld_application">Upload Application</button>
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
                <div class="card card-success d-none sectionUploadTor collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Upload TOR</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="form-group">
                            <label>Expire Date*</label>
                            <input id="expireDateTor" type="date" max="2999-12-31" class="form-control form-control-sm" placeholder="Enter Date..." value="">
                        </div>
                        <div class="form-group">
                            <label>Valid Date*</label>
                            <input id="validDateTor" type="date" max="2999-12-31" class="form-control form-control-sm" placeholder="Enter Date..." value="">
                        </div>
                        <div class="form-group">
                            <button id="uploadTOR" type="submit" class="btn btn-success"><i class="fas fa-check"></i> Upload TOR</button>
                        </div>
                    </div>
                </div>

                <div class="card card-success d-none sectionUploadClReport collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Upload Client Report</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <div class="form-group">
                            <label>Expire Date*</label>
                            <input id="expireClientReport" type="date" max="2999-12-31" class="form-control form-control-sm" placeholder="Enter Date..." value="">
                        </div>
                        <div class="form-group" id="fileUpDiv">
                            <hr>
                            <input id="fileUploadInput" type="file" class="" accept="image/*, .pdf">
                            <div class="progress d-none">
                                <div class="progress-bar bg-primary progress-bar-striped Uploadprogress" id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                    <!--<span class="sr-only">40% Complete (success)</span>-->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button id="uploadClReport" type="submit" class="btn btn-success"><i class="fas fa-check"></i> Upload Report</button>
                        </div>
                    </div>
                </div>

                <div class="card card-success d-none sectionArrangeCommittee collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title">Arange Committee</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <a href="/committee/id/{{$profile}}" class="btn btn-success navToCommittee" target="_blank">Add Committee</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endif

@endsection



@section('pageScripts')
<!-- Page script -->

<!-- Select2 -->
<script src="/../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="/../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="/../../plugins/moment/moment.min.js"></script>
<script src="/../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="/../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="/../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="/../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="/../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/../../dist/js/demo.js"></script>
<script src="/../../js/commonFunctions/file_upload.js" type="text/javascript"></script>
<script src="/../../js/EPLProfileJS/submit.js"></script>
<script src="/../../js/EPLProfileJS/get.js"></script>
<script src="/../../js/EPLProfileJS/client_space.js"></script>
<script src="/../../js/EPLProfileJS/update.js"></script>
<script src="/../../js/EPLProfileJS/delete.js"></script>
<script src="/../../js/SiteClearanceJS/site_clearance_scr.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script>
////Map Start    
//// Initialize and add the map
//function initMap(_Latitude, _Longitude) {
//    // The location of CeyTech
//    var defaultLocation = {lat: _Latitude, lng: _Longitude}; //default Location for load map
//
//    // The map, centered at Uluru
//    var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: defaultLocation});
//    // The marker, positioned at Uluru
//    var marker = new google.maps.Marker({position: defaultLocation, map: map, draggable: false, title: "Drag me!"});
//}
////Map END
$(function () {
    var CLIENT = '{{$client}}';
    var PROFILE = '{{$profile}}';
    $('#currentProStatus').val(PROFILE);
//    console.log('cli: ' + CLIENT + ', prof: ' + PROFILE);
    getaClientbyId(CLIENT, function (result) {
        if (result.length == 0 || result == undefined) {
            if (confirm("Client Not Found! Try Again!")) {

            }
        } else {
            setClientDetails(result);
            disableLinkSection(result.is_old);
            checkIsOldTwo(result.is_old);
            $('.setFileNoTitile').html(result.file_no);
            $(".setFileNoTitile").attr("href", "/industry_profile/id/" + CLIENT);
        }
    });

    var SITE_CLEARANCE_STATUS = {0: 'pending', 1: 'site clearance', 2: 'EIA', 3: 'IEA'};
    getSiteClearanceAPI(PROFILE, function (resp) {
        if (resp.site_clearances.length != 0) {
            let cleareance = resp.site_clearances[(resp.site_clearances.length) - 1];
            $('.processingMethod').html('Processing Method:' + SITE_CLEARANCE_STATUS[resp.processing_status]);
            if (resp.processing_status == 2 || resp.processing_status == 3) {
                $('.sectionUploadClReport').removeClass('d-none');
                $('.sectionUploadTor').removeClass('d-none');
                $('.sectionArrangeCommittee').removeClass('d-none');
            } else {
                $('.sectionUploadClReport').addClass('d-none');
                $('.sectionUploadTor').addClass('d-none');
                $('.sectionArrangeCommittee').addClass('d-none');
            }
            $('.navTodownload').attr('href', '/' + cleareance.application_path);
            $('.siteClearType').html(resp.site_clearance_type);
        } else {
        }
    });

    $("#changeProcessingBtn").click(function () {
        var data = {
            status: $('#setSiteType').val()
        };
        if (confirm('Are you sure you want to change?')) {
            setProcessingTypeAPI($('#currentProStatus').val(), data, function (respo) {
                show_mesege(respo);
                getSiteClearanceAPI(PROFILE, function (resp) {
                    if (resp.site_clearances.length != 0) {
                        let cleareance = resp.site_clearances[(resp.site_clearances.length) - 1];
                        $('.processingMethod').html('Processing Method:' + SITE_CLEARANCE_STATUS[resp.processing_status]);
                        if (resp.processing_status == 2 || resp.processing_status == 3) {
                            $('.sectionUploadClReport').removeClass('d-none');
                            $('.sectionUploadTor').removeClass('d-none');
                            $('.sectionArrangeCommittee').removeClass('d-none');
                        } else {
                            $('.sectionUploadClReport').addClass('d-none');
                            $('.sectionUploadTor').addClass('d-none');
                            $('.sectionArrangeCommittee').addClass('d-none');
                        }
                        $('.navTodownload').attr('href', '/' + cleareance.application_path);
                        $('.siteClearType').html(resp.site_clearance_type);
                    } else {
                    }
                });
            });
        }
    });

});
function disWarnPay() {
    toastr.error('Assign Environment Officer & Try Again!');
}
function showNotAvailable() {
    toastr.info('Not Available For Old Files!');
}
</script>
@endsection

