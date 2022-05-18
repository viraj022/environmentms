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
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                        <h1>Comfirmed Files</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <div class="col-md-12">
                <div class="card card-success card-outline card-tabs">
                    <div class="card-header p-0 pt-1 border-bottom-0">
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-two-tabContent">
                            <div class="col-md-12">
                                <div class="card card-dark">
                                    <div class="card-header">
                                        <h3 class="card-title">Confirmed Files</h3>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <!--                                <button class="btn btn-sm btn-primary" id="tblRefresh"><i class="fa fa-refresh"></i> Refresh</button>&nbsp;-->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="card-body table-responsive" style="height: 450px;">
                                            <table class="table table-condensed" id="tbl_confirm">
                                                <thead>
                                                    <tr>
                                                        <th>File No</th>
                                                        <th>Client Name</th>
                                                        <th>Industry Name</th>
                                                        <th>BR No</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="12" class="text-center"><b>No Data</b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </section>
    @endif
@endsection



@section('pageScripts')
    <!-- Page script -->

    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../js/oldConfirmJs/UnConfirmOldFile.js" type="text/javascript"></script>
    <script src="../../js/IndustryProfileJS/upload_old_attachment.js" type="text/javascript"></script>
    <script src="../../js/IndustryProfileJS/industry_profile.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script>
        $(document).ready(function() {
            var table = $('#tbl_confirm').DataTable({
                "processing": true,
                "serverSide": true,
                language: {
                    searchPlaceholder: "Search"
                },
                "ajax": {
                    "url": "/api/server_side_process",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{ csrf_token() }}"
                    }
                },
                "columns": [{
                        "data": "file_no",
                        render: function(data, type, row) {
                            return '<a href="/industry_profile/id/' + row.id +
                                '" target="_blank">' + row
                                .file_no + '</a>';
                        }
                    },
                    {
                        "data": "client_name"
                    },
                    {
                        "data": "industry_name"
                    },
                    {
                        "data": "industry_registration_no"
                    },
                    {
                        "data": "id"
                    }
                ],
                "columnDefs": [{
                    "targets": -1,
                    "data": "0",
                    "render": function(data, type, full, meta) {
                        return getJtableBtnHtml(full);
                    }
                }],

            });

            function getJtableBtnHtml(full) {
                var html = "";
                //encode a string
                html += '<div class="btn-group" role="group"  aria-label="" >';
                html += '<button type= "button" value="' + full.id +
                    '" type ="button" class ="btnUnconfirm btn btn-success btn-xs"> REVERT </button>';
                html += "</div>";
                return html;
            }

        });
        //Confirm Button
        $(document).on("click", ".btnUnconfirm", function() {
            if (confirm('Are you sure?')) {
                var id = $(this).val();
                UnConfirmUploadingAttachs(id, function(respo) {
                    show_mesege(respo);
                    if (respo.id == 1) {
                        location.reload();
                    }
                });
            }
        });
    </script>
@endsection
