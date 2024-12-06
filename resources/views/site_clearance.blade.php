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
                                class="setFileNoTitile">Loading..</a>) - Site Clearance Number: <span
                                class="right badge badge-primary">{{ $code }}</span></h1>
                        <input type="hidden" id="site_clear_sess_id" value="">
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid view-Profile">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-user"></i> Client Details

                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <h4 class="siteClearType text-success"></h4>
                                <h5 class="processingMethod text-success"></h5>
                                <dl class="row">
                                    <dt class="col-sm-4">Name : </dt>
                                    <dd class="col-sm-6" id="client_name"></dd>
                                    <dt class="col-sm-4">Address:</dt>
                                    <dd class="col-sm-6" id="client_address"></dd>
                                    <dt class="col-sm-4">Contact Number:</dt>
                                    <dd class="col-sm-6" id="client_cont"></dd>
                                    <dt class="col-sm-4">Contact Email:</dt>
                                    <dd class="col-sm-6" id="client_amil"></dd>
                                    <dt class="col-sm-4">NIC:</dt>
                                    <dd class="col-sm-6" id="client_nic"></dd>
                                </dl>
                                <hr>
                                <dl class="row">
                                    <dt class="col-sm-4">Industry Name : </dt>
                                    <dd class="col-sm-6" id="obj_name"></dd>
                                    <dt class="col-sm-4">Industry Registration No:</dt>
                                    <dd class="col-sm-6" id="obj_regno"></dd>
                                    <dt class="col-sm-4">Industry Code:</dt>
                                    <dd class="col-sm-6" id="obj_code"></dd>
                                    <dt class="col-sm-4">Industry Investment:</dt>
                                    <dd class="col-sm-6" id="obj_invest"></dd>
                                    <dt class="col-sm-4">Industry Remark:</dt>
                                    <dd class="col-sm-6" id="obj_remark"></dd>
                                </dl>
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
                                    <h6><a id="disPaylink" href="/epl_payments/id/{{ $profile }}/type/site_clearance"
                                            class="text-success isOld2">Payments</a></h6>
                                    <p>All Payment (Site Clearance, Fine,Inspection Fee, Certificate)</p>
                                </div>
                                <div class="callout callout-danger">
                                    <h6><a href="/epl_profile/atachments/{{ $profile }}"
                                            class="text-success isOld2">Attachments</a></h6>
                                    <p>Upload Site Clearance Attachments</p>
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
                                    <i class="fas fa-address-card"></i> Site Clearance Data
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group disType">
                                    <input id="currentProStatus" type="text" class="d-none">
                                    <label>Processing Type*</label>
                                    <select id="setSiteType" class="form-control form-control-sm cutenzReq"
                                        style="width: 100%;">
                                        <option value="0">Pending</option>
                                        <option value="1">Site Clearance</option>
                                        <option value="2">EIA</option>
                                        <option value="3">IEE</option>
                                    </select>
                                </div>
                                <button id="changeProcessingBtn" class="btn btn-dark">Change</button>
                                <hr>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <a href="" class="btn btn-dark navTodownload" target="_blank">View
                                            Application</a>
                                        <button id="delete_application" class="btn btn-danger d-none"
                                            data-file="">Delete Application</button>
                                        @if (!empty($certificate) && !empty($certificate->certificate_path))
                                            <a href="{{ env('DO_URL').'/'.$certificate->certificate_path }}" target="_blank"
                                                class="btn btn-primary mt-2" data-toggle="tooltip" data-placement="top"
                                                title="Click to get draft certificate" id="">
                                                Draft Certificate </a>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
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
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-success d-none sectionUploadTor collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Upload TOR</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: none;">
                                <div class="form-group">
                                    <label>Expire Date*</label>
                                    <input id="expireDateTor" type="date" max="2999-12-31"
                                        class="form-control form-control-sm" placeholder="Enter Date..." value="">
                                </div>
                                <div class="form-group">
                                    <label>Valid Date*</label>
                                    <input id="validDateTor" type="date" max="2999-12-31"
                                        class="form-control form-control-sm" placeholder="Enter Date..." value="">
                                </div>
                                <div class="form-group sectionActiveTor d-none">
                                    <a id="viewActiveTor" href="#" target="_blank" class="btn btn-dark"><i
                                            class="fas fa-search"></i> View Current File</a>
                                </div>
                                <div class="form-group" id="fileUpDiv">
                                    <hr>
                                    <label id="uploadLabel">File Upload :</label>
                                    <input id="fileUploadTor" type="file" class="" accept="image/*, .pdf">
                                    <div class="progress d-none">
                                        <div class="progress-bar bg-primary progress-bar-striped Uploadprogress"
                                            id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 0%">
                                            <!--<span class="sr-only">40% Complete (success)</span>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button id="uploadTOR" type="submit" class="btn btn-success"><i
                                            class="fas fa-check"></i> Upload TOR</button>
                                </div>
                            </div>
                        </div>

                        <div class="card card-success d-none sectionUploadClReport collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Upload Client Report</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: none;">
                                <div class="form-group">
                                    <label>Expire Date*</label>
                                    <input id="expireClientReport" type="date" max="2999-12-31"
                                        class="form-control form-control-sm" placeholder="Enter Date..." value="">
                                </div>
                                <div class="form-group sectionActiveClientRep d-none">
                                    <a id="viewActiveClientRep" target="_blank" href="#" class="btn btn-dark"><i
                                            class="fas fa-search"></i> View Current File</a>
                                </div>
                                <div class="form-group" id="fileUpDiv">
                                    <hr>
                                    <input id="fileUploadClient" type="file" class="" accept="image/*, .pdf">
                                    <div class="progress d-none">
                                        <div class="progress-bar bg-primary progress-bar-striped Uploadprogress"
                                            id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 0%">
                                            <!--<span class="sr-only">40% Complete (success)</span>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button id="uploadClReport" type="submit" class="btn btn-success"><i
                                            class="fas fa-check"></i> Upload Report</button>
                                </div>
                            </div>
                        </div>

                        <div class="card card-success d-none sectionArrangeCommittee collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Arange Committee</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: none;">
                                <a href="/committee/id/{{ $profile }}" class="btn btn-success navToCommittee"
                                    target="_blank">Add Committee</a>
                            </div>
                        </div>
                        <!--Site Clearance Extention-->
                        <div class="card card-info  collapsed-card siteClearExtend d-none">
                            <div class="card-header">
                                <h3 class="card-title">Site Clearance Extension</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="display: none;">
                                <div class="form-group">
                                    <label>Submit Date*</label>
                                    <input id="submitDateExten" type="date" max="2999-12-31"
                                        class="form-control form-control-sm" placeholder="Enter Date..." value="">
                                </div>
                                <div class="form-group">
                                    <label>Remark</label>
                                    <input id="extendRemark" type="text" class="form-control form-control-sm"
                                        value="">
                                </div>
                                <div class="form-group sectionExtenFile d-none">
                                    <a id="viewApplicationExten" target="_blank" href="#" class="btn btn-dark"><i
                                            class="fas fa-search"></i> View Current File</a>
                                </div>
                                <div class="form-group" id="fileUpDiv">
                                    <hr>
                                    <input id="fileUploadExten" type="file" class="" accept="image/*, .pdf">
                                    <div class="progress d-none">
                                        <div class="progress-bar bg-primary progress-bar-striped Uploadprogress"
                                            id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 0%">
                                            <!--<span class="sr-only">40% Complete (success)</span>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button id="uploadExten" type="submit" class="btn btn-success"><i
                                            class="fas fa-check"></i> Upload Application</button>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-address-card"></i> Issued Data
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>No</th>
                                            <th>Certificate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($certificates as $cert)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>Expire: {{ $cert->expire_date }}, Issued:
                                                    {{ $cert->issue_date }}</td>
                                                <td>{{ $cert->cetificate_number }}</td>
                                                <td>
                                                    @if (!empty($cert->certificate_path))
                                                        <a href="{{ env('DO_URL').'/'.$cert->certificate_path }}"
                                                            class="btn btn-sm btn-success">Draft</a>
                                                    @endif
                                                    @if (!empty($cert->signed_certificate_path))
                                                        <a href="{{ env('DO_URL').'/'.$cert->signed_certificate_path }}"
                                                            class="btn btn-sm btn-info">Origial</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">No Data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
    <script src="/../../js/SiteClearanceJS/site_clearance_scr.js" type="text/javascript"></script>

    <!-- AdminLTE App -->
    <script>
        ////Map Start
        //// Initialize and add the map
        //function initMap(_Latitude, _Longitude) {
        //    // The location of CeyTech
        //    var defaultLocation = {lat: _Latitude, lng: _Longitude}; //default Location for load map
        //
        //    // The map, centered at Uluru
        //    var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: defaultLocation});
        //    // The marker, positioned at Uluru
        //    var marker = new google.maps.Marker({position: defaultLocation, map: map, draggable: false, title: "Drag me!"});
        //}
        ////Map END
        $(function() {
            var CLIENT = '{{ $client }}';
            var PROFILE = '{{ $profile }}';
            const FILE_URL="{{ env('DO_URL') }}";
            //    var PATH_CONTENT = [];
            $('#currentProStatus').val(PROFILE);
            //    console.log('cli: ' + CLIENT + ', prof: ' + PROFILE);
            getaClientbyId(CLIENT, function(result) {
                if (result.length == 0 || result == undefined) {
                    if (confirm("Client Not Found! Try Again!")) {

                    }
                } else {
                    setClientDetails(result);
                    disableLinkSection(result.is_old);
                    checkIsOldTwo(result.is_old);
                    $('.setFileNoTitile').html(result.file_no);
                    $(".setFileNoTitile").attr("href", "/industry_profile/id/" + CLIENT);
                }
            });

            var SITE_CLEARANCE_STATUS = {
                0: 'pending',
                1: 'site clearance',
                2: 'EIA',
                3: 'IEA'
            };
            getSiteClearanceAPI(PROFILE, function(resp) {
                if (resp.content_paths != null) {
                    //            PATH_CONTENT = [resp.content_paths];
                    viewUploadContentData(resp.content_paths);
                }
                if (resp.site_clearances.length != 0) {
                    let cleareance = resp.site_clearances[(resp.site_clearances.length) - 1];
                    $('.processingMethod').html('Processing Method:' + SITE_CLEARANCE_STATUS[resp
                        .processing_status]);
                    if (resp.processing_status == 2 || resp.processing_status == 3) {
                        $('.sectionUploadClReport').removeClass('d-none');
                        $('.sectionUploadTor').removeClass('d-none');
                        $('.sectionArrangeCommittee').removeClass('d-none');

                    } else {
                        $('.sectionUploadClReport').addClass('d-none');
                        $('.sectionUploadTor').addClass('d-none');
                        $('.sectionArrangeCommittee').addClass('d-none');
                    }
                    $('.navTodownload').attr('href', FILE_URL+'/' + cleareance.application_path);
                    $('.siteClearType').html(resp.site_clearance_type);

                    $('#delete_application').attr('data-file', FILE_URL+'/' + cleareance.application_path);
                    $('#delete_application').removeClass('d-none');
                } else {}
                if (resp.client.file_status == 5) {
                    $('.siteClearExtend').removeClass('d-none');
                }
                $('#site_clear_sess_id').val(PROFILE);
            });

            $("#changeProcessingBtn").click(function() {
                var data = {
                    status: $('#setSiteType').val()
                };
                if (confirm('Are you sure you want to change?')) {
                    setProcessingTypeAPI($('#currentProStatus').val(), data, function(respo) {
                        show_mesege(respo);
                        getSiteClearanceAPI(PROFILE, function(resp) {
                            if (resp.site_clearances.length != 0) {
                                let cleareance = resp.site_clearances[(resp.site_clearances
                                    .length) - 1];
                                $('.processingMethod').html('Processing Method:' +
                                    SITE_CLEARANCE_STATUS[resp.processing_status]);
                                if (resp.processing_status == 2 || resp.processing_status ==
                                    3) {
                                    $('.sectionUploadClReport').removeClass('d-none');
                                    $('.sectionUploadTor').removeClass('d-none');
                                    $('.sectionArrangeCommittee').removeClass('d-none');
                                } else {
                                    $('.sectionUploadClReport').addClass('d-none');
                                    $('.sectionUploadTor').addClass('d-none');
                                    $('.sectionArrangeCommittee').addClass('d-none');
                                }
                                $('.navTodownload').attr('href', FILE_URL+'/' + cleareance
                                    .application_path);
                                $('.siteClearType').html(resp.site_clearance_type);
                            } else {}
                        });
                    });
                }
            });
            //Tor Upload Event
            $("#uploadTOR").click(function() {
                let data = {
                    expire_date: $('#expireDateTor').val(),
                    valid_date: $('#validDateTor').val(),
                    file: $('#fileUploadTor')[0].files[0]
                };
                setUploadTorAPI(PROFILE, data, function(rest) {
                    show_mesege(rest);
                    if (rest.id == 1) {
                        getSiteClearanceAPI(PROFILE, function(resp) {
                            if (resp.content_paths != null) {
                                viewUploadContentData(resp.content_paths);
                            }
                        });
                    }
                });
            });
            //Client Report Upload Event
            $("#uploadClReport").click(function() {
                let data = {
                    expire_date: $('#expireClientReport').val(),
                    file: $('#fileUploadClient')[0].files[0]
                };
                setUploadClientAPI(PROFILE, data, function(rest) {
                    show_mesege(rest);
                    if (rest.id == 1) {
                        getSiteClearanceAPI(PROFILE, function(resp) {
                            if (resp.content_paths != null) {
                                viewUploadContentData(resp.content_paths);
                            }
                        });
                    }
                });
            });
            //Site Clearance Extention
            $("#uploadExten").click(function() {
                let data = {
                    submit_date: $('#submitDateExten').val(),
                    file: $('#fileUploadExten')[0].files[0],
                    client_id: CLIENT
                };
                setSiteClearanceExtenAPI(PROFILE, data, function(rest) {
                    show_mesege(rest);
                    if (rest.id == 1) {
                        location.reload();
                        //                getSiteClearanceAPI(PROFILE, function (resp) {
                        //                    if (resp.content_paths != null) {
                        //                        viewUploadContentData(resp.content_paths);
                        //                    }
                        //                });
                    } else {
                        //                alert(rest.message);
                    }
                });
            });

        });

        function disWarnPay() {
            toastr.error('Assign Environment Officer & Try Again!');
        }

        function showNotAvailable() {
            toastr.info('Not Available For Old Files!');
        }


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
                "site_sess_id": $('#site_clear_sess_id').val(),
                "file_path": $('#delete_application').attr('data-file')
            };
            ajaxRequest('DELETE', "/api/remove_site_application", data, function(dataSet) {
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
                    type: 'site_clearance',
                    site_clear_sess_id: $('#site_clear_sess_id').val()
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
