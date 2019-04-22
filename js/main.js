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
    message.sender = "sender_placeholder";
    message.recipient = "recipient_placeholder";
    message.body = document.getElementById("message-area").value;
    return message;
}

function getMessages() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_messages.php?p1=sender_placeholder&p2=recipient_placeholder', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.onload = function(){
        if(xhr.status === 200) {
            var html = '';
            var responseArray = JSON.parse(xhr.response);
            for(var i = 0;i<responseArray.length;i++){
                if(responseArray[i].sender === "sender_placeholder"){
                    html+="<div class=\"message-row-s\">" +
                          "<span class=\"message-sent\">" + responseArray[i].message + "</span>" +
                          "</div>"
                }else{
                    html+="<div class=\"message-row-r\">" +
                          "<span class=\"message-received\">" + responseArray[i].message + "</span>" +
                          "</div>"
                }
            }
            document.getElementById("message-container").innerHTML= html;
        }else{
            alert("Error while retrieving messages");
        }
    };
    xhr.send();
}
