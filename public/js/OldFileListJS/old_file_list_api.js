function getAllOldFilesApi(callBack) {
    ajaxRequest('GET', "/api/files/old", null, function (dataSet) {
        var tbl = "";
        if (dataSet.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(dataSet, function (index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td>' + row.industry_name + '</td>';
                tbl += '<td>' + row.industry_registration_no + '</td>';
                tbl += '<td><a href="/register_old_data/id/' + row.id + '" type="button" class="btn btn-success">Select File</a></td>';
                tbl += '</tr>';
            });
        }
        $('#tblOldFiles tbody').html(tbl);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}
