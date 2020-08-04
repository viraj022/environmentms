
function Validiteinsert(data) {
    var response = true;
    if (data.site_clearance_file.length === 0) {
        $('#valPayCat').removeClass('d-none');
        response = false;
    }
    return response;
}