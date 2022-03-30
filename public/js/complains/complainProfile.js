function update_attachments() {
    let id = $('#complain_profile_id').val();
    let url = '/api/update_attachments/id/' + id;
    let arr = [];
    let index = 0;
    $.each($('#fileUploadInput')[0].files, function (key, val) {
        arr[index++] = val;
    });
    if (arr.length != 0) {
        ulploadFileWithData(url, null, function (resp) {
            if (resp.status == 1) {
                loadProfileData();
                $('#fileUploadInput').val('');
                $('#attached_files').html('');

                swal.fire('success', 'Successfully change the attachments of complains', 'success');
            } else {
                swal.fire('failed', 'Complain attachments change is unsuccessful', 'warning');
            }
        }, false, arr);
    } else {
        swal.fire('failed', 'One or more images must be selected to upload', 'warning');
    }

}

function loadProfileData(user_id, callBack) {
    let id = $('#complain_profile_id').val();
    let url = '/api/complain_profile_data/id/' + id;
    ajaxRequest('GET', url, null, function (resp) {
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

        if (resp.status == 1) {
            $('#comp_status').addClass('badge bg-success').text('Complete');
        } else if (resp.status == -1) {
            $('#comp_status').addClass('badge bg-danger').text('Rejected');
        } else if (resp.status == 0) {
            $('#comp_status').addClass('badge bg-warning').text('Pending');
        }

        if (resp.status == 1 || resp.status == -1 || resp.status == 4) {
            $('#confirm').addClass('d-none');
            $('#reject').addClass('d-none');
        } else {
            $('#reject').removeClass('d-none');
            $('#confirm').removeClass('d-none');
        }

        if (resp.status != 4 && resp.status != 1 && resp.status != -1) {
            $('#forward_letter_preforation').removeClass('d-none');
        } else {
            $('#forward_letter_preforation').addClass('d-none');
        }

        let last_index = resp.letters.length - 1;

        if (resp.letters[last_index] != null) {
            if (resp.letters[last_index].status == 'COMPLETED' && resp.status != 1 && resp.status != -1) {
                $('#confirm').removeClass('d-none');
            }
        }

        $('#comp_by').html('<span class="badge bg-success">' + resp.complainer_name + '</span>');

        let image = '';
        if (resp.attachment != null || resp.attachment.length != 0 || resp.attachment.file_path != null) {
            let unescaped_data = unescape(resp.attachment);
            if (unescaped_data != '') {
                let data = JSON.parse(unescape(resp.attachment));
                // let base_url = "{{ url('/') }}";
                $.each(data, function (key, value) {
                    let file_path = value.img_path;
                    let file_type = file_path.substr(file_path.indexOf(".") + 1);

                    if (file_type != 'pdf') {
                        if (file_path != '') {
                            image += '<div class="col-3" style="padding: 7.5px 7.5px 7.5px 7.5px; height: 300px;text-align: center; margin-top: 2%;background-color: #e7e3e3;"><img src="/storage/' + file_path + '" class="img-fluid" alt="" style="width: auto; height: 200px; max-width: 384px;"><hr> <button type="button" data-name="' + file_path + '" class="btn btn-danger remove_attach">Remove</button> <a class="btn btn-primary m-1" href="/storage/' + file_path + '" target="blank">View</a></div>';
                        }
                    } else {
                        if (file_path != '') {
                            image += '<div class="col-3" style="padding: 7.5px 7.5px 7.5px 7.5px; height: 300px;text-align: center; margin-top: 2%;background-color: #e7e3e3;"><embed  src="/storage/' + file_path + '" class="img-fluid" alt="" style="width: auto; height: 200px; max-width: 384px;"><hr> <button type="button" data-name="' + file_path + '" class="btn btn-danger remove_attach">Remove</button> <a class="btn btn-primary m-1" href="/storage/' + file_path + '" target="blank">View</a></div>';
                        }
                    }

                });

                $('#file_attachments').html(image);
            }
        }

        if (resp.complain_comments != '') {
            iterateComplain_comments(resp.complain_comments, user_id);
        }

        if (resp.complain_minutes != '') {
            iterateComplain_minit(resp.complain_minutes, user_id);
        }
        let assigned_user = 'Not Assigned';
        if (resp.assigned_user != null) {
            assigned_user = resp.assigned_user.first_name + ' ' + resp.assigned_user.last_name;
        }
        $('#assigned_user').html(assigned_user);
    });
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}

function iterateComplain_minit(object, user_id) {
    let minute = '';
    $.each(object, function (key, value2) {
        let chat_msg = (value2.minute_user.id == user_id) ? 'right' : '';
        let chat_name = (value2.minute_user.id == user_id) ? 'float-right' : 'float-left';
        let chat_time = (value2.minute_user.id == user_id) ? 'float-left' : 'float-right';
        minute += `<div class="direct-chat-msg ${chat_msg}"><div class="direct-chat-infos clearfix">
                <span class="direct-chat-name ${chat_name}">${value2.minute_user.first_name} ${value2.minute_user.last_name}</span>
                <span class="direct-chat-timestamp ${chat_time}">${value2.created_at}</span>
            </div>
            <img class="direct-chat-img" src="/dist/img/user1-128x128.jpg" alt="Message User Image">
            <div class="direct-chat-text">${value2.minute}</div>
        </div>`;
    });
    $('.minute_section').html(minute);
}

