var currentlyAddedRow = 0;
var num_checkbox = 10;
var email = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var row = 1;
$(document).ready(function () {
    $('#exampleModal').hide();
        $("#update_associate_btn").hide();
    loadAllRights();
    loadAllAssociateProfile();
    $('#removeRow_1').hide();
    });
    count = 1;
    $("#add_document").click(function () {
        if (row<3) {
            count++;
                        row++;

            $docRow = '<div class="form" >\n\
                                            <input type="text" placeholder="Document Number" id="doc_no_'+row+'" name="doc_no_'+row+'" class="col-md-3">\n\
                                            <input id="doc_name_'+row+'" type="text" placeholder="Document Name"  name="doc_name_'+row+'"  class="col-md-3">\n\
                                            <input id="doc_url_'+row+'" name="doc_url_'+row+'" type="file" class=" col-md-3">\n\
                                        </div>';
            $("#document_div").append($docRow);
        } else {
            alert('Sorry ! Document Limit upload Extend  ');
        }

    

    $("#customFields").on('click', '#remCF', function () {
        var curr = $(this).data('id');
        if (curr < row) {
            alert('sorry please remove last row');
        } else {
            $(this).parent().parent().parent().remove();
            row--;
            count--;
        }
    });


});


$('#save_associate_btn').click(function (event) {
    event.preventDefault();
    if ($('#name').val().trim().length == 0) {
        alert('Please enter Valid Name');
        $('#name').focus();
        return false;
    }
    if ($('#mobile').val().trim().length != 10) {
        alert('Please enter Valid Mobile');
        $('#mobile').focus();
        return false;
    }
    if (!($('#email').val().match(email))) {
        alert('Please enter Valid Email');
        $('#email').focus();
        return false;
    }

    if ($('#user_name').val().trim().length < 4) {
        alert('Please enter valid username');
        $('#user_name').focus();
        return false;
    }

    if ($('#password').val().trim().length < 4) {
        alert('Please enter Valid password of length grater than 4');
        $('#password').focus();
        return false;
    }

    if (!$('#company_name').val().length == 0) {
        var is_company = '1';
    } else {
        var is_company = '0';
    }
    var data = new FormData();
    var file_data = $('input[type="file"]'); // for multiple files

    data.append("tval", '1');//have to define tval in constant
    data.append("sname", 'AssociateService');
    data.append("fname", 'addAssociate');
    data.append("isweb", '1');
    data.append("name", $('#name').val().trim());
    data.append("mobile", $('#mobile').val().trim());
    data.append("email", $('#email').val().trim());
    data.append("address", $('#address').val().trim());
    data.append("gender", $('input[name=gender]:checked').val().trim());
    data.append("dob", $('#dob').val().trim());
    data.append("password", $('#password').val().trim());
    data.append("user_name", $('#user_name').val().trim());
    data.append("is_company", is_company);
    data.append("company_name", $('#company_name').val().trim());
    data.append("company_address", $('#company_address').val().trim());
    data.append("company_state", $('#company_state').val().trim());
    data.append("company_country", $('#company_country').val().trim());
    data.append("company_phone", $('#company_phone').val().trim());
    data.append("gstin", $('#gstin').val().trim());
    data.append("tin_no", $('#tin_no').val().trim());
    data.append("pan_no", $('#pan_no').val().trim());
    data.append("admin_id", aid);


    // count the dynamic length of the input form for doc upload
    var doc_count = $(":input[id^=doc_no_]").length;
    console.log(doc_count);
    
    var docName = '';
    var docNo = '';
    for (i = 1; i <= doc_count; i++) {
        docName = $('#doc_name_' + i).val();
        docNo = $('#doc_no_' + i).val();
        data.append("doc_name_" + i, docName);
        data.append("doc_no_" + i, docNo);
    }

    var rights_count = $(":input[id^=c_]").length;
    data.append("rights", hashSeperatedRights(rights_count));

    data.append("document_1", file_data[0].files[0]);
    if (file_data[1] != undefined) {
        data.append("document_2", file_data[1].files[0]);
    }
    if (file_data[2] != undefined) {
        data.append("document_3", file_data[2].files[0]);
    }
    for (var value of data.entries()) {
        console.log(value[0] + ', ' + value[1]);
    }
    
    console.log(data);

    var ajaxCalled = makeFileAJAX(API_PATH, data, 'POST', handleAssociateResultAll);
    $.when(ajaxCalled).then(function () {
        $('#submitEmployeeDetail').removeClass('disabled');
    });
    return false;
});

