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
<style>
    table.dataTable td {
        word-break: break-word;
    }

    td.fc-day.fc-past {
        background-color: #EEEEEE;
    }
</style>
@endsection
@section('content')
@if ($pageAuth['is_read'] == 1 || false)
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Pending Certificates</h1>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="nav-pending-cert-tab" data-toggle="pill" href="#pending-cert" role="tab" aria-controls="pending-cert" aria-selected="true">Pending Certificates</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav-fowarded-letters-tab" data-toggle="pill" href="#fowarded-letters" role="tab" aria-controls="fowarded-letters" aria-selected="false">Forwarded letters</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-five-tabContent">
                            <div class="tab-pane fade show active" id="pending-cert" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-tab">
                                <div class="overlay-wrapper">
                                    {{-- <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                                <div class="text-bold pt-2">Loading...</div>
                                            </div> --}}
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <h3 class="card-title">All Pending Certificates</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="card-body table-responsive" style="height: 450px;">
                                                <table class="table table-condensed" id="tblPendingCertificate">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10em">#</th>
                                                            <th style="width: 20em">Industry Name</th>
                                                            <th style="width: 30em">EPL Code</th>
                                                            <th style="width: 30em">Site Clearance Code</th>
                                                            <th style="width: 30em">File No</th>
                                                            <th>Nominate</th>
                                                            <th>Status</th>
                                                            <th style="width: 30em">Action</th>
                                                            <!-- <th></th> -->
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
                            <div class="tab-pane fade" id="fowarded-letters" role="tabpanel" aria-labelledby="custom-tabs-five-overlay-dark-tab">
                                <div class="overlay-wrapper">
                                    {{-- <div class="overlay dark"><i class="fas fa-3x fa-sync-alt fa-spin"></i>
                                                <div class="text-bold pt-2">Loading...</div>
                                            </div> --}}
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered" id="letter_view_tbl">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Code</th>
                                                        <th>Complainer Name</th>
                                                        <th>Address</th>
                                                        <th>Contact No</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
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
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../js/CertificatePreferJS/pending_certificate.js" type="text/javascript"></script>
<script src="../../plugins/datatables/ellipsis.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
        //Load table
        getaProfilebyId();
        //select button action
        $(document).on('click', '.btnAction', function() {});
        load_letters();
    });

        function load_letters() {
            let url = '/api/forwarded_complains/';
            ajaxRequest('GET', url, null, function(resp) {
                var letter_view_tbl = "";
                $('#letter_view_tbl').DataTable().destroy();
                $('#letter_view_tbl').DataTable({
                    responsive: true,
                    aLengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    "bDestroy": true,
                    iDisplayLength: 10
                });
                $.each(resp, function(key, value) {
                    key++;

                    letter_view_tbl += "<tr><td>" + key + "</td><td>" + value.complainer_code +
                        "</td><td>" + value.complainer_name + "</td><td>" + value.complainer_address +
                        "</td><td>" + value.comp_contact_no + "</td></td><td><a href='/complain_profile/id/" + value.id + "' class='btn btn-dark'>View</a></td></tr>";
                });
                $('#letter_view_tbl tbody').html(letter_view_tbl);

            });

            $('#letter_view_tbl').DataTable({
                responsive: true,
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "bDestroy": true,
                iDisplayLength: 10
            });
        }
</script>
@endsection
