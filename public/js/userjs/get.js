function load_deleted_user_table() {
    get_deleted_user_table(function (result) {
        var table = "";
        var id = 1;
        $.each(result, function (index, data) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table += "<td>" + data.user_name + "</td>";
            table += "<td>" + data.deleted_at + "</td>";
            table += "<td><button value='" + data.id + "' type='button' class='btn btn-block btn-danger btn-sm btnAction'>Active</button></td>";
            table += "</tr>";
        });
        $('#tbl_deleted_users tbody').html(table);
        //$("#tbl_deleted_users").DataTable();
    });
}


function get_deleted_user_table(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "/api/user/deleted",
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ':' + errorThrown);
        }
    });

}
