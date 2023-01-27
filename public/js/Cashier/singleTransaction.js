 //load all industry transaction records to pay single transaction
 function loadAllIndustryTransactionsTbleToPay() {
    var url = "/get-transactions";

    ajaxRequest("GET", url, null, function(response) {
        let tr = '';
        let i = 0;
        $.each(response, function(i, transaction) {
            let type = transaction.type;
            type = type.replace("_", " ");
            type.charAt(0).toUpperCase();
            type = type.charAt(0).toUpperCase() + type.slice(1)

            tr += `<tr data-row_id = "${transaction.id}">
                <td>${++i}</td>
                <td>${transaction.id}</td>
                <td> <b>${transaction.industry_name} </b> <br> ${transaction.address}</td>
                <td>${type} <br>  <b>Rs.${transaction.net_total.toFixed(2)}  </b></td>
                <td>
                    <button class ="btn btn-danger btn-xs btn-old-transaction-pay" 
                    data-transaction_name="${transaction.industry_name}"
                    data-nic=${transaction.nic} 
                    data-contact_no=${transaction.contact_no} 
                    data-invoice_id=${transaction.id} 
                    data-net_total=${transaction.net_total}
                    data-address="${transaction.address}"> Pay </button> 
                    <button class ="btn btn-info btn-xs btn-cancel" data-invoice_id=${transaction.id}> Cancel </button> 
                </td>
            </tr>`;
        })
        $('#industry_tran_table > tbody').html(tr);
        $('#industry_tran_table').DataTable();
    });
}

$(document).on('click', ".btn-old-transaction-pay", function(e) {
    localStorage.setItem('new_application_transaction_items', '[]');
    generateNewApplicationTable();

    localStorage.setItem('industry_transactions', '[]');
    $("#industry_payments_tbl tfoot").html('');
    selectedIndustryTransactionRecordsTbl();

    localStorage.setItem('industry_items_id_list', '[]');
    loadAllIndustryTransactionsTable();

    let name = $(this).data('transaction_name');
    let nic = $(this).data('nic');
    let telephone = $(this).data('contact_no');
    let address = $(this).data('address');
    let sub_total = $(this).data('net_total');
    let transactionId = $(this).data('invoice_id');

    let data =  {
        transactionId: transactionId,
        sub_total: sub_total,
    }
    localStorage.setItem("single_transaction_amount", JSON.stringify(data));

    name ? $('#name').prop("readonly", true) : $('#name').prop("readonly", false);
    nic ? $('#nic').prop("readonly", true) : $('#nic').prop("readonly", false);
    telephone ? $('#telephone').prop("readonly", true) : $('#telephone').prop("readonly", false);
    address ? $('#address').prop("readonly", true) : $('#address').prop("readonly", false);

    $('#name').val(name);
    $('#nic').val(nic);
    $('#telephone').val(telephone);
    $('#address').val(address);
    $('#sub_total').val(sub_total.toFixed(2));
    $('#transactionId').val(transactionId);

    calTax();
});
