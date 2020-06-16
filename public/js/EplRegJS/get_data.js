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
        name: $('#business_name').val(),
        client_id: $('#client_id').val(),
        industry_category_id: $('#industryCat').val(),
        business_scale_id: $('#businesScale').val(),
        contact_no: $('#getContactn').val(),
        address: $('#getAddressT').val(),
        email: $('#getEmail').val(),
        coordinate_x: _Latitude,
        coordinate_y: _Longitude,
        pradesheeyasaba_id: $('#prsdeshiySb').val(),
        is_industry: $('#getZone').val(),
        investment: $('#inventsment').val(),
        start_date: $('#startDate').val(),
        registration_no: $('#business_regno').val(),
        remark: $('#getRemark').val()
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

