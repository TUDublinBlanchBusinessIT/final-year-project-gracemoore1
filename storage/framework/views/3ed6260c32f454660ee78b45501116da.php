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
        $job = $conversation->serviceRequest;
        $landlordName = $landlord
            ? trim(($landlord->firstname ?? '') . ' ' . ($landlord->surname ?? ''))
            : 'Landlord';
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
                    <?php echo e($errors->first('content')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <div class="border-b border-slate-200 px-8 py-5 bg-white">
                    <div class="flex items-center gap-4">
                        <a href="<?php echo e(route('serviceprovider.messages')); ?>"
                           class="text-slate-500 hover:text-slate-700 text-xl">
                            ←
                        </a>

                        <div class="h-14 w-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-2xl font-semibold">
                            <?php echo e(strtoupper(substr($landlordName, 0, 1))); ?>

                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">
                                <?php echo e($landlordName); ?>

                            </h3>
                            <p class="text-slate-500 text-base">
                                <?php echo e($job->servicetype); ?> ·
                                <?php echo e($job->address_housenumber); ?> <?php echo e($job->address_street); ?>,
                                <?php echo e($job->address_county); ?> <?php echo e($job->address_postcode); ?>

                            </p>
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
                        <div class="mb-4 flex <?php echo e($message->sender_type === 'service_provider' ? 'justify-end' : 'justify-start'); ?>">
                            <div class="<?php echo e($message->sender_type === 'service_provider' ? 'bg-blue-600 text-white' : 'bg-white border border-slate-200 text-slate-800'); ?> max-w-xl rounded-3xl px-5 py-3 shadow-sm">
                                <p class="text-sm leading-6"><?php echo e($message->content); ?></p>
                                <p class="mt-2 text-xs <?php echo e($message->sender_type === 'service_provider' ? 'text-blue-100' : 'text-slate-400'); ?>">
                                    <?php echo e(optional($message->timestamp)->format('d M Y H:i') ?? optional($message->created_at)->format('d M Y H:i')); ?>

                                </p>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-slate-500">
                            No messages yet. Start the conversation with the landlord about this job.
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>

                <div class="border-t border-slate-200 bg-white px-8 py-5">
                    <form method="POST" action="<?php echo e(route('serviceprovider.messages.store', $conversation->id)); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="flex items-end gap-4">
                            <div class="flex-1">
                                <textarea
                                    name="content"
                                    rows="3"
                                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Type your message to the landlord here..."
                                    required
                                ><?php echo e(old('content')); ?></textarea>
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("chatContainer");
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/serviceprovider/chat.blade.php ENDPATH**/ ?>