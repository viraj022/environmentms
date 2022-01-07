@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')

@section('content')

<link href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
<!-- Main content -->

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary m-5 col-6">
            <div class="card-header">Reset Settings</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12"><h5><label>EPL Count:</label><b>  <span id="epl_count"></span></b></h5></div>
                    <div class="col-md-12"><h5><label>Site Count: </label><b>  <span id="site_count"></span></b></h5></div>
                </div>
                <div class="row mt-5">
                    <div class="form-group col-12">
                        <button type="button" class="btn btn-lg btn-success" id="btn_reset">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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

<!-- Page script -->
<script>

    $(document).ready(function () {
        load_epl_site_counts();
    });

    $('#btn_reset').click(function () {
        reset_count();
    });

    function load_epl_site_counts() {
        let url = '/api/epl_site_count';
        ajaxRequest('GET', url, null, function (resp) {
            $('#epl_count').html(resp.epl_count);
            $('#site_count').html(resp.site_count);
        });
    }

    function reset_count() {
        let url = '/api/reset_counts';
        ajaxRequest('PUT', url, null, function (resp) {
            if (resp.status == 1) {
                swal.fire('success', 'Successfully Reset the counts', 'success');
                location.reload();
            } else {
                swal.fire('failed', 'Resetting is unsuccessful', 'warning');
            }
        });
    }
</script>

@endsection
