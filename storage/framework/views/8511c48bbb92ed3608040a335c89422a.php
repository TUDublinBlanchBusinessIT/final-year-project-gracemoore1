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
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
     <?php $__env->slot('header', null, []); ?> 
        <div class="border-b border-slate-200 px-6 py-4 bg-white">
            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('student.messages.show', $application->id)); ?>" 
                   class="text-slate-500 hover:text-slate-700 text-xl">←</a>

                <div class="w-11 h-11 rounded-full bg-slate-100 flex items-center justify-center 
                            text-slate-500 text-lg font-semibold">
                    <?php echo e(strtoupper(substr($application->rental->landlord->firstname ?? 'L', 0, 1))); ?>

                </div>

                <div class="min-w-0">
                    <h3 class="text-lg font-semibold text-slate-900 truncate">
                        <?php echo e($application->rental->landlord->firstname ?? 'Landlord'); ?>

                        <?php echo e($application->rental->landlord->surname ?? ''); ?>

                    </h3>

                    <p class="text-sm text-slate-500 truncate">
                        <?php echo e($application->rental->housenumber ?? ''); ?>

                        <?php echo e($application->rental->street ?? ''); ?>,
                        <?php echo e($application->rental->county ?? ''); ?>

                    </p>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    
    <div class="pb-28 lg:pl-70">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                
                <div class="px-6 py-3 bg-white border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <div id="rt-summary" class="text-sm text-slate-700 truncate"></div>
                        <button id="rt-all" 
                                class="ml-auto text-xs px-2 py-1 rounded border hover:bg-slate-50">
                            All
                        </button>
                    </div>
                </div>

                
                <div id="rt-feed" 
                     class="bg-slate-50 px-6 py-6 overflow-y-auto space-y-4"
                     style="min-height: 200px; max-height: calc(100vh - 280px);">
                </div>

                
                <div class="border-t border-slate-200 bg-white px-6 py-4">
                    <div class="flex items-end gap-3 flex-wrap">

                        <input id="rt-date" type="date"
                               class="rounded-2xl border border-slate-300 px-4 py-3 text-sm">

                        <input id="rt-amount" type="number" step="0.01"
                               class="rounded-2xl border border-slate-300 px-4 py-3 text-sm"
                               placeholder="Amount (€)">

                        <button id="rt-pay"
                                class="rounded-2xl bg-blue-600 px-5 py-3 text-sm text-white">
                            Pay
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <script src="https://js.stripe.com/v3"></script>

<script>
const APP_ID = <?php echo json_encode($application->id, 15, 512) ?>;
const GROUP_ID = <?php echo json_encode($groupId, 15, 512) ?>;
const VIEWER_ID = <?php echo json_encode($viewerId, 15, 512) ?>;
const VIEWER_NAME = <?php echo json_encode(optional(\App\Models\Student::find($viewerId))->firstname ?? 'You', 15, 512) ?>;

const feedEl = document.getElementById('rt-feed');
const summaryEl = document.getElementById('rt-summary');
const amountIn = document.getElementById('rt-amount');
const payBtn = document.getElementById('rt-pay');

const OVERDUE_BG = 'bg-red-600 text-white';
const SELF_BG = 'bg-blue-600 text-white';
const OTHER_BG = 'bg-white text-slate-800 border border-slate-200';
const REMINDER_BG = 'bg-blue-600 text-white';

let RT = { balance:null, history:[] };

async function refreshBalance(){
    const res = await fetch(`/student/rent-tracker/balance?application_id=${APP_ID}`);
    RT.balance = await res.json();
    summaryEl.textContent = `Due €${RT.balance.monthly_due} • Paid €${RT.balance.paid} • Outstanding €${RT.balance.outstanding}`;
}

async function refreshFeed(){
    const res = await fetch(`/student/rent-tracker/history?application_id=${APP_ID}&all=1`);
    const data = await res.json();
    console.log('HISTORY DATA:', data);
    RT.history = data.history;
    renderFeed(RT.history);
}

