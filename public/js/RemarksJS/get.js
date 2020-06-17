function GetRemarks(id,callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/remarks/"+id,
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
    GetRemarks(id,function (result) {
        var uidev = "";
        var id = 1;
        $.each(result, function (index, value) {
            uidev += "<div class='col-md-8'>";
            uidev += "<div class='card card-outline card-success'>";
            uidev += "<div class='card-header'>";
            uidev += "<h3 class='card-title'>"+ value.created_at +"</h3>";
            uidev += "<div class='card-tools'>";
            uidev += "<button type='button' class='btn btn-tool removeComm' data-card-widget='remove'><i class='fas fa-times'></i></button>";
            uidev += "</div>";
            uidev += "</div>";
            uidev += "<div class='card-body'>"+ value.remark +"</div>";
            uidev += "</div>";
            uidev += "</div>";
        });
        $('#showUiDb').html(uidev);
    });
}