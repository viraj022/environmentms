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
    @if ($pageAuth['is_read'] == 1 || false)
        <section class="content-header">
            <div class="container-fluid">
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Report Dashboard</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label>Report*</label>
                                            <select id="report_type_cmbo" class="form-control form-control-sm">
                                                <option value="1">Site Clearance Report</option>
                                                <option value="7">Site Clearance Application Log Report </option>
                                                <option value="2">EPL Report</option>
                                                <option value="3">EPL Application Log Report</option>
                                                <option value="4">Progress Report</option>
                                                <option value="5">EO Inspection Report</option>
                                                <option value="6">File Count By Category Report</option>
                                                <option value="8">EPL/SC Full Detailed Report</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>From Date*</label>
                                            <input id="startDate" type="date" max="2999-12-31"
                                                class="form-control form-control-sm" placeholder="Enter Date..."
                                                value="">
                                        </div>
                                        <div class="form-group">
                                            <label>To Date*</label>
                                            <input id="endDate" type="date" max="2999-12-31"
                                                class="form-control form-control-sm" placeholder="Enter Date..."
                                                value="">
                                        </div>
                                    </div>


                                    <div class="col-md-6">

                                        <div class="col-md-6">
                                            <div class="form-group" id="generateBy_section">
                                                <label>Get*</label>
                                                <select id="rep_type" class="form-control form-control-sm">
                                                    <option value="all">All Files</option>
                                                    <option value="new">New Files</option>
                                                    <option value="extend">Extend Files</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="d-none" id="officer_section">
                                            <div class="form-group">
                                                <label>Assistant Director:</label>
                                                <select id="getAsDirect" class="form-control form-control-sm">
                                                    <option value="0">Loading..</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Environment Officer:</label>
                                                <select id="eoCombo" class="form-control form-control-sm">
                                                    <option value="0">Loading..</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="industryCat_section">
                                            <label>Industry Category:</label>
                                            <select id="industryCatCombo" class="form-control form-control-sm">
                                                <option value="">Select Category</option>
                                                @foreach ($industryCategory as $ic)
                                                    <option value="{{ $ic->id }}">{{ $ic->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group" id="epl_category_section">
                                            <label>Get*</label>
                                            <select id="epl_rep_type" class="form-control form-control-sm">
                                                <option value="all">All Files</option>
                                                <option value="new">New Files</option>
                                                <option value="renew">Renewed Files</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-2">
                                        <button id="getByAssDirGenBtn" type="button"
                                            class="btn btn-block btn-primary btn-xs">Generate</button>
                                    </div>
                                    <div class="col-md-2">
                                        {{-- hard refresh check box --}}
                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="hardRefresh">
                                            <label class="form-check label" for="hardRefresh">Hard Refresh</label>
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
    <script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>

    <script src="/../../js/\ReportsJS\report_dashboard.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- AdminLTE App -->
    <script>
        $(function() {
            loadAssDirCombo(function() {
                env_officer_byAD(parseInt($('#getAsDirect').val()));
            });
            $('#getAsDirect').change(function() {
                env_officer_byAD(parseInt($('#getAsDirect').val()));
            });
            $('#report_type_cmbo').change(function() {
                $('#officer_section').addClass('d-none');
                $('#generateBy_section').addClass('d-none');
                $('#industryCat_section').addClass('d-none');
                $('#epl_category_section').addClass('d-none');
                let rep = parseInt($(this).val());
                switch (rep) {
                    case 1:
                        $('#generateBy_section').removeClass('d-none');
                        break;
                    case 5:
                        $('#officer_section').removeClass('d-none');
                        break;
                    case 8:
                        $('#officer_section').removeClass('d-none');
                        $('#industryCat_section').removeClass('d-none');
                        $('#epl_category_section').removeClass('d-none');
                        break;
                }
            });
            //select button action
            $(document).on('click', '#getByAssDirGenBtn', function() {
                let rep = parseInt($('#report_type_cmbo').val());
                let URL = '';
                let qStr = '';
                let date_from = $('#startDate').val().trim();
                let date_to = $('#endDate').val().trim();
                if (date_from.length == 0 || date_to.length == 0) {
                    alert('Please Select Date Properly!');
                    return false;
                }
                let eo_id = $('#eoCombo').val();
                switch (rep) {
                    case 1:
                        URL = '/site_clearance_report/' + date_from + '/' + date_to + '/' + $('#rep_type')
                            .val();
                        break;
                    case 2:
                        URL = '/epl_report/' + date_from + '/' + date_to;
                        break;
                    case 3:
                        URL = '/epl_application_log/' + date_from + '/' + date_to;
                        break;
                    case 4:
                        URL = '/monthly_progress/' + date_from + '/' + date_to;
                        break;
                    case 5:
                        URL = '/ep_inspection_report/' + eo_id + '/' + date_from + '/' + date_to;
                        break;
                    case 6:
                        URL = '/category_count_report/' + date_from + '/' + date_to;
                        break;
                    case 7:
                        URL = '/site_clearence_log/' + date_from + '/' + date_to;
                        break;
                    case 8:
                        //add query params
                        if ($('#industryCatCombo :selected').val() != '') {
                            qStr = '?industry_cat_id=' + $('#industryCatCombo :selected').val();
                        }
                        if (!isNaN(parseInt($('#eoCombo :selected').val()))) {
                            qStr += (qStr.length > 0 ? '&' : '?') + 'eo_id=' + $('#eoCombo :selected')
                                .val();
                        } else if (!isNaN(parseInt($('#getAsDirect :selected').val()))) {
                            qStr += (qStr.length > 0 ? '&' : '?') + 'ad_id=' + $(
                                '#getAsDirect :selected').val();
                        }
                        if ($('#epl_rep_type').val() != 'all') {
                            qStr += (qStr.length > 0 ? '&' : '?') + 'epl_type=' + $('#epl_rep_type')
                                .val();
                        }
                        URL = '/license_full_detail_report/' + date_from + '/' + date_to + qStr;
                        break;
                }
                //check if hard refresh is checked
                if ($('#hardRefresh').is(':checked')) {
                    URL += (qStr.length > 0 ? '&' : '?') + 'hard_refresh=1';
                }

                window.open(URL, '_blank');
            });
        });
    </script>
@endsection
