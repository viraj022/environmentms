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
                <h1>Old File List</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Old Files</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body table-responsive" style="height: 450px;">
                            <table class="table table-condensed" id="tblOldFiles">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>BR</th>
                                        <th>Industry Name</th>
                                        <th >EPL</th>
                                        <th >Old Files</th>
                                        <th >Action</th>                                                        
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
<script src="../../js/OldFileListJS/old_file_list_api.js"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
//Load table
        getAllOldFilesApi();
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
