$(document).ready(function () {
//    load4ProductThumbnail();
});

function load4ProductThumbnail() {
    var data = {};
    data.sname = 'productService';
    data.fname = 'productThumbnailDetail';
    data.isweb = '1';
    data.tval = '1';
    var ajaxCalled = callAJAX(WEB_API_PATH, data, handleProductThumbnailDetail);
    $.when(ajaxCalled).then(function () {
        alert("ajax Called congrate");
    });
}
function handleProductThumbnailDetail(){
    
}
