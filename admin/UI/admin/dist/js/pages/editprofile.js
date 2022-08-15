//working 

$(document).ready(function () {
    loadAdminProfile();
    
});

function loadAdminProfile(){
    $('#profile_btn').addClass('btn-success');
    $('#company_div').hide();
    var data = {};
    data.admin_id = aid;
    data.sname = 'ProfileService';
    data.fname = 'getAdminProfile';
    data.tval = 1;
    data.isweb = 1;
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            $('#update_profile_btn').removeClass('disabled');
            var decrypt = atob(data);
            var response = JSON.parse(decrypt);
            if (response.status == 0) {
                handleErrorData(data); //error alert should be here
            } else {
                var data = response.data;
                $('#admin_name').val(data.admin_name);
                $('#admin_phone').val(data.admin_phone);
                $('#admin_email').val(data.admin_email);
                $('#admin_username').val(data.username);
                admin_name = data.admin_name;
            }
        },
        error: function (err) {
            $('#update_profile_btn').removeClass('disabled');
        }
    }).done(function () {
        $('#update_profile_btn').removeClass('disabled');
    }).fail(function () {
//console.log('inside fail function');
        $('#update_profile_btn').removeClass('disabled');
    });
}

$('#company_btn').click(function () {

    $('#company_div').show();
    $('#profile_div').hide();
    $('#company_btn').removeClass('btn-primary');
    $('#company_btn').addClass('btn-success');
    $('#profile_btn').removeClass('btn-success');
    $('#profile_btn').addClass('btn-primary');
    var data = {};
    data.admin_id = aid;
    data.sname = 'CompanyService';
    data.fname = 'getCompanyBasicDetail';
    data.tval = 1;
    data.isweb = 1;
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            var decrypt = atob(data);
            var response = JSON.parse(decrypt);
            if (response.status == 0) {
                handleErrorData(data); //error alert should be here
            } else {
                var data = response.data;
                var companyDetail = data.company_detail;
                var companyRegDetail = data.company_registration_detail;
                $('#company_name').val(companyDetail.company_name);
                $('#company_gstn').val(companyRegDetail.gstin);
                $('#company_tin').val(companyRegDetail.tin_no);
                $('#company_pan').val(companyRegDetail.pan_no);
                $('#company_state').val(companyDetail.company_state);
                $('#company_country').val(companyDetail.company_country);
                $('#company_address').val(companyDetail.company_address);
            }
        },
        error: function (err) {

        }
    }).done(function () {
    }).fail(function () {
//console.log('inside fail function');
    });
});
$('#profile_btn').click(function () {
    $('#profile_div').show();
    $('#company_div').hide();
    $('#company_btn').removeClass('btn-success');
    $('#profile_btn').addClass('btn-success');
});
$('#update_profile_btn').click(function (event) {
    event.preventDefault();
    var mobile = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    var email = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if ($('#admin_name').val().trim().length == 0) {
        showNotification('Enter valid Name');
        $('#admin_name').focus();
        return false;
    }

    if (!($('#admin_phone').val().match(mobile))) {
        showNotification('Enter valid Phone No');
        $('#admin_phone').focus();
        return false;
    }
    if (!(email.test($('#admin_email').val()))) {
        showNotification('Enter valid Email');
        $('#admin_email').focus();
        return false;
    }
    if ($('#admin_username').val().trim().length < 4) {
        showNotification('Enter valid username');
        $('#admin_username').focus();
        return false;
    }
    if ($('#admin_password').val().trim().length < 6) {
        showNotification('Enter current Password to update');
        $('#admin_password').focus();
        return false;
    }
    if ($('#updatetprofile_btn').hasClass('disabled')) {
        return false;
    }

    $('#update_profile_btn').addClass('disabled');
    var data = {};
    data.admin_id = aid;
    data.admin_name = $('#admin_name').val().trim();
    data.admin_phone = $('#admin_phone').val().trim();
    data.admin_email = $('#admin_email').val().trim();
    data.admin_username = $('#admin_username').val().trim();
    data.current_password = $('#admin_password').val().trim();
    data.admin_type = 1;
    data.sname = 'ProfileService';
    data.fname = 'updateProfile';
    data.isweb = '1';
    data.tval = '1';
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            $('#update_profile_btn').removeClass('disabled');
            var decrypt = atob(data);
            var response = JSON.parse(decrypt);
            if (response.status == 0) {
                handleErrorData(response); //error alert should be here
            } else {
                swal("Done", "You profile updated", "success").then((value) => {
                    //window.location.href = "index.php?page_name=dashboard&lid=0";
                    $('#admin_password').val("");
                });

            }
        },
        error: function (err) {
            // console.log("error function" + err);
            $('#update_profile_btn').removeClass('disabled');
        }
    }).done(function () {
        $('#update_profile_btn').removeClass('disabled');
        $('#admin_password').val("");


    }).fail(function () {
        $('#update_profile_btn').removeClass('disabled');

    });
    return false;
});

