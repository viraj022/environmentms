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
                <!--<h1>(<a href="/industry_profile/id/{file_id}">{file_no}</a>) {inspec_date} Committee Comments</h1>-->
                <h1>Committee Comments</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!--Add New Comment Section-->
                <div class="card card-success">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Add New Comment</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Comment*</label>
                                            <input id="getComment" type="text" class="form-control form-control-sm" placeholder="Enter Your Comment" value="">
                                            <a class="error invalid-feedback aefFGE d-none">Please enter your comment</a>
                                        </div>
                                        <div class="form-group" id="fileUpDiv">
                                            <hr>
                                            <label id="uploadLabel">Attachments:</label>
                                            <input id="fileUploadInput" type="file" class="" accept="image/*, .pdf">
                                            <div class="progress d-none">
                                                <div class="progress-bar bg-primary progress-bar-striped Uploadprogress" id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        @if($pageAuth['is_create']==1 || false)
                                        <button id="btnSave" type="submit" class="btn btn-success">Save</button>
                                        @endif
                                    </div>
                                    <!--                                    <div class="overlay dark disInspection">
                                                                            <p class="text-white"><i class="fa fa-check"></i> Inspection Completed </p>
                                                                        </div>-->
                                </div>
                            </div> 
                        </div>
                    </div>
                </div> 
                <div class="row" id="showUiDb">

                </div>
                <!--Add New Comment END-->
            </div>
            <div class="col-md-8">

            </div>
        </div>
        <!--        <div class="modal fade" id="modal-danger">
                    <div class="modal-dialog">
                        <div class="modal-content bg-danger">
                            <div class="modal-header">
                                <h4 class="modal-title">Delete Selected Remark</h4>
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
                         /.modal-content 
                    </div>
                     /.modal-dialog 
                </div>-->
</section>
@endif
@endsection



@section('pageScripts')
<!-- Page script -->

<!-- Select2 -->
<script src="/../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="/../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="/../../plugins/moment/moment.min.js"></script>
<script src="/../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="/../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="/../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="/../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="/../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/../../dist/js/demo.js"></script>
<!-- AdminLTE App -->
<script src="../../js/CommitteeRemarksJS/committee_remark_data.js" type="text/javascript"></script>
<script>
    $(function () {
        var ID = "{{$id}}";
        loadInterface(ID);
//        loadInspectionStatusAPI(ID, function (resp) { //<-- Get Inspection Status
//            if (resp.status === 0) {
//                $('.inspectConfStatus').removeClass('d-none'); //<-- Show Complete Inspection Btn
//                $('.disInspection').removeClass('overlay');
//            } else {
//                $('.inspectConfStatus').addClass('d-none'); //<-- Hide Complete Inspection Btn
//                $('.compDoneUi').removeClass('d-none'); //<-- Show Completed UI
//            }
//        });
//click save button
        $('#btnSave').click(function () {
            var data = fromValues();
            methodCommitteeRemarkAPI(data, 1, ID, function (resp) {
                if (resp.id === 1) {
                    loadInterface(ID);
                    resetinputFields();
                }
                show_mesege(resp);
            });
        });

//Reset all fields    
        function resetinputFields() {
            $('#getComment').val('');
            $('#btnUpdate').val('');
            $('#btnDelete').val('');
        }
//get form values
        function fromValues() {
            var data = {};
            if ($('#getComment').val().trim().length > 0) {
                data.remark = $('#getComment').val();
            }
            if ($('#fileUploadInput').get(0).files.length != 0) {
                data.file = $('#fileUploadInput')[0].files[0];
            }
            if (data.length == 0) {
                alert('Please add file or remark.');
                return false;
            }
            return data;
        }
        $('#getComment').keyup(function (e) {
            if (e.keyCode == 13)
            {
                $("#btnSave").click();
            }
        });
    });
</script>
@endsection
