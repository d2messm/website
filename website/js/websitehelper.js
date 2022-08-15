$(document).ready(function () {
//   $(window).on('load', function() { // makes sure the whole site is loaded 
//    $('#preloader').delay(500).fadeOut('slow');
//    $('#wrapper').delay(500).fadeIn('slow');
//  });
});
function handleErrorData(data) {
    if (data.is_valid_req == 0) {
//        window.location.href = 'https://www.crozeal.com';
        console.log(data);
    } else {
        //swal/toast the data.msg
        swal("error", data.msg, "error");
    }
}
function abc(abc){
    return abc;
}
function callAJAX(url, data, funcName){
    $('#loader').fadeIn('slow');
    return $.ajax({
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
            //console.log(err);
        }
    }).fail(function () {
        $('#loader').fadeOut('slow');
        swal("error", "Oops! Check your Internet Connectivity!");
    }).done(function () {
        $('#loader').fadeOut('slow');
        //ajax completed
    });
}
function callFileAJAX(url, data, type, funcname, id) {//id=progress
    $.ajax({
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    percentComplete = parseInt(percentComplete * 100);
                    if (id != null & percentComplete === 100) {
                        $('#' + id).css('width', 99);
                    } else if (id != null) {
                        $('#' + id).css('width', percentComplete);
                    }
                }
            }, false);
            return xhr;
        },
        url: url,
        data: data,
        type: type,
        contentType: false,
        processData: false,
        error: function (err) {
            console.log(err);
        },
        success: function (data) {
            data = atob(data);
            data = JSON.parse(data);
            if (Number(data.status) == 1) {
                if (id != null)
                    $('#' + id).css('width', "100%");
                funcname(data.data);
            } else {
                if (id != null)
                    $('#' + id).css('width', "0%");
                handleErrorData(data);
            }
        }
    }).done(function () {
        //work is complete 
    }).fail(function () {
        //ajax has failed
        swal("error", "Oops! Check your Internet Connectivity!");
    });
}




function showNotification(message) {
    $('#showErr').text(message);
    $('#showErr').fadeIn("slow");
    setTimeout(function () {
        $('#showErr').fadeOut();
        $('#showErr').text('');
    }, 3000);
}
function showModelNotification(message) {
    $('#showModelErr').text(message);
    $('#showModelErr').fadeIn("slow");
    setTimeout(function () {
        $('#showModelErr').fadeOut();
        $('#showModelErr').text('');
    }, 3000);
}



var nameRegex = /^[a-z ,.'-]+.{2,}$/i
var phnreg = /^[\d]{6,15}$/i
var gstinreg = /\d{2}[A-Z]{5}\d{4}[A-Z]{1}\d[Z]{1}[A-Z\d]{1}/i

var emailreg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var OnlypositiveNumregex = /[0-9]/