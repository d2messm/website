var product_data = '';
var currentDeleterowid = 0;
var featureCount = '';
var productDescriptionLength = 15;
var maxNoOfImage = 3;
$(document).ready(function () {
    fetchProductDetail();
});
function fetchProductDetail() {
    var data = {};
    data.sname = 'ProductService';
    data.fname = 'getAllProduct';
    data.isweb = '1';
    data.tval = '1';
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (response) {
            var encrypt = atob(response);
            var parse = JSON.parse(encrypt);
            if (parse.status == 0) {
                swal("error", parse.msg, "error");
            } else {
                fillTableData(parse);
                $('#product_table tbody').empty();
                $('#product_table').append(product_data);
                $('#product_table').DataTable({
                    responsive: true
                });
            }
        },
        error: function (err) {
            // console.log("error function" + err);
        }
    }).done(function () {
        //swal("error", parse.msg, "success");
    }).fail(function () {
        // alert('fail ajax');
        swal("server error", parse.msg, "error");
    });
}

function fillTableData(parse) {
    $.each(parse.data, function (i, product) {
        var image_url = product.product_image_url.split('# ');
        product.product_make = (product.product_make == null || product.product_make == "") ? "-NA-" : product.product_make;
        product.product_description = (product.product_description === null || product.product_description == "") ? "-NA-" : product.product_description;
        product.purchase_price = (product.purchase_price == null || product.purchase_price == "") ? 0 : product.purchase_price;
        product.unit_of_measurement = (product.unit_of_measurement == null || product.unit_of_measurement == "") ? "-NA-" : product.unit_of_measurement;
        product_data += '<tr id="tr_' + product.product_id + '">';
        product_data += '<td>' + (i + 1) + '</td>';
        product_data += '<td>' + product.product_name + '</td>';
        product_data += '<td>' + product.product_make + '</td>';
        product_data += '<td>' + product.product_description + '</td>';
        product_data += '<td>' + product.purchase_price + '</td>';
        product_data += '<td>' + product.selling_price + '</td>';
        product_data += '<td>' + product.unit_of_measurement + '</td>';
        product_data += '<td>' + product.hsn + '</td>';
        product_data += '<td>' + product.discount + '</td>';
        product_data += '<td><div>';
        $.each(image_url, function (i, image) {
            if (image) {
                product_data += '<img src=\'../../UI/assets/img/product/' + image + '\' width="100px" >';
            }
        });
        product_data += '</div></td>';
        product_data += '<td><i class="fa fa-pencil" data-toggle="modal" data-target="#myModal" style="font-size:24px;color:#3c8dbc;cursor:pointer" id="fetch_product_details" data-id=' + product.product_id + ' ></i> <i class="glyphicon glyphicon-remove" style="font-size:24px;color:#3c8dbc;cursor:pointer; margin-left:20px;" id="delete_particular_product" data-id=' + product.product_id + ' ></i></td>';
        product_data += '</tr>';
    });
}



