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
                <h1>Industry Files</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <!--    Register New Client START-->
    <div class="container-fluid reg-newClient">
        <div class="row">
            <div class="col-md-12">
                <form id="eo_report_form">
                    <div class="card card-gray">
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
                        <div class="card">
                            <div class="card-body table-responsive" style="height: 450px;">
                                <table class="table table-condensed" id="eo_client_tbl">
                                    <thead>
                                        <tr class="tblTrsec">
                                            <th>#</th>
                                            <th>Client Name</th>
                                            <th>Client Address</th>
                                            <th>Industry Category</th>
                                            <th>Licence Issue date</th>
                                            <th>Licence exp date</th>
                                            <th>Contact No</th>
                                            <!--<th class="inspectTbl" style="width: 180px">Inspection</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>                                      
        </div>
    </div>
    <!--Register New Client END-->

</section>

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
<!-- AdminLTE App -->
<script>
    IndustryCategoryCombo();
    loadPradeshiyaSabha();

    $('#report_generate').click(function () {
        eo_report_load();
    });

    function loadPradeshiyaSabha(callBack) {
        var cbo = "";
        ajaxRequest('GET', "/api/pradesheeyasabas", null, function (dataSet) {
            if (dataSet) {
                $.each(dataSet, function (index, row) {
                    cbo += '<option data-ps_code="' + row.code + '" value="' + row.id + '">' + row.code + ' - ' + row.name + '</option>';
                });
            } else {
                cbo = "<option value=''>No Data Found</option>";
            }
            $('#pradeshiya_sabha').html(cbo);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        });
    }
    function IndustryCategoryCombo(callBack) {
        var cbo = "";
        ajaxRequest('GET', "/api/industrycategories", null, function (dataSet) {
            if (dataSet) {
                $.each(dataSet, function (index, row) {
                    cbo += '<option data-cat_code="' + row.code + '" value="' + row.id + '">' + row.name + '</option>';
                });
            } else {
                cbo = "<option value=''>No Data Found</option>";
            }
            $('#industry_cat').html(cbo);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        });
    }

    function eo_report_load() {
        tbl = "";
        let data = $("#eo_report_form").serializeArray();
        $('#eo_client_tbl').DataTable().destroy();
                ajaxRequest("post", "/api/eo_client_data", data, function (resp) {
                if (resp.length == 0) {
                    tbl = "<td class='text-center'><span>No Data Found</span></td>";
                } else {
                    $.each(resp, function (index, row) {
                        tbl += "<tr>";
                        tbl += "<td>" + ++index + "</td>";
                        tbl += "<td>" + row.first_name + row.last_name + "</td>";
                        if (row.address == null) {
                            row.address = '---';
                        }
                        tbl += "<td>" + row.address + "</td>";
                        tbl += "<td>" + row.name + "</td>";
                        tbl += "<td>" + row.issue_date + "</td>";
                        tbl += "<td>" + row.expire_date + "</td>";
                        if (row.industry_contact_no == null) {
                            row.industry_contact_no = '---';
                        }
                        tbl += "<td>" + row.industry_contact_no + "</td>";
                        tbl += "</tr>";
                    });
                }
                $('#eo_client_tbl tbody').html(tbl);
//            $("#eo_client_tbl").DataTable();
                $(function () {
                    var t = $("#eo_client_tbl").DataTable();
                    t.on('order.dt search.dt', function () {
                        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                });

                //data table error handling
                $.fn.dataTable.ext.errMode = 'none';
                $('#eo_client_tbl').on('error.dt', function (e, settings, techNote, message) {
                    console.log('DataTables error: ', message);
                });
                if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                    callBack();
                    }
                }
                );
    }
</script>
@endsection
