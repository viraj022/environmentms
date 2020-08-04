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
            <div class="col-12 col-sm-6">
                <h1>New EPL</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="card card-primary">
                    <div class="card-header">
                        <label id="lblTitle">Register New EPL</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Is New*</label>
                            <select id="getisOld" class="form-control form-control-sm" style="width: 100%;">
                                <option value="1">New</option>
                                <option value="0">Old</option>
                            </select>
                        </div>
                        <div id="old_file" class="d-none">
                            <div class="form-group">
                                <label>EPL Code*</label>
                                <input id="epl_code" type="text" class="form-control form-control-sm" placeholder="Enter Number" value="">
                            </div>
                            <div class="form-group">
                                <label>Certificate No*</label>
                                <input id="certificate_no" type="text" class="form-control form-control-sm" placeholder="Enter Number" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Remark*</label>
                            <input id="getRemark" type="text" class="form-control form-control-sm" placeholder="Enter Name..." value="">
                        </div>
                        <input hidden id="client_id" type="text" class="form-control form-control-sm" placeholder="" value="{{$id ?? ''}}">
                        <div class="form-group">
                            <label>Upload Application: </label>
                            <input id="inp" type='file'>
                        </div>
                        <div class="progress d-none">
                            <div class="progress-bar bg-primary progress-bar-striped Uploadprogress" id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                <!--<span class="sr-only">40% Complete (success)</span>-->
                            </div>
                        </div>

                        <!--                        <div class="form-group">
                                                    <label>Road Map: </label>
                                                    <input id="file_1" type='file'>
                                                </div>
                        
                                                <div class="form-group">
                                                    <label>Deed of the land: </label>
                                                    <input id="file_2" type='file'>
                                                </div>
                        
                                                <div class="form-group">
                                                    <label>Survey Plan: </label>
                                                    <input id="file_3" type='file'>
                                                </div>-->
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button id="btnSave" type="button" class="btn btn-success">Save</button>
                        @endif
                        @if($pageAuth['is_update']==1 || false)
                        <button id="btnUpdate" type="submit" class="btn btn-warning d-none">Update</button>
                        @endif
                        @if($pageAuth['is_delete']==1 || false)
                        <button  id="btnshowDelete" type="submit" class="btn btn-danger d-none"  data-toggle="modal"
                                 data-target="#modal-danger">Delete</button>
                        @endif

                        <p id="b64"></p>
                        <img id="img" height="150">
                    </div>                           
                </div>
            </div>

            <!--            <div class="col-md-7">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <label id="lblTitle">Map</label>
                                                </div>
                                                 /.card-header 
                                                <div class="card-body p-0">
                                                    <div id="map" style="width: 100%; height: 600px;"></div>
                                                </div>
                                                 /.card-body 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
        </div>
    </div>
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
<script src="../../js/commonFunctions/functions.js" type="text/javascript"></script>
<script src="../../js/commonFunctions/file_upload.js" type="text/javascript"></script>
<script src="../../js/epl/epl_register.js"></script>
<script src="../../js/EplRegJS/submit.js"></script>
<script src="../../js/EplRegJS/get.js"></script>
<script src="../../js/EplRegJS/get_data.js"></script>
<script src="../../js/EplRegJS/update.js"></script>
<script src="../../js/EplRegJS/delete.js"></script>
<!-- AdminLTE App -->
<!--<script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyaUNtnrMrJwLqWQmHoUbeHaLk6q4msXE&callback=initMap"></script>-->
<script>
//var _Latitude = 7.489050;
//var _Longitude = 80.349985;
//// Initialize and add the map
//function initMap() {
//    // The location of CeyTech
//    var defaultLocation = {lat: 7.489050, lng: 80.349985}; //default Location for load map
//
//    // The map, centered at Uluru
//    var map = new google.maps.Map(
//            document.getElementById('map'), {zoom: 15, center: defaultLocation});
//    // The marker, positioned at Uluru
//    var marker = new google.maps.Marker({position: defaultLocation, map: map, draggable: true,
//        title: "Drag me!"});
//    google.maps.event.addListener(marker, 'dragend', function (evt) {
//        _Latitude = evt.latLng.lat().toFixed(6); //change  decimal point if have problam with location accuracy
//        _Longitude = evt.latLng.lng().toFixed(6); //change  decimal point if have problam with location accuracy
//    });
//}

$("#getisOld").click(function () {
    if ($(this).val() == 0) {
        $('#old_file').removeClass('d-none');
    } else {
        $('#old_file').addClass('d-none');
    }
});
$("#btnSave").click(function () {
    var data = fromValues();
    AddEpl(data, function (result) {
        if (result.id == 1) {
            window.location.replace(result.rout);
        }
        show_mesege(result.id);
    });
});

</script>
<script>
    $(function () {
//        loadPradeshiyaSabha();
//        IndustryCategoryCombo();
//        BusinessScaleCombo();
    });

</script>
@endsection
