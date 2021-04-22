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
<style>
    div#map {
        height: 100%;
    }

    div#map {
        border: 0;
        width: 100%;
    }
</style>
<!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
@if($pageAuth['is_read']==1 || false)
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>File Locations</h1>
            </div>
        </div>
    </div>
</section>
<!--//Tab Section START//-->
<section class="content-header">
    <div class="col-md-12">
        <div class="card card-gray">
            <div class="card-body">
                <div class="row form-inline">
                    <div class="col-5">
                        <div class="form-group">
                            <label>Environment Officer: </label>
                            <select class="form-control combo_envOfficer" id="env_officer_combo">
                                <option>...</option>
                            </select>
                        </div>  
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label>Industry Category: </label>
                            <select class="form-control select2 select2-purple combo_catIndus" data-dropdown-css-class="select2-purple" style="width: 100%;" id="indust_cat">
                                <option>...</option>
                            </select>
                        </div>   
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button id="btnLoad" class="btn btn-success">Load</button>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="map" style="width: 100%; height: 590px;"></div>
    </div>
</section>
<!--//Tab Section END//-->
<section>
    <div class="viewClientData d-none">
        <p>Here Is Our Client Data!</p>
    </div>
</section>

@endif
@endsection



@section('pageScripts')
<!-- Page script -->
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox 
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>-->
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../js/EO_LocationJS/eo_location_source.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyaUNtnrMrJwLqWQmHoUbeHaLk6q4msXE&callback=initMap"></script>
<script>
    loadEnvOfficers_combo(function () {
        catIndustry(function () {
            loadLocation($('#indust_cat').val(), $('#env_officer_combo').val(), function (result) {
                initMap(result);
            });
        });
    });
</script>
<script type="text/javascript">
    $('#btnLoad').click(function () {
        loadLocation($('#indust_cat').val(), $('#env_officer_combo').val(), function (result) {
            initMap(result);
        });
    });
    $('.select2').select2();
    function initMap(locations) {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 12,
            center: new google.maps.LatLng(7.500206389772781, 80.30374068438205),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow;

        var marker, i;
        if (locations != 'undefined' || locations.length > 0) {
            console.log(locations);
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            }
        }
//        window.onload = function () {
//            initMap();
//        };
    }

</script>
@endsection