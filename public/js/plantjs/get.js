// $.ajax({
//      type: "GET",
//      headers: {
//          "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
//          "Accept": "application/json"
//      },
//      url: "api/rolls/privilege/add",
//      data: data,
//      contentType: 'text/json',
//      dataType: "json",
//      cache: false,
//      processDaate: false,
//      success: function (result) {

//          if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
//              callBack(result);
//          }
//      }
//  });