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
<link rel="stylesheet" type="text/css" href="/dataTable/Buttons-1.6.5/css/buttons.dataTables.min.css"/>

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
                            <table class="table table-condensed" id="pending_site_clear_report">
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
                                  @foreach ($pending_site_clear_data as $data)
                                     <tr>
                                         <td>{{ ++$loop->index }}</td>
                                         <!-- @if (!isset($data->siteClearenceSession->client))
                                           @continue
                                         @endif -->
                                         <td><a href="/industry_profile/id/{{ $data->siteClearenceSession->client->id }}"
                                             class="btn btn-dark"
                                             target="_blank">{{ !isset($data->siteClearenceSession->client->file_no) ? 'N/A' : $data->siteClearenceSession->client->file_no }}</a></td>

                                         <td>{{ (!isset($data->siteClearenceSession->client)) ? '-' : $data->siteClearenceSession->client->industry_name}}</td>
                                         <td>{{ (!isset($data->siteClearenceSession->client->pradesheeyasaba)) ? '-' : $data->siteClearenceSession->client->pradesheeyasaba->name }}</td>
                                         <td>{{ (!isset($data->siteClearenceSession->client->environmentOfficer->user)) ? 'Not Assigned' : $data->siteClearenceSession->client->environmentOfficer->user->first_name.' '.$data->siteClearenceSession->client->environmentOfficer->user->last_name}}</td>
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
<script type="text/javascript" src="/dataTable/Buttons-1.6.5/dataTables.buttons.min.js"></script>

<!-- AdminLTE App -->
<script>
    // var img = 
    // $('.table').DataTable();
    $(document).ready( function () {
        // alert(123);
$('#pending_site_clear_report').DataTable({
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
                        '<center><H1>Pending Site Clearence Report</h1></center><img src='+img+' style="position:absolute; filter: grayscale(100%); opacity: 0.5; top:0; left:0;" />'
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
