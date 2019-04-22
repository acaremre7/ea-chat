function sendMessage() {
    var message = createMessage();
    if(message.body){
        document.getElementById("message-area").disabled = true;
        document.getElementById("btn-send").disabled = true;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'send_message.php', false);
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhr.onload = function(){
            if(xhr.status === 200) {
                document.getElementById("message-area").value = "";
                getMessages();
            }else{
                alert("Error while sending message, HTTP error code: " + xhr.status);
            }
            document.getElementById("message-area").disabled = false;
            document.getElementById("btn-send").disabled = false;
        };
        xhr.send(JSON.stringify(message));
    }
}

function createMessage() {
    var message = {};
    message.sender = document.getElementById('sender').value;
    message.recipient = document.getElementById('recipient').value;
    message.body = document.getElementById("message-area").value;
    return message;
}

function getMessages() {
    var xhr = new XMLHttpRequest();
    var sender = document.getElementById('sender').value;
    var recipient = document.getElementById('recipient').value;
    xhr.open('GET', 'get_messages.php?p1=' + sender + '&p2=' + recipient, true);
    xhr.onload = function(){
        if(xhr.status === 200) {
            var html = '';
            var responseArray = JSON.parse(xhr.response);
            for(var i = 0;i<responseArray.length;i++){
                if(responseArray[i].sender === sender){
                    html+="<div class=\"message-row-s\">" +
                          "<span class=\"message-sent\">" + responseArray[i].message + "</span>" +
                          "</div>"
                }else{
                    html+="<div class=\"message-row-r\">" +
                          "<span class=\"message-received\">" + responseArray[i].message + "</span>" +
                          "</div>"
                }
            }
            var $messageContainer = document.getElementById("message-container");
            $messageContainer.innerHTML= html;
            $messageContainer.scrollTop = $messageContainer.scrollHeight;
        }else{
            alert("Error while retrieving messages");
        }
    };
    xhr.send();
}

function getUsers() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_users.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var html = "";
            var responseArray = JSON.parse(xhr.response);
            for(var i = 0;i<responseArray.length;i++){
                html += "<div class=\"user-line\" onclick=\"openMessageWindow('" + responseArray[i] + "')\">" +
                            "<span class=\"user-name\">" + responseArray[i] + "</span>" +
                        "</div>";
            }
            if(html) {
                document.getElementById("users-container").innerHTML = html;
            }else{
                document.getElementById("users-container").innerHTML = "Noone is online to talk :( <br/> <br/> Hint: Try opening the chat application from another browser - or private session to talk with yourself ;)";
            }
        } else {
            alert("Error while retrieving users");
        }
    };
    xhr.send();
}

function openMessageWindow(recipient) {
    var url = "chat.php?recipient=" + recipient;
    var win = window.open(url,'_blank');
    win.open();
}
