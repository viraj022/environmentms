function GetRemarks(id, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/remarks/" + id,
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

function loadInterface(id) {
    GetRemarks(id, function (result) {
        var uidev = "";
        var id = 1;
        $.each(result, function (index, value) {
            uidev += "<div class='col-md-8'>";
            uidev += "<div class='card card-outline card-success'>";
            uidev += "<div class='card-header'>";
            uidev += "<h3 class='card-title'>" + value.created_at + "</h3>";
            uidev += "<div class='card-tools'>";
            uidev += "<button type='button' class='btn btn-tool removeComm' data-card-widget='remove' value='" + value.id + "'><i class='fas fa-times'></i></button>";
            uidev += "</div>";
            uidev += "</div>";
            uidev += "<div class='card-body'>" + value.remark + "</div>";
            uidev += "<div class='card-footer font-weight-bold'>"+ "Added By:" + " " + value.user.first_name + " " + value.user.last_name +"</div>";
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
