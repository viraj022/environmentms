let start_date = $("#start_date").val();
let end_date = $("#end_date").val();

// $(document).on("click", "#printBtn", function () {
//     print();
// });

$(function () {
    $("#incomeReport").DataTable({
        dom: "Bfrtip",
        buttons: [
            "excel",
            {
                extend: "print",
                messageTop: `<h4>${start_date} To ${end_date}</h4>`,
                orientation: "landscape",
            },
        ],
        //order second column ascending
        order: [[1, "asc"]],

    });
});
