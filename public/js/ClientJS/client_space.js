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
}