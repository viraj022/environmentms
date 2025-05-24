function GetRemarks(id, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/inspection_remarks/" + id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}

//function load_inspection_attach(inspection_attach_path){
//    var insdiv = "";
//    $.each(inspection_attach_path, function (index, value) {
//        insdiv += "<img src=" + value.path + "/>";
//    });
//    $('#attachments').html(insdiv);
//}

function loadInterface(id) {
    GetRemarks(id, function (result) {
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
            uidev += "<div class='card-footer font-weight-bold'>" + "Added By:" + " " + value.user.first_name + " " + value.user.last_name + "</div>";
            uidev += "</div>";
            uidev += "</div>";
        });
        $('#showUiDb').html(uidev);
        $('.removeComm').click(function () {
            //alert($(this).val());
            if (confirm("Are you sure you want to delete this?")) {
                deleteComment($(this).val(), function (result) {
                    if (result.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Enviremontal MS</br>Remark Removed!'
                        });
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: 'Enviremontal MS</br>Error!'
                        });
                    }
                });
            } else {
                return false;
            }
        });
    });
}

function deleteComment(id, callBack) {
    $.ajax({
        type: "DELETE",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/inspection_remark/" + id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}
function AddComment(data, id, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/inspection_remarks/" + id,
        data: data,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}

function Validiteinsert(data) {
    var response = true;
    if (data.remark.length == 0) {
        $('.aefFGE').removeClass('d-none');
        response = false;
    }
    return response;
}
function updateZone(id, data, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "api/zone/id/" + id,
        data: data,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}

function Validiteupdate(data) {
    var response = true;
    if (data.name.length == 0) {
        $('#valName').removeClass('d-none');
        response = false;
    }
    if (data.code.length == 0) {
        $('#valCode').removeClass('d-none');
        response = false;
    }
    return response;
}

function completeInspectionAPI(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/inspection/complete/id/" + id;
    ajaxRequest('POST', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}

function loadInspectionStatusAPI(id, callBack) {
    if (id.length == 0) {
        return false;
    }
    var url = "/api/inspection/id/" + id;
    ajaxRequest('GET', url, null, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    });
}
