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
<style>
    .bs-example {
        font-family: sans-serif;
        position: relative;
        margin: 100px;
    }

    .typeahead,
    .tt-query,
    .tt-hint {
        border: 2px solid #CCCCCC;
        border-radius: 8px;
        font-size: 17px;
        /* Set input font size */
        height: 33px;
        line-height: 30px;
        outline: medium none;
        padding: 8px 12px;
    }

    .typeahead {
        background-color: #FFFFFF;
        display: block !important;
        width: 648px;
    }

    .typeahead:focus {
        border: 2px solid #0097CF;
    }

    .tt-query {
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    }

    .tt-hint {
        color: #999999;
    }

    .tt-menu {
        background-color: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        margin-top: 12px;
        padding: 8px 0;
        width: 562px;
    }

    .tt-suggestion {
        font-size: 20px;
        /* Set suggestion dropdown font size */
        padding: 3px 20px;
    }

    .tt-suggestion:hover {
        cursor: pointer;
        background-color: #0097CF;
        color: #FFFFFF;
    }

    .tt-suggestion p {
        margin: 0;
    }
</style>
@endsection
@section('content')
@if($pageAuth['is_read']==1 || false)
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Industry Registration</h1>

            </div>
        </div>
    </div>
</section>
<section class="content">
    <!--    Register New Client START-->
    <div class="container-fluid reg-newClient d-none">
        <div class="row">

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-gray">
                            <div class="card-header">
                                <h3 id="lblTitle" class="card-title">Register New Client</h3>
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
                                    <label>Title*</label>
                                    <select id="getTitle" class="form-control form-control-sm cutenzReq" style="width: 100%;">
                                        <option value="Mr">Mr.</option>
                                        <option value="Mrs">Mrs.</option>
                                        <option value="-">-</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>First Name*</label>
                                    <input id="getfName" type="text" maxlength="45" class="form-control form-control-sm cutenzReq" placeholder="Enter FirstName..." value="">
                                    <div id="valName" class="d-none">
                                        <p class="text-danger">Name is required</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input id="getlName" type="text" maxlength="45" class="form-control form-control-sm" placeholder="Enter LastName..." value="">
                                    <div id="valLName" class="d-none">
                                        <p class="text-danger">Last Name is required</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input id="getAddress" type="text" class="form-control form-control-sm" placeholder="Enter Address..." value="">
                                    <div id="valAddName" class="d-none">
                                        <p class="text-danger">Address is required</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input id="getContact" onKeyDown="if (this.value.length == 10 && event.keyCode != 8)
                                                return false;" type="number" class="form-control form-control-sm" placeholder="Enter Contact Number..." value="">
                                    <div id="valConName" class="d-none">
                                        <p class="text-danger">Contact Number is required</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="getEmail" type="text" class="form-control form-control-sm" placeholder="Enter Email..." value="">
                                    <div id="valNam1e" class="d-none">
                                        <p class="text-danger">Email is required</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>NIC</label>
                                    <input id="getNicSave" onKeyDown="if (this.value.length == 12 && event.keyCode != 8)
                                                return false;" type="text" class="form-control form-control-sm" maxlength="12" minlength="10" placeholder="Enter NIC..." value="">
                                    <div id="valnicName" class="d-none">
                                        <p class="text-danger">NIC is required</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="card-header">
                                    <label id="lblTitle">Map</label>
                                </div>
                                <div id="map" style="width: 100%; height: 385px;"></div>
                            </div>
                        </div>
                    </div>
                    <!--Industry details-->
                    <div class="col-md-6">
                        <div class="card card-gray">
                            <div class="card-header">
                                <h3 class="card-title" id="lblTitle">Industry details</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Pradeshiya Sabha*</label>
                                    <select id="prsdeshiySb" class="form-control form-control-sm select2 select2-purple cutenzReq" style="width: 100%;"></select>
                                </div>
                                <div class="form-group">
                                    <label>Industry Category*</label>
                                    <select id="industryCat" class="form-control form-control-sm select2 select2-purple cutenzReq" style="width: 100%;"></select>
                                </div>
                                <div class="form-group">
                                    <label>Business Scale*</label>
                                    <select id="businesScale" class="form-control form-control-sm select2 select2-purple cutenzReq" style="width: 100%;"></select>
                                </div>
                                <div class="form-group">
                                    <label>Industry Sub-Category</label>
                                    <input id="industry_sub_cat" type="text" class="form-control form-control-sm " placeholder="Enter Text." value="">
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
                                    <label>Investment(Rs)*</label>
                                    <input id="inventsment" pattern="/^-?\d+\.?\d*$/" onkeypress="if (this.value.length == 12)
                                                return false;" type="number" class="form-control form-control-sm cutenzReq" placeholder="Enter investment Rs" value="">
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
                                    <input id="getContactn" type="number" onKeyDown="if (this.value.length == 10 && event.keyCode != 8)
                                                return false;" class="form-control form-control-sm" placeholder="Enter Contact Info..." value="">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="getEmailI" type="text" class="form-control form-control-sm" placeholder="Enter Email..." value="">
                                </div>
                            </div>
                            <div class="card-footer">
                                @if($pageAuth['is_create']==1 || false)
                                <button id="btnSave" type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                                    Register</button>
                                @endif
                                @if($pageAuth['is_update']==1 || false)
                                <button id="btnUpdate" type="submit" class="btn btn-warning d-none">Update</button>
                                @endif
                                @if($pageAuth['is_delete']==1 || false)
                                <button id="btnshowDelete" type="submit" class="btn btn-danger d-none" data-toggle="modal" data-target="#modal-danger">Delete</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <!--If something about Datatable place tt here again! -->
            </div>
        </div>
    </div>
    <!--Register New Client END-->

    <!---------END ALL------------>

    <!--Search Client By NIC START-->
    <div class="container-fluid search-Client">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="card card-gray">
                        <div class="card-header">
                            <h3 id="lblTitle" class="card-title">Search Client</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Search with*</label>
                                <select id="getDtaType" class="form-control form-control-sm select2 select2-purple col-sm-4" data-dropdown-css-class="select2-purple" style="width: 60em;" name="level">
                                    <option value="name">Client Name</option>
                                    <option value="id">Client NIC</option>
                                    <option value="license">License Number</option>
                                    <option value="epl">EPL Number</option>
                                    <option value="site_clear_code">Site Clearance Code</option>
                                    <option value="by_industry_name">Business Name</option>
                                    <option value="business_reg">Business Registration Number</option>
                                    <option value="by_address">Address</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div id="the-basics">
                                    <input id="getNic" type="text" class="form-control form-control-sm col-12 typeahead" style="width: 49.5em" max-length="12" min-length="10" placeholder="Enter Here..." value="">
                                </div>
                                <div id="valName" class="d-none">
                                    <p class="text-danger">Name is required</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if($pageAuth['is_create']==1 || false)
                            <button id="btnSearch" type="submit" class="btn btn-success"><i class="fas fa-search"></i>
                                Search</button>
                            <button id="btnRegister" class="btn btn-primary"><i class="fas fa-plus"></i> Register New
                                Client</button>
                            @endif
                            <!--<button type="submit" class="btn btn-default resetAll">Reset</button>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Search Client By NIC END-->
    <div class="view-Customer d-none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Customer Details

                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-active" id="tblCusData">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>NIC</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!--show lient details START-->

    <!--Search Site Clearance END-->
    <div class="view-site-clear d-none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Site Clearance Details

                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-active" id="tblSiteClear">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Client Name</th>
                                <th>Industry Name</th>
                                <th>Remark</th>
                                <th>Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!-- /.card-body -->
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
                    <button id="btnDelete" type="submit" class="btn btn-outline-light" data-dismiss="modal">Delete
                        Permanently</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</section>
