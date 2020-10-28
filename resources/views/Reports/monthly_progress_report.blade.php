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
         <h1>Progress Report </h1>
           <h5>From: {{$from}} - To: {{$to}}</h5>
          </center>
        <h4>Report Genaration Time :{{$time_elapsed_secs}} seconds</h4>
     {{-- @dump($newEplCount); --}}
<table class="table cell-border compact stripe">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th> </th>
                                                    <th>Application</th>   
                                                    @foreach ($assistanceDirectors as $assistanceDirector)
                                                         <th>{{$assistanceDirector['name']}} <br> {{$assistanceDirector['first_name']}} {{$assistanceDirector['last_name']}}</th> 
                                                    @endforeach                                                                           
                                                </tr>
                                            </thead>
                                            <tbody>   
                                                {{-- @dump($result); --}}
                                               @foreach ($result as $row)
                                                       <tr>
                                                         <th>{{$row['type']}}</th>  
                                                         <th>{{$row['name']}}</th>  
                                                         <th>{{$row['application']}}</th>  
                                                          @foreach ($row['object'] as $o)
                                                          <th>{{$o['total']}}</th>  
                                                           @endforeach    
                                                       </tr>
                                                    @endforeach                                  
                                                {{-- <tr>                                                   
                                                    <td>Recieved </td>
                                                    <td>SC (New)</td>                                                 
                                                    <td>45</td>  
                                                     @foreach ($siteNewCount as $siteNew)
                                                         <th>{{$siteNew['total']}}</th> 
                                                    @endforeach                                             
                                                </tr>
                                                <tr>                                                   
                                                    <td>Recieved </td>
                                                    <td>SC (R)</td>                                                 
                                                    <td>45</td> 
                                                      @foreach ($siteNewCount as $siteNew)
                                                         <th>{{$siteNew['total']}}</th> 
                                                    @endforeach                                                
                                                </tr>
                                                 <tr>                                                   
                                                    <td>Recieved </td>
                                                    <td>EPL (New)</td>                                                 
                                                    <td>45</td> 
                                                      @foreach ($siteNewCount as $siteNew)
                                                         <th>{{$siteNew['total']}}</th> 
                                                    @endforeach                                                
                                                </tr>
                                                 <tr>                                                   
                                                     <td>Recieved </td>
                                                    <td>EPL (R)</td>                                                 
                                                    <td>45</td> 
                                                      @foreach ($siteNewCount as $siteNew)
                                                         <th>{{$siteNew['total']}}</th> 
                                                    @endforeach                                                
                                                </tr>
                                                 <tr>                                                   
                                                     <td>Recieved </td>
                                                    <td>Agrarian Services </td>                                                 
                                                    <td>45</td>  
                                                      @foreach ($siteNewCount as $siteNew)
                                                         <th>{{$siteNew['total']}}</th> 
                                                    @endforeach                                               
                                                </tr>
                                                 <tr>                                                   
                                                    <td>Recieved </td>
                                                    <td>Land Lease Out</td>                                                 
                                                    <td>45</td> 
                                                      @foreach ($siteNewCount as $siteNew)
                                                         <th>{{$siteNew['total']}}</th> 
                                                    @endforeach                                                
                                                </tr>
                                                 <tr>                                                   
                                                    <td>Recieved </td>
                                                    <td>Court Case</td>                                                 
                                                    <td>45</td>  
                                                      @foreach ($siteNewCount as $siteNew)
                                                         <th>{{$siteNew['total']}}</th> 
                                                    @endforeach                                               
                                                </tr>
                                                 <tr>                                                   
                                                    <td>Recieved </td>
                                                    <td>Complaint</td>                                                 
                                                    <td>45</td>  
                                                      @foreach ($siteNewCount as $siteNew)
                                                         <th>{{$siteNew['total']}}</th> 
                                                    @endforeach                                               
                                                </tr>
                                                 <tr>                                                   
                                                    <td>Recieved </td>
                                                    <td>Other</td>                                                 
                                                    <td>45</td>  
                                                      @foreach ($siteNewCount as $siteNew)
                                                         <th>{{$siteNew['total']}}</th> 
                                                    @endforeach                                               
                                                </tr> --}}
                                         
                                            </tbody>
                                        </table>
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/dataTable/datatables.min.js"></script>
    <script type="text/javascript" src="/js/image.js"></script>
    <script>
        // var img = 
        // $('.table').DataTable();
        $(document).ready( function () {
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
                title : '',
                customize: function ( win ) {                  
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<center><H1>Monthly Progress</h1></center><img src='+img+' style="position:absolute; filter: grayscale(100%); opacity: 0.5; top:0; left:0;" />'
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

 