function renderFeed(items){
    feedEl.innerHTML = '';
    items.sort((a,b)=>new Date(a.timestamp)-new Date(b.timestamp));

    items.forEach(it=>{
        const status = (it.status || '').toLowerCase();
        const isReminder = status === 'reminder';

        if (isReminder) {
            // Left-side reminder bubble
            const outer = document.createElement('div');
            outer.className = 'flex justify-start';
            const bubble = document.createElement('div');
            const isOverdue = (it.label || '').toLowerCase().includes('overdue');
            bubble.className = `max-w-[75%] rounded-2xl px-4 py-3 text-sm shadow-sm ${isOverdue ? 'bg-red-600 text-white' : 'bg-blue-600 text-white'}`;
            bubble.innerHTML = `
                <div class="text-xs font-semibold uppercase tracking-wide opacity-80 mb-1">${it.label || 'Rent Reminder'}</div>
                <div class="text-base font-semibold">€${Number(it.amount).toFixed(2)}</div>
                <div class="text-xs opacity-75 mt-1">Due ${new Date(it.timestamp).toLocaleDateString(undefined,{day:'2-digit',month:'short',year:'numeric'})}</div>
            `;
            outer.appendChild(bubble);
            feedEl.appendChild(outer);
        } else {
            // Payment bubble — right if viewer's payment, left if someone else's
            const fromViewer = it.studentid && Number(it.studentid) === Number(VIEWER_ID);
            const outer = document.createElement('div');
            outer.className = fromViewer ? 'flex justify-end' : 'flex justify-start';
            const bubble = document.createElement('div');
            bubble.className = `max-w-[75%] rounded-2xl px-4 py-3 text-sm shadow-sm ${fromViewer ? 'bg-blue-600 text-white' : 'bg-white text-slate-800 border border-slate-200'}`;
            const paidBy = it.paid_by || (fromViewer ? VIEWER_NAME : 'Housemate');
            bubble.innerHTML = `
                <div class="text-base font-semibold">€${Number(it.amount).toFixed(2)}</div>
                <div class="text-xs opacity-75">Paid by ${paidBy}</div>
                <div class="text-[11px] opacity-60 mt-1">${new Date(it.timestamp).toLocaleTimeString(undefined,{hour:'2-digit',minute:'2-digit'})}</div>
            `;
            outer.appendChild(bubble);
            feedEl.appendChild(outer);
        }
    });

    if(!items.length){
        feedEl.innerHTML = '<div class="text-sm text-slate-500 text-center py-6">No payments yet.</div>';
    }
}

function bubbleEl({variant, amountValue, whoText, time, label}){
    const outer = document.createElement('div');
    outer.className = 'flex justify-start';

    const bubble = document.createElement('div');

    let palette = OTHER_BG;

    if (variant === 'reminder'){
        if ((whoText || '').toLowerCase().includes('overdue')){
            palette = OVERDUE_BG;
        } else {
            palette = REMINDER_BG;
        }
    }

    bubble.className = `max-w-[75%] rounded-2xl px-4 py-3 text-sm shadow-sm ${palette}`;

    bubble.innerHTML = `
        <div class="text-base font-semibold">${amountValue}</div>
        <div class="text-xs">${label || whoText}</div>
        <div class="text-[11px] opacity-70">${time}</div>
    `;

    outer.appendChild(bubble);
    return outer;
}

payBtn.addEventListener('click', async () => {
    const amount = parseFloat(amountIn.value || 0);
    if (!amount || amount <= 0) { alert('Enter an amount'); return; }

    try {
        const csrf = document.querySelector('meta[name="csrf-token"]').content;

        // 1) Create payment intent
        const res = await fetch('/student/rent-tracker/payment-intent', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ application_id: APP_ID, amount_eur: amount, group_id: GROUP_ID })
        });
        const json = await res.json();
        if (!res.ok) { alert(json.message || 'Could not start payment'); return; }

        // 2) Launch Stripe — redirects away and back
        const stripe = Stripe(<?php echo json_encode(config('services.stripe.public_key'), 15, 512) ?>);
        const { error } = await stripe.confirmPayment({
            clientSecret: json.client_secret,
            confirmParams: { return_url: window.location.href }
        });

        if (error) { alert(error.message || 'Payment failed'); }

    } catch(e) {
        console.error(e);
        alert('Something went wrong.');
    }
});

async function boot() {
    // Handle Stripe redirect return
    const params = new URLSearchParams(window.location.search);
    const piId = params.get('payment_intent');
    if (piId) {
        window.history.replaceState({}, '', window.location.pathname);
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        await fetch('/student/rent-tracker/confirm-payment', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ payment_intent: piId })
        });
    }

    await refreshBalance();
    await refreshFeed();
}

boot();
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/student/rent-tracker.blade.php ENDPATH**/ ?>