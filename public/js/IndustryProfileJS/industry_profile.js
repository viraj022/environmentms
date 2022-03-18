var cer_status = { 0: 'Pending', 1: 'Drafting', 2: 'Drafted', 3: 'AD Approval Pending', 4: 'Director Approval pending', 5: 'Director Approved', 6: 'Certificate Issued', '-1': 'Certificate Director Holded' };
var file_status_list = { 0: 'Pending', 1: 'AD File Approval Pending', 2: 'Certificate Preparation', 3: 'AD Certificate Prenidng Approval', 4: 'D Certificate Approval Prenidng', 5: 'Complete', 6: 'Issued', '-1': 'Rejected', '-2': 'Hold' };
let PROFILE_ID = "";

function getaProfilebyId(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/client/id/" + id;
    ajaxRequest("GET", url, null, function(result) {
        if (
            typeof callBack !== "undefined" &&
            callBack !== null &&
            typeof callBack === "function"
        ) {
            callBack(result);
        }
    });
}

function setProfileDetails(obj) {
    //    console.log(obj);
    //    $('#newEPL').val(obj.id);
    if (obj.epls.length == 0) {
        $(".newEPL").removeClass("d-none");
    } else {
        $(".viewEPL").removeClass("d-none");
        $(".newEPL").addClass("d-none");
        $("#setEPLCode").html(obj.epls[obj.epls.length - 1].code);
        //        if (obj.site_clearence_sessions.length == 0) {
        //            $("#setSiteCleanceCode").html(obj.site_clearence_sessions[0].code);
        //        }
        if (obj.epls.length != 0) {
            $("#setEPlLink").attr(
                "href",
                "/epl_profile/client/" +
                PROFILE_ID +
                "/profile/" +
                obj.epls[obj.epls.length - 1].id
            );
        }
    }
    //Check site clearance
    if (obj.site_clearence_sessions.length == 0) {
        $(".newSiteClear").removeClass("d-none");
    } else {
        $(".setSiteClear").removeClass("d-none");
        $("#setSiteCleanceCode").html(obj.site_clearence_sessions[0].code);
        console.log(obj.site_clearence_sessions[0].code);
        if (obj.site_clearence_sessions.length != 0) {
            $("#setSiteClear").attr("href", "/site_clearance/client/" + PROFILE_ID + "/profile/" + obj.site_clearence_sessions[obj.site_clearence_sessions.length - 1].id);
        }

    }
    obj.last_name == null ?
        $("#client_name").html(obj.first_name) :
        $("#client_name").html(obj.first_name + " " + obj.last_name);
    (obj.address != null) ? $("#client_address").html(obj.address): $("#client_address").html('--');
    (obj.contact_no != null) ? $("#client_cont").html(obj.contact_no): $("#client_cont").html('--');
    (obj.email != null) ? $("#client_amil").html(obj.email): $("#client_amil").html('--');
    $("#client_nic").html(obj.nic);
    $("#obj_name").html(obj.industry_name);
    (obj.industry_registration_no != null) ? $("#obj_regno").html(obj.industry_registration_no): $("#obj_regno").html('--');
    let invest = format(obj.industry_investment);
    $("#obj_invest").html(invest);
    (obj.industry_address != null) ? $("#obj_industrySub").html(obj.industry_address): $("#obj_industrySub").html('-');
    initMap(
        parseFloat(obj.industry_coordinate_x),
        parseFloat(obj.industry_coordinate_y)
    );
    documentUploadDetails(obj);
}

// Initialize and add the map
function initMap(_Latitude, _Longitude) {
    // The location of CeyTech
    var defaultLocation = { lat: _Latitude, lng: _Longitude }; //default Location for load map

    // The map, centered at Uluru
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: defaultLocation,
    });
    // The marker, positioned at Uluru
    var marker = new google.maps.Marker({
        position: defaultLocation,
        map: map,
        draggable: false,
        title: "Drag me!",
    });
}

