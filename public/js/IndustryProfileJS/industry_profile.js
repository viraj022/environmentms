function getaProfilebyId(id, callBack) {
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

function setProfileDetails(obj) {
    //    $('#newEPL').val(obj.id);
    $('#client_name').html(obj.first_name + ' ' + obj.last_name);
    $('#client_address').html(obj.address);
    $('#client_cont').html(obj.contact_no);
    $('#client_amil').html(obj.email);
    $('#client_nic').html(obj.nic);
    $('#obj_name').html(obj.industry_name);
    $('#obj_regno').html(obj.industry_registration_no);
    $('#obj_invest').html(obj.industry_investment);
    initMap(parseFloat(obj.industry_coordinate_x), parseFloat(obj.industry_coordinate_y));
    documentUploadDetails(obj);
}

// Initialize and add the map
function initMap(_Latitude, _Longitude) {
    // The location of CeyTech
    var defaultLocation = {lat: _Latitude, lng: _Longitude}; //default Location for load map

    // The map, centered at Uluru
    var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: defaultLocation});
    // The marker, positioned at Uluru
    var marker = new google.maps.Marker({position: defaultLocation, map: map, draggable: false, title: "Drag me!"});
}

function documentUploadDetails(obj) {
    $('#fileUpDiv').addClass('d-none');
    $('.navTodownload').addClass('d-none');
    $('#upld_roadMap').addClass('d-none');
    $('.navToFile1').addClass('d-none');
    $('#upld_deed').addClass('d-none');
    $('.navToFile2').addClass('d-none');
    $('#upld_SurveyPlan').addClass('d-none');
    $('.navToFile3').addClass('d-none');

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
        $('#env_firstname').html("Environment Officer: " + obj.first_name + " " + obj.last_name);
    } else if (obj.first_name == null) {
        $("#disPaylink").attr("href", "javascript:disWarnPay();");
        $("#disInspeclink").attr("href", "javascript:disWarnPay();");
    }
}