/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @Author Nishant
 */
$(document).ready(function () {
    
    var data = {};
    data.admin_id = aid;
    data.sname = 'ProfileService';
    data.fname = 'getAdminProfile';
    data.isweb = '1';
    data.tval = '1';
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (response) {
            var decrypt = atob(response);
            var result = JSON.parse(decrypt);
            var data = result.data;
            if (result.status == 0) {
                handleErrorData(data);
            } else {
                admin_name = data.admin_name;
                document.getElementById("profile_name").innerHTML = admin_name;
                document.getElementById("view_name").innerHTML = admin_name;
                document.getElementById("view_mobile").innerHTML = data.admin_phone;
                document.getElementById("view_email").innerHTML = data.admin_email;
            }
        },
        error: function (err) {
             //console.log("error function" + err);
        }
    }).done(function () {
    }).fail(function () {
        swal("server error", result.msg, "error");
    });
});