function documentUploadDetails(obj) {
    $("#fileUpDiv").addClass("d-none");
    $(".navTodownload").addClass("d-none");
    $("#upld_roadMap").addClass("d-none");
    $(".navToFile1").addClass("d-none");
    $("#upld_deed").addClass("d-none");
    $(".navToFile2").addClass("d-none");
    $("#upld_SurveyPlan").addClass("d-none");
    $(".navToFile3").addClass("d-none");

    //road map
    if (obj.file_01 == null || obj.file_01 == "") {
        $("#upld_roadMap").removeClass("d-none");
    } else {
        $(".navToFile1").removeClass("d-none");
    }

    //deed
    if (obj.file_02 == null || obj.file_02 == "") {
        $("#upld_deed").removeClass("d-none");
    } else {
        $(".navToFile2").removeClass("d-none");
    }

    //survey plan
    if (obj.file_03 == null || obj.file_03 == "") {
        $("#upld_SurveyPlan").removeClass("d-none");
    } else {
        $(".navToFile3").removeClass("d-none");
    }
    $("#obj_code").html(obj.code);
    $("#obj_remark").html(obj.remark);
    $(".navTodownload").attr("href", obj.application_path);
    $(".navToFile1").attr("href", "/" + obj.file_01);
    $(".navToFile2").attr("href", "/" + obj.file_02);
    $(".navToFile3").attr("href", "/" + obj.file_03);

    if (obj.environment_officer != null) {
        if (obj.environment_officer.user != null) {
            $("#env_firstname").html(
                "Environment Officer: " +
                obj.environment_officer.user.first_name +
                " " +
                obj.environment_officer.user.last_name
            );
        }
    } else if (obj.first_name == null) {
        $("#disPaylink").attr("href", "javascript:disWarnPay();");
        $("#disInspeclink").attr("href", "javascript:disWarnPay();");
    }
}

function checkEPLstatus(epls) {
    if (epls.length === 0) {
        $(".newEPL").addClass("bg-info");
        $(".newEPL").removeClass("bg-success");
    } else {
        return false;
    }
}

function setIndustryAndClientDb(get) {
    //Client
    $(".firstL_name").html(get.first_name + " " + get.last_name);
    $(".file_no").html(get.file_no);
    var or_assign_Date = new Date(get.industry_start_date);
    //    alert(get.industry_start_date); <--someone changed tbl col name
    var con_assign_Date = or_assign_Date.toISOString().split("T")[0];
    $(".assign_date").html(con_assign_Date);
    (get.address != null) ? $(".cl_address").html(get.address): $(".cl_address").html('--');
    (get.email != null) ? $(".cl_email").html(get.email): $(".cl_email").html('--');
    (get.contact_no != null) ? $(".cl_contact_no").html(get.contact_no): $(".cl_contact_no").html('--');
    (get.nic != null) ? $(".cl_nic").html(get.nic): $(".cl_nic").html('--');
    //Industry
    $(".tabf_industry_name").html(get.industry_name);
    $(".tabf_industry_cat_name").html(get.industry_category.name);
    $(".tabf_business_scale").html(get.business_scale.name);
    $(".tabf_pradesheeyasaba").html(get.pradesheeyasaba.name);
    (get.industry_registration_no != null) ? $(".tabf_industry_registration_no").html(get.industry_registration_no): $(".tabf_industry_registration_no").html('--');
    $(".tabf_industry_start_date").html(get.start_date_only);
    let invest_tabf = format(get.industry_investment);
    $(".tabf_industry_investment").html(invest_tabf);
    $(".tabf_subindustry_cat").html(get.industry_sub_category);
    $(".tabf_industry_address").html(get.industry_address);
    (get.industry_email != null) ? $(".tabf_industry_email").html(get.industry_email): $(".tabf_industry_email").html('--');
    (get.industry_contact_no != null) ? $(".tabf_industry_contact_no").html(get.industry_contact_no): $(".tabf_industry_contact_no").html('--');
    let env_officer = "Not Assinged";
    if (!(get.environment_officer == null)) {
        if (get.environment_officer.user != null) {
            env_officer =
                get.environment_officer.user.first_name +
                " " +
                get.environment_officer.user.last_name;
        }
    }
    $(".tabf_environment_officer").html(env_officer);
}

function loadAllEPLTable(dataSet, callBack) {
    //EPLS as dataSet
    var tbl = "";
    var i = 0;
    if (dataSet.length == 0) {
        tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
    } else {
        $.each(dataSet, function(index, row) {
            tbl += "<tr>";
            tbl += "<td>" + ++index + "</td>";
            tbl +=
                '<td><a type="button" href="/epl_profile/client/' +
                PROFILE_ID +
                "/profile/" +
                row.id +
                '" class="btn btn-primary">' +
                row.code +
                "</a></td>";

            if (row.certificate_no == null) {
                tbl += "<td>In Progress.</td>";
            } else {
                tbl += "<td>" + row.certificate_no.toUpperCase() + "</td>";
            }
            tbl += "<td>" + row.issue_date_only + "</td>";
            tbl += "<td>" + row.expire_date_only + "</td>";
            tbl += "</tr>";
        });
    }
    $("#clientEplList tbody").html(tbl);
    if (typeof callBack !== "undefined" && callBack != null && typeof callBack === "function") {
        callBack(dataSet);
    }
}

