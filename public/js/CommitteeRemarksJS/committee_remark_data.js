//Method API
function methodCommitteeRemarkAPI(data, method, id, callBack) {
    //Current Usage Explained - POST/1 , PUT/2 , DELETE/3 , GET/4
    let DATA_METHOD = '';
    let URL = '';

    if (method === 1) {
        if (!data) {
            return false;
        }
        DATA_METHOD = 'POST';
        URL = '/api/committees/' + id + '/c_remarks';
    } else if (method === 2) {
        if (!data) {
            return false;
        }
        DATA_METHOD = 'PUT';
        URL = '/api/committees/' + id + '/c_remarks';
    } else if (method === 3) {
        DATA_METHOD = 'DELETE';
        URL = '/api/c_remarks/' + id;
    } else if (method === 4) {
        DATA_METHOD = 'GET';
        URL = '/api/committees/' + id + '/c_remarks';
    } else {
        return false;
    }

    submitDataWithFile(URL, data, function (dataSet) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(dataSet);
        }
    }, DATA_METHOD);
}

function loadInterface(id) {
    methodCommitteeRemarkAPI(null, 4, id, function (result) {
        var uidev = "";
        var id = 1;
        $.each(result, function (index, value) {
            uidev += "<div class='col-md-12'>";
            uidev += "<div class='card card-outline card-success'>";
            uidev += "<div class='card-header'>";
            uidev += "<h3 class='card-title'>" + value.created_at + "</h3>";
            uidev += "<div class='card-tools'>";
            uidev += "<button type='button' class='btn btn-tool removeComm' data-card-widget='remove' value='" + value.id + "'><i class='fas fa-times'></i></button>";
            uidev += "</div>";
            uidev += "</div>";
            uidev += "<div class='card-body'>" + value.remark + "</div>";
            if (value.path != null) {
                uidev += "<a href='/" + value.path + "' target='_blank'><img class='img-fluid pad' width='230px' height='60%' src='/" + value.path + "'></a>";
            }
            uidev += "<div class='card-footer font-weight-bold'>" + "Added By:" + " " + value.user.first_name + " " + value.user.last_name + "</div>";
            uidev += "</div>";
            uidev += "</div>";
        });
        $('#showUiDb').html(uidev);
        $('.removeComm').click(function () {
            //alert($(this).val());
            if (confirm("Are you sure you want to delete this?")) {
                methodCommitteeRemarkAPI(null, 3, $(this).val(), function (result) {
                    show_mesege(result);
                });
            } else {
                return false;
            }
        });
    });
}