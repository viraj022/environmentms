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
                <h1>Old Data Registation</h1>
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
                        <label id="lblTitle">Add Old File</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Industry Type*</label>
                            <div class="col-sm-12">
                                <select id="getIndustryType" class="form-control form-control-sm">
                                    <option value="01">EPL</option>
                                    <option value="02">Site Clearance</option>
                                    <option value="03">Telecommunication Tower</option>
                                    <option value="04">SiteClearn</option>
                                </select>
                            </div>
                        </div>
                        <button id="btnLoadAc" class="btn btn-primary">Load</button>
                        <div class="epl_section"> 
                            <div class="form-group">
                                <label>EPL Code*</label>
                                <input id="getEPLCode" type="text" class="form-control form-control-sm" placeholder="Enter Data..." value="">
                                <div id="valEPL" class="d-none"><p class="text-danger">EPL is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Remark*</label>
                                <input id="getRemark" type="text" class="form-control form-control-sm" placeholder="Enter Remark..." value="">
                                <div id="valRemark" class="d-none"><p class="text-danger">Remark is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Issue Date*</label>
                                <input id="issue_date" type="date" class="form-control form-control-sm" placeholder="Enter Issue Date..." value="">
                            </div>
                            <div class="form-group">
                                <label>Expire Date*</label>
                                <input id="expire_date" type="date" class="form-control form-control-sm" placeholder="Enter Expire Date..." value="">
                            </div>
                            <div class="form-group">
                                <label>Certificate No*</label>
                                <input id="getcertifateNo" type="text" class="form-control form-control-sm" placeholder="Enter Certificate No..." value="">
                                <div id="valcertifateNo" class="d-none"><p class="text-danger">Certificate No is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Previous Renews*</label>
                                <div class="col-sm-12">
                                    <select id="getPreRenew" class="form-control form-control-sm">
                                        <option value="0">First</option>
                                        <option value="1">R 1</option>
                                        <option value="2">R 2</option>
                                        <option value="3">R 3</option>
                                        <option value="4">R 4</option>
                                        <option value="5">R 5</option>
                                        <option value="6">R 6</option>
                                        <option value="7">R 7</option>
                                        <option value="8">R 8</option>
                                        <option value="9">R 9</option>
                                        <option value="10">R 10</option>
                                        <option value="11">R 11</option>
                                        <option value="12">R 12</option>
                                        <option value="13">R 13</option>
                                        <option value="14">R 14</option>
                                        <option value="15">R 15</option>
                                        <option value="16">R 16</option>
                                        <option value="17">R 17</option>
                                        <option value="18">R 18</option>
                                        <option value="19">R 19</option>
                                        <option value="20">R 20</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Submit Date*</label>
                                <input id="getsubmitDate" type="date" class="form-control form-control-sm" placeholder="Enter Submit Date..." value="">
                            </div>
                            <div class="form-group">
                                <label>Last Issued Certificate: </label>
                                <input id="last_certificate" type="file" accept="image/*,application/pdf">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button id="btnSave" type="submit" class="btn btn-success">Save</button>
                        @endif
                        @if($pageAuth['is_update']==1 || false)
                        <button id="btnUpdate" type="submit" class="btn btn-warning d-none">Update</button>
                        @endif
                        @if($pageAuth['is_delete']==1 || false)
                        <button  id="btnshowDelete" type="submit" class="btn btn-danger d-none"  data-toggle="modal"
                                 data-target="#modal-danger">Delete</button>
                        @endif
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
                                                    <h3 class="card-title">All Zones</h3>
                                                </div>
                                                 /.card-header 
                                                <div class="card-body p-0">
                                                    <div class="card-body table-responsive" style="height: 450px;">
                                                        <table class="table table-condensed" id="tblZone">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10px">#</th>
                                                                    <th>Name</th>
                                                                    <th>Code</th>
                                                                    <th style="width: 140px">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
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
<script src="../../js/zonejs/delete.js"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
//Load table
//        loadTable();
//click save button
        $('#btnSave').click(function () {
            var data = fromValues();
            if (Validiteinsert(data)) {
                uniqueNamecheck(data.name, function (res) {
                    if (res.message === 'unique') {
                        uniqueCodecheck(data.code, function (rest) {
                            if (rest.message === 'unique') {
                                // if validiated
                                AddZone(data, function (result) {
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
                                    loadTable();
                                    resetinputFields();
                                    hideAllErrors();
                                });

                                ///fkf   
                            } else {
                                $('#uniCode').removeClass('d-none');
                            }
                        });

                    } else {
                        $('#uniName').removeClass('d-none');
                        //$('#uniCode').removeClass('d-none');  
                    }

                });
            }
        });
//click update button
        $('#btnUpdate').click(function () {
            //get form data
            var data = fromValues();
            if (Validiteupdate(data)) {
                updateZone($('#btnUpdate').val(), data, function (result) {
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
                    loadTable();
                    showSave();
                    resetinputFields();
                    hideAllErrors();
                });
            }
        });
//click delete button
        $('#btnDelete').click(function () {
            deleteZone($('#btnDelete').val(), function (result) {
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
                loadTable();
                showSave();
                resetinputFields();
                hideAllErrors();
            });
        });
//select button action 
        $(document).on('click', '.btnAction', function () {
            getaZonebyId(this.id, function (result) {
                $('#getName').val(result.name);
                $('#getCode').val(result.code);
                showUpdate();
                $('#btnUpdate').val(result.id);
                $('#btnDelete').val(result.id);
            });
            hideAllErrors();
        });
    });
//show update buttons    
    function showUpdate() {
        $('#btnSave').addClass('d-none');
        $('#btnUpdate').removeClass('d-none');
        $('#btnshowDelete').removeClass('d-none');
    }
//show save button    
    function showSave() {
        $('#btnSave').removeClass('d-none');
        $('#btnUpdate').addClass('d-none');
        $('#btnshowDelete').addClass('d-none');
    }
//Reset all fields    
    function resetinputFields() {
        $('#getName').val('');
        $('#getCode').val('');
        $('#btnUpdate').val('');
        $('#btnDelete').val('');
    }
//get form values
    function fromValues() {
        var data = {
            name: $('#getName').val(),
            code: $('#getCode').val()
        };
        return data;
    }
//HIDE ALL ERROR MSGS   
    function hideAllErrors() {
        $('#valName').addClass('d-none');
        $('#valCode').addClass('d-none');
        $('#uniName').addClass('d-none');
        $('#uniCode').addClass('d-none');
    }
</script>
@endsection
