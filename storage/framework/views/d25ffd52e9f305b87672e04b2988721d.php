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
            <p class="text-lg font-bold uppercase tracking-[0.12em] text-blue-600">
                Completed Jobs
            </p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="pb-20 lg:pl-70">
        <div class="max-w-4xl mx-auto space-y-4">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $completedJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $providerRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $job = $providerRequest->serviceRequest;
                ?>

                <div class="bg-white shadow-sm rounded-xl border border-slate-200 px-5 py-4">

                    <!-- Title + Status -->
                    <div class="flex items-center gap-2 mb-2">
                        <h3 class="text-base font-semibold text-slate-900">
                            <?php echo e($job->servicetype ?? 'Service Job'); ?>

                        </h3>

                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            Completed
                        </span>
                    </div>

                    <!-- Address -->
                    <p class="text-sm text-slate-700 mb-2">
                        <?php echo e($job->address_housenumber); ?> <?php echo e($job->address_street); ?>,
                        <?php echo e($job->address_county); ?> <?php echo e($job->address_postcode); ?>

                    </p>

                    <!-- Dates -->
                    <div class="text-sm text-slate-500 space-y-1">

                        <p>
                            <span class="font-semibold text-slate-700">Posted:</span>
                            <?php echo e(optional($job->created_at)->format('d M Y H:i')); ?>

                        </p>

                        <p>
                            <span class="font-semibold text-slate-700">Completed:</span>
                            <?php echo e(\Carbon\Carbon::parse($providerRequest->responded_at)->format('d M Y H:i')); ?>

                        </p>

                    </div>

                </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="bg-white shadow-sm rounded-xl border border-slate-200 px-5 py-4">
                    <p class="text-slate-500 text-sm">
                        No completed jobs yet.
                    </p>
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
<?php endif; ?>


                <?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/serviceprovider/completed.blade.php ENDPATH**/ ?>