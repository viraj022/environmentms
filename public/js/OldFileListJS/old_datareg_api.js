//API Functions
function checkEPLExist(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/old/industry/" + id;
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}
function getAsetClientData(id, callBack) {
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

function saveEPLOldFiles(profile_id, data, type, callBack) {
    let url = "";
    if (!data || data.length == 0) {
        return false;
    }
    if (type == 01) {
        url = "/api/epl/old/industry/" + profile_id;
    } else {
        url = "/api/site_clearance/old/file/" + profile_id;
    }
    submitDataWithFile(url, data, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}
function updateEPLOldFiles(epl_id, data, type, callBack) {
    let url = "";
    if (!data || data.length == 0) {
        return false;
    }
    if (type == 01) {
        url = "/api/epl/old/epl/" + epl_id;
    } else {
        url = "/api/site_clearance/old/site_clearance_session/" + epl_id;
    }
    submitDataWithFile(url, data, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

function uploadOldAttacments(client_id, key, value, callBack) {
    let formData = new FormData();
    formData.append(key, value);
    formData.append('file_catagory', 'OLD FILE');
    ulploadFile2("/api/old/attachments/" + client_id, formData, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

function deleteEPLOldFiles(id, type, callBack) {
    let url = '';
    if (type == 01) {
        url = '/api/epl/old/epl/' + id;
    } else {
        url = "/api/site_clearance/old/site_clearance_session/" + id;
    }

    ajaxRequest('DELETE', url, null, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}
//----Remove Old Attachments---
function deleteOldAttachments(id, callBack) {
    let url = '/api/old/attachments/' + id;
    ajaxRequest('DELETE', url, null, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

//API Functions END


//Validate Data
function Validiteinsert(data) {
    var response = true;
    if (data.epl_code.length == 0) {
        $('#valEPL').removeClass('d-none');
        response = false;
    }
//    if (data.remark.length == 0) {
//        $('#valRemark').removeClass('d-none');
//        response = false;
//    }
    return response;
}
//END OF VALIDATE DATA

//GET EPL FORM Data
function fromValues() {
    let applicationType = parseInt($('#getIndustryType').val());
    var data = {
        epl_code: $('#getEPLCode').val(),
        remark: $('#getRemark').val(),
        issue_date: $('#issue_date').val(),
        expire_date: $('#expire_date').val(),
        count: $('#getPreRenew').val(),
        submit_date: $('#getsubmitDate').val(),
        file: $('#last_certificate')[0].files[0]
    };
    switch (applicationType) {
        case 01:
            data.certificate_no = $('#getcertifateNo').val();
            break;
        case 02:
            data.code = $('#getEPLCode').val();
            data.type = 'Site Clearance';
            break;
        case 03:
            data.code = $('#getEPLCode').val();
            data.type = 'Telecommunication';
            break;
        case 04:
            data.code = $('#getEPLCode').val();
            data.type = 'Schedule Waste';
            break;

        default:
            break;
    }
    return data;
}

function setProfileDetails(obj) {
    if (obj.last_name === null) {
        $('#client_name').html(obj.first_name);
    } else {
        $('#client_name').html(obj.first_name + ' ' + obj.last_name);
    }
    $('#client_address').html(obj.address);
    $('#client_cont').html(obj.contact_no);
    $('#client_amil').html(obj.email);
    $('#client_nic').html(obj.nic);
    $('#obj_name').html(obj.industry_name);
    $('#obj_regno').html(obj.industry_registration_no);
    $('#obj_invest').html(obj.industry_investment);
    if (obj.environment_officer != null) {
        $('#btnAssignEnv').html("Change");
        $('#btnAssignEnv').addClass("btn-warning");
        $('#btnAssignEnv').removeClass("btn-success");
        $('.assignedOfficer').html("Current Environment Officer: " + obj.environment_officer.user.first_name + " " + obj.environment_officer.user.last_name);
    }
}

function checkSiteClearExist(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/old/site_clearance/industry/" + id;
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function resetCurrentFormVals() {
    $('#getEPLCode').val('');
    $('#getRemark').val('');
    $('#issue_date').val('');
    $('#expire_date').val('');
    $('#getcertifateNo').val('');
    $('#getPreRenew').val('');
    $('#getsubmitDate').val('');
    $('#btnUpdate').val('');
    $('#btnshowDelete').val('');
    $('#btnUpdate').addClass('d-none');
    $('#btnshowDelete').addClass('d-none');
}

//Check if Industry Type NOT EPL
function sectionIfSiteClears(industry_type) {
    if (industry_type !== '01') {
        $('.txtCodeCn').html('Code*');
        $('.showCertificateNo').addClass('d-none');

        var option = '';
        for (var i = 0; i < 51; i++) { //Loop Combo Box Values For EPL
            option += '<option value="' + i + '">' + i + '</option>';
        }
        $('#getPreRenew').html(option);
    } else {
        $('.txtCodeCn').html('EPL Code*');
        $('.showCertificateNo').removeClass('d-none');

        for (var i = 0; i < 51; i++) { //Loop Combo Box Values For Other
            option += '<option value="' + i + '">R ' + i + '</option>';
        }
        $('#getPreRenew').html(option);
    }

}