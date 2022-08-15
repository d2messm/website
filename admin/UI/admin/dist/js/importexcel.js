/* global aid, swal, value */

var option = '';
var csvHeaderRecords = '';
var filename = '';
$('#productsform').on('submit', function (event) {
    event.preventDefault();
    var formData = {};
    formData.data = $(this).serializeArray();
    formData.filename = filename;
    formData.tval = 1;
    formData.admin_id = aid;
    formData.isweb = 1;
    formData.sname = 'ExcelService';
    formData.fname = 'uploadExcelRecords';
    //console.log(filename);
    var a = makeAJAX('../../api/index.php', formData, uploadCompleted);
//    $.when(a).then(function () {//done
//        alert('AJax done');
//    });
    return false;
});
function uploadCompleted(response) {
    swal(response.msg)
            .then((value) => {
                location.reload();
            });

}

function submitExcelSheet() {
    //fileInputElement.files[0]
    if ($('#file')[0].files[0] === undefined) {
        //alert('Kindly select a file to proceed');
        showNotification('Kindly select a file to proceed');
        return false;
    }
    var formData = new FormData();
    formData.append("file", $('#file')[0].files[0]);
    formData.append("tval", 1);
    formData.append("isweb", 1);
    formData.append("fname", 'uploadExcel');
    formData.append("sname", 'ExcelService');
    formData.append("file", $('#file')[0].files[0]);
    filename = $('#file')[0].files[0].name;
    makeFileAJAX('../../api/index.php', formData, 'POST', makeOption, 'progress');
}
function makeOption(data) {
    filename = $('#file')[0].files[0].name;
    csvHeaderRecords = data;
    option += '<select><option value="0">-NA-</option>';
    $.each(data, function (index, value) {
        option += ('<option value="' + index + '">' + value + '</option>');
    });
    $('#postform').fadeIn(2000);
    $('#preform').fadeOut(2000);
    option += '</select>';
    autofillOption('productsform');
}
function resetoption() {
    option = '<select><option value="0">-NA-</option></select>';
}
function setFileName() {
    $('#filename').val($('#file').val());
}
function autofillOption(productsform) {
    $('#' + productsform + ' select').each(function () {
        $(this).html(option);
    });
}