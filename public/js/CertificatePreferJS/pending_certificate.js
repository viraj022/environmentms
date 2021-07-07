function getaProfilebyId(callBack) {
    var url = "/api/files/certificate_drafting";
    var certificate_status = {0: 'pending', 1: 'Drafting', 2: 'Drafted', 3: 'AD Pending', 4: 'Director Pending', 5: 'Director Approved', 6: 'Issued', '-1': 'Hold'};
    var certificate_type = {0: 'pending', 1: 'New EPL', 2: 'Renew EPL', 3: 'New Site Clearance', 4: 'Site Clearance Extended'};
    ajaxRequest('GET', url, null, function (result) {
        var tbl = '';
        if (result.length == 0) {
            tbl += '<td colspan="5">Data Not Found</td>';
        } else {
            $.each(result, function (index, row) {
                let tr_style = '';
                if (row.cer_status == 2) {
                    tr_style = 'background-color: #f1f1f1;';
                }
                tbl += '<tr style="' + tr_style + '">';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td>' + row.industry_name + '</td>';
                tbl += '<td><a href="/industry_profile/id/' + row.id + '" target="_blank">' + row.file_no + '</a>(' + certificate_type[row.cer_type_status] + ')</td>';
                tbl += '<td title="' + row.certificate_comment + '">' + row.certificate_comment + '</td>';
                tbl += '<td>' + certificate_status[row.cer_status] + '</td>';
                tbl += '<td><a href="/certificate_perforation/id/' + row.id + '" class="btn btn-success">Certificate<a></td>';
                tbl += '</tr>';
            });
        }
        $('#tblPendingCertificate tbody').html(tbl);
        $('#tblPendingCertificate').DataTable({
            columnDefs: [{
                    targets: 3,
                    render: function (data, type, row) {
                        return data.length > 10 ?
                                data.substr(0, 10) + '…' :
                                data;
                    }
                }]
        });
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}