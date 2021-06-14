function loadConfirmedTable() {
    GetIndustry(function(result) {
        var table = "";
        var id = 1;
        $.each(result, function(index, value) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table += "<td>" + value.name_title + "</td>";
            table += "<td>" + value.first_name + "</td>";
            table += "<td>" + value.last_name + "</td>";
            table += "<td>" + value.address + "</td>";
            table += "<td>" + value.contact_no + "</td>";
            table += "<td>" + value.industry_investment + "</td>";
            table += "<td>" + value.industry_registration_no + "</td>";
            table += "<td><button value='" + value.id + "' type ='button' class ='btnUnconfirm btn btn-success btn-xs'> UnConfirm </button></td>";
            table += "</tr>";
        });
        $('#tbl_confirm tbody').html(table);
        $("#tbl_confirm").DataTable();
    });
}

function GetIndustry(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/old/confirmed_clients",
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function(result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}