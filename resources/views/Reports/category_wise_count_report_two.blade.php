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
        <h3>File Count By Category</h3>      
        <h5>From: {{$from}} .To: {{$to}}</h5>
    </center>
    <h6>Report Genaration Time :{{$time_elapsed_secs}} seconds</h6>
     {{-- @dump($req_array["40"]); --}}
<table id="table" class="table cell-border compact stripe">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Local Authority Name</th>
                                                    <th>Category Name</th>
                                                    <th>SC new</th>
                                                    <th>SC Extend</th>
                                                    <th>EPL New</th>
                                                    <th>EPL Renew</th>                              
                                                    <th>Certificate Issued</th>                              
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($req_array as $array)                                               
                                                 @foreach($array['cat'] as $row)
                                                <tr>
                                                    <td>1.</td>       
                                                    <td>{{$array['name']}}</td>                                           
                                                    <td>{{$row['name']}}</td>
                                                    <td>{{$row['site_new']}}</td>                                                 
                                                    <td>{{$row['site_renew']}}</td>                                                 
                                                    <td>{{$row['epl_new']}}</td>                                                 
                                                    <td>{{$row['epl_renew']}}</td>                                           
                                                    <td>{{$row['certificate_issue']}}</td>                                           
                                                </tr>
                                                  @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- @dump($environmentOfficer) --}}
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/dataTable/datatables.min.js"></script>
    <script type="text/javascript" src="/js/image.js"></script>
    <script>
       
        var from = '{{$from}}';
        var to = '{{$to}}';
        // var img = 
        // $('.table').DataTable();
        $(document).ready( function () {

            $('#table thead tr').clone(true).appendTo( '#table thead' );
    $('#table thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
 
        $( 'input', this ).on( 'keyup change', function () {
            if ( table.column(i).search() !== this.value ) {
                table
                    .column(i)
                    .search( this.value )
                    .draw();
            }
        } );
    } );
            // alert(123);
    $('.table').DataTable({
        colReorder: true,
         responsive: true,
         select: true,
        orderCellsTop: true,
        fixedHeader: true,
        dom: "Bfrtip",
        // buttons: ["csv", "excel", "print",],
        buttons: [{
                extend: 'print',
                title : '',
                customize: function ( win ) {                  
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<center><H1>File Count By Category</h1><h4>from: '+from+' to: '+to+'</h4></center><img src='+img+' style="position:absolute; filter: grayscale(100%); opacity: 0.5; top:0; left:0;" />'
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

 
