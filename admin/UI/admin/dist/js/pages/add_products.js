var featureCount = 0;
var maxUpload = 3;  //max image to upload
var productDescriptionLength =15;


$('#add_product_btn').click(function (event) {

    event.preventDefault();
    
    if ($('#product_name').val().trim().length < 2) {
        showNotification('Product name required');
        $('#product_name').focus();
        return false;
    }

    if ($('#product_description').val().trim().length < productDescriptionLength) {
        showNotification('product_description should be more then 15 character');
        $('#product_description').focus();
        return false;
    }
    
    if ($('#category_id').val().trim().length === 0) {
        showNotification('Category Name is required');
        $('#category_id').focus();
        return false;
    }
    
    if ($('#product_image_1').val().trim().length === 0) {
        showNotification('Image is required');
        $('#product_image_1').focus();
        //$('#image_1').css('border-color', 'red');
            return false;
    }
    if($('#purchase_price').val().trim() > $('#selling_price').val().trim()){
        showNotification('Purchase Price should be less then Selling Price.');
        $('#purchase_price').foucs();
        return false;
    }
    var displayPrice = 0;
    if( $('#display_price').prop('checked')=== false){
         displayPrice = 1;
    }
    
    if ($('#add_product_btn').hasClass('disabled')) {
        return false;
    }
    $('#add_product_btn').addClass('disabled');
    
    var data = new FormData();
    var file_data = $('input[type="file"]'); // for multiple files
    
    data.append("admin_id",aid);
    data.append("product_name",$('#product_name').val().trim());
    data.append("product_make",$('#product_make').val().trim());
    data.append("product_description",$('#product_description').val().trim());
    data.append("category_id", $('#category_id').val().trim());
    data.append("unit_of_measurement" , $('#unit_of_measurement').val().trim());
    data.append("product_image_1",file_data[0].files[0]);
    if(file_data[1] != undefined){
    data.append("product_image_2", file_data[1].files[0]);
    }
    if(file_data[2] != undefined){
    data.append("product_image_3", file_data[2].files[0]);
    }
    //hash seperated feature name
    var featureHashName = '';
    for (var i = 0; i <= featureCount; i++) {
        
            featureHashName += $('#feature_name_' + i).val();
            featureHashName += '#';      
    }
    data.append("features", featureHashName.slice(0,-1));
    
    //hash seperated feature description
    var featureHashDescription = '';
    for (var i = 0; i <= featureCount; i++) {
        
            featureHashDescription += $('#feature_description_' + i).val();
            featureHashDescription += '#';      
    }
    data.append("feature_description", featureHashDescription.slice(0,-1));

    data.append("purchase_price", $('#purchase_price').val().trim());
    data.append("selling_price", $('#selling_price').val().trim());
    data.append("display_price", displayPrice);
    data.append("sname",'ProductService');
    data.append("fname",'addProduct');
    data.append("isweb",'1');
    data.append("tval",'1');
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        processData: false,
        contentType: false,
        success: function (data) {
            $('#add_product_btn').removeClass('disabled');
            var decrypt = atob(data);
            var response = JSON.parse(decrypt);
            if (response.status == 0) {
                handleErrorData(response);
            } else {
                $('#reset_add_product').click();
                swal('Done', 'New Product Added', 'success');
                
            }
        }, error: function (err) {
            $('#add_product_btn').removeClass('disabled');
        }
    }).done(function () {
        //alert('done');
        $('#add_product_btn').removeClass('disabled');
    }).fail(function () {
        alert('fail');
        $('#add_product_btn').removeClass('disabled');
    });

});


$('#addNewFeature').on('click', function (event) {
    event.preventDefault();
    featureCount++;
    var featureRow = '<div class="col-md-6"><div class="form-group"><label class="control-label">Feature Name</label><input type="text" name="feature_name_' + featureCount + '" id="feature_name_' + featureCount + '" value="" class="form-control" title="Feature name"></div></div>';
    featureRow += '<div class="col-md-6"><div class="form-group"><div class="form-group label-floating"><label class="control-label"> Feature Description</label><input type="text" name="feature_description_' + featureCount + '" id="feature_description_' + featureCount + '" value="" class="form-control" title="Feature Description"></div></div></div>';
    $('#featureBox').append(featureRow);
    
    return false;
});
