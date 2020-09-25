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
function fromValues(type) {
    var data = {
        client_id: $('#client_id').val(),
        created_date: $('#startDate').val(),
        remark: $('#getRemark').val().trim(),
        file: $('#inp')[0].files[0]
    };
    if (type == 'site_clearance') {
        data.type = $('#setSiteType').val();
        data.submit_date = $('#startDate').val();
    }
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

