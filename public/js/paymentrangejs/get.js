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