function ajaxRequest(Method, url, data, callBack) {
    $.ajax({
        type: Method,
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: url,
        data: data,
        cache: false,
        success: function (result) {
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}
function loadApplication_types(callBack) {
    var cbo = "";
    ajaxRequest('GET', "/api/application/applicationList", null, function (dataSet) {
        if (dataSet) {
            $.each(dataSet, function (index, row) {
                cbo += '<option value="' + row.id + '" data-amt="' + row.amount + '">' + row.name + '</option>';
            });
        } else {
            cbo = "<option value=''>No Data Found</option>";
        }
        $('#application_combo').html(cbo);
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack();
        }
    });
}
function selectedApplication_table(obj, callBack) {
    var tbl = "";
    if (obj.length == 0) {
        tbl = "<tr><td colspan='5'>No Data Found</td></tr>";
    } else {
        $.each(obj, function (index, row) {
            tbl += '<tr>';
            tbl += '<td>' + ++index + '</td>';
            tbl += '<td>' + row.name + '</td>';
            tbl += '<td>' + row.qty + '</td>';
            tbl += '<td>' + row.amount + '</td>';
            tbl += '<td><button value="' + row.id + '" type="button" class="btn btn-danger app_removeBtn">Remove</button></td>';
            tbl += '</tr>';
        });
    }
    $('#tbl_applications tbody').html(tbl);
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }
}

function paymentDetals_table() {
    let tbl = "";
    ajaxRequest('GET', "/api/application/pendingPayments", null, function (r) {
        if (r.length == 0) {
            tbl = "<tr><td>No data found</td></tr>";
        } else {
            $.each(r, function (index, row) {
//                tbl += '<tr>';
//                tbl += '<td>'+row.+'</td>';
//                tbl += '</tr>';
            });
        }

    });
}

function saveApplicationPayment(data, callBack) {
    if (!data) {
        return false;
    }
    ajaxRequest("POST", "/api/epl/regPayment", data, function (resp) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            resp.name = data.name
            callBack(resp);
        }
    });
}
function show_mesege(resp_id) {
    if (resp_id.message == "true") {
        Toast.fire({
            type: 'success',
            title: 'Envirmontal MS</br>Success!'
        });
    } else {
        Toast.fire({
            type: 'error',
            title: 'Enviremontal MS</br>Error'
        });
    }
}

function set_application_amount() {
    let apl_amt = (isNaN(parseFloat($('#application_combo :selected').data('amt')))) ? '00.00' : parseFloat($('#application_combo :selected').data('amt'));
    $('#amt').val(apl_amt);
}
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000

});