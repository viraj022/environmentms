
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


function setClearanceData(obj) {
    if (obj.site_clearance_file == null) {
        $('#btnSaveClear').removeClass('d-none');
    } else {
        $('#siteclear_get').val(obj.site_clearance_file);

        $('#btnSaveClear').addClass('d-none');
        $('#btnUpdateClear').removeClass('d-none');
    }
}
