//Method API
function oldfileCoundByDate(callBack) {
    ajaxRequest('GET', '/api/old_files/count_by_date', null, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

function getOldDataSummerApi(data, callBack) {
    var tbl = "";
    if (data.length == 0) {
        tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
    } else {
        $.each(data, function (index, row) {
            tbl += '<tr>';
            tbl += '<td>' + ++index + '</td>';
            tbl += '<td>' + row.date + '</td>';
            tbl += '<td>' + row.count + '</td>';
            tbl += '</tr>';
        });
    }
    $('#tblloadOldDataSummer tbody').html(tbl);
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }

}