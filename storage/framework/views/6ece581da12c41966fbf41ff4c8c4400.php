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
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Messages
        </h2>
     <?php $__env->endSlot(); ?>

    <?php
        $providerName = $provider
            ? trim(($provider->firstname ?? '') . ' ' . ($provider->surname ?? ''))
            : 'Service Provider';
    ?>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    <?php echo e($errors->first('message')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <div class="border-b border-slate-200 px-8 py-5 bg-white">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <a href="<?php echo e(route('landlord.messages', ['filter' => 'service_providers'])); ?>"
                               class="text-slate-500 hover:text-slate-700 text-xl">
                                ←
                            </a>

                            <div class="h-14 w-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-2xl font-semibold">
                                <?php echo e(strtoupper(substr($providerName, 0, 1))); ?>

                            </div>

                            <div class="relative inline-block group">

                                <h3 class="text-xl font-semibold text-slate-900 cursor-pointer">
                                    <?php echo e($providerName); ?>

                                </h3>

                                <div
                                    class="absolute left-0 top-full mt-1 w-44
                                    bg-white border border-slate-200 rounded-lg shadow-lg
                                    opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                    transition-all duration-150 z-50">

                                    <a
                                        href="<?php echo e(route('complaint.create', [
                                            'reported_user_id' => $provider->id,
                                            'reported_user_role' => 'serviceprovider'
                                        ])); ?>"
                                        class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-lg"
                                    >
                                        Report account
                                    </a>

                                </div>

                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($providerRequest->status === 'messaged' || $providerRequest->status === 'pending'): ?>
                                <form method="POST" action="<?php echo e(route('landlord.service-provider.messages.accept', $providerRequest->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition">
                                        Accept Provider
                                    </button>
                                </form>

                                <form method="POST" action="<?php echo e(route('landlord.service-provider.messages.decline', $providerRequest->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition">
                                        Decline Provider
                                    </button>
                                </form>
                            <?php elseif($providerRequest->status === 'assigned'): ?>
                                <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-xl font-medium border border-green-200">
                                    Provider Accepted
                                </span>
                            <?php elseif($providerRequest->status === 'declined'): ?>
                                <span class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-xl font-medium border border-red-200">
                                    Provider Declined
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>                

                <div id="chatContainer" class="px-8 py-6 bg-slate-50 min-h-[420px] max-h-[520px] overflow-y-auto">

                    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5">
                        <h4 class="text-sm font-semibold text-slate-900 mb-2">Job Details</h4>
                        <p class="text-slate-700"><?php echo e($job->description); ?></p>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($job->requestimage)): ?>
                            <div class="mt-4">
                                <a href="<?php echo e(asset('storage/' . $job->requestimage)); ?>" target="_blank">
                                    <img
                                        src="<?php echo e(asset('storage/' . $job->requestimage)); ?>"
                                        alt="Request image"
                                        class="w-40 h-40 object-cover rounded-xl border border-slate-200 shadow-sm cursor-pointer"
                                    >
                                </a>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="mb-4 flex <?php echo e($message->sender_type === 'landlord' ? 'justify-end' : 'justify-start'); ?>">
                        <div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->sender_type === 'invoice'): ?>
                                <div class="bg-white border border-slate-200 rounded-3xl px-5 py-4 shadow-sm max-w-xl">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="text-lg">🧾</span>
                                        <span class="font-semibold text-slate-900 text-sm">Invoice</span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->invoice_paid): ?>
                                            <span class="ml-auto text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">Paid ✓</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <table class="w-full text-sm mb-3">
                                        <thead>
                                            <tr class="text-xs text-slate-500 border-b">
                                                <th class="text-left py-1">Invoice Details</th>
                                                <th class="text-right py-1">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = json_decode($message->invoice_data, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <tr class="border-b border-slate-100">
                                                    <td class="py-1 text-slate-700"><?php echo e($item['detail']); ?></td>
                                                    <td class="py-1 text-right text-slate-700">€<?php echo e(number_format($item['amount'], 2)); ?></td>
                                                </tr>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="pt-2 font-semibold text-slate-900">Total</td>
                                                <td class="pt-2 text-right font-semibold text-slate-900">€<?php echo e(number_format($message->invoice_amount, 2)); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <p class="text-xs text-slate-400 mb-3"><?php echo e(optional($message->timestamp)->format('d M Y H:i')); ?></p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$message->invoice_paid): ?>
                                        <button onclick="openPayModal(<?php echo e($message->id); ?>, <?php echo e($message->invoice_amount); ?>)"
                                            class="w-full rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                            Pay €<?php echo e(number_format($message->invoice_amount, 2)); ?>

                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="<?php echo e($message->sender_type === 'landlord' ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-800'); ?> max-w-xl rounded-3xl px-5 py-3 shadow-sm">
                                    <p class="text-sm leading-6"><?php echo e($message->content); ?></p>
                                    <p class="mt-2 text-xs <?php echo e($message->sender_type === 'landlord' ? 'text-blue-100' : 'text-slate-400'); ?>">
                                        <?php echo e(optional($message->timestamp)->format('d M Y H:i') ?? optional($message->created_at)->format('d M Y H:i')); ?>

                                    </p>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->sender_type === 'landlord'): ?>
                                    <p class="mt-1 text-xs text-right text-slate-400">
                                        <?php echo e($message->is_read_by_service_provider ? 'Seen' : 'Sent'); ?>

                                    </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>                    
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-slate-500">
                        No messages yet.
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>

                <div class="border-t border-slate-200 bg-white px-8 py-5">
                    <form method="POST" action="<?php echo e(route('landlord.service-provider.messages.store', $providerRequest->id)); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <textarea
                                    name="message"
                                    rows="3"
                                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Type your message here..."
                                    required
                                ><?php echo e(old('message')); ?></textarea>
                            </div>

                            <div>
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

        <div id="payModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">💳 Pay Invoice</h3>
                <button onclick="closePayModal()" class="text-slate-400 hover:text-slate-600 text-xl">✕</button>
            </div>
            <p class="text-sm text-slate-600 mb-4">Total: <span id="payModalAmount" class="font-semibold text-slate-900"></span></p>
            <div id="pay-payment-element" class="border border-slate-300 rounded-xl px-4 py-3 bg-white mb-4"></div>
            <div id="pay-message" class="hidden text-red-600 text-sm mb-3"></div>
            <button id="pay-submit" class="w-full rounded-2xl bg-blue-600 px-6 py-3 text-sm font-medium text-white hover:bg-blue-700">
                Confirm Payment
            </button>
        </div>

    <script src="https://js.stripe.com/v3"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("chatContainer");
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });

        const STRIPE_KEY = <?php echo json_encode(config('services.stripe.public_key'), 15, 512) ?>;
        const CSRF_TOKEN = '<?php echo e(csrf_token()); ?>';

        let currentMessageId = null;
        let stripeInstance   = null;
        let stripeElements   = null;
        let cardElement      = null;
        let currentSecret    = null;

        async function openPayModal(messageId, amount) {
            currentMessageId = messageId;
            document.getElementById('payModalAmount').textContent = '€' + parseFloat(amount).toFixed(2);
            document.getElementById('payModal').classList.remove('hidden');
            document.getElementById('pay-message').classList.add('hidden');
            document.getElementById('pay-submit').disabled    = false;
            document.getElementById('pay-submit').textContent = 'Confirm Payment';

            const res = await fetch('<?php echo e(route('landlord.invoice.payment-intent')); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({ message_id: messageId, amount: amount })
            });

            const json = await res.json();
            currentSecret  = json.client_secret;
            stripeInstance = Stripe(STRIPE_KEY);
            stripeElements = stripeInstance.elements();
            cardElement    = stripeElements.create('card', {
                hidePostalCode: true,
                disableLink: true,
                style: {
                    base: { fontSize: '16px', color: '#424770', '::placeholder': { color: '#aab7c4' } },
                    invalid: { color: '#dc2626' }
                }
            });
            document.getElementById('pay-payment-element').innerHTML = '';
            cardElement.mount('#pay-payment-element');
        }

        function closePayModal() {
            document.getElementById('payModal').classList.add('hidden');
        }

        document.getElementById('pay-submit').addEventListener('click', async () => {
            const btn = document.getElementById('pay-submit');
            const msg = document.getElementById('pay-message');
            btn.disabled    = true;
            btn.textContent = 'Processing...';
            msg.classList.add('hidden');

            const { error, paymentIntent } = await stripeInstance.confirmCardPayment(currentSecret, {
                payment_method: { card: cardElement }
            });

            if (error) {
                msg.textContent = error.message;
                msg.classList.remove('hidden');
                btn.disabled    = false;
                btn.textContent = 'Confirm Payment';
                return;
            }

            if (paymentIntent && paymentIntent.status === 'succeeded') {
                await fetch('<?php echo e(route('landlord.invoice.confirm')); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                    body: JSON.stringify({ message_id: currentMessageId, payment_intent: paymentIntent.id })
                });
                closePayModal();
                window.location.reload();
            }
        });
    </script>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/landlord/messages/service-provider-chat.blade.php ENDPATH**/ ?>