
function setClientDetails(obj) {
//    $('#newEPL').val(obj.id);
    $('#client_name').html(obj.first_name + ' ' + obj.last_name);
    $('#client_address').html(obj.address);
    $('#client_cont').html(obj.contact_no);
    $('#client_amil').html(obj.email);
    $('#client_nic').html(obj.nic);
}
function setAllDetails(obj) {
//    $('#newEPL').val(obj.id);
    $('#obj_name').html(obj.name);
    $('#obj_regno').html(obj.registration_no);
    $('#obj_code').html(obj.code);
    $('#obj_invest').html(obj.investment);
    $('#obj_remark').html(obj.remark);
//    _Latitude = obj.coordinate_x;
//    _Longitude = obj.coordinate_y;
}
function downloadApp(obj) {
window.location.href = "/"+obj.application_path;
}
