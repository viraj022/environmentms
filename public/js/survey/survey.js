function save_survey(foc, obj, callBack) {
    // alert('asdasd');
    var url = '';
    switch (foc) {
        case 'title_t':
            url = "/api/survey/title";
            break;
        case 'param_t':
            url = "/api/survey/parameter";
            break;
        case 'attr_t':
            url = "/api/survey/attribute";
            break;
        case 'sel_value':
            url = "/api/survey/value";
            break;
        case 'param_type_t':
            url = "/api/survey/attrpram_map";
            break;
    }
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: url,
        data: obj,
        //        contentType: 'text/json',
        //        dataType: "json",
        cache: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}


function load_titleTable(callBack) {
    var tbl = '';
    //    alert('asdasd');
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/survey/titles",
        //        data: {"survey_title_name": "dddd", "survey_title_status":1},
        //        contentType: 'text/json',
        //        dataType: "json",
        cache: false,
        success: function (result) {
            $.each(result, function (index, row) {
                tbl += '<tr><td>' + ++index + '</td><td>' + row.name + '</td><td><button type="button" data-row="' + encodeURIComponent(JSON.stringify(row)) + '"  value="' + row.id + '" class="btn btn-dark">Select</button></td></tr>';
                // do something with `item` (or `this` is also `item` if you like)
            });
            $('#title_table tbody').html(tbl);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
    });
}
function load_paramTable(title_id, callBack) {
    //    alert(title_id);
    $('#param_table tbody').html('');
    if (isNaN(title_id)) {
        return false;
    }
    var tbl = '';
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/survey/parameter/title/id/" + title_id,
        //        data: {"survey_title_name": "dddd", "survey_title_status":1},
        //        contentType: 'text/json',
        //        dataType: "json",
        cache: false,
        success: function (result) {
            $.each(result, function (index, row) {
                tbl += '<tr><td>' + ++index + '</td><td>' + row.name + '</td><td><button type="button" data-row="' + encodeURIComponent(JSON.stringify(row)) + '"  value="' + row.id + '" class="btn btn-dark">Select</button></td></tr>';
                // do something with `item` (or `this` is also `item` if you like)
            });
            $('#param_table tbody').html(tbl);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
    });
}
function load_attributeTable(title_id, callBack) {
    $('#attribute_table tbody').html('');
    if (isNaN(title_id)) {
        return false;
    }
    var tbl = '';
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/survey/attribute/title/id/" + title_id,
        //        data: {"survey_title_name": "dddd", "survey_title_status":1},
        //        contentType: 'text/json',
        //        dataType: "json",
        cache: false,
        success: function (result) {
            $.each(result, function (index, row) {
                tbl += '<tr><td>' + ++index + '</td><td>' + row.name + '</td><td><button type="button" data-row="' + encodeURIComponent(JSON.stringify(row)) + '"  value="' + row.id + '" class="btn btn-dark">Select</button></td></tr>';
                // do something with `item` (or `this` is also `item` if you like)
            });
            $('#attribute_table tbody').html(tbl);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
    });
}
//function load_attr_valTable(callBack) {
//    var tbl = '';
////    alert('asdasd');
//    $.ajax({
//        type: "GET",
//        headers: {
//            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
//            "Accept": "application/json"
//        },
//        url: "/api/survey/values",
////        data: {"survey_title_name": "dddd", "survey_title_status":1},
////        contentType: 'text/json',
////        dataType: "json",
//        cache: false,
//        success: function (result) {
//            $.each(result, function (index, row) {
//                tbl += '<tr><td>' + ++index + '</td><td>' + row.name + '</td><td><button type="button" data-row="' + encodeURIComponent(JSON.stringify(row)) + '"  value="' + row.id + '" class="btn btn-dark">Select</button></td></tr>';
//                // do something with `item` (or `this` is also `item` if you like)
//            });
//            $('#attr_val_table tbody').html(tbl);
//            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//                callBack();
//            }
//        }
//    });
//}
function load_attr_param_Table(attribute_id, callBack) {
    var tbl = '';
    //    alert('asdasd');
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        //        url: "/api/survey/parameter/assigned/title_id/" + titleId + "/attribute_id/" + attribute_id,
        url: "/api/survey/attrpram_map/attr/" + attribute_id,
        //        data: {"survey_title_name": "dddd", "survey_title_status":1},
        //        contentType: 'text/json',
        //        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.length == 0) {
                tbl += '<tr><td>No Data Available</td></tr>';
            }
            $.each(result, function (index, row) {
                if (row.type == 'SELECTED') {
                    tbl += '<tr><td>' + ++index + '</td><td>' + row.param_name + '</td><td>' + row.type + '</td><td><button type="button" data-toggle="modal"  data-target="#modal-lg" data-row="' + encodeURIComponent(JSON.stringify(row)) + '"  value="' + row.id + '" class="btn btn-default val_sel"><i class="fa fa-plus"></i></button><button type="button" data-row="' + encodeURIComponent(JSON.stringify(row)) + '" value="' + row.id + '" class="btn btn-dark">Select</button></td></tr>';
                } else {
                    tbl += '<tr><td>' + ++index + '</td><td>' + row.param_name + '</td><td>' + row.type + '</td><td><button type="button" data-row="' + encodeURIComponent(JSON.stringify(row)) + '"  value="' + row.id + '" class="btn btn-dark">Select</button></td></tr>';
                }

            });
            $('#attr_param_val_table tbody').html(tbl);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
    });
}
function gen_priv(titleId) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "text/html"
        },
        url: "/api/survey/attrpram_map/table/id/" + titleId, cache: false,
        success: function (result) {
            $('#sur_privTbl').html(result);
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
function load_avl_paramCombo(title_id, attr_id, callBack) {
    var cbo = '';
    //    alert('asdasd');
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/survey/parameter/unassigned/title_id/" + title_id + "/attribute_id/" + attr_id,
        cache: false,
        success: function (result) {
            if (result.length == 0) {
                cbo += '<option>-No Data Available-</option>';
            } else {
                $.each(result, function (index, row) {
                    cbo += '<option value="' + row.id + '">' + row.name + '</option>';
                });
            }
            $('.avl_param_cmb').html(cbo);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
    });
}
function load_attr_valCombo(attr_id, callBack) {
    var cbo = '';
    $('.attr_val_cmb').html(cbo);
    //    alert('asdasd');
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/survey/values/id/" + attr_id,
        //        url: "/api/survey/values/" + attr_id,
        cache: false,
        success: function (result) {
            if (result.length == 0) {
                cbo += '<option>-No Data Available-</option>';
            } else {
                $.each(result, function (index, row) {
                    cbo += '<option value="' + row.id + '">' + row.name + '</option>';
                });
            }
            $('.attr_val_cmb').html(cbo);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
    });
}

//function load_attr_types(callBack) {
//    var cbo = '';
////    alert('asdasd');
//    $.ajax({
//        type: "GET",
//        headers: {
//            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
//            "Accept": "application/json"
//        },
//        url: "/api/survey/attribute/types",
//        cache: false,
//        success: function (result) {
//            $.each(result, function (index, row) {
//                cbo += '<option value="' + row.id + '">' + row.name + '</option>';
//            });
//            $('.attr_type_cbo').html(cbo);
//            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//                callBack();
//            }
//        }
//    });
//}



function remove_survData(foc, del_id, callBack) {
    var url = "";
    switch (foc) {
        case 'title_t':
            url = "/api/survey/title/id/";
            break;
        case 'param_t':
            url = "/api/survey/parameter/id/";
            break;
        case 'attr_t':
            url = "/api/survey/attribute/id/";
            break;
        case 'sel_value':
            url = "/api/survey/value/id/";
            break;
        case 'param_type_t':
            url = "/api/survey/attrpram_map/id/";
            break;
    }
    $.ajax({
        type: "DELETE",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        //        url: "/api/survey/title/id/" + title_id,
        url: url + del_id,
        //        data: {"survey_title_name": "dddd", "survey_title_status":1},
        cache: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}
