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

function uniqueNamecheck(name,callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/pradesheeyasaba/name/"+name,
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
function loadTable() {
    GetPaymentCat(function (result) {
        var table = "";
        var id = 1;
        $.each(result, function (index, value) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table += "<td>" + value.name + "</td>";
            table += "<td><button id='" + value.id + "' type='button' class='btn btn-block btn-primary btn-xs btnAction'>Select</button></td>";
            table += "</tr>";
        });
        $('#tblPaymentCat tbody').html(table);
        $("#tblPaymentCat").DataTable();
    });
}

function getaPaymentCatbyId(id, callBack) {

    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/payment_type/id/" + id,
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