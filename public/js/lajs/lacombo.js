/**
   * load local authority combo filterdby province
   *  return local authorities by the province if  provinceCombo exist else return a error allert
   *
   */
function comboLocalAuthorityByProvince(callBack) {
     if ($('.provinceCombo').length > 0) {
          $('.laByProvinceCombo').empty();

          getPlantsByProvince($('.provinceCombo').val(), function (result) {
               if (result.length > 0) {
                    $.each(result, function (key, value) {
                         $('.laByProvinceCombo').append(new Option(value.name, value.id));
                    });
               } else {
                    $('.laByProvinceCombo').append(new Option('None', 0));
               }
               if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
                    callBack(result);
                }
          });

     } else {
          //  alert('Province Combo not found');
     }
}