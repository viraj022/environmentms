function getAllOldFilesApi(callBack) {
    ajaxRequest('GET', "/api/files/old", null, function (dataSet) {
        var tbl = "";
        if (dataSet.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(dataSet, function (index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += (row.industry_registration_no == null) ? '<td>-</td>' : '<td>' + row.industry_registration_no + '</td>';
                tbl += '<td>' + row.file_no + '</td>';
                tbl += '<td>' + row.industry_name + '</td>';
                (row.epls.length == 0) ? tbl += '<td>-</td>' : tbl += '<td><i class="fa fa-check"></i></td>';
                (row.old_files.length == 0) ? tbl += '<td>-</td>' : tbl += '<td><i class="fa fa-check"></i></td>';
                tbl += '<td> <div  class="btn-group">  <a href="/industry_profile/id/' + row.id + '" type="button" class="btn btn-xs btn-dark">View Profile</a>&nbsp<a href="/register_old_data/id/' + row.id + '" type="button" class="btn btn-xs btn-success">Add Data</a></div></td>';
                tbl += '</tr>';
            });
        }
        $('#tblOldFiles tbody').html(tbl);
        $('#tblOldFiles').DataTable();
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
