@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
<!-- Select2 -->
<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
@if($pageAuth['is_read']==1 || false)
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Old Data Registration</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i> Client Details
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Name:</dt>
                            <dd class="col-sm-6" id="client_name"></dd>
                            <dt class="col-sm-4">Address:</dt>
                            <dd class="col-sm-6" id="client_address"></dd>
                            <dt class="col-sm-4">Contact No:</dt>
                            <dd class="col-sm-6" id="client_cont"></dd>
                            <dt class="col-sm-4">Contact Email:</dt>
                            <dd class="col-sm-6" id="client_amil"></dd>
                        </dl>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card card-success">
                    <div class="card-header">
                        <label id="lblTitle">Add Old File</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Industry Type*</label>
                            <div class="col-sm-12">
                                <select id="getIndustryType" class="form-control form-control-sm">
                                    <option value="01">EPL</option>
                                    <option value="02">Site Clearance</option>
                                    <option value="03">Telecommunication</option>
                                </select>
                            </div>
                        </div>
                        <button id="btnLoadAc" class="btn btn-primary">Load</button>
                        <div class="eplSection legitSection d-none"> 
                            <div class="form-group">
                                <label class="txtCodeCn">EPL Code*</label>
                                <input id="getEPLCode" type="text" class="form-control form-control-sm" placeholder="Enter EPL Code..." value="">
                                <div id="valEPL" class="d-none"><p class="text-danger">EPL is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Remark</label>
                                <input id="getRemark" type="text" class="form-control form-control-sm" placeholder="Enter Remark..." value="">
                                <div id="valRemark" class="d-none"><p class="text-danger">Remark is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Issue Date*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input id="issue_date" name="datepickerUi" type="text" data-date="" data-date-format="YYYY MM DD" max="2999-12-31" class="form-control form-control-sm" placeholder="Enter Issue Date..." value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Expire Date*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input id="expire_date" name="datepickerUi"  max="2999-12-31"class="form-control form-control-sm " placeholder="Enter Expire Date..." value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Last Submitted Date*</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input id="getsubmitDate" name="datepickerUi"  max="2999-12-31" class="form-control form-control-sm" placeholder="Enter Submit Date..." value="">
                                </div>
                            </div>
                            <div class="form-group showCertificateNo">
                                <label>Certificate No*</label>
                                <input id="getcertifateNo" type="text" class="form-control form-control-sm" placeholder="Enter Certificate No..." value="">
                                <div id="valcertifateNo" class="d-none"><p class="text-danger">Certificate No is required</p></div>
                            </div>
                            <div class="form-group">
                                <label>Previous Renews*</label>
                                <div class="col-sm-12">
                                    <select id="getPreRenew" class="form-control form-control-sm">
                                        <option value="0">First</option>
                                        <option value="1">R 1</option>
                                        <option value="2">R 2</option>
                                        <option value="3">R 3</option>
                                        <option value="4">R 4</option>
                                        <option value="5">R 5</option>
                                        <option value="6">R 6</option>
                                        <option value="7">R 7</option>
                                        <option value="8">R 8</option>
                                        <option value="9">R 9</option>
                                        <option value="10">R 10</option>
                                        <option value="11">R 11</option>
                                        <option value="12">R 12</option>
                                        <option value="13">R 13</option>
                                        <option value="14">R 14</option>
                                        <option value="15">R 15</option>
                                        <option value="16">R 16</option>
                                        <option value="17">R 17</option>
                                        <option value="18">R 18</option>
                                        <option value="19">R 19</option>
                                        <option value="21">R 20</option>
                                        <option value="22">R 22</option>
                                        <option value="23">R 23</option>
                                        <option value="24">R 24</option>
                                        <option value="25">R 25</option>
                                        <option value="26">R 26</option>
                                        <option value="27">R 27</option>
                                        <option value="28">R 28</option>
                                        <option value="29">R 29</option>
                                        <option value="30">R 30</option>
                                        <option value="31">R 31</option>
                                        <option value="32">R 32</option>
                                        <option value="33">R 33</option>
                                        <option value="34">R 34</option>
                                        <option value="35">R 35</option>
                                        <option value="36">R 36</option>
                                        <option value="37">R 37</option>
                                        <option value="38">R 38</option>
                                        <option value="39">R 39</option>
                                        <option value="40">R 40</option>
                                        <option value="41">R 41</option>
                                        <option value="42">R 42</option>
                                        <option value="43">R 43</option>
                                        <option value="44">R 44</option>
                                        <option value="45">R 45</option>
                                        <option value="46">R 46</option>
                                        <option value="47">R 47</option>
                                        <option value="48">R 48</option>
                                        <option value="49">R 49</option>
                                        <option value="50">R 50</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Last Issued Certificate: </label>
                                <input id="last_certificate" type="file" accept="image/*,application/pdf">
                            </div>
                            <div class="progress d-none">
                                <div class="progress-bar bg-primary progress-bar-striped Uploadprogress" id="Uploadprogress" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                    <!--<span class="sr-only">40% Complete (success)</span>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button id="btnSave" type="submit" class="btn btn-success d-none">Save</button>
                        @endif
                        @if($pageAuth['is_update']==1 || false)
                        <button id="btnUpdate" type="submit" class="btn btn-warning d-none">Update</button>
                        @endif
                        @if($pageAuth['is_delete']==1 || false)
                        <button  id="btnshowDelete" type="submit" class="btn btn-danger d-none">Delete</button>
                        @endif
                    </div>                           
                </div>
            </div>


            <div class="col-md-7 uploadEPLSection">
                <div class="card card-success">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card assignFileToOffier">
                                    <div class="card-header">
                                        <h3 class="card-title assignedOfficer">
                                            <i class="fas fa-file-archive"></i> Assign File To Officer
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Assistant Director</label>
                                            <select class="form-control form-control-sm combo_AssistantDirector" id="ass_dir_combo"></select>
                                        </div>
                                        <div class="form-group">
                                            <label>Environment Officer</label>
                                            <select class="form-control form-control-sm combo_envOfficer" id="env_officer_combo"></select>
                                        </div>
                                        <div class="form-group">
                                            <button id="btnAssignEnv" type="submit" class="btn btn-success">Assign</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Other Attachments</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="card-body table-responsive" style="height: 450px;">
                                            <div class="form-group">
                                                <label>Upload: </label>
                                                <input id="otherFiles" accept="application/pdf,image/*" type="file">
                                                @if($pageAuth['is_create']==1 || false)
                                                <button disabled id="btnUpload" type="submit" class="btn btn-success">Upload</button>
                                                @endif
                                            </div>
                                            <div class="card-body injectViewAttachs">                                
                                                <a href="#" target="_blank">Loading Attachments...</a>
                                            </div>                                    
                                        </div>
                                    </div>
                                    <!--                                    <div class="card-footer">
                                    
                                                                        </div> -->
                                </div>
                            </div>                                        
                        </div>
                    </div>
                </div>

                <div class="card card-success d-none lastIssuedCer">
                    <div class="col-md-12">
                        <div class="card-header">
                            <h3 class="card-title">Last Issued Certificate</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="card-body" style="height: 70%; width: 60%;">
                                <div class="card card-widget card-dark">
                                    <div class="card-header">
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Mark as read">
                                                <i class="far fa-circle"></i></button>
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="display: block;">
                                        <a id="addCertificateURL" target="_blank" href=""><img class="img-fluid pad lastCertificatePath" src="#" alt="Certificate"></a>
                                    </div>
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

