
var counter=0;
$(document).ready(function () {
    insertNewRow();
    $("#removeRow_1").hide();
});
function insertNewRow() {
    counter++;
    $rowAppended ='<div id="div_row_'+counter+'" class="form-group label-floating"><label class="control-label">Image '+counter+'</label><input type="file" name="pkg_image_'+counter+'" id="pkg_image_'+counter+'"><a onclick="removeRow('+counter+')" id="removeRow_'+counter+'">Remove</a></div>';
    $('#pkgImagesDiv').append($rowAppended);
}
function removeRow(rowID) {
    $("#div_row_"+ rowID).remove();
}
function addDaysDescription(){
    $("#daysbuttondiv button").remove();
    var tmp= $("#pkg_days").val().trim();
    insertNewDaysButton(tmp);
    insertModals(tmp);
}
function insertNewDaysButton(days){
    for(var i=1;i<=days;i++){
        $buttonRow ='<button type="button" class="btn btn-default" data-toggle="modal" \n\
                    data-target="#daysModal_'+i+'" ><b>Days '+i+'<b></button>';
        $("#daysbuttondiv").append($buttonRow);
    }
    $("#daysbuttondiv button").css('margin','5px');
}
function insertModals(days){
    for(var i=1;i<=days;i++){
        $buttonRow ='<div class="modal fade" id="daysModal_'+i+'" tabindex="-1" role="dialog" >\n\
            <div class="modal-dialog" role="document">\n\
                <div class="modal-content">\n\
                    <div class="modal-header">\n\
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n\
                        <h4 class="modal-title" id="exampleModalLabel">Day '+i+' Description</h4>\n\
                    </div>\n\
                    <div class="modal-body">\n\
                        <div class="row">\n\
                            <div class="col-md-5">\n\
                                <div class="form-group label-floating">\n\
                                    <label class="control-label">Place Name</label>\n\
                                    <input type="text" name="place_name"  id="place_name_'+i+'" value="" class="form-control">\n\
                                </div>\n\
                            </div>\n\
                            <div class="col-md-7">\n\
                                <div class="form-group label-floating">\n\
                                    <label class="control-label">Images</label>\n\
                                    <input type="file" name="image" id="image_day_'+i+'" class="form-control">\n\
                                </div>\n\
                            </div>\n\
                            <div class="col-md-5">\n\
                                <div class="checkbox">\n\
                                    <label> <input type = "checkbox" id ="meal_'+i+'" value ="BreakFast">BreakFast</label> \n\
                                </div>\n\
                                <div class="checkbox">\n\
                                    <label> <input type = "checkbox" id ="meal_2_'+i+'" value ="Lunch">Lunch</label> \n\
                                </div>\n\
                                <div class="checkbox">\n\
                                    <label> <input type = "checkbox" id ="meal_3_'+i+'" value ="Dinner">Dinner</label> \n\
                                </div>\n\
                            </div>\n\
                            <div class="col-md-7">\n\
                                <div class="form-group label-floating">\n\
                                    <label class="control-label">Hotel Name</label>\n\
                                    <input type="text" name="hotel_name" id="hotel_name_'+i+'" class="form-control">\n\
                                </div>\n\
                            </div>\n\
                            <div class="col-md-6"></div>\n\
                            <div class="col-md-12">\n\
                                <div class="form-group label-floating">\n\
                                    <label class="control-label">Description</label>\n\
                                    <input type="textarea" name="desc" id="desc_'+i+'" class="form-control">\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                    <div class="modal-footer">\n\
                        <button type="button" id="" class="btn btn-default" data-dismiss="modal">Done</button>\n\
                    </div>\n\
                </div>\n\
            </div>\n\
        </div>';
        $("#sectiondiv").append($buttonRow);
    }
}

$("#add_packages").click(function(event){
    event.preventDefault();
//    if ($('#pkg_name').val().trim().length == 0) {
//        alert('Please enter Valid Package Name');
//        $('#pkg_name').focus();
//        return false;
//    }
//    if ($('#pkg_type').val().trim().length == 0) {
//        alert('Please Select Valid Option');
//        $('#pkg_type').focus();
//        return false;
//    }
//    if ($('#pkg_category').val().trim().length == 0) {
//        alert('Please Select Valid Category');
//        $('#pkg_category').focus();
//        return false;
//    }
//    if ($('#pkg_activities').val().trim().length == 0) {
//        alert('Please Select Multiple Activities');
//        $('#pkg_activities').focus();
//        return false;
//    }
//    if ($('#pkg_days').val().trim().length == 0) {
//        alert('Please enter Valid Days');
//        $('#pkg_days').focus();
//        return false;
//    }
//    if ($('#pkg_nights').val().trim().length == 0) {
//        alert('Please enter Valid Nights');
//        $('#pkg_nights').focus();
//        return false;
//    }
//    
    var data= new FormData();
    var file_data=$('input[type="file"]');
    
    data.append("tval",TVAL);
    data.append("admin_id",aid);
    data.append("sname","PackageService");
    data.append("fname","addPackage");
    data.append("isweb",ISWEB);
    data.append("pkg_name",$("#pkg_name").val().trim());
    data.append("pkg_type",$("#pkg_type").val().trim());
    data.append("pkg_category",$("#pkg_category").val().trim());
    data.append("pkg_activities",$("#pkg_activities").val().trim());
    var pkg_days= $("#pkg_days").val().trim();
    data.append("pkg_days",pkg_days);
    data.append("pkg_nights",$("#pkg_nights").val().trim());
    data.append("pkg_month",$("#pkg_month").val().trim());
    
    var imageCount=$(":input[id^=pkg_image_]").length;
    
    for (i = 1; i <= imageCount; i++) {
        image = $('#pkg_image_' + i).val();
        data.append("pkg_image_" + i, image);
    }
    
    for (i = 1; i <= pkg_days; i++) {
        data.append("place_name_"+i,$("#place_name_"+i).val().trim());
        data.append("image_day_"+i,$("#image_day_"+i).val().trim());
        data.append("meal_"+i,$("#meal_"+i).val().trim());
        data.append("hotel_name_"+i,$("#hotel_name_"+i).val().trim());
        data.append("desc_"+i,$("#desc_"+i).val().trim());
    }
    console.log(data);
    
    var ajaxCalled = makeFileAJAX(API_PATH,data,'POST',handlePackageResponse);
    $.when(ajaxCalled).then(function(){
        $('#add_packages').removeClass('disable');
        location.reload();
    });
    return false;
});
    
function handlePackageResponse(){
    
}
    
    
    
    
   