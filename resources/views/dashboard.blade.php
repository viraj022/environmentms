@extends('layouts.dashadmin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('content')
<!-- Content Header (Page header) -->
<!--<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div> /.col 
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v1</li>
                </ol>
            </div> /.col 
        </div> /.row 
    </div> /.container-fluid 
</div>-->
<!-- /.content-header -->
<link href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <hr>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fab fa-whmcs"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text pending">New Files</span>
                        <span class="info-box-number pending_count">
                            22
                            <small></small>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text complete">Old Files</span>
                        <span class="info-box-number complete_count">41,410</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text d_penidng">Total Inspections</span>
                        <span class="info-box-number d_penidng_count">760</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text cer_preparation">Total Files</span>
                        <span class="info-box-number cer_preparation_count">2,000</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-audio-description"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text font-weight-bold ad_approval">Inspection Pending Count</span>
                        <span class="info-box-number ad_approval_count">760</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>   
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fab fa-whmcs"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text font-weight-bold ">Inspection Pending Count</span>
                        <span class="info-box-number ad_approve_count">760</span>
                    </div>
                </div>  
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b>Monthly EPL Renewal Summary</b></h3>
                            <a href="javascript:void(0);">View Report</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg">820</span>
                                <span>Visitors Over Time</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> 12.5%
                                </span>
                                <span class="text-muted">Since last week</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="epl-renewal-chart" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Renewed
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Pending
                            </span>
                        </div>
                    </div>
                </div>

                <!-- solid sales graph -->
                <div class="card bg-gradient-dark">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-th mr-1"></i>
                            New Files
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas class="chart" id="new-files-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>

            <!--<div class="row">-->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b>File Category(Month)</b></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="chart-responsive">
                                        <canvas id="fileCategorypieChart" height="150"></canvas>
                                    </div>
                                    <!-- ./chart-responsive -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <ul class="chart-legend clearfix">
                                        <li><i class="far fa-circle text-danger"></i> EPL</li>
                                        <li><i class="far fa-circle text-success"></i> Site Clearance</li>
                                        <li><i class="far fa-circle text-warning"></i> Telecommunication</li>
                                        <li><i class="far fa-circle text-info"></i> Schedule Waste</li>
                                    </ul>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card --> 
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b>New Jobs(Day)</b></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="chart-responsive">
                                        <canvas id="newJobspieChart" height="150"></canvas>
                                    </div>
                                    <!-- ./chart-responsive -->
                                </div>
                                <!-- /.col -->
                                <div class="col-md-4">
                                    <ul class="chart-legend clearfix">
                                        <li><i class="far fa-circle text-danger"></i> EPL</li>
                                        <li><i class="far fa-circle text-success"></i> Site Clearance</li>
                                        <li><i class="far fa-circle text-warning"></i> Telecommunication</li>
                                        <li><i class="far fa-circle text-info"></i> Schedule Waste</li>
                                    </ul>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->  
                </div>
            <!--</div>-->
            <!-- /.col -->

            <div class="col-md-6">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title"><b>Pradeshiyasaba File Count</b></h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="pradeshiyasabaFileCount_table" class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sample File</td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <!--<a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>-->
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title"><b>Environment Officers File Count</b></h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="envOfficeFileCount_table" class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Call of Duty IV</td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <!--<a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>-->
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card --> 
            </div>


        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-6">

                <!-- /.card -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header border-transparent">
                                <h3 class="card-title"><b>Industry Category Count</b></h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="industryCatCount_table" class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Call of Duty IV</td>
                                                <td>
                                                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <!--<a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>-->
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-6">
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!--                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>File Category</b></h3>
                
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                     /.card-header 
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="chart-responsive">
                                                    <canvas id="pieChart2" height="150"></canvas>
                                                </div>
                                                 ./chart-responsive 
                                            </div>
                                             /.col 
                                            <div class="col-md-4">
                                                <ul class="chart-legend clearfix">
                                                    <li><i class="far fa-circle text-danger"></i> EPL</li>
                                                    <li><i class="far fa-circle text-success"></i> Site Clearance</li>
                                                    <li><i class="far fa-circle text-warning"></i> Telecommunication</li>
                                                    <li><i class="far fa-circle text-info"></i> Schedule Waste</li>
                                                </ul>
                                            </div>
                                             /.col 
                                        </div>
                                         /.row 
                                    </div>
                                     /.card-body 
                                </div>-->
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('pageScripts')


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- PAGE SCRIPTS -->
<script src="dist/js/pages/dashboard3.js"></script>
<script src="../../js/DashboardJS/main_dashboard_script.js" type="text/javascript"></script>
<script src="plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<script>
//Filter Date
    var today = new Date();
    var dd = today.getDate();

    var mm = today.getMonth() + 1;
    var yyyy = today.getFullYear();
    if (dd < 10)
    {
        dd = '0' + dd;
    }
    if (mm < 10)
    {
        mm = '0' + mm;
    }

//    renew_chart, new_file_chart, file_category_chart, new_job_chart, pra_table, env_officer_table, industry_category_table, file_status_lable
    getDashboardData(['renew_chart', 'new_file_chart', 'pra_table', 'industry_category_table', 'env_officer_table', 'file_category_chart'], {from: '2020-01-01', to: '2020-12-31'}, function (p) {
        console.log(p);
        //--EPL Renewal Chart Open--//
        eplRenewalChart(p.renew_chart.months, p.renew_chart.renew, p.renew_chart.expire);
        //--EPL Renewal Chart END--//

//--NEW FILES Chart Open--//
        newFilesChart(p.new_file_chart.months, p.new_file_chart.new, p.new_file_chart.site, p.new_file_chart.epl);
        //--NEW FILES Chart END--//

        /* -- pradeshiya sabha file count--*/
        pradeshiyasabaFileCount(p.pra_table.data);
        /* -- industry category file count--*/
        industryCategoryCount(p.industry_category_table.data);
        /* -- env officer file count--*/
        environmentOfficersFileCount(p.env_officer_table.data);
        /* file categoyr chart monthly*/
        fileCategoryChart(p.file_category_chart);
    });
    today = yyyy+'-'+mm+'-'+dd;
    nextDay = yyyy+'-'+mm+'-'+ dd;
    getDashboardData(['new_job_chart', 'renew_chart'], {from: today, to: nextDay}, function (p) {
        /* new jobs chart*/
        newJobsChart(p.new_job_chart.types, p.new_job_chart.count);
    });

//    getDashboardData(['file_category_chart'], {from: '2020-10-01', to: '2020-10-31'}, function (p) {
//////--File Category Chart Open--//
//        var fileCat_lable = [
//            'Chrome',
//            'IE',
//            'FireFox',
//            'Safari',
//            'Opera',
//            'Navigator',
//        ];
//        var fileCat_data = [700, 500, 400, 600, 300, 100];
//        fileCategoryChart(fileCat_lable, fileCat_data);
////        //--File Category Chart END--//
//    });

    //Add Spesific "File Status" Classes To Any Elements If Your Wants To Show Count And File Status Name// (Example Line 38 & 39)
    var FILE_STATUS = {0: 'In Progress', 1: 'AD File Approval Pending', 2: 'Certificate Preparation', 3: 'AD Pending Approval', 4: 'D Certificate Approval Pending', 5: 'Complete', 6: 'Issued', '-1': 'Rejected', '-2': 'Hold'};
    var FILE_CLASS = {0: 'pending', 1: 'ad_approve', 2: 'cer_preparation', 3: 'ad_approval', 4: 'd_penidng', 5: 'complete', 6: 'issued', '-1': 'rejected', '-2': 'hold'};
    var COUNT_CLASS = {0: 'pending_count', 1: 'ad_approve_count', 2: 'cer_preparation_count', 3: 'ad_approval_count', 4: 'd_penidng_count', 5: 'complete_count', 6: 'issued_count', '-1': 'rejected_count', '-2': 'hold_count'};
    getDashboardData(['file_status_lable'], {from: '2020-10-29', to: '2020-12-31'}, function (e) {
        var lable = '';
        var count = '';
        var clz = '';
        var count_clz = '';
        $.each(e.file_status_lable.data, function (index, row) {
            lable = FILE_STATUS[row.file_status];
            clz = FILE_CLASS[row.file_status];
            count_clz = COUNT_CLASS[row.file_status];
            count = row.total;
            $('.' + clz).html(lable);
            $('.' + count_clz).html(count);
        });
    });



</script>


@endsection
