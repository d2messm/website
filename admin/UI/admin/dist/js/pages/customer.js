/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @nishant
 */
//
$(document).ready(function() {
    var customer_data = '';
    var data = {};
    data.sname = 'ProfileService';
    data.fname = 'getAllCustomerDetail';
    data.isweb = '1';
    data.tval = '1';
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (response) {

            //console.log('response ' +response);

            var encrypt = atob(response);
            var parse = JSON.parse(encrypt);
            //console.log(parse);
            if (parse.status == 0) {
                swal("error", parse.msg, "error");
            } else {
                var sno=1;
                $.each(parse.data, function (i, customers) {
                    if(customers.customer_email==''|| customers.customer_email==null)
                        customers.customer_email='--';
                    if(customers.customer_name==''|| customers.customer_name==null)
                        customers.customer_name='--';
                    if(customers.customer_phone==''|| customers.customer_phone==null)
                        customers.customer_phone='--';
                    if(customers.customer_address==''|| customers.customer_address==null)
                        customers.customer_address='--';
                   customer_data += '<tr trid='+customers.customer_id+ '>';
                   customer_data += '<td>'+sno+'</td>';
                   customer_data += '<td>'+customers.customer_name+'</td>';
                   customer_data += '<td >'+customers.customer_email+'</td>';
                   customer_data += '<td>'+customers.customer_phone+'</td>';
                   customer_data += '<td>'+customers.customer_address+'</td>';
                   customer_data += '<td><i data-toggle="modal" data-target="#myModal"  id="fetch_customer_details" data-id=' +customers.customer_id + ' class="fa fa-pencil" style="font-size:24px;color:#3c8dbc;cursor:pointer"></in></td>';
                   customer_data += '</tr>';
                   sno++;

                   });
                   $('#customer_table').append(customer_data);
                   $('#customer_table').DataTable({
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

});

$(document).on('click','#fetch_customer_details',function(){

   // var id =$(this).data('id');
   // alert(id);
     var data = {};
     data.customer_id = $(this).data('id');
     data.sname = 'ProfileService';
     data.fname = 'getCustomerProfile';
     data.isweb = '1';
     data.tval = '1';

     $.ajax({
         url: '../../api/index.php',
         data:data,
         type:'POST',
         success:function(data){

             encrypt = atob(data);
            response  =  JSON.parse(encrypt);
            if(response.status == 0){
                handleErrorData(response);
                //inside('0');
            }else{
                $('#u_customer_name').val(response.data.customer_name);
                $('#u_customer_email').val(response.data.customer_email);
                $('#u_customer_phone').val(response.data.customer_phone);
                $('#u_customer_address').val(response.data.customer_address);


            }
         }

     }).done(function(){
         //alert('indise done');
        // handleErrorData(response);
     }).fail(function(){

         //handleErrorData(response);

     });


});


$('#update_customer').click( function(){

    event.preventDefault();
    if($('#u_customer_name').val().trim().length < 2){
        showModelNotification('Name required');
        $('#u_customer_name').focus();
        return false;
    }

    if($('#u_customer_email').val().trim().length < 2){
        showModelNotification('Email is required');
        $('#u_customer_email').focus();
        return false;
    }

    if($('#u_customer_phone').val().trim().length < 1){
        showModelNotification('Phone No is required');
        $('#u_customer_phone').focus();
        return false;
    }
    if($('#update_customer').hasClass('disabled')){
        return false;
    }
    $('#update_customer').addClass('disabled');

    var data={};
    data.admin_id = aid;
    data.customer_id = response.data.customer_id;
    data.customer_name = $('#u_customer_name').val().trim();
    data.customer_email = $('#u_customer_email').val().trim();
    data.customer_phone = $('#u_customer_phone').val().trim();
    data.customer_address = $('#u_customer_address').val().trim();
    //data.is_a_company = response.data.is_a_company;
    //data.company_id = response.data.company_id;
    data.sname = 'ProfileService';
    data.fname = 'updateCustomerProfile';
    data.isweb = '1';
    data.tval = '1';

    //alert('inside');
    $.ajax({
        url: '../../api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            //console.log("data" +data);
            $('#update_customer').removeClass('disabled');
            var decrypt = atob(data);
            //console.log('recieved'+decrypt);
            var response = JSON.parse(decrypt);
            //alert('Akssh');
            if (response.status == 0) {
                handleErrorData(response);
            } else {
                swal('Done', 'Customer details updated', 'success');
               // handleErrorData(response);
                setTimeout(function () {
                    location.reload();
                }, 3000);
            }
        }, error: function (err) {
            //alert('erroe');
           // console.log('error function', +err);
            $('#update_customer').removeClass('disabled');
        }
    }).done(function () {
        //alert('done');
        $('#update_customer').removeClass('disabled');
    }).fail(function () {
        alert('fail');
        $('#update_customer').removeClass('disabled');
        //console.log('inside fail function');
    });

});
