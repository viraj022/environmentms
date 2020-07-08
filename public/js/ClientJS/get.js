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

            if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}
function loadTable() {
    GetClients(function (result) {
        var table = "";
        var id = 1;
        $.each(result, function (index, clientData) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table += "<td>" + clientData.first_name + "</td>";
            table += "<td>" + clientData.last_name + "</td>";
            table += "<td>" + clientData.nic + "</td>";
            table += "<td><button id='" + clientData.id + "' type='button' class='btn btn-block btn-success btn-xs btnAction'>Select</button></td>";
            table += "</tr>";
        });
        $('#tblAllClients tbody').html(table);
        $("#tblAllClients").DataTable();
    });
}

function getaClientbyId(id, callBack) {

    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/client/id/" + id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });

}
//DEV Mode
//function getClientbyNic(nic, callBack) {
//    if (nic.length == 0) {
//        return false;
//    }
//    $.ajax({
//        type: "GET",
//        headers: {
//            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
//            "Accept": "application/json"
//        },
//        url: "api/client/nic/" + nic,
//        data: null,
//        dataType: "json",
//        cache: false,
//        processDaate: false,
//        success: function (result) {
//            if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
//                callBack(result);
//            }
//        }
//    });
//
//}

function getClientbyNic(type, data, callBack) {
    if (type.length == 0) {
        return false;
    }
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/search/client/type/" + type,
        data: data,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });

}

function fromValuesCv() {
    var data = {
        value: $('#getNic').val()
    };
    return data;
}