@extends('layouts.app')

@section('content')
<div class="min-h-screen w-full bg-purple-900 flex items-center justify-center">

    <div class="w-full max-w-6xl h-[700px] bg-white shadow-xl rounded-2xl flex overflow-hidden">

        <!-- LEFT SIDEBAR -->
        <div class="w-1/4 bg-purple-800 text-white p-6 flex flex-col">
            <button id="new-scenario" class="bg-purple-700 px-4 py-3 rounded-xl mb-4 text-left hover:bg-purple-600">
                + New Scenario
            </button>

            <button id="clear-chat" class="bg-purple-700 px-4 py-3 rounded-xl text-left hover:bg-purple-600 mt-2">
                Clear Conversation
            </button>

            <div class="mt-auto text-sm text-purple-100">
                <div class="mb-2">Mode: <strong>Phishing Simulator</strong></div>
                <div class="text-xs">Use for authorized training only.</div>
            </div>
        </div>

        <!-- RIGHT CHAT PANEL -->
        <div class="w-3/4 flex flex-col">
            <!-- HEADER -->
            <div class="bg-purple-700 text-white px-6 py-4 flex justify-between items-center rounded-tr-2xl">
                <h2 class="text-xl font-bold">AI Chatbot - Phishing Simulator</h2>
                <span class="text-green-300">● Online</span>
            </div>

            <!-- CHATBOX -->
            <div id="chatbox" class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50">
                <div class="text-gray-500 text-center">Starting scenario...</div>
            </div>

            <!-- INPUT BAR -->
            <form id="chat-form" class="flex items-center border-t p-4 space-x-3 bg-white rounded-b-2xl">
                <input
                    id="message"
                    class="flex-grow bg-gray-100 px-4 py-3 rounded-full focus:outline-none"
                    placeholder="Type a message..."
                    autocomplete="off"
                >
                <button
                    class="bg-purple-600 text-white px-5 py-2 rounded-full hover:bg-purple-700">
                    Send
                </button>
            </form>
        </div>
    </div>
</div>

<script>
const chatbox = document.getElementById('chatbox');
const form = document.getElementById('chat-form');
const input = document.getElementById('message');
const newScenarioBtn = document.getElementById('new-scenario');
const clearChatBtn = document.getElementById('clear-chat');

// Helper to append messages
function appendMessage(who, text) {
    const safeText = text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
    if (who === 'user') {
        chatbox.innerHTML += `
            <div class="flex justify-end">
                <div class="bg-purple-600 text-white px-4 py-3 rounded-2xl max-w-xs shadow">
                    ${safeText}
                </div>
            </div>
        `;
    } else {
        chatbox.innerHTML += `
            <div class="flex justify-start">
                <div class="bg-white border px-4 py-3 rounded-2xl max-w-xs shadow">
                    ${safeText}
                </div>
            </div>
        `;
    }
    chatbox.scrollTop = chatbox.scrollHeight;
}

// Auto-start: request a random scenario via __init__
window.onload = function () {
    fetch("{{ route('chatbot.message') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ message: "__init__" })
    })
    .then(r => r.json())
    .then(data => {
        chatbox.innerHTML = ''; // clear "Starting scenario..." text
        appendMessage('attacker', data.reply);
    })
    .catch(() => {
        chatbox.innerHTML = '<div class="text-red-500">Error starting scenario.</div>';
    });
};

// Submit user message
form.addEventListener('submit', async function (e) {
    e.preventDefault();
    const message = input.value.trim();
    if (!message) return;
    appendMessage('user', message);
    input.value = '';

    try {
        const res = await fetch("{{ route('chatbot.message') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message })
        });
        const data = await res.json();
        appendMessage('attacker', data.reply);
    } catch (err) {
        appendMessage('attacker', 'Error: Cannot connect to server.');
    }
});

// New Scenario button: re-init session with a fresh scenario
newScenarioBtn.addEventListener('click', function () {
    fetch("{{ route('chatbot.message') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ message: "__init__" })
    })
    .then(r => r.json())
    .then(data => {
        chatbox.innerHTML = '';
        appendMessage('attacker', data.reply);
    });
});

// Clear conversation (client + also clear session by calling __init__ and discarding response)
clearChatBtn.addEventListener('click', function () {
    // We will call init to reset server-side history then clear UI
    fetch("{{ route('chatbot.message') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ message: "__init__" })
    })
    .then(r => r.json())
    .then(_ => {
        chatbox.innerHTML = '<div class="text-gray-500 text-center">Conversation cleared. Click "New Scenario" to start.</div>';
    });
});
</script>
@endsection
