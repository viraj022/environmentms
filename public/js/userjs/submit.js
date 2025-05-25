// alert('linked');


function assignPrivilegesToRolls(callBack) {
    var data = {
        roll_id: $('#rollCombo').val(),
        pre: []
    }

    var table = $(".assignedPrivilages tbody tr");
    $.each(table, function (key, value) {

        var pre = {
            id: value.id.substring(3),
            is_read: 0,
            is_create: 0,
            is_update: 0,
            is_delete: 0
        }
        pre.is_read = ($(value).find('.read').prop('checked') ? 1 : 0);
        pre.is_create = ($(value).find('.write').prop('checked') ? 1 : 0);
        pre.is_update = ($(value).find('.update').prop('checked') ? 1 : 0);
        pre.is_delete = ($(value).find('.delete').prop('checked') ? 1 : 0);
        if (pre.is_read == true || pre.is_create == true || pre.is_update == true || pre.is_delete == true) {
            data.pre.push(pre);
        }
    });
    // alert(JSON.stringify(data));
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "api/rolls/privilege/add",
        data: data,
        contentType: 'text/json',
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

function assignPrivilegesToUser(id, callBack) {
    // update user privileges

    var data = {
        user_id: id,
        role: $('.roleCombo').val(),
        pre: []
    }

    var table = $(".assignedPrivilages tbody tr");
    $.each(table, function (key, value) {

        var pre = {
            id: value.id.substring(3),
            is_read: 0,
            is_create: 0,
            is_update: 0,
            is_delete: 0
        }
        pre.is_read = ($(value).find('.read').prop('checked') ? 1 : 0);
        pre.is_create = ($(value).find('.write').prop('checked') ? 1 : 0);
        pre.is_update = ($(value).find('.update').prop('checked') ? 1 : 0);
        pre.is_delete = ($(value).find('.delete').prop('checked') ? 1 : 0);
        if (pre.is_read == true || pre.is_create == true || pre.is_update == true || pre.is_delete == true) {
            data.pre.push(pre);
        }
    });
    // alert(JSON.stringify(data));
    $.ajaxSetup({
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },

    });
    $.ajax({
        type: "GET",
        url: "/api/user/privilege/add/" + id,
        data: data,
        contentType: 'text/json',
        dataType: "json",
        cache: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
    });
}

function changeAciveStatus(id, data, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/user/activity/" + id,
        data: data,
        contentType: 'text/json',
        dataType: "json",
        cache: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack();
            }
        }
    });
}
function deleteRole(id, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/rolls/rollId/" + id,
        cache: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}
function updateRole(id, data, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        data: data,
        url: "/api/rolls/rollId/" + id,
        cache: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}

function activeDeletedUser(id, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },

        url: "/api/user/active/" + id,
        cache: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }

            if (result.id == 1) {
                location.reload();
            }


        }
    });
}
