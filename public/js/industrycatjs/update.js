function updateIndustry(id,data,callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "api/industrycategory/id/"+ id,
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

function Validiteupdate(data){
    var response = true;
    if(data.name.length == 0){
        $('#valIndustryName').removeClass('d-none');
        response = false;
    }
        if(data.code.length == 0){
        $('#valIndustryCode').removeClass('d-none');
        response = false;
    }
    return response;
}
