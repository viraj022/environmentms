function ajaxRequest(Method, url, data, callBack) {
    $.ajax({
        type: Method,
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: url,
        data: data,
        cache: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (jqXHR, exception) {
            console.log(jqXHR.responseJSON.message);
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Failed To Connect. Please Verify Your Network Connection.';
            } else if (jqXHR.status == 401) {
                msg = 'You Dont Have Privilege To Performe This Action!';
            } else if (jqXHR.status == 422) {
                msg = 'Validation Error ! \n';
                $.each(jqXHR.responseJSON.errors, function (key, value) {
                    msg += value + '\n';
                });
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
                msg = 'Uncaught Error.\n' + jqXHR.responseJSON.message;
            }
            //            Toast.fire({
            //                type: 'error',
            //                title: 'Error</br>' + msg
            //            });
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(msg);
            }
        }
    });
}

function submitDataWithFile(url, frmDta, callBack, metod = false) {
    let formData = new FormData();
    // populate fields
    $.each(frmDta, function (k, val) {
        formData.append(k, val);
    });
    ulploadFile2(url, formData, function (result) {
        if (typeof callBack !== 'undefined' && callBack !== null && typeof callBack === "function") {
            callBack(result);
        }
    }, metod);
}

function show_mesege(resp_id) {
    console.log(resp_id);
    if (resp_id.id == 1) {
        Swal.fire({
            type: 'success',
            title: 'Envirmontal MS</br>Success!'
        });
    } else {
        let message = '';
        if (resp_id.message != undefined || resp_id.message != null || resp_id.message != '') {
            message = resp_id.message;
        }
        Swal.fire({
            type: 'error',
            title: 'Enviremontal MS</br>' + message
        });
    }
}
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000

});
