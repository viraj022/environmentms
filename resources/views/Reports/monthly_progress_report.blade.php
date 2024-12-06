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
        <h1>Progress Report </h1>
        <h5>From: {{ $from }} - To: {{ $to }}</h5>
    </center>
    <h4>Report Genaration Time :{{ $time_elapsed_secs }} seconds</h4>
    {{-- @dump($newEplCount); --}}
    <table class="table cell-border compact stripe">
        <thead>
            <tr>
                <th>#</th>
                <th> </th>
                <th>Application</th>
                @foreach ($zones as $zone)
                    <th>{{ $zone['name'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{-- @dump($result); --}}
            @foreach ($result as $row)
                {{-- @dump($row) --}}
                <tr>
                    <th>{{ $row['type'] }}</th>
                    <th>{{ $row['name'] }}</th>
                    @if ($row['type'] == 'received' && $row['name'] == 'SC(New)')
                        <th><a href="{{ route('new_cs_report', [$from, $to, 1]) }}">{{ $row['application'] }}</a></th>
                    @elseif($row['type'] == 'received' && $row['name'] == 'SC(EX)')
                        <th><a href="{{ route('new_cs_report', [$from, $to, 0]) }}">{{ $row['application'] }}</a></th>
                    @elseif($row['type'] == 'received' && $row['name'] == 'EPL(New)')
                        <th><a href="{{ route('new_epl_report', [$from, $to, 1]) }}">{{ $row['application'] }}</a>
                        </th>
                    @elseif($row['type'] == 'received' && $row['name'] == 'EPL(R)')
                        <th><a href="{{ route('new_epl_report', [$from, $to, 0]) }}">{{ $row['application'] }}</a>
                        </th>
                    @else
                        <th>{{ $row['application'] }}</th>
                    @endif

                    @foreach ($zones as $zk => $zv)
                        @if (array_key_exists($zk, $row['object']))
                            <th>{{ $row['object'][$zk]['total'] }}</th>
                        @else
                            <th></th>
                        @endif
                    @endforeach
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
                ordering: false,
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
