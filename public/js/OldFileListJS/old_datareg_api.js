//API Functions
function checkEPLExist(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/old/industry/" + id;
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function saveEPLOldFiles(epl_id, data, callBack) {
    if (!data || data.length == 0) {
        return false;
    }
    ajaxRequest("POST", "/api/epl/old/industry/" + epl_id, data, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}
function updateEPLOldFiles(epl_id, data, callBack) {
    if (!data || data.length == 0) {
        return false;
    }
    ajaxRequest("PUT", "/api/epl/old/epl/" + epl_id, data, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

function deleteEPLOldFiles(id, callBack) {
    let url = '/api/epl/old/epl/' + id;
    ajaxRequest('DELETE', url, null, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

//API Functions END


//Validate Data
function Validiteinsert(data) {
    var response = true;
    if (data.epl_code.length == 0) {
        $('#valEPL').removeClass('d-none');
        response = false;
    }
    if (data.remark.length == 0) {
        $('#valRemark').removeClass('d-none');
        response = false;
    }
    return response;
}
//END OF VALIDATE DATA

//GET EPL FORM Data
function fromValues() {
    var data = {
        epl_code: $('#getEPLCode').val(),
        remark: $('#getRemark').val(),
        issue_date: $('#issue_date').val(),
        expire_date: $('#expire_date').val(),
        certificate_no: $('#getcertifateNo').val(),
        count: $('#getPreRenew').val(),
        submit_date: $('#getsubmitDate').val(),
        file: $('#last_certificate').val()
    };
    return data;
}
//END GET EPL FORM DATA