//data = new FormData();
//data.append('file', $('#file')[0].files[0]);

function ulploadFile(URL, file) {
    $.ajax({
        xhr: function () {
            var xhr = new window.XMLHttpRequest();

            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    console.log(percentComplete);

                    if (percentComplete === 100) {

                    }

                }
            }, false);

            return xhr;
        },
        url: URL,
        type: "POST",
        data: JSON.stringify(file),
        contentType: "application/json",
        dataType: "json",
        success: function (result) {
            console.log(result);
        }
    });
}
function ulploadFile2(URL, formData, callBack) {
//    let formData = new FormData();
//    // populate fields
//    let title = $('#title').val();
//    let serial_no = $('#serial_no').val();
//    let image1 = $('#image1')[0].files[0];// file
//    let image2 = $('#image2')[0].files[0];// file
//    formData.append('title', title);
//    formData.append('serial_no', serial_no);
//    formData.append('image1', image1);
//    formData.append('image2', image2);
//    console.log(URL);
//    return false;
    // send form data
    $.ajax({
        type: 'POST',
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: URL,
        data: formData,
        contentType: false,
        processData: false
    }).done(function (response) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    }).fail(function (data) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}