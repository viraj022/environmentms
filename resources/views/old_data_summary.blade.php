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
@if($pageAuth['is_read']==1 || false)
<section class="content-header">
    <div class="container-fluid">
    </div>
</section>
<div class="card card-primary card-outline card-tabs">
    <div class="card-header p-0 pt-1 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="false">Chart</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Summary</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-three-tabContent">
            <div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                <div class="col-md-12">
                    <!-- solid sales graph -->
                    <div class="card bg-gradient-info">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                Old Files
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
                            <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <div class="overlay dark">
                            <i class="fas fa-2x fa-sync-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Old Data Summary</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="card-body table-responsive" style="height: 450px;">
                                <table class="table table-condensed" id="tblloadOldDataSummer">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Date</th>
                                            <th>Count</th>
                                            <!--<th style="width: 140px">Action</th>-->
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
    <!-- /.card -->
</div>

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
<!-- jQuery Knob Chart -->
<script src="../../plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- ChartJS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../js/ReportsJS/report_data_summary.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    $(function () {

        /* jQueryKnob */
//        $('.knob').knob();

        oldfileCoundByDate(function (p) {
            getOldDataSummerApi(p);
            renderChart(p, function () {
                $('.overlay').remove();
            });
        });
        function renderChart(data, callBack) {
            let dates = [];
            let files = [];
            $.each(data, function (i, row) {
                dates.push(row.date);
                files.push(row.count);
            });
            var salesGraphChartData = {
//                labels: ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'],
                labels: dates,
                datasets: [
                    {
                        label: 'Digital Goods',
                        fill: false,
                        borderWidth: 2,
                        lineTension: 0,
                        spanGaps: true,
                        borderColor: '#efefef',
                        pointRadius: 3,
                        pointHoverRadius: 7,
                        pointColor: '#efefef',
                        pointBackgroundColor: '#efefef',
                        data: files
//                        data: [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432]
                    }
                ]
            }
            var salesGraphChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false,
                },
                scales: {
                    xAxes: [{
                            ticks: {
                                fontColor: '#efefef',
                            },
                            gridLines: {
                                display: false,
                                color: '#efefef',
                                drawBorder: false,
                            }
                        }],
                    yAxes: [{
                            ticks: {
                                stepSize: 5000,
                                fontColor: '#efefef',
                            },
                            gridLines: {
                                display: true,
                                color: '#efefef',
                                drawBorder: false,
                            }
                        }]
                }
            }

            // This will get the first returned node in the jQuery collection.
            new Chart(salesGraphChartCanvas, {
                type: 'line',
                data: salesGraphChartData,
                options: salesGraphChartOptions
            });
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
//OPEN---
        // Sales graph chart
        var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d');




//END---

    });

</script>
@endsection
