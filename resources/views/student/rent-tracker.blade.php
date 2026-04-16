<x-app-layout>

    {{-- HEADER --}}
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <div class="flex items-center gap-4">
                <a href="{{ route('student.messages.show', $application->id) }}"
                    class="flex items-center justify-center w-9 h-9 rounded-full text-slate-500 hover:text-blue-600 hover:bg-slate-100 text-xl transition">
                    ←
                </a>

                <p class="text-lg font-bold uppercase tracking-[0.16em] text-blue-700">
                    Messages <span class="mx-1 text-slate-300">/</span> Rent Tracker
                </p>
            </div>
        </div>
    </x-slot>

    {{-- BODY --}}
    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                {{-- SUMMARY --}}
            <div class="px-6 py-3 bg-white border-b border-slate-200">
                <div class="flex items-center gap-4">
                    <div class="min-w-0">
                        <h3 class="text-lg font-semibold text-slate-900 truncate">
                            {{ $application->rental->landlord->firstname ?? 'Landlord' }}
                            {{ $application->rental->landlord->surname ?? '' }}
                        </h3>

                        <p class="text-sm text-slate-500 truncate mt-1">
                            {{ $application->rental->housenumber ?? '' }}
                            {{ $application->rental->street ?? '' }},
                            {{ $application->rental->county ?? '' }}
                        </p>
                    </div>
                </div>
            </div>

                            <div id="rt-summary" class="pl-12 pr-6 py-4 border-b border-slate-200">
                </div>

                {{-- FEED --}}
                <div id="rt-feed"
                     class="bg-slate-50 px-6 py-5 overflow-y-auto space-y-4"
                     style="min-height: 200px; max-height: calc(100vh - 360px);">
                </div>

                {{-- COMPOSER --}}
                <div class="border-t border-slate-200 bg-white px-6 py-4">
                    <div class="flex items-end gap-3 justify-center flex-wrap">
                        <input id="rt-date" type="date"
                               class="rounded-2xl border border-slate-300 px-4 py-3 text-sm">
                        <input id="rt-amount" type="number" step="100" min="0"
                               class="rounded-2xl border border-slate-300 px-4 py-3 text-sm"
                               placeholder="Amount (€)">
                        <button id="rt-pay"
                                class="rounded-2xl bg-blue-600 px-5 py-3 text-sm text-white">
                            Pay
                        </button>
                    </div>
                </div>

                {{-- STRIPE CARD FORM (hidden until Pay clicked) --}}
                <div id="stripe-form" class="hidden border-t border-slate-200 bg-white px-6 py-5">
                    <p class="text-sm font-medium text-slate-700 mb-3">Card details</p>
                    <div id="payment-element"
                         class="border border-slate-300 rounded-xl px-4 py-3 bg-white"></div>
                    <div id="payment-message" class="hidden text-red-600 text-sm mt-3"></div>
                    <div class="flex items-center gap-2 mt-4 mb-2">
                        <input type="checkbox" id="rt-save"
                               class="rounded border-slate-300 text-blue-600">
                        <label for="rt-save" class="text-xs text-slate-600">
                            Save my card details for future payments
                        </label>
                    </div>
                    <div class="flex gap-3 mt-2">
                        <button id="rt-submit"
                                class="flex-1 rounded-2xl bg-blue-600 px-5 py-3 text-sm text-white">
                            Confirm Payment
                        </button>
                        <button id="rt-cancel"
                                class="rounded-2xl border border-slate-300 px-5 py-3 text-sm text-slate-700">
                            Cancel
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3"></script>

    <script>
        const APP_ID      = @json($application->id);
        const GROUP_ID    = @json($groupId);
        const VIEWER_ID   = @json($viewerId);
        const VIEWER_NAME = @json(optional(\App\Models\Student::find($viewerId))->firstname ?? 'You');
        const STRIPE_KEY  = @json(config('services.stripe.public_key'));
        const CSRF_TOKEN  = '{{ csrf_token() }}';

        const feedEl     = document.getElementById('rt-feed');
        const summaryEl  = document.getElementById('rt-summary');
        const amountIn   = document.getElementById('rt-amount');
        const payBtn     = document.getElementById('rt-pay');
        const stripeForm = document.getElementById('stripe-form');
        const submitBtn  = document.getElementById('rt-submit');
        const cancelBtn  = document.getElementById('rt-cancel');
        const messageEl  = document.getElementById('payment-message');

        let RT = { balance: null, history: [] };
        let stripeInstance = null;
        let stripeElements = null;

        // ── BALANCE ──────────────────────────────────────────────
        async function refreshBalance() {
            const res  = await fetch(`/student/rent-tracker/balance?application_id=${APP_ID}`);
            RT.balance = await res.json();
            summaryEl.textContent = `Due €${RT.balance.monthly_due} • Paid €${RT.balance.paid} • Outstanding €${RT.balance.outstanding}`;
        }

        // ── FEED ─────────────────────────────────────────────────
        async function refreshFeed() {
            const res  = await fetch(`/student/rent-tracker/history?application_id=${APP_ID}&all=1`);
            const data = await res.json();
            RT.history = data.history;
            renderFeed(RT.history);
        }

        // ── DAY SEPARATOR HELPERS ────────────────────────────────
        function daySeparatorLabel(date) {
            const today = new Date(); today.setHours(0,0,0,0);
            const that  = new Date(date); that.setHours(0,0,0,0);
            const diff  = Math.round((that - today) / 86400000);
            if (diff === 0)  return 'Today';
            if (diff === -1) return 'Yesterday';
            return new Date(date).toLocaleDateString(undefined, { weekday: 'long', day: '2-digit', month: 'short', year: 'numeric' });
        }

        function separatorEl(label) {
            const wrap = document.createElement('div');
            wrap.className = 'flex justify-center my-2';
            wrap.innerHTML = `<span class="px-3 py-0.5 rounded-full bg-slate-200 text-slate-600 text-xs">${label}</span>`;
            return wrap;
        }

        // ── RENDER FEED ──────────────────────────────────────────
        function renderFeed(items) {
            feedEl.innerHTML = '';
            items.sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));

            let lastDay = '';

            items.forEach(it => {
                const date     = new Date(it.timestamp);
                const dayLabel = daySeparatorLabel(date);

                if (dayLabel !== lastDay) {
                    feedEl.appendChild(separatorEl(dayLabel));
                    lastDay = dayLabel;
                }

                const status     = (it.status || '').toLowerCase();
                const isReminder = status === 'reminder';

                if (isReminder) {
                    const isOverdue = (it.label || '').toLowerCase().includes('overdue');
                    const outer  = document.createElement('div');
                    outer.className = 'flex justify-start';
                    const bubble = document.createElement('div');

                    if (isOverdue) {
                        bubble.className = 'max-w-[75%] rounded-2xl px-4 py-3 text-sm shadow-sm bg-red-600 text-white';
                        bubble.innerHTML = `
                            <div class="text-xs font-semibold uppercase tracking-wide opacity-80 mb-1">Overdue</div>
                            <div class="text-base font-semibold">Rent Due: €${Number(it.amount).toFixed(2)}</div>
                            <div class="text-xs opacity-75 mt-1">Outstanding: €${Number(it.amount).toFixed(2)}</div>
                            <div class="text-xs opacity-75">Was due ${new Date(it.for_date).toLocaleDateString(undefined, {day: '2-digit', month: 'short', year: 'numeric'})}</div>
                        `;
                    } else {
                        bubble.className = 'max-w-[75%] rounded-2xl px-4 py-3 text-sm shadow-sm bg-green-600 text-white';
                        bubble.innerHTML = `
                            <div class="text-xs font-semibold uppercase tracking-wide opacity-80 mb-1">Rent Reminder</div>
                            <div class="text-base font-semibold">€${Number(it.amount).toFixed(2)}</div>
                            <div class="text-xs opacity-75 mt-1">Due ${new Date(it.for_date).toLocaleDateString(undefined, {day: '2-digit', month: 'short', year: 'numeric'})}</div>
                        `;
                    }

                    outer.appendChild(bubble);
                    feedEl.appendChild(outer);

                } else if (status === 'succeeded') {
                    const fromViewer = it.studentid && Number(it.studentid) === Number(VIEWER_ID);
                    const outer  = document.createElement('div');
                    outer.className = fromViewer ? 'flex justify-end' : 'flex justify-start';
                    const bubble = document.createElement('div');
                    bubble.className = `max-w-[75%] rounded-2xl px-4 py-3 text-sm shadow-sm ${fromViewer ? 'bg-blue-600 text-white' : 'bg-white text-slate-800 border border-slate-200'}`;
                    const paidBy = it.paid_by || 'Unknown';
                    bubble.innerHTML = `
                        <div class="text-base font-semibold">€${Number(it.amount).toFixed(2)}</div>
                        <div class="text-xs opacity-75">Paid by ${paidBy}</div>
                        <div class="text-[11px] opacity-60 mt-1">${date.toLocaleTimeString(undefined, {hour: '2-digit', minute: '2-digit'})}</div>
                    `;
                    outer.appendChild(bubble);
                    feedEl.appendChild(outer);
                }
            });

            if (!items.length) {
                feedEl.innerHTML = '<div class="text-sm text-slate-500 text-center py-6">No payments yet.</div>';
            }
        }

        // ── PAY BUTTON ───────────────────────────────────────────
        payBtn.addEventListener('click', async () => {
            const amount = parseFloat(amountIn.value || 0);
            if (!amount || amount <= 0) { alert('Enter an amount'); return; }

            payBtn.disabled = true;
            payBtn.textContent = 'Loading...';

            try {
                const res = await fetch('/student/rent-tracker/payment-intent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        application_id: APP_ID,
                        amount_eur: amount,
                        group_id: GROUP_ID
                    })
                });

                const json = await res.json();
                if (!res.ok) {
                    alert(json.message || 'Could not start payment');
                    payBtn.disabled = false;
                    payBtn.textContent = 'Pay';
                    return;
                }

                stripeInstance = Stripe(STRIPE_KEY);
                stripeElements = stripeInstance.elements();

                const cardElement = stripeElements.create('card', {
                    hidePostalCode: true,
                    disableLink: true,
                    style: {
                        base: {
                            fontSize: '16px',
                            color: '#424770',
                            fontFamily: 'ui-sans-serif, system-ui, sans-serif',
                            '::placeholder': { color: '#aab7c4' }
                        },
                        invalid: { color: '#dc2626' }
                    }
                });

                document.getElementById('payment-element').innerHTML = '';
                cardElement.mount('#payment-element');
                submitBtn.dataset.clientSecret = json.client_secret;
                stripeForm.classList.remove('hidden');
                messageEl.classList.add('hidden');

            } catch (e) {
                alert('ERROR: ' + e.message);
            } finally {
                payBtn.disabled = false;
                payBtn.textContent = 'Pay';
            }
        });

        // ── CANCEL ───────────────────────────────────────────────
        cancelBtn.addEventListener('click', () => {
            stripeForm.classList.add('hidden');
            messageEl.classList.add('hidden');
        });

        // ── CONFIRM PAYMENT ──────────────────────────────────────
        submitBtn.addEventListener('click', async () => {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Processing...';
            messageEl.classList.add('hidden');

            const clientSecret = submitBtn.dataset.clientSecret;
            const cardElement  = stripeElements.getElement('card');

            const { error, paymentIntent } = await stripeInstance.confirmCardPayment(clientSecret, {
                payment_method: { card: cardElement }
            });

            if (error) {
                messageEl.textContent = error.message;
                messageEl.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Confirm Payment';
            } else if (paymentIntent && paymentIntent.status === 'succeeded') {
                await fetch('/student/rent-tracker/confirm-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ payment_intent: paymentIntent.id })
                });

                stripeForm.classList.add('hidden');
                amountIn.value = '';
                await refreshBalance();
                await refreshFeed();
            }
        });

        // ── BOOT ─────────────────────────────────────────────────
        async function boot() {
            await refreshBalance();
            await refreshFeed();
        }

        boot();
    </script>

</x-app-layout>