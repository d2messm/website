/* global demo, aid */

var num_checkbox = 0;
var emp_admin_id = 0;
$(document).ready(function () {
    var data = {};
    data.isweb = 1;
    data.tval = 1,
    data.admin_id = aid;
    data.sname = 'ProfileService';
    data.fname = 'getAdminRights';
    makeAJAX('../../api/index.php', data, employeeAction);
});
function employeeAction(data) {
    //console.log(data);
    num_checkbox = data.length;
    var checklist = '';
    for (var i = 0; i < data.length; i++)
    {
        checklist += '<div class="form-check"><input class="form-check-input" type="checkbox" value="' + i + '" id="c_' + i + '"><label class="form-check-label" for="">' + data[i].Display_name + '</label></div>';

    }
    $('#view_right').append(checklist);
    $("#update_emp_btn").prop('disabled',true).hide();
    $("#remove_emp_btn").prop('disabled',true).hide();

}

$('#add_emp_btn').click(function () {
    //alert('inside');
    var mobile = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    var email = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if ($('#emp_name').val().trim().length < 2) {
        showNotification('Please Provide Employee Valid Name');
        $('#emp_name').focus();
        $('#emp_name').css('border-color', 'red');
        
        return false;
    }
    if (!($('#emp_mobile').val().match(mobile))) {
        showNotification('Enter valid Phone No');
        $('#emp_mobile').focus();
        $('#emp_mobile').css('border-color', 'red');
        $('#emp_name').css('border-color', '#d2d6de ');
        return false;
    }
    if (!(email.test($('#emp_email').val()))) {
        showNotification('Enter valid Email');
        $('#emp_email').focus();
        $('#emp_email').css('border-color', 'red');
        $('#emp_mobile').css('border-color', '#d2d6de ');
        return false;
    }
    if ($('#emp_username').val().trim().length < 6) {
        showNotification('Enter valid UserName');
        $('#emp_username').focus();
        $('#emp_username').css('border-color', 'red');
        $('#emp_email').css('border-color', '#d2d6de ');
        return false;
    }
    if ($('#emp_password').val().trim().length < 6) {
        showNotification('Enter valid Password');
        $('#emp_password').focus();
        $('#emp_password').css('border-color', 'red');
        $('#emp_username').css('border-color', '#d2d6de ');
        return false;
    }

    var data = {};
    data.admin_id = aid;
    data.emp_name = $('#emp_name').val().trim();
    data.emp_mobile = $('#emp_mobile').val().trim();
    data.emp_email = $('#emp_email').val().trim();
    data.emp_username = $('#emp_username').val().trim();
    data.emp_password = $('#emp_password').val().trim();
    var ids = '';
    for (var i = 0; i < num_checkbox; i++) {
        if ($('#c_' + i).is(":checked")) {
            ids += $('#c_' + i).val();
            ids += '#';
       
        }
       
    }
    data.ids = ids.substr(0, ids.length - 1);
    if (ids.length == 0) {
        showNotification('Please Specify atleast One Right to your Employee');
       
        $('#emp_password').css('border-color', '#d2d6de ');
        return false;
    }
    data.sname = 'ProfileService';
    data.fname = 'addEmployee';
    data.isweb = '1';
    data.tval = '1';
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            var decrypt = atob(data);

            var response = JSON.parse(decrypt);
            if (response.status === 0) {
                handleErrorData(response);//error alert should be here
            } else {
                swal('done ', 'success', 'success');
                setTimeout(function(){
                    location.reload();
                },1000);

            }
        },
        error: function (err) {
            console.log("error function" + err);
        }
    }).done(function () {
    }).fail(function () {
        console.log('inside fail function');
    });

});

