//Check validate input and send for processing
function submit(btn) {
    btn = document.getElementById('btn');

    let sender_name = document.getElementById('sender_name');

    let sender_email = document.getElementById('sender_email');

    let messageSubject = document.getElementById('msg-subject');

    if (messageSubject.value == "") messageSubject.value = "No Subject"; //Setting default Message subject for Mail

    let messageBody = document.getElementById('msg-body');

    if (sender_name.value == "") {
        showMessage("Please tell me your name");
        return false;
    } else if (sender_email.checkValidity() == false) {
        showMessage("Invalid Email Address");
        return false;
    } else if (messageBody.value == "") {
        showMessage("The Message box cannot be empty");
        return false;
    } else {

        //disable clicked button
        btn.style = "background-color:salmon";
        btn.disabled = true;

        conjuctor = "&"
        data_to_send = "name=" + sender_name.value + conjuctor + "email=" + sender_email.value + conjuctor +
            "subject=" + messageSubject.value + conjuctor + "message=" + messageBody.value;

        destination = "sendMail.php";
        showWaitingMessage();
        sendForProcess(data_to_send, destination)
    }
}

// function to send input
function sendForProcess(data, destination) {
    let xmlSender = new XMLHttpRequest();
    xmlSender.onreadystatechange = () => {
        if (xmlSender.readyState == 4 && xmlSender.status == 200) {
            if (xmlSender.responseText == "1") {
                showMessage('Message sent successfully');
            } else {
                showMessage("<font color ='red'> Error encountered, please retry </font>")
            }
            //return Boolean(xmlSender.responseText);
        }
    }

    let conjuctor = "?";
    xmlSender.open('get', destination + conjuctor + data, true);
    xmlSender.send();
}

//Show message function
function showMessage(message) {
    document.getElementById('msg').innerHTML = message
}

function showWaitingMessage() {
    document.getElementById('msg').innerHTML = "Please Wait..."
}