//View Customer Data
//function showCustomerDetails(obje) {
//    $('#client_name').html(obje.first_name + ' ' + obje.last_name);
//    $('#client_address').html(obje.address);
//    $('#client_cont').html(obje.contact_no);
//    $('#client_amil').html(obje.email);
//    $('#client_nic').html(obje.nic);
//}
function showCustomerDetails(obje) {
        var table = "";
        var id = 1;
        $.each(obje, function (index, clientData) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table += "<td>" + clientData.first_name + "</td>";
            table += "<td>" + clientData.last_name + "</td>";
            table += "<td>" + clientData.address + "</td>";
            table += "<td>" + clientData.nic + "</td>";
            table += "<td><a href='/industry_profile/id/" + clientData.id + "' class='btn btn-block btn-success btn-xs btnCustomerVa'>Select</a></td>";
            table += "</tr>";
        });
        $('#tblCusData tbody').html(table);
        $("#tblCusData").DataTable();
}

//View site clearance details


