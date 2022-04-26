@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
    @if ($pageAuth['is_read'] == 1 || false)
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <form action="/warn_report" target="_blank" method="get">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input id="getByAssDir" class="form-check-input" type="checkbox"
                                                    name="ad_check">
                                                <label class="form-check-label">Search By Assistant Director</label>
                                            </div>
                                            <div class="form-group">
                                                <select id="getAsDirect" class="form-control form-control-sm" name="ad_id">
                                                    <option value="0">Loading..</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ url('/warning_letter_log') }}" class="btn btn-dark  float-right"
                                                target="_blank">View Letter
                                                Log</a>
                                            <button class="btn btn-primary float-right">print</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="col-md-2">
                                    <button id="getByAssDirGenBtn" type="button"
                                        class="btn btn-block btn-primary btn-xs">Generate</button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="card-body table-responsive" style="height: 700px;">
                                    <table class="table table-condensed" id="tbl_warn_let_exp">
                                        <thead>
                                            <tr>
                                                <th style="width: 5em">#</th>
                                                <th style="width: 20em">Industry Name</th>
                                                <th style="width: 25em">File No</th>
                                                <th style="width: 25em">Pradeshiya Sabha</th>
                                                <th style="width: 20em">Status</th>
                                                <th style="width: 30em">Action</th>
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
            </div>
            </div>
        </section>
    @endif
@endsection

@section('pageScripts')
    <!-- Page script -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../js/CertificatePreferJS/expired_certificate.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script>
        $(function() {
            //Load table
            loadAssDirCombo();
            getWarnAssDir(null);

            $('#getAsDirect').change(function() {
                if ($('#getByAssDir').is(":checked")) {
                    getWarnAssDir($('#getAsDirect').val());
                } else {
                    getWarnAssDir(null);
                }
            });

            //select button action
            $(document).on('click', '#getByAssDirGenBtn', function() {
                if ($('#getByAssDir').is(":checked")) {
                    getWarnAssDir($('#getAsDirect').val());
                } else {
                    getWarnAssDir(null);
                }
            });

            $(document).on('click', '.gen-warn-letter', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Warning letter will be created!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, create letter!'
                }).then((result) => {
                    if (result.value) {
                        var data = {
                            "client_id": $(this).data('client'),
                            "expired_date": $(this).data('expire-date'),
                            "file_type": $(this).data('file-type')
                        };
                        create_warn_letter(data, function() {
                            getWarnAssDir(null);
                        });
                    }
                });
            });
        });

        function create_warn_letter(data, callBack) {
            var url = "/api/save_warning_letter";
            ajaxRequest('POST', url, data, function(result) {
                if (result.status == 1) {
                    swal.fire('Success', result.message, 'success');
                } else {
                    swal.fire('Error', result.message, 'error');
                }
                if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
                    callBack(result);
                }
            });
        }

        function getWarnAssDir(id, callBack) {
            var url = "/api/certificate/expiredCertificates";
            let data = null;
            if (id != null) {
                data = {
                    "ad_id": id
                };
            }
            ajaxRequest('GET', url, data, function(result) {
                var tbl = '';
                if (result.length == 0) {
                    tbl += '<td colspan="5">Data Not Found</td>';
                } else {
                    $('#tbl_warn_let_exp').DataTable().destroy();
                    $.each(result, function(index, row) {
                        console.log(row);
                        tbl += '<tr>';
                        tbl += '<td>' + ++index + '</td>';
                        tbl += '<td><a href="/industry_profile/id/' + row.client_id + '" target="_blank">' +
                            row.industry_name + '</a></td>';
                        tbl += '<td>' + row.code + '</td>';
                        tbl += '<td>' + row.pradesheeyasaba_name + '</td>';
                        tbl += '<td>' + row.expire_date + ' (' + row.due_date + ')</td>';
                        tbl += '<td>';
                        if (row.warning_count == 0) {
                            tbl +=
                                '<button type="button" class="btn btn-success gen-warn-letter" data-client="' +
                                row.client_id + '" data-expire-date="' + row.expire_date +
                                '" data-file-type="' + row.certificate_type +
                                '">Generate Warning Letter</button>';
                            tbl +=
                                '<button type="button" class="btn btn-info send_sms ml-1" data-client="' +
                                row.client_id + '" data-expire-date="' + row.expire_date +
                                '" data-industry-name="' + row.industry_name + '" data-tel="' + row
                                .contact_no + '">Send SMS</button>';
                        } else {
                            tbl += '<a href="/warn_view/id/' + row.last_letter +
                                '" class="btn btn-primary"  target="_blank">View Warning Letter</a>';
                            tbl +=
                                '<button type="button" class="btn btn-info send_sms ml-1" data-client="' +
                                row.client_id + '" data-expire-date="' + row.expire_date +
                                '" data-industry-name="' + row.industry_name + '" data-tel="' + row
                                .contact_no + '">Send SMS</button>';
                        }
                        tbl += '</td>';
                        tbl += '</tr>';
                    });
                    $('#tbl_warn_let_exp tbody').html(tbl);
                    $('#tbl_warn_let_exp').DataTable({
                        "stateSave": true,
                        "pageLength": 10,
                    });
                }
            });
            if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
                callBack(result);
            }
        }

        $(document).on('click', '.send_sms', function() {
            if ($(this).data('tel') != '') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Message will be send!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, send it!'
                }).then((result) => {
                    if (result.value) {
                        let data = {
                            "expire_date": $(this).data('expire-date'),
                            "PhoneNumber": $(this).data('tel'),
                            "client_id": $(this).data('client')
                        };
                        send_sms(data);
                    }
                });
            } else {
                swal.fire('warning', "There is no telephone number for this file", 'error');
            }
        });

        function send_sms(data) {
            let url = '/api/send_sms';
            ajaxRequest('POST', url, data, function(resp) {
                if (resp.status == 1) {
                    swal.fire('Success', 'Message sending successful', 'success');
                } else {
                    swal.fire('Error', 'Message sending was unsuccessful', 'error');
                }
            });
        }
    </script>
@endsection
