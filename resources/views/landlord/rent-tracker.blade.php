<x-app-layout>

    {{-- HEADER --}}
<x-slot name="header">
    <div class="border-b border-slate-200 px-6 py-3 bg-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('landlord.messages.show', $application->id) }}"
                   class="text-slate-500 hover:text-slate-700 text-xl">←</a>

                <div class="min-w-0 flex items-center gap-2">
                    <p class="text-m font-semibold uppercase tracking-[0.12em] text-blue-600">
                        Messages <span class="mx-1 text-slate-300">/</span> Rent Tracker
                    </p>

                    <div class="relative">
                        <button id="rentHelpBtn"
                            class="w-7 h-7 flex items-center justify-center rounded-full bg-blue-100 text-blue-600 text-sm font-bold hover:bg-blue-200 transition">
                            ?
                        </button>

                        <div id="rentHelpBox"
                            class="hidden absolute right-0 top-full mt-2 w-80 bg-white border border-slate-200 rounded-xl shadow-lg p-4 text-sm text-slate-600 z-50">

                            <p class="font-semibold text-slate-800 mb-2">Rent Tracker</p>

                            <p class="mb-2">
                                This is the rent tracker. Students can pay their rent securely to you directly within the app.
                            </p>

                            <p class="mb-2">
                                All payments are recorded so you can easily keep track of what has been paid and what is still outstanding.
                            </p>

                            <p>
                                This ensures nothing gets missed and gives you a clear overview of each tenant’s payments.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-slot>  

    {{-- BODY --}}
    <div class="pb-28 lg:pl-70">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                {{-- SUMMARY --}}
                <div class="px-6 py-3 bg-white border-b border-slate-200">
                    <div class="flex items-center gap-4">
                        <div class="min-w-0">
                            <h3 class="text-lg font-semibold text-slate-900 truncate">
                                {{ $application->student->firstname ?? 'Student' }}
                                {{ $application->student->surname ?? '' }}
                            </h3>

                            <p class="text-sm text-slate-500 truncate mt-1">
                                {{ $application->rental->housenumber ?? '' }}
                                {{ $application->rental->street ?? '' }},
                                {{ $application->rental->county ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div id="rt-summary" class="px-10 py-4 border-b border-slate-200">
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <div class="flex items-center gap-2">
                            <label class="text-sm text-slate-600">Rent due day:</label>
                            <select id="due-day-select"
                                class="rounded-lg border border-slate-300 px-6 py-1.5 text-sm focus:border-blue-400 focus:ring focus:ring-blue-100 min-w-[140px]">
                                @for($i = 1; $i <= 28; $i++)
                                    <option value="{{ $i }}" {{ ($application->rent_due_day ?? null) == $i ? 'selected' : '' }}>
                                        {{ $i }}{{ in_array($i, [1,21]) ? 'st' : (in_array($i, [2,22]) ? 'nd' : (in_array($i, [3,23]) ? 'rd' : 'th')) }}
                                    </option>
                                @endfor
                            </select>

                            <button onclick="saveDueDay()"
                                class="rounded-lg bg-blue-600 px-3 py-1.5 text-sm text-white hover:bg-blue-700">
                                Save
                            </button>

                            <span id="due-day-saved" class="text-xs text-green-600 hidden">Saved ✓</span>
                        </div>
                    </div>
                </div>


                {{-- FEED --}}
                <div id="rt-feed"
                     class="bg-slate-50 px-6 py-6 overflow-y-auto space-y-4"
                     style="min-height: 200px; max-height: 500px;">
                </div>

            </div>
        </div>
    </div>

    <script>
        const APP_ID  = @json($application->id);
        const GROUP_ID = @json($groupId);

        const feedEl    = document.getElementById('rt-feed');


        // BALANCE 
        async function refreshBalance() {
            const res  = await fetch(`/landlord/rent-tracker/balance?application_id=${APP_ID}`);
            RT_balance = await res.json();
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
        
        async function saveDueDay() {
            const day = document.getElementById('due-day-select').value;
            const res = await fetch('{{ route('landlord.rent.set-due-day', $application->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ rent_due_day: day })
            });

            if (res.ok) {
                document.getElementById('due-day-saved').classList.remove('hidden');
                setTimeout(() => document.getElementById('due-day-saved').classList.add('hidden'), 3000);
                await refreshBalance();
                await refreshFeed();
            }
        }

    </script>

    <script>
        const rentBtn = document.getElementById('rentHelpBtn');
        const rentBox = document.getElementById('rentHelpBox');

        rentBtn.addEventListener('click', () => {
            rentBox.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!rentBtn.contains(e.target) && !rentBox.contains(e.target)) {
                rentBox.classList.add('hidden');
            }
        });
    </script>

    <script>
        const rentBtn = document.getElementById('rentHelpBtn');
        const rentBox = document.getElementById('rentHelpBox');

        rentBtn.addEventListener('click', () => {
            rentBox.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!rentBtn.contains(e.target) && !rentBox.contains(e.target)) {
                rentBox.classList.add('hidden');
            }
        });
    </script>

</x-app-layout>