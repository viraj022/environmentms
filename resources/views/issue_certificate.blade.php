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
                                <div class="form-group">
                                    <label>Issue Date *</label>
                                    <input id="issueDate" type="date" class="form-control form-control-sm" placeholder="" value="">
                                </div>
                                <div class="form-group">
                                    <label>Expire Date *</label>
                                    <input id="expireDate" type="date" class="form-control form-control-sm" placeholder="" value="">
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
            </div>
            <div class="col-md-12">
                <div class="row d-none" id="showData">
                    <div class="col-md-8">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h3 class="card-title">EPL Issued</h3>
                            </div>
                            <div class="card-body">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center clientName">{Client_name}</h3>
                                    <p class="text-muted text-center clientNic">NIC_Data</p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Address</b> <a class="float-right clientAddr">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Contact No</b> <a class="float-right clientCont">-</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Email</b> <a class="float-right clientEmail">-</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">EPL Number</span>
                                        <span class="info-box-number text-center text-muted mb-0" id="eplNum"></span>
                                    </div>
                                </div>
                                <dl>
                                    <dt>Issue Date</dt>
                                    <dd id="eplissueDate"></dd>
                                    <dt>Address</dt>
                                    <dd id="eplAddress"></dd>
                                </dl>
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
<script src="../../js/commonFunctions/functions.js"></script>
<!--<script src="../../js/RemarksJS/update.js"></script>-->
<!--<script src="../../js/RemarksJS/delete.js"></script>-->
<!-- AdminLTE App -->
<script>
$(function () {
    var EPL = "{{$id}}";
    getEplCertificateDetails(EPL, function (parameters) {
        if (parameters.status == 1) {
            $('#showUiDb').addClass('d-none');
            $('#showData').removeClass('d-none');
            $('#eplNum').html(parameters.code);
            $('#eplissueDate').html(parameters.created_at);
            $('.clientName').html(parameters.name);
//            $('.clientName').html(parameters.client.first_name + ' ' + parameters.client.last_name);
            $('.clientNic').html(parameters.client.nic);
            $('.clientAddr').html(parameters.client.address);
            $('.clientCont').html(parameters.client.contact_no);
            $('.clientEmail').html(parameters.client.email);
            $('.clientEmail').html(parameters.address);
        } else {
            $('#showUiDb').removeClass('d-none');
            $('#showData').addClass('d-none');
        }
    });
    $("#issueBtn").click(function () {
        IssueEpl(EPL, formData(), function (p) {

        });
    });
    function formData() {
        let data = {
            issue_date: $("#issueDate").val().trim(),
            expire_date: $("#expireDate").val().trim(),
            certificate_no: $("#certificateNo").val().trim()
        }
        if (data.issue_date.length == 0 || data.expire_date.length == 0 || data.certificate_no.length == 0) {
            alert("Please Fill Correct Values !");
            return false;
        }
        return data;
    }
});
</script>
@endsection
