<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f3e8ff; font-family: sans-serif; }
        .chat-container { max-width: 450px; margin: 20px auto; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); display: flex; flex-direction: column; height: 80vh; }
        .chat-box { flex: 1; padding: 15px; overflow-y: auto; background: #f9f6ff; }
        .message { margin-bottom: 12px; display: flex; }
        .message.user { justify-content: flex-end; }
        .message.admin { justify-content: flex-start; }
        .message .bubble { max-width: 75%; padding: 10px 14px; border-radius: 15px; font-size: 14px; }
        .message.user .bubble { background-color: #6f42c1; color: white; border-bottom-right-radius: 2px; }
        .message.admin .bubble { background-color: #e2d9f3; color: #333; border-bottom-left-radius: 2px; }
        .chat-input-area { padding: 10px; background: white; border-top: 1px solid #ddd; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px; }
        .btn-purple { background-color: #6f42c1; color: white; }
        .btn-purple:hover { background-color: #59339d; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="chat-container">
        <!-- Header -->
        <div class="p-3 bg-purple text-white text-center fw-bold" style="background-color: #6f42c1; border-top-left-radius: 12px; border-top-right-radius: 12px;">
            <i class="fa-solid fa-headset"></i> Admin နှင့် တိုက်ရိုက်ဆွေးနွေးရန်
        </div>

        <!-- Chat Messages Area -->
        <div class="chat-box" id="chat-box">
            <!-- Messages will load here dynamically -->
        </div>

        <!-- Input Area -->
        <div class="chat-input-area">
            <form id="chat-form" class="input-group">
                <input type="text" id="chat-input" class="form-control" placeholder="မက်ဆေ့ဂျ် ရေးရန်..." required>
                <button class="btn btn-purple" type="submit"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>

<script>
    const token = localStorage.getItem('auth_token') || localStorage.getItem('token');
    const chatBox = document.getElementById('chat-box');

    async function loadMessages() {
        try {
            let response = await fetch('/api/chat/messages', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            let res = await response.json();
            if(res.status === 'success') {
                chatBox.innerHTML = '';
                res.chats.forEach(chat => {
                    let senderClass = chat.sender_type === 'user' ? 'user' : 'admin';
                    chatBox.innerHTML += `
                        <div class="message ${senderClass}">
                            <div class="bubble">${escapeHtml(chat.message)}</div>
                        </div>
                    `;
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        } catch (err) {
            console.error('Error loading messages:', err);
        }
    }

    document.getElementById('chat-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        let inputField = document.getElementById('chat-input');
        let message = inputField.value.trim();
        if(!message) return;

        try {
            let response = await fetch('/api/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            });
            let res = await response.json();
            if(res.status === 'success') {
                inputField.value = '';
                loadMessages();
            }
        } catch (err) {
            console.error('Error sending message:', err);
        }
    });

    function escapeHtml(text) {
        let map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // Load messages on page load and poll every 3 seconds
    loadMessages();
    setInterval(loadMessages, 3000);
</script>

</body>
</html>