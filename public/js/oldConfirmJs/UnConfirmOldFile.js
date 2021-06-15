function loadConfirmedTable() {
    GetIndustry(function(result) {
        var table = "";
        var id = 1;
        $.each(result, function(index, value) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table += "<td>" + value.name_title + "</td>";
            table += "<td>" + value.first_name + "</td>";
            table += "<td>" + value.last_name + "</td>";
            table += "<td>" + value.address + "</td>";
            table += "<td>" + value.contact_no + "</td>";
            table += "<td>" + value.industry_investment + "</td>";
            table += "<td>" + value.industry_registration_no + "</td>";
            table += "<td><button value='" + value.id + "' type ='button' class ='btnUnconfirm btn btn-success btn-xs'> UnConfirm </button></td>";
            table += "</tr>";
        });
        $('#tbl_confirm tbody').html(table);
        $("#tbl_confirm").DataTable();
    });

    // table = $('#tbl_confirm').DataTable({
    //         "destroy": true,
    //         "processing": true,
    //         "colReorder": true,
    //         "serverSide": false,
    //         "pageLength": 10,
    //         language: {
    //             searchPlaceholder: "search"
    //         },
    //         "ajax": {
    //             "url": "/api/old/confirmed_clients",
    //             "data": null,
    //             "type": "GET",
    //             "dataSrc": "",
    //             "headers": {
    //                 "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
    //                 "Accept": "application/json"
    //             },
    //         },
    //         "columns": [{
    //                 "data": "name_title"
    //             },
    //             {
    //                 "data": "first_name"
    //             },
    //             {
    //                 "data": "last_name"
    //             },
    //             {
    //                 "data": "address"
    //             },
    //             {
    //                 "data": "contact_no"
    //             },
    //             {
    //                 "data": "industry_investment"
    //             },
    //             {
    //                 "data": "industry_registration_no"
    //             },
    //             {
    //                 "data": "id"
    //             },
    //             "columnDefs": [{
    //                     "targets": -1,
    //                     "data": "0",
    //                     "render": function(data, type, full, meta) {
    //                         return getJtableBtnHtml(full);
    //                     }
    //                 },
    //                 {
    //                     "targets": 4,
    //                     "orderable": true,
    //                     "render": function(data, type, full, meta) {
    //                         var text = "";
    //                         if (full["ol"] == 1) {
    //                             text = "Qualified";
    //                         } else {
    //                             text = "Not Qualified";
    //                         }
    //                         return text;
    //                     }
    //                 },
    //             ],

    //         });

    //     $(function() {
    //         $('#tbl_confirm').DataTable();
    //     });

    //     //data table error handling
    //     $.fn.dataTable.ext.errMode = 'none'; $('#tbl_confirm').on('error.dt', function(e, settings, techNote, message) {
    //         console.log('DataTables error: ', message);
    //     });
}

// function getJtableBtnHtml(full) {
//     var html = "";
//     var page_url = window.location.href;
//     var enc_url = window.btoa(page_url); // encode a string
//     html += '<div class="btn-group" role="group"  aria-label="" >';
//     html += '<button type="button" class="btn btn-primary btn-edit" value="' +
//         full["id"] + '" data-toggle="tooltip" title="edit"><i class="btnUnconfirm far fa-edit"></i></button>';
//     html += "</div>";
//     return html;
// }

function GetIndustry(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "api/old/confirmed_clients",
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function(result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });
}