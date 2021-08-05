<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="api-token" content="{{auth()->user()->api_token}}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Environemnt Authority | North Western Province</title>
        <link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css"/>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed text-sm">
    <center>
        <h1>Envrionment Protection Licence Log </h1>
        <h5>From: {{$from}} - To: {{$to}}</h5>
    </center>
    <h4>Report Genaration Time :{{$time_elapsed_secs}} seconds</h4>
    {{-- @dump($data); --}}
    <table class="table cell-border compact stripe">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>File Number</th>
                <th>Applications Name and Address</th>
                <th>Industry</th>
                <th>Location</th>
                <th>Inspection Nature</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $indexKey=>$row)
            <tr>
                <td>{{$indexKey+1}}.</td>
                <td>{{$row['submitted_date']}}</td>
                <td>{{$row['code']}}</td>                                                 
                <td>{{$row['name_title']}}</td>                                                 
                <td>{{$row['category_name']}}</td>                                                 
                <td>{{$row['industry_address']}}</td>  
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


