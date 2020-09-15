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
                <h1>Update Industry File - <span class="right badge badge-primary fileNoDbzz">Loading..</span></h1>

            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <!--    Register New Client START-->
    <div class="container-fluid reg-newClient">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <label id="lblTitle">Update Client</label>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Is New*</label>
                                    <select id="getisOld" class="form-control form-control-sm cutenzReq" style="width: 100%;">
                                        <option value="1">New</option>
                                        <option value="0">Old</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>First Name*</label>
                                    <input id="getfName" type="text" class="form-control form-control-sm cutenzReq"
                                           placeholder="Enter FirstName..."
                                           value="">
                                    <div id="valName" class="d-none"><p class="text-danger">Name is required</p></div>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input id="getlName" type="text" class="form-control form-control-sm"
                                           placeholder="Enter LastName..."
                                           value="">
                                    <div id="valLName" class="d-none"><p class="text-danger">Last Name is required</p></div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input id="getAddress" type="text" class="form-control form-control-sm"
                                           placeholder="Enter Address..."
                                           value="">
                                    <div id="valAddName" class="d-none"><p class="text-danger">Address is required</p></div>
                                </div>
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input id="getContact" type="text" class="form-control form-control-sm"
                                           placeholder="Enter Contact Number..."
                                           value="">
                                    <div id="valConName" class="d-none"><p class="text-danger">Contact Number is required</p></div>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="getEmail" type="text" class="form-control form-control-sm"
                                           placeholder="Enter Email..."
                                           value="">
                                    <div id="valNam1e" class="d-none"><p class="text-danger">Email is required</p></div>
                                </div>
                                <div class="form-group">
                                    <label>NIC</label>
                                    <input id="getNicSave" type="text" class="form-control form-control-sm"
                                           placeholder="Enter NIC..."
                                           value="">
                                    <div id="valnicName" class="d-none"><p class="text-danger">NIC is required</p></div>
                                </div>
                                <hr>
                                <div class="card-header">
                                    <label id="lblTitle">Map</label>
                                </div>
                                <div id="map" style="width: 100%; height: 367px;"></div>
                            </div>  
                            <div class="overlay dark loadingRenderUI">
                                <i class="fas fa-2x fa-sync-alt"></i>
                            </div>
                        </div>
                    </div>
                    <!--Industry details-->
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <label id="lblTitle">Industry details</label>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Pradeshiya Sabha*</label>
                                    <select id="prsdeshiySb" class="form-control form-control-sm select2 select2-purple cutenzReq prsdeshiySb" style="width: 100%;"></select>
                                </div>
                                <div class="form-group">
                                    <label>Industry Category*</label>
                                    <select id="industryCat" class="form-control form-control-sm select2 select2-purple cutenzReq" style="width: 100%;"></select>
                                </div>
                                <div class="form-group">
                                    <label>Business Scale*</label>
                                    <select id="businesScale" class="form-control form-control-sm  select2 select2-purple cutenzReq" style="width: 100%;"></select>
                                </div>
                                <div class="form-group">
                                    <label>Business Registration Number</label>
                                    <input id="business_regno" type="text" class="form-control form-control-sm" placeholder="Enter Number" value="">
                                </div>
                                <div class="form-group">
                                    <label>Business Name*</label>
                                    <input id="business_name" type="text" class="form-control form-control-sm cutenzReq" placeholder="Enter Name..." value="">
                                </div>
                                <div class="form-group">
                                    <label>Is this Industry Zone</label>
                                    <select id="getZone" class="form-control form-control-sm" style="width: 100%;">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Investment*</label>
                                    <input id="inventsment" type="number" class="form-control form-control-sm cutenzReq" placeholder="Enter investment" value="">
                                </div>
                                <div class="form-group">
                                    <label>Address*</label>
                                    <input id="getAddressT" type="text" class="form-control form-control-sm cutenzReq" placeholder="Enter Address..." value="">
                                </div>
                                <div class="form-group">
                                    <label>Start Date*</label>
                                    <input id="startDate" type="date" max="2999-12-31" class="form-control form-control-sm" placeholder="Enter Date..." value="">
                                </div>
                                <div class="form-group">
                                    <label>Submitted Date*</label>
                                    <input id="submittedDate" type="date" max="2999-12-31" class="form-control form-control-sm cutenzReq" placeholder="Enter Date..." value="">
                                </div>
                                <div class="form-group">
                                    <label>Contact No</label>
                                    <input id="getContactn" type="text" class="form-control form-control-sm" placeholder="Enter Contact Info..." value="">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="getEmailI" type="text" class="form-control form-control-sm" placeholder="Enter Email..." value="">
                                </div>
                            </div>
                            <div class="card-footer">
                                @if($pageAuth['is_create']==1 || false)
                                <button id="btnUpdate" type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button>
                                @endif
                            </div>
                            <div class="overlay dark loadingRenderUI">
                                <i class="fas fa-2x fa-sync-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--If something about Datatable place tt here again! -->
            </div>
        </div>
    </div>
    <!--Register New Client END-->
