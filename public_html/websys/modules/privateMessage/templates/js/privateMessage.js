var privateMessage_partnerID = 0;
var privateMessage_partnerID_last = 0;
var first = true;
var busy = false;
var sending = false;
var showChatWindow = false;
var room_id = 0;
var lastID = 0;
var doScroll = true;
function numKeys(obj)
{
    var count = 0;
    for (var k in obj) {
        if (obj.hasOwnProperty(k)) {
           ++count;
        }
    }
    return count;
}

function makeMessages(data, noMsg)
{
    var toreturn = '';
    if(numKeys(data) > 0) {
        var date = '';
        var current_date = new Date();
        var MyDate = new Date();

        current_date = MyDate.getFullYear() + '-' + ('0' + (MyDate.getMonth()+1)).slice(-2) + '-' + ('0' + MyDate.getDate()).slice(-2);
        for(message in data) {
            if(parseInt(data[message].msg_id) <= parseInt(lastID)) {
                continue;
            }
            if (data.hasOwnProperty(message)) {
                lastID = parseInt(data[message].msg_id);
                if(data[message].date == current_date) {
                    date = data[message].time;
                } else {
                    date = data[message].date + ' ' + data[message].time;
                }
                toreturn += '<div class="privateMessage_chatWindow_message">';
                toreturn += '<div class="privateMessage_chatWindow_messageAuthor">' + '[' + date + '] ' + data[message].user.login + ':</div>';
                toreturn += '<div class="privateMessage_chatWindow_messageText">' + data[message].text.replace('\n', '<br />') + '</div>';
                toreturn += '</div>';
            }
        }
    } else if(typeof noMsg != 'undefined') {
        toreturn += '<div class="privateMessage_chatWindow_message">Нет сообщений</div>';
    }
    return toreturn;
}

function privateMessage_updateChat()
{
    if(room_id != 0 && busy == false && sending == false) {
        busy = true;
        $.get('/privateMessage/new', {'room_id':room_id, 'html':'true'}, function(response) {
            response = eval("(" + response + ")");
            if(response.status == 'true' || response.status == true) {
                $('#privateMessage_chatWindow_messageList').append(makeMessages(response.messages));
                if(doScroll) {
                    $('#privateMessage_chatWindow_messageList').scrollTo('100%');
                }
                sending = false;
            }
        });
        busy = false;
    }
    setTimeout('privateMessage_updateChat();', 700);
}

$(document).ready(function() {
    $('#privateMessage_mainWindow').draggable({containment: 'body', handle: '#privateMessage_mainWindow_title'});
    $('#privateMessage_chatWindow').draggable({containment: 'body', handle: '#privateMessage_chatWindow_title'});
    $('#privateMessage_chatWindow_messageList').mouseenter(function() {
        doScroll = false;
    });
    $('#privateMessage_chatWindow_messageList').mouseleave(function() {
        doScroll = true;
    });

    $('body').keydown(function (e) {
        if (e.keyCode === 27) {
            $('#privateMessage_chatWindow').hide();
            $('#privateMessage_mainWindow_contactList').slideUp();
        }
    });

    $('#privateMessage_mainWindow_close').click(function() {
        if($(this).text() == '[↓]') {
            $(this).text('[↑]');
            if(showChatWindow) {
                $('#privateMessage_chatWindow').show();
            }
            $('#privateMessage_mainWindow_contactList').slideDown();
        } else {
            $(this).text('[↓]');
            $('#privateMessage_chatWindow').hide();
            $('#privateMessage_mainWindow_contactList').slideUp();
        }
    });
    $('#privateMessage_chatWindow_close').click(function() {
        showChatWindow = false;
        $('#privateMessage_chatWindow').hide();
    });
    $('.privateMessage_contactList_contact').click(function() {
        $('#privateMessage_chatWindow').show();
        showChatWindow = true;
        lastID = 0;
        privateMessage_partnerID = $(this).attr('href').replace('#userProfile', '');
        if(privateMessage_partnerID != privateMessage_partnerID_last) {
            first = true;
        } else {
            first = false;
        }
        $('#privateMessage_chatWindow_username').text($(this).text());

        $.get('/privateMessage/createRoom', { users: [privateMessage_partnerID] }, function (response) {
            response = eval("(" + response + ")");
            room_id = response.room_id;
            $.get('/privateMessage/read', {'room_id':room_id, 'html':'true'}, function(response) {
                response = eval("(" + response + ")");
                if(response.status == 'true' || response.status == true) {
                    $('#privateMessage_chatWindow_messageList').html(makeMessages(response.messages, true));
                }
            });
        });

        if(first) {
            $('#privateMessage_chatWindow_writeBlock textarea').val('');
        }
        return false;
    });
    $('#privateMessage_chatWindow_writeBlock textarea').keypress(function(e) {
        var text = $(this).val();
        if(e.keyCode == 13) {
            if(sending == false) {
                sending = true;
                $.post('/privateMessage/write', {'room_id':room_id, 'text':text}, function(response) {
                    response = eval("(" + response + ")");
                    if(response.status == 'true' || response.status == true) {
                        $('#privateMessage_chatWindow_writeBlock textarea').val('');
                    }
                    sending = false;
                });
            }
            return false;
        }
        if(first && e.keyCode == 10) {
            $(this).val($(this).val() + '\n');
            first = false;
            return false;
        }
    });
});
privateMessage_updateChat();