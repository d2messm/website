$(document).ready(function () {
    var data = {};
    data.isweb = 1;
    data.tval = 1,
    data.admin_id = aid;
    data.sname = 'ProfileService';
    data.fname = 'getAdminRights';
    makeAJAX('../../api/index.php', data, loadRights);
});
function loadRights(data) {
    
    var rightLi = '<li class="header">MAIN NAVIGATION</li>';
    for (var i = 0; i < data.length; i++)
    {
        if (i == 0)
            rightLi += '<li id="' + i + '" class="active">';
        else
            rightLi += '<li id="' + i + '">';
        rightLi += '<a href="index.php?page_name=' + data[i].page_name + '&lid=' + i + '"><i class="' + data[i].icon + '"></i> <span>' + data[i].Display_name + '</span></a></li>';
    }
    $('#user_rights').html(rightLi);
    $("#user_rights li").removeClass("active");
    $("#" + lid).addClass("active");
}

