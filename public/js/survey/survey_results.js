function save_survey_val(obj, callBack) {
    // alert(JSON.stringify(obj));
    var url = '';
    url = "/api/survey/result";
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: url,
        data: { "data": obj },
        cache: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}


function iterate_results_form(attribute_id, callBack) {
    var tbl = '';
    var ret_obj = {};
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/survey/attrpram_map/attr_option/" + attribute_id,
        cache: false,
        success: function (result) {
            if (result.length == 0) {
                tbl += '<tr><td>No Data Available</td></tr>';
            }
            $.each(result, function (index, row) {
                ret_obj[row.id] = '';
                var input = '';
                if (row.type == 'SELECTED') {
                    input += '<select class="form-control in_val" data-row_id="' + row.id + '" id="v_' + row.id + '">';
                    $.each(row.survey_values, function (index, op) {
                        input += '<option value="' + op.id + '">' + op.name + '</option>';
                    });
                    input += '</select>';
                } else if (row.type == 'DATE') {
                    input = '<input type="date" class="form-control in_val" placeholder="" data-row_id="' + row.id + '"  id="v_' + row.id + '" value="">';
                } else if (row.type == 'NUMERIC') {
                    input = '<input type="number" class="form-control in_val" placeholder="" data-row_id="' + row.id + '"  id="v_' + row.id + '" value="">';
                } else {
                    input = '<input type="text" class="form-control in_val" placeholder="" data-row_id="' + row.id + '"  value="" id="v_' + row.id + '">';
                }
                var tbl_rw = '<div class="form-group"><label>' + row.param_name + ':</label>' + input + '</div>';
                tbl += '<tr><td>' + tbl_rw + '</td></tr>';
            });
            $('#sur_resTbl tbody').html(tbl);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(ret_obj);
            }
        }
    });
}

function load_attrCombo(title_id, callBack) {
    var cbo = '';
    //    alert('asdasd');
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/survey/attribute/title/id/" + title_id,
        cache: false,
        success: function (result) {
            $.each(result, function (index, row) {
                cbo += '<option value="' + row.id + '">' + row.name + '</option>';
            });
            $('.attr_cbo').html(cbo);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
    });
}
function load_titleCombo(callBack) {
    var cbo = '';
    //    alert('asdasd');
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/survey/titles",
        cache: false,
        success: function (result) {
            $.each(result, function (index, row) {
                cbo += '<option value="' + row.id + '">' + row.name + '</option>';
            });
            $('.title_cbo').html(cbo);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
    });
}

//function remove_survData(foc, del_id, callBack) {
//    var url = "";
//    switch (foc) {
//        case 'title_t':
//            url = "/api/survey/title/id/";
//            break;
//        case 'param_t':
//            url = "/api/survey/parameter/id/";
//            break;
//        case 'attr_t':
//            url = "/api/survey/attribute/id/";
//            break;
//        case 'custom-tabs-two-messages-tab':
//            url = "/api/survey/value/id/";
//            break;
//        case 'param_type_t':
//            url = "/api/survey/attrpram_map/id/";
//            break;
//    }
//    $.ajax({
//        type: "DELETE",
//        headers: {
//            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
//            "Accept": "application/json"
//        },
////        url: "/api/survey/title/id/" + title_id,
//        url: url + del_id,
////        data: {"survey_title_name": "dddd", "survey_title_status":1},
//        cache: false,
//        success: function (result) {
//            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//                callBack(result);
//            }
//        }
//    });
//}
