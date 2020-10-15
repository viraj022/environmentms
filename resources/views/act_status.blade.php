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
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>AD Status</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="timeline">
                    <div class="time-label">
                        <span class="bg-red">10 Feb. 2021</span>
                    </div>
                    <div>
                        <i class="fas fa-envelope bg-blue"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> 12:05</span>
                            <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                            <div class="timeline-body">
                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                quora plaxo ideeli hulu weebly balihoo...
                            </div>
                            <div class="timeline-footer">
                                <a class="btn btn-primary btn-sm">Read more</a>
                                <a class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-user bg-green"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> 5 mins ago</span>
                            <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-comments bg-yellow"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> 27 mins ago</span>
                            <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                            <div class="timeline-body">
                                Take me to your leader!
                                Switzerland is small and neutral!
                                We are more like Germany, ambitious and misunderstood!
                            </div>
                            <div class="timeline-footer">
                                <a class="btn btn-warning btn-sm">View comment</a>
                            </div>
                        </div>
                    </div>
                    <div class="time-label">
                        <span class="bg-green">3 Jan. 2014</span>
                    </div>
                    <div>
                        <i class="fa fa-camera bg-purple"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> 2 days ago</span>
                            <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                            <div class="timeline-body">
                                <img src="http://placehold.it/150x100" alt="...">
                                <img src="http://placehold.it/150x100" alt="...">
                                <img src="http://placehold.it/150x100" alt="...">
                                <img src="http://placehold.it/150x100" alt="...">
                                <img src="http://placehold.it/150x100" alt="...">
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-clock bg-gray"></i>
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
<script src="../../js/AdPendingJS/ad_pending_list.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    function minute() {
        var data = {
            minutes: $('#getMinutes').val()
        };
        return data;
    }
    $(function () {
//Load table
        $('#getAssistantDirector').change(function () {
            loadAdPendingListTable($('#getAssistantDirector').val());
        });
//select button action 
        $(document).on('click', '.btnAction', function () {
        });


        $(document).on('click', '.actionDetails', function () {

        });

    });

</script>
@endsection