<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../js/OldFileListJS/old_datareg_api.js"></script>
<script src="../../js/OldFileListJS/load_button_data.js"></script>
<script src="../../js/commonFunctions/file_upload.js" type="text/javascript"></script>
<script src="../../js/OldFileListJS/assign-epl-combo-set.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    let PROFILE = '{{$id}}';
    $(function () {
//Load Combo Sets
        loadAssistantDirectorCombo(function () {
            loadEnvOfficers_combo(parseInt($('#ass_dir_combo').val()), function () {

            });
        });
        $('#ass_dir_combo').change(function () {
            loadEnvOfficers_combo(parseInt($('#ass_dir_combo').val()), function () {
            });
        });
//click save button
        $('#btnSave').click(function () {
            let TYPE = $('#getIndustryType').val();
            var data = fromValues();
            if (Validiteinsert(data)) {
                saveEPLOldFiles(PROFILE, data, TYPE, function (result) {
                    show_mesege(result);
                    visibleUploads(result);
                    regenCLientData(PROFILE);
                    resetinputFields();
                    hideAllErrors();
                    $("#btnLoadAc").click();
                });
            }
        });
        //Load Sections Button
        $('#btnLoadAc').click(function () {
            //EPL Section
            var load_val = $('#getIndustryType').val();
            sectionIfSiteClears(load_val);
            if (load_val === '01') {
                checkEPLExist(PROFILE, function (result) {
//                    visibleUploads(result);
                    if (result.length === 0) {
                        $('.eplSection').removeClass('d-none');
                        showSave();
                    } else {
                        var trackSubmitDate = new Date(result.created_at);
                        var submitDate = trackSubmitDate.toISOString().split('T')[0];
                        $('#getEPLCode').val(result.code);
                        $('#getRemark').val(result.remark);
                        $('#issue_date').val(result.issue_date_only);
                        $('#expire_date').val(result.expire_date_only);
                        $('#getcertifateNo').val(result.certificate_no);
                        $('#getPreRenew').val(result.count);
                        $('#getsubmitDate').val(result.submit_date_only);
                        $('#btnUpdate').val(result.id);
                        $('#btnshowDelete').val(result.id);
                        $('.lastCertificatePath').attr('src', '/' + result.path);
                        $('#addCertificateURL').attr('href', '/' + result.path);
                        if (result.path !== null && result.path.length > 0) {
                            $('.lastIssuedCer').removeClass('d-none');
                        }
                        showUpdate();
                        $('.eplSection').removeClass('d-none');
                    }
                });
            }
            //Site Clearance Section
            if (load_val === '02') {
                checkSiteClearExist(PROFILE, function (result) {
                    if (result.length === 0) {
                        $('.eplSection').removeClass('d-none');
                        showSave();
                    } else {
                        var trackIssueDate = new Date(result.site_clearances[0].issue_date);
                        var issueDate = trackIssueDate.toISOString().split('T')[0];
                        var trackExpireDate = new Date(result.site_clearances[0].expire_date);
                        var expireDate = trackExpireDate.toISOString().split('T')[0];
                        var trackSubmitDate = new Date(result.created_at);
                        var submitDate = trackSubmitDate.toISOString().split('T')[0];
                        $('#issue_date').val(issueDate);
                        $('#expire_date').val(expireDate);
                        $('#getsubmitDate').val(submitDate);
                        $('#getEPLCode').val(result.code);
                        $('#getRemark').val(result.remark);
                        $('#getPreRenew').val(result.count);
                        //Required
                        $('#btnUpdate').val(result.id);
                        $('#btnshowDelete').val(result.id);
                        showUpdate();
                        $('.eplSection').removeClass('d-none');
                    }
                });
                //Telecomminication Section   
            } else if (load_val === '03') {
                checkSiteClearExist(PROFILE, function (result) {
                    if (result.length === 0) {
                        $('.eplSection').removeClass('d-none');
                        showSave();
                    } else {
                        $('.txtCodeCn').html('Code*');
                        $('.showCertificateNo').addClass('d-none');
                        var trackIssueDate = new Date(result.site_clearances[0].issue_date);
                        var issueDate = trackIssueDate.toISOString().split('T')[0];
                        var trackExpireDate = new Date(result.site_clearances[0].expire_date);
                        var expireDate = trackExpireDate.toISOString().split('T')[0];
                        var trackSubmitDate = new Date(result.created_at);
                        var submitDate = trackSubmitDate.toISOString().split('T')[0];
                        $('#issue_date').val(issueDate);
                        $('#expire_date').val(expireDate);
                        $('#getsubmitDate').val(submitDate);
                        $('#getEPLCode').val(result.code);
                        $('#getRemark').val(result.remark);
                        $('#getPreRenew').val(result.count);
                        //Required
                        $('#btnUpdate').val(result.id);
                        $('#btnshowDelete').val(result.id);
                        showUpdate();
                        $('.eplSection').removeClass('d-none');
                    }
                });
            } else if (load_val === '04') {
                checkSiteClearExist(PROFILE, function (result) {
                    if (result.length === 0) {
                        $('.eplSection').removeClass('d-none');
                        showSave();
                    } else {
                        $('.txtCodeCn').html('Code*');
                        $('.showCertificateNo').addClass('d-none');
                        var trackIssueDate = new Date(result.site_clearances[0].issue_date);
                        var issueDate = trackIssueDate.toISOString().split('T')[0];
                        var trackExpireDate = new Date(result.site_clearances[0].expire_date);
                        var expireDate = trackExpireDate.toISOString().split('T')[0];
                        var trackSubmitDate = new Date(result.created_at);
                        var submitDate = trackSubmitDate.toISOString().split('T')[0];
                        $('#issue_date').val(issueDate);
                        $('#expire_date').val(expireDate);
                        $('#getsubmitDate').val(submitDate);
                        $('#getEPLCode').val(result.code);
                        $('#getRemark').val(result.remark);
                        $('#getPreRenew').val(result.count);
                        //Required
                        $('#btnUpdate').val(result.id);
                        $('#btnshowDelete').val(result.id);
                        showUpdate();
                        $('.eplSection').removeClass('d-none');
                    }
                });
            }
        });
        //Load Sections Button END
        $('#getIndustryType').on('change', function () {
            resetCurrentFormVals();
            $('.legitSection').addClass('d-none');
        });
        $('#issue_date').on('change', function () { //<--On change issue date configer expire date
            var issueDate = new Date($('#issue_date').val());
            var year = issueDate.getFullYear() + 1;
            var month = issueDate.getMonth() + 1;
            var date = issueDate.getDate();
            var expireDate = year + "-" + ('0' + month).slice(-2) + "-" + ('0' + date).slice(-2);
            console.log(expireDate);
            $('#expire_date').val(expireDate);
        });
//click update button
        $('#btnUpdate').click(function () {
            var load_val = $('#getIndustryType').val();
            //get form data
            var data = fromValues();
            delete data["file"];
            if (Validiteinsert(data)) {
                updateEPLOldFiles($(this).val(), data, load_val, function (result) {
                    show_mesege(result);
                    hideAllErrors();
                    resetinputFields();
                    $("#btnLoadAc").click();
                });
            }
        });
//click delete button
        $('#btnshowDelete').click(function () {
            var load_val = $('#getIndustryType').val();
            if (confirm("Are you sure you want to delete this?")) {
                deleteEPLOldFiles(PROFILE, load_val, function (result) {
                    show_mesege(result);
                    showSave();
                    hideAllErrors();
                    resetinputFields();
                    $("#btnLoadAc").click();
                });
            }
        });
//Remove Old Attachments
        $(document).on('click', '.removeAttachs', function () {
            if (confirm("Are you sure you want to delete this?")) {
                var getRemoveId = $(this).attr('id');
                deleteOldAttachments(getRemoveId, function (result) {
                    show_mesege(result);
                    regenCLientData(PROFILE);
                });
            }
        });
        getAsetClientData(PROFILE, function (result) {
            setProfileDetails(result);
            loadAllOldAttachments(result, function () {
            });
        });
        $('input[name="datepickerUi"]').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    });
    $('#btnAssignEnv').click(function () {
        let obj = {environment_officer_id: parseInt($("#env_officer_combo").val()), epl_id: PROFILE};
        assign_epl_to_officer(obj, function (respo) {
            if (respo.id == 1) {
                Toast.fire({
                    type: 'success',
                    title: 'Enviremontal MS</br>Saved!'
                });
            } else {
                Toast.fire({
                    type: 'error',
                    title: 'Enviremontal MS</br>Error'
                });
            }
        });
    });
    $(document).ready(function () {
        $('#btnUpload').click(function () {
            var file = $('#otherFiles')[0].files[0];
            uploadOldAttacments(PROFILE, 'file', file, function (result) {
                show_mesege(result);
                regenCLientData(PROFILE);
                resetinputFields();
                uploadButtonHandler($('#otherFiles').val());
            });
        });
        $('#otherFiles').bind('change', function () {
            uploadButtonHandler($('#otherFiles').val());
        });
    });
</script>
@endsection