$(document).ready(function () {
    var data = {};
    data.isweb = 1;
    data.tval = 1,
            data.admin_id = aid;
    data.sname = 'ProfileService';
    data.fname = 'getEmpProfile';
    makeAJAX('../../api/index.php', data, viewEmployeeDetail);
});
function viewEmployeeDetail(data) {

    var item = '';
    var i='';
    var j=1;
    for (i in data)
    {

        item += '<tr id=' + data[i].admin_id + '><th scope="row">' + j + '</th> <td>' + data[i].admin_name + '</td>   <td>' + data[i].admin_phone + '</td>  <td>' + data[i].username + '</td>   <td>' + data [i].admin_email + '</td></tr>';
        j++;
    }
    $('#emp_list').append(item);
    $('#emp_list_table').DataTable({
        responsive: true
    });
    $("#emp_list_table tbody").delegate("tr", "click", function () {
        //rest of the code here
        var id = $(this).find('th:first').text();
        id=id-1;
        console.log(id);

        $("div.label-floating").removeClass("label-floating").addClass("label-fixed");
        $("#emp_name").attr("value", data[id].admin_name).focus();
        $("#emp_mobile").attr("value", data[id].admin_phone);
        $("#emp_email").attr("value", data[id].admin_email);
        $("#emp_username").attr("value", data[id].username);
        $("#emp_password").prop('disabled', true);
        var arr = data[id].admin_rights.split('#');
        for (var i = 0; i <= arr.length - 1; i++) {
            $("#c_" + arr[i]).prop('checked', true);
        }
        $("#add_emp_btn").prop('disabled',true).hide();
        $("#update_emp_btn").prop('disabled',false).show();
        $("#remove_emp_btn").prop('disabled',false).show();
//            $("#add_emp_btn").text("Update Emp");
//            $("#add_emp_btn").attr("id", "update_emp_btn");
        emp_admin_id = data[id].admin_id;

    });
}





$('#update_emp_btn').click(function () {
    //console.log('ehlofdlfdf');
    var mobile = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    var email = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    event.preventDefault();
    if ($('#emp_name').val().trim().length < 2) {
        showNotification('Please Provide Emp. Name');
        $('#emp_name').focus();
        return false;
    }
    if (!($('#emp_mobile').val().match(mobile))) {
        showNotification('Enter valid Phone No');
        $('#emp_mobile').focus();
        return false;
    }
    if (!(email.test($('#emp_email').val()))) {
        showNotification('Enter valid Email');
        $('#emp_email').focus();
        return false;
    }
    if ($('#emp_username').val().trim().length < 6) {
        showNotification('Enter valid UserName');
        $('#emp_username').focus();
        return false;
    }

    var data = {};
    data.admin_id = aid;
    data.emp_admin_id = emp_admin_id;
    data.emp_name = $('#emp_name').val().trim();
    data.emp_mobile = $('#emp_mobile').val().trim();
    data.emp_email = $('#emp_email').val().trim();
    data.emp_username = $('#emp_username').val().trim();
//    data.emp_password = $('#emp_password').val().trim();
    var ids = '';
    for (var i = 0; i < num_checkbox; i++) {
        if ($('#c_' + i).is(":checked")) {
            ids += $('#c_' + i).val();
            ids += '#';
        
        }
       }
    
    data.ids = ids.substr(0, ids.length - 1)
    if (ids.length == 0) {
        showNotification('top', 'left', 'Please Specify atleast One Right to your Employee');
        return false;
    }
    data.sname = 'ProfileService';
    data.fname = 'updateEmpProfile';
    data.isweb = '1';
    data.tval = '1';
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            var decrypt = atob(data);
            //console.log("result"+decrypt);
            var response = JSON.parse(decrypt);
            if (response.status === 0) {
                handleErrorData(response);//error alert should be here
            } else {
                swal('done ', 'success', 'success');
                setTimeout(function(){
                    location.reload();
                },1000);

//             alert('sucessfully Updated...;');
            }
        },
        error: function (err) {
            console.log("error function" + err);
        }
    }).done(function () {
    }).fail(function () {
        console.log('inside fail function');
    });

});



$("#remove_emp_btn").click(function(){
   var data = {};
    data.admin_id = aid;
    data.emp_admin_id = emp_admin_id;

    data.sname = 'ProfileService';
    data.fname = 'removeEmpProfile';
    data.isweb = '1';
    data.tval = '1';
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            var decrypt = atob(data);

            var response = JSON.parse(decrypt);
            if (response.status === 0) {
                handleErrorData(response);//error alert should be here
            } else {
                swal('done ', 'success', 'success');
                setTimeout(function(){
                    location.reload();
                },1000);

            }
        },
        error: function (err) {
            console.log("error function" + err);
        }
    }).done(function () {
    }).fail(function () {
        console.log('inside fail function');
    });

});

