<x-app-layout>
    {{-- HEADER — mirrors Messages --}}
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-4 bg-white">
            <div class="flex items-center gap-4">
                <a href="{{ route('student.messages.show', $application->id) }}" class="text-slate-500 hover:text-slate-700 text-xl">←</a>

                <div class="w-11 h-11 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-lg font-semibold">
                    {{ strtoupper(substr($application->rental->landlord->firstname ?? 'L', 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <h3 class="text-lg font-semibold text-slate-900 truncate">
                        {{ $application->rental->landlord->firstname ?? 'Landlord' }}
                        {{ $application->rental->landlord->surname ?? '' }}
                    </h3>
                    <p class="text-sm text-slate-500 truncate">
                        {{ $application->rental->housenumber ?? '' }}
                        {{ $application->rental->street ?? '' }},
                        {{ $application->rental->county ?? '' }}
                    </p>

                    @if(($application->applicationtype ?? '') === 'group' && isset($groupMembers) && $groupMembers->count())
                        <p class="text-xs text-slate-400 mt-1">
                            Group members: {{ $groupMembers->pluck('firstname')->implode(', ') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    {{-- BODY --}}
    <div class="pb-28 lg:pl-70">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                {{-- SUMMARY ROW --}}
                <div class="px-6 py-3 bg-white border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <div id="rt-summary" class="text-sm text-slate-700 truncate"></div>
                        <button id="rt-all" class="ml-auto text-xs px-2 py-1 rounded border hover:bg-slate-50">
                            All
                        </button>
                    </div>
                </div>

                {{-- CHAT FEED --}}
                <div id="rt-feed" class="bg-slate-50 px-6 py-6 h-[500px] overflow-y-auto space-y-4">
                    {{-- JS renders date separators + bubbles here --}}
                </div>

                {{-- COMPOSER (date + amount + Pay) --}}
                <div class="border-t border-slate-200 bg-white px-6 py-4">
                    <div class="flex items-end gap-3 flex-wrap">
                        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="flex items-center gap-2">
                                <label for="rt-date" class="text-sm font-medium text-slate-700 shrink-0">
                                    Rent payment for:
                                </label>
                                <input id="rt-date" type="date"
                                       class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-400 focus:ring focus:ring-blue-100">
                            </div>
                            <input id="rt-amount" type="number" step="0.01" min="0"
                                   class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-400 focus:ring focus:ring-blue-100"
                                   placeholder="Amount (€)">
                        </div>

                        <button id="rt-pay"
                                class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700">
                            Pay with Stripe
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Airbnb-like Payment Card (bottom sheet on mobile, centered on desktop) --}}
    <div id="rt-payment-modal" class="hidden fixed inset-0 z-50">
        <div class="absolute inset-0 bg-black/40" id="rt-payment-backdrop"></div>

        <div class="absolute bottom-0 left-0 right-0 bg-white p-5 rounded-t-2xl sm:rounded-2xl sm:inset-auto sm:m-auto sm:w-full sm:max-w-md sm:shadow-xl">
            <div class="flex items-start justify-between">
                <h4 class="text-base font-semibold text-slate-900">Confirm your payment</h4>
                <button id="rt-close" class="text-slate-500 hover:text-slate-700 text-xl leading-none">×</button>
            </div>

            {{-- Summary strip --}}
            <div class="mt-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-slate-600">Rent for</span>
                    <span id="rt-summary-date" class="font-medium text-slate-900"></span>
                </div>
                <div class="mt-1 flex items-center justify-between text-sm">
                    <span class="text-slate-600">Amount</span>
                    <span id="rt-summary-amount" class="font-medium text-slate-900"></span>
                </div>
            </div>

            {{-- Stripe Payment Element --}}
            <div class="mt-4">
                <div id="rt-payment-element" class="py-2"></div>
            </div>

            <div class="mt-4 flex items-center justify-end gap-2">
                <button id="rt-cancel" class="px-4 py-2 rounded border border-slate-300 text-slate-700 hover:bg-slate-50">Cancel</button>
                <button id="rt-confirm" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50" disabled>
                    Pay
                </button>
            </div>
        </div>
    </div>

    {{-- Stripe.js (correct tag) --}}
    <script src="https://js.stripe.com/v3"></script>

    {{-- PAGE SCRIPT --}}
    <script>
    // ================== CONSTANTS ==================
    const STRIPE_PUBLIC_KEY = @json(config('services.stripe.public_key'));
    const stripe = Stripe(STRIPE_PUBLIC_KEY);

    const APP_ID      = @json($application->id);
    const GROUP_ID    = @json($groupId);
    const VIEWER_ID   = @json($viewerId);
    const VIEWER_NAME = @json(optional(\App\Models\Student::find($viewerId))->firstname ?? 'You');

    // ================== ELEMENTS ==================
    const dateInp   = document.getElementById('rt-date');
    const allBtn    = document.getElementById('rt-all');
    const summaryEl = document.getElementById('rt-summary');
    const feedEl    = document.getElementById('rt-feed');
    const amountIn  = document.getElementById('rt-amount');
    const payBtn    = document.getElementById('rt-pay');

    // Payment modal elements
    const modal         = document.getElementById('rt-payment-modal');
    const modalClose    = document.getElementById('rt-close');
    const modalCancel   = document.getElementById('rt-cancel');
    const modalBackdrop = document.getElementById('rt-payment-backdrop');
    const summaryDate   = document.getElementById('rt-summary-date');
    const summaryAmount = document.getElementById('rt-summary-amount');
    const confirmBtn    = document.getElementById('rt-confirm');

    // ================== STATE ==================
    const RT = {
      applicationId: APP_ID,
      groupId: GROUP_ID ?? null,
      balance: null,
      history: [],
    };

    // ================== LOOK & FEEL (bubbles) ==================
    const BUBBLE_RADIUS = 'rounded-lg'; // 'rounded-md' for squarer, 'rounded-2xl' for pill
    const SELF_BG       = 'bg-blue-600 text-white';
    const OTHER_BG      = 'bg-white text-slate-800 border border-slate-200';
    const REMINDER_BG   = 'bg-blue-600 text-white'; // left + blue

    let userScrolledUp = false;
    feedEl?.addEventListener('scroll', () => {
      const stickThreshold = 60;
      const atBottom = (feedEl.scrollHeight - feedEl.clientHeight - feedEl.scrollTop) < stickThreshold;
      userScrolledUp = !atBottom;
    });
    function scrollToBottom(force = false) {
      if (!feedEl) return;
      if (!userScrolledUp || force) feedEl.scrollTop = feedEl.scrollHeight;
    }

    // ================== BOOT ==================
    async function boot() {
      await refreshBalance();
      setDefaultDateFromBalance();
      await refreshFeed(true);
      wireHandlers();
      scrollToBottom(true);
    }

    function wireHandlers() {
      allBtn?.addEventListener('click', () => refreshFeed(true));
      payBtn?.addEventListener('click', onPayClick);
      modalClose?.addEventListener('click', closeModal);
      modalCancel?.addEventListener('click', closeModal);
      modalBackdrop?.addEventListener('click', closeModal);
    }

    function setDefaultDateFromBalance() {
      const dueIso = RT.balance?.due_date_iso;
      const d = dueIso ? new Date(dueIso) : new Date();
      const y = d.getFullYear(), m = String(d.getMonth()+1).padStart(2,'0'), day = String(d.getDate()).padStart(2,'0');
      dateInp.value = `${y}-${m}-${day}`;
    }

    // ================== FETCHERS ==================
    async function refreshBalance() {
      const params = new URLSearchParams({ application_id: RT.applicationId });
      if (RT.groupId !== null) params.set('group_id', RT.groupId);

      const now = new Date();
      params.set('month', now.getMonth()+1);
      params.set('year',  now.getFullYear());

      const res = await fetch(`/student/rent-tracker/balance?${params.toString()}`);
      RT.balance = await res.json();
      summaryEl.textContent = `Due: €${RT.balance.monthly_due} • Paid: €${RT.balance.paid} • Outstanding: €${RT.balance.outstanding}`;
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

    // ================== AIRBNB-LIKE PAYMENT FLOW ==================
    let elements = null;
    let lastPI   = null; // { client_secret, payment_intent }
    let payAmt   = null;
    let payDate  = null;

    async function onPayClick() {
      const outstanding = parseFloat((RT?.balance?.outstanding) || '0');
      const amt = amountIn?.value ? parseFloat(amountIn.value) : outstanding;

      if (!amt || amt <= 0) { alert('Enter a valid amount'); return; }

      payAmt  = Math.round(amt * 100) / 100; // 2dp
      payDate = dateInp?.value || null;

      // 1) Create PaymentIntent
      const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
      const body = { application_id: RT.applicationId, amount_eur: payAmt, for_date: payDate };
      if (RT.groupId !== null) body.group_id = RT.groupId;

      const createRes = await fetch('/student/rent-tracker/payment-intent', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', ...(csrf ? {'X-CSRF-TOKEN': csrf} : {}) },
        body: JSON.stringify(body)
      });

      const createJson = await createRes.json();
      if (!createRes.ok) {
        console.error('PI create failed', createJson);
        alert(createJson.message || 'Unable to create payment');
        return;
      }

      lastPI = { client_secret: createJson.client_secret, payment_intent: createJson.payment_intent };

      // 2) Mount Payment Element inside the card
      mountPaymentElement(lastPI.client_secret);

      // 3) Open modal and render summary
      summaryDate.textContent   = payDate ? formatDayMonth(new Date(payDate)) : '—';
      summaryAmount.textContent = `€${payAmt.toFixed(2)}`;
      confirmBtn.textContent    = `Pay €${payAmt.toFixed(2)}`;
      confirmBtn.disabled       = false;
      confirmBtn.onclick        = confirmPaymentElement;

      openModal();
    }

    function mountPaymentElement(clientSecret) {
      if (!clientSecret) { alert('Missing client secret'); return; }
      try { elements?.unmount?.('#rt-payment-element'); } catch (e) {}

      const appearance = {
        theme: 'stripe',
        variables: { colorPrimary: '#2563eb', colorText: '#0f172a', fontFamily: 'Inter, system-ui, sans-serif' }
      };

      elements = stripe.elements({ clientSecret, appearance });
      const paymentElement = elements.create('payment', { layout: 'tabs' }); // Airbnb-like tabs UI
      paymentElement.mount('#rt-payment-element');
    }

    async function confirmPaymentElement() {
      confirmBtn.disabled = true;
      confirmBtn.textContent = 'Processing...';

      const { error } = await stripe.confirmPayment({
        elements,
        confirmParams: { return_url: window.location.href },
        redirect: 'if_required' // stay inline unless SCA/redirect is needed
      });

      if (error) {
        console.error('Stripe confirm error', error);
        alert(error.message || 'Payment failed');
        confirmBtn.disabled = false;
        confirmBtn.textContent = `Pay €${payAmt.toFixed(2)}`;
        return;
      }

      // 4) Server confirm + UI refresh
      await afterConfirmed(lastPI.payment_intent, payDate, payAmt);
      closeModal();
    }

    async function afterConfirmed(piId, forDate, amount) {
      try {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
        const res  = await fetch('/student/rent-tracker/confirm-payment', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', ...(csrf ? {'X-CSRF-TOKEN': csrf} : {}) },
          body: JSON.stringify({ payment_intent: piId })
        });
        const data = await res.json();

        if (res.ok && data.ok) {
          // Optional optimistic right-side bubble
          prependMyPaymentBubble(amount, forDate);
          await refreshBalance();
          await refreshFeed(true);
          scrollToBottom(true);
        } else {
          console.warn('confirmPayment not ok', data);
        }
      } catch (e) {
        console.error('afterConfirmed exception', e);
      }
    }

    function openModal(){ modal.classList.remove('hidden'); }
    function closeModal(){
      modal.classList.add('hidden');
      try { elements?.unmount?.('#rt-payment-element'); } catch (e) {}
      confirmBtn.disabled = true;
      confirmBtn.textContent = 'Pay';
    }

    // ================== FEED RENDERING ==================
    function renderFeed(items) {
      feedEl.innerHTML = '';
      items.sort((a,b) => new Date(a.timestamp) - new Date(b.timestamp)); // oldest -> newest

      let lastDate = '';
      for (const it of items) {
        const d   = new Date(it.timestamp);
        const day = daySeparatorLabel(d);

        if (day !== lastDate) {
          feedEl.appendChild(separatorEl(day));
          lastDate = day;
        }

        const status = (it.status || '').toLowerCase();
        const isReminder = status === 'reminder';
        const isMine = it.studentid && Number(it.studentid) === Number(VIEWER_ID);
        const variant = isReminder ? 'reminder' : (isMine ? 'self' : 'other');

        const amountValue = `€${Number(it.amount).toFixed(2)}`;
        const whoName = it.paid_by || (isMine ? VIEWER_NAME : 'Student');
        const whoText = isReminder ? 'Rent reminder' : `Paid by ${whoName}`;
        const forText = it.for_date ? `For ${formatDayMonth(new Date(it.for_date))}` : '';
        const time    = formatTime(d);

        feedEl.appendChild(bubbleEl({ variant, amountValue, whoText, forText, time }));
      }

      if (!items.length) feedEl.appendChild(emptyEl('No payments yet.'));
      scrollToBottom(false);
    }

    function separatorEl(label) {
      const wrap = document.createElement('div');
      wrap.className = 'flex justify-center my-4';
      wrap.dataset.sep = label;
      wrap.innerHTML = `<span class="px-4 py-1 rounded-full bg-slate-200 text-slate-600 text-xs">${label}</span>`;
      return wrap;
    }

    function bubbleEl({ variant, amountValue, whoText, forText, time }) {
      const sideRight = (variant === 'self');
      const outer = document.createElement('div');
      outer.className = sideRight ? 'flex justify-end' : 'flex justify-start';

      const bubble = document.createElement('div');
      const base   = `max-w-[75%] ${BUBBLE_RADIUS} px-4 py-3 text-sm shadow-sm`;
      const palette = variant === 'self' ? SELF_BG
                   : variant === 'reminder' ? REMINDER_BG
                   : OTHER_BG;
      const corners = sideRight ? 'rounded-br-md' : 'rounded-bl-md';
      bubble.className = [base, palette, corners].join(' ');

      const lines = [];
      lines.push(`<div class="text-base font-semibold">${amountValue}</div>`);
      if (whoText) lines.push(`<div class="text-xs ${variant === 'other' ? 'text-slate-500' : 'text-blue-100'}">${whoText}</div>`);
      if (forText) lines.push(`<div class="text-xs ${variant === 'other' ? 'text-slate-500' : 'text-blue-100'}">${forText}</div>`);
      lines.push(`<div class="mt-1 ${sideRight ? 'text-right' : 'text-left'} text-[11px] ${variant === 'other' ? 'text-slate-400' : 'text-blue-100'}">${time}</div>`);
      bubble.innerHTML = lines.join('');

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
      return `${formatDayMonth(date)} ${date.getFullYear()}`;
    }

    function formatDayMonth(date) {
      return date.toLocaleDateString(undefined, { day: '2-digit', month: 'short' }); // “27 Mar”
    }

    function formatTime(date) {
      return date.toLocaleTimeString(undefined, { hour: '2-digit', minute: '2-digit' }); // “14:33”
    }

    function prependMyPaymentBubble(amountNumber, forDateStr) {
      const d = new Date();
      const day = daySeparatorLabel(d);

      const seps = feedEl.querySelectorAll('[data-sep]');
      const lastSep = seps.length ? seps[seps.length - 1] : null;
      if (!lastSep || lastSep.dataset.sep !== day) feedEl.appendChild(separatorEl(day));

      const amountValue = `€${Number(amountNumber).toFixed(2)}`;
      const whoText     = `Paid by ${VIEWER_NAME}`;
      const forText     = forDateStr ? `For ${formatDayMonth(new Date(forDateStr))}` : '';
      const time        = formatTime(d);

      feedEl.appendChild(bubbleEl({
        variant: 'self',
        amountValue,
        whoText,
        forText,
        time
      }));
    }

    // GO!
    boot();
    </script>
</x-app-layout>