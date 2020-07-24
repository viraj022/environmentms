
function setClientDetails(obj) {
//    $('#newEPL').val(obj.id);
    $('#client_name').html(obj.first_name + ' ' + obj.last_name);
    $('#client_address').html(obj.address);
    $('#client_cont').html(obj.contact_no);
    $('#client_amil').html(obj.email);
    $('#client_nic').html(obj.nic);
}
function setAllDetails(obj) {
    console.log(obj);
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

    $('#obj_name').html(obj.name);
    $('#obj_regno').html(obj.registration_no);
    $('#obj_code').html(obj.code);
    $('#obj_invest').html(obj.investment);
    $('#obj_remark').html(obj.remark);
//    _Latitude = obj.coordinate_x;
//    _Longitude = obj.coordinate_y;
    if (obj.first_name != null) {
        $('#env_firstname').html("Assign Environment Officer: " + obj.first_name + " " + obj.last_name);
    } else if (obj.first_name == null) {
        $("#disPaylink").attr("href", "javascript:disWarnPay();");
        $("#disInspeclink").attr("href", "javascript:disWarnPay();");
    }
}
function downloadApp(obj) {
    window.open("/" + obj.application_path, '_blank');
}
function downloadFile1(obj) {
    window.open("/" + obj.file_01, '_blank');
}
function downloadFile2(obj) {
    window.open("/" + obj.file_02, '_blank');
}
function downloadFile3(obj) {
    window.open("/" + obj.file_03, '_blank');
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
