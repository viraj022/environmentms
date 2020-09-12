function deleteEnviremontalOfficer(id, callBack) {
    //just change active status = 0
    $.ajax({
        type: "delete",
        headers: {
            Authorization:
                "Bearer " + $("meta[name=api-token]").attr("content"),
            Accept: "application/json",
        },
        url: "api/environment_officers/id/" + id,
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
