

function getaAttachmentbyId(id, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/epl/inspection/attach/id/" + id,
        data: null,
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

function iterateSavedImages(url_list,file_url) {
    let content = '';
    if (url_list.length == 0 || url_list == undefined) {
        content = '';
    } else {
        $.each(url_list, function (index, value) {
            content += '<div>';
            content += '<div class="thumbnail attachment_image"><a href="javascript:void(0)" class="delete_attachment" data-attachment_id="' + value.id + '">';
            content += '<img src="/dist/img/delete-icon.png" alt="" style="width:32px; height:32px;"></a>';
            content += '<a href="' + file_url + value.path + '"  data-title="' + value.id + '" data-fancybox="attachments">';
            content += '<div class="m-3" style="width: 120px; height:120px; background-size: cover; background-image:url(' + file_url + value.path + ')"></div>';
            content += '</a>';
            content += '</div>';
            content += '</div>';
        });
    }
    $('#image_row').html(content);
}

function readImage(selected_id, callback) {
    var img = document.getElementById(selected_id);

    if (img.files && img.files[0]) {
        var FR = new FileReader();

        FR.addEventListener("load", function (e) {
            //   document.getElementById("b64").innerHTML = e.target.result;
            callback(e.target.result);
        });
        FR.readAsDataURL(img.files[0]);
    } else {
        return false;
        //        alert("No Image");
    }
}

function save_Attachment(id, data, callBack) {
    let url = "/api/epl/inspection/attach/id/" + id;
    if (!data || data.length == 0) {
        return false;
    }
    submitDataWithFile(url, data, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(resp);
        }
    });
}

function remove_Image(attachment_id, callBack) {
    $.ajax({
        type: "POST",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/epl/inspection/attach/delete/id/" + attachment_id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (result.id == 1) {
                Toast.fire({
                    type: 'success',
                    title: 'Enviremontal MS</br>Attachment Succuessfully Removed !'
                });
            } else {
                Toast.fire({
                    type: 'error',
                    title: result.message
                });
            }
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}
