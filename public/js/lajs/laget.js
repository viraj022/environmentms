

function getPlantsByProvince(id,callBack){
     $.ajax({
          type: "GET",
          headers: {
              "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
              "Accept": "application/json"
          },
          url: "api/localAuthority/province/id/"+id,
          data: null,         
          cache: false,
          processDaate: false,
          success: function (result) {
  
              if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                  callBack(result);
              }
          }
      });
}