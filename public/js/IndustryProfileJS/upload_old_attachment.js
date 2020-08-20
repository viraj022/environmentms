//Load Attachments
function loadAllOldAttachments(result, callBack) {
    var obj = '';
    var num = 0;
    $.each(result.old_files, function (index, row) {
        obj += '&nbsp;<br>';
        obj += '<a type="button" id="' + row.id + '" class="btn btn-danger text-white removeAttachs" value="0">Remove Attachment ' + ++num + '</a>   ';
        obj += '<a href="/' + row.path + '" target="_blank">View Attachment [' + ++index + ']</a> ';
        if (row.type === 'pdf') {
            obj += '<img class="rounded" alt="PDF" style="width: 80px; height: 80px;" src="/dist/img/pdf-view.png" href="/' + row.path + '" data-holder-rendered="true">';
        } else {
            obj += '<img class="rounded" alt="Attachment" style="width: 80px; height: 80px;" src="/' + row.path + '" data-holder-rendered="true">';
        }
        obj += '&nbsp;<br>';
    });
    $('.injectViewAttachs').html(obj);
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}

//----Remove Old Attachments---
function deleteOldAttachments(id, callBack) {
    let url = '/api/old/attachments/' + id;
    ajaxRequest('DELETE', url, null, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

function uploadOldAttacments(client_id, key, value, callBack) {
    let formData = new FormData();
    formData.append(key, value);
    ulploadFile2("/api/old/attachments/" + client_id, formData, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

function sectionProtector(is_old) {
    if (is_old === 1) {
        $('.oldAttachTab').addClass('disabled');
    } else {
        $('.oldAttachTab').removeClass('disabled');
    }
}

function oldFileConfirmSection(is_old) {
    if (is_old === 0 || is_old === 2) {
        $('.isNotConfiremd').removeClass('d-none');
        $('#setEPlLink').addClass('disabled');
        $('#newEPL').addClass('disabled');
        $('.serviceSectionCnf').addClass('overlay');
        $('.is_oldProf').html('OLD');
        $('.is_oldProf').removeClass('badge-primary');
        $('.is_oldProf').addClass('badge-dark');
    } else {
        $('.isConfirmed').removeClass('d-none');
        $('.removeAttachs').addClass('d-none');
        $('.uploadAttachments').addClass('d-none');
    }
}

//----Confirm Uploading Old Attachments---
function ConfirmUploadingAttachs(id, callBack) {
    let url = '/api/old/industry/' + id;
    ajaxRequest('PATCH', url, null, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

function uploadButtonHandler(value) {
    if (value.length !== 0) {
        $("#btnUpload").removeAttr("disabled");
    } else {
        $("#btnUpload").attr("disabled", "disabled");
    }
}