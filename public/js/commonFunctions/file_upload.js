function ulploadFile2(URL, formData, callBack, metod = false) {
    if (!metod) {
        metod = 'POST';
    }
    /*
     let formData = new FormData();
     // populate fields
     let image1 = $('#image1')[0].files[0];// file
     formData.append('title', title);
     formData.append('image1', image1);
     return false;
     */
    // send form data
    $.ajax({
        type: metod,
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    $('.progress').removeClass('d-none');
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    let bar_width = percentComplete + '%';
                    $('.Uploadprogress').width(bar_width);
                    if (percentComplete === 100) {
                        $('.progress').addClass('d-none');
                    }
                }
            }, false);
            return xhr;
        },
        url: URL,
        data: formData,
        contentType: false,
        processData: false
    }).done(function(response) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(response);
        }
    }).fail(function(jqXHR, exception) {
        let msg = responseMsg(jqXHR, exception);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(msg);
        }
    });
}

function ulploadFileWithData(URL, dataArray, callBack, metod = false, file_list = []) {

    if (!metod) {
        metod = 'POST';
    }

    let formData = new FormData();
    // populate fields
    $.each(dataArray, function(key, value) {
        formData.append(key, value);
    });
    $.each(file_list, function(key, value) {
        formData.append("file_list[]", value);
    });
    // send form data
    $.ajax({
        type: metod,
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                    $('.progress').removeClass('d-none');
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    let bar_width = percentComplete + '%';
                    $('.Uploadprogress').width(bar_width);
                    if (percentComplete === 100) {
                        $('.progress').addClass('d-none');
                    }
                }
            }, false);
            return xhr;
        },
        url: URL,
        data: formData,
        contentType: false,
        processData: false
    }).done(function(response) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(response);
        }
    }).fail(function(jqXHR, exception) {
        let msg = responseMsg(jqXHR, exception);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(response);
        }
    });
}

function responseMsg(jqXHR, exception) {
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 401) {
        msg = 'You Dont Have Privilege To Performe This Action!';
    } else if (jqXHR.status == 422) {
        msg = 'Validation Error !';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    alert(msg);
    return msg;
}

$("input[type='file']").on("change", function() {
    if (this.files[0].size > 30000000) {
        alert("Please upload file less than 20MB.");
        $(this).val('');
    }
});
