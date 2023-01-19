$("#invoice_date").val(new Date().toJSON().slice(0, 10));
//load payment types
function loadPaymentTypes(callback) {
    ajaxRequest("get", "/cashier/payment_types", null, function (response) {
        let options = "";

        $.each(response, function (index, value) {
            options +=
                `<option value="` + value.id + `">` + value.name + `</option>`;
        });
        $("#payment_type").html(options);

        if (typeof callback == "function") {
            callback();
        }
    });
}

//load payments by payment type
function loadPaymentsByPaymentTypes(callback) {
    let payment_type = $("#payment_type").val();

    ajaxRequest(
        "get",
        "/cashier/payments-by-type/" + payment_type,
        null,
        function (response) {
            let options = `<option value="">Select category</option>`;

            $.each(response, function (index, value) {
                options += `<option value="${value.id}" data-price="${value.amount}" data-name="${value.name}"> ${value.name} </option>`;
            });
            $("#category").html(options);

            if (typeof callback == "function") {
                callback();
            }
        }
    );
}

//load payment price by payments
function loadPaymentPrice() {
    let price = $("#category option:selected").data("price");
    $("#price").val(price);
}

$("#payment_type").change(loadPaymentsByPaymentTypes);
$("#category").change(loadPaymentPrice);

//get total amount
function total() {
    let price = $("#category option:selected").data("price");
    let total = price * $("#qty").val();
    $("#price").val(total.toFixed(2));
}

$("#qty").change(total);
