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
    $('#otherFiles').val('');
}
//HIDE ALL ERROR MSGS   
function hideAllErrors() {
    $('#valEPL').addClass('d-none');
    $('#valRemark').addClass('d-none');
}
//Upload Section Visibility
function visibleUploads(usage) {
    if (usage.length == 0) {
        $('.uploadEPLSection').addClass('d-none');
    } else {
        $('.uploadEPLSection').removeClass('d-none');
    }
}

//Load Attachments
function loadAllOldAttachments(result, callBack) {
    var obj = '';
    var num = 0;
    $.each(result.old_files, function (index, row) {
        obj += '&nbsp;<br>';
        obj += '<a type="button" id="' + row.id + '" class="btn btn-danger text-white removeAttachs" value="0">Remove Attachment ' + ++num + '</a>   ';
        obj += '<a href="/' + row.path + '" target="_blank">View Attachment [' + ++index + ']</a> ';
        obj += '&nbsp;<br>';
    });
    $('.injectViewAttachs').html(obj);
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}

//This function used to reload Ajax Client Data
function regenCLientData(EPL_PROFILE) {
    getAsetClientData(EPL_PROFILE, function (result) {
        setProfileDetails(result);
        loadAllOldAttachments(result, function () {
        });
    });
}

function uploadButtonHandler(value) {
    if (value.length !== 0) {
        $("#btnUpload").removeAttr("disabled");
    } else {
        $("#btnUpload").attr("disabled", "disabled");
    }
}