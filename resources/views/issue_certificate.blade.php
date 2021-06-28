@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
<!-- Select2 -->
<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
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
                <h1>(<a href="/epl_profile/client/{{$client}}/profile/{{$id}}">{{$epl_number}}</a>) - Issue EPL</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row d-none" id="showUiDb">
                    <div class="col-md-8">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title">Issue EPL</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group d-none">
                                    <input id="client_id" type="text" class="form-control form-control-sm" placeholder="" value="">
                                </div>
                                <div class="form-group">
                                    <label>Remark *</label>
                                    <input id="remark" type="text" class="form-control form-control-sm" placeholder="" value="Enter Text">
                                </div>
                                <div class="form-group">
                                    <label>Created Date *</label>
                                    <input id="createdDate" type="date" max="2999-12-31" class="form-control form-control-sm" placeholder="" value="">
                                </div>
                                <div class="form-group">
                                    <label>Upload Certificate *</label>
                                    <input id="fileUploadC" class="form-control form-control-sm" type="file" value="">
                                </div>
                                <button type="button" class="btn btn-lg btn-success" id="issueBtn"><i class="fas fa-check"></i> Issue EPL Certificate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <div class="col-md-12">
                            <div class="row d-none" id="showUiDb">
                                <div class="col-md-8">
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">Issue EPL</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Issue Date *</label>
                                                <input id="issueDate" type="date" max="2999-12-31" class="form-control form-control-sm" placeholder="" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Expire Date *</label>
                                                <input id="expireDate" type="date" max="2999-12-31" class="form-control form-control-sm" placeholder="" value="">
                                            </div>
                                            <div class="form-group">
                                                <label>Certificate Number *</label>
                                                <input id="certificateNo" type="text" class="form-control form-control-sm" placeholder="Enter Number" value="">
                                            </div>
                                            <button type="button" class="btn btn-lg btn-success" id="issueBtn"><i class="fas fa-check"></i> Issue EPL Certificate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
            <div class="col-md-12">
                <div class="row d-none" id="showData">
                    <div class="col-md-8">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title">EPL Issued</h3>
                            </div>
                            <div class="card-body">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center clientName">Certificate Information</h3>
                                    <p class="text-muted text-center clientNic">NIC_Data</p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Environment Officer</b> <a class="float-right eplName">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Certificate No</b> <a class="float-right eplCerNo">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Registration No</b> <a class="float-right eplRegNo">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Address</b> <a class="float-right clientAddr">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Contact No</b> <a class="float-right clientCont">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Email</b> <a class="float-right clientEmail">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Issue Date</b> <a class="float-right" id="eplissueDate">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Expire Date</b> <a class="float-right" id="eplExpireDate">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b id="eplexpireuiSetup">Dates To Expire</b> <a class="float-right" id="eplcalExpireDate">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Remarks</b> <a class="float-right eplRemark">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <button id="" type="button" class="btn btn-block btn-success btn-xs btnRenewal">Renew Certificate</button>
                                        </li>
                                    </ul>
                                </div>
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
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../js/issueEPLCertificate/all_js.js"></script>
<!--<script src="../../js/RemarksJS/update.js"></script>-->
<!--<script src="../../js/RemarksJS/delete.js"></script>-->
<!-- AdminLTE App -->
<script>
var EPL = "{{$id}}";
$(function () {
    alert();
    getEplCertificateDetails(EPL, function (parameters) {
        $('#client_id').val(parameters.client_id);
        if (parameters.status == 1) {
            $('#showUiDb').addClass('d-none');
            $('#showData').removeClass('d-none');
            //Set Issue Date
            $('#eplissueDate').html(parameters.issue_date);
            //Set Expire Date
            $('#eplExpireDate').html(parameters.expire_date);
            $('#eplcalExpireDate').html(parameters.date_different);
            var currentDate = new Date().toISOString().split('T')[0];
            if (currentDate >= parameters.expire_date) {
                $('#eplexpireuiSetup').html('Passed Away');
            } else {
                $('#eplexpireuiSetup').html('Dates To Expire');
            }
            //Date Filtering End            
            $('.clientName').html(parameters.name);
            $('.eplName').html(parameters.first_name + ' ' + parameters.last_name);
            $('.clientNic').html(parameters.code);
            $('.clientAddr').html(parameters.client.industry_address);
            $('.clientCont').html(parameters.contact_no);
            $('.clientEmail').html(parameters.email);
            $('.eplCerNo').html(parameters.certificate_no);
            $('.eplRegNo').html(parameters.client.industry_registration_no);
            $('.eplRemark').html(parameters.remark);
            $('.eplClientName').html(parameters.client.first_name + ' ' + parameters.client.last_name);
            $('.eplClientAdress').html(parameters.client.address);
            $('.eplClientMail').html(parameters.client.email);
            $('.eplClientConNo').html(parameters.client.contact_no);
            $('.eplClientNic').html(parameters.client.nic);
        } else {
            $('#showUiDb').removeClass('d-none');
            $('#showData').addClass('d-none');
        }
    });
    $("#issueBtn").click(function () {
        if (confirm('Are you sure you want to issue?')) {
            IssueCertificateEPL($('#client_id').val(), formData(), function (p) {
                show_mesege(p);
                if (p.id === 1) {
                    window.location.href = p.rout;
                }
            });
        } else {
            return false;
        }
    });

    function formData() {
        let data = {
            client_id: $("#client_id").val().trim(),
            remark: $("#remark").val().trim(),
            created_date: $("#createdDate").val().trim(),
            file: $('#fileUploadC')[0].files[0]
        };
        //        if (data.issue_date.length == 0 || data.expire_date.length == 0 || data.certificate_no.length == 0) {
        //            alert("Please Fill Correct Values !");
        //            return false;
        //        }
        return data;
    }
    $('.btnRenewal').click(function () {
        window.open("/renewal_page/id/" + EPL, '_blank');
    });
});
</script>
@endsection