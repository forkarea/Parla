setInterval( function() {
    $.get('app.php?action=user_table', function(data) {
        $('#user_table').html(data);
    });
}, 2000);

setInterval( function() {
    $.get('app.php?action=messages', function(data) {
        $('#messages').html(data);
    });
}, 2000);

setInterval( function() {
    $.post('app.php?action=notify', {sender: $id});
}, 2000);


function send() {
    $.post('app.php?action=send', {sender: $id, message: $('#message').val()});
    $('#message').val('');
}

function refresh_image() {
    $('#image').attr(image_src+'?'+Math.random());
}

function togglePassword() {
    $('#password').toggle();
    $('#passwordButton').html($('#passwordButton').html()[0]=='S' ? 'Hide password' : 'Show password');
}

$(document).ready( function() {
    $('#message').keypress(function(e) {
        if(e.which == 13) send();
    });
});