// for update admin password
$('#update_admin_password').click(function (e) {
    console.log("inside update pass click");
//    $("#profile_div").prop('id', "showErr");
    e.preventDefault();
    if ($('#curr_pass').val().trim().length < 6) {
        showModelNotification('Enter Your Current Password');
        $('#curr_pass').focus();
        return false;
    }
    if ($('#new_pass').val().trim().length < 6) {
        showModelNotification('Enter new Password (min - 6 letters)');
        $('#new_pass').focus();
        return false;
    }

    if ($('#confirm_new_pass').val().trim().length < 6) {
        showModelNotification('Please Confirm New Password (min - 6 letters)');
        $('#current_password').focus();
        return false;
    }
    if ($('#new_pass').val().trim() != $('#confirm_new_pass').val().trim()) {
        showModelNotification('New Password & Confirm Password does not Match');
        $('#new_pass').focus();
        return false;
    }
    
    if ($('#update_admin_password').hasClass('disabled')) {
        return false;
    }
    
    $('#update_admin_password').addClass('disabled');
    
    var data = {};
    data.admin_id = aid;
    data.curr_pass = $('#curr_pass').val().trim();
    data.new_pass = $('#new_pass').val().trim();
    data.sname = 'ProfileService';
    data.fname = 'updateAdminPassword';
    data.isweb = '1';
    data.tval = '1';
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            $('#update_admin_password').removeClass('disabled');
            var decrypt = atob(data);
            var response = JSON.parse(decrypt);
            if (response.status == 0) {
                handleErrorData(response); //error alert should be here
            } else {
                swal("Done", "You Password updated", "success").then((value) => {
                    location.reload();
                });
            }
        },
        error: function (err) {
            //console.log("error function" + err);
            $('#update_admin_password').removeClass('disabled');
        }
    }).done(function () {
        $('#update_admin_password').removeClass('disabled');
    }).fail(function () {
//console.log('inside fail function');
        $('#update_admin_password').removeClass('disabled');
    });
    return false;
});


//API for update Company 
$('#company_update_btn').click(function (e) {
    e.preventDefault();
    $("#profile_div #showErr").prop('id', "");//reset id to show notification on current page.

    if ($('#company_name').val().trim().length === 0) {
        showNotification('Enter valid Name');
        $('#company_name').focus();
        return false;
    }
    if (!($('#company_gstn').val())) {
        showNotification('Enter company GSTN');
        $('#company_gstn').focus();
        return false;
    }
    if (!($('#company_tin').val())) {
        showNotification('Enter tin no tin ka dabba ');
        $('#company_tin').focus();
        return false;
    }
    if (!($('#company_pan').val())) {
        showNotification('Enter Pan ');
        $('#company_pan').focus();
        return false;
    }

    if ($('#company_update_btn').hasClass('disabled')) {
        return false;
    }
    $('#company_update_btn').addClass('disabled');

    var cdata = new FormData();
    var logo = $('input[type="file"]'); // for multiple files
    cdata.append("admin_id", aid);
    cdata.append("company_name", $('#company_name').val().trim());
    cdata.append("company_gstn", $('#company_gstn').val().trim());
    cdata.append("company_tin", $('#company_tin').val().trim());
    cdata.append("company_pan", $('#company_pan').val().trim());
    cdata.append("company_state", $('#company_state').val().trim());
    cdata.append("company_country", $('#company_country').val().trim());
    cdata.append("company_address", $('#company_address').val().trim());
    cdata.append("company_logo", logo[0].files[0]);
    cdata.append("admin_type", 1);
    cdata.append("sname", 'CompanyService');
    cdata.append("fname", 'updateCompanyProfile');
    cdata.append("isweb", '1');
    cdata.append("tval", '1');
    console.log(cdata);
    $.ajax({
        url: '../../api/index.php',
        data: cdata,
        type: 'POST',
        processData: false,
        contentType: false,
        success: function (cdata) {
            $('#company_update_btn').removeClass('disabled');
            var decrypt = atob(cdata);
            var response = JSON.parse(decrypt);
            if (response.status === 0) {
                handleErrorData(response); //error alert should be here
            } else {
                swal("Done", "Your Company Profile has beed updated", "success");//.then((value) => {
                // window.location.href = "index.php?page_name=dashboard&lid=0";
                //});
            }
        },
        error: function (err) {
            // console.log("error function" + err);
            $('#company_update_btn').removeClass('disabled');
        }
    }).done(function () {
        $('#company_update_btn').removeClass('disabled');

    }).fail(function () {
//console.log('inside fail function');
        $('#company_update_btn').removeClass('disabled');
    });
    return false;
});