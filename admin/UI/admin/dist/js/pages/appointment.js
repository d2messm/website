//var currentAptId=0;
//getAppointments();
//function loadValue(data) {
//    //console.log(data);
//    document.getElementById("revenue").innerHTML = '₹ ' + data.revenue;
//    document.getElementById("customer_base").innerHTML = data.customer_base;
//    document.getElementById("new_customer").innerHTML = data.new_customer;
//    document.getElementById("stock_purchasing_amount").innerHTML = '₹ ' + data.stock_purchasing_amount;
//}
//function getAppointments() {
//    var requestData = {};
//    requestData.sname = 'AppointmentService';
//    requestData.fname = 'getAllPointments';
//    requestData.tval = '1';
//    requestData.isweb = '1';
//    requestData.admin_id = aid;
//    makeAJAX('../../api/index.php', requestData, handleAppointmentData);
//}
//
//function handleAppointmentData(responseData) {
//    var appointmentData='';
//    $.each(responseData, function (i, appointment) {
//        appointmentData+=('<tr id="'+appointment.appointment_id+'">');
//        appointmentData+=('<td>'+(i+1)+'</td>');
//        appointmentData+=('<td>'+appointment.name+'</td>');
//        appointmentData+=('<td>'+appointment.mobile+'</td>');
//        appointmentData+=('<td><input type="email" id="app_email_'+appointment.appointment_id+'" disabled value="'+appointment.email+'"></td>');
//        appointmentData+=('<td>'+appointment.service_name+'</td>');
//        appointmentData+=('<td>'+appointment.details+'</td>');
//        if(appointment.file_url.trim()==""){
//            appointmentData+=('<td>--NA--</td>');
//        }else{
//            appointmentData+=('<td><a href="'+appointment.file_url+'" target="_blank"><i class="fa fa-eye" style="font-size:36px"></i></a></td>');
//        }
//        if(Number(appointment.is_confirmed)==0){
//            appointmentData+=('<td><input type="date" value="'+appointment.pref_date+'" id="app_date_'+appointment.appointment_id+'"></input></td>');
//            appointmentData+=('<td id="btn_cnfrm_'+appointment.appointment_id+'"><a class="btn btn-success" onclick="confirmAppointment('+appointment.appointment_id+')">Confirm</a></td>');
//        }else{
//            appointmentData+=('<td>'+appointment.pref_date+'</td>');
//            appointmentData+=('<td><i class="fa fa-check" style="font-size:24px"></i></td>');
//        }
//        appointmentData+=('</tr>');
//    });
//    $('#appointment_tabel tbody').empty();
//    $('#appointment_tabel').append(appointmentData);
//    $('#appointment_tabel').DataTable({
//        responsive: true
//    });
//}
//
//function confirmAppointment(aptid){
//    var requestData = {};
//    currentAptId=aptid;
//    requestData.sname = 'AppointmentService';
//    requestData.fname = 'confirmAppointment';
//    requestData.tval = '1';
//    requestData.isweb = '1';
//    requestData.appointment_id =Number(aptid);
//    requestData.client_email =$('#app_email_'+aptid).val().trim();
//    requestData.client_date =$('#app_date_'+aptid).val().trim();
//    requestData.admin_id = aid;
//    makeAJAX('../../api/index.php', requestData, handleConfirmedAppointment);
//}
//function handleConfirmedAppointment(resposneData){
//    $('#btn_cnfrm_'+currentAptId).html('<i class="fa fa-check" style="font-size:24px"></i>');
//    currentAptId=0;
//    swal("","Appointment Confirmed","success");
//}
