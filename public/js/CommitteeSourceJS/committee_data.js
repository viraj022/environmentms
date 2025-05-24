
function committeeMemberCombo(callBack) {
    var cbo = "";
    ajaxRequest('GET', "/api/committee", null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '">' + row.first_name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#getCommitUser').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}

function selectedApplication_table(obj, callBack) {
    var tbl = "";
    if (obj.length == 0) {
        tbl = "<tr><td colspan='3'>No Data Found</td></tr>";
    } else {
        $.each(obj, function (index, row) {
            tbl += '<tr>';
            tbl += '<td>' + ++index + '</td>';
            tbl += '<td>' + row.first_name + '</td>';
            tbl += '<td><button value="' + row.id + '" type="button" class="btn btn-danger app_removeBtn">Remove</button></td>';
            tbl += '</tr>';
        });
    }
    $('#tblComMembers tbody').html(tbl);
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}
//Method API
function methodCommitteeAPI(data, method, id, callBack) {
    let DATA_METHOD = '';
    let URL = '';

    if (method === 1) {
        DATA_METHOD = 'POST';
        URL = '/api/committees';
    } else if (method === 2) {
        DATA_METHOD = 'POST';
        URL = '/api/committees/' + id;
    } else if (method === 3) {
        DATA_METHOD = 'DELETE';
        URL = '/api/committees/' + id;
    } else if (method === 4) {
        DATA_METHOD = 'GET';
        URL = '/api/committees/' + id;
    } else {
        return false;
    }
    ajaxRequest(DATA_METHOD, URL, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

function getCommitteeTableUI(callBack) {
    var table = "";
    var id = 1;
    ajaxRequest('GET', "/api/committees", null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, committee) {
                table += "<tr>";
                table += "<td>" + id++ + "</td>";
                table += "<td>" + committee.name + "</td>";
                table += "<td>" + committee.schedule_date + "</td>";
                table += '<td><a href="/committee_remarks/id/' + committee.id + '" type="button" target="_blank" class="btn btn-dark btn-xs"> Comment </a></td>';
                table += "<td><button id='" + committee.id + "' value='" + committee.id + "' type='button' class='btn btn-block btn-success btn-xs btnAction'>Select</button></td>";
                table += "</tr>";
            });
        } else {
            table = "<option value=''>No Data Found</option>";
        }
        $('#tblCommittees tbody').html(table);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });

}
