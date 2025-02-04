<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatGPT Clone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            margin: auto;
            width: 100%;
            max-width: 600px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .chat-messages {
            padding: 20px;
            height: 400px;
            overflow-y: auto;
        }
        .message {
            margin-bottom: 15px;
        }
        .message.user {
            text-align: right;
        }
        .message.bot {
            text-align: left;
        }
        .message p {
            display: inline-block;
            padding: 10px;
            border-radius: 8px;
            max-width: 75%;
        }
        .message.user p {
            background-color: #007BFF;
            color: white;
        }
        .message.bot p {
            background-color: #f4f4f4;
            color: #333;
        }
        .chat-input {
            display: flex;
            padding: 15px;
            border-top: 1px solid #ddd;
            background-color: #fff;
        }
        .chat-input input {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }
        .chat-input button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .chat-input button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-messages" id="chatMessages"></div>
        <div class="chat-input">
            <input type="text" id="userInput" placeholder="Type your message here..." autocomplete="off">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        // Scroll to the bottom of the chat
        function scrollToBottom() {
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Add a message to the chat
        function addMessage(sender, text) {
            const chatMessages = document.getElementById('chatMessages');
            const message = document.createElement('div');
            message.classList.add('message', sender);
            const messageText = document.createElement('p');
            messageText.textContent = text;
            message.appendChild(messageText);
            chatMessages.appendChild(message);
            scrollToBottom();
        }

        // Simulate bot response
        function getBotResponse(userMessage) {
            // Replace this with your backend API for real responses
            if (userMessage.toLowerCase().includes("hello")) {
                return "Hello! How can I help you today?";
            }
            if (userMessage.toLowerCase().includes("how are you")) {
                return "I'm just a bot, but I'm doing great! How about you?";
            }
            return "I'm sorry, I didn't understand that. Can you rephrase?";
        }

        // Handle user message
        function sendMessage() {
            const userInput = document.getElementById('userInput');
            const userMessage = userInput.value.trim();
            if (userMessage === "") return;

            // Add user message to the chat
            addMessage("user", userMessage);

            // Clear input field
            userInput.value = "";

            // Get bot response
            setTimeout(() => {
                const botResponse = getBotResponse(userMessage);
                addMessage("bot", botResponse);
            }, 500);
        }
    </script>
</body>
</html>
