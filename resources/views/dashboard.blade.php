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

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <hr>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">New Files</span>
                        <span class="info-box-number">
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
                        <span class="info-box-text">Old Files</span>
                        <span class="info-box-number">41,410</span>
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
                        <span class="info-box-text">Total Inspections</span>
                        <span class="info-box-number">760</span>
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
                        <span class="info-box-text">Total Files</span>
                        <span class="info-box-number">2,000</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
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
                <div class="card bg-gradient-info">
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

            <div class="row">
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
            </div>
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
                    <div class="card-body p-0">
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
                        <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
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
                    <div class="card-body p-0">
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
                        <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
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
            <div class="col-md-8">

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
                            <div class="card-body p-0">
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
                                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
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
            <!-- /.col -->

            <div class="col-md-4">
                <!-- Info Boxes Style 2 -->
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Inspection Pending Count</span>
                        <span class="info-box-number">760</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-comment"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">File Processing Count</span>
                        <span class="info-box-number">760</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 d-none">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">tertetetetet</span>
                        <span class="info-box-number">760</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 d-none">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Inspections</span>
                        <span class="info-box-number">760</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('pageScripts')
<!-- ChartJS -->
<!--<script src="/plugins/chart.js/Chart.min.js"></script>-->
<!-- Sparkline -->
<!--<script src="/plugins/sparklines/sparkline.js"></script>
 JQVMap 
<script src="/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
 jQuery Knob Chart 
<script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
 daterangepicker 
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
 Tempusdominus Bootstrap 4 
<script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
 Summernote 
<script src="/plugins/summernote/summernote-bs4.min.js"></script>
 overlayScrollbars 
<script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
 AdminLTE App 
<script src="/dist/js/adminlte.js"></script>
 AdminLTE dashboard demo (This is only for demo purposes) 
<script src="dist/js/pages/dashboard2.js"></script>-->


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


<script>

    //--EPL Renewal Chart Open--//
    var lable = ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'];
    var line1 = [100, 120, 170, 167, 180, 177, 160];
    var line2 = [60, 80, 70, 67, 80, 77, 100];
    eplRenewalChart(lable, line1, line2);
    //--EPL Renewal Chart END--//

//--NEW FILES Chart Open--//
    var newfile_lable = ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'];
    var newfile_data = [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432];
    newFilesChart(newfile_lable, newfile_data);
    //--NEW FILES Chart END--//

//--File Category Chart Open--//
    var fileCat_lable = [
        'Chrome',
        'IE',
        'FireFox',
        'Safari',
        'Opera',
        'Navigator',
    ];
    var fileCat_data = [700, 500, 400, 600, 300, 100];
    fileCategoryChart(fileCat_lable, fileCat_data);
    //--File Category Chart END--//

//--New Jobs Chart Open--//
    var newJobs_lable = [
        'Chrome',
        'IE',
        'FireFox',
        'Safari',
        'Opera',
        'Navigator',
    ];
    var newJobs_data = [700, 500, 400, 600, 300, 100];
    newJobsChart(newJobs_lable, newJobs_data);
//--New Jobs Chart END--//




</script>


@endsection
