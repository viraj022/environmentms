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
                <h1>AD Pending List</h1>
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
                        <div class="form-group" id="comboAssistantDirectorDisplay">
                            <label>Assistant Director*</label>
                            <select id="getAssistantDirector" class="form-control form-control-sm combo_AssistantDirector" style="width: 100%;" ></select>
                            <div id="valZone" class="d-none"><p class="text-danger">Field is required</p></div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body table-responsive" style="height: 450px;">
                            <table class="table table-condensed" id="tblPendingAdList">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Industry Name</th>
                                        <th>File No</th>
                                        <th>Status</th>
                                        <th style="width: 140px">Action</th>
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
    <div class="modal fade" id="modal-x2">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitlex2">Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Minute</label>
                        <textarea id="getMinutes" maxlength="55" type="text" class="form-control form-control-sm" placeholder="Enter Minute..." value=""></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="prepareCertificate" class="btn btn-primary d-none"><i class="fa fa-check"></i> Approve For Prepare Certificate</button>
                    <button type="button" id="approveCertificate" class="btn btn-primary d-none"><i class="fa fa-check"></i> Approve Certificate</button>
                    <button type="button" id="rejectCertificate" class="btn btn-danger d-none"><i class="fa fa-times"></i> Reject Certificate</button>
                    <button type="button" id="approveFile" class="btn btn-primary d-none"><i class="fa fa-times"></i> Approve File</button>
                    <button type="button" id="rejectFile" class="btn btn-danger d-none"><i class="fa fa-times"></i> Reject File</button>
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
<script src="../../js/AdPendingJS/ad_pending_list.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    function minute() {
        var data = {
            minutes: $('#getMinutes').val()
        };
        return data;
    }
    $(function () {
//Load table
        loadAssistantDirectorCombo(function () {
            loadAdPendingListTable($('#getAssistantDirector').val());
        });

        $('#getAssistantDirector').change(function () {
            loadAdPendingListTable($('#getAssistantDirector').val());
        });
//select button action 
        $(document).on('click', '.btnAction', function () {
        });


        $(document).on('click', '.actionDetails', function () {
            var fileData = JSON.parse(unescape($(this).val()));
            let f_Status = fileData.file_status;
            $('#modalTitlex2').html(fileData.file_no);
            $('#modal-x2').modal();

            $('#prepareCertificate').val($(this).val()); //<-- Share this button value to this button
            $('#approveCertificate').val($(this).val()); //<-- Share this button value to this button
            $('#rejectCertificate').val($(this).val()); //<-- Share this button value to this button
            $('#approveFile').val($(this).val()); //<-- Share this button value to this button
            $('#rejectFile').val($(this).val()); //<-- Share this button value to this button
            $('#prepareCertificate,#approveFile,#rejectFile,#approveCertificate,#rejectCertificate').addClass('d-none');
            if (f_Status == 1) {
                $('#approveFile').removeClass('d-none');
                $('#rejectFile').removeClass('d-none');
            } else if (f_Status == 3) {
                $('#approveCertificate').removeClass('d-none');
                $('#rejectCertificate').removeClass('d-none');
            } else {
                $('#prepareCertificate').addClass('d-none');
            }
        });

        $(document).on('click', '#prepareCertificate', function () {
            var fileData = JSON.parse(unescape($(this).val()));
            if (confirm('Are you sure you want to approve?')) {
                preCertificateApi(fileData.id, $('#getAssistantDirector').val(), minute(), function (resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        loadAdPendingListTable($('#getAssistantDirector').val());
                        $('#modal-x2').modal('hide');
                    }
                });
            }
        });
        $(document).on('click', '#approveCertificate', function () { // approve certificate btn
            var fileData = JSON.parse(unescape($(this).val()));
            if (confirm('Are you sure you want to approve?')) {
                certificateApproveApi(fileData.id, $('#getAssistantDirector').val(), minute(), function (resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        loadAdPendingListTable($('#getAssistantDirector').val());
                        $('#modal-x2').modal('hide');
                    }
                });
            }
        });
        $(document).on('click', '#rejectCertificate', function () { // reject certificate btn
            var fileData = JSON.parse(unescape($(this).val()));
            if (confirm('Are you sure you want to reject?')) {
                certificateRejectApi(fileData.id, $('#getAssistantDirector').val(), minute(), function (resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        loadAdPendingListTable($('#getAssistantDirector').val());
                        $('#modal-x2').modal('hide');
                    }
                });
            }
        });
        $(document).on('click', '#approveFile', function () { // approveFile btn
            var fileData = JSON.parse(unescape($(this).val()));
            if (confirm('Are you sure you want to approve?')) {
                fileApproveApi(fileData.id, $('#getAssistantDirector').val(), minute(), function (resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        loadAdPendingListTable($('#getAssistantDirector').val());
                        $('#modal-x2').modal('hide');
                    }
                });
            }
        });
        $(document).on('click', '#rejectFile', function () { // reject file btn
            var fileData = JSON.parse(unescape($(this).val()));
            if (confirm('Are you sure you want to reject?')) {
                fileRejectApi(fileData.id, $('#getAssistantDirector').val(), minute(), function (resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        loadAdPendingListTable($('#getAssistantDirector').val());
                        $('#modal-x2').modal('hide');
                    }
                });
            }
        });

    });

</script>
@endsection
