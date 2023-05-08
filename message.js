
// Function to show the message and hide it after a specified duration
function showMessage(message, duration) {
    var messageDiv = document.createElement("div");
    messageDiv.className = "message";
    messageDiv.innerText = message;
    document.body.appendChild(messageDiv);
    setTimeout(function() {
        document.body.removeChild(messageDiv);
    }, duration);
}

