function getaProfilebyId(callBack) {
    var url = "/api/files/certificate_drafting";
    var Obj = {1: 'New EPL', 2: 'Renew EPL', 3: 'New Site Clearance', 4: 'Site Clearance'};
    ajaxRequest('GET', url, null, function (result) {
        var tbl = '';
        if (result.length == 0) {
            tbl += '<td colspan="5">Data Not Found</td>';
        } else {
            $.each(result, function (index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td>' + row.industry_name + '</td>';
                tbl += '<td><a href="/industry_profile/id/' + row.id + '" target="_blank">' + row.file_no + '</a></td>';
                tbl += '<td>' + Obj[row.cer_type_status] + '</td>';
                tbl += '<td><a href="/certificate_perforation/id/' + row.id + '" class="btn btn-success">Update Certificate<a></td>';
                tbl += '</tr>';
            });
        }
        $('#tblPendingCertificate tbody').html(tbl);
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}