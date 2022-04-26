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

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="card-body table-responsive" style="height: 700px;">
                            <table class="table table-condensed" id="tbl_warn_report">
                                <thead>
                                    <tr>
                                        <th style="width: 5em">#</th>
                                        <th style="width: 20em">Industry Name</th>
                                        <th style="width: 25em">File No</th>
                                        <th style="width: 25em">Pradeshiya Sabha</th>
                                        <th style="width: 20em">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($warn_let_data as $data)
                                    <tr>
                                        <td>{{ $loop->index+1}}</td>
                                        <td>{{$data['client']['industry_name']}}</td>
                                        <td>{{$data['cetificate_number'].'('.$data['client']['file_no'].')'}}</td>
                                        <td>{{$data['client']['pradesheeyasaba']['name']}}</td>
                                        <td>{{'('. $data['expire_date']. ')'.$data['due_date']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>
<script src="/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/dataTable/datatables.min.js"></script>
    <script type="text/javascript" src="/js/image.js"></script>
    <script>
        // var img = 
        // $('.table').DataTable();
        $(document).ready( function () {
            // alert(123);
    $('#tbl_warn_report').DataTable({
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
                            '<center><H1>Warning Letter Report</h1></center><img src='+img+' style="position:absolute; filter: grayscale(100%); opacity: 0.5; top:0; left:0;" />'
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
