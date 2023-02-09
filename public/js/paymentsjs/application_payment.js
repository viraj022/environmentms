function loadApplication_types(callBack) {
    var cbo = "";
    ajaxRequest(
        "GET",
        "/api/application/applicationList",
        null,
        function (dataSet) {
            if (dataSet) {
                $.each(dataSet, function (index, row) {
                    cbo +=
                        '<option value="' +
                        row.id +
                        '" data-amt="' +
                        row.amount +
                        '">' +
                        row.name +
                        "</option>";
                });
            } else {
                cbo = "<option value=''>No Data Found</option>";
            }
            $("#application_combo").html(cbo);
            if (
                typeof callBack !== "undefined" &&
                callBack != null &&
                typeof callBack === "function"
            ) {
                callBack();
            }
        }
    );
}
function selectedApplication_table(obj, callBack) {
    var tbl = "";
    if (obj.length == 0) {
        tbl = "<tr><td colspan='5'>No Data Found</td></tr>";
    } else {
        $.each(obj, function (index, row) {
            tbl += "<tr>";
            tbl += "<td>" + ++index + "</td>";
            tbl += "<td>" + row.name + "</td>";
            tbl += "<td>" + row.type + "</td>";
            tbl += "<td>" + row.qty + "</td>";
            tbl += "<td>" + row.amount + "</td>";
            tbl +=
                '<td><button value="' +
                row.id +
                '" type="button" class="btn btn-danger app_removeBtn">Remove</button></td>';
            tbl += "</tr>";
        });
    }
    $("#tbl_applications tbody").html(tbl);
    if (
        typeof callBack !== "undefined" &&
        callBack != null &&
        typeof callBack === "function"
    ) {
        callBack();
    }
}

function paymentDetals_table() {
    loadTable();
}

function saveApplicationPayment(data, callBack) {
    if (!data) {
        return false;
    }
    ajaxRequest("POST", "/api/epl/regPayment", data, function (resp) {
        if (
            typeof callBack !== "undefined" &&
            callBack != null &&
            typeof callBack === "function"
        ) {
            resp.name = data.name;
            callBack(resp);
        }
    });
}

function set_application_amount() {
    let apl_amt = isNaN(
        parseFloat($("#application_combo :selected").data("amt"))
    )
        ? "00.00"
        : parseFloat($("#application_combo :selected").data("amt"));
    $("#amt").val(apl_amt);
}

function loadTable() {
    $("#tbl_pendingpays").dataTable().fnDestroy();
    ajaxRequest(
        "GET",
        "api/application/pendingPayments",
        null,
        function (data) {
            var table = "";
            var id = 1;
            $.each(data, function (index, value) {
                table += "<tr>";
                table += "<td>" + id++ + "</td>";
                table += "<td>" + value.application_client.name + "</td>";
                if (value.application_client.nic == null) {
                    table += "<td>-</td>";
                } else {
                    table += "<td>" + value.application_client.nic + "</td>";
                }
                if (value.application_client.contact_no == null) {
                    table += "<td>-</td>";
                } else {
                    table +=
                        "<td>" + value.application_client.contact_no + "</td>";
                }
                table += "<td>" + value.application_client.created_at + "</td>";
                if (value.status == 0) {
                    let v = encodeURIComponent(JSON.stringify(value));
                    table +=
                        "<td><button value='" +
                        value.id +
                        "' type='button' class='btn btn-danger btn-xs btnRemove'>Delete</button> \
                <button data-row='" +
                        v +
                        "' value='" +
                        value.id +
                        "' type='button' class='btn btn-default printBtn'>\
                <i class='fa fa-barcode'></i></button></td>";
                } else if (value.status == 1) {
                    table +=
                        "<td><button id='getIssuedId' value='" +
                        value.id +
                        "' type='button' class='btn btn-block btn-dark btn-xs btnIssue'>Issue Application</button></td>";
                } else {
                    table += "<td></td>";
                }
                table += "</tr>";
            });
            $("#tbl_pendingpays tbody").html(table);
            $("#tbl_pendingpays").DataTable();
        }
    );
}

function issueApplication(id, callBack) {
    let url = "api/application/process/id/" + id;
    ajaxRequest("PATCH", url, null, function (resp) {
        if (
            typeof callBack !== "undefined" &&
            callBack != null &&
            typeof callBack === "function"
        ) {
            callBack(resp);
        }
    });
}
function deleteIssueApplication(id, callBack) {
    let url = "api/epl/regPayment/id/" + id;
    ajaxRequest("DELETE", url, null, function (resp) {
        if (
            typeof callBack !== "undefined" &&
            callBack != null &&
            typeof callBack === "function"
        ) {
            callBack(resp);
        }
        loadTable();
    });
}
function generateQrCode(params, callBack) {
    console.log(params.code);
    let url = "api/get_barcode/code/" + params.code + "/name/" + params.name;
    ajaxRequest("GET", url, null, function (resp) {
        showQrCode(resp);
        if (
            typeof callBack !== "undefined" &&
            callBack != null &&
            typeof callBack === "function"
        ) {
            callBack(resp);
        }
    });
}
function showQrCode(data) {
    $("#qrImage").html(data.BarCode);
    $("#barcode_id").html(data.BarCodeVal);
    $("#timeStamp").html(data.time);
    $("#Payment_Name").html(data.name);
    $("#qrCode").modal("show");
}
