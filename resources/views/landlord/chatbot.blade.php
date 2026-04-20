<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3 text-base font-semibold text-blue-600 uppercase tracking-[0.2em]">
            <a href="{{ route('landlord.support') }}" class="text-slate-500 hover:text-blue-600 transition">
                ←
            </a>
            <span>Support</span>
            <span class="text-slate-400">/</span>
            <span>Chatbot</span>
        </div>
    </x-slot>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto px-4 py-6">

            <div class="bg-white shadow-md sm:rounded-3xl border border-slate-200 overflow-hidden">

                <!-- HEADER -->
                <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center text-2xl shadow-sm">
                            🤖
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold text-blue-600">
                                RentConnect Assistant
                            </h1>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="w-2.5 h-2.5 bg-green-500 rounded-full inline-block"></span>
                                <p class="text-sm text-slate-600">
                                    Online now • Landlord Support Bot
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CHAT AREA -->
                <div id="chat-box" class="p-6 bg-slate-50 min-h-[420px] space-y-5">

                    <!-- BOT WELCOME -->
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center text-lg shrink-0">
                            🤖
                        </div>

                        <div class="max-w-2xl">
                            <div class="bg-blue-100 text-slate-800 px-4 py-3 rounded-2xl shadow-sm">
                                Hi! I’m RentConnect’s virtual assistant. How can I help you today?
                            </div>

                            <div class="flex flex-wrap gap-2 mt-3">
                                <button type="button" class="faq-chip px-3 py-2 bg-white border border-blue-200 text-blue-600 rounded-full text-sm hover:bg-blue-50 transition">
                                    How do I create a listing?
                                </button>

                                <button type="button" class="faq-chip px-3 py-2 bg-white border border-blue-200 text-blue-600 rounded-full text-sm hover:bg-blue-50 transition">
                                    How do I view applications?
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- INPUT AREA -->
                <div class="p-4 border-t border-slate-200 bg-white">
                    <form id="chat-form" class="flex gap-3 items-center">
                        @csrf

                        <input type="hidden" id="role" value="landlord">

                        <input
                            type="text"
                            id="message"
                            class="flex-1 border border-slate-300 rounded-2xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-slate-50"
                            placeholder="Type your question here..."
                        >

                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-2xl hover:bg-blue-700 transition shadow-sm"
                        >
                            Send
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <script>
        const chatForm = document.getElementById('chat-form');
        const messageInput = document.getElementById('message');
        const roleInput = document.getElementById('role');
        const chatBox = document.getElementById('chat-box');

        async function sendMessage(message) {
            if (!message.trim()) {
                return;
            }

            // USER MESSAGE
            chatBox.innerHTML += `
                <div class="flex justify-end">
                    <div class="max-w-xl bg-blue-600 text-white px-4 py-3 rounded-2xl shadow-sm">
                        ${message}
                    </div>
                </div>
            `;

            messageInput.value = '';

            const response = await fetch("{{ route('chatbot.ask') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    message: message,
                    role: roleInput.value
                })
            });

            const data = await response.json();

            // BOT RESPONSE WITH AVATAR
            chatBox.innerHTML += `
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center text-lg shrink-0">
                        🤖
                    </div>

                    <div class="max-w-2xl bg-blue-100 text-slate-800 px-4 py-3 rounded-2xl shadow-sm">
                        ${data.reply}
                    </div>
                </div>
            `;

            chatBox.scrollTop = chatBox.scrollHeight;
        }

        chatForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const message = messageInput.value.trim();
            await sendMessage(message);
        });

        document.querySelectorAll('.faq-chip').forEach(button => {
            button.addEventListener('click', async function() {
                const question = this.textContent.trim();
                await sendMessage(question);
            });
        });
    </script>
</x-app-layout>