function handleAssociateResultAll(responseData) {
    console.log(responseData);
    if (Number(responseData.status) == 1) {
        alert(responseData.msg);
        setTimeout(location.reload(), 1000);
    } else {
        alert(responseData.msg);
    }
}

function hashSeperatedRights(rights_count) {
    var ids = '';
    
    for (var i = 0; i < rights_count; i++) {
        if($("input[name=right_"+i+"]").prop('checked')){
            ids+= $("input[name=right_"+i+"]").val();
            ids+= '#';
        }
             
    }
    return ids = ids.substr(0, ids.length - 1);
}

function loadAllRights() {
    var requestData = {};
    requestData.tval = '1';
    requestData.isweb = "1";
    requestData.sname = 'ProfileService';
    requestData.fname = 'getAllAdminRights';
    $.when(makeAJAX(API_PATH, requestData, loadAllRightsHandle)).then(function () {
    });
    return false;

}

function loadAllRightsHandle(data) {
    for (var i in data) {
        $row ='<label>'+data[i].Display_name+'<input type="checkbox" name="right_'+i+'"id="c_'+data[i].id+'" value="'+data[i].id+'"></label><br>';
        $('#userRightsDiv').append($row);
    }
}

function loadAssociaterDataTable() {
    $('#associateDataTable').dataTable({
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "sDom": '<""l>t<"F"fp>'
    });
}

function loadAllAssociateProfile() {
    var requestData = {};
    requestData.tval = tval;
    requestData.admin_id = aid;
    requestData.isweb = "1";
    requestData.sname = 'AssociateService';
    requestData.fname = 'getAllAssociateProfile';

    $.when(makeAJAX(APIURL, requestData, loadAllAssociateData, 0)).then(function () {
    });
    return false;
}

function loadAllAssociateData(data) {
    sno = 0;
    var $row = '';
    console.log(data);
    for (var i in data) {
        sno++;
        var company_name='NA';
        if(data[i].is_company==1)
             company_name=data[i].company_data.company_name;
        
        $row += "<tr><td>" + sno + "</td> \n\
                <td>" + data[i].name + "</td>\n\
                <td>" + data[i].mobile + "</td>\n\
                <td>" + data[i].email + "</td>\n\
                <td>" + data[i].dob + "</td>\n\
                <td>" + data[i].is_company + "</td>\n\
                <td>" + company_name+ "</td>\n\
                <td><span class='icon'><i class='icon-pencil' onclick='editAssociatePartner(\"" + btoa(JSON.stringify(data[i])) + "\")' style='font-size:24px;color:#3c8dbc;cursor:pointer' ></i></span></td></tr>";
    }
    $('#associateTableBody').html($row);
    loadAssociaterDataTable();
}
function editAssociatePartner(data) {
    resetAllInput();
    data = JSON.parse(atob(data));
    var doc_no=data.document_no.split(' # ');
    $("#saveAssociate_btn").hide();
    $("#update_associate_btn").show();
    $("#name").focus();
    $("#name").val(data.name);
    $("#associate_id").val(data.ref_user_id);
    $("#mobile").val(data.mobile);
    $("#email").val(data.email);
    $("input[name=gender][value=" + data.gender + "]").attr('checked', 'checked');
    $("#dob").val(data.dob);
    $("#address").val(data.address);
    var right=data.user_right.split('#');
    var doc_url=data.document_url.split(' # ');
    var doc_name=data.document_name.split(' # ');
    for(var i=1;i<doc_no.length;i++){
        $("#addCF").click();
    }
    for(var i=1;i<=doc_no.length;i++){
        $("#doc_no_"+i).attr('value',doc_no[i-1]).prop('disabled',false);
        $("#doc_name_"+i).attr('value',doc_name[i-1]).prop('disabled',false);
        $("#doc_url_"+i).prop('disabled',false);
    }
    for(var i in right){
        $("#c_"+right[i]).attr('checked',true);
    }
    $("#user_name").val(data.username);
    $("#password").prop('disabled',true);
    if (data.is_company !== "0") {
        $("#is_company").show();
        $("#company_name").val(data.company_data.company_name);
        $("#gstin").val(data.company_data.gstin);
        $("#tin_no").val(data.company_data.tin_no);
        $("#pan_no").val(data.company_data.pan_no);
        $("#company_phone").val(data.company_data.company_phone);
        $("#company_state").val(data.company_data.company_state);
        $("#company_country").val(data.company_data.company_country);
        $("#company_address").val(data.company_data.company_address);
    }else{
        alert("sorry "+data.name+" does't have any Company");
    }
}