function loadAllSiteClearTable(dataSet, callBack) {
    //SiteClears as dataSet
    var tbl = "";
    var i = 0;
    if (dataSet.length == 0) {
        tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
    } else {
        $.each(dataSet, function(index, row) {
            tbl += "<tr>";
            tbl += "<td>" + ++index + "</td>";
            tbl += '<td><a type="button" href="/site_clearance/client/' + PROFILE_ID + "/profile/" + row.id + '" class="btn btn-primary">' + row.code + "</a></td>";
            if (row.expire_date != null) {
                tbl += "<td>" + row.expire_date + "</td>";
            } else {
                tbl += "<td> ----- No Data ----- </td>";
            }
            tbl += "</tr>";
            $.each(row.site_clearances, function(index2, row2) {
                tbl += "<tr>";
                tbl += "<td></td>";
                tbl += "<td>" + ++index2 + "</td>";
                tbl += "<td colspan='2'>issued: " + row2.issue_date + ", Expired: " + row2.expire_date + ", Session: " + row2.count + "</td>";
                tbl += "</tr>";
            });
        });
    }
    $("#clientSiteclearList tbody").html(tbl);
    if (typeof callBack !== "undefined" && callBack != null && typeof callBack === "function") {
        callBack(dataSet);
    }
}

function setupInspectionUI(need_inspection_status) {
    if (need_inspection_status === null) {
        $(".setupInspectStatus").html("Pending");
        $(".setInspectUI").removeClass("d-none");
        $(".noNeedInspect").removeClass("d-none");
    } else if (need_inspection_status === "Inspection Needed") {
        $(".setupInspectStatus").html("Inspection Needed");
        $(".noNeedInspect").removeClass("d-none");
    } else if (need_inspection_status === "Inspection Not Needed") {
        $(".setupInspectStatus").html("Inspection Not Needed");
        $(".setInspectUI").removeClass("d-none");
    } else if (need_inspection_status === "Pending") {
        $(".setupInspectStatus").html("Inspection Pending");
    } else if (need_inspection_status === "Completed") {
        $(".setupInspectStatus").html("Completed");
        $(".setInspectUI").removeClass("d-none");
    }
}

function getAllInspectionAPI(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/inspections/file/id/" + id;
    ajaxRequest("GET", url, null, function(result) {
        if (
            typeof callBack !== "undefined" &&
            callBack !== null &&
            typeof callBack === "function"
        ) {
            callBack(result);
        }
    });
}

function loadAllSiteInspectionTable(id) {
    getAllInspectionAPI(id, function(result) {
        var tbl = "";
        var id = 1;
        if (result.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(result, function(index, row) {
                tbl += "<tr>";
                tbl += "<td>" + ++index + "</td>";
                if (row.status == 0) {
                    tbl += "<td>Processing</td>";
                } else {
                    tbl += "<td><i class='fa fa-check text-success'></i> Completed (" + row.completed_at + ")</td>";
                }
                tbl += "<td>" + row.schedule_date_only + "</td>";
                tbl += '<td><a type="button" href="/inspection/epl/remarks/id/' + row.id + '" class="btn btn-primary"> View </a></td>';
                tbl += "</tr>";
            });
        }
        $("#tblAllInspections tbody").html(tbl);
    });
}

//Check Inspection Need Or Not
function checkInspectionStatus(id, btn_val, callBack) {
    if (isNaN(id)) {
        return false;
    }
    ajaxRequest(
        "PATCH",
        "/api/inspection/" + btn_val + "/file/" + id,
        null,
        function(dataSet) {
            if (
                typeof callBack !== "undefined" &&
                callBack != null &&
                typeof callBack === "function"
            ) {
                callBack(dataSet);
            }
        }
    );
}

