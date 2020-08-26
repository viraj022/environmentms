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
                <h1>Industry Files</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <!--    Register New Client START-->
    <div class="container-fluid reg-newClient">
        <div class="row">
            <div class="col-md-5">
                <div class="card card-primary">
                    <div class="card-header">
                        <label id="lblTitle">Update Client</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Assistant Director*</label>
                            <select id="getAsDirect" class="form-control form-control-sm">
                                <option value="0">Loading..</option>
                            </select>
                            <div id="valAsDirect" class="d-none"><p class="text-danger">Field is required</p></div>
                        </div>
                        <div class="form-group">
                            <label>Environment Officer*</label>
                            <select id="getEnvOfficer" class="form-control form-control-sm">
                                <option value="0">Loading..</option>
                            </select>
                            <div id="valEnvOfficer" class="d-none"><p class="text-danger">Field is required</p></div>
                        </div>
                        <div class="form-group">
                            <label>File Type*</label>
                            <select id="getFileType" class="form-control form-control-sm">
                                <option value="01">New</option>
                                <option value="02">Working</option>
                                <option value="03">All</option>
                            </select>
                            <div id="valfileType" class="d-none"><p class="text-danger">Field is required</p></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button id="btnSave" type="submit" class="btn btn-success">Check</button>
                        @endif
                        @if($pageAuth['is_delete']==1 || false)
                        <button  id="btnshowDelete" type="submit" class="btn btn-danger d-none"  data-toggle="modal"
                                 data-target="#modal-danger">Delete</button>
                        @endif
                    </div>                           
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title setCurrentEnvProf">All Data</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="card-body table-responsive" style="height: 450px;">
                            <table class="table table-condensed" id="tblAllFiles">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Industry Name</th>
                                        <th>Date</th>
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
    </div>
    <!--Register New Client END-->
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
<script src="../../js/IndustryFilesJS/industry_files_data.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- AdminLTE App -->
<script>
    let PROFILE_ID = '11';
    $(function () {
//Load table
        //Load AssDir Combo
        loadAssDirCombo(function () {
            loadEnvOfficerCombo($('#getAsDirect').val(), function (rest) {
                loadAllFilesApi($('#getEnvOfficer').val(), function (respo) {
                });
            });
        });
        $("#getAsDirect").change(function () {
            loadEnvOfficerCombo($('#getAsDirect').val(), function (rest) {
            });
        });
        $("#getEnvOfficer").change(function () {

        });
    });


    $(document).ready(function () {
        $('#btnSave').on('click', function () {
            switch ($('#getFileType option:selected').val()) {
                case '01':
                    loadNewFilesApi($('#getEnvOfficer').val(), function (respo) {
                        forTypeFiles_table(respo);
                    });
                    break;
                case '02':
                    loadWorkingFilesApi($('#getEnvOfficer').val(), function (respo) {
                        forTypeFiles_table(respo);
                    });
                    break;
                case '03':
                    loadAllFilesApi($('#getEnvOfficer').val(), function (respo) {
                        forTypeFiles_table(respo);
                    });
                    break;
            }
        });
    });

    function checkFileType() {
        switch ($('#getFileType option:selected').val()) {
            case '01':
                loadNewFilesApi($('#getEnvOfficer').val(), function (respo) {
                    forTypeFiles_table(respo);
                });
                break;
            case '02':
                loadWorkingFilesApi($('#getEnvOfficer').val(), function (respo) {
                    forTypeFiles_table(respo);
                });
                break;
            case '03':
                loadAllFilesApi($('#getEnvOfficer').val(), function (respo) {
                    forTypeFiles_table(respo);
                });
                break;
        }
    }

</script>
@endsection
