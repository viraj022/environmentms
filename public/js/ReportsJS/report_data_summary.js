//Method API
function oldfileCoundByDate(data, method, id, callBack) {
    //Current Usage Explained - POST/1 , PUT/2 , DELETE/3 , GET/4
    let DATA_METHOD = '';
    let URL = '';

    if (method === 1) {
        DATA_METHOD = 'POST';
        URL = '/api/old_files/count_by_date';
    } else if (method === 2) {
        DATA_METHOD = 'PUT';
        URL = '/api/old_files/count_by_date/' + id;
    } else if (method === 3) {
        DATA_METHOD = 'DELETE';
        URL = '/api/old_files/count_by_date/' + id;
    } else if (method === 4) {
        DATA_METHOD = 'GET';
        URL = '/api/old_files/count_by_date';
    } else {
        return false;
    }
    ajaxRequest(DATA_METHOD, URL, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

function getOldDataSummerApi(callBack) {
    oldfileCoundByDate(null, 4, null, function (dataSet) {
        var tbl = "";
        if (dataSet.length == 0) {
            tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
        } else {
            $.each(dataSet, function (index, row) {
                tbl += '<tr>';
                tbl += '<td>' + ++index + '</td>';
                tbl += '<td>' + row.date + '</td>';
                tbl += '<td>' + row.count + '</td>';
                tbl += '</tr>';
            });
        }
        $('#tblloadOldDataSummer tbody').html(tbl);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });

}