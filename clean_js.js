$("page").ready(function() {
    $.ajax({
        type: 'POST',
        url: "modules/getContent.php",
        data: 'action=run',
        success: function(data) {
            $(".content").html(data);
        }
    });
});
function logout() {
    $.ajax({
        type: 'POST',
        url: 'authMeLogin/logout.php',
        data: 'action=logout',
        success: function(){
            location.href = "/";
        }
    });
}

function sAlert(status, message) {
    $(".console_form_alert").html('<div class="alert alert-' + status + '" role="alert">' + message + '</div>');
}

function run() {
    $(".console_form_alert").html("");
    $.ajax({
        type: 'POST',
        url: 'modules/console.php',
        data: 'action=sendCommand&command=' + $("#command").val(),
        success: function(data) {
            var result = JSON.parse(data);
            if(result.code == 0) {
                location.href = "/";
            }
            sAlert(result.status, result.message);
        }
    });
}

function getCommands() {
    $.ajax({
        type: 'POST',
        url: 'modules/console.php',
        data: 'action=getCommands',
        success: function(data){
            $(".commands").html(data);
        }
    });
}

function setCommandVal(str) {
    $("#command").val(str);
}
