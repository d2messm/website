
$('#reset').click(function(){
   if($('#username_reset').val().trim().length < 2){
      showErrNotification('Enter valid username or email');
        $('#username_reset').focus();
        $('#username_reset').addClass('alert-danger');
        return false; 
   } 
   
   var data ={};
   data.username_email = $('#username_reset').val().trim();
   data.isweb = '1';
   data.tval = '1';
   data.sname = 'LoginRegister';
   data.fname = 'sendResetPasswordLink';
   
   $.ajax({
      
      url : '.././api/index.php',
      data: data,
      type: 'POST',
      success:function(data){
          var encrypt = atob(data);
          var response = JSON.parse(encrypt);
          if(response.status == 0){
             // handleErrorData(data,showNotification);
              alert(response.msg);
          }
          else{
              $('#username_reset').val('');
              $('#myModal').modal('hide');
              alert(response.msg);
          }
      },error:function(err){
      }
        
   }).done(function(){
   }).fail(function(){
   });
   
   
   
});
function showErrNotification(message){
    $('#showmodelErr').text(message);
    $('#showmodelErr').fadeIn("slow");
    setTimeout(function(){$('#showmodelErr').fadeOut();$('#showmodelErr').text('');},3000);
}