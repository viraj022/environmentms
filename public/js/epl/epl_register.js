function loadPradeshiyaSabha(callBack) {
    var cbo = "";
    ajaxRequest('GET', "/api/pradesheeyasabas", function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '">' + row.code + ' - ' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#prsdeshiySb').html(cbo);
        $('.select2').select2();
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function IndustryCategoryCombo(callBack) {
    var cbo = "";
    ajaxRequest('GET', "/api/industrycategories", function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '">' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#industryCat').html(cbo);
        $('.select2').select2();
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function BusinessScaleCombo(callBack) {
    var cbo = "";
    ajaxRequest('GET', "/api/business_scale", function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '">' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#businesScale').html(cbo);
        $('.select2').select2();
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function ajaxRequest(Method, url, callBack) {
    $.ajax({
        type: Method,
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: url,
        cache: false,
        success: function (result) {
//            return result;
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }

    });
}