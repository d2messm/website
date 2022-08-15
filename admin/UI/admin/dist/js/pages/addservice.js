var serviceList = '';
$('#addservice_btn').click(function () {
//    event.preventDefault();
    if ($('#service_name').val().trim().length < 2) {
        showNotification('Service Name required');
        $('#service_name').focus();
        return false;
    }
    if ($('#service_punchline').val().trim().length < 2) {
        showNotification('A Punch Line would look Nice on Service');
        $('#service_punchline').focus();
        return false;
    }
    if ($('#thumbnail_image_file')[0].files[0] == undefined) {
        showNotification('Thumbnail is Required');
        $('#thumbnail_image_file').focus();
        return false;
    }


    if ($('#addservice_btn').hasClass('disabled')) {
        return false;
    }
    $('#addservice_btn').addClass('disabled');

    var data = new FormData();
    data.append('admin_id', aid);
    data.append('service_name', $('#service_name').val().trim());
    data.append('punchline', $('#service_punchline').val().trim());
    data.append('thumbnail_image', $('#thumbnail_image_file')[0].files[0]);
    data.append('parent_id', '0');
    data.append('sname', 'Service');
    data.append('fname', 'addService');
    data.append('isweb', '1');
    data.append('tval', '1');
    $.when(makeFileAJAX('../../api/index.php', data, 'POST', addServiceMainHandler, null)).then(function () {
        $('#addservice_btn').removeClass('disabled');
    });
    return false;
});

function addServiceMainHandler(response) {
    swal('New Service Added', '', 'success').then((then) => {
        location.reload();
    });
}

$(document).ready(function () {
    var data = {};
    var service_data = '';
    data.sname = 'Service';
    data.fname = 'getAllServiceName';
    data.parent_id = 0;
    data.tval = '1';
    data.admin_id = aid;
    data.from_website = '1';
    data.isweb = '1';
    makeAJAX('../../api/index.php', data, handleServicedata);

    setupEditor('');

});
function handleServicedata(response) {
    //alert(response);
    var service_data = '<ul style="cursor:pointer;" id="mainCategoryUL"><table>';
    $.each(response, function (i, service) {
        $('#category_id').append($('<option>').text(service.category_name).attr('value', service.service_id));
        service_data += '<tr id="tr_li_' + service.service_id + '"><td><li id="li_' + service.service_id + '" onclick="getSubCat(\'' + service.service_id + '\',this)">' + service.service_name + '</li></td><td valign="top;" align="right"><span onclick="deleteService(\'' + service.service_id + '\')" class="text-danger">&nbsp;&nbsp;&nbsp;<i class="fa fa-remove"></i></span><td></tr>';
    });
    service_data += '</table></ul>';
    $('#accordion').html(service_data);

    //for service description
    fillServiceList(response);
}

function deleteService(serviceid) {
    console.log("service Id " + serviceid);
    if (confirm("Are you sure you want to delete")) {
        var requestData = {};
        requestData.sname = 'Service';
        requestData.fname = 'removeService';
        requestData.tval = '1';
        requestData.isweb = '1';
        requestData.service_id = serviceid;
        var deleteajax = makeAJAX('../../api/index.php', requestData, removeService);
        $.when(deleteajax).then(function () {
            $('#tr_li_' + categoryId).remove();
            $("#category_id option[value='" + categoryId + "']").remove();
        });
    } else {
        return false;
    }
}

function removeService(responseData) {
    swal("Service Removed").then((value) => {
        location.reload();
    });
}

function fillServiceList(response) {
    serviceList = response;
    $serviceList = "";
    $serviceList += '<option value=\'0\' selected disabled>Select Service</option>';

    $.each(response, function (i, service) {
        if (service.status == 1)
            $serviceList += '<option value=\'' + service.service_id + '\'>' + service.service_name + '</option>';
    });

    $('#service_list_select').empty();
    $('#service_list_select').append($serviceList);
}

$('#update_description_btn').click(function () {

    var serviceId = $('#service_list_select option:selected').val();

    if (serviceId == 0) {
        swal('Please Select a Service to Update');
        return false;
    }

    if ($('#update_description_btn').hasClass('disabled')) {
        return false;
    }

    $('#update_description_btn').addClass('disabled');

    var description = CKEDITOR.instances.service_description.getData();

    var data = {};
    data.admin_id = aid;
    data.service_id = serviceId;
    data.service_description = description;
    data.sname = 'Service';
    data.fname = 'updateServiceDescription';
    data.isweb = '1';
    data.tval = '1';
    $.when(makeAJAX('../../api/index.php', data, serviceDescUpdated)).then(function (response) {
        $('#update_description_btn').removeClass('disabled');
    });

});

function serviceDescUpdated(data) {
    swal('Service Description Updated Successfully').then((value) => {
        fillServiceList(serviceList);
        CKEDITOR.instances.service_description.setData('');
    });
}

$('#service_list_select').change(function () {
    var serviceId = $(this).val();

    var data = {};
    data.admin_id = aid;
    data.service_id = serviceId;
    data.sname = 'Service';
    data.fname = 'getServiceDescription';
    data.isweb = '1';
    data.tval = '1';
    makeAJAX('../../api/index.php', data, handleServiceDesc);
});

function handleServiceDesc(response) {
    var desc = '';
    if (response != null)
        desc = response.service_description;

    CKEDITOR.instances.service_description.setData(desc);
}

function setupEditor(prefilledData) {
    var ckEditor = CKEDITOR.replace('service_description');
//    CKEDITOR.config.extraPlugins = 'autogrow';
//    CKEDITOR.config.autoGrow_minHeight = 850;
//    CKFinder.setupCKEditor(ckEditor, null, {type: 'Files', currentFolder: '/' + SERVICE_IMAGE_PATH});

//    CKEDITOR.editorConfig = function (config) {
//        config.filebrowserBrowseUrl = SERVICE_IMAGE_PATH;
//        config.filebrowserUploadUrl = SERVICE_IMAGE_PATH;
//    };

    CKEDITOR.instances.service_description.setData(prefilledData);

}