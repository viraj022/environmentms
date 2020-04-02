function GetClients(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/client",
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
    GetClients(id,function (result) {
        var table = "";
        var id = 1;
        $.each(result, function (index, clientData) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table += "<td>" + clientData.first_name + "</td>";
            table += "<td>" + clientData.type + "</td>";
            table += "<td>" + clientData.amount + "</td>";
            table += "<td><button id='" + clientData.id + "' type='button' class='btn btn-block btn-success btn-xs btnAction'>Select</button></td>";
            table += "</tr>";
        });
        $('#tblPayments tbody').html(table);
        $("#tblPayments").DataTable();
    });
}

function GetPaymentCat(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
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
//DEV Mode
function getClientbyNic(nic, callBack) {

    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/client/nic/" + nic,
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