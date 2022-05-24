<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="api-token" content="{{auth()->user()->api_token}}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Site Clearance Log Report | North Western Province</title>
        <link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css"/>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed text-sm">
    <center>
        <h1>Site Clearance Log Report </h1>
        <h5>From: {{$from}} .To: {{$to}}</h5>
    </center>
    <h4>Report Genaration Time :{{$time_elapsed_secs}} seconds</h4>
    {{-- @dump($data['results'][2]); --}}
    <table class="table cell-border compact stripe">
        <thead>
            <tr>
                <th>#</th>
                <th>Applications Name and Address</th>
                <th>Site Clearance Code</th>
                <th>Industry</th>
                {{-- <th>Location</th> --}}
                <th style="width: 4em">Submitted Date</th>
                <th>Nature</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['results'] as $indexKey=>$row)
            <tr>
                <td>{{$indexKey+1}}.</td>
                <td>{{$row['name_title']}}</td>                                                 
                <td><a href="/industry_profile/id/{{$row['client_id']}}" target="_blank">{{$row['code_site']}}</a></td>                                                 
                <td>{{$row['category_name']}}</td>                                                 
                {{-- <td>{{$row['industry_address']}}</td>                                                       --}}
                <td>{{$row['submit_date']}}</td>
                <td>{{$row['nature']}}</td> 
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
$(document).ready(function () {
    // alert(123);
    $('.table').DataTable({
        "order": [[ 1, "desc" ]],
        colReorder: true,
        responsive: true,
        select: true,
        dom: "Bfrtip",
        // buttons: ["csv", "excel", "print",],
        buttons: [{
                extend: 'print',
                title: '',
                customize: function (win) {
                    $(win.document.body)
                            .css('font-size', '10pt')
                            .prepend(
                                    '<center><H1>Site Clearence Report</h1></center><img src=' + img + ' style="position:absolute; filter: grayscale(100%); opacity: 0.5; top:0; left:0;" />'
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


