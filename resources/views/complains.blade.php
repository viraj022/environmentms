@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('pageStyles')
    <link href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="mt-5 col-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="card-title">Complains</div>
                        </div>
                        <div class="card-body">
                            <input type="text" id="hidden_id" value="" hidden>
                            <form enctype="multipart/form-data" id="complain_frm">
                                <div class="form-group">
                                    <label>Pradeshiya Sabha*</label>
                                    <select id="ps" class="form-control form-control-sm select2 select2-purple cutenzReq"></select>
                                </div>
                                <div class="form-group">
                                    <label>Complain Code*</label>
                                    <input id="complainer_code" name="complainer_code" type="text" maxlength="45"
                                        class="form-control form-control-sm cutenzReq" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Complainer Name*</label>
                                    <input id="complainer_name_ipt" name="complainer_name_ipt" type="text" maxlength="45"
                                        class="form-control form-control-sm cutenzReq"
                                        placeholder="Enter complainer name..." value="" required>
                                    <div id="comp_name_valid" class="d-none">
                                        <p class="text-danger">Container Name is required</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Complain Recieve Type</label>
                                    <select id="recieve_type_ipt" name="recieve_type_ipt"
                                        class="form-control form-control-sm">
                                        <option value="1">Call</option>
                                        <option value="2">Written</option>
                                        <option value="3">Verbal</option>
                                    </select>
                                    <div id="recieve_type_valid" class="d-none">
                                        <p class="text-danger">Recieve type required</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Complainer Address*</label>
                                    <input id="complainer_address_ipt" name="complainer_address_ipt" type="text"
                                        maxlength="45" class="form-control form-control-sm cutenzReq"
                                        placeholder="Enter complainer address..." value="" required>
                                    <div id="comp_address_valid" class="d-none">
                                        <p class="text-danger">Container Address is required</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Complainer Contact Number*</label>
                                    <input id="contact_complainer_ipt" name="contact_complainer_ipt"
                                        onKeyDown="if (this.value.length == 10 && event.keyCode != 8)
                                                                                                                    return false;" type="number" class="form-control form-control-sm" 
                                        placeholder="Enter Contact Number of complainer..." value="" required>
                                    <div id="contact_complainer_valid" class="d-none">
                                        <p class="text-danger">Complainer Contact Number is required</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Complain Description*</label>
                                    <textarea id="complain_desc_ipt" name="complain_desc_ipt"
                                        class="form-control form-control-sm" placeholder="Enter complain Description..."
                                        value="" required></textarea>
                                    <div id="complain_desc_valid" class="d-none">
                                        <p class="text-danger">Complain description required</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Attachment: </label>
                                    <input type="file" id="complain_attach" name="complain_attach"
                                        accept=".png, .jpg, .jpeg" multiple>
                                    <div id="complain_attach_valid" class="d-none">
                                        <p class="text-danger">Complain attachment required</p>
                                    </div>
                                    <span id="attachment_view"></span>
                                </div>
                                <div class="row mt-5">
                                    <div class="form-group col-12">
                                        <button type="button" class="btn btn-lg btn-success" id="save">Save</button>
                                        <button type="button" class="btn btn-lg btn-warning d-none"
                                            id="update">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class=" mt-5 col-md-9">
                    <div class="card card-primary">
                        <div class="card-header"> Complain Table </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered" id="complain_tbl">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Contact Number</th>
                                        <!-- <th>Description</th> -->
                                        <th>Created User</th>
                                        <th>Assigned User</th>
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
        </div>
    </section>
@endsection

