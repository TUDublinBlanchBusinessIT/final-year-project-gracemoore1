<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Virtual Assistant
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-4xl mx-auto px-4 py-6">

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <!-- HEADER -->
                <div class="p-6 border-b border-slate-200">
                    <h1 class="text-2xl font-bold text-blue-600">
                        RentConnect
                    </h1>
                    <p class="text-slate-700 mt-1">
                        Student Virtual Assistant
                    </p>
                </div>

                <!-- CHAT MESSAGES -->
                <div id="chat-box" class="p-6 bg-slate-50 min-h-[400px] space-y-4">

                    <div class="flex">
                        <div class="bg-blue-100 text-slate-800 px-4 py-3 rounded-2xl max-w-xl">
                            Hi! I’m RentConnect’s virtual assistant. How can I help you today?
                        </div>
                    </div>

                </div>

                <!-- INPUT AREA -->
                <div class="p-4 border-t border-slate-200 bg-white">

                    <form id="chat-form" class="flex gap-3">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" id="role" value="student">

                        <input
                            type="text"
                            id="message"
                            class="flex-1 border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Type your question here..."
                        >

                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-5 py-3 rounded-xl hover:bg-blue-700 transition"
                        >
                            Send
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        document.getElementById('chat-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const messageInput = document.getElementById('message');
            const roleInput = document.getElementById('role');
            const chatBox = document.getElementById('chat-box');

            const message = messageInput.value.trim();
            const role = roleInput.value;

            if (!message) return;

            // USER MESSAGE
            chatBox.innerHTML += `
                <div class="flex justify-end">
                    <div class="bg-blue-600 text-white px-4 py-3 rounded-2xl max-w-xl">
                        ${message}
                    </div>
                </div>
            `;

            messageInput.value = '';

            // SEND TO BACKEND
            const response = await fetch("<?php echo e(route('chatbot.ask')); ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    message: message,
                    role: role
                })
            });

            const data = await response.json();

            // BOT RESPONSE
            chatBox.innerHTML += `
                <div class="flex">
                    <div class="bg-blue-100 text-slate-800 px-4 py-3 rounded-2xl max-w-xl">
                        ${data.reply}
                    </div>
                </div>
            `;

            chatBox.scrollTop = chatBox.scrollHeight;
        });
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/student/chatbot.blade.php ENDPATH**/ ?>