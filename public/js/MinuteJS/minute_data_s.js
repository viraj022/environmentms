//Method API
function methodMinuteAPI(data, method, id, callBack) {
    //Current Usage Explained - POST/1 , PUT/2 , DELETE/3 , GET/4
    let DATA_METHOD = '';
    let URL = '';

    if (method === 1) {
        DATA_METHOD = 'POST';
        URL = '/api/file_minutes';
    } else if (method === 2) {
        DATA_METHOD = 'PUT';
        URL = '/api/file_minutes/' + id;
    } else if (method === 3) {
        DATA_METHOD = 'DELETE';
        URL = '/api/file_minutes/' + id;
    } else if (method === 4) {
        DATA_METHOD = 'GET';
        URL = '/api/file_minutes';
    } else {
        return false;
    }
    ajaxRequest(DATA_METHOD, URL, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    });
}


function getCardOfTableUI(callBack) {
    var card = "";
    var id = 1;
    methodMinuteAPI(null, 4, null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, set) {
                card += '<div class="card card-success">';
                card += '<div class="card-header">';
                card += ' <h3 class="card-title">' + set.type + '(' + set.Date + ')' + '</h3>';
                card += ' <div class="card-tools">';
                card += ' <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>';
                card += '  </button>';
                card += ' </div>';
                card += ' </div>';
                card += ' <div class="card-body" style="display: block;">';
//                $.each(set.minute_object, function (index, e) {
                card += '<table class="table table-condensed">';
                card += ' <thead>';
                card += '    <tr>';
                card += '       <th style="width: 10px">#</th>';
                card += '        <th>Description</th>';
                card += '        <th>Situation</th>';
                card += '    </tr>';
                card += '  </thead>';
                card += ' <tbody>';
                $.each(set.minute_object, function (index, e) {
                    card += '<tr>';
                    card += '<td>' + ++index + '</td>';
                    card += '<td>' + e.minute_description + '</td>';
                    card += '<td>' + e.situation + '</td>';
                    card += '</tr>';
                });
                card += '  </tbody>';
                card += ' </table>';
//                });
                card += ' </div>';
                card += '</div>';
            });
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