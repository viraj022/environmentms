function AddClient(data, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/client",
        data: data,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}

function requiredFieldHandler(frm_data,required_class) {
    var response = true;
    if (frm_data.is_old.length == 0) {
        toastr.error('Is Old Required!');
        response = false;
    }
    if (frm_data.first_name.length == 0) {
        toastr.error('First Name Required!');
        response = false;
    }
    if (frm_data.industry_registration_no.length == 0) {
        toastr.error('Business Registation Number Required!');
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
    if (frm_data.industry_created_date.length == 0) {
        toastr.error('Submitted Required!');
        response = false;
    }
    $(required_class).each(function () {
        if ($(this).val().length === 0) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
    });
    return response;
}