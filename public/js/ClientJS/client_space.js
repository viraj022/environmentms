//show save button    
function showSave() {
    $('#btnSave').removeClass('d-none');
    $('#btnUpdate').addClass('d-none');
    $('#btnshowDelete').addClass('d-none');
}
//Reset all fields    
function resetinputFields() {
    $('#getName').val('');
    $('#btnUpdate').val('');
    $('#btnDelete').val('');
}
//get form values
function fromValues() {
    var data = {
        first_name: $('#getfName').val(),
        last_name: $('#getlName').val(),
        address: $('#getAddress').val(),
        contact_no: $('#getContact').val(),
        email: $('#getEmail').val(),
        nic: $('#getNicSave').val(),
        industry_name: $('#business_name').val().trim(),
        industry_category_id: $('#industryCat').val(),
        business_scale_id: $('#businesScale').val(),
        industry_contact_no: $('#getContactn').val().trim(),
        industry_address: $('#getAddressT').val().trim(),
        industry_email: $('#getEmailI').val(),
        pradesheeyasaba_id: $('#prsdeshiySb').val(),
        industry_is_industry: $('#getZone').val(),
        industry_investment: $('#inventsment').val(),
        industry_start_date: $('#startDate').val(),
        industry_registration_no: $('#business_regno').val().trim(),
        industry_coordinate_x: _Latitude,
        industry_coordinate_y: _Longitude,
        industry_created_date: $('#submittedDate').val()
                //password: $('#gefkfg').val(),
                //conpassword: $('#getfffk').val()
    };
    return data;
}
//HIDE ALL ERROR MSGS   
function hideAllErrors() {
    $('#valName').addClass('d-none');
}

//show update buttons    
function showUpdate() {
    $('#btnSave').addClass('d-none');
    $('#btnUpdate').removeClass('d-none');
    $('#btnshowDelete').removeClass('d-none');
}
function setSectionVisible(sec_id) {
    switch (sec_id) {
        case "search-Client":
            $('.search-Client').removeClass('d-none');
            $('.view-Client').addClass('d-none');
            $('.reg-newClient').addClass('d-none');
            break;
        case "view-Client":
            $('.search-Client').addClass('d-none');
            $('.view-Client').removeClass('d-none');
            $('.reg-newClient').addClass('d-none');
            $('.view-Customer').addClass('d-none');

            break;
        case "reg-newClient":
            $('.search-Client').addClass('d-none');
            $('.view-Client').addClass('d-none');
            $('.reg-newClient').removeClass('d-none');

            break;

        default:
            $('.search-Client').removeClass('d-none');
            $('.view-Client').addClass('d-none');
            $('.reg-newClient').addClass('d-none');
            break;
    }
}
function setClientDetails(obj) {
    $('#newEPL').val(obj.id);
    $('#client_amil').html(obj.email);
    $('#client_cont').html(obj.contact_no);
    $('#client_address').html(obj.address);
    $('#client_name').html(obj.first_name + ' ' + obj.last_name);

    let tbl = "";
    $('#clientEplList tbody').html(tbl);
    if (obj.epls.length == 0) {
        tbl += '<tr><td colspan="4">-No EPL Found-</td></tr>';
    } else {
        $.each(obj.epls, function (index, val) {
            tbl += '<tr>';
            tbl += '<td>' + ++index + '</td>';
            tbl += '<td>' + val.name + '</td>';
            tbl += '<td>' + val.code + '</td>';
            tbl += '<td><a href="/epl_profile/client/' + val.client_id + '/profile/' + val.id + '" class="btn btn-dark">View</a></td>';
            tbl += '</tr>';
        });
    }
    $('#clientEplList tbody').html(tbl);
}