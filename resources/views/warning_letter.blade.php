@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
<!-- Theme style -->
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
@if($pageAuth['is_read']==1 || false)

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="">
                            <div class="">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input id="getByAssDir" class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Search By Assistant Director</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="getAsDirect" class="form-control form-control-sm">
                                            <option value="0">Loading..</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button id="getByAssDirGenBtn" type="button" class="btn btn-block btn-primary btn-xs">Generate</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body table-responsive" style="height: 700px;">
                            <table class="table table-condensed" id="tblExpiredCertificate">
                                <thead>
                                    <tr>
                                        <th style="width: 5em">#</th>
                                        <th style="width: 20em">Industry Name</th>
                                        <th style="width: 25em">File No</th>
                                        <th style="width: 25em">Pradeshiya Sabha</th>
                                        <th style="width: 20em">Status</th>
                                        <th style="width: 20em">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
<script src="../../js/CertificatePreferJS/expired_certificate.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
//Load table
        loadAssDirCombo();
        getExpiredCerByAssDir(null);
//select button action 
        $(document).on('click', '#getByAssDirGenBtn', function () {
            if ($('#getByAssDir').is(":checked")) {
//                alert();
                getExpiredCerByAssDir($('#getAsDirect').val());
            } else {
                getExpiredCerByAssDir(null);
            }
        });

        $(document).on('click', '.gen-warn-letter', function(){
            var data = {
              "client_id": $(this).data('client'),
              "expired_date": $(this).data('expire-date'),
              "file_type": $(this).data('file-type')
            };
            create_warn_letter(data, function(){
                getExpiredCerByAssDir();
            });
        });
    });

    function create_warn_letter(data, callBack){
        var url = "/api/save_warning_letter";
        ajaxRequest('POST', url, data, function (result) {
           if(result.status == 1){
               swal.fire('Success', result.message, 'success');
           }else{
               swal.fire('Error', result.message, 'error');
           }
           if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
               callBack(result);
           }
        });
    }

    function getExpiredCerByAssDir(id, callBack) {
    var url = "/api/certificate/expiredCertificates";
    if (id != null) {
        url = "/api/certificate/expiredCertificates/id/" + id;
    }
//    console.log(url);
//    var certificate_status = {0: 'pending', 1: 'Drafting', 2: 'Drafted', 3: 'AD Pending', 4: 'Director Pending', 5: 'Director Approved', 6: 'Issued', '-1': 'Hold'};
//    var certificate_type = {0: 'pending', 1: 'New EPL', 2: 'Renew EPL', 3: 'New Site Clearance', 4: 'Site Clearance Extended'};
    ajaxRequest('GET', url, null, function (result) {
        var tbl = '';
        if (result.length == 0) {
            tbl += '<td colspan="5">Data Not Found</td>';
        } else {
            $('#tblExpiredCertificate').DataTable().destroy();
            $.each(result, function (index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td>' + row.client.industry_name + '</td>';
                tbl += '<td>' + row.cetificate_number + ' (<a href="/industry_profile/id/' + row.client_id + '" target="_blank">' + row.client.file_no + '</a>)</td>';
                tbl += '<td>' + row.client.pradesheeyasaba.name + '</td>';
                tbl += '<td>(' + row.expire_date + ')' + row.due_date + '</td>';
                 console.log(row);
                if(row.client.warning_letters.length == 0){
                  tbl += '<td><button type="button" class="btn btn-success gen-warn-letter" data-client="'+row.client_id+'" data-expire-date="'+row.expire_date+'" data-file-type="'+row.certificate_type+'">Generate Warning Letter</button></td>';
                }else{
                  tbl += '<td><a href="/warn_view/id/'+row.id+'" class="btn btn-primary">View Warning Letter</a></td>';
                }
                tbl += '</tr>';
            });
        }
        $('#tblExpiredCertificate tbody').html(tbl);
        $('#tblExpiredCertificate').DataTable({
            stateSave: true
        });
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}
</script>
@endsection
