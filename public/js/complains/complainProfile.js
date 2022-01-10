
function update_attachments() {
    let id = $('#complain_profile_id').val();
    let url = '/api/update_attachments/id/' + id;
    let arr = [];
    let index = 0;
    $.each($('#fileUploadInput')[0].files, function (key, val) {
        arr[index++] = val;
    });
    ulploadFileWithData(url, null, function (resp) {
        if (resp.status == 1) {
            loadProfileData();
            swal.fire('success', 'Successfully change the attachments of complains', 'success');
        } else {
            swal.fire('failed', 'Complain attachments change is unsuccessful', 'warning');
        }
    }, false, arr);
}