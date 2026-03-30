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
            Maintenance Log
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">
                
                <div class="border-b border-slate-200 px-6 py-4 bg-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-800">Maintenance Tracker</h3>
                            <p class="text-sm text-slate-500 mt-1">
                                <?php echo e($application->rental->housenumber ?? ''); ?>

                                <?php echo e($application->rental->street ?? ''); ?>,
                                <?php echo e($application->rental->county ?? ''); ?>

                            </p>
                        </div>

                        <a href="<?php echo e(route('student.messages.show', $application->id)); ?>"
                           class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            ← Back to Messages
                        </a>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Describe the issue
                        </label>
                        <textarea
                            rows="5"
                            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Example: There is a leak under the kitchen sink and water is collecting on the floor."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Urgency level
                        </label>
                        <div class="flex items-center gap-4">
                            <button type="button" class="h-5 w-5 rounded-full bg-red-500"></button>
                            <button type="button" class="h-5 w-5 rounded-full bg-orange-400"></button>
                            <button type="button" class="h-5 w-5 rounded-full bg-green-500"></button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Upload image
                        </label>
                        <div class="border-2 border-dashed border-slate-300 rounded-2xl p-6 text-center text-slate-500">
                            Image upload feature coming next
                        </div>
                    </div>

                    <div class="pt-2">
                        <button
                            type="button"
                            class="inline-flex items-center rounded-xl bg-slate-800 px-5 py-3 text-white font-medium hover:bg-slate-700 transition">
                            Save Maintenance Issue
                        </button>
                    </div>
                </div>

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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/student/maintenance-log.blade.php ENDPATH**/ ?>