//fetch particular  product  in Model for updation.
$(document).on('click', '#fetch_product_details', function () {

    var data = {};
    data.admin_id = 1;
    data.product_id = $(this).data('id');
    data.sname = 'ProductService';
    data.fname = 'getSpecificProduct';
    data.isweb = '1';
    data.tval = '1';
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            encrypt = atob(data);
            response = JSON.parse(encrypt);
            if (response.status == 0) {
                handleErrorData(response);
            } else {

                $('#featureBox div').remove();
                var image_url = response.data.product_image_url.split('# ');
                var feature_name_arr = response.data.features.split('#');
                var feature_desc_arr = response.data.feature_description.split('#');
                $.each(feature_name_arr, function (i, name) {
                    viewNoOfFeatures(i);
                    $('#feature_name_' + i).val(name);
                });
                $.each(feature_desc_arr, function (i, name) {
                    $('#feature_description_' + i).val(name);
                });
                for (var i = 0; i < maxNoOfImage; i++) {
                    $('#product_image_' + i + ' img').remove();
                }

                (response.data.display_price === 1) ? $('#display_price').prop('checked', true) : $('#display_price').prop('checked', false);
                console.log(response.data);
                var product_id = response.data.product_id;
                var barcode = response.data.barcode;
                $('#product_name').val(response.data.product_name);
                $('#product_make').val(response.data.product_make);
                $('#category_id option[value=' + response.data.category_id + ']').attr('selected', true);
                $('#product_description').val(response.data.product_description);
                $('#purchase_price').val(response.data.purchase_price);
                $('#selling_price').val(response.data.selling_price);
                $('#unit_of_measurement').val(response.data.unit_of_measurement);
                $('#hsn').val(response.data.hsn);
                $('#discount').val(response.data.discount);
                $('#pdtid').val(response.data.product_id);
                $.each(image_url, function (i, image) {
                    $path = "../../UI/assets/img/product/" + image;
                    $('#product_image_' + i).append($('<img>', {src: $path}));
                    $('#product_image_' + i + ' img').attr('width', '100px');
                    // $('#product_image_' + i + ' #product_image_' + i).val($path);
                });
            }
        }

    }).done(function () {
// handleErrorData(response);
    }).fail(function () {
//handleErrorData(response);
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
function viewNoOfFeatures(i) {
    featureCount = i;
    var featureRow = '<div class="col-md-6"><div class="form-group"><label class="control-label">Feature Name</label><input type="text" name="feature_name_' + featureCount + '" id="feature_name_' + featureCount + '" value="" class="form-control" title="Feature name"></div></div>';
    featureRow += '<div class="col-md-6"><div class="form-group"><div class="form-group label-floating"><label class="control-label"> Feature Description</label><input type="text" name="feature_description_' + featureCount + '" id="feature_description_' + featureCount + '" value="" class="form-control" title="Feature Description"></div></div></div>';
    $('#featureBox').append(featureRow);
    return false;
}





$('#update_product_btn').click(function (event) {
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
    if ($('#purchase_price').val().trim() > $('#selling_price').val().trim()) {
        showNotification('Purchase Price should be less then Selling Price.');
        $('#purchase_price').foucs();
        return false;
    }
    var displayPrice = 0;
    if ($('#display_price').prop('checked') === true) {
        displayPrice = 1;
    }
    if ($('#update_product_btn').hasClass('disabled')) {
        return false;
    }
    $('#update_product_btn').addClass('disabled');
    var data = new FormData();
    var file_data = $('input[type="file"]'); // for multiple files
    data.append("admin_id", aid);
    data.append("product_id", $('#pdtid').val().trim());
    data.append("product_name", $('#product_name').val().trim());
    data.append("product_make", $('#product_make').val().trim());
    data.append("product_description", $('#product_description').val().trim());
    data.append("category_id", $('#category_id').val().trim());
    data.append("unit_of_measurement", $('#unit_of_measurement').val().trim());
    if (file_data[0].files[0] != undefined) {
        data.append("product_image_0", file_data[0].files[0]);
    }
    if (file_data[1].files[0] != undefined) {
        data.append("product_image_1", file_data[1].files[0]);
    }
    if (file_data[2].files[0] != undefined) {
        data.append("product_image_2", file_data[2].files[0]);
    }
//hash seperated feature name
    var featureHashName = '';
    for (var i = 0; i <= featureCount; i++) {

        featureHashName += $('#feature_name_' + i).val();
        featureHashName += '#';
    }
    data.append("features", featureHashName.slice(0, -1));
    //hash seperated feature description
    var featureHashDescription = '';
    for (var i = 0; i <= featureCount; i++) {
        featureHashDescription += $('#feature_description_' + i).val();
        featureHashDescription += '#';
    }
    data.append("feature_description", featureHashDescription.slice(0, -1));
    data.append("purchase_price", $('#purchase_price').val().trim());
    data.append("selling_price", $('#selling_price').val().trim());
    data.append("display_price", displayPrice);
    data.append("sname", 'ProductService');
    data.append("fname", 'updateProduct');
    data.append("isweb", '1');
    data.append("tval", '1');
    var data2 = data;
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        processData: false,
        contentType: false,
        success: function (data) {
            $('#update_product_btn').removeClass('disabled');
            var decrypt = atob(data);
            var response = JSON.parse(decrypt);
            if (response.status == 0) {
                handleErrorData(response);
            } else {
                
                swal('Done', 'Product updated Successfully', 'success');
                $('#myModal').modal('hide');
                var table = $('#product_table').dataTable();
                var particularrow = $('#tr_' + data2.get('product_id')).find('td:first').text();
                particularrow = parseInt(particularrow);
                particularrow--;
                table.fnUpdate(data2.get('product_name'), particularrow, 1);
                table.fnUpdate(data2.get('product_make'), particularrow, 2);
                table.fnUpdate(data2.get('product_description'), particularrow, 3);
                table.fnUpdate(data2.get('purchase_price'), particularrow, 4);
                table.fnUpdate(data2.get('selling_price'), particularrow, 5);
                table.fnUpdate(data2.get('unit_of_measurement'), particularrow, 6);
                table.fnUpdate('Image will update soon', particularrow, 9);
                
            }
        }, error: function (err) {
            $('#update_product_btn').removeClass('disabled');
        }
    }).done(function () {
//alert('done');
        $('#update_product_btn').removeClass('disabled');
    }).fail(function () {
        alert('fail');
        $('#update_product_btn').removeClass('disabled');
    });
});




$(document).on('click', '#delete_particular_product', function () {
    if (confirm("Are you sure?")) {
        var data = {};
        data.admin_id = 1;
        data.product_id = $(this).data('id');
        currentDeleterowid = data.product_id;
        data.sname = 'ProductService';
        data.fname = 'deleteSpecificProduct';
        data.isweb = '1';
        data.tval = '1';
        makeAJAX(API_PATH, data, handleDeleteProduct);
    } else {
        //do nothing
        return false;
    }
});
function handleDeleteProduct(response) {
    swal("", "Deleted", "success");
    window.setTimeout('location.reload()', 1000); //Reloads after one seconds


}
