var cer_status = { 0: 'pending', 1: 'Drafting', 2: 'Drafted', 3: 'AD Approval Pending', 4: 'Director Approval pending', 5: 'Director Approved', 6: 'Certificate Issued', '-1': 'Certificate Director Holded' };

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

function getConfirmedCerByAssDir(id, callBack) {
    var url = "/api/files/confirmed";
    //    var certificate_status = {0: 'pending', 1: 'Drafting', 2: 'Drafted', 3: 'AD Pending', 4: 'Director Pending', 5: 'Director Approved', 6: 'Issued', '-1': 'Hold'};
    //    var certificate_type = {0: 'pending', 1: 'New EPL', 2: 'Renew EPL', 3: 'New Site Clearance', 4: 'Site Clearance Extended'};
    ajaxRequest('GET', url, null, function(result) {
        var tbl = '';
        if (result.length == 0) {
            tbl += '<tr>';
            tbl += '<td colspan="5">Data Not Found</td>';
            tbl += '</tr>';
        } else {
            $.each(result, function(index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td>' + row.industry_name + '</td>';
                tbl += '<td><a href="/industry_profile/id/' + row.id + '" target="_blank">' + row.file_no + '</a></a></td>';
                tbl += '<td>' + row.file_problem_status + '</td>';
                tbl += '<td><a href="/certificate_perforation/id/' + row.id + '" class="btn btn-success">Certificate<a></td>';
                tbl += '</tr>';
            });
        }
        $('#confirmed_files tbody').html(tbl);
        $('#confirmed_files').DataTable();
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}