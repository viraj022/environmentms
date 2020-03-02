function GetPaymentRange(id,callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/rangedpayment",
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
    GetPaymentRange(id,function (result) {
        var table = "";
        var id = 1;
        $.each(result, function (index, rangevalue) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table += "<td>" + rangevalue.name + "</td>";
            table += "<td>" + rangevalue.type + "</td>";
            table += "<td><button id='" + rangevalue.id + "' type='button' class='btn btn-block btn-primary btn-xs btnAction'>Select</button></td>";
            table += "</tr>";
        });
        $('#tblPaymentRange tbody').html(table);
        $("#tblPaymentRange").DataTable();
    });
}

function createPaymentRangeBox(id) {
    getaPaymentRangebyCat(id,function (result) {
        var range = "";
        var id = 1;
        $.each(result, function (index, rangevalue) {
            range += "<div class='row form-group create-Now'>";
            range += "<div class='col-3'>";
            range += "<input type='text' class='form-control form-control-sm' value='"+ rangevalue.from +"' placeholder='Enter From..'>";
            range += "</div>";
            range += "<div class='col-3'>";
            range += "<input type='text' class='form-control form-control-sm' value='"+ rangevalue.to +"' placeholder='Enter To..'>";
            range += "</div>";
            range += "<div class='col-4'>";
            range += "<input type='number' class='form-control form-control-sm' value='"+ rangevalue.amount +"' placeholder='Enter Amount..'>";
            range += "</div>";
            range += "<div class='col-1'>";
            range += "<button type='button' class='btn btn-block btn-outline-primary btn-xs make-new'><i class='fas fas fa-plus'></i></button>";
            range += "</div>";
            range += "<div class='col-1'>";
            range += "<button type='button' class='btn btn-block btn-outline-danger btn-xs make-remove'><i class='fas fas fa-minus'></i></button>";
            range += "</div>";
            range += "</div>";
            
        });
        $('.create-Now').html(range);
    });
}

function getaPaymentRangebyId(id, callBack) {

    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/rangedpayment/id/" + id,
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

function getaPaymentRangebyCat(id, callBack) {

    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/findRangedPayment/payment_id/" + id,
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