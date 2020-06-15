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
                <h1>Assign EPL To Officer</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <label id="lblTitle">Un-assigned EPL</label>
                    </div>
                    <div class="card-body">
                        <label>Assistant Director</label>
                        <select class="form-control combo_AssistantDirector" id="ass_dir_combo"></select>
                        <table class="table table-condensed" id="pending_epl_table">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>EPL</th>
                                    <th style="width: 5%;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>


            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-body">
                        <label>Assistant Director</label>
                        <select class="form-control combo_envOfficer" id="env_officer_combo"></select>
                        <div class="card-body p-0">
                            <div class="card-body table-responsive" style="height: 550px;">
                                <table class="table table-condensed" id="assigned_epl_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th>EPL</th>
                                            <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
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
<!--<script src="../../plugins/select2/js/select2.full.min.js"></script>-->
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
<script src="../../js/epl_assign/epl_assign.js"></script>
<!-- AdminLTE App -->
<script>
    $(function () {

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000

        });

//Load table
        loadAssistantDirectorCombo(function () {
            loadEnvOfficers_combo(parseInt($('#ass_dir_combo').val()), function () {
                assigned_EPL_table(parseInt($('#env_officer_combo').val()));
            });
            pending_EPL_table(parseInt($('#ass_dir_combo').val()));
        });

        $('#env_officer_combo').change(function () {
            assigned_EPL_table(parseInt($('#env_officer_combo').val()));
        });

        $('#ass_dir_combo').change(function () {
            loadEnvOfficers_combo(parseInt($('#ass_dir_combo').val()), function () {
                assigned_EPL_table(parseInt($('#env_officer_combo').val()));
            });
            pending_EPL_table(parseInt($('#ass_dir_combo').val()));
        });

//click save button
        $('#btnSave').click(function () {
        });
//click update button
        $('#btnUpdate').click(function () {
        });
//click delete button
        $('#btnDelete').click(function () {});
//select button action 
        $(document).on('click', '.selPendingEpl', function () {
            let obj = {environment_officer_id: parseInt($("#env_officer_combo").val()), epl_id: parseInt($(this).val())};
            assign_epl_to_officer(obj, function (parameters) {
                if (parameters.id == 1) {
                    assigned_EPL_table(parseInt($('#env_officer_combo').val()));
                    pending_EPL_table(parseInt($('#ass_dir_combo').val()));

                }
            });
        });
        $(document).on('click', '.removePendingEpl', function () {
            remove_epl_from_officer(parseInt($(this).val()), function (parameters) {
                if (parameters.id == 1) {
                    assigned_EPL_table(parseInt($('#env_officer_combo').val()));
                    pending_EPL_table(parseInt($('#ass_dir_combo').val()));

                }
            });
        });
    });

</script>
@endsection
