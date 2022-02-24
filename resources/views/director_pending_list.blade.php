@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
@endsection
@section('content')
@if($pageAuth['is_read']==1 || false)
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Director Pending List</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive" style="height: 450px;">
                        <table class="table table-condensed" id="tblPendingAdList">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Industry Name</th>
                                    <th>EPL Code</th>
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
                    <!--<button type="button" id="prepareCertificate" class="btn btn-primary d-none"><i class="fa fa-check"></i> Approve Certificate</button>-->
                    <div class="form-group">
                        <label>Minute</label>
                        <textarea id="getMinutes" type="text" class="form-control form-control-sm" placeholder="Enter Minute..." value=""></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="approveCertificate" class="btn btn-success d-none"><i class="fa fa-check"></i> Approve Certificate</button>
                    <!--<button id="prepareCertificate" class="btn btn-success d-none"><i class="fa fa-check"></i> Approve Certificate</button>-->
                    <button type="button" id="holdCertificate" class="btn btn-warning d-none"><i class="fa fa-warning"></i> Hold Certificate</button>
                    <button type="button" id="uNholdCertificate" class="btn btn-warning d-none"><i class="fa fa-warning"></i> Un-Hold Certificate</button>
                    <button type="button" id="rejectCertificate" class="btn btn-danger d-none"><i class="fa fa-times"></i> Reject Certificate</button>
                    <button type="button" id="viewCertificateBtn" class="btn btn-info d-none"><i class="fa fa-file"></i> View Certificate</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection

@section('pageScripts')
<!-- Page script -->
<script src="../../dist/js/adminlte.min.js"></script>
<script src="../../js/DirectorPendingJS/director_pending_list.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    function minute() {
        var data = {
            minutes: $('#getMinutes').val().trim()
        };
        if (data.minutes == null || data.minutes.length == 0) {
            alert('Please Add Minute First');
            return false;
        }
        return data;
    }
    $(function () {
//Load table
        loadDirectorPendingListTable();

        $(document).on('click', '.actionDetails', function () {
            var fileData = JSON.parse(unescape($(this).val()));
            let f_Status = fileData.file_status;
            $('#modal-x2').modal();
            $('#prepareCertificate').val($(this).val()); //<-- Share this button value to this button
            $('#rejectCertificate').val($(this).val()); //<-- Share this button value to this button
            $('#holdCertificate').val($(this).val()); //<-- Share this button value to this button
            $('#uNholdCertificate').val($(this).val()); //<-- Share this button value to this button
            $('#viewCertificateBtn').val($(this).val());
            $('#modalTitlex2').html(fileData.file_no);
            $('#approveCertificate,#prepareCertificate,#holdCertificate,#uNholdCertificate,#rejectCertificate').addClass('d-none'); //hide all buttons
            if (f_Status == 4) {
//                $("#viewCertificate").attr("href", "https://www.w3schools.com/jquery/");
                $('#prepareCertificate').removeClass('d-none');
                $('#approveCertificate').removeClass('d-none').val(fileData.id);
                $('#holdCertificate').removeClass('d-none');
                $('#rejectCertificate').removeClass('d-none');
                $('#viewCertificateBtn').removeClass('d-none');
            } else if (f_Status == -2) {
                $('#uNholdCertificate').removeClass('d-none');
            } else {
                $('#prepareCertificate').addClass('d-none');
                $('#approveCertificate').addClass('d-none');
                $('#holdCertificate').addClass('d-none');
                $('#rejectCertificate').addClass('d-none');
            }
        });

// prepare certificate button
        $(document).on('click', '#prepareCertificate', function () {
            var fileData = JSON.parse(unescape($(this).val()));
            if (confirm('Are you sure you want to approve?')) {
                preCertificateApi(fileData.id, minute(), 1, function (resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        loadDirectorPendingListTable();
                        $('#modal-x2').modal('hide');
                    }
                });
            }
        });

// reject certifcate button
        $(document).on('click', '#rejectCertificate', function () {
            if (minute() != '') {
            var fileData = JSON.parse(unescape($(this).val()));
            if (confirm('Are you sure you want to reject?')) {
                preCertificateApi(fileData.id, minute(), 2, function (resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        loadDirectorPendingListTable();
                        $('#modal-x2').modal('hide');
                    }
                });
            }
            }else{
                alert('Please Add Minute First!');
            }
        });

        // hold certificate button
        $(document).on('click', '#holdCertificate', function () {
            if (minute() != '') {
                var fileData = JSON.parse(unescape($(this).val()));
                if (confirm('Are you sure you want to hold?')) {
                    preCertificateApi(fileData.id, minute(), 3, function (resp) {
                        show_mesege(resp);
                        if (resp.id == 1) {
                            loadDirectorPendingListTable();
                            $('#modal-x2').modal('hide');
                        }
                    });
                }
            }else{
                alert('Please Add Minute First!');
            }
        });

        //unhold certificate button
        $(document).on('click', '#uNholdCertificate', function () {
            var fileData = JSON.parse(unescape($(this).val()));
            if (confirm('Are you sure you want to un-hold?')) {
                preCertificateApi(fileData.id, minute(), 4, function (resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        loadDirectorPendingListTable();
                        $('#modal-x2').modal('hide');
                    }
                });
            }
        });

        //View certificate btn click
        $(document).on('click', '#viewCertificateBtn', function () {
            var fileData = JSON.parse(unescape($(this).val()));
            loadCertificatePathsApi(parseInt(fileData.id), function (set) {
                window.open(set.certificate_path, '_blank');
            });
        });

        //approve certificate btn click
        $(document).on('click', '#approveCertificate', function () {
            let FILE_ID = parseInt($(this).val());
            if (isNaN(FILE_ID)) {
                alert('Invalid File Id');
                return false;
            }
            DirectorFinalApproval(FILE_ID, minute(), function (parameters) {
                if (parameters.message == 'true') {
                    loadDirectorPendingListTable();
                    $('#modal-x2').modal('hide');
                }
            });
        });

    });

</script>
@endsection
