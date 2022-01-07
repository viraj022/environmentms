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
            <div class="col-md-12">
                <div class="card card-gray">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Assistant Director*</label>
                                    <select id="getAsDirect" class="form-control form-control-sm">
                                        <option value="0">Loading..</option>
                                    </select>
                                    <div id="valAsDirect" class="d-none"><p class="text-danger">Field is required</p></div>
                                </div>    
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Environment Officer*</label>
                                    <select id="getEnvOfficer" class="form-control form-control-sm">
                                        <option value="0">Loading..</option>
                                    </select>
                                    <div id="valEnvOfficer" class="d-none"><p class="text-danger">Field is required</p></div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>File Type*</label>
                                    <select id="getFileType" class="form-control form-control-sm">
                                    </select>
                                    <div id="valfileType" class="d-none"><p class="text-danger">Field is required</p></div>
                                </div> 
                            </div>
                        </div>
                    </div>  
                    <hr>
                    <div class="card">
                        <div class="card-body table-responsive" style="height: 450px;">
                            <table class="table table-condensed" id="tblAllFiles">
                                <thead>
                                    <tr class="tblTrsec">
                                        <th style="width: 10px">#</th>
                                        <th style='width: 25em'>Industry Name</th>
                                        <th style='width: 25em'>Client Name</th>
                                        <th style='width: 20em'>EPL Code</th>
                                        <th style='width: 20em'>Site Clearance Code</th>
                                        <th style='width: 25em'>File No</th>
                                        <th style='width: 25em'>#</th>
                                        <th style='width: 25em'>Status</th>
                                        <!--<th class="inspectTbl" style="width: 180px">Inspection</th>-->
                                        <th style='width: 5em'>Action</th>
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
    <!--Register New Client END-->

    <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalTitle">Modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Inspection*</label>
                        <select id="getInspection" class="form-control form-control-sm">
                            <option value="needed">Add To Inspection</option>
                            <option value="no_needed">No Inspection</option>
                        </select>
                        <div id="valInspection" class="d-none"><p class="text-danger">Field is required</p></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="setInspectionVal" class="btn btn-primary"><i class="fa fa-check"></i> Submit</button>
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
                        <textarea id="getMinutes" type="text" class="form-control form-control-sm" placeholder="Enter Minute..." value=""></textarea>
                    </div>
                    <div class="form-group d-none" id="nominate_certificate">
                        <label>For Certificate Prepare</label>
                        <textarea id="cert_nominate" type="text" class="form-control form-control-sm" placeholder="Add Comment" value=""></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" id="setInspectionVal2" class="btn btn-primary d-none"><i class="fa fa-check"></i> Set Inspection</button>
                    <button type="button" id="needApproval" class="btn btn-primary d-none"><i class="fa fa-check"></i> AD Approval</button>
                    <button type="button" id="submitAdCerApproval" class="btn btn-primary d-none"><i class="fa fa-check"></i> Submit For AD Certificate Approval</button>
                    <button type="button" id="rejectAdCerApproval" class="btn btn-danger d-none"><i class="fa fa-times"></i> Reject Certificate</button>
                    <button type="button" id="upCertificate" class="btn btn-primary d-none"><i class="fa fa-check"></i>Upload Certificate</button>
                    <div class="btn btn-group-lg">
                        <button type="button" id="viewCertificateBtn" class="btn btn-info d-none"><i class="fa fa-file"></i> View Certificate</button>
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
    var file_status = {0: 'pending', 1: 'AD File Approval Pending', 2: 'Certificate Preparation', 3: 'AD Certificate Prenidng Approval', 4: 'D Certificate Approval Prenidng', 5: 'Complete', 6: 'Issued', '-1': 'Rejected', '-2': 'Hold'};
    function minute() {
        var data = {
            minutes: $('#getMinutes').val().trim()
        };
        if ($('#cert_nominate').val().trim() != null || $('#cert_nominate').val().trim().length > 0) {
            data.nominate = $('#cert_nominate').val().trim();
        }
        return data;
    }
    fileStatusCombo(file_status);
    function fileStatusCombo(file_status) {
        var options = $('#getFileType');
        options.append($("<option>").val('all').text('All'));
        $.each(file_status, function (key, val) {
            options.append($("<option>").val(key).text(val));
        });
    }

    $(function () {
        //Load AssDir Combo
        loadAssDirCombo(function () {
            loadEnvOfficerCombo($('#getAsDirect').val(), function (rest) {
                if (rest === null) {
                    return false;
                } else {
                    forTypeFiles_table($('#getEnvOfficer').val(), $('#getFileType').val(), file_status);
                }
            });
        });
        $("#getAsDirect").change(function () {
            loadEnvOfficerCombo($('#getAsDirect').val(), function (rest) {
                if (rest === null) {
                    return false;
                } else {
                    forTypeFiles_table($('#getEnvOfficer').val(), $('#getFileType').val(), file_status);
                }
            });
        });
        $("#getEnvOfficer").change(function () {
            forTypeFiles_table($(this).val(), $('#getFileType').val(), file_status);
        });
        $("#getFileType").change(function () {
            forTypeFiles_table($('#getEnvOfficer').val(), $('#getFileType').val(), file_status);
        });
    });


    $(document).ready(function () {
        $(document).on('click', '#setInspectionVal2', function () {
            $('#setInspectionVal').val($(this).val());
        });
        $(document).on('click', '#setInspectionVal', function () {
            var fileData = JSON.parse(unescape($(this).val()));
            let f_id = fileData.id;
            checkInspectionStatus(f_id, $('#getInspection').val(), function (rep) {
                show_mesege(rep);
                $('#modal-xl').modal('hide');
                forTypeFiles_table($('#getEnvOfficer').val(), $('#getFileType').val(), file_status);
//                $("#tblAllFiles").DataTable().ajax.reload(null, false);
            });
            forTypeFiles_table($('#getEnvOfficer').val(), $('#getFileType').val(), file_status);
//            $("#tblAllFiles").DataTable().ajax.reload(null, false);
        });
    });


    $(document).on('click', '.detailsData', function () {
        var fileData = JSON.parse(unescape($(this).val()));
        let f_Status = fileData.file_status;
        console.log(f_Status);
        $('#modal-x2').modal();
        $('#getMinutes').val('');

        $('#needApproval').val($(this).val()); //<-- Share this button value to this button
        $('#submitAdCerApproval').val($(this).val()); //<-- Share this button value to submitAdCerApproval button
        $('#rejectAdCerApproval').val($(this).val()); //<-- Share this button value to submitAdCerApproval button
        $('#setInspectionVal2').val($(this).val()); //<-- Share this button value to setInspectionVal2 button
        $('#viewCertificateBtn').val($(this).val()); //<-- Share this button value to setInspectionVal2 button
        $('#upCertificate').val($(this).val()); //<-- Share this button value to setInspectionVal2 button
        $('#modalTitlex2').html(fileData.file_no);
        if (fileData.need_inspection != null && f_Status == 0) {
            $('#nominate_certificate').removeClass('d-none');
        } else {
            $('#nominate_certificate').addClass('d-none');
        }

        $('#needApproval,#submitAdCerApproval,#rejectAdCerApproval,#setInspectionVal2,#viewCertificateBtn').addClass('d-none');

        if (f_Status === 0 || f_Status === -1) {
            if (fileData.need_inspection == null) {
                $('#setInspectionVal2').removeClass('d-none');
            } else if (fileData.need_inspection == 'Completed') {
                $('#needApproval').removeClass('d-none');
            } else if (fileData.need_inspection == 'Inspection Not Needed') {
                $('#needApproval').removeClass('d-none');
            } else {
                $('#needApproval').addClass('d-none');
            }
        } else if (f_Status == 2) {
            if (fileData.cer_status == 2) {
                $('#submitAdCerApproval').removeClass('d-none');
                $('#rejectAdCerApproval').removeClass('d-none');
                $('#viewCertificateBtn').removeClass('d-none');
                $('#upCertificate').removeClass('d-none');
            }
        } else if (f_Status == -1) {
            $('#needApproval').addClass('d-none');
        } else {
            if (fileData.need_inspection == 'Inspection Not Needed') {
                $('#setInspectionVal2').addClass('d-none');
            } else {
                $('#setInspectionVal2').removeClass('d-none');
            }
        }
    });

    $(document).on('click', '#needApproval', function () {
        var fileData = JSON.parse(unescape($(this).val()));
        if (confirm('Are you sure you want to approve?')) {
            approvalApi(fileData.id, fileData.environment_officer_id, minute(), function (resp) {
                show_mesege(resp);
                if (resp.id == 1) {
                    $('#modal-x2').modal('hide');
                    forTypeFiles_table($('#getEnvOfficer').val(), $('#getFileType').val(), file_status);
//                    $("#tblAllFiles").DataTable().ajax.reload(null, false);
                }
            });
        }
    });

    $(document).on('click', '#submitAdCerApproval', function () {
        if ($('#getMinutes').val() != '') {
            var fileData = JSON.parse(unescape($(this).val()));
            if (confirm('Are you sure you want to approve?')) {
                adCertificateApproval(fileData.id, fileData.environment_officer_id, minute(), function (resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        $('#modal-x2').modal('hide');
                        forTypeFiles_table($('#getEnvOfficer').val(), $('#getFileType').val(), file_status);
//                    $("#tblAllFiles").DataTable().ajax.reload(null, false);
                    }
                });
            }
        } else {
            alert('Please enter the minute field!');
        }
    });
    $(document).on('click', '#rejectAdCerApproval', function () {
        if ($('#getMinutes').val() != '') {
            var fileData = JSON.parse(unescape($(this).val()));
            if (confirm('Are you sure you want to reject?')) {
                rejectCertificateApproval(fileData.id, fileData.environment_officer_id, minute(), function (resp) {
                    show_mesege(resp);
                    if (resp.id == 1) {
                        $('#modal-x2').modal('hide');
                        forTypeFiles_table($('#getEnvOfficer').val(), $('#getFileType').val(), file_status);
//                    $("#tblAllFiles").DataTable().ajax.reload(null, false);
                    }
                });
            }
        } else {
            alert('Please enter the minutes field!');
        }
    });
    //View certificate btn click
    $(document).on('click', '#viewCertificateBtn', function () {
        var fileData = JSON.parse(unescape($(this).val()));
        loadCertificatePathsApi(parseInt(fileData.id), function (set) {
            window.open(set.certificate_path, '_blank');
        });
    });
    $(document).on('click', '#upCertificate', function () {
        var fileData = JSON.parse(unescape($(this).val()));
        window.open('certificate_perforation/id/' + fileData.id, '_blank');
    });
    $(document).on('click', '#setInspectionVal2', function () {
        $('#modal-x2').modal('hide');
        $('#modal-xl').modal('show');
    });

</script>
@endsection
