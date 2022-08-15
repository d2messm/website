$(document).ready(function () {
    var data = {};
    var category_data = '';
    data.sname = 'ProductService';
    data.fname = 'getAllCategory';
    data.tval = '1';
    data.isweb = '1';
    makeAJAX('../../api/index.php',data,handleCategorydata);
    });
function handleCategorydata(response){
    var category_data='<ul style="cursor:pointer;" id="mainCategoryUL"><table>';
    $.each(response, function (i, category) {
        $('#category_id').append($('<option>').text(category.category_name).attr('value', category.category_id));
        category_data+='<tr id="tr_li_'+category.category_id+'"><td><li id="li_'+category.category_id+'" onclick="getSubCat(\'' + category.category_id + '\',this)">' + category.category_name + '</li></td><td valign="top;" align="right"><span onclick="deleteCategory(\''+category.category_id +'\')" class="text-danger">&nbsp;&nbsp;&nbsp;<i class="fa fa-remove"></i></span><td></tr>';
    });
    category_data+='</table></ul>';
    $('#accordion').html(category_data);
}   
$('#addcategory_btn').click(function () {
    //event.preventDefault();
    if ($('#category_name').val().trim().length < 2) {
        showNotification('Category Name required');
        $('#category_name').focus();
        $('#category_name').css('border-color', 'red');
        return false;
    }
    if ($('#addcategory_btn').hasClass('disabled')) {
        return false;
    }
    $('#addcategory_btn').addClass('disabled');
    $('#category_name').css('border-color', '#d2d6de ');
    var data = {};
    data.admin_id = aid;
    data.category_name = $('#category_name').val().trim();
    data.parent_id = '0';
    data.sname = 'ProductService';
    data.fname = 'addProductCategory';
    data.isweb = '1';
    data.tval = '1';
    $.when(makeAJAX('../../api/index.php',data,addCategoryMainHandler)).then(function(){
        $('#addcategory_btn').removeClass('disabled');
    });
    return false;
});
function addCategoryMainHandler(response){
    swal('Good job!','New Category Added','success');
    if ($('#category_id')) {
        $('#category_id').append('<option value="' + response + '">'+$('#category_name').val().trim()+'</option>');
    }
    $('#mainCategoryUL').append('<li id="li_'+response+'" onclick="getSubCat(\'' + response + '\',this)">'+$('#category_name').val().trim()+'</li>');
    $('#category_name').val('');
}

//  model in product to add category js file ......................
$('#addmodelcategory_btn').click(function () {
    //event.preventDefault();
    if ($('#category_name').val().trim().length < 2) {
        showModelNotification('Category Name required');
        $('#category_name').focus();
        $('#category_name').css('border-color', 'red');
        return false;
    }
    if ($('#addmodelcategory_btn').hasClass('disabled')) {
        return false;
    }
    $('#addmodelcategory_btn').addClass('disabled');
    $('#category_name').css('border-color', '#d2d6de ');
    var data = {};
    data.admin_id = aid;
    data.category_name = $('#category_name').val().trim();
    data.parent_id = '0';
    data.sname = 'ProductService';
    data.fname = 'addProductCategory';
    data.isweb = '1';
    data.tval = '1';
    var ajaxcalled=makeAJAX('../../api/index.php',data,handleModelAddedCategory);
    $.when(ajaxcalled).then(function(){
        $('#addmodelcategory_btn').removeClass('disabled');
        $('#addCategory').modal('toggle');
    });
    return false;
});
function handleModelAddedCategory(response){
    swal('Good job!','New Category Added','success');
    if ($('#category_id')) {
        $('#category_id').append('<option value="' + response + '">' + $('#category_name').val().trim() + '</option>');
    }
    $('#category_name').val('');
}
//  model in product to add category js file end......................

// adding sub category ------------------------------

$('#addsubcategory_btn').click(function () {
    event.preventDefault();
    if ($('#subcategory_name').val().trim().length < 2) {
        showModelNotification('Category Name required');
        $('#subcategory_name').focus();
        return false;
    }
    if ($('#addsubcategory_btn').hasClass('disabled')) {
        return false;
    }

    $('#addsubcategory_btn').addClass('disabled');

    var data = {};
    data.admin_id = aid;    
    data.category_name = $('#subcategory_name').val().trim();
    data.parent_id = $('#category_id').val().trim();
    data.sname = 'ProductService';
    data.fname = 'addProductCategory';
    data.isweb = '1';
    data.tval = '1';
    $.when(makeAJAX('../../api/index.php',data,handleSubCategoryAdd)).then(function(){
       $('#addsubcategory_btn').removeClass('disabled');
       $('#exampleModal').modal('toggle');
    });
    return false;
});
function handleSubCategoryAdd(data){
    $('#subcategory_name').val('');
    swal('Good job!','SubCategoryAdded','success');
}

function getSubCat(parentid,eventtarget){
    if($(eventtarget).hasClass('appended'))
        return false;
    var data={};
    data.sname = 'ProductService';
    data.fname = 'getSubCategory';
    data.parent_id = parentid;
    data.tval = '1';
    data.isweb = '1';
    var category_data='';
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            var decrypt = atob(data);
            var response = JSON.parse(decrypt);
            if (response.status == 0) {
                handleErrorData(response);//error alert should be here
            } else {
                if(response.data.length==0){
                    category_data='<ul><li>'+response.msg+'</li></ul>';
                }else{
                    category_data+='<ul><table>';
                    $.each(response.data, function (i, category) {
                        category_data+='<tr id="tr_li_'+category.category_id+'"><td><li id="li_'+category.category_id+'" onclick="getSubCat(\'' + category.category_id + '\',this)">' + category.category_name + '</li></td><td valign="top;"  align="right"><span onclick="deleteCategory(\''+category.category_id +'\')" class="text-danger">&nbsp;&nbsp;&nbsp;<i class="fa fa-remove"></i></span><td></tr>';
                    });
                    category_data+='</table></ul>';
                }
                $(eventtarget).addClass('appended');
                $(eventtarget).append(category_data);
            }
        },
        error: function (err) {
           // console.log("error function" + err);
        }
        }).done(function () {
        }).fail(function () {
        });
}
function deleteCategory(categoryId){
    if(confirm("Are you sure you want to delete")){
        var requestData={};
        requestData.sname = 'ProductService';
        requestData.fname = 'removeProductCategory';
        requestData.tval = '1';
        requestData.isweb = '1';
        requestData.category_id = categoryId;
        var deleteajax=makeAJAX('../../api/index.php',requestData,removeCategory);
        $.when(deleteajax).then(function(){
            $('#tr_li_'+categoryId).remove();
            $("#category_id option[value='"+categoryId+"']").remove();
        });
    }else{
        return false;
    }
}

function removeCategory(responseData){
    alert("Category Removed");
}