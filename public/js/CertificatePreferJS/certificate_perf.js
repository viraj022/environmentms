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
    if (obj.epls.length == 0) {
        $('.newEPL').removeClass('d-none');
    } else {
        $('.viewEPL').removeClass('d-none');
        $('.newEPL').addClass('d-none');
        $('#setEPLCode').html(obj.epls[obj.epls.length - 1].code);
        $("#setEPlLink").attr("href", "/epl_profile/client/" + PROFILE_ID + "/profile/" + obj.epls[obj.epls.length - 1].id);
    }
    (obj.last_name == null) ? $('#client_name').html(obj.first_name) : $('#client_name').html(obj.first_name + ' ' + obj.last_name);
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
