<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="api-token" content="{{ auth()->user()->api_token }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EPL Report | North Western Province</title>
    <link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <center>
        <h1>EPL Report </h1>
        <h5>Filtered by created at - From: {{ $from }} - To: {{ $to }}</h5>
    </center>
    <h4>Report Genaration Time :{{ $time_elapsed_secs }} seconds, (filter By Issue date)</h4>
    {{-- @dump($data['results'][2]); --}}
    <table class="table cell-border compact stripe">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Applications Name and Address</th>
                <th>Industry</th>
                <th>EPL Code</th>
                <th>File No</th>
                <th>Ref No</th>
                <th>Inspection Fee</th>
                <th>Inspection Bill Date</th>
                <th>Licence No</th>
                {{-- <th>Created Date</th> --}}
                <th>Submitted Date</th>
                <th>Issued Date</th>
                <th>Nature</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['results'] as $indexKey => $row)
                <tr>
                    <td>{{ $indexKey + 1 }}.</td>
                    <td>{{ $row['name_title'] }}</td>
                    <td>{{ $row['category_name'] }}</td>
                    <td>{{ $row['code'] }}</td>
                    <td><a href="/industry_profile/id/{{ $row['client_id'] }}"
                            target="_blank">{{ $row['file_no'] }}</a></td>
                    <td>{{ $row['ref_no'] }}</td>
                    <td>{{ $row['inspection_fee'] }}</td>
                    <td>{{ $row['inspection_pay_date'] }}</td>
                    <td>{{ $row['license_number'] }}</td>
                    {{-- <td>{{ $row['created_at'] }}</td> --}}
                    <td>{{ $row['submitted_date'] }}</td>
                    <td>{{ $row['issue_date'] }}</td>
                    <td>{{ $row['nature'] }}</td>
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