$('#update_associate_btn').click(function (event) {
    event.preventDefault();
    if ($('#name').val().trim().length == 0) {
        alert('Please enter Valid Name');
        $('#name').focus();
        return false;
    }
    if ($('#mobile').val().trim().length != 10) {
        alert('Please enter Valid Mobile');
        $('#mobile').focus();
        return false;
    }
    if (!($('#email').val().match(email))) {
        alert('Please enter Valid Email');
        $('#email').focus();
        return false;
    }
    
    if ($('#user_name').val().trim().length < 4) {
        alert('Please enter valid username');
        $('#user_name').focus();
        return false;
    }

    if (!$('#company_name').val().length == 0) {
        var is_company = '1';
    } else {
        var is_company = '0';
    }
    var data = new FormData();
    var file_data = $('input[type="file"]'); // for multiple files
    
    data.append("tval", tval);
    data.append("sname", 'AssociateService');
    data.append("fname", 'updateParticularAssociate');
    data.append("isweb", '1');
    data.append("name", $('#name').val().trim());
    data.append("mobile", $('#mobile').val().trim());
    data.append("email", $('#email').val().trim());
    data.append("address", $('#address').val().trim());
    data.append("gender", $('input[name=gender]:checked').val().trim());
    data.append("dob", $('#dob').val().trim());
    //data.append("password", $('#password').val().trim());
    data.append("user_name", $('#user_name').val().trim());
    data.append("is_company", is_company);
    data.append("company_name", $('#company_name').val().trim());
    data.append("company_address", $('#company_address').val().trim());
    data.append("company_state", $('#company_state').val().trim());
    data.append("company_country", $('#company_country').val().trim());
    data.append("company_phone", $('#company_phone').val().trim());
    data.append("gstin", $('#gstin').val().trim());
    data.append("tin_no", $('#tin_no').val().trim());
    data.append("pan_no", $('#pan_no').val().trim());
    data.append("admin_id", aid);
    data.append("associate_id", $('#associate_id').val().trim());

    // count the dynamic length of the input form for doc upload
    var doc_count = $(":input[id^=doc_no_]").length;
    
    var docName = '';
    var docNo = '';
    for (i = 1; i <= doc_count; i++) {
        docName = $('#doc_name_' + i).val();
        docNo = $('#doc_no_' + i).val();
        data.append("doc_name_" + i, docName);
        data.append("doc_no_" + i, docNo);
    }

    var rights_count = $(":input[id^=c_]").length;
    data.append("rights", hashSeperatedRights(rights_count));

    data.append("document_1", file_data[0].files[0]);
    if (file_data[1] != undefined) {
        data.append("document_2", file_data[1].files[0]);
    }
    if (file_data[2] != undefined) {
        data.append("document_3", file_data[2].files[0]);
    }
    var ajaxCalled = makeFileAJAX(APIURL, data, 'POST', handleUpdatedAssociated);
    $.when(ajaxCalled).then(function () {
        $('#submitEmployeeDetail').removeClass('disabled');
        resetAllInput();
    });
    return false;
});
function handleUpdatedAssociated(responseData) {
    console.log(responseData);
    if (Number(responseData.status) == 1) {
        alert(responseData.msg);
            $("#reset_all_form").click();

    } else {
        alert(responseData.msg);
    }
}

function resetAllInput(){
     $("#reset_all_form").click();
    $("input[type=checkbox]").attr('checked',false);
    for(var i=row;i>1;i--){
        $("#divRow_"+i).remove();
        row--;
    }
    $("#doc_no_"+row).val("");
    $("#doc_name_"+row).val("");
}