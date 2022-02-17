function update_attachments() {
    let id = $('#complain_profile_id').val();
    let url = '/api/update_attachments/id/' + id;
    let arr = [];
    let index = 0;
    $.each($('#fileUploadInput')[0].files, function(key, val) {
        arr[index++] = val;
    });
    ulploadFileWithData(url, null, function(resp) {
        if (resp.status == 1) {
            loadProfileData();
            swal.fire('success', 'Successfully change the attachments of complains', 'success');
        } else {
            swal.fire('failed', 'Complain attachments change is unsuccessful', 'warning');
        }
    }, false, arr);
}

function load_user_by_level(level) {
    ajaxRequest('GET', "/api/get_users_for_level/level/" + level, null, function(dataSet) {
        var combo = "";
        if (dataSet.length == 0) {
            combo += "<option value=''>NO DATA FOUND</option>";
        } else {
            $.each(dataSet, function(index, value) {
                combo += "<option value='" + value.id + "'>" + value.first_name + ' ' + value.last_name + "</option>";
            });
        }
        $('#user').html(combo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}

function assign_user_to_complain(complain_id, user_id, callBack) {
    ajaxRequest('GET', "/api/assign_complain_to_user/complain_id/" + complain_id + "/user_id/" + user_id, null, function(result) {
        if (result.status == 1) {
            swal.fire('success', 'Successfully assigned the user to the complain', 'success');
        } else {
            swal.fire('failed', 'User assigning was unsuccessfull', 'warning');
        }

        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}

function load_assigned_user(complain_id) {
    alert(complain_id);
    ajaxRequest('GET', "/api/get_assigned_user/id/" + complain_id, null, function(result) {
        if (result.status == 1) {
            $('#assigned_user').val();
        }
    });
}