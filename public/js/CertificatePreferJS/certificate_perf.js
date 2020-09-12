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
var certificate_Status = {1: 'New EPL', 2: 'Renew EPL', 3: 'New Site Clearance', 4: 'Site Clearance'};
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
    $('#cer_status').html(certificate_Status[obj.cer_type_status]);
}


function setIndustryAndClientDb(get) {
    //Client
    $('.firstL_name').html(get.first_name + ' ' + get.last_name);
    $('.file_no').html(get.file_no);
    var or_assign_Date = new Date(get.assign_date);
    var con_assign_Date = or_assign_Date.toISOString().split('T')[0];
    $('.assign_date').html(con_assign_Date);
    $('.cl_address').html(get.address);
    $('.cl_email').html(get.email);
    $('.cl_contact_no').html(get.contact_no);
    $('.cl_nic').html(get.nic);
    //Industry
    $('.tabf_industry_name').html(get.industry_name);
    $('.tabf_industry_cat_name').html(get.industry_category.name);
    $('.tabf_business_scale').html(get.business_scale.name);
    $('.tabf_pradesheeyasaba').html(get.pradesheeyasaba.name);
    $('.tabf_industry_registration_no').html(get.industry_registration_no);
    $('.tabf_industry_start_date').html(get.industry_start_date);
    $('.tabf_industry_investment').html(get.industry_investment);
    $('.tabf_industry_address').html(get.industry_address);
    $('.tabf_industry_contact_no').html(get.industry_contact_no);
    $('.tabf_industry_email').html(get.industry_email);
    let env_officer = 'Not Assinged';
    if (!(get.environment_officer == null)) {
        env_officer = get.environment_officer.user.first_name + ' ' + get.environment_officer.user.last_name;
    }
    $('.tabf_environment_officer').html(env_officer);
}

function genCertificateNumbyId(file_id, callBack) {
    if (file_id.length == 0) {
        return false;
    }
    var url = "/api/start_drafting/id/" + file_id;
    ajaxRequest('POST', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}
function getCertificateDetails(file_id, callBack) {
    if (file_id.length == 0) {
        return false;
    }
    var url = "/api/working_certificate/file/" + file_id;
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}