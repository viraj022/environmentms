//Load Attachments
function loadAllOldAttachments(result, BASE_PATH, callBack) {
    var obj = '';
    console.log(BASE_PATH);
    $.each(result, function (index, row) {
        obj += '<div class="col-3 text-center" style="padding: 7.5px 7.5px 7.5px 7.5px; height: 300px;">';
        if (row.type === 'pdf') {
            obj += '<a href="' + BASE_PATH + row.path + '" target="_blank"><img class="rounded" alt="PDF" style="width: auto; height: auto;" src="/dist/img/pdf-view.png" data-holder-rendered="true"></a>';
        } else {
            obj += '<a href="' + BASE_PATH + row.path + '" target="_blank"><img class="rounded img-thumbnail" alt="Attachment" style="" src="' + BASE_PATH + row.path + '" data-holder-rendered="true"></a>';
        }
        if (row.description == null) {
            row.description = 'N/A';
        }
        obj += '<h6 class="text-center" >' + row.description + '</h6>';
        obj += '<span>Uploaded at: ' + row.created_at + '</span><br>';
        obj += '<a type="button" id="' + row.id + '" class="btn btn-danger text-white removeAttachs" value="0">Remove Attachment</a>';
        obj += '</div>';
    });
    $('.injectViewAttachs').html(obj);
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}

function deedList(profile_id, FILE_BASE_PATH, callBack) {
    var obj = '';
    ajaxRequest('GET', '/api/files/client/id/' + profile_id, null, function (respo) {
        if (respo.length == 0) {
            obj += '<li><a>No Files Found</a></li>';
        } else {
            $.each(respo, function (index, row) {
                obj += '<li class="' + (row.is_latest ? 'text-success' : '') + '">\
                <a target="_blank" href="/' + FILE_BASE_PATH + row.file_name + '" class="' + (row.is_latest ? 'text-success' : '') + '">' + (row.is_latest ? '<strong>' : '') + 'File ' + ++index + (row.is_latest ? ' (Latest)' : '') + (row.is_latest ? '<strong>' : '') + '</a>\
                </li>';
            });
        }
        $('.deedListUsr').html(obj);
    });
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}

//----Remove Old Attachments---
function deleteOldAttachments(id, callBack) {
    let url = '/api/old/attachments/delete/' + id;
    ajaxRequest('POST', url, null, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

function uploadOldAttacments(client_id, key, value, desc, callBack) {
    let formData = new FormData();
    formData.append(key, value);
    formData.append('file_catagory', 'ATTACHMENT');
    formData.append('description', desc);
    ulploadFile2("/api/old/attachments/" + client_id, formData, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

function oldFileConfirmSection(is_old) {
    if (is_old === 0) {
        $('#setEPlLink').addClass('disabled');
        $('#newEPL').addClass('disabled');
        $('.serviceSectionCnf').addClass('overlay');
        $('.is_oldProf').html('OLD');
        $('.is_oldProf').removeClass('badge-primary');
        $('.is_oldProf').addClass('badge-dark');
        $('.isNotConfiremd').removeClass('d-none');
        $('.isConfirmed').addClass('d-none');
    } else if (is_old === 1) {
        $('.removeAttachs').addClass('d-none');
        //        $('.uploadAttachments').addClass('d-none');
        $('.is_oldProf').html('NEW');
    } else if (is_old === 2) {
        $('.isNotConfiremd').addClass('d-none');
        $('.isConfirmed').removeClass('d-none');
        $('.is_oldProf').html('OLD');
        $('.is_oldProf').removeClass('badge-primary');
        $('.is_oldProf').addClass('badge-dark');
        $('.removeAttachs').addClass('d-none');
    } else {
        alert("Invalid Old Code!");
    }
}

//----Confirm Uploading Old Attachments---
function ConfirmUploadingAttachs(id, callBack) {
    let url = '/api/old/industry/' + id;
    ajaxRequest('POST', url, null, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

//----Confirm Uploading Old Attachments---
function UnConfirmUploadingAttachs(id, callBack) {
    let url = '/api/old/unconfirm_industry/' + id;
    ajaxRequest('POST', url, null, function (resp) {
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

function updateAttachmentData(status_of) {
    (status_of.file_01 == null) ? $('.upld_roadMap').addClass('d-none') : $('.upld_roadMap').removeClass('d-none');
    (status_of.file_02 == null) ? $('.upld_deed').addClass('d-none') : $('.upld_deed').removeClass('d-none');
    (status_of.file_03 == null) ? $('.upld_SurveyPlan').addClass('d-none') : $('.upld_SurveyPlan').removeClass('d-none');
}
