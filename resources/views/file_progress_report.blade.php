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
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Files Progress</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <!--    Register New Client START-->
    <div class="container-fluid reg-newClient">
        <div class="row">
            <div class="col-md-12">
                <!--<form id="">-->
                <!--                    <div class="card card-gray">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Industry Category</label><input id="is_industry" name="industry_category_check" class='ml-3' type="checkbox"/>
                                                                            <select id="industry_cat" name="industry_category" class="form-control form-control-sm">
                                                                                <option value="0">Loading..</option>
                                                                            </select>
                                                                        </div> 
                                                                        <button type='button' id='report_generate' class='btn btn-primary'>Generate Report</button>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Pradeshiya Saba</label><input id="is_pradeshiya_sabha" name="pradeshiya_sabha_check" class="ml-3" type="checkbox"/>
                                                                            <select id="pradeshiya_sabha" name="pradeshiya_sabha" class="form-control form-control-sm">
                                                                                <option value="0">Loading..</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        </div>-->
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-condensed" id="eo_client_tbl">
                            <thead>
                                <tr class="tblTrsec">
                                    <th style="width: 10px">#</th>
                                    <th style='width: 15em'>File</th>
                                    <th style='width: 8em'>Type</th>
                                    <th style='width: 20em'>Client Name</th>
                                    <th style='width: 20em'>Industry Category</th>
                                    <th style='width: 10em'>File Updated Date</th>
                                    <th style='width: 10em'>Created At</th>
                                    <th style='width: 10em'>File Status</th>

                                    <!--<th class="inspectTbl" style="width: 180px">Inspection</th>-->
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--</form>-->
            </div>
        </div>
    </div>
    <!--Register New Client END-->

</section>

@endsection

@section('pageScripts')
<!-- Page script -->

