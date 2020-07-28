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
                        <dl>
                            <dt>Name :</dt>
                            <dd id="client_name"></dd>
                            <dt>Address :</dt>
                            <dd id="client_address"></dd>
                            <dt>Contact Number :</dt>
                            <dd id="client_cont"></dd>
                            <dt>Contact Email :</dt>
                            <dd id="client_amil"></dd>
                            <dt>NIC :</dt>
                            <dd id="client_nic"></dd>
                        </dl>
                    </div>
                    <!-- /.card-body -->
                </div>                                    
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i> Site Clearance File
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label>Site Clearance*</label>
                            <input id="siteclear_get" type="text" class="form-control form-control-sm" placeholder="Enter.." value="">
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button id="btnSaveClear" type="button" class="btn btn-success">Save</button>
                        @endif
                        @if($pageAuth['is_update']==1 || false)
                        <button id="btnUpdateClear" type="submit" class="btn btn-warning d-none">Update</button>
                        @endif
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
                            <h6 id="env_firstname">Assign Environment Officer: N/A</h6>
                            <button type="button" onclick="location.href = '/epl_assign';" class="btn btn-dark" data-dismiss="modal">Assign/Change</button>
                            <!--<p>There is a problem that we need to</p>-->
                        </div>
                        <div class="callout callout-danger">
                            <h6><a id="disPaylink" href="/epl_payments/id/{{$profile}}" class="text-success">Payments</a></h6>
                            <p>All Payment (EPL, Fine,Inspection Fee, Certificate)</p>
                        </div>
                        <div class="callout callout-danger">
                            <h6><a href="/epl_profile/atachments/{{$profile}}" class="text-success">Attachments</a></h6>
                            <p>Upload EPL Attachments</p>
                        </div>
                        <div class="callout callout-danger">
                            <h6><a href="/remarks/epl/{{$profile}}" class="text-success">Remarks</a></h6>
                            <p>Add Comments</p>
                        </div>
                        <div class="callout callout-danger">
                            <h6><a href="/certificate_approval/id/{{$profile}}" class="text-success">Approval</a></h6>
                            <p>Approve the EPL</p>
                        </div>
                        <div class="callout callout-danger">
                            <h6><a href="/issue_certificate/id/{{$profile}}" class="text-success ">Certificate Information</a></h6>
                            <p>Issue Certificate / Certificate Information</p>
                        </div>
                        <div class="callout callout-danger">
                            <h6><a id="disInspeclink" href="/inspection/epl/id/{{$profile}}" class="text-success ">Inspection</a></h6>
                            <p>Manage Inspection Details</p>
                        </div>
                    </div>
                    <!-- /.card-body -->
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
                        <dt>Name :</dt>
                        <dd id="obj_name"></dd>
                        <dt>Registration No :</dt>
                        <dd id="obj_regno"></dd>
                        <dt>Code :</dt>
                        <dd id="obj_code"></dd>
                        <dt>Investment :</dt>
                        <dd id="obj_invest"></dd>
                        <dt>Remark :</dt>
                        <dd id="obj_remark"></dd>
                        <dt>Location :</dt>
                        <div id="map" style="width: 100%; height: 400px;"></div>
                        <dt>Download Application :</dt>
                        <button type="button" class="btn btn-dark d-none navTodownload">View Application</button>
                        <button type="button" class="btn btn-dark d-none navToFile1">View Road Map</button>
                        <button type="button" class="btn btn-dark d-none navToFile2">View Deed of the land </button>
                        <button type="button" class="btn btn-dark d-none navToFile3">View Survey Plan</button>

                        <button type="button" class="btn btn-success d-none" data-upload_file="EPL" id="upld_application">Upload Application</button>
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
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-danger">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header"> 
                <h4 class="modal-title">Delete Attachment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><b>Are you sure you want to permanently delete this Attachment ? </b></p>
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

<!-- AdminLTE App -->
<script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyaUNtnrMrJwLqWQmHoUbeHaLk6q4msXE&callback=initMap"></script>
<script>
//Map Start    
// Initialize and add the map
                                function initMap(_Latitude, _Longitude) {
                                    // The location of CeyTech
                                    var defaultLocation = {lat: _Latitude, lng: _Longitude}; //default Location for load map
//    console.log('def lat: ' + defaultLocation.lat);
//    alert(defaultLocation.lat);

                                    // The map, centered at Uluru
                                    var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: defaultLocation});
                                    // The marker, positioned at Uluru
                                    var marker = new google.maps.Marker({position: defaultLocation, map: map, draggable: false, title: "Drag me!"});
//    google.maps.event.addListener(marker, 'dragend', function (evt) {
//    _Latitude = evt.latLng.lat().toFixed(6); //change  decimal point if have problam with location accuracy
//    _Longitude = evt.latLng.lng().toFixed(6); //change  decimal point if have problam with location accuracy
//    // alert('Marker dropped: Current Lat: ' + evt.latLng.lat().toFixed(3) + ' Current Lng: ' + evt.latLng.lng().toFixed(3) );
//    });
                                }
//Map END
                                $(function () {
                                    var CLIENT = '{{$client}}';
                                    var PROFILE = '{{$profile}}';
                                    getaClientbyId(CLIENT, function (result) {
                                        if (result.length == 0 || result == undefined) {
                                            if (confirm("Client Not Found! Try Again!")) {

                                            }
                                        } else {
                                            setClientDetails(result);
                                        }
                                        initMap(parseFloat(result.industry_coordinate_x), parseFloat(result.industry_coordinate_y));
                                    });
                                    getDetailsbyId(PROFILE, function (result) {
                                        if (result.length == 0 || result == undefined) {
                                            if (confirm("Details Not Found! Try Again!")) {
                                            }
                                        } else {
                                            setClearanceData(result);
                                            setAllDetails(result);
                                            $('.navTodownload').click(function () {
                                                downloadApp(result);
                                            });
                                            $('.navToFile1').click(function () {
                                                downloadFile1(result);
                                            });
                                            $('.navToFile2').click(function () {
                                                downloadFile2(result);
                                            });
                                            $('.navToFile3').click(function () {
                                                downloadFile3(result);
                                            });
                                        }
                                    });
                                    $('#btnSaveClear').click(function () {
                                        var data = fromValues();
                                        if (Validiteinsert(data)) {
                                            // if validiated
                                            AddClearance(data, PROFILE, function (result) {
                                                if (result.id == 1) {
                                                    Toast.fire({
                                                        type: 'success',
                                                        title: 'Enviremontal MS</br>Saved'
                                                    });
                                                    $('#btnSaveClear').addClass('d-none');
                                                    $('#btnUpdateClear').removeClass('d-none');
                                                } else {
                                                    Toast.fire({
                                                        type: 'error',
                                                        title: 'Enviremontal MS</br>Error'
                                                    });
                                                }
                                                resetinputFields();
                                                hideAllErrors();
                                            });
                                        }
                                    });
                                    $('#upld_application, #upld_roadMap, #upld_deed, #upld_SurveyPlan').click(function () {
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
                                        ulploadFile2('/api/epl/upload/epl/' + PROFILE + '/file/' + fileCat, formData, function (parameters) {
                                            getDetailsbyId(PROFILE, function (result) {
                                                if (result.length == 0 || result == undefined) {
                                                    if (confirm("Details Not Found! Try Again!")) {
                                                    }
                                                } else {
                                                    setClearanceData(result);
                                                    setAllDetails(result);
                                                    $('.navTodownload').click(function () {
                                                        downloadApp(result);
                                                    });
                                                    $('.navToFile1').click(function () {
                                                        downloadFile1(result);
                                                    });
                                                    $('.navToFile2').click(function () {
                                                        downloadFile2(result);
                                                    });
                                                    $('.navToFile3').click(function () {
                                                        downloadFile3(result);
                                                    });
                                                }
                                                initMap(parseFloat(result.coordinate_x), parseFloat(result.coordinate_y));
                                            });
                                        });
                                    });

                                    //click update button
                                    $('#btnUpdateClear').click(function () {
                                        var data = fromValues();
                                        if (confirm('Are You Sure?')) {
                                            if (Validiteupdate(data)) {
                                                updateClearance(PROFILE, data, function (result) {
                                                    if (result.id == 1) {
                                                        Toast.fire({
                                                            type: 'success',
                                                            title: 'Enviremontal MS</br>Updated'
                                                        });
                                                    } else {
                                                        Toast.fire({
                                                            type: 'error',
                                                            title: 'Enviremontal MS</br>Error'
                                                        });
                                                    }
                                                    resetinputFields();
                                                    hideAllErrors();
                                                });
                                            }
                                        }
                                    });
                                    function fromValues() {
                                        var data = {
                                            site_clearance_file: $('#siteclear_get').val()
                                        };
                                        return data;
                                    }
                                });
                                function disWarnPay() {
                                    toastr.error('Assign Environment Officer & Try Again!');
                                }
</script>
<!--<script>
    $(function(){
    {{-- function readFile() {

    if (this.files && this.files[0]) {

    var FR = new FileReader();
    FR.addEventListener("load", function(e) {
    document.getElementById("img").src = e.target.result;
    document.getElementById("b64").innerHTML = e.target.result;
    AddPayments({"name": e.target.result}, function(){
    alert("Message Sent");
    })
    });
    FR.readAsDataURL(this.files[0]);
    }

    } --}}

    {{-- document.getElementById("inp").addEventListener("change", readFile); --}}
    $("#btnSave").click(function(){
    alert("wada");
    var img = document.getElementById("inp")
            if (img.files && img.files[0]) {

    var FR = new FileReader();
    FR.addEventListener("load", function(e) {
    document.getElementById("img").src = e.target.result;
    document.getElementById("b64").innerHTML = e.target.result;
    AddPayments({"name": e.target.result}, function(){
    alert("Message Sent");
    })
    });
    FR.readAsDataURL(img.files[0]);
    } else{
    alert("No Image")
    }
    });
    });
</script>-->
@endsection

