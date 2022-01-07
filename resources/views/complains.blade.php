@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')

@section('content')

<link href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
<!-- Main content -->

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="card card-primary mt-5 col-6">
                <div class="card-header">Complains</div>
                <div class="card-body">
                    <form id="complain_frm">
                        <div class="form-group">
                            <label>Complain Recieve Type</label>
                            <select id="recieve_type_ipt" class="form-control form-control-sm col-md-4">
                                <option value="1">Call</option>
                                <option value="2">Written</option>
                                <option value="3">Verbal</option>
                            </select>
                            <div id="recieve_type_valid" class="d-none">
                                <p class="text-danger">Recieve type required</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Complainer Name*</label>
                            <input id="complainer_name_ipt" type="text" maxlength="45" class="form-control form-control-sm cutenzReq" placeholder="Enter complainer name..." value="">
                            <div id="comp_name_valid" class="d-none">
                                <p class="text-danger">Container Name is required</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Complainer Address*</label>
                            <input id="complainer_address_ipt" type="text" maxlength="45" class="form-control form-control-sm cutenzReq" placeholder="Enter complainer address..." value="">
                            <div id="comp_address_valid" class="d-none">
                                <p class="text-danger">Container Address is required</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Complainer Contact Number</label>
                            <input id="contact_complainer_ipt" onKeyDown="if (this.value.length == 10 && event.keyCode != 8)
                                        return false;" type="number" class="form-control form-control-sm col-md-4" placeholder="Enter Contact Number of complainer..." value="">
                            <div id="contact_complainer_valid" class="d-none">
                                <p class="text-danger">Complainer Contact Number is required</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Complain Description</label>
                            <textarea id="complain_desc_input" class="form-control form-control-sm" placeholder="Enter complain Description..." value=""></textarea>
                            <div id="complain_desc_valid" class="d-none">
                                <p class="text-danger">Complain description required</p>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="form-group col-12">
                                <button type="button" class="btn btn-lg btn-success" id="save">Save</button>
                                <button type="button" class="btn btn-lg btn-warning d-none" id="update">Update</button>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
            <div class="card card-primary mt-5 col-6">
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th>Description</th>
                                <th>Recieved By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="text-center"><b>No Data</b></td> 
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('pageScripts')

<!-- Page script -->
<script>

    $(document).ready(function () {

    });

    $('#save').click(function () {
        save_complain();
    });

    function load_complains() {
        let url = '/api/complain_data';
        ajaxRequest('GET', url, null, function (resp) {
            $('#epl_count').html(resp.epl_count);
            $('#site_count').html(resp.site_count);
        });
    }

    function save_complain() {
        let url = '/api/save_complain';
        let data = $('#complain_frm').serializeArray();
        ajaxRequest('POST', url, data, function (resp) {
            if (resp.status == 1) {
                swal.fire('success', 'Successfully save the complains', 'success');
                location.reload();
            } else {
                swal.fire('failed', 'Complain saving is unsuccessful', 'warning');
            }
        });
    }
</script>

@endsection

