function loadPradeshiyaSabha(callBack) {
    var cbo = "";
    ajaxRequest('GET', "/api/pradesheeyasabas",null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option data-ps_code="'+ row.code +'" value="' + row.id + '">' + row.code + ' - ' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#prsdeshiySb').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function IndustryCategoryCombo(callBack) {
    var cbo = "";
    ajaxRequest('GET', "/api/industrycategories",null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option data-cat_code="'+row.code +'" value="' + row.id + '">' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#industryCat').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function BusinessScaleCombo(callBack) {
    var cbo = "";
    ajaxRequest('GET', "/api/business_scale",null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option data-bc_code="'+row.code +'" value="' + row.id + '">' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#businesScale').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}

//Update Client File
function updateClientFileAPI(id, data, callBack) {
    if (isNaN(id)) {
        id = 0;
    }
    var url = "/api/client/id/" + id;
    ajaxRequest('PUT', url, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

//Required Field
function requiredFieldHandler(frm_data, required_class) {
    var response = true;
//    if (frm_data.is_old.length == 0) {
//        toastr.error('Is Old Required!');
//        response = false;
//    }
    if (frm_data.first_name.length == 0) {
        toastr.error('First Name Required!');
        response = false;
    }
    if (frm_data.industry_name.length == 0) {
        toastr.error('Business Name Required!');
        response = false;
    }
    if (frm_data.industry_investment.length == 0) {
        toastr.error('Investment Required!');
        response = false;
    }
    if (frm_data.industry_address.length == 0) {
        toastr.error('Address Required!');
        response = false;
    }
    if (frm_data.industry_start_date.length == 0) {
        toastr.error('Start Date Required!');
        response = false;
    }
//    if (frm_data.assign_date.length == 0) {
//        toastr.error('Submitted Required!');
//        response = false;
//    }
    $(required_class).each(function () {
        if ($(this).val().length === 0) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });
    return response;
}

//Get client By Id details
function getaClientbyId(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/client/id/" + id;
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}