

//function GetIndustry(callBack) {
//    $.ajax({
//        type: "GET",
//        headers: {
//            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
//            "Accept": "application/json"
//        },
//        url: "/api/server_side_process",
//        data: {
//            "search": $('input[type=search]').val(),
//            "order_column": "file_no",
//            "order_dir": "asc"
//        },
//        dataType: "json",
//        cache: false,
//        processDaate: false,
//        success: function (result) {
//
//            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//                callBack(result);
//            }
//        },
//        error: function (xhr, textStatus, errorThrown) {
//            alert(textStatus + ':' + errorThrown);
//        }
//    });
//}