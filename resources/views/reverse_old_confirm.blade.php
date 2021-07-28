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
                <h1>Comfirmed Files</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="col-md-12">
        <div class="card card-success card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                    <div class="col-md-12">
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">Confirmed Files</h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<!--                                <button class="btn btn-sm btn-primary" id="tblRefresh"><i class="fa fa-refresh"></i> Refresh</button>&nbsp;-->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="card-body table-responsive" style="height: 450px;">
                                    <table class="table table-condensed" id="tbl_confirm">
                                        <thead>
                                            <tr>
                                                <th>File No</th>
                                                <th>Client Name</th>
                                                <th>Industry Name</th>
                                                <th>BR No</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
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
<script src="../../js/oldConfirmJs/UnConfirmOldFile.js" type="text/javascript"></script>
<script src="../../js/IndustryProfileJS/upload_old_attachment.js" type="text/javascript"></script>
<script src="../../js/IndustryProfileJS/industry_profile.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    loadConfirmedTable();
    $(document).ready(function() {
        //Confirm Button
        $(document).on("click", ".btnUnconfirm", function() {
            if (confirm('Are you sure?')) {
                var id = $(this).val();
                UnConfirmUploadingAttachs(id, function(respo) {
                    show_mesege(respo);
                    if (respo.id == 1) {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
@endsection