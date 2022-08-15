$('#login_btn').click(function (event) {
    event.preventDefault();
    //validate
    if ($('#username').val().trim().length <4) {
        showNotification('Enter valid username');
        $('#username').focus();
        $('#username').addClass('alert-danger');
        return false;
    }
    if ($('#password').val().trim().length < 4) {
        showNotification('Enter valid password');
        $('#password').focus();
        $('#password').addClass('alert-danger');
        if ($('#username').hasClass('alert-danger'))
            $('#username').removeClass('alert-danger');
        return false;
    }
    if ($('#login_btn').hasClass('disabled')) {
        return false;
    }
    $('#login_btn').addClass('disabled');

    $('#loader').fadeIn('slow');

    if ($('#password').hasClass('alert-danger'))
        $('#password').removeClass('alert-danger');
    if ($('#username').hasClass('alert-danger'))
        $('#username').removeClass('alert-danger');
    var data = {};
    data.username = $('#username').val().trim();
    data.password = $('#password').val().trim();
    data.sname = 'LoginRegister';
    data.fname = 'login';
    data.isweb = 1;
    data.tval = 1;
    $.ajax({
        url: '.././api/index.php',
        data: data,
        type: 'POST',
        success: function (data) {
            try {
                data = JSON.parse(atob(data));
            } catch (err) {
                //print error here
                $('#loader').hide();
                $('#login_btn').removeClass('disabled');
                showNotification('Failed to Communicate Server');
            }
            if (data.status == 0) {
                $('#loader').hide();
                handleErrorData(data, showNotification);
            } else {
                //redirect to the loggedinScreed and clear back history
                $('#loader').hide();
                window.location.href = "admin/index.php";
            }

        },
        error: function (err) {
            $('#loader').hide();
            $('#login_btn').removeClass('disabled');
        }
    }).done(function () {
        //ajax complete
        $('#login_btn').removeClass('disabled');
    }).fail(function () {
        //no internet
        $('#loader').hide();
        $('#login_btn').removeClass('disabled');
    });
    return false;
});

function showNotification(message) {
    $('#showErr').text(message);
    $('#showErr').fadeIn("slow");
    setTimeout(function () {
        $('#showErr').fadeOut();
        $('#showErr').text('');
    }, 3000);
}