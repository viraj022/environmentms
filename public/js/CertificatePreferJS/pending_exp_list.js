function loadAssDirCombo(callBack) {
    var url = '/api/AssistantDirector/active';
    let cbo = '';
    ajaxRequest('GET', url, null, function(dataSet) {
        if (dataSet.length == 0) {
            cbo = "<option value=''>No Data Found</option>";
        } else {
            $.each(dataSet, function(index, row) {
                cbo += '<option value="' + row.id + '">' + row.first_name + " " + row.last_name + '</option>';
            });
        }
        $('#getAsDirect').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}

function getPendingExpireCerByAssDir(id, callBack) {
    var url = "/api/pendingExpiredCert";

    let data = {
        "id": id,
        "is_checked": $('#getByAssDir').prop("checked")
    };
    ajaxRequest('post', url, data, function(result) {
        var tbl = '';
        if (result.length == 0) {
            tbl += '<td colspan="5">Data Not Found</td>';
        } else {
            $('#tblPendingExpList').DataTable().destroy();
            $.each(result, function(index, row) {
                if (row.client != null) {
                    tbl += '<tr>';
                    tbl += '<td>' + ++index + '</td>';
                    tbl += '<td>' + row.code + '</td>';
                    tbl += '<td>' + row.client.file_no + '</td>';
                    tbl += '<td>' + row.client.industry_name + '</td>';
                    if (row.client.environment_officer != null) {
                        tbl += '<td>' + row.client.environment_officer.user.user_name + '</td>';
                    } else {
                        tbl += '<td> Not Assigned </td>';
                    }
                    tbl += '</tr>';
                }
            });
        }
        $('#tblPendingExpList tbody').html(tbl);
        $('#tblPendingExpList').DataTable({
            stateSave: true
        });
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}