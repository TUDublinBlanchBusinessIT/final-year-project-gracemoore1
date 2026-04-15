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
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


    
     <?php $__env->slot('header', null, []); ?> 
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('landlord.messages.show', $application->id)); ?>"
                   class="text-slate-500 hover:text-slate-700 text-xl">←</a>

                <div class="min-w-0">
                    <p class="text-m font-semibold uppercase tracking-[0.12em] text-blue-600">
                        Messages <span class="mx-1 text-slate-300">/</span> Rent Tracker
                    </p>
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    
    <div class="pb-28 lg:pl-70">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                
                <div class="px-6 py-3 bg-white border-b border-slate-200">
                    <div class="flex items-center gap-4">
                        <div class="min-w-0">
                            <h3 class="text-lg font-semibold text-slate-900 truncate">
                                <?php echo e($application->student->firstname ?? 'Student'); ?>

                                <?php echo e($application->student->surname ?? ''); ?>

                            </h3>

                            <p class="text-sm text-slate-500 truncate mt-1">
                                <?php echo e($application->rental->housenumber ?? ''); ?>

                                <?php echo e($application->rental->street ?? ''); ?>,
                                <?php echo e($application->rental->county ?? ''); ?>

                            </p>
                        </div>
                    </div>
                </div>
                <div id="rt-summary" class="px-10 py-4 border-b border-slate-200">
                </div>    
                

                
                <div id="rt-feed"
                     class="bg-slate-50 px-6 py-6 overflow-y-auto space-y-4"
                     style="min-height: 200px; max-height: 500px;">
                </div>

            </div>
        </div>
    </div>

    <script>
        const APP_ID  = <?php echo json_encode($application->id, 15, 512) ?>;
        const GROUP_ID = <?php echo json_encode($groupId, 15, 512) ?>;

        const feedEl    = document.getElementById('rt-feed');
        const summaryEl = document.getElementById('rt-summary');

        // BALANCE 
        async function refreshBalance() {
            const res  = await fetch(`/landlord/rent-tracker/balance?application_id=${APP_ID}`);
            RT_balance = await res.json();
            summaryEl.textContent = `Due €${RT_balance.monthly_due} • Paid €${RT_balance.paid} • Outstanding €${RT_balance.outstanding}`;
        }

        //  FEED 
        async function refreshFeed() {
            const res  = await fetch(`/landlord/rent-tracker/history?application_id=${APP_ID}&all=1`);
            const data = await res.json();
            renderFeed(data.history);
        }

        //  DAY SEPARATOR HELPERS 
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

        //  RENDER FEED 
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
                    // Reminders/overdues on the RIGHT for landlord
                    outer.className = 'flex justify-end';
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
                    // Payments on the left for landlord
                    const outer  = document.createElement('div');
                    outer.className = 'flex justify-start';
                    const bubble = document.createElement('div');
                    bubble.className = 'max-w-[75%] rounded-2xl px-4 py-3 text-sm shadow-sm bg-white text-slate-800 border border-slate-200';
                    const paidBy = it.paid_by || 'Student';
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

        //  BOOT 
        let RT_balance = null;

        async function boot() {
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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/landlord/rent-tracker.blade.php ENDPATH**/ ?>