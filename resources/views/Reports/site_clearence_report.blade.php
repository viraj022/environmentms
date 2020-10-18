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
     {{-- @dump($data); --}}
<table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Date</th>
                                                    <th>File Number</th>
                                                    <th>Applications Name and Address</th>
                                                    <th>Industry</th>
                                                    <th>Location</th>
                                                    <th>Inspection Feee</th>
                                                    <th>Letter Issued Date</th>                                     
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($data as $indexKey=>$row)
                                                <tr>
                                                    <td>{{$indexKey+1}}.</td>
                                                    <td>{{$row[1]}}</td>
                                                    <td>{{$row[2]}}</td>                                                 
                                                    <td>{{$row[3]}}</td>                                                 
                                                    <td>{{$row[4]}}</td>                                                 
                                                    <td>{{$row[5]}}</td>                                                 
                                                    <td>{{$row[6]}}</td>                                                 
                                                    <td>{{$row[7]}}</td> 
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/dataTable/datatables.min.js"></script>
    <script>
        // $('.table').DataTable();
        $(document).ready( function () {
            alert(123);
    $('.table').DataTable();
} );
    </script>
    </body>
</html>

 
