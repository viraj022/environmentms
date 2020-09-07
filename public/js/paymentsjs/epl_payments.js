function loadEPL_details(epl_id, callBack) {
    ajaxRequest('GET', "/api/epl/pay/id/" + epl_id, null, function (dataSet) {
        if (dataSet.fine.status == "not_payed") {
            $('#fineDev').removeClass('d-none');
            $('#fine_amt').prop('readonly', false);
            $('#fine_payBtn').prop('disabled', false);
        } else if (dataSet.fine.status == "not_available") {
            $('#fineDev').addClass('d-none');
        } else {
            $('#fineDev').removeClass('d-none');
            $('#fine_amt').prop('readonly', true);
            $('#fine_payBtn').prop('disabled', true);
        }

        if (dataSet.inspection.status == "not_payed") {
            $('#epl_methodCombo').prop('disabled', false);
            $('#paymnt_amount').prop('readonly', false);
            $('#inspection_payBtn').prop('disabled', false);
            $('#paymnt_amount').val('');
        } else {
            $('#epl_methodCombo').prop('disabled', true);
            $('#paymnt_amount').prop('readonly', true);
            $('#inspection_payBtn').prop('disabled', true);
            $('#paymnt_amount').val(dataSet.inspection.object.amount);
        }
        if (dataSet.license_fee.status == "not_payed") {
            $('#certificate_list').prop('disabled', false);
            $('#certificate_payBtn').prop('disabled', false);
            $('#cert_amt').val('');
        } else {
            $('#certificate_list').prop('disabled', true);
            $('#certificate_payBtn').prop('disabled', true);
            $('#cert_amt').val(dataSet.license_fee.object.amount);
        }

        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
function loadFine_amount(epl_id, epl_amt, callBack) {
    if (isNaN(epl_amt)) {
        epl_amt = 0;
    }
    ajaxRequest('POST', "/api/get/epl/inspection/fine/id/" + epl_id, {inspection_fee: epl_amt}, function (dataSet) {
        $('#fine_amt').val(dataSet.amount);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function loadEPL_methodCombo(callBack) {
    let cbo = '';
    ajaxRequest('GET', "/api/inspection/list", null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '" data-amt="' + row.amount + '">' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#epl_methodCombo').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function fineList_Combo(callBack) {
    let cbo = '';
    ajaxRequest('GET', "/api/application/fine_list", null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '" data-amt="' + row.amount + '">' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#fine_list').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function certificateList_Combo(callBack) {
    let cbo = '';
    ajaxRequest('GET', "/api/application/licenceList", null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '" data-amt="' + row.amount + '">' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#certificate_list').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function certificate_amount() {
    let amt = (isNaN(parseFloat($('#certificate_list :selected').data('amt')))) ? 0.0 : parseFloat($('#certificate_list :selected').data('amt'));
    $('#cert_amt').val(amt);
}
function calc_amount() {
    let amt = (isNaN(parseFloat($('#epl_methodCombo :selected').data('amt')))) ? 0.0 : parseFloat($('#epl_methodCombo :selected').data('amt'));
    $('#paymnt_amount').val(amt);
}

//function loadApplication_types(callBack) {
//    var cbo = "";
//    ajaxRequest('GET', "/api/application/applicationList", null, function (dataSet) {
//        if (dataSet) {
//            $.each(dataSet, function (index, row) {
//                cbo += '<option value="' + row.id + '" data-amt="' + row.amount + '">' + row.name + '</option>';
//            });
//        } else {
//            cbo = "<option value=''>No Data Found</option>";
//        }
//        $('#application_combo').html(cbo);
//        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//            callBack();
//        }
//    });
//}
function selectedPayments_table(obj, callBack) {
    var tbl = "";
    var tblft = "";
    let tot = 0.0;
    if (obj.length == 0) {
        tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
    } else {
        $.each(obj, function (index, row) {
            tot += parseFloat(row.amount);
            tbl += '<tr>';
            tbl += '<td>' + ++index + '</td>';
            tbl += '<td>' + row.name + '</td>';
            tbl += '<td class="text-right">' + row.amount + '</td>';
            tbl += '<td><button value="' + row.id + '" type="button" class="btn btn-danger app_removeBtn">Remove</button></td>';
            tbl += '</tr>';
        });
    }
    tbl += '<tr>';
    tbl += '<td colspan="2">Total</td>';
    tbl += '<td class="text-right">' + tot.toFixed(2) + '</td>';
    tbl += '<td></td>';
    tbl += '</tr>';

    $('#tbl_applications tbody').html(tbl);
    $('#tbl_applications tfoot').html(tblft);
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}

function savePayment(data, epl_id, callBack) {
    if (!data || data.length == 0) {
        alert('Please Add Payments Before Complete!');
        return false;
    }
    ajaxRequest("POST", "/api/epl/pay/id/" + epl_id, {items: data}, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}
//function deleteIssueApplication(id, callBack) {
//    let url = 'api/epl/regPayment/id/' + id;
//    ajaxRequest('DELETE', url, null, function (resp) {
//        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//            callBack(resp);
//        }
//        loadTable();
//    })
//}