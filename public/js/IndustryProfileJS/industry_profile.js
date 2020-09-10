let PROFILE_ID = '';
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

    if (obj.environment_officer != null) {
        $('#env_firstname').html("Environment Officer: " + obj.environment_officer.user.first_name + " " + obj.environment_officer.user.last_name);
    } else if (obj.first_name == null) {
        $("#disPaylink").attr("href", "javascript:disWarnPay();");
        $("#disInspeclink").attr("href", "javascript:disWarnPay();");
    }
}

function checkEPLstatus(epls) {
    if (epls.length === 0) {
        $('.newEPL').addClass('bg-info');
        $('.newEPL').removeClass('bg-success');
    } else {
        return false;
    }
}

function setIndustryAndClientDb(get) {
    //Client
    $('.firstL_name').html(get.first_name + ' ' + get.last_name);
    $('.file_no').html(get.file_no);
    $('.assign_date').html(get.assign_date);
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

function loadAllEPLTable(dataSet, callBack) {
    //EPLS as dataSet
    var tbl = "";
    var i = 0;
    if (dataSet.length == 0) {
        tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
    } else {
        $.each(dataSet, function (index, row) {
            tbl += '<tr>';
            tbl += '<td>' + ++index + '</td>';
            tbl += '<td><a type="button" href="/epl_profile/client/' + PROFILE_ID + '/profile/' + row.id + '" class="btn btn-primary">' + row.code + '</a></td>';
            tbl += '<td>' + row.certificate_no + '</td>';
            tbl += '<td>' + row.issue_date + '</td>';
            tbl += '<td>' + row.expire_date + '</td>';
            tbl += '</tr>';
        });
    }
    $('#clientEplList tbody').html(tbl);
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack(dataSet);
    }
}

function setupInspectionUI(need_inspection_status) {
    if (need_inspection_status === null || need_inspection_status === 'Completed') {
        $('.setupInspectStatus').html('NEW');
        $('.setInspectUI').removeClass('d-none');
        $('.noNeedInspect').removeClass('d-none');

    } else if (need_inspection_status === 'Inspection Needed') {

        $('.setupInspectStatus').html('Inspection Needed');
        $('.noNeedInspect').removeClass('d-none');

    } else if (need_inspection_status === 'Inspection Not Needed') {

        $('.setupInspectStatus').html('Inspection Not Needed');
        $('.setInspectUI').removeClass('d-none');

    } else if (need_inspection_status === 'Completed') {

        $('.setupInspectStatus').html('Completed');
        $('.setInspectUI').removeClass('d-none');

    }
}

function getAllInspectionAPI(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/inspections/file/id/" + id;
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function loadAllSiteInspectionTable(id) {
    getAllInspectionAPI(id, function (result) {
        var tbl = "";
        var id = 1;
        if (result.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(result, function (index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                if (row.status == 0) {
                    tbl += '<td>Processing</td>';
                } else {
                    tbl += '<td>Completed (' + row.completed_at + ')</td>';
                }
                tbl += '<td>' + row.schedule_date_only + '</td>';
                tbl += '<td><a type="button" href="/inspection/epl/remarks/id/' + row.id + '" class="btn btn-primary"> View </a></td>';
                tbl += '</tr>';
            });
        }
        $('#tblAllInspections tbody').html(tbl);
    });
}

//Check Inspection Need Or Not
function checkInspectionStatus(id, btn_val, callBack) {
    if (isNaN(id)) {
        id = 0;
    }
    ajaxRequest('PATCH', "/api/inspection/" + btn_val + "/file/" + id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

//Report File Issue
function reportFileIssueAPI(id, data, callBack) {
    if (isNaN(id)) {
        id = 0;
    }
    ajaxRequest('POST', "/api/files/file_problem_status/id/" + id, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

//Remove Client File API
function removeClientFileAPI(id, callBack) {
    if (isNaN(id)) {
        id = 0;
    }
    ajaxRequest('DELETE', "/api/client/id/" + id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

//Remove EPL Payment API
function removeEPLPaymentAPI(id, callBack) {
    if (isNaN(id)) {
        id = 0;
    }
    ajaxRequest('DELETE', "/api/epl/regPayment/id/" + id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

//Pending Payments API
function pendingPaymentsAPI(id, callBack) {
    ajaxRequest('GET', "/api/payment/history/file/" + id, null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
//Pending Payment Table
function pendingPaymentsTable(id) {
    pendingPaymentsAPI(id, function (result) {
        var tbl = "";
        var id = 1;
        if (result.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(result, function (index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                if (row.cashier_name !== null) {
                    tbl += '<td>' + row.cashier_name + '</td>';
                } else {
                    tbl += '<td>N/A</td>';
                }
                if (row.invoice_no !== null) {
                    tbl += '<td>' + row.invoice_no + '</td>';
                } else {
                    tbl += '<td>N/A</td>';
                }
                if (row.status == 0) {
                    tbl += '<td>Pending Payment</td>';
                } else if (row.status == 1) {
                    tbl += '<td>Paid</td>';
                } else {
                    tbl += '<td>Payment Cancelled</td>';
                }
                tbl += '<td>'+ row.net_total +'</td>';
                if (row.status == 0) {
                    tbl += '<td><button type="button" data-name="'+ row.name +'" value="'+ row.id +'" class="btn btn-primary printBarcode"> Print BarCode </button> <button type="button" value="'+ row.id +'" class="btn btn-danger removeBarcode"> Remove </button></td>';
                }
                tbl += '</tr>';
            });
        }
        $('#tblAllPayments tbody').html(tbl);
    });
}

function checkFileIssueStatus(is_exist) {
    if (is_exist.file_problem_status === 'problem') {
        $('.markIssueClean').removeClass('d-none'); //<-- Show Issue Cleared
        $('.showReportInfoUi').removeClass('d-none');
        $('.reportIssueView').addClass('d-none'); //<-- Hide report issue
        $('.reportInfo').html(is_exist.file_problem_status_description);
    } else {
        $('.markIssueClean').addClass('d-none'); //<-- Hide Issue Cleared
        $('.showReportInfoUi').addClass('d-none');
    }
}