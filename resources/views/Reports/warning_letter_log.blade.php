<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="api-token" content="{{ auth()->user()->api_token }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEA | North Western Province</title>
    <link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed text-sm">
    <center>
        <h1>Warning Letter/SMS Log</h1>
    </center>
    <table class="table cell-border compact stripe">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>File Code</th>
                <th>Applications Name</th>
                <th>Industry Name</th>
                <th>Industry Category</th>
                <th>Created Date</th>
            </tr>
        </thead>
        {{-- {{ dd($warn_let_data) }} --}}
        <tbody>
            {{-- {{ dd($warn_let_data) }} --}}
            @foreach ($warn_let_data as $key => $value)
                <tr>
                    @if (!isset($value->client->id))
                        @continue
                    @endif
                    <td>{{ $key + 1 }}</td>
                    <td><a href="{{ $value->client->id }}">{{ $value->client->file_no }}</a></td>
                    <td>{{ $value->client->first_name . ' ' . $value->client->last_name }}</td>
                    <td>{{ $value->client->industry_name }}</td>
                    <td>{{ $value->client->industryCategory->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($value->created_at)->format('Y-m-d') }}</td>
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