function iterateComplain_comments(object, user_id) {
    let comments = '';
    $.each(object, function (key, value2) {
        let chat_msg = (value2.commented_user.id == user_id) ? 'right' : '';
        let chat_name = (value2.commented_user.id == user_id) ? 'float-right' : 'float-left';
        let chat_time = (value2.commented_user.id == user_id) ? 'float-left' : 'float-right';
        comments += `<div class="direct-chat-msg ${chat_msg}"><div class="direct-chat-infos clearfix">
                <span class="direct-chat-name ${chat_name}">${value2.commented_user.first_name} ${value2.commented_user.last_name}</span>
                <span class="direct-chat-timestamp ${chat_time}">${value2.created_at}</span>
            </div>
            <img class="direct-chat-img" src="/dist/img/user1-128x128.jpg" alt="Message User Image">
            <div class="direct-chat-text">${value2.comment}</div>
        </div>`;
    });
    $('.comment_section').html(comments);
}

function load_forward_history_table(complain_id) {

    let url = '/api/complain_log_data/complain/' + complain_id;

    ajaxRequest('GET', url, null, function (resp) {
        var forward_hist_table = " ";
        $('#forward_history').DataTable().destroy();
        $.each(resp, function (key, value2) {
            key++;
            let assignee_name = '-';
            let assigner_name = '-';

            if (value2['assignee_user'] != null) {
                assignee_name = value2['assignee_user'].first_name + " " + value2['assignee_user'].last_name;
            }
            if (value2['assigner_user'] != null) {
                assigner_name = value2['assigner_user'].first_name + " " + value2['assigner_user'].last_name;
            }
            forward_hist_table += "<tr><td>" + key + "</td><td>" + assignee_name + "</td><td>" + assigner_name + "</td><td>" + value2.assigned_time + "</td></tr>";
        });
        $('#forward_history tbody').html(forward_hist_table);
        $('#forward_history').DataTable({
            "pageLength": 5,
            "bDestroy": true,
            "iDisplayLength": 10,
            "bLengthChange": false,
            "searching": false
        });
    });

}

function load_user_by_level(level) {
    ajaxRequest('GET', "/api/get_users_for_level/level/" + level, null, function (dataSet) {
        var combo = "";
        if (dataSet.length == 0) {
            combo += "<option value=''>NO DATA FOUND</option>";
        } else {
            $.each(dataSet, function (index, value) {
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
    ajaxRequest('GET', "/api/assign_complain_to_user/complain_id/" + complain_id + "/user_id/" + user_id, null, function (result) {
        if (result.status == 1) {
            swal.fire('success', 'Successfully assigned the user to the complain', 'success');
            loadProfileData(user_id, function(){
                load_forward_history_table(complain_id);
            });
        } else {
            swal.fire('failed', 'User assigning was unsuccessful', 'warning');
        }
    });
}

function comment_on_complain(data) {
    if (data.comment != '') {
        ajaxRequest('POST', "/api/comment_on_complain", data, function (result) {
            if (result.status == 1) {
                swal.fire('success', 'Successfully added the comment', 'success');
                $('#comment').val('');
                loadProfileData(data.user_id);
            } else {
                swal.fire('failed', 'Comment addition was unsuccessful', 'warning');
            }
        });
    } else {
        swal.fire('failed', 'Comment cannot be empty!', 'warning');
    }
}

function add_minute_to_complain(data) {
    if (data.minute != '') {
        ajaxRequest('POST', "/api/minute_on_complain", data, function (result) {
            if (result.status == 1) {
                swal.fire('success', 'Successfully added the minute', 'success');
                $('#minute').val('');
                loadProfileData(data.user_id);
            } else {
                swal.fire('failed', 'minute addition was unsuccessful', 'warning');
            }
        });
    } else {
        swal.fire('failed', 'Minute cannot be empty!', 'warning');
    }
}

function confirm_complain(complain_id) {
    ajaxRequest('GET', "/api/confirm_complain/complain/" + complain_id, null, function (result) {
        if (result.status == 1) {
            swal.fire('success', 'Successfully confirmed the complain', 'success');
            loadProfileData();
        } else {
            swal.fire('failed', 'Complain confirmation was unsuccessful', 'warning');
        }
    });
}

function reject_complain(complain_id) {
    ajaxRequest('GET', "/api/reject_complain/complain/" + complain_id, null, function (result) {
        if (result.status == 1) {
            swal.fire('success', 'Successfully rejected the complain', 'success');
            loadProfileData();
        } else {
            swal.fire('failed', 'Complain rejection was unsuccessful', 'warning');
        }
    });
}

function forward_letter_preforation(complain_id) {
    ajaxRequest('GET', "/api/forward_to_letter_preforation/complain/" + complain_id, null, function (result) {
        if (result.status == 1) {
            swal.fire('success', 'Forward to letter preforation was successful', 'success');
            loadProfileData();
        } else {
            swal.fire('failed', 'Forward to letter preforation was unsuccessful', 'warning');
        }
    });
}

function load_file_no() {
    ajaxRequest('GET', "/api/load_file_no", null, function (dataSet) {
        var combo = "";
        if (dataSet.length == 0) {
            combo += "<option value=''>NO DATA FOUND</option>";
        } else {
            $.each(dataSet, function (index, value) {
                combo += "<option value='" + value.id + "'>" + value.file_no + "</option>";
            });
        }
        $('#client_id').html(combo);
        $('.select2').select2();

        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}

function assign_file_no(complain_id, client_id) {
    let data = {
        "id": complain_id,
        "client_id": client_id,
    };
    let url = '/api/assign_file_no';
    ajaxRequest('POST', url, data, function (resp) {
        if (resp.status == 1) {
            swal.fire('success', 'File No has assigned for the complain', 'success');
        } else {
            swal.fire('failed', 'File No assignment for the complain was unsuccessful', 'warning');
        }
    });
}