</section>

@endif
@endsection

@section('pageScripts')
<!-- Page script -->

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
<script src="../../js/IndustryProfileJS/update_industry_profile.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyaUNtnrMrJwLqWQmHoUbeHaLk6q4msXE&callback=initMap"></script>
<script>
    var _Latitude = 7.489050;
    var _Longitude = 80.349985;
    var PROFILE = '{{$id}}';
// Initialize and add the map
    function initMap() {
        // The location of CeyTech
        var defaultLocation = {lat: 7.489050, lng: 80.349985}; //default Location for load map
        // The map, centered at Uluru
        var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 14, center: defaultLocation});
        // The marker, positioned at Uluru
        var marker = new google.maps.Marker({position: defaultLocation, map: map, draggable: true,
            title: "Drag me!"});
        google.maps.event.addListener(marker, 'dragend', function (evt) {
            _Latitude = evt.latLng.lat().toFixed(6); //change  decimal point if have problam with location accuracy
            _Longitude = evt.latLng.lng().toFixed(6); //change  decimal point if have problam with location accuracy
        });
    }

    $(function () {
        loadPradeshiyaSabha();
        IndustryCategoryCombo();
        BusinessScaleCombo();

        getaClientbyId(PROFILE, function (set) {
            //Client
            $(".fileNoDbzz").html(set.file_no);
            $("#getisOld").val(set.is_old);
            $('#getfName').val(set.first_name);
            $('#getlName').val(set.last_name);
            $('#getAddress').val(set.address);
            $('#getContact').val(set.contact_no);
            $('#getEmail').val(set.email);
            $('#getNicSave').val(set.nic);
            //Industry
            $('#prsdeshiySb').val(set.pradesheeyasaba_id);
            $('#industryCat').val(set.industry_category_id);
            $('#businesScale').val(set.business_scale_id);
            $('#business_regno').val(set.industry_registration_no);
            $('#business_name').val(set.industry_name);
            $('#getZone').val(set.industry_is_industry);
            $('#getAddressT').val(set.industry_address);
            $('#inventsment').val(set.industry_investment);
            $('#startDate').val(set.created_at);
            $('#submittedDate').val(set.industry_start_date);
            $('#getContactn').val(set.industry_contact_no);
            $('#getEmailI').val(set.industry_email);
            $('#btnUpdate').val(set.id);
            _Latitude = parseFloat(set.industry_coordinate_x);
            _Longitude = parseFloat(set.industry_coordinate_y);
            initMap();
            $(".loadingRenderUI").remove(); //<--Check Loading Status
        });
    });


    $('#btnUpdate').click(function () {
        var dataz = {
            is_old: $('#getisOld').val(),
            first_name: $('#getfName').val(),
            last_name: $('#getlName').val(),
            address: $('#getAddress').val(),
            contact_no: $('#getContact').val(),
            email: $('#getEmail').val(),
            nic: $('#getNicSave').val(),
            industry_name: $('#business_name').val().trim(),
            industry_category_id: $('#industryCat').val(),
            business_scale_id: $('#businesScale').val(),
            industry_contact_no: $('#getContactn').val().trim(),
            industry_address: $('#getAddressT').val().trim(),
            industry_email: $('#getEmailI').val(),
            pradesheeyasaba_id: $('#prsdeshiySb').val(),
            industry_is_industry: $('#getZone').val(),
            industry_investment: $('#inventsment').val(),
            industry_start_date: $('#startDate').val(),
            industry_registration_no: $('#business_regno').val().trim(),
            industry_coordinate_x: _Latitude,
            industry_coordinate_y: _Longitude,
            assign_date: $('#submittedDate').val()
        };
        if (requiredFieldHandler(dataz, ".cutenzReq")) {
            updateClientFileAPI($(this).val(), dataz, function (resp) {
                show_mesege(resp);
                if (resp.id === 1) {
                    //Do redirect to indust profile if u want...
                    window.location = '/industry_profile/id/' + PROFILE;
                }
            });
        }
    });


</script>
@endsection
