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
                <p class="text-m font-semibold uppercase tracking-[0.12em] text-blue-600">
                    Completed Jobs
                </p>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="pb-20 lg:pl-70">
        <div class="max-w-5xl mx-auto">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $providerRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $providerRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden mb-6">
                    <div class="p-8">
                        <div class="flex flex-wrap items-center gap-3 mb-3">
                            <h3 class="text-2xl font-semibold text-slate-900">
                                <?php echo e($providerRequest->servicetype ?? 'Service Job'); ?>

                            </h3>

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                Completed
                            </span>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($providerRequest->urgent)): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-600">
                                    Urgent
                                </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <p class="text-slate-600 text-lg">
                            <?php echo e($providerRequest->housenumber ?? ''); ?>

                            <?php echo e($providerRequest->street ?? ''); ?>,
                            <?php echo e($providerRequest->county ?? ''); ?>

                            <?php echo e($providerRequest->postcode ?? ''); ?>

                        </p>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($providerRequest->accepted_at)): ?>
                            <p class="text-slate-600 text-lg mt-1">
                                Accepted on
                            </p>
                            <p class="text-slate-400 text-lg">
                                <?php echo e(\Carbon\Carbon::parse($providerRequest->accepted_at)->format('d M Y H:i')); ?>

                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($providerRequest->completed_at)): ?>
                            <p class="text-slate-600 text-lg mt-1">
                                Completed on
                            </p>
                            <p class="text-slate-400 text-lg">
                                <?php echo e(\Carbon\Carbon::parse($providerRequest->completed_at)->format('d M Y H:i')); ?>

                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($providerRequest->description)): ?>
                            <p class="text-slate-800 text-2xl mt-6">
                                <?php echo e($providerRequest->description); ?>

                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="<?php echo e(route('serviceprovider.messages.show', $providerRequest->id)); ?>"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                Open Chat
                            </a>
                        </div>
                    </div>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="p-8">
                        <p class="text-slate-500 text-lg">
                            No completed jobs yet.
                        </p>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/serviceprovider/completed.blade.php ENDPATH**/ ?>