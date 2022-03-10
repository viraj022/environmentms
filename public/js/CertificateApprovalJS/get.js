function GetLogs(id, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/approval/id/" + id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}
function loadTable(id) {
    let statusArray = {officer: "Environment Officer", a_director: "Assistant Director", director: "Director"};
    GetLogs(id, function (result) {
        var table = "";
        var id = 1;
        $.each(result, function (index, payvalue) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table += "<td>" + payvalue.approve_date + "</td>";
            table += "<td>" + payvalue.comment + "</td>";
            if (payvalue.status == 0) {
                table += "<td><span class='right badge badge-success'>" + statusArray[payvalue.officer_type] + " Approved</span></td>";
            } else if (payvalue.status == 1) {
                table += "<td><span class='right badge badge-danger'>" + statusArray[payvalue.officer_type] + " Rejected</span></td>";
            }
            table += "</tr>";
        });
        $('#tblCerApprove tbody').html(table);
        $("#tblCerApprove").DataTable();
    });
}

function GetPaymentCat(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "api/payment_type",
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}

function loadPayCatCombo(callBack) {
    GetPaymentCat(function (result) {
        var combo = "";
        var id = 1;
        $.each(result, function (index, value) {
            combo += "<option value='" + value.id + "'>" + value.name + "</option>";
        });
        $('#getPaymentCat').html(combo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(result);
        }
    });
}
function loadPayInfoCatCombo(callBack) {
    GetPaymentCat(function (result) {
        var combo = "";
        var id = 1;
        $.each(result, function (index, value) {
            combo += "<option value='" + value.id + "'>" + value.name + "</option>";
        });
        $('#getPaymentInfobyCat').html(combo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function getaPaymentsbyId(id, callBack) {

    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "api/payment/id/" + id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });

}
function get_initial_approvalStatus(id, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/approval/current/id/" + id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}
