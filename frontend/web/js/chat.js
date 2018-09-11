var
        conn = new WebSocket('ws://localhost:' + wsPort),
        rchat_id = document.getElementById('chat_screen'),
        msg = document.getElementById('input_msg');

conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onerror = function(e) {
    console.log('Connection failed');
};

conn.onmessage = function(e) {
    // rchat_id.value = e.data + '\n' + rchat_id.value;
    putNewLine(e.data);
    console.log(e.data);
};

function putNewLine(line_text) {
    // document.body.insertBefore(div, document.body.firstChild)
    var chat_line = document.createElement('p');
    chat_line.innerHTML = line_text;
    rchat_id.insertBefore(chat_line, rchat_id.firstChild);
}

document.getElementById('send_msg').addEventListener('click',function (e) {
    sendMsg();
});

document.getElementById('input_msg').addEventListener('keypress',function (e) {
    if (e.which == 13 || e.keyCode == 13) {
        sendMsg();
    }
});

function sendMsg() {
    if (msg.value) {
        conn.send(msg.value);
        msg.value = '';
    }
}
