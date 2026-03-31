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
        <div class="flex items-start justify-start">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">
                    RentConnect
                </div>
                <div class="mt-1 font-semibold text-gray-800">
                    Reports
                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-6xl mx-auto px-4 py-8">

        
        <nav class="mt-3 border-b border-slate-200">
            <ul class="flex gap-6 text-sm">

                <li>
                    <a href="<?php echo e(route('admin.reports')); ?>"
                       class="<?php echo e($activeTab === 'pending'
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Reports to be handled
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('admin.reports.action')); ?>"
                       class="<?php echo e($activeTab === 'action'
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Action required
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('admin.reports.noaction')); ?>"
                       class="<?php echo e($activeTab === 'noaction'
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        No action required
                    </a>
                </li>

            </ul>
        </nav>

        <div class="mt-6">
            <?php echo e($slot); ?>

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
<?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/components/admin/reports.blade.php ENDPATH**/ ?>