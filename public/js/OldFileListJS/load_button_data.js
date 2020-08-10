//show update buttons    
        function showUpdate() {
            $('#btnSave').addClass('d-none');
            $('#btnUpdate').removeClass('d-none');
            $('#btnshowDelete').removeClass('d-none');
        }
//show save button    
        function showSave() {
            $('#btnSave').removeClass('d-none');
            $('#btnUpdate').addClass('d-none');
            $('#btnshowDelete').addClass('d-none');
        }
//Reset all fields    
        function resetinputFields() {
            $('#getEPLCode').val();
            $('#getRemark').val();
            $('#issue_date').val();
            $('#expire_date').val();
            $('#getcertifateNo').val();
            $('#getPreRenew').val();
            $('#getsubmitDate').val();
            $('#last_certificate').val();
        }
//HIDE ALL ERROR MSGS   
        function hideAllErrors() {
            $('#valEPL').addClass('d-none');
            $('#valRemark').addClass('d-none');
        }