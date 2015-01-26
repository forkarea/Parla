/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

setInterval( function() {
    $.get('app.php?action=user_table', function(data) {
        $('#user_table').html(data);
    });
}, 2000);

setInterval( function() {
    $.get('app.php?action=messages&sender='+$id+'&receiver='+receiver+'&last_id='+lastId, function(data) {
        $('#messages').html(data);
    });
}, 2000);

setInterval( function() {
    $.post('app.php?action=notify', {sender: $id});
}, 2000);


function send() {
    $.post('app.php?action=send', {sender: $id, receiver: receiver, message: $('#message').val()});
    $('#message').val('');
}

function refresh_image() {
    $('#image').attr(image_src+'?'+Math.random());
}

function togglePassword() {
    $('#password').toggle();
    $('#passwordButton').html($('#passwordButton').html()[0]=='S' ? 'Hide password/email' : 'Show password/email');
}

function userClick(id, key, name) {
    receiver = id;
    $('#chat_partner').html(''+key+', '+name);
    $('#user-'+key).css('background-color', 'red');
}

$(document).ready( function() {
    $('#message').keypress(function(e) {
        if(e.which == 13) send();
    });
});
