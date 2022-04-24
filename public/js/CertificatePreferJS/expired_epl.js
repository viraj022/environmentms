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



// function getExpireEplByAssDir(id, callBack) {
//     var url = "/api/expiredEpl";
//     let data = {
//         id: id,
//         is_checked: $('#getByAssDir').prop("checked"),
//     }
//     ajaxRequest('post', url, data, function(result) {
//         var tbl = '';
//         if (result.length == 0) {
//             tbl += '<td colspan="5">Data Not Found</td>';
//         } else {
//             $('#tblExpiredEpl').DataTable().destroy();
//             $.each(result, function(index, row) {
//                 tbl += '<tr>';
//                 tbl += '<td>' + ++index + '</td>';
//                 tbl += '<td>' + row.client.industry_name + '</td>';
//                 tbl += '<td>' + ' (<a href="/industry_profile/id/' + row.client_id + '" target="_blank">' + row.client.file_no + '</a>)</td>';
//                 tbl += '<td>' + row.client.pradesheeyasaba.name + '</td>';
//                 tbl += '<td>' + row.expire_date + '</td>';
//                 tbl += '</tr>';
//             });
//         }
//         $('#tblExpiredEpl tbody').html(tbl);
//         $('#tblExpiredEpl').DataTable({
//             stateSave: true
//         });
//         if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
//             callBack(result);
//         }
//     });
// }