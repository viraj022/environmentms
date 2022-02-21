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

        table.dataTable td {
            word-break: break-word;
        }

    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>Letters</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="sticky-top mb-3">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered" id="letter_view_tbl">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">#</th>
                                            <th style="width: 30%">title</th>
                                            <th style="width: 25%">created date</th>
                                            <th style="width: 15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
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
        $(function() {
            load_letters();
        });

        function load_letters() {
            let url = '/api/get_all_letters/';
            ajaxRequest('GET', url, null, function(resp) {
                var letter_view_tbl = "";
                $('#letter_view_tbl').DataTable().destroy();
                $.each(resp, function(key, value2) {
                    key++;
                    letter_view_tbl += "<tr><td>" + key + "</td><td>" + value2.letter_title + "</td><td>" +
                        value2.created_at + "</td><td><a href='/get_letter/letter/" + value2.id +
                        "' class='btn btn-success'>View</a></td></tr>";
                });
                $('#letter_view_tbl tbody').html(letter_view_tbl);
                $('#letter_view_tbl').DataTable({
                    responsive: true,
                    aLengthMenu: [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, "All"]
                    ],
                    "bDestroy": true,
                    iDisplayLength: 10
                });
            });
        }
    </script>
@endsection
