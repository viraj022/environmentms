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
                <h1>Pradeshiya sabha</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="card card-gray">
                    <div class="card-header">
                        <label class="card-title" id="lblTitle">Add New Pradeshiya sabha</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Zone*</label>
                            <select id="getZone" class="form-control form-control-sm         combo_zone">
                                <option>Loading...</option>
                            </select>
                            <div id="valZone" class="d-none">
                                <p class="text-danger">Field is required</p>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Name*</label>
                            <input id="getName" maxlength="50" type="text" class="form-control form-control-sm" placeholder="Enter Name..." value="">
                            <div id="valName" class="d-none">
                                <p class="text-danger">Name is required</p>
                            </div>
                            <div id="valUnique" class="d-none">
                                <p class="text-danger">Name already taken!</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Code*</label>
                            <input maxlength="10" id="getCode" type="text" class="form-control form-control-sm" placeholder="Enter Code..." value="">
                            <div id="valCode" class="d-none">
                                <p class="text-danger">Code is required</p>
                            </div>
                            <div id="valCodeLen" class="d-none">
                                <p class="text-danger">Code Maximum Character Must Be 10</p>
                            </div>
                            <div id="valcodeUnique" class="d-none">
                                <p class="text-danger">Code already taken!</p>
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
                        <button id="btnshowDelete" type="submit" class="btn btn-danger d-none" data-toggle="modal" data-target="#modal-danger">Delete</button>
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-md-7">
                <div class="card card-gray">
                    <div class="card-header">
                        <h3 class="card-title">Pradeshiya sabha</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-2"><label>Zone*</label></div>
                                            <div class="col-md-10">
                                                <select id="getZoneForTbl" class="form-control form-control-sm combo_zone">
                                                    <option>Loading...</option>
                                                </select>
                                                <div id="valZone" class="d-none">
                                                    <p class="text-danger">Field is required</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="check_all_Zone">
                                            <label class="form-check-label" for="check_all_Zone">All</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body table-responsive" style="height: 450px;">
                            <table class="table table-condensed assignedPrivilages" id="tblPradesiyasaba">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Action</th>
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
    </div>
    </div>
    </div>
    <div class="modal fade" id="modal-danger">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Pradeshiya sabha</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><b>Are you sure you want to permanently delete this Pradeshiya sabha ? </b></p>
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
<script src="../../js/pradeshiyasabajs/submit.js"></script>
<script src="../../js/pradeshiyasabajs/get.js"></script>
<script src="../../js/pradeshiyasabajs/update.js"></script>
<script src="../../js/pradeshiyasabajs/delete.js"></script>
<!-- AdminLTE App -->
<script>
    $(function() {
        //combo and Load table

        loadZoneCombo(function() {
            loadPradeshiyaSabaTblByZone($('#getZoneForTbl').val());

        });

        //click save button
        $('#btnSave').click(function() {
            var data = fromValues();
            if (Validiteinsert(data)) {
                uniqueNamecheck(data.name, function(r) {
                    uniqueCodecheck(data.code, function(re) {
                        if (r.message == 'unique') {
                            if (re.message == 'unique') {
                                AddPradeshiyasaba(data, function(result) {

                                    resetinputFields();
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
                                    //  alert($('#getZone').val());

                                    $('#check_all_Zone').prop('checked', false);
                                    $('#getZoneForTbl').val($('#getZone').val());
                                    //alert($('#getZoneForTbl').val());
                                    loadPradeshiyaSabaTblByZone($('#getZone').val());


                                });
                            } else {
                                $('#valName').addClass('d-none');
                                $('#valcodeUnique').removeClass('d-none');
                            }
                        } else {
                            $('#valName').addClass('d-none');
                            $('#valUnique').removeClass('d-none');
                        }
                    });
                });
            }
            hideAllErrors();
        });
        //click update button
        $('#btnUpdate').click(function() {
            //get form data
            var data = fromValues();
            if (Validiteupdate(data)) {
                updatePradesheeyasaba($('#btnUpdate').val(), data, function(result) {
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
                    $('#check_all_Zone').prop('checked', false);
                    loadPradeshiyaSabaTblByZone($('#getZone').val());
                    showSave();
                    resetinputFields();
                });
            }
            hideAllErrors();
        });
        //click delete button
        $('#btnDelete').click(function() {
            deletePradesheeyasaba($('#btnDelete').val(), function(result) {
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
                $('#check_all_Zone').prop('checked', false);
                loadPradeshiyaSabaTblByZone($('#getZone').val());
                showSave();
                resetinputFields();
            });
            hideAllErrors();
        });
        //select button action 
        $(document).on('click', '.btnAction', function() {
            getaPradesiyasababyId(this.id, function(result) {
                $('#getZone').val(result.zone_id);
                $('#getName').val(result.name);
                $('#getCode').val(result.code);
                showUpdate();
                $('#btnUpdate').val(result.id);
                $('#btnDelete').val(result.id);
            });
            hideAllErrors();
        });
    });
    //Check change of name input   
    $('#getName').change(function() {
        var data = fromValues();
        uniqueNamecheck(data.name, function(r) {
            //            alert(JSON.stringify(r));
            if (r.message == 'unique') {
                $('#valName').addClass('d-none');
                $('#valCode').addClass('d-none');
                $('#valUnique').addClass('d-none');

            } else {
                $('#valName').addClass('d-none');
                $('#valCode').addClass('d-none');
                $('#valUnique').removeClass('d-none');
            }
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
    //HIDE ALL ERROR MSGS   
    function hideAllErrors() {
        $('#valcodeUnique').addClass('d-none');
        $('#valUnique').addClass('d-none');
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
            zone_id: $('#getZone').val(),
            name: $('#getName').val(),
            code: $('#getCode').val()
        };
        return data;
    }


    $('#getZoneForTbl').change(function() {

        // getPradeshiyaSabaByZone($(this).val());
        $('#check_all_Zone').prop('checked', false);
        loadPradeshiyaSabaTblByZone($(this).val());

    });


    $('#check_all_Zone').change(function() {
        if (this.checked) {

            loadTable();
        }
        // else
        // {
        //    loadPradeshiyaSabaTblByZone('#getZoneForTbl'); 
        // }

    });
</script>
@endsection