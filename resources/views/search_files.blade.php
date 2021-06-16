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
<style>
    .bs-example {
        font-family: sans-serif;
        position: relative;
        margin: 100px;
    }

    .typeahead,
    .tt-query,
    .tt-hint {
        border: 2px solid #CCCCCC;
        border-radius: 8px;
        font-size: 17px;
        /* Set input font size */
        height: 33px;
        line-height: 30px;
        outline: medium none;
        padding: 8px 12px;
    }

    .typeahead {
        background-color: #FFFFFF;
        display:block !important;
        width: 648px;
    }

    .typeahead:focus {
        border: 2px solid #0097CF;
    }

    .tt-query {
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    }

    .tt-hint {
        color: #999999;
    }

    .tt-menu {
        background-color: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        margin-top: 12px;
        padding: 8px 0;
        width: 562px;
    }

    .tt-suggestion {
        font-size: 20px;
        /* Set suggestion dropdown font size */
        padding: 3px 20px;
    }

    .tt-suggestion:hover {
        cursor: pointer;
        background-color: #0097CF;
        color: #FFFFFF;
    }

    .tt-suggestion p {
        margin: 0;
    }
</style>
@endsection
@section('content')
@if($pageAuth['is_read']==1 || false)
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Search Files</h1>

            </div>
        </div>
    </div>
</section>
<section class="content">
    <!--Search Client By NIC START-->
    <div class="container-fluid search-Client">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-9">
                    <div class="card card-gray">
                        <div class="card-header">
                            <h3 id="lblTitle" class="card-title">Search Client</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Enter*</label>
                                <select id="getDtaType"
                                        class="form-control form-control-sm select2 select2-purple col-sm-4"
                                        data-dropdown-css-class="select2-purple" style="width: 100%;" name="level">
                                    <option value="name">Client Name</option>
                                    <option value="id">Client NIC</option>
                                    <option value="license">License Number</option>
                                    <option value="epl">EPL Number</option>
                                    <option value="by_industry_name">Business Name</option>
                                    <option value="business_reg">Business Registration Number</option>
                                    <option value="by_address">Address</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div id="the-basics">
                                    <input id="getNic" type="text" minlength="10" maxlength="12" class="form-control form-control-sm col-12 typeahead"
                                           placeholder="Enter Here..." value="">
                                </div>
                                <div id="valName" class="d-none">
                                    <p class="text-danger">Name is required</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if($pageAuth['is_create']==1 || false)
                            <button id="btnSearch" type="submit" class="btn btn-success"><i class="fas fa-search"></i>
                                Search</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Search Client By NIC END-->
    <div class="view-Customer d-none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Customer Details

                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-active" id="tblCusData">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>NIC</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</section>
@endif
@endsection



@section('pageScripts')
<!-- Page script -->

<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script src="../../plugins/select2/js/select2.full.min.js"></script>
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
<script src="../../js/SearchFilesJS/search_files.js"></script>
<script src="../../js/epl/epl_register.js"></script>
<script src="../../js/SearchFilesJS/submit.js"></script>
<script src="../../js/SearchFilesJS/get.js"></script>
<script src="../../js/SearchFilesJS/viewClientData.js"></script>
<script src="../../js/SearchFilesJS/typeahead.bundle.js" type="text/javascript"></script>
<script>
                                        $(function () {
                                            BusinessScaleCombo();
                                            getClientSearchDetails('name', function (set) {
                                                localStorage.setItem('clientData', JSON.stringify(set));
                                                states.clear();
                                                states.local = JSON.parse(localStorage.getItem('clientData'));
                                                states.initialize(true);
                                            });
                                            //Search NIC Button 
                                            $(document).on('click', '#btnSearch', function () {

                                                var data2 = {
                                                    value: $('#getNic').val()
                                                };
                                                if (data2.value.length != 0 && data2.value != null) {
                                                    getClientbyNic($('#getDtaType').val(), data2, function (result) {
                                                        switch ($('#getDtaType').val()) {
                                                            case 'name':
                                                                if (result != 0) {
                                                                    showCustomerDetails(result);
                                                                    $('.view-Customer').removeClass('d-none');
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'id':
                                                                if (result != 0) {
                                                                    window.location = "/industry_profile/id/" + result.id;
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'license':
                                                                if (result != 0) {
                                                                    window.location = "/industry_profile/id/" + result.id;
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'epl':
                                                                if (!!result.deleted_at) {
                                                                    alert('Deleted Record!');
                                                                } else {
                                                                    if (result != 0) {
                                                                        window.location = "/industry_profile/id/" + result.id;
                                                                    } else {
                                                                        if (confirm(
                                                                                'Client Not Found!Do You Want Create New Client?')) {
                                                                            setSectionVisible('reg-newClient');
                                                                        } else {
                                                                            return false;
                                                                        }
                                                                    }
                                                                }
                                                                break;
                                                            case 'business_reg':
                                                                if (result != 0) {
                                                                    window.location = "/industry_profile/id/" + result.id;
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'by_address':
                                                                if (result != 0) {
                                                                    showCustomerDetails(result);
                                                                    $('.view-Customer').removeClass('d-none');
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            case 'by_industry_name':
                                                                if (result != 0) {
                                                                    showCustomerDetails(result);
                                                                    $('.view-Customer').removeClass('d-none');
                                                                } else {
                                                                    if (confirm('Client Not Found!Do You Want Create New Client?')) {
                                                                        setSectionVisible('reg-newClient');
                                                                    } else {
                                                                        return false;
                                                                    }
                                                                }
                                                                break;
                                                            default:
                                                                alert('Invalid Data');
                                                        }
                                                    });
                                                } else {
                                                    alert('Please Enter Client Information!');
                                                    $('#getNic').focus();
                                                }
                                                hideAllErrors();
                                            });

                                            $('#getNic').keyup(function (e) {
                                                if (e.which == 13) {
                                                    $("#btnSearch").click();
                                                }
                                            });
                                            $('#newEPL').click(function () {
                                                if (isNaN(parseInt($(this).val()))) {
                                                    return false;
                                                }
                                                window.location = "epl_register/id/" + $(this).val();
                                            });
                                            $('.resetAll').click(function () {
                                                setSectionVisible('');
                                            });
                                        });

//btnCustomerVa button action 
                                        $(document).on('click', '.btnCustomerVa', function () {
                                            var row = JSON.parse(decodeURIComponent($(this).data('row')));
                                            window.location = "/industry_profile/id/" + row.id;
                                        });

                                        $('#getfName,#getlName').on('change', function () {
                                            let frName = $('#getfName').val();
                                            let lName = $('#getlName').val();
                                            $('#business_name').val(frName + ' ' + lName);
                                        });
                                        $('#getContact,#getEmail').on('change', function () {
                                            if ($('#getisOld').val() == 0) {
                                                let setContact = $('#getContact').val();
                                                let setEmail = $('#getEmail').val();
                                                $('#getContactn').val(setContact);
                                                $('#getEmailI').val(setEmail);
                                            }
                                        });
</script>
<script>
    var clientData = JSON.parse(localStorage.getItem('clientData'));

    $(document).on('change', '#getDtaType', function () {
        $('.view-Customer').addClass('d-none');
        getClientSearchDetails($(this).val(), function (set) {
            localStorage.setItem('clientData', JSON.stringify(set));
            states.clear();
            states.local = JSON.parse(localStorage.getItem('clientData'));
            states.initialize(true);
        });
        $('#getNic').val('');
    });

    var states = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `states` is an array of state names defined in "The Basics"
        local: clientData
    });

    $('#the-basics .typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'myMatches',
        source: states
    });
</script>
@endsection