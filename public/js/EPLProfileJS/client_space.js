
function setClientDetails(obj) {
    //    $('#newEPL').val(obj.id);
    $('#client_name').html(obj.first_name + ' ' + obj.last_name);
    $('#client_address').html(obj.address);
    $('#client_cont').html(obj.contact_no);
    $('#client_amil').html(obj.email);
    $('#client_nic').html(obj.nic);
    $('#obj_name').html(obj.industry_name);
    $('#obj_regno').html(obj.industry_registration_no);
    $('#obj_invest').html(obj.industry_investment);
    _Latitude = obj.industry_coordinate_x;
    _Longitude = obj.industry_coordinate_y;
}
function setAllDetails(obj) {
    $('#fileUpDiv').addClass('d-none');
    $('#upld_application').addClass('d-none');
    $('.navTodownload').addClass('d-none');
    $('#upld_roadMap').addClass('d-none');
    $('.navToFile1').addClass('d-none');
    $('#upld_deed').addClass('d-none');
    $('.navToFile2').addClass('d-none');
    $('#upld_SurveyPlan').addClass('d-none');
    $('.navToFile3').addClass('d-none');
    //application check 
    if (obj.application_path == null || obj.application_path == '') {
        $('#upld_application').removeClass('d-none');
    } else {
        $('.navTodownload').removeClass('d-none');
    }

    //road map
    if (obj.file_01 == null || obj.file_01 == '') {
        $('#upld_roadMap').removeClass('d-none');
    } else {
        $('.navToFile1').removeClass('d-none');
    }

    //deed
    if (obj.file_02 == null || obj.file_02 == '') {
        $('#upld_deed').removeClass('d-none');


    } else {
        $('.navToFile2').removeClass('d-none');
    }

    //survey plan
    if (obj.file_03 == null || obj.file_03 == '') {
        $('#upld_SurveyPlan').removeClass('d-none');
    } else {
        $('.navToFile3').removeClass('d-none');
    }
    $('#obj_code').html(obj.code);
    $('#obj_remark').html(obj.remark);
    $('.navTodownload').attr("href", obj.application_path);
    $('.navToFile1').attr("href", "/" + obj.file_01);
    $('.navToFile2').attr("href", "/" + obj.file_02);
    $('.navToFile3').attr("href", "/" + obj.file_03);
    if (obj.first_name != null) {
        $('#env_firstname').html("Assign Environment Officer: " + obj.first_name + " " + obj.last_name);
    } else if (obj.first_name == null) {
        $("#disPaylink").attr("href", "javascript:disWarnPay();");
        $("#disInspeclink").attr("href", "javascript:disWarnPay();");
    }
}

function setClearanceData(obj) {
    if (obj.site_clearance_file == null) {
        $('#btnSaveClear').removeClass('d-none');
    } else {
        $('#siteclear_get').val(obj.site_clearance_file);

        $('#btnSaveClear').addClass('d-none');
        $('#btnUpdateClear').removeClass('d-none');
    }
}
