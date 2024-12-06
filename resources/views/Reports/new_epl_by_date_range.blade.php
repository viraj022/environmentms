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
        <h1>{{ $isNew == 1 ? 'New' : 'Renewed' }} EPL Report </h1>
        <h5>From: {{ $from }} - To: {{ $to }} (Submit Date)</h5>
    </center>
    <table class="table cell-border compact stripe">
        <thead>
            <tr>
                <th>#</th>
                <th>EPL Code</th>
                <th>Submit Date</th>
                <th>Industry Name</th>
                <th>Zone</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row['epl_code'] }}</td>
                    <td>{{ Carbon\Carbon::parse($row['submitted_date'])->format('Y-m-d') }}</td>
                    <td><a
                            href="{{ route('industry_profile.find', $row['client_id']) }}">{{ $row['industry_name'] }}</a>
                    </td>
                    <td>{{ $row['zone'] }}</td>
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
                ordering: true,
                paging: false,
                dom: "Bfrtip",
                // buttons: ["csv", "excel", "print",],
                buttons: [{
                    extend: 'print',
                    title: '',
                    customize: function(win) {
                        $(win.document.body)
                            .css('font-size', '10pt')
                            .prepend(
                                '<center><h1>Monthly Progress</h1></center><img src=' + img +
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
