@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
    <!-- This section didnt work for me -->
    <!-- fullCalendar -->
    <link rel="stylesheet" href="../plugins/fullcalendar/main.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar-daygrid/main.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar-timegrid/main.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar-bootstrap/main.min.css">
    <style>
        /* SHADE DAYS IN THE PAST */
        td.fc-day.fc-past {
            background-color: #EEEEEE;
        }

    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>Letter Writer</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky-top mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Letter Title*</label>
                                    <input type="text" class="form-control">
                                </div>
                                <button class="btn btn-success" id="saveLetter">Save</button>
                                <button class="btn btn-dark" id="printLetter">Print</button>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-gray">
                            <div class="card-header">
                                <h4 class="card-title">Events</h4>
                            </div>
                            <div class="card-body">
                                <!-- the events -->
                                <p class='text-success'>Loading...</p>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-gray">
                        <div class="card-body p-0">
                            <textarea name="editor1"></textarea>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection



@section('pageScripts')
    <!-- Page script -->

    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
    <!-- AdminLTE App -->
    <script>
        var EDITOR_DATA = CKEDITOR.replace('editor1');
        $(function() {
            $(document).on('click', '#saveLetter', function() {
                console.log(EDITOR_DATA.getData());
            });
            $(document).on('click', '#printLetter', function() {
                print('editor1');
            });

            function print() {
                console.log('a');
                EDITOR_DATA.execCommand('print');
            }
        });
    </script>
@endsection
