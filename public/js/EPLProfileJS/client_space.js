
function setClientDetails(obj) {
//    $('#newEPL').val(obj.id);
    $('#client_name').html(obj.first_name + ' ' + obj.last_name);
    $('#client_address').html(obj.address);
    $('#client_cont').html(obj.contact_no);
    $('#client_amil').html(obj.email);
    $('#client_nic').html(obj.nic);
}
function setAllDetails(obj) {
    $('#obj_name').html(obj.name);
    $('#obj_regno').html(obj.registration_no);
    $('#obj_code').html(obj.code);
    $('#obj_invest').html(obj.investment);
    $('#obj_remark').html(obj.remark);
//    _Latitude = obj.coordinate_x;
//    _Longitude = obj.coordinate_y;
    if (obj.first_name.length != 0) {
        $('#env_firstname').html("Assign Environment Officer: " + obj.first_name + " " + obj.last_name);
    }
}
function downloadApp(obj) {
    window.location.href = "/" + obj.application_path;
}

function setClearanceData(obj) {
    if (obj.site_clearance_file.length == 0) {
        $('#btnSaveClear').removeClass('d-none');
    } else {
        $('#siteclear_get').val(obj.site_clearance_file);
        $('#btnSaveClear').addClass('d-none');
        $('#btnUpdateClear').removeClass('d-none');
    }
}
