@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-purple-50 flex flex-col items-center justify-center py-10">
    <div class="bg-white shadow-xl rounded-2xl w-full max-w-3xl">
        <div class="bg-purple-700 text-white rounded-t-2xl px-6 py-4 flex items-center justify-between">
            <h2 class="text-xl font-semibold">AI Chatbot</h2>
            <span class="text-sm text-green-300">● Online</span>
        </div>

        <div id="chatbox" class="h-96 overflow-y-auto p-6 space-y-4 bg-gray-50">
            <div class="text-gray-500 text-center">Say hi to start chatting 💬</div>
        </div>

        <form id="chat-form" class="flex border-t">
            <input type="text" id="message" class="flex-grow p-4 focus:outline-none" placeholder="Type a message..." autocomplete="off">
            <button type="submit" class="bg-purple-600 text-white px-6 hover:bg-purple-700">Send</button>
        </form>
    </div>
</div>

<script>
document.getElementById('chat-form').addEventListener('submit', async function(e) {
    e.preventDefault();

    const message = document.getElementById('message').value.trim();
    if (!message) return;

    const chatbox = document.getElementById('chatbox');
    chatbox.innerHTML += `<div class="text-right text-purple-700"><strong>You:</strong> ${message}</div>`;

    const response = await fetch('{{ route('chatbot.message') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message })
    });

    const data = await response.json();
    chatbox.innerHTML += `<div class="text-left text-gray-700"><strong>Bot:</strong> ${data.reply}</div>`;
    document.getElementById('message').value = '';
    chatbox.scrollTop = chatbox.scrollHeight;
});
</script>
@endsection
