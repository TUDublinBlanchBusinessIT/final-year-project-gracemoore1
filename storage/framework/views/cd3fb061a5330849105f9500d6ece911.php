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

    <div class="pb-28 lg:pl-70">
        <div class="max-w-5xl mx-auto">

            <div class="mb-6">
                <h1 class="text-3xl font-semibold text-slate-900">Messages</h1>
                <p class="text-blue-500 mt-2">Manage conversations with landlords</p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 p-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($conversations->count() == 0): ?>
                    <div class="text-center py-10 text-slate-500">
                        <p class="text-lg font-medium">No messages yet</p>
                        <p class="text-sm text-slate-400 mt-2">
                            When you message a landlord about a job, it will appear here.
                        </p>
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

                            <?php
                                $lastMessage = $conversation->sortByDesc('created_at')->first();

                                $unreadCount = $conversation
                                    ->where('sender_type', '!=', 'service_provider')
                                    ->where('is_read_by_service_provider', false)
                                    ->count();

                                $job = \App\Models\ServiceRequest::where('rentalid', $lastMessage->rentalid)
                                    ->where('landlordid', $lastMessage->landlordid)
                                    ->latest()
                                    ->first();
                            ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($job): ?>
                                <a href="<?php echo e(route('serviceprovider.messages.show', $lastMessage->serviceproviderpartnershipid)); ?>"
                                   class="block rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-blue-200 hover:shadow-md">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-base font-semibold text-black truncate">
                                                <?php echo e($job->servicetype); ?>

                                            </h3>

                                            <p class="mt-1 text-sm text-slate-500">
                                                <?php echo e($job->address_housenumber ?? ''); ?>

                                                <?php echo e($job->address_street ?? ''); ?>,
                                                <?php echo e($job->address_county ?? ''); ?>

                                                <?php echo e($job->address_postcode ?? ''); ?>

                                            </p>

                                            <p class="mt-3 text-sm text-slate-700 truncate">
                                                <?php echo e(\Illuminate\Support\Str::limit($lastMessage->content, 90)); ?>

                                            </p>
                                        </div>

                                        <div class="ml-4 flex flex-col items-end gap-2 shrink-0">
                                            <div class="text-xs text-slate-400 whitespace-nowrap">
                                                <?php echo e($lastMessage && $lastMessage->created_at ? $lastMessage->created_at->format('d M Y H:i') : ''); ?>

                                            </div>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
                                                <span class="inline-flex items-center justify-center min-w-[22px] h-[22px] rounded-full bg-red-500 px-2 text-xs font-semibold text-white">
                                                    <?php echo e($unreadCount); ?>

                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

        </div>
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/serviceprovider/messages.blade.php ENDPATH**/ ?>