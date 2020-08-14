
function loadAssistantDirectorCombo(callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/AssistantDirector/active",
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            var combo = "";
            $.each(result, function (index, value) {
                combo += "<option value='" + value.id + "'>" + value.first_name + ' ' + value.last_name + "</option>";
            });
            $('.combo_AssistantDirector').html(combo);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });

}
function loadEnvOfficers_combo(ass_dir_id, callBack) {
    $.ajax({
        type: "GET",
        headers: {
            "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
            "Accept": "application/json"
        },
        url: "/api/environment_officers/assistant_director/id/" + ass_dir_id,
        data: null,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {
            var combo = "";
            if (result.length == 0 || result == undefined) {
                combo = "<option value=''>-No data Found-</option>";
            } else {
                $.each(result, function (index, value) {
                    combo += "<option value='" + value.id + "'>" + value.first_name + ' ' + value.last_name + "</option>";
                });
            }
            $('.combo_envOfficer').html(combo);
            if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                callBack(result);
            }
        }
    });

}