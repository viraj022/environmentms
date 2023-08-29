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
        #map {
            height: 400px;
            /* The height is 400 pixels */
            width: 100%;
            /* The width is the width of the web page */
        }
    </style>
    <!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
    @if ($pageAuth['is_read'] == 1 || false)
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h1>File No: (<a href="/industry_profile/id/{{ $client }}"
                                class="setFileNoTitile">Loading..</a>) - EPL Number: <span
                                class="right badge eplCodeAfileNo badge-primary">Loading..</span></h1>
                        <input type="text" id="epl_hid" value="" class="d-none">
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <div class="container-fluid view-Profile">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-gray">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user"></i> Client Details

                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <dt class="">Name : <a id="client_name"></a></dt> <br>
                                <div class="">
                                    <a href="#" class="btn btn-primary viewCert d-none" target="_blank">View
                                        Certificate</a>
                                    <input type="hidden" id='cert_path' value="">
                                    <span id="no_certificate_span" class="text-danger"> No Certificate Uploaded</span>

                                    {{-- draft certificate --}}
                                    @if (!empty($certificate) && !empty($certificate->certificate_path))
                                        <a data-toggle="tooltip" data-placement="top" title="Click to get draft certificate"
                                            id="" href="{{ env('DO_URL').'/'.$certificate->certificate_path }}"
                                            target="_blank" class="btn btn-primary" style="float: right;"> Draft Certificate
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user"></i> Links
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                            class="fas fa-remove"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="height: 350px; overflow-y: scroll;">
                                <div class="callout callout-danger">
                                    <h6><a id="disPaylink" href="/epl_payments/id/{{ $profile }}/type/epl"
                                            class="text-success isOld2">Payments</a></h6>
                                    <p>All Payment (EPL, Fine,Inspection Fee, Certificate)</p>
                                </div>
                                <div class="callout callout-danger">
                                    <h6><a href="/epl_profile/atachments/{{ $profile }}"
                                            class="text-success isOld2">Attachments</a></h6>
                                    <p>Upload EPL Attachments</p>
                                </div>
                                <div class="callout callout-danger">
                                    <h6><a href="/remarks/epl/{{ $profile }}" class="text-success isOld2">Remarks</a>
                                    </h6>
                                    <p>Add Comments</p>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="linkSectionCnf overlay dark">
                                <a class="text-white">File Not Confirmed!</a>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-address-card"></i> Industry Data
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <dl class="row ">
                                    <div class="col-md-8">
                                        <dt>Name : <a id="obj_name"></a></dt>
                                        <dt>Remark : <a id="obj_remark"></a></dt>
                                        <dt>Location :---</dt>
                                    </div>
                                    <div id="map" style="width: 100%; height: 400px;"></div>
                                </dl>
                                <div class="row">
                                    <div class="col-md-6">
                                        <dt>Download Application :</dt>
                                        <a href="" class="btn btn-dark navTodownload" target="_blank">View
                                            Application</a>
                                        <button id="delete_application" class="btn btn-danger d-none" data-file="">Delete
                                            Application</button>
                                        <div class="row mt-3">
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input id="change_file_input" type="file" class="form-control"
                                                        accept="image/*, .pdf">
                                                </div>
                                                <div class="input-group-append">
                                                    <button type="button" id="change_file_btn"
                                                        class="btn btn-success">Change
                                                        File</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 cerInfoBtn d-none">
                                        <dt>Certificate Information :</dt>
                                        <a href="/issue_certificate/id/{{ $profile }}" class="btn btn-primary"
                                            target="_blank">EPL Renewal</a>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success d-none" data-upload_file="EPL"
                                    id="upld_application">Upload Application</button>
                                <div class="form-group d-none" id="fileUpDiv">
                                    <hr>
                                    <label id="uploadLabel">File Upload </label>
                                    <input id="fileUploadInput" type="file" class="" accept="image/*, .pdf">
                                    <div class="progress d-none">
                                        <div class="progress-bar bg-primary progress-bar-striped Uploadprogress"
                                            id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 0%">
                                            <!--<span class="sr-only">40% Complete (success)</span>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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
    <script src="/../../plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="/../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="/../../plugins/moment/moment.min.js"></script>
    <script src="/../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
    <!-- date-range-picker -->
    <script src="/../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="/../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="/../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="/../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/../../dist/js/demo.js"></script>
    <script src="/../../js/commonFunctions/file_upload.js" type="text/javascript"></script>
    <script src="/../../js/EPLProfileJS/submit.js"></script>
    <script src="/../../js/EPLProfileJS/get.js"></script>
    <script src="/../../js/EPLProfileJS/client_space.js"></script>
    <script src="/../../js/EPLProfileJS/update.js"></script>
    <script src="/../../js/EPLProfileJS/delete.js"></script>

    <!-- AdminLTE App -->
    <script async="" defer=""
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDyaUNtnrMrJwLqWQmHoUbeHaLk6q4msXE&callback=initMap"></script>
    <script>
        const FILE_URL="{{ env('DO_URL') }}";
        //Map Start
        // Initialize and add the map
        function initMap(_Latitude, _Longitude) {
            // The location of CeyTech
            var defaultLocation = {
                lat: _Latitude,
                lng: _Longitude
            }; //default Location for load map

            // The map, centered at Uluru
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: defaultLocation
            });
            // The marker, positioned at Uluru
            var marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: false,
                title: "Drag me!"
            });
        }
        //Map END
        $(function() {
            var CLIENT = '{{ $client }}';
            var PROFILE = '{{ $profile }}';
            //    console.log('cli: ' + CLIENT + ', prof: ' + PROFILE);
            getDetailsbyId(PROFILE, function(result) {
                if (result.length == 0 || result == undefined) {
                    if (confirm("Client Not Found! Try Again!")) {}
                } else {
                    setClientDetails(result.client);
                    disableLinkSection(result.client.is_old);
                    checkIsOldTwo(result.client.is_old);
                    $('.setFileNoTitile').html(result.client.file_no);
                    $(".setFileNoTitile").attr("href", "/industry_profile/id/" + CLIENT);
                }
                initMap(parseFloat(result.client.industry_coordinate_x), parseFloat(result.client
                    .industry_coordinate_y));
                $('.cerInfoBtn').addClass('d-none');
                if (result.length == 0 || result == undefined) {
                    if (confirm("Details Not Found! Try Again!")) {}
                } else {
                    if (result.client.file_status == 5) {
                        $('.cerInfoBtn').removeClass('d-none');
                    }
                    setClearanceData(result);
                    $('#obj_remark').text(result.remark);
                    $('.eplCodeAfileNo').html(result.epl_instantNumber);
                    $('#epl_hid').val(PROFILE);

                    if (result.path == null) {
                        $(".navTodownload").attr("href", FILE_URL+'/' + result.application_path);
                    } else {
                        $(".navTodownload").attr("href", FILE_URL+'/' + result.path);
                    }
                    if (result.path != '') {
                        $('#delete_application').removeClass('d-none');
                        $('#delete_application').attr('data-file', FILE_URL+'/' + result.path);
                    }

                }

                if (result.certificate_no != null) {
                    $('.viewCert').removeClass('d-none');
                    $('#no_certificate_span').addClass('d-none');
                    var cert_num = {
                        cert_no: result.certificate_no
                    };
                    getCertificatebyId(cert_num, function(set) { // get certificate by cert number
                        $('.viewCert').attr('href', FILE_URL+"/" + set[0].signed_certificate_path);
                    });
                }
            });
        });

        $('#change_file_btn').click(function() {
            change_file();
        });

        $('#delete_application').click(function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    delete_application();
                }
            });

        });

        function delete_application() {
            let data = {
                "epl_id": $('#epl_hid').val(),
                "file_path": $('#delete_application').attr('data-file')
            };
            ajaxRequest('DELETE', "/api/remove_epl_application", data, function(dataSet) {
                if (dataSet.status == 1) {
                    swal.fire('Success', 'File Deleted Successfully!', 'success');
                    window.location.reload();
                } else {
                    swal.fire('Error', 'File Not Deleted!', 'error');
                }
            });
        }

        function change_file() {
            let file = $('#change_file_input').get(0).files[0];
            if (file != undefined) {
                const data = {
                    type: 'epl',
                    epl_id: $('#epl_hid').val()
                };
                ulploadFileWithData("/api/change_file", data, function(resp) {

                    if (resp.status == 1) {
                        Swal.fire({
                            type: 'success',
                            title: 'File has changed successfully!',
                        });
                    } else {
                        Swal.fire({
                            type: 'error',
                            title: 'File changing was not successful!',
                        });
                    }
                    location.reload();
                }, metod = 'POST', file_list = [file]);
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Please select a file!',
                });
            }

        }
    </script>
@endsection
