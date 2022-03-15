
function loadRolls(id,combo,callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization":"Bearer "+$('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept":"application/json"
        },
        url: "/api/rolls/levelId/" + id,
        contentType: false,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            /// apending data to comboBox
            $('.'+combo).empty();
            $.each(result, function (key, value) {
                $('.'+combo).append(new Option(value.name, value.id));
            });
            // alert(JSON.stringify(result));
            console.log(result);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {

                callBack();
            }
        }
    });

}
function loadInstituesById(id,combo,callBack) {
// send a request to get provincial councils or la according to the type
    $.ajax({
        type: "GET",
        headers: {
            "Authorization":"Bearer "+$('meta[name=api-token]').attr("content"),
            "Accept":"application/json"
        },
        url: "/api/level/institutes/id/"+id,
        contentType: false,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            /// apending data to comboBox
            $('.'+combo).empty();
            $.each(result, function (key, value) {
                $('.'+combo).append(new Option(value.name, value.id));
            });
            // alert(JSON.stringify(result));
            console.log(result);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {

                callBack();
            }
        }
    });

}
