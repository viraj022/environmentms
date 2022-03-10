function GetUsers(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            Authorization:
                "Bearer " + $("meta[name=api-token]").attr("content"),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: "application/json",
        },
        url: "api/environment_officers/unassigned",
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (
                typeof callBack !== "undefined" &&
                callBack != null &&
                typeof callBack === "function"
            ) {
                callBack(result);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert(textStatus + ":" + errorThrown);
        },
    });
}

function loadUsersCombo(callBack) {
    GetUsers(function (result) {
        var combo = "";
        var id = 1;
        $.each(result, function (index, value) {
            combo +=
                "<option value='" +
                value.id +
                "'>" +
                value.first_name +
                " " +
                value.last_name +
                "</option>";
        });
        $("#getUsers").html(combo);
        if (
            typeof callBack !== "undefined" &&
            callBack != null &&
            typeof callBack === "function"
        ) {
            callBack(result);
        }
    });
}

function uniqueNamecheck(name, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            Authorization:
                "Bearer " + $("meta[name=api-token]").attr("content"),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: "application/json",
        },
        url: "api/zone/name/" + name,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (
                typeof callBack !== "undefined" &&
                callBack != null &&
                typeof callBack === "function"
            ) {
                callBack(result);
            }
        },
    });
}
function uniqueCodecheck(code, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            Authorization:
                "Bearer " + $("meta[name=api-token]").attr("content"),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: "application/json",
        },
        url: "api/zone/code/" + code,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (
                typeof callBack !== "undefined" &&
                callBack != null &&
                typeof callBack === "function"
            ) {
                callBack(result);
            }
        },
    });
}

function GetAssistantDir(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            Authorization:
                "Bearer " + $("meta[name=api-token]").attr("content"),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: "application/json",
        },
        url: "api/AssistantDirector/active",
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (
                typeof callBack !== "undefined" &&
                callBack != null &&
                typeof callBack === "function"
            ) {
                callBack(result);
            }
        },
    });
}

function loadAssistantDirectorCombo(callBack) {
    GetAssistantDir(function (result) {
        var combo = "";
        var id = 1;
        $.each(result, function (index, value) {
            combo +=
                "<option value='" +
                value.id +
                "'>" +
                value.first_name +
                " " +
                value.last_name +
                "</option>";
        });
        $(".combo_AssistantDirector").html(combo);
        if (
            typeof callBack !== "undefined" &&
            callBack != null &&
            typeof callBack === "function"
        ) {
            callBack(result);
        }
    });
}

function getEnvOfficerByAssistantDirId_table(id, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            Authorization:
                "Bearer " + $("meta[name=api-token]").attr("content"),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: "application/json",
        },
        url: "api/environment_officers/assistant_director/id/" + id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (
                typeof callBack !== "undefined" &&
                callBack != null &&
                typeof callBack === "function"
            ) {
                callBack(result);
            }
        },
    });
}
function loadEnvOficerTable(id) {
    getEnvOfficerByAssistantDirId_table(id, function (result) {
        var table = "";
        var id = 1;
        $.each(result, function (index, value) {
            table += "<tr>";
            table += "<td>" + id++ + "</td>";
            table +=
                "<td>" + value.first_name + " " + value.last_name + "</td>";
            table +=
                "<td><button id='" +
                value.id +
                "' type='button' data-toggle='modal' data-target='#modal-danger'  class='btn btn-block btn-danger btn-xs btnAction' data-raw_data='" +
                escape(JSON.stringify(value)) +
                "'>Un Assign</button></td>";
            table += "</tr>";
        });

        $("#tblEnvOfficer tbody").html(table);
        $("#tblEnvOfficer").DataTable();
    });
}

function getEnvOfficerById(id, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            Authorization:
                "Bearer " + $("meta[name=api-token]").attr("content"),
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            Accept: "application/json",
        },
        url: "api/environment_officer/id/" + id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            if (
                typeof callBack !== "undefined" &&
                callBack != null &&
                typeof callBack === "function"
            ) {
                callBack(result);
            }
        },
    });
}
