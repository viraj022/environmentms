function GetCommittee(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "api/committee",
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });
}

function uniqueNICcheck(nic, callBack) {
    if (nic.length == 0) {
        callBack({'message': 'true'});
    } else {
        $.ajax({
            type: "GET",
            headers: {
                "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Accept": "application/json"
            },
            url: "api/committee/is_available/nic/" + nic,
            data: null,
            dataType: "json",
            cache: false,
            processDaate: false,
            success: function (result) {

                if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                    callBack(result);
                }
            }
        });
    }
}

function loadTableUI() {
    GetCommittee(function (result) {
        var table = "";
        var id = 1;
        $.each(result, function (index, committee) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table += "<td>" + committee.first_name + "</td>";
            if(committee.nic == null) {
                table += "<td>" +  '-' + "</td>";
            } else {
                table += "<td>" +  committee.nic + "</td>";
            }
            table += "<td><button id='" + committee.id + "' type='button' class='btn btn-block btn-success btn-xs btnAction'>Select</button></td>";
            table += "</tr>";
        });
        $('#tblCommittees tbody').html(table);
        $("#tblCommittees").DataTable();
    });
}

function getaCommitteebyId(id, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Accept": "application/json"
        },
        url: "api/committee/id/" + id,
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
