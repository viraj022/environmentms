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
                <h1>EO Locations</h1>
            </div>
        </div>
    </div>
</section>
<!--//Tab Section START//-->
<section class="content-header">
    <div class="col-md-12">
        <div class="card card-gray">
            <div class="card-body">
                <div class="form-group">
                    <label>Environment Officer</label>
                    <select class="form-control combo_envOfficer" id="env_officer_combo">
                        <option>...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Industry Category</label>
                    <select class="form-control combo_catIndus" id="indust_cat">
                        <option>...</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                @if($pageAuth['is_create']==1 || false)
                <button id="btnLoad" class="btn btn-success">Load</button>
                @endif
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
<script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyaUNtnrMrJwLqWQmHoUbeHaLk6q4msXE&callback=location_array"></script>
<script>
    var HT = 'https://gist.githubusercontent.com/mariosmello/d6cce41514d6fa2e8ef6/raw/c6eecd00ed62302ebda36d488334f3ee265b291c/beaches-google.json';
    loadEnvOfficers_combo();
    catIndustry();
    location_array(HT);

    $('#btnLoad').click(function () {
        loadLocation($('#indust_cat').val(), $('#env_officer_combo').val(), function (result) {
            location_array(result);
        });
    });

    function location_array(htz) {
        $.get(htz, function (data) {
            var bounds = new google.maps.LatLngBounds();
            var mapOptions = {
                zoom: 15,
                zoomControl: true,
                scrollwheel: false
            };

            var map = new google.maps.Map(document.getElementById('map'), mapOptions);
            var infowindow = new google.maps.InfoWindow();
            var marker;

            $(data.points).each(function (i, o) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(o[1], o[2]),
                    map: map
                });

                bounds.extend(marker.position);
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent(o[0]);
                        infowindow.open(map, marker);
                    }
                })(marker, i));

            });

            map.fitBounds(bounds);
            var listener = google.maps.event.addListener(window, 'load', function () {
                map.setZoom(3);
                google.maps.event.removeListener(listener);
            });

        }, 'json');
    }

// Initialize and add the map
//    $.get('https://gist.githubusercontent.com/mariosmello/d6cce41514d6fa2e8ef6/raw/c6eecd00ed62302ebda36d488334f3ee265b291c/beaches-google.json', function (data) {

</script>
@endsection