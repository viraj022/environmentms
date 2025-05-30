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
    @if ((isset($pageAuth['is_read']) && $pageAuth['is_read'] == 1) || false)
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                        <h1>Director Approved List</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body table-responsive" style="">
                                <table class="table table-condensed" id="tblApprovedAdList">
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
                                <textarea id="getMinutes" type="text" class="form-control form-control-sm" placeholder="Enter Minute..."
                                    value=""></textarea>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="approveCertificate" class="btn btn-success d-none"><i class="fa fa-check"></i>
                                Approve Certificate</button>
                            <!--<button id="prepareCertificate" class="btn btn-success d-none"><i class="fa fa-check"></i> Approve Certificate</button>-->
                            <button type="button" id="holdCertificate" class="btn btn-warning d-none"><i
                                    class="fa fa-warning"></i> Hold Certificate</button>
                            <button type="button" id="uNholdCertificate" class="btn btn-warning d-none"><i
                                    class="fa fa-warning"></i> Un-Hold Certificate</button>
                            <button type="button" id="rejectCertificate" class="btn btn-danger d-none"><i
                                    class="fa fa-times"></i> Reject Certificate</button>
                            <button type="button" id="viewCertificateBtn" class="btn btn-info d-none"><i
                                    class="fa fa-file"></i> View Certificate</button>
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
    <script src="../../js/DirectorPendingJS/director_pending_list.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script>
        $(function() {
            //Load table
            $('#tblApprovedAdList').DataTable();
            loadDirectorApprovedListTable();
        });
    </script>
@endsection
