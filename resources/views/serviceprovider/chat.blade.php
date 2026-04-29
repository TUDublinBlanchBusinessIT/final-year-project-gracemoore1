<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Messages
        </h2>
    </x-slot>

    @php
        $job = $conversation->serviceRequest;
        $landlordName = $landlord
            ? trim(($landlord->firstname ?? '') . ' ' . ($landlord->surname ?? ''))
            : 'Landlord';
    @endphp

    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto">

            @if(session('success'))
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    {{ $errors->first('content') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <div class="border-b border-slate-200 px-8 py-5 bg-white">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('serviceprovider.messages') }}"
                           class="text-slate-500 hover:text-slate-700 text-xl">
                            ←
                        </a>

                        <div class="h-14 w-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-2xl font-semibold">
                            {{ strtoupper(substr($landlordName, 0, 1)) }}
                        </div>

                        <div class="relative inline-block group">

                            <h3 class="text-xl font-semibold text-slate-900 cursor-pointer">
                                {{ $landlordName }}
                            </h3>

                            <div
                                class="absolute left-0 top-full mt-1 w-44
                                bg-white border border-slate-200 rounded-lg shadow-lg
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                transition-all duration-150 z-50">

                                <a
                                    href="{{ route('complaint.create', [
                                        'reported_user_id' => $job->landlordid,
                                        'reported_user_role' => 'landlord'
                                    ]) }}"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-lg"
                                >
                                    Report account
                                </a>

                            </div>

                        </div>
                    </div>
                </div>

                @if($isOtherAccountBanned)
                    <div class="mx-8 mt-4 mb-2 rounded-xl border border-red-300 bg-red-50 px-4 py-3 text-red-800">
                        <strong>Notice:</strong>
                        This landlord account has been suspended.
                    </div>
                @endif
                
                <div id="chatContainer" class="px-8 py-6 bg-slate-50 min-h-[420px] max-h-[520px] overflow-y-auto">

                    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5">
                        <h4 class="text-sm font-semibold text-slate-900 mb-2">Job Details</h4>
                        <p class="text-slate-700">{{ $job->description }}</p>

                        @if(!empty($job->requestimage))
                            <div class="mt-4">
                                <a href="{{ asset('storage/' . $job->requestimage) }}" target="_blank">
                                    <img
                                        src="{{ asset('storage/' . $job->requestimage) }}"
                                        alt="Request image"
                                        class="w-40 h-40 object-cover rounded-xl border border-slate-200 shadow-sm cursor-pointer"
                                    >
                                </a>
                            </div>
                        @endif
                    </div>

                    @forelse($messages as $message)
                        <div class="mb-4 flex {{ $message->sender_type === 'service_provider' || $message->sender_type === 'invoice' ? 'justify-end' : 'justify-start' }}">
                            <div>
                                @if($message->sender_type === 'invoice')
                                    <div class="bg-white border border-slate-200 rounded-3xl px-5 py-4 shadow-sm max-w-xl">
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="text-lg">🧾</span>
                                            <span class="font-semibold text-slate-900 text-sm">Invoice</span>
                                            @if($message->invoice_paid)
                                                <span class="ml-auto text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">Paid ✓</span>
                                            @else
                                                <span class="ml-auto text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-medium">Awaiting Payment</span>
                                            @endif
                                        </div>
                                        <table class="w-full text-sm mb-3">
                                            <thead>
                                                <tr class="text-xs text-slate-500 border-b">
                                                    <th class="text-left py-1">Invoice Details</th>
                                                    <th class="text-right py-1">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach(json_decode($message->invoice_data, true) as $item)
                                                    <tr class="border-b border-slate-100">
                                                        <td class="py-1 text-slate-700">{{ $item['detail'] }}</td>
                                                        <td class="py-1 text-right text-slate-700">€{{ number_format($item['amount'], 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="pt-2 font-semibold text-slate-900">Total</td>
                                                    <td class="pt-2 text-right font-semibold text-slate-900">€{{ number_format($message->invoice_amount, 2) }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <p class="text-xs text-slate-400">{{ optional($message->timestamp)->format('d M Y H:i') }}</p>
                                    </div>
                                @else
                                    <div class="{{ $message->sender_type === 'service_provider' ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-800' }} max-w-xl rounded-3xl px-5 py-3 shadow-sm">
                                        <p class="text-sm leading-6">{{ $message->content }}</p>
                                        <p class="mt-2 text-xs {{ $message->sender_type === 'service_provider' ? 'text-blue-100' : 'text-slate-400' }}">
                                            {{ optional($message->timestamp)->format('d M Y H:i') ?? optional($message->created_at)->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    @if($message->sender_type === 'service_provider')
                                        <p class="mt-1 text-xs text-right text-slate-400">
                                            {{ $message->is_read_by_landlord ? 'Seen' : 'Sent' }}
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-slate-500">
                            No messages yet. Start the conversation with the landlord about this job.
                        </div>
                    @endforelse

                </div>

                <div class="border-t border-slate-200 bg-white px-8 py-5">
                    <form method="POST" action="{{ route('serviceprovider.messages.store', $conversation->id) }}">
                        @csrf

                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <textarea
                                    name="content"
                                    rows="3"
                                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Type your message to the landlord here..."
                                    required
                                >{{ old('content') }}</textarea>
                            </div>

                            <div class="flex flex-col gap-2">
                                <button type="button" onclick="openInvoiceModal()"
                                    class="inline-flex items-center justify-center rounded-2xl bg-slate-100 hover:bg-slate-200 px-4 py-3 text-xl"
                                    title="Send Invoice">
                                    🧾
                                </button>
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-medium text-white hover:bg-blue-700 transition">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("chatContainer");
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });

        let rowCount = 1;
        const MAX_ROWS = 15;

        function openInvoiceModal() { document.getElementById('invoiceModal').classList.remove('hidden'); }
        function closeInvoiceModal() { document.getElementById('invoiceModal').classList.add('hidden'); }

        function addInvoiceRow() {
            if (rowCount >= MAX_ROWS) return;
            const container = document.getElementById('invoiceRows');
            const div = document.createElement('div');
            div.className = 'grid grid-cols-[1fr_120px_32px] gap-2 items-center';
            div.innerHTML = `
                <input type="text" name="invoice_items[${rowCount}][detail]" placeholder="e.g. Materials"
                    class="rounded-xl border-slate-300 text-sm px-3 py-2" oninput="recalcTotal()">
                <input type="number" name="invoice_items[${rowCount}][amount]" min="0" step="0.01" placeholder="0.00"
                    class="rounded-xl border-slate-300 text-sm px-3 py-2" oninput="recalcTotal()">
                <button type="button" onclick="removeRow(this)" class="text-red-400 hover:text-red-600 text-lg font-bold">✕</button>
            `;
            container.appendChild(div);
            rowCount++;
        }

        function removeRow(btn) { btn.closest('div').remove(); recalcTotal(); }

        function recalcTotal() {
            let total = 0;
            document.querySelectorAll('#invoiceRows input[type="number"]').forEach(input => {
                const val = parseFloat(input.value);
                if (!isNaN(val) && val > 0) total += val;
            });
            document.getElementById('invoiceTotal').textContent = '€' + total.toFixed(2);
        }
    </script>

    <div id="invoiceModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">🧾 Send Invoice</h3>
                <button onclick="closeInvoiceModal()" class="text-slate-400 hover:text-slate-600 text-xl">✕</button>
            </div>
            <form method="POST" action="{{ route('serviceprovider.messages.store', $conversation->id) }}">
                @csrf
                <div class="mb-3">
                    <div class="grid grid-cols-[1fr_120px_32px] gap-2 text-xs font-semibold text-slate-500 mb-1 px-1">
                        <span>Invoice Details</span>
                        <span>Amount (€)</span>
                        <span></span>
                    </div>
                    <div id="invoiceRows" class="space-y-2">
                        <div class="grid grid-cols-[1fr_120px_32px] gap-2 items-center">
                            <input type="text" name="invoice_items[0][detail]" placeholder="e.g. Labour"
                                class="rounded-xl border-slate-300 text-sm px-3 py-2" oninput="recalcTotal()">
                            <input type="number" name="invoice_items[0][amount]" min="0" step="0.01" placeholder="0.00"
                                class="rounded-xl border-slate-300 text-sm px-3 py-2" oninput="recalcTotal()">
                            <span></span>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addInvoiceRow()" class="text-sm text-blue-600 hover:underline mb-4">+ Add item</button>
                <div class="flex items-center justify-between border-t border-slate-200 pt-3 mb-4">
                    <span class="font-semibold text-slate-900">Total</span>
                    <span id="invoiceTotal" class="font-semibold text-slate-900">€0.00</span>
                </div>
                <button type="submit" class="w-full rounded-2xl bg-blue-600 px-6 py-3 text-sm font-medium text-white hover:bg-blue-700">
                    Send Invoice
                </button>
            </form>
        </div>
    </div>
</x-app-layout>