@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
<!-- Theme style -->
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css"/>

<!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
@if($pageAuth['is_read']==1 || false)
<section class="content-header">
    <div class="container-fluid">
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="card-body table-responsive" style="height: 700px;">
                            <table class="table table-condensed" id="pending_epl_report">
                                <thead>
                                    <tr>
                                        <th style="width: 5em">#</th>
                                        <th style="width: 20em">File No</th>
                                        <th style="width: 20em">Industry Name</th>
                                        <th style="width: 25em">Pradesheeya Sabha</th>
                                        <th style="width: 25em">EO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach ($pending_epl_data as $data)
                                     <tr>
                                         <td>{{ ++$loop->index }}</td>
                                         @if(isset($data->client))
                                         <td><a href="/industry_profile/id/{{ $data->client->id }}" class="btn btn-dark" target="_blank">{{ $data->client->file_no }}</a></td>
                                         @else
                                            <td><a href="" class="btn btn-dark" target="_blank">-</a></td>
                                         @endif
                                         <td>{{ (!isset($data->client)) ? '-' : $data->client->industry_name}}</td>
                                         <td>{{ (!isset($data->client->pradesheeyasaba)) ? '-' : $data->client->pradesheeyasaba->name }}</td>
                                         <td>{{ (!isset($data->client->environmentOfficer->user)) ? 'Not Assigned' : $data->client->environmentOfficer->user->first_name.' '.$data->client->environmentOfficer->user->last_name}}</td>
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
@endif
@endsection

@section('pageScripts')
<!-- Page script -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script type="text/javascript" src="/dataTable/datatables.min.js"></script>
<script type="text/javascript" src="/js/image.js"></script>

<!-- AdminLTE App -->
<script>
    // var img = 
    // $('.table').DataTable();
    $(document).ready( function () {
        // alert(123);
$('#pending_epl_report').DataTable({
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
                        '<center><H1>Pending EPL Report</h1></center><img src='+img+' style="position:absolute; filter: grayscale(100%); opacity: 0.5; top:0; left:0;" />'
                    ); 
                $(win.document.body).find( 'table' )
                    .addClass( 'compact' )
                    .css( 'font-size', 'inherit' );
            }
        },"excel","csv"],
    
});

});
</script>
@endsection
