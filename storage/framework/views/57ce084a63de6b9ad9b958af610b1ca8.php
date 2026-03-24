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
            Messages
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                
                <div class="border-b border-slate-200 px-6 py-4 bg-white">
                    <div class="flex items-center justify-between gap-4">

                        
                        <div class="flex items-center gap-4">
                            <a href="<?php echo e(route('student.messages')); ?>"
                               class="text-slate-500 hover:text-slate-700 text-xl">
                                ←
                            </a>

                            <div class="w-11 h-11 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-lg font-semibold">
                                <?php echo e(strtoupper(substr($application->rental->landlord->firstname ?? 'L', 0, 1))); ?>

                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                    <?php echo e($application->rental->landlord->firstname ?? 'Landlord'); ?>

                                    <?php echo e($application->rental->landlord->surname ?? ''); ?>

                                </h3>

                                <p class="text-sm text-slate-500">
                                    <?php echo e($application->rental->housenumber ?? ''); ?>

                                    <?php echo e($application->rental->street ?? ''); ?>,
                                    <?php echo e($application->rental->county ?? ''); ?>

                                </p>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->applicationtype === 'group' && $groupMembers->count()): ?>
                                    <p class="text-xs text-slate-400 mt-1">
                                        Group members: <?php echo e($groupMembers->pluck('firstname')->implode(', ')); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->status === 'accepted'): ?>
                            <button
                                id="btnRentTracker"
                                class="inline-flex items-center justify-center h-9 w-9 rounded-full hover:bg-gray-100"
                                title="Rent tracker"
                                data-application="<?php echo e($application->id); ?>"
                                data-group="<?php echo e($application->group_id ?? ''); ?>"
                                onclick="openRentTrackerModal(this)">
                                
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-6 w-6 text-emerald-600"
                                     viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 5H9a5 5 0 000 10h6v2H9a7 7 0 010-14h8v2z"/>
                                </svg>
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </div>
                </div>

                
                <div id="chatContainer" class="bg-slate-50 px-6 py-6 h-[500px] overflow-y-auto space-y-4">

                    <?php $lastDate = null; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $messageDate = \Carbon\Carbon::parse($message->created_at)->format('d M Y');
                            $loggedInStudentId = session('student_id');
                            $isOwnMessage = $message->sender_type === 'student'
                                            && $message->studentid == $loggedInStudentId;
                        ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastDate !== $messageDate): ?>
                            <div class="flex justify-center my-4">
                                <span class="px-4 py-1 rounded-full bg-slate-200 text-slate-600 text-xs">
                                    <?php echo e($messageDate); ?>

                                </span>
                            </div>
                            <?php $lastDate = $messageDate; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="flex <?php echo e($isOwnMessage ? 'justify-end' : 'justify-start'); ?>">
                            <div class="max-w-[75%]">

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->applicationtype === 'group'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->sender_type === 'student'): ?>
                                        <p class="text-xs text-black font-medium mb-1 <?php echo e($isOwnMessage ? 'text-right' : 'text-left'); ?>">
                                            <?php echo e(\App\Models\Student::find($message->studentid)->firstname ?? 'Student'); ?>

                                        </p>
                                    <?php else: ?>
                                        <p class="text-xs text-black font-medium mb-1 text-left">
                                            <?php echo e($application->rental->landlord->firstname ?? 'Landlord'); ?>

                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <div class="px-4 py-3 rounded-2xl text-sm shadow-sm
                                            <?php echo e($isOwnMessage 
                                                ? 'bg-blue-600 text-white rounded-br-md'
                                                : 'bg-white text-slate-800 border border-slate-200 rounded-bl-md'); ?>">
                                    <?php echo e($message->content); ?>

                                </div>

                                <div class="mt-1 text-[11px] text-slate-400 <?php echo e($isOwnMessage ? 'text-right' : 'text-left'); ?>">
                                    <?php echo e(\Carbon\Carbon::parse($message->created_at)->format('H:i')); ?>


                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOwnMessage): ?>
                                        <span class="ml-1">
                                            <?php echo e($message->is_read_by_landlord ? 'Seen' : 'Sent'); ?>

                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="flex justify-center items-center h-full">
                            <p class="text-sm text-slate-500">No messages yet.</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <div class="border-t border-slate-200 bg-white px-6 py-4">
                    <?php echo e(route('student.messages.store', $application->id)); ?>

                        <?php echo csrf_field(); ?>
                        <div class="flex-1">
                            <textarea
                                name="message"
                                rows="2"
                                class="w-full resize-none rounded-2xl border border-slate-300 px-4 py-3 text-sm
                                       focus:border-blue-400 focus:ring focus:ring-blue-100"
                                placeholder="Type your message here..."
                                required></textarea>
                        </div>

                        <button type="submit"
                                class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700">
                            Send
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const chat = document.getElementById("chatContainer");
            if (chat) { chat.scrollTop = chat.scrollHeight; }
        });
    </script>

    
    <div id="rentTrackerModal"
         class="hidden fixed inset-0 bg-black/40 z-40">
        <div class="bg-white rounded-xl shadow-xl max-w-lg w-full mx-auto mt-28 overflow-hidden">

            <div class="px-4 py-3 border-b flex items-center justify-between">
                <h3 class="font-semibold">Rent Tracker</h3>
                <button onclick="closeRentTrackerModal()" 
                        class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            <div class="p-4 space-y-4">

                <div class="flex items-center gap-2">
                    <label class="text-sm">Month</label>
                    <select id="rt-month"
                            class="border rounded px-2 py-1"></select>

                    <label class="text-sm">Year</label>
                    <select id="rt-year"
                            class="border rounded px-2 py-1"></select>
                </div>

                <div id="rt-summary"
                     class="text-sm text-gray-700"></div>

                <div>
                    <h4 class="font-medium mb-1">Payment History</h4>
                    <div id="rt-history"
                         class="max-h-56 overflow-auto text-sm space-y-1"></div>
                </div>

                <div class="border-t pt-3">
                    <div class="flex items-center gap-2">
                        <input id="rt-amount"
                               type="number" step="0.01" min="0"
                               class="border rounded px-2 py-1 w-32"
                               placeholder="Amount (€)">
                        <button id="rt-pay"
                                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded">
                            Pay with Stripe
                        </button>
                    </div>

                    <p id="rt-reminder"
                       class="mt-2 text-xs text-gray-500"></p>
                </div>

            </div>
        </div>
    </div>


    
    <script src="https://js.stripe.com/v3"></script>

    
    <script>
        const STRIPE_PUBLIC_KEY = <?php echo json_encode(config('services.stripe.public_key'), 15, 512) ?>;
        const stripe = Stripe(STRIPE_PUBLIC_KEY);

        const modal = document.getElementById('rentTrackerModal');
        const monthSel = document.getElementById('rt-month');
        const yearSel  = document.getElementById('rt-year');
        const summaryEl = document.getElementById('rt-summary');
        const histEl    = document.getElementById('rt-history');
        const reminderEl= document.getElementById('rt-reminder');
        const amountIn  = document.getElementById('rt-amount');
        const payBtn    = document.getElementById('rt-pay');

        const RT = {
            applicationId: null,
            groupId: null,
            month: new Date().getMonth() + 1,
            year: new Date().getFullYear(),
            balance: null,
        };

        function openRentTrackerModal(btn) {
            RT.applicationId = parseInt(btn.dataset.application);
            RT.groupId = btn.dataset.group ? parseInt(btn.dataset.group) : null;

            modal.classList.remove('hidden');
            populateMonthYear();
            refreshBalance();
        }

        function closeRentTrackerModal() {
            modal.classList.add('hidden');
        }

        function populateMonthYear() {
            monthSel.innerHTML = '';
            yearSel.innerHTML = '';

            for (let m = 1; m <= 12; m++) {
                const opt = document.createElement('option');
                opt.value = m;
                opt.text = new Date(2000, m - 1, 1).toLocaleString('default', {month: 'long'});
                if (RT.month === m) opt.selected = true;
                monthSel.appendChild(opt);
            }

            const yNow = new Date().getFullYear();
            for (let y = yNow - 1; y <= yNow + 1; y++) {
                const opt = document.createElement('option');
                opt.value = y;
                opt.text = y;
                if (RT.year === y) opt.selected = true;
                yearSel.appendChild(opt);
            }

            monthSel.onchange = () => {
                RT.month = parseInt(monthSel.value);
                refreshBalance();
            };
            yearSel.onchange = () => {
                RT.year = parseInt(yearSel.value);
                refreshBalance();
            };
        }

        async function refreshBalance() {
            const params = new URLSearchParams({
                application_id: RT.applicationId,
                month: RT.month,
                year: RT.year
            });

            if (RT.groupId !== null) params.set('group_id', RT.groupId);

            const balanceRes = await fetch(`/student/rent-tracker/balance?${params.toString()}`);
            const balance = await balanceRes.json();
            RT.balance = balance;

            summaryEl.textContent =
                `Due: €${balance.monthly_due} • Paid: €${balance.paid} • Outstanding: €${balance.outstanding}`;

            if (balance.due_date_iso) {
                const d = new Date(balance.due_date_iso);
                reminderEl.textContent =
                    `€${balance.outstanding} is due on ${d.toLocaleDateString()}`;
            } else {
                reminderEl.textContent = '';
            }

            const histRes = await fetch(`/student/rent-tracker/history?${params.toString()}`);
            const hist = await histRes.json();
            histEl.innerHTML = '';

            hist.history.forEach(item => {
                const row = document.createElement('div');
                row.className = 'flex justify-between border-b pb-1 text-sm';
                const when = new Date(item.timestamp).toLocaleString();
                row.innerHTML = `<span>${item.status}</span><span>€${item.amount}</span><span>${when}</span>`;
                histEl.appendChild(row);
            });

            payBtn.onclick = () => pay();
        }

        async function pay() {
            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            const amount = amountIn.value
                ? parseFloat(amountIn.value)
                : parseFloat(RT.balance.outstanding);

            const body = {
                application_id: RT.applicationId,
                month: RT.month,
                year: RT.year,
                amount_eur: amount
            };

            if (RT.groupId !== null) body.group_id = RT.groupId;

            const res = await fetch('/student/rent-tracker/payment-intent', {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf},
                body: JSON.stringify(body)
            });

            const data = await res.json();
            if (!res.ok) {
                alert(data.message || 'Payment failed');
                return;
            }

            const result = await stripe.confirmPayment({
                clientSecret: data.client_secret,
                confirmParams: {
                    return_url: window.location.href
                }
            });

            // After redirect back:
            setTimeout(() => confirmPayment(data.payment_intent), 1500);
        }

        async function confirmPayment(pi_id) {
            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            const res = await fetch('/student/rent-tracker/confirm-payment', {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf},
                body: JSON.stringify({payment_intent: pi_id})
            });

            const data = await res.json();
            if (data.ok) {
                refreshBalance();
            }
        }
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/student/messages/chat.blade.php ENDPATH**/ ?>