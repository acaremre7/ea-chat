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
    message.sender = "Sender";
    message.recipient = "Recipient";
    message.body = document.getElementById("message-area").value;
    return message;
}

function getMessages() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_messages.php', true);
    xhr.send();
}