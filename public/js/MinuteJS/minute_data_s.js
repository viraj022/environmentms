var situations_arr = {
    ENV_OFF_APP_FILE: 'Environment Officer Approved',
    ENV_OFF_REJECT_FILE: 'Environment Officer File Rejected',
    ASSI_OFF_REJECT_FILE: 'Assistent Director File Rejected',
    ASSI_OFF_APPROVE_FILE: 'Assistent Director File Approved',
    ENV_OFF_APP__CERTIFICATE: 'Environment Officer Certificate Approved',
    ENV_OFF_REJECT__CERTIFICATE: 'Environment Officer Certificate Rejected',
    ASSI_OFF_REJECT__CERTIFICATE: 'Assistant Director Certificate Rejected',
    ASSI_OFF_APPROVE__CERTIFICATE: 'Assistant Director Certificate Approved',
    DIRECTOR_APP__CERTIFICATE: 'Director Certificate Approved',
    //    ENV_OFF_APP__CERTIFICATE: 'Environment Officer Certificate Approved',
    //    ENV_OFF_REJECT__CERTIFICATE: 'Environment Officer Certificate Rejected',
    //    ASSI_OFF_REJECT__CERTIFICATE: 'Assistant Director Certificate Rejected'
};

//Method API
function methodMinuteAPI(data, method, id, callBack) {

    //Current Usage Explained - POST/1 , PUT/2 , DELETE/3 , GET/4
    let DATA_METHOD = '';
    let URL = '';

    if (method === 1) {
        DATA_METHOD = 'POST';
        URL = '/api/file_minutes';
    } else if (method === 2) {
        DATA_METHOD = 'POST';
        URL = '/api/file_minutes/' + id;
    } else if (method === 3) {
        DATA_METHOD = 'POST';
        URL = '/api/file_minutes/' + id;
    } else if (method === 4) {
        DATA_METHOD = 'GET';
        URL = '/api/file_minutes/' + id;
    } else {
        return false;
    }
    ajaxRequest(DATA_METHOD, URL, data, function(dataSet) {


        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}

//function getCardOfTableUI(callBack) {
//    var card = "";
//    var id = 1;
//    methodMinuteAPI(null, 4, PROFILE_ID, function (dataSet) {
//        if (dataSet) {
//            $.each(dataSet, function (index, set) {
//                card += '<div class="card card-success">';
//                card += '<div class="card-header">';
//                card += ' <h3 class="card-title">' + set.type + '(' + set.Date + ')' + '</h3>';
//                card += ' <div class="card-tools">';
//                card += ' <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>';
//                card += '  </button>';
//                card += ' </div>';
//                card += ' </div>';
//                card += ' <div class="card-body" style="display: block;">';
//                card += '<table class="table table-condensed">';
//                card += ' <thead>';
//                card += '    <tr>';
//                card += '       <th style="width: 10px">#</th>';
//                card += '        <th>Description</th>';
//                card += '        <th>Situation</th>';
//                card += '        <th>Updated At</th>';
//                card += '    </tr>';
//                card += '  </thead>';
//                card += ' <tbody>';
//                $.each(set.minute_object, function (index, e) {
//                    card += '<tr>';
//                    card += '<td>' + ++index + '</td>';
//                    card += '<td>' + e.minute_description + '</td>';
//                    card += '<td>' + situations_arr[e.situation] + '</td>';
//                    card += '<td>' + e.updated_at + '</td>';
//                    card += '</tr>';
//                });
//                card += '  </tbody>';
//                card += ' </table>';
//                card += ' </div>';
//                card += '</div>';
//            });
//        } else {
//            card = "<td>No Data Found</td>";
//        }
//        $('.loadMinCard').html(card);
////        $('.loadMinCard').html(table);
//        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//            callBack();
//        }
//    });
//
//}
function getCardOfTableUI(callBack) {
    var card = "";
    var id = 1;
    methodMinuteAPI(null, 4, PROFILE_ID, function(dataSet) {
        if (dataSet) {
            card += '<div class="card card-widget">';
            card += '<div class="card-header">';
            card += ' <b class="username">Minutes for this file</b>';
            card += ' <div class="card-tools">';
            card += ' <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>';
            card += ' <button type="button" class="btn btn-primary" onClick="window.print()">Print</button>';
            card += ' </div>';
            card += ' </div>';
            card += ' <div class="card-footer card-comments" style="display: block;">';
            $.each(dataSet, function(index, e) {
                card += '<div class="card-comment">';
                card += '<img class="img-circle img-sm" src="../../dist/img/user1-128x128.jpg" alt="User Image">';
                card += '<div class="comment-text">';
                card += '<span class="username">';
                card += situations_arr[e.situation];
                card += '<span class="text-muted float-right">' + e.updated_at + '</span>';
                card += '</span>';
                card += e.minute_description;
                card += '</br>';
                card += 'Officer: ' + e.user;
                card += '</div>';
                card += '</div>';
            });
            card += '</div>';
            card += '</div>';
        } else {
            card = "<td>No Data Found</td>";
        }
        $('.loadMinCard').html(card);
        //        $('.loadMinCard').html(table);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });

}