<!-- Select2 -->
<!--<script src="../../plugins/select2/js/select2.full.min.js"></script>-->
<!-- Bootstrap4 Duallistbox -->
<!--<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>-->
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<!--<script src="../../plugins/daterangepicker/daterangepicker.js"></script>-->
<!-- bootstrap color picker -->
<!--<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>-->
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<!--<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>-->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- AdminLTE App -->
<script>
    //    IndustryCategoryCombo();
    //    loadPradeshiyaSabha();
    fileProgressReport();

    $('#report_generate').click(function() {
        fileProgressReport();
    });

    //    function loadPradeshiyaSabha(callBack) {
    //        var cbo = "";
    //        ajaxRequest('GET', "/api/pradesheeyasabas", null, function (dataSet) {
    //            if (dataSet) {
    //                $.each(dataSet, function (index, row) {
    //                    cbo += '<option data-ps_code="' + row.code + '" value="' + row.id + '">' + row.code + ' - ' + row.name + '</option>';
    //                });
    //            } else {
    //                cbo = "<option value=''>No Data Found</option>";
    //            }
    //            $('#pradeshiya_sabha').html(cbo);
    //            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
    //                callBack();
    //            }
    //        });
    //    }
    //    function IndustryCategoryCombo(callBack) {
    //        var cbo = "";
    //        ajaxRequest('GET', "/api/industrycategories", null, function (dataSet) {
    //            if (dataSet) {
    //                $.each(dataSet, function (index, row) {
    //                    cbo += '<option data-cat_code="' + row.code + '" value="' + row.id + '">' + row.name + '</option>';
    //                });
    //            } else {
    //                cbo = "<option value=''>No Data Found</option>";
    //            }
    //            $('#industry_cat').html(cbo);
    //            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
    //                callBack();
    //            }
    //        });
    //    }
    var file_status = {
        0: 'EO pending',
        1: 'AD File Approval Pending',
        2: 'Certificate Preparation',
        3: 'AD Certificate Prenidng Approval',
        4: 'D Certificate Approval Prenidng',
        5: 'Complete',
        6: 'Issued',
        '-1': 'Rejected',
        '-2': 'Hold'
    };
    var file_type_status = {
        0: 'pending',
        1: 'New EPL',
        2: 'EPL Renew',
        3: 'Site Clearance',
        4: 'Extend Site Clearance'
    };

    function fileProgressReport() {
        var tbl = "";
        let data = $("#eo_report_form").serializeArray();

        $('#eo_client_tbl').DataTable().destroy();
        let index = 1;
        table = $('#eo_client_tbl').DataTable({
            "destroy": true,
            "processing": true,
            "colReorder": true,
            "serverSide": true,
            "pageLength": 10,
            language: {
                searchPlaceholder: "Search..."
            },
            ajax: {
                "url": "/api/file_progress",
                "type": "GET",
                "dataSrc": "",
                "headers": {
                    "Accept": "application/json",
                    "Content-Type": "text/json; charset=utf-8",
                    "Authorization": "Bearer " + $('meta[name=api-token]').attr("content")
                },
            },
            "columnDefs": [{
                    "targets": 1,
                    "data": "",
                    "render": function(data, type, row, meta) {
                        return "<td><a href='/industry_profile/id/" + row.id + "'  target=\"_blank\">" +
                            row.file_no + "</a></td>";
                    }
                },
                {
                    "targets": 2,
                    "data": "",
                    "render": function(data, type, row, meta) {
                        return file_type_status[row.cer_type_status];
                    }
                },
                {
                    "targets": 3,
                    "data": "",
                    "render": function(data, type, row, meta) {
                        return row.first_name + ' ' + row.last_name;
                    }
                },
                {
                    "targets": 4,
                    "data": "",
                    "render": function(data, type, row, meta) {
                        return row.industry_category.name;
                    }
                },
                {
                    "targets": 5,
                    "data": "",
                    "render": function(data, type, row, meta) {
                        return row.updated_at;
                    }
                },
                {
                    "targets": 6,
                    "data": "",
                    "render": function(data, type, row, meta) {
                        return formatDate(row.created_at);
                    }
                },
                {
                    "targets": 7,
                    "data": "",
                    "render": function(data, type, row, meta) {
                        if (isNaN(parseInt(row.environment_officer_id))) {
                            tbl = "<td style='color:red;'>Not Assigned</td>";
                        } else {
                            tbl = "<td>" + file_status[row.file_status] + "</td>";
                        }
                        return tbl;
                    }
                }
            ]
        });
        //data table error handling
        $.fn.dataTable.ext.errMode = 'none';
        $('#eo_client_tbl').on('error.dt', function(e, settings, techNote, message) {
            console.log('DataTables error: ', message);
        });
        table.on('draw.dt', function() {
            var info = table.page.info();
            table.column(0, {
                search: 'applied',
                order: 'applied',
                page: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });

        //     ajaxRequest("GET", "/api/file_progress", data, function(resp) {
        //         if (resp.length == 0) {
        //             tbl = "<td class='text-center'><span>No Data Found</span></td>";
        //         } else {
        //             $.each(resp, function(index, row) {
        //                 tbl += "<tr>";
        //                 tbl += "<td>" + ++index + "</td>";
        //                 tbl += "<td><a href='/industry_profile/id/" + row.id + "'  target=\"_blank\">" + row
        //                     .file_no + "</a></td>";
        //                 tbl += "<td>" + file_type_status[row.cer_type_status] + "</td>";
        //                 tbl += "<td>" + row.first_name + ' ' + row.last_name + "</td>";
        //                 tbl += "<td>" + row.industry_category.name + "</td>";
        //                 tbl += "<td>" + row.updated_at + "</td>";
        //                 tbl += "<td>" + formatDate(row.created_at) + "</td>";
        //                 if (isNaN(parseInt(row.environment_officer_id))) {
        //                     tbl += "<td style='color:red;'>Not Assigned</td>";
        //                 } else {
        //                     tbl += "<td>" + file_status[row.file_status] + "</td>";
        //                 }
        //                 tbl += "</tr>";
        //             });
        //         }
        //         $('#eo_client_tbl tbody').html(tbl);
        //         //            $("#eo_client_tbl").DataTable();
        //         $(function() {
        //             var t = $("#eo_client_tbl").DataTable();
        //             t.on('order.dt search.dt', function() {
        //                 t.column(0, {
        //                     search: 'applied',
        //                     order: 'applied'
        //                 }).nodes().each(function(cell, i) {
        //                     cell.innerHTML = i + 1;
        //                 });
        //             }).draw();

        //         });

        //         //data table error handling
        //         $.fn.dataTable.ext.errMode = 'none';
        //         $('#eo_client_tbl').on('error.dt', function(e, settings, techNote, message) {
        //             console.log('DataTables error: ', message);
        //         });
        //         if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        //             callBack();
        //         }
        //     });
    }

    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear(),
            hours = d.getHours(),
            minutes = d.getMinutes(),
            seconds = d.getSeconds();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        if (hours.length < 2) hours = '0' + hours;
        if (minutes.length < 2) minutes = '0' + minutes;
        if (seconds.length < 2) seconds = '0' + seconds;

        return [year, month, day].join('/') + ' ' + hours + ':' + minutes + ':' + seconds;
    }
</script>
@endsection