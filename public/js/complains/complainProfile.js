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

function loadProfileData() {
    let id = $('#complain_profile_id').val();
    let url = '/api/complain_profile_data/id/' + id;
    ajaxRequest('GET', url, null, function(resp) {

        $('#comp_code').html(resp.complainer_code);
        if (resp.assigned_user != null) {
            $('#assigned_officer').html(resp.assigned_user.user_name);
        } else {
            $('#assigned_officer').html('N/A');
        }
        if (resp.created_user != null) {
            $('#created_user').html(resp.created_user.user_name);
        } else {
            $('#created_user').html('N/A');
        }
        $('#comp_name').html(resp.complainer_name);
        $('#comp_address').html(resp.complainer_address);
        $('#comp_contact_no').html(resp.comp_contact_no);
        $('#comp_desc').html(resp.complain_des);
        if (resp.comp_status == 1) {
            $('#comp_status_completed').removeClass('d-none');
        } else {
            $('#comp_status_pending').removeClass('d-none');
        }
        let image = '';
        if (resp.attachment != null || resp.attachment.length != 0) {
            let data = JSON.parse(unescape(resp.attachment));
            // let base_url = "{{ url('/') }}";
            $.each(data, function(key, value) {
                image += "<img src='/storage/" + value.img_path + "' width='100em' height='100em'>";
            });

            $('#file_attachments').html(image);
        }

        if (resp.complain_comments != '') {
            let comments = '';
            $.each(resp.complain_comments, function(key, value2) {
                comments += '<div class="alert alert-info w-100" role="alert"><b>' + value2.comment + '</b></div>';
            });
            $('#comment_section').html(comments);
        }

        if (resp.complain_minutes != '') {
            let minutes = '';
            $.each(resp.complain_minutes, function(key, value2) {
                minutes += '<div class="alert alert-info w-100" role="alert"><b>' + value2.minute + '</b></div>';
            });
            $('#minute_section').html(minutes);
        }

        $('#assigned_user').html(resp.assigner_user.first_name + ' ' + resp.assigner_user.last_name);

        let forward_hist_table = "";
        $.each(resp.complain_assign_log, function(key, value2) {
            key++;
            forward_hist_table += "<tr><td>" + key + "</td><td>" + value2.assignee_id + "</td><td>" + value2.assigner_id + "</td><td>" + value2.assigned_time + "</td></tr>";
        });
        $('#forward_history tbody').html(forward_hist_table);
    });
}

function load_user_by_level(level) {
    ajaxRequest('GET', "/api/get_users_for_level/level/" + level, null, function(dataSet) {
        var combo = "";
        if (dataSet.length == 0) {
            combo += "<option value=''>NO DATA FOUND</option>";
        } else {
            $.each(dataSet, function(index, value) {
                combo += "<option value='" + value.id + "'>" + value.first_name + " - (" + value.name + ") </option>";
            });
        }
        $('#user').html(combo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}

function forms_reset() {
    $('#comments_frm')[0].reset();
    $('#minutes_frm')[0].reset();
    $('#complain_assign_frm')[0].reset();
}

function assign_user_to_complain(complain_id, user_id) {
    ajaxRequest('GET', "/api/assign_complain_to_user/complain_id/" + complain_id + "/user_id/" + user_id, null, function(result) {
        if (result.status == 1) {
            swal.fire('success', 'Successfully assigned the user to the complain', 'success');
            forms_reset();
            loadProfileData();
        } else {
            swal.fire('failed', 'User assigning was unsuccessful', 'warning');
        }
    });
}

function comment_on_complain() {
    let data = $('#comments_frm').serializeArray();
    ajaxRequest('POST', "/api/comment_on_complain", data, function(result) {
        if (result.status == 1) {
            swal.fire('success', 'Successfully added the comment', 'success');
            forms_reset();
            loadProfileData();
        } else {
            swal.fire('failed', 'Comment addition was unsuccessful', 'warning');
        }
    });
}

function add_minute_to_complain() {
    let data = $('#minutes_frm').serializeArray();
    ajaxRequest('POST', "/api/minute_on_complain", data, function(result) {
        if (result.status == 1) {
            swal.fire('success', 'Successfully added the minute', 'success');
            forms_reset()
            loadProfileData();
        } else {
            swal.fire('failed', 'minute addition was unsuccessful', 'warning');
        }
    });
}

function confirm_complain(complain_id) {
    ajaxRequest('GET', "/api/confirm_complain/complain/" + complain_id, null, function(result) {
        if (result.status == 1) {
            swal.fire('success', 'Successfully confirmed the complain', 'success');
        } else {
            swal.fire('failed', 'Complain confirmation was unsuccessful', 'warning');
        }
    });
}

function reject_complain(complain_id) {
    ajaxRequest('GET', "/api/reject_complain/complain/" + complain_id, null, function(result) {
        if (result.status == 1) {
            swal.fire('success', 'Successfully rejected the complain', 'success');
        } else {
            swal.fire('failed', 'Complain rejection was unsuccessful', 'warning');
        }
    });
}