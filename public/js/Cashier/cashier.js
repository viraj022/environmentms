let vat = Number($("#vatValue").val());
let nbt = Number($("#nbtValue").val());

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

//create new application payment table
$(document).on("click", "#btn_add_new_application_payment", function () {
    var transactions = JSON.parse(
        localStorage.getItem("industry_transactions")
    );
    if (transactions && transactions.length != 0) {
        localStorage.setItem("industry_transactions", "[]"); // clear

        selectedIndustryTransactionRecordsTbl(); // clear table
    }

    var singlePaymentAmount  =  JSON.parse(
        localStorage.getItem("single_transaction_amount")
    );
    if (singlePaymentAmount && singlePaymentAmount.length != 0) {
        localStorage.setItem("single_transaction_amount", "[]"); // clear
    }

    // create if location storage key does not exists
    if (!localStorage.getItem("new_application_transaction_items")) {
        localStorage.setItem("new_application_transaction_items", "[]");
    }

    // get the transaction items data from local storage
    let transactionItems = JSON.parse(
        localStorage.getItem("new_application_transaction_items")
    );

    transactionItems.push({
        payment_type: $("#payment_type").val(),
        payment_cat_name: $("#category option:selected").data("name"),
        amount: $("#price").val(),
        category_id: $("#category").val(),
        qty: $("#qty").val(),
    });

    localStorage.setItem(
        "new_application_transaction_items",
        JSON.stringify(transactionItems)
    );

    // clear tfoot
    $("#industry_payments_tbl tfoot").html("");
    generateNewApplicationTable();
    localStorage.setItem("industry_items_id_list", "[]");
    loadAllIndustryTransactionsTable();
});

//generate payment table
function generateNewApplicationTable() {
    let sub_total = 0;
    let i = 1;
    $("#new_application_payments_tbl tbody").html("");

    var array = JSON.parse(
        localStorage.getItem("new_application_transaction_items")
    );

    $.each(array, function (index, val) {
        if (val) {
            if (val.category_id) {
                $("#new_application_payments_tbl > tbody").append(
                    `<tr><td>${i++}</td><td>${val.payment_cat_name}</td><td>${val.qty
                    }</td>
                <td>${val.amount}</td>
                <td><button type="button" class="btn btn-xs btn-danger btn-delete" 
                    value=` +
                    index +
                    `>Delete</button></td></tr>`
                );
            } else {
                localStorage.setItem("new_application_transaction_items", "[]");
                return false;
            }
        }
        sub_total += Number(val.amount);
    });
    
    $("#sub_total").val(sub_total.toFixed(2));
    calTax();
}

$(document).on("click", ".btn-delete", function (e) {
    if (!confirm("Remove this item?")) {
        return false;
    }

    var items = JSON.parse(
        localStorage.getItem("new_application_transaction_items")
    );
    let rowVal = $(this).val();

    // remove the item at rowVal index
    items.splice(rowVal, 1);

    // set modified items back to the local storage
    localStorage.setItem(
        "new_application_transaction_items",
        JSON.stringify(items)
    );

    // re-generate the table
    generateNewApplicationTable();
});