<section>
    <div class="viewClientData d-none">
        <p>Here Is Our Client Data!</p>
    </div>
</section>

@endif
@endsection



@section('pageScripts')
<!-- Page script -->

<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script src="../../plugins/select2/js/select2.full.min.js"></script>
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
<script src="../../js/ClientJS/client_space.js"></script>
<script src="../../js/epl/epl_register.js"></script>
<script src="../../js/ClientJS/submit.js"></script>
<script src="../../js/ClientJS/get.js"></script>
<script src="../../js/ClientJS/update.js"></script>
<script src="../../js/ClientJS/delete.js"></script>
<script src="../../js/ClientJS/viewClientData.js"></script>
<script src="../../js/ClientJS/typeahead.bundle.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyaUNtnrMrJwLqWQmHoUbeHaLk6q4msXE&callback=initMap"></script>
<script>
                                        var _Latitude = 7.489050;
                                        var _Longitude = 80.349985;
                                        // Initialize and add the map
                                        function initMap() {
                                            // The location of CeyTech
                                            var defaultLocation = {
                                                lat: 7.489050,
                                                lng: 80.349985
                                            }; //default Location for load map

                                            // The map, centered at Uluru
                                            var map = new google.maps.Map(
                                                    document.getElementById('map'), {
                                                zoom: 13,
                                                center: defaultLocation
                                            });
                                            // The marker, positioned at Uluru
                                            var marker = new google.maps.Marker({
                                                position: defaultLocation,
                                                map: map,
                                                draggable: true,
                                                title: "Drag me!"
                                            });
                                            google.maps.event.addListener(marker, 'dragend', function (evt) {
                                                _Latitude = evt.latLng.lat().toFixed(6); //change  decimal point if have problam with location accuracy
                                                _Longitude = evt.latLng.lng().toFixed(6); //change  decimal point if have problam with location accuracy
                                            });
                                        }


                                        $(function () {
                                            //Load table
                                            loadPradeshiyaSabha();
                                            IndustryCategoryCombo();
                                            BusinessScaleCombo();
                                            getClientSearchDetails('name', function (set) {
                                                localStorage.setItem('clientData', JSON.stringify(set));
                                                states.clear();
                                                states.local = JSON.parse(localStorage.getItem('clientData'));
                                                states.initialize(true);
                                            });
                                            //Register Button
                                            $('#btnSave').click(function () {
                                                var data = fromValues();
                                                if (requiredFieldHandler(data, ".cutenzReq")) {
                                                    // if validiated
                                                    AddClient(data, function (result) {
                                                        if (result.message == 'true') {
                                                            Toast.fire({
                                                                type: 'success',
                                                                title: 'Enviremontal MS</br>Saved'
                                                            });
                                                            getaClientbyId(result.id, function (result) {
                                                                window.location = "/industry_profile/id/" + result.id;
                                                            });
                                                        } else {
                                                            Toast.fire({
                                                                type: 'error',
                                                                title: 'Enviremontal MS</br>Error'
                                                            });
                                                        }
                                                        //                                                        loadTable();
                                                        resetinputFields();
                                                        hideAllErrors();
                                                    });
                                                }
                                            });
                                            //click update button
                                            $('#btnUpdate').click(function () {
                                                //get form data
                                                var data = fromValues();
                                                if (Validiteupdate(data)) {
                                                    updatePaymentCat($('#btnUpdate').val(), data, function (result) {
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
                                                        //                                                        loadTable();
                                                        showSave();
                                                        resetinputFields();
                                                        hideAllErrors();
                                                    });
                                                }
                                            });
                                            //click delete button
                                            $('#btnDelete').click(function () {
                                                deletePaymentCat($('#btnDelete').val(), function (result) {
                                                    if (result.id == 1) {
                                                        Toast.fire({
                                                            type: 'success',
                                                            title: 'Enviremontal MS</br>Removed!'
                                                        });
                                                    } else {
                                                        Toast.fire({
                                                            type: 'error',
                                                            title: 'Enviremontal MS</br>Error'
                                                        });
                                                    }
                                                    //                                                    loadTable();
                                                    showSave();
                                                    resetinputFields();
                                                    hideAllErrors();
                                                });
                                            });
                                            //select button action 
                                            $(document).on('click', '.btnAction', function () {
                                                getaPaymentCatbyId(this.id, function (result) {
                                                    $('#getName').val(result.name);
                                                    showUpdate();
                                                    $('#btnUpdate').val(result.id);
                                                    $('#btnDelete').val(result.id);
                                                });
                                                hideAllErrors();
                                            });

                                            function showSiteClearanceDetails(obje) {
                                                var table = "";
                                                var id = 1;
                                                $('#tblSiteClear').DataTable().destroy();
                                                $.each(obje, function (index, clientData) {
                                                    console.log(clientData);
                                                    table += "<tr>";
                                                    table += "<td>" + ++index + "</td>";
                                                    table += "<td>" + clientData.code + "</td>";
                                                    let client_name = clientData.first_name + clientData.last_name;
                                                    table += "<td>" + client_name + "</td>";
                                                    table += "<td>" + clientData.industry_name + "</td>";
                                                    table += "<td>" + clientData.remark + "</td>";
                                                    table += "<td>" + clientData.site_clearance_type + "</td>";
                                                    table += "<td><a href='/industry_profile/id/" + clientData.id + "' class='btn btn-block btn-success btn-xs btnCustomerVa'>Select</a></td>";
                                                    table += "</tr>";
                                                });
                                                $('#tblSiteClear tbody').html(table);
                                                $(function () {
                                                    var t = $("#tblSiteClear").DataTable();
                                                    t.on('order.dt search.dt', function () {
                                                        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                                                            cell.innerHTML = i + 1;
                                                        });
                                                    }).draw();
                                                });

                                                //data table error handling
                                                $.fn.dataTable.ext.errMode = 'none';
                                                $('#tblSiteClear').on('error.dt', function (e, settings, techNote, message) {
                                                    console.log('DataTables error: ', message);
                                                });
                                            }

                                            //Search NIC Button 
                                            $(document).on('click', '#btnSearch', function () {

                                                var data2 = {
                                                    value: $('#getNic').val()
                                                };
                                                if (data2.value.length != 0 && data2.value != null) {
                                                    getClientbyNic($('#getDtaType').val(), data2, function (result) {
                                                        console.log(result);
                                                        switch ($('#getDtaType').val()) {
                                                            case 'name':
                                                                if (result != 0) {
                                                                    showCustomerDetails(result);
                                                                    $('.view-Customer').removeClass('d-none');
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'id':
                                                                if (result != 0) {
                                                                    window.location = "/industry_profile/id/" + result.id;
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'license':
                                                                if (result != 0) {
                                                                    window.location = "/industry_profile/id/" + result.id;
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'epl':
                                                                if (!!result.deleted_at) {
                                                                    alert('Deleted Record!');
                                                                } else {
                                                                    if (result != 0) {
                                                                        window.location = "/industry_profile/id/" + result.id;
                                                                    } else {
                                                                        if (confirm(
                                                                                'Client Not Found!Do You Want Create New Client?')) {
                                                                            setSectionVisible('reg-newClient');
                                                                        } else {
                                                                            return false;
                                                                        }
                                                                    }
                                                                }
                                                                break;
                                                            case 'business_reg':
                                                                if (result != 0) {
                                                                    window.location = "/industry_profile/id/" + result.id;
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'by_address':
                                                                if (result != 0) {
                                                                    showCustomerDetails(result);
                                                                    $('.view-Customer').removeClass('d-none');
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'by_industry_name':
                                                                if (result != 0) {
                                                                    showCustomerDetails(result);
                                                                    $('.view-Customer').removeClass('d-none');
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'site_clear_code':
                                                                if (result != 0) {
                                                                    showSiteClearanceDetails(result);
                                                                    $('.view-site-clear').removeClass('d-none');
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            default:
                                                                alert('Invalid Data');
                                                        }
                                                    });
                                                } else {
                                                    alert('Please Enter Client Information!');
                                                    $('#getNic').focus();
                                                }
                                                hideAllErrors();
                                            });

                                            $('#getNic').keyup(function (e) {
                                                if (e.which == 13) {
                                                    $("#btnSearch").click();
                                                }
                                            });
                                            $('#newEPL').click(function () {
                                                if (isNaN(parseInt($(this).val()))) {
                                                    return false;
                                                }
                                                window.location = "epl_register/id/" + $(this).val();
                                            });
                                            $('.resetAll').click(function () {
                                                setSectionVisible('');
                                            });
                                            $('#btnRegister').click(function () {
                                                setSectionVisible('reg-newClient');
                                            });
                                        });

                                        //btnCustomerVa button action 
                                        $(document).on('click', '.btnCustomerVa', function () {
                                            var row = JSON.parse(decodeURIComponent($(this).data('row')));
                                            window.location = "/industry_profile/id/" + row.id;
                                        });

                                        $('#getfName,#getlName').on('change', function () {
                                            let frName = $('#getfName').val();
                                            let lName = $('#getlName').val();
                                            $('#business_name').val(frName + ' ' + lName);
                                        });
                                        $('#getContact,#getEmail').on('change', function () {
                                            if ($('#getisOld').val() == 0) {
                                                let setContact = $('#getContact').val();
                                                let setEmail = $('#getEmail').val();
                                                $('#getContactn').val(setContact);
                                                $('#getEmailI').val(setEmail);
                                            }
                                        });
</script>
<script>
    var clientData = JSON.parse(localStorage.getItem('clientData'));

    $(document).on('change', '#getDtaType', function () {
        $('.view-Customer').addClass('d-none');
        getClientSearchDetails($(this).val(), function (set) {
            localStorage.setItem('clientData', JSON.stringify(set));
            states.clear();
            states.local = JSON.parse(localStorage.getItem('clientData'));
            states.initialize(true);
        });
        $('#getNic').val('');
    });

    var states = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `states` is an array of state names defined in "The Basics"
        local: clientData
    });

    $('#the-basics .typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'myMatches',
        source: states
    });
</script>
@endsection