@section('pageScripts')
    <script src="../../dist/js/adminlte.min.js"></script>

    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/complains/complains.js') }}"></script>
    <script src="../../plugins/select2/js/select2.full.min.js"></script>
    <script src="../../dist/js/adminlte.min.js"></script>

    <!-- Page script -->
    <script>
        $(document).ready(function() {
            loadPradeshiyaSabha(function() {
                gen_complain_code();
            });
            load_complains();
        });

        $('#ps').change(function() {
                gen_complain_code();
        });

        $('#complain_attach').change(function() {
            let index = 0;
            let html = "";
            $.each($('#complain_attach')[0].files, function(key, val) {
                html += "<img src='" + window.URL.createObjectURL(val) + "' width='100em' height='100em'/>";
            });
            $('#attachment_view').html(html);
        });

        $('#save').click(function() {
            let is_valid = jQuery("#complain_frm").valid();
            if (is_valid) {
                save_complain();
            } else {
                swal.fire('failed', 'Required fields must fill', 'warning');
            }

        });

        $('#update').click(function() {
            let is_valid = jQuery("#complain_frm").valid();
            if (is_valid) {
                update_complain();
            } else {
                swal.fire('failed', 'Required fields must fill', 'warning');
            }
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).val();
            let url = '/api/complain_profile_data/id/' + id;
            ajaxRequest('GET', url, null, function(resp) {
                $('#complainer_code').val(resp.complainer_code);
                $('#complainer_name_ipt').val(resp.complainer_name);
                $('#complainer_address_ipt').val(resp.complainer_address);
                $('#contact_complainer_ipt').val(resp.comp_contact_no);
                $('#complain_desc_ipt').val(resp.complain_des);
                $('#recieve_type_ipt').val(resp.recieve_type);
                $('#hidden_id').val(resp.id);
                $('#ps').val(resp.pradeshiya_saba_id);
                $('#ps').change();
                $('.select2').select2();
            });

            $('#save').addClass('d-none');
            $('#update').removeClass('d-none');
        });

        $(document).on('click', '.btn-del', function() {

            let id = $(this).val();

            Swal.fire({
                title: 'Do you want to delete complain?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'confirm',
                denyButtonText: `Don't confirm`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.value) {
                    delete_complain(id);
                } else if (result.isDenied) {
                    Swal.fire('Canceled!', 'Confirmation was cancelled', 'info')
                }
            })
        });

        var complain_form;
        complain_form = $("#complain_frm").validate({
            errorClass: "invalid",
            rules: {
                contact_complainer_ipt: {
                    valid_lk_phone: true,
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        jQuery.validator.setDefaults({
            errorElement: "span",
            ignore: ":hidden:not(select.chosen-select)",
            errorPlacement: function(error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    //                error.insertAfter(element.parent("label"));
                    error.appendTo(element.parents("validate-parent"));
                } else if (element.is("select.chosen-select")) {
                    error.insertAfter(element.siblings(".chosen-container"));
                } else if (element.prop("type") === "radio") {
                    error.appendTo(element.parents("div.validate-parent"));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                jQuery(element).parents(".validate-parent").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                jQuery(element).parents(".validate-parent").removeClass("has-error");
            }
        });
        jQuery.validator.addMethod("valide_code", function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s\d\_\-()]{1,100}$/.test(value);
        }, "Please enter a valid Code");
        jQuery.validator.addMethod("valid_name", function(value, element) {
            return this.optional(element) || /^[a-zA-Z\s\.\&\-()]*$/.test(value);
        }, "Please enter a valid name");
        jQuery.validator.addMethod("valid_date", function(value, element) {
            return this.optional(element) || /^\d{4}\-\d{2}\-\d{2}$/.test(value);
        }, "Please enter a valid date ex. 2017-03-27");
        jQuery.validator.addMethod("valide_email", function(value, element) {
            return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/.test(value);
        }, "Please enter a valid email addresss");
        jQuery.validator.addMethod("valid_lk_phone", function(value, element) {
            return this.optional(element) || /^0[7][0-9]{8}$/.test(value);
        }, "Please enter a valid phone number");
        jQuery.validator.addMethod("valid_lk_nic", function(value, element) {
            return this.optional(element) || /^([0-9]{9}[x|X|v|V]|[0-9]{12})$/.test(value);
        }, "Please enter a valid NIC number");
    </script>
@endsection