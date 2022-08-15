$(document).ready(function () {
//   $(window).on('load', function() { // makes sure the whole site is loaded 
//    $('#preloader').delay(500).fadeOut('slow');
//    $('#wrapper').delay(500).fadeIn('slow');
//  });
});
function handleErrorData(data, errorfunc) {
    if (data.is_valid_req == 0) {
        window.location.href = 'https://www.bsrnetwork.in';
    } else {
        //swal/toast the data.msg
        errorfunc(data.msg);
    }
}
function makeAJAX(url, data, funcName) {
    $('#loader').fadeIn('slow');
    $.ajax({
        data: data,
        url: url,
        type: 'POST',
        success: function (data) {
            $('#loader').fadeOut('slow');
            data = atob(data);
            data = JSON.parse(data);
            if (Number(data.status) == 1) {
                funcName(data.data);
            } else {
                handleErrorData(data);
            }
        },
        error: function (err) {
            $('#loader').fadeOut('slow');
            console.log(err);
        }
    }).fail(function () {
        $('#loader').fadeOut('slow');
        swal("error", "Oops! Check your Internet Connectivity!");
    }).done(function () {
        $('#loader').fadeOut('slow');
        //ajax completed
    });
}
