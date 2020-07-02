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
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="height: 350px; overflow-y: scroll;">
                        <div class="callout callout-danger">
                            <h6 id="env_firstname">Assign Environment Officer: N/A</h6>
                            <button type="button" onclick="location.href = '/epl_assign';" class="btn btn-dark" data-dismiss="modal">Assign/Change</button>
                            <!--<p>There is a problem that we need to</p>-->
                        </div>
                        <div class="callout callout-danger">
                            <h6><a href="/epl_payments/id/{{$profile}}" class="text-success">Payments</a></h6>
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
                            <h6><a href="5" class="text-success ">Certificate Information</a></h6>
                            <p>Issue Certificate / Certificate Information</p>
                        </div>
                        <div class="callout callout-danger">
                            <h6><a href="/inspection/epl/id/{{$profile}}" class="text-success ">Inspection</a></h6>
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
                        <button type="button" class="btn btn-dark navTodownload" data-dismiss="modal">Download</button>
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
                                const Toast = Swal.mixin({
                                toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 4000

                                });
                                getaClientbyId({{$client}}, function (result) {
                                if (result.length == 0 || result == undefined) {
                                if (confirm("Client Not Found! Try Again!")) {

                                }
                                } else {
                                setClientDetails(result);
                                }
                                });
                                getDetailsbyId({{$profile}}, function (result) {
                                if (result.length == 0 || result == undefined) {
                                if (confirm("Details Not Found! Try Again!")) {
                                }
                                } else {
                                setClearanceData(result);
                                setAllDetails(result);
                                $('.navTodownload').click(function(){
                                downloadApp(result);
                                });
                                }

                                initMap(parseFloat(result.coordinate_x), parseFloat(result.coordinate_y));
//                $('#getName').val(result.name);
                                });
                                $('#btnSaveClear').click(function () {
                                var data = fromValues();
                                if (Validiteinsert(data)) {
                                // if validiated
                                AddClearance(data, {{$profile}}, function (result) {
                                if (result.id == 1) {
                                Toast.fire({
                                type: 'success',
                                        title: 'Enviremontal MS</br>Saved'
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
                                });
                                //click update button
                                $('#btnUpdateClear').click(function () {
                                var data = fromValues();
                                if (confirm('Are You Sure?')) {
                                if (Validiteupdate(data)) {
                                updateClearance({{$profile}}, data, function (result) {
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

