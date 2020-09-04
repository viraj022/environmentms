

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
function iterateSavedImages(url_list) {
    let content = '';
    console.log(url_list);
    if (url_list.length == 0 || url_list == undefined) {
        content = '';
    } else {
        $.each(url_list, function (index, value) {
            content += '<div class="col-sm-2">';
            content += '<a href="/' + value.path + '" data-toggle="lightbox" data-title="' + value.id + '" data-gallery="gallery">';
            content += '<img src="/' + value.path + '" class="img-fluid mb-2" alt="white sample"/>';
            content += '</a>';
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

//function save_Attachment(file_data, ref_id, callBack) {
//    $.ajax({
//        type: "POST",
//        headers: {
//            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
//            "Accept": "application/json"
//        },
//        url: "/api/epl/inspection/attach/id/" + ref_id,
//        data: {file: file_data},
//        dataType: "json",
//        cache: false,
//        processDaate: false,
//        success: function (result) {
//            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//                callBack(result);
//            }
//        },
//        error: function (xhr, textStatus, errorThrown) {
//            alert(textStatus + ':' + errorThrown);
//        }
//    });
//}

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
        type: "DELETE",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/epl/inspection/attach/id/" + attachment_id,
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