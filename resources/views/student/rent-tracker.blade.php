<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('student.messages.show', $application->id) }}" class="text-slate-500 hover:text-slate-700 text-xl">←</a>

                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 text-sm font-semibold">
                    {{ strtoupper(substr($application->rental->landlord->firstname ?? 'L', 0, 1)) }}
                </div>

                <div>
                    <div class="text-base font-semibold text-slate-900">
                        {{ $application->rental->landlord->firstname ?? 'Landlord' }}
                        {{ $application->rental->landlord->surname ?? '' }}
                    </div>
                    <div class="text-xs text-slate-500">
                        {{ $application->rental->housenumber ?? '' }}
                        {{ $application->rental->street ?? '' }},
                        {{ $application->rental->county ?? '' }}
                    </div>
                </div>
            </div>

            <div>
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 text-xl font-semibold">€</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

            {{-- Rent payment for: [calendar date] + All toggle --}}
            <div class="px-4 pt-4 flex items-center gap-3 flex-wrap">
                <span class="text-sm font-medium text-slate-700">Rent payment for:</span>
                <input id="rt-date" type="date"
                       class="border rounded px-2 py-1 text-sm"
                       style="min-width: 12rem;">
                <button id="rt-all" class="ml-auto text-xs px-2 py-1 rounded border hover:bg-slate-50">
                    All
                </button>
            </div>

            {{-- Summary --}}
            <div id="rt-summary" class="px-4 py-2 text-sm text-slate-700"></div>

            {{-- Reminder bubble (blue/grey) --}}
            <div id="rt-reminder" class="px-4 hidden">
                <div class="flex justify-start">
                    <div class="max-w-[80%] rounded-2xl px-4 py-3 shadow-sm bg-slate-50 text-slate-800 border border-slate-200 rounded-bl-md">
                        <div class="text-xs uppercase tracking-wide text-slate-500 mb-1">Reminder from landlord</div>
                        <div id="rt-reminder-text" class="text-sm font-medium"></div>
                        <div class="mt-2">
                            <button id="rt-reminder-pay" class="text-xs px-3 py-1.5 rounded bg-sky-500 text-white hover:bg-sky-600">
                                Pay now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chat feed --}}
            <div id="rt-feed" class="px-4 pb-4 pt-2 space-y-2 max-h-[65vh] overflow-y-auto">
                <!-- JS renders chat bubbles & date separators here -->
            </div>

            {{-- Quick pay --}}
            <div class="border-t border-slate-200 px-4 py-4 bg-white flex items-center gap-2">
                <input id="rt-amount" type="number" step="0.01" min="0" class="border rounded px-3 py-2 w-40" placeholder="Amount (€)">
                <button id="rt-pay" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded">
                    Pay with Stripe
                </button>
            </div>

        </div>
    </div>

    {{-- Stripe.js --}}
    <script src="https://js.stripe.com/v3"></script>

    {{-- Page script --}}
    <script>
    const STRIPE_PUBLIC_KEY = @json(config('services.stripe.public_key'));
    const stripe = Stripe(STRIPE_PUBLIC_KEY);

    const APP_ID    = @json($application->id);
    const GROUP_ID  = @json($groupId);
    const VIEWER_ID = @json($viewerId);
    const IS_GROUP  = @json(($application->applicationtype ?? '') === 'group');

    // Elements
    const dateInp   = document.getElementById('rt-date');
    const allBtn    = document.getElementById('rt-all');
    const summaryEl = document.getElementById('rt-summary');
    const feedEl    = document.getElementById('rt-feed');

    const reminderWrap = document.getElementById('rt-reminder');
    const reminderTxt  = document.getElementById('rt-reminder-text');
    const reminderPay  = document.getElementById('rt-reminder-pay');

    const amountIn  = document.getElementById('rt-amount');
    const payBtn    = document.getElementById('rt-pay');

    const RT = {
      applicationId: APP_ID,
      groupId: GROUP_ID ?? null,
      filterDate: null,  // YYYY-MM-DD
      balance: null,
      history: [],
    };

    async function boot() {
      await refreshBalance();
      setDefaultDateFromBalance();
      await refreshFeed(true);
    }

    function setDefaultDateFromBalance() {
      const dueIso = RT.balance?.due_date_iso;
      const d = dueIso ? new Date(dueIso) : new Date();
      const y = d.getFullYear(), m = String(d.getMonth()+1).padStart(2,'0'), day = String(d.getDate()).padStart(2,'0');
      dateInp.value = `${y}-${m}-${day}`;
      RT.filterDate = dateInp.value;
    }

    // ===== Fetchers =====
    async function refreshBalance() {
      const params = new URLSearchParams({ application_id: RT.applicationId });
      if (RT.groupId !== null) params.set('group_id', RT.groupId);

      const now = new Date();
      params.set('month', now.getMonth()+1);
      params.set('year',  now.getFullYear());

      const res = await fetch(`/student/rent-tracker/balance?${params.toString()}`);
      RT.balance = await res.json();
      summaryEl.textContent = `Due: €${RT.balance.monthly_due} • Paid: €${RT.balance.paid} • Outstanding: €${RT.balance.outstanding}`;
      renderReminder();
    }

    async function refreshFeed(all = false) {
      const params = new URLSearchParams({ application_id: RT.applicationId });
      if (RT.groupId !== null) params.set('group_id', RT.groupId);
      if (all) params.set('all', '1');

      const res = await fetch(`/student/rent-tracker/history?${params.toString()}`);
      const data = await res.json();
      RT.history = Array.isArray(data.history) ? data.history : [];
      renderFeed(RT.history);
    }

    // ===== Reminder bubble (as its own chat bubble) =====
    function renderReminder() {
      reminderWrap.classList.add('hidden');
      const bal = RT.balance;
      if (!bal?.due_date_iso) return;

      const due = new Date(bal.due_date_iso);
      const now = new Date();
      const ms  = due.setHours(0,0,0,0) - now.setHours(0,0,0,0);
      const days = Math.round(ms / 86400000);

      if (parseFloat(bal.outstanding) > 0 && days <= 2) {
        reminderTxt.textContent = `€${bal.outstanding} due on ${formatDayMonth(due)}.`;
        reminderWrap.classList.remove('hidden');

        reminderPay.onclick = () => pay(parseFloat(bal.outstanding));
      }
    }

    // ===== Chat feed rendering =====
    function renderFeed(items) {
      feedEl.innerHTML = '';
      items.sort((a,b) => new Date(b.timestamp) - new Date(a.timestamp));

      let lastDay = '';
      for (const it of items) {
        const d   = new Date(it.timestamp);
        const day = daySeparatorLabel(d);
        const ok  = (it.status || '').toLowerCase() === 'succeeded';

        if (day !== lastDay) {
          feedEl.appendChild(separatorEl(day));
          lastDay = day;
        }

        const isStudentPayment = it.studentid && Number(it.studentid) > 0;
        const fromViewer       = isStudentPayment && Number(it.studentid) === Number(VIEWER_ID);

        feedEl.appendChild(bubbleEl({
          sideRight: fromViewer,               // only sender (viewer) on right
          amount: `€${Number(it.amount).toFixed(2)}`,
          status: ok ? 'Rent payment' : (it.status ?? 'Pending'),
          time: formatTime(d),
        }));
      }

      if (!items.length) {
        feedEl.appendChild(emptyEl('No payments yet.'));
      }
    }

    // ===== Interactions =====
    dateInp.onchange = () => { RT.filterDate = dateInp.value || null; };
    allBtn.onclick   = () => refreshFeed(true);
    payBtn.onclick   = () => {
      const amt = amountIn.value ? parseFloat(amountIn.value) : parseFloat(RT.balance?.outstanding || '0');
      pay(amt);
    };

    // ===== Payment (no webhook) =====
    async function pay(amount) {
      if (!amount || amount <= 0) { alert('Enter an amount'); return; }
      const csrf = document.querySelector('meta[name="csrf-token"]').content;

      const body = {
        application_id: RT.applicationId,
        amount_eur: amount,
        for_date: RT.filterDate,     // calendar date goes to Stripe metadata
      };
      if (RT.groupId !== null) body.group_id = RT.groupId;

      const res  = await fetch('/student/rent-tracker/payment-intent', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
        body: JSON.stringify(body)
      });
      const data = await res.json();
      if (!res.ok) { alert(data.message || 'Unable to create payment'); return; }

      await stripe.confirmPayment({
        clientSecret: data.client_secret,
        confirmParams: { return_url: window.location.href }
      });

      // After return → confirm & refresh
      setTimeout(() => confirmPayment(data.payment_intent), 1200);
    }

    async function confirmPayment(pi_id) {
      const csrf = document.querySelector('meta[name="csrf-token"]').content;
      const res  = await fetch('/student/rent-tracker/confirm-payment', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
        body: JSON.stringify({ payment_intent: pi_id })
      });
      const data = await res.json();
      if (data.ok) {
        await refreshBalance();
        await refreshFeed(true);
      }
    }

    // ===== Helpers =====
    function separatorEl(label) {
      const wrap = document.createElement('div');
      wrap.className = 'flex justify-center my-2';
      wrap.innerHTML = `<span class="px-3 py-0.5 rounded-full bg-slate-200 text-slate-700 text-xs">${label}</span>`;
      return wrap;
    }
    function bubbleEl({ sideRight, amount, status, time }) {
      const outer  = document.createElement('div');
      outer.className = sideRight ? 'flex justify-end' : 'flex justify-start';

      const bubble = document.createElement('div');
      bubble.className = [
        'max-w-[75%] rounded-2xl px-4 py-3 shadow-sm',
        sideRight ? 'bg-blue-600 text-white rounded-br-md'
                  : 'bg-white text-slate-800 border border-slate-200 rounded-bl-md'
      ].join(' ');
      bubble.innerHTML = `
        <div class="text-sm font-semibold">${amount}</div>
        <div class="text-xs ${sideRight ? 'text-blue-100' : 'text-slate-500'}">Rent payment</div>
        <div class="mt-1 text-[11px] ${sideRight ? 'text-blue-100' : 'text-slate-400'}">${time}</div>
      `;

      outer.appendChild(bubble);
      return outer;
    }
    function emptyEl(text) {
      const d = document.createElement('div');
      d.className = 'text-sm text-slate-500 text-center py-6';
      d.textContent = text;
      return d;
    }
    function daySeparatorLabel(date) {
      const today = new Date(); today.setHours(0,0,0,0);
      const that  = new Date(date); that.setHours(0,0,0,0);
      const diff  = Math.round((that - today) / 86400000);
      if (diff === 0)  return 'Today';
      if (diff === -1) return 'Yesterday';
      return formatDayMonth(date);
    }
    function formatDayMonth(date) {
      return date.toLocaleDateString(undefined, { day: '2-digit', month: 'short' }); // “24 Mar”
    }
    function formatTime(date) {
      return date.toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' }); // “14:33”
    }

    boot();
    </script>
</x-app-layout>