<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="api-token" content="{{ auth()->user()->api_token }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Environemnt Authority | North Western Province</title>
    <link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <center>
        <h1>{{ $title }}</h1>
        <h5>From: {{ $from }} To: {{ $to }}</h5>
    </center>
    <h4>Report Genaration Time :{{ $time_elapsed_secs }} seconds, (Filter by Issue Date)</h4>
    {{-- @dump($data); --}}
    <table class="table cell-border compact stripe">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Applications Name</th>
                <th>Address</th>
                <th>Industry</th>
                <th>Inspection Fee</th>
                <th>Site Clearance Number</th>
                <th>Submited Date</th>
                <th>Issued Date</th>
                <th>Created Date</th>
                <th>Nature</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $indexKey => $row)
                <tr>
                    <td>{{ $indexKey + 1 }}.</td>
                    <td>{{ $row[2] }}</td>
                    <td>{{ $row[11] }}</td>
                    <td>{{ $row[3] }}</td>
                    <td>{{ $row[5] }}</td>
                    <td><a href="/industry_profile/id/{{ $row[9] }}" target="_blank">{{ $row[1] }}</a>
                    </td>
                    <td>{{ $row[6] }}</td>
                    <td>{{ $row[7] }}</td>
                    <td>{{ $row[8] }}</td>
                    <td>{{ $row[9] }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/dataTable/datatables.min.js"></script>
    <script type="text/javascript" src="/js/image.js"></script>
    <script>
        // var img =
        // $('.table').DataTable();
        $(document).ready(function() {
            // alert(123);
            $('.table').DataTable({
                colReorder: true,
                responsive: true,
                select: true,
                dom: "Bfrtip",
                // buttons: ["csv", "excel", "print",],
                buttons: [{
                    extend: 'print',
                    title: '',
                    customize: function(win) {
                        $(win.document.body)
                            .css('font-size', '10pt')
                            .prepend(
                                '<center><H1>Site Clearence Report</h1></center><img src=' +
                                img +
                                ' style="position:absolute; filter: grayscale(100%); opacity: 0.5; top:0; left:0;" />'
                            );
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }, "excel", "csv"],

            });
        });
    </script>
</body>

</html>
