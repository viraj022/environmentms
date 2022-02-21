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
        .project-tab {
            padding: 10%;
            margin-top: -8%;
        }

        .project-tab #tabs {
            background: #007b5e;
            color: #eee;
        }

        .project-tab #tabs h6.section-title {
            color: #eee;
        }

        .project-tab #tabs .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #0062cc;
            background-color: transparent;
            border-color: transparent transparent #f3f3f3;
            border-bottom: 3px solid !important;
            font-size: 16px;
            font-weight: bold;
        }

        .project-tab .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
            color: #0062cc;
            font-size: 16px;
            font-weight: 600;
        }

        .project-tab .nav-link:hover {
            border: none;
        }

        .project-tab thead {
            background: #f3f3f3;
            color: #333;
        }

        .project-tab a {
            text-decoration: none;
            color: #333;
            font-weight: 600;
        }

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

                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-pending-cert-tab" data-toggle="tab"
                                    href="#pending-cert" role="tab" aria-controls="pending-cert"
                                    aria-selected="true">Pending
                                    certificate table</a>
                                <a class="nav-item nav-link" id="nav-fowarded-letters-tab" data-toggle="tab"
                                    href="#fowarded-letters" role="tab" aria-controls="fowarded-letters"
                                    aria-selected="false">Forwarded letters</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="pending-cert" role="tabpanel"
                                aria-labelledby="nav-pending-cert-tab">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">All Pending Certificates</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="card-body table-responsive" style="height: 450px;">
                                            <table class="table table-condensed" id="tblPendingCertificate">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th style="width: 25em">Industry Name</th>
                                                        <th style="width: 25em">EPL Code</th>
                                                        <th style="width: 20em">File No</th>
                                                        <th>Nominate</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
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
                            <div class="tab-pane fade" id="fowarded-letters" role="tabpanel"
                                aria-labelledby="nav-fowarded-letters-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered" id="letter_view_tbl">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%">#</th>
                                                    <th style="width: 50%">title</th>
                                                    <th style="width: 25%">created date</th>
                                                    <th style="width: 10%">Action</th>
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
            let url = '/api/get_all_letters/';
            ajaxRequest('GET', url, null, function(resp) {
                var letter_view_tbl = "";
                $('#letter_view_tbl').DataTable().destroy();
                $.each(resp, function(key, value2) {
                    key++;
                    letter_view_tbl += "<tr><td>" + key + "</td><td>" + value2.letter_title + "</td><td>" +
                        value2.created_at + "</td><td><a href='/get_letter/letter/" + value2.id +
                        "' class='btn btn-success'>View</a></td></tr>";
                });
                $('#letter_view_tbl tbody').html(letter_view_tbl);
                $('#letter_view_tbl').DataTable({
                    responsive: true,
                    aLengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    "bDestroy": true,
                    iDisplayLength: 10
                });
            });
        }
    </script>
@endsection
