//industry transaction add
$(document).on("click", ".btn-old-transaction-add", function () {
    var newApplicationPayments = JSON.parse(
        localStorage.getItem("new_application_transaction_items")
    );
    if (newApplicationPayments && newApplicationPayments.length != 0) {
        localStorage.setItem("new_application_transaction_items", "[]"); // clear
        generateNewApplicationTable();
    }

    var singlePaymentAmount = JSON.parse(
        localStorage.getItem("single_transaction_amount")
    );
    if (singlePaymentAmount && singlePaymentAmount.length != 0) {
        localStorage.setItem("single_transaction_amount", "[]"); // clear
    }

    // create entry for invoice items id list
    if (!localStorage.getItem("industry_items_id_list")) {
        // create new
        localStorage.setItem("industry_items_id_list", "[]");
    }
    // get invoice id list
    let invoiceIdList = JSON.parse(
        localStorage.getItem("industry_items_id_list")
    );

    // create if location storage key does not exists
    if (!localStorage.getItem("industry_transactions")) {
        localStorage.setItem("industry_transactions", "[]");
    }

    // get the transactions data from local storage
    let transactions = JSON.parse(
        localStorage.getItem("industry_transactions")
    );

    var transaction_id = $(this).data("invoice_id");
    var name = $(this).data("transaction_name");
    var address = $(this).data("address");
    var amount = $(this).data("net_total");

    transactions.push({
        id: transaction_id,
        name: name,
        address: address,
        total: amount,
    });

    //push to invoice ids list
    invoiceIdList.push(transaction_id);
    // set the modified invoice id list array to the local storage
    localStorage.setItem(
        "industry_items_id_list",
        JSON.stringify(invoiceIdList)
    );

    localStorage.setItem("industry_transactions", JSON.stringify(transactions));
    $("#industry_payments_tbl tfoot").html("");
    selectedIndustryTransactionRecordsTbl();

    let s = $(this).parents("td").find("button").prop("disabled", true);
    // console.log(s);
    // $(this).prop("disabled", true);
});

//load selected industry transactions table to generate invoice
function selectedIndustryTransactionRecordsTbl() {
    let sub_total = 0;
    let i = 1;
    $("#industry_payments_tbl tbody").html("");

    var array = JSON.parse(localStorage.getItem("industry_transactions"));

    $.each(array, function (index, val) {
        if (val) {
            $("#industry_payments_tbl > tbody").append(
                `<tr>
            <td>${i++}</td><td>${val.id}</td><td><b>${val.name}</b>  <br>${
                    val.address
                }</td>
            <td>${val.total.toFixed(2)}</td>
            <td><button type="button" class="btn btn-xs btn-danger btn-delete-invoice-gen" 
                value=` +
                    index +
                    ` ` +
                    `data-transaction_id=${val.id}` +
                    `>Delete</button></td>
            </tr>`
            );
        }
        sub_total += Number(val.total);
    });
    $("#industry_payments_tbl > tfoot").append(`<tr>
        <td colspan="3" style="text-align: center">Total</td>
        <td id="gene_total_amount">${sub_total.toFixed(2)}</td>
    </tr>`);

    $("#sub_total").val(sub_total.toFixed(2));
    calTax();
}

//remove selected industry transaction record
$(document).on("click", ".btn-delete-invoice-gen", function (e) {
    if (!confirm("Remove this item?")) {
        return false;
    }

    var transactions = JSON.parse(
        localStorage.getItem("industry_transactions")
    );
    let rowVal = $(this).val();
    let transactionId = $(this).data("transaction_id");
    $(".btn-old-transaction-add[data-invoice_id=" + transactionId + "]").prop(
        "disabled",
        false
    );
    $(".btn-cancel[data-invoice_id=" + transactionId + "]").prop(
        "disabled",
        false
    );

    transactions.splice(rowVal, 1);

    localStorage.setItem("industry_transactions", JSON.stringify(transactions));

    // remove from invoice id list as well
    let invoiceIdList = JSON.parse(
        localStorage.getItem("industry_items_id_list")
    );
    let tiind = invoiceIdList.indexOf(`${transactionId}`);
    invoiceIdList.splice(tiind, 1);
    localStorage.setItem(
        "industry_items_id_list",
        JSON.stringify(invoiceIdList)
    );

    $("#industry_payments_tbl tfoot").html("");
    selectedIndustryTransactionRecordsTbl();
});