//Report File Issue
function reportFileIssueAPI(id, data, callBack) {
    if (isNaN(id)) {
        return false;
    }
    ulploadFileWithData("/api/files/file_problem_status/id/" + id, data, function(resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}
//function reportFileIssueAPI(id, data, callBack) {
//    if (isNaN(id)) {
//        return false;
//    }
//    ajaxRequest(
//            "POST",
//            "/api/files/file_problem_status/id/" + id,
//            data,
//            function (dataSet) {
//                if (
//                        typeof callBack !== "undefined" &&
//                        callBack != null &&
//                        typeof callBack === "function"
//                        ) {
//                    callBack(dataSet);
//                }
//            }
//    );
//}

//Remove Client File API
function removeClientFileAPI(id, callBack) {
    if (isNaN(id)) {
        return false;
    }
    ajaxRequest("DELETE", "/api/client/id/" + id, null, function(dataSet) {
        if (
            typeof callBack !== "undefined" &&
            callBack != null &&
            typeof callBack === "function"
        ) {
            callBack(dataSet);
        }
    });
}

//Remove EPL Payment API
function removeEPLPaymentAPI(id, callBack) {
    if (isNaN(id)) {
        return false;
    }
    ajaxRequest("DELETE", "/api/epl/regPayment/id/" + id, null, function(
        dataSet
    ) {
        if (
            typeof callBack !== "undefined" &&
            callBack != null &&
            typeof callBack === "function"
        ) {
            callBack(dataSet);
        }
    });
}

//Pending Payments API
function pendingPaymentsAPI(id, callBack) {
    ajaxRequest("GET", "/api/payment/history/file/" + id, null, function(
        dataSet
    ) {
        if (
            typeof callBack !== "undefined" &&
            callBack != null &&
            typeof callBack === "function"
        ) {
            callBack(dataSet);
        }
    });
}
//Pending Payment Table
function pendingPaymentsTable(id) {
    pendingPaymentsAPI(id, function(result) {
        var tbl = "";
        var id = 1;
        if (result.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(result, function(index, row) {
                tbl += "<tr>";
                tbl += "<td>" + ++index + "</td>";
                if (row.cashier_name !== null) {
                    tbl += "<td>" + row.cashier_name + "</td>";
                } else {
                    tbl += "<td>N/A</td>";
                }
                if (row.invoice_no !== null) {
                    tbl += "<td>" + row.invoice_no + "</td>";
                } else {
                    tbl += "<td>N/A</td>";
                }
                if (row.status == 0) {
                    tbl += "<td>Pending Payment</td>";
                } else if (row.status == 1) {
                    tbl += "<td>Paid</td>";
                } else {
                    tbl += "<td>Payment Cancelled</td>";
                }
                tbl += "<td>" + row.net_total + "</td>";
                if (row.status == 0) {
                    tbl +=
                        '<td><button type="button" data-name="' +
                        row.name +
                        '" value="' +
                        row.id +
                        '" class="btn btn-primary printBarcode"><i class="fas fa-barcode"></i>  Re-Print BarCode </button> <button type="button" value="' +
                        row.id +
                        '" class="btn btn-danger removeBarcode"><i class="fas fa-times"></i> Remove </button></td>';
                } else {
                    tbl += "<td><i class='fas fa-check text-success'></i></td>";
                }
                tbl += "</tr>";
            });
        }
        $("#tblAllPayments tbody").html(tbl);
    });
}

function get_url_extension(url) {
    return url.split(/[#?]/)[0].split('.').pop().trim();
}

function checkFileIssueStatus(is_exist) {
    if (is_exist.file_problem_status === "problem") {
        $(".markIssueClean").removeClass("d-none"); //<-- Show Issue Cleared
        $(".showReportInfoUi").removeClass("d-none");
        $(".reportIssueView").addClass("d-none"); //<-- Hide report issue
        if (get_url_extension(is_exist.complain_attachment) == 'pdf') {
            $(".reportInfo").html(is_exist.file_problem_status_description + '<br>' + '<a href="/' + is_exist.complain_attachment + '" target="_blank"><img class="rounded" alt="PDF" style="width: auto; height: auto;" src="/dist/img/pdf-view.png" data-holder-rendered="true"></a>');
        } else {
            $(".reportInfo").html(is_exist.file_problem_status_description + '<br>' + '<a href="/' + is_exist.complain_attachment + '" target="_blank"><img class="rounded img-thumbnail" alt="IMG" style="width: auto; height: auto;" src="/' + is_exist.complain_attachment + '" data-holder-rendered="true"></a>');
        }
    } else {
        $(".markIssueClean").addClass("d-none"); //<-- Hide Issue Cleared
        $(".showReportInfoUi").addClass("d-none");
    }
}


function checkCompletedStatus(file_status, epl_status, siteclear_status) {
    if (file_status != 5) {
        if (epl_status.length != 0) {
            $(".newSiteClear").remove();
        }
        if (siteclear_status.length != 0) {
            $(".newEPL").remove();
        }
    } else {

    }
}

function setCurrentFileStatus(api_result) {
    let status_Lable = '';
    if (api_result.file_status == 2) {
        status_Lable = '(' + cer_status[api_result.cer_status] + ')';
    } else if (api_result.file_status == 0) {
        if (api_result.need_inspection == null) {
            status_Lable = '(Set Inspction Status)';
        } else if (api_result.need_inspection == 'Pending') {
            status_Lable = '(Inpection Result Pending)';
        } else {
            status_Lable = '(' + api_result.need_inspection + ')';
        }
    }
    $('.setCurrentFstatus').text(file_status_list[api_result.file_status] + status_Lable);
}

function format(n, sep, decimals) {
    sep = sep || "."; // Default to period as decimal separator
    decimals = decimals || 2; // Default to 2 decimals

    return n.toLocaleString().split(sep)[0] +
        sep +
        n.toFixed(decimals).split(sep)[1];
}