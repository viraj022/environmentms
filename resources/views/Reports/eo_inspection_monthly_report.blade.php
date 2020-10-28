<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="api-token" content="{{auth()->user()->api_token}}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EPL Report | North Western Province</title>
        <link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css"/>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed text-sm">
        <center>
        <h3>Field Officer Inspection Log</h3>
        <h4>{{$environmentOfficer->user->first_name ." ".$environmentOfficer->user->last_name}}</h4>
        <h5>From: {{$from}} .To: {{$to}}</h5>
    </center>
    <h6>Report Genaration Time :{{$time_elapsed_secs}} seconds</h6>
     {{-- @dump($data); --}}
<table class="table cell-border compact stripe">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Date</th>
                                                    <th>Local Authority</th>
                                                    <th>Industry Address</th>
                                                    <th>File Code</th>
                                                    <th>Distance</th>                              
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($rows as $indexKey=>$row)
                                                <tr>
                                                    <td>{{$indexKey+1}}.</td>
                                                    <td>{{$row['Date']}}</td>
                                                    <td>{{$row['pradesheeyasaba']}}</td>                                                 
                                                    <td>{{$row['location']}}</td>                                                 
                                                    <td>{{$row['file_no']}}</td>                                                 
                                                    <td>{{$row['distance']}}</td>                                           
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- @dump($environmentOfficer) --}}
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/dataTable/datatables.min.js"></script>
    <script type="text/javascript" src="/js/image.js"></script>
    <script>
        var officerName = '{{$environmentOfficer->user->first_name ." ".$environmentOfficer->user->last_name}}' ;
        var from = '{{$from}}';
        var to = '{{$to}}';
        // var img = 
        // $('.table').DataTable();
        $(document).ready( function () {
            // alert(123);
    $('.table').DataTable({
        colReorder: true,
         responsive: true,
         select: true,
        dom: "Bfrtip",
        // buttons: ["csv", "excel", "print",],
        buttons: [{
                extend: 'print',
                title : '',
                customize: function ( win ) {                  
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<center><H1>Field Officer Inspection Log</h1><h3>'+officerName+'</h3><h4>from: '+from+' to: '+to+'</h4></center><img src='+img+' style="position:absolute; filter: grayscale(100%); opacity: 0.5; top:0; left:0;" />'
                        ); 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
            },"excel","csv"],
        
    });
} );
    </script>
    </body>
</html>

 
