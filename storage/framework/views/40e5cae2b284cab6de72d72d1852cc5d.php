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
            Report an Account
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="flex justify-center px-4 py-2">
        <div class="w-full max-w-3xl">

            
            <div class="mb-6 rounded-xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">
                <p class="font-medium mb-1">
                    Creating a safe and respectful platform
                </p>
                <p class="text-blue-800">
                    RentConnect reviews all reports carefully. If you believe a user has breached our
                    platform standards or code of conduct, please submit a report so our team can investigate.
                </p>
            </div>

            
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-8">

                
                <div class="mb-8">
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-3">
                        Report details
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 rounded-xl bg-slate-50 border border-slate-200 p-4 text-sm">
                        <div>
                            <p class="text-slate-500">Reporter</p>
                            <p class="font-medium text-slate-900">
                                <?php echo e($reporterDisplay); ?>

                            </p>
                        </div>

                        <div>
                            <p class="text-slate-500">Reported account</p>
                            <p class="font-medium text-slate-900">
                                <?php echo e($reportedDisplay); ?>

                            </p>
                        </div>
                    </div>
                </div>

                
                <form action="<?php echo e(route('complaint.store')); ?>"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="reported_user_id" value="<?php echo e($reported_user_id); ?>">
                    <input type="hidden" name="reported_user_role" value="<?php echo e($reported_user_role); ?>">

                    
                    <div>
                        <label class="block text-sm font-medium text-slate-800 mb-1">
                            Subject
                        </label>
                        <p class="text-xs text-slate-500 mb-2">
                            A short, one‑sentence summary of the issue.
                        </p>
                        <input
                            type="text"
                            name="subject"
                            maxlength="150"
                            required
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm
                                   focus:border-blue-400 focus:ring focus:ring-blue-100"
                            placeholder="e.g. Inappropriate or abusive messages"
                        >
                    </div>

                    
                    <div>
                        <label class="block text-sm font-medium text-slate-800 mb-1">
                            Description
                        </label>
                        <p class="text-xs text-slate-500 mb-2">
                            Please describe what happened, including any relevant dates or context.
                        </p>
                        <textarea
                            name="details"
                            rows="6"
                            required
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm
                                   focus:border-blue-400 focus:ring focus:ring-blue-100"
                            placeholder="Provide as much detail as possible to help our team review this report."
                        ></textarea>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-medium text-slate-800 mb-1">
                            Supporting evidence (optional)
                        </label>
                        <p class="text-xs text-slate-500 mb-2">
                            You may upload up to 5 images if you wish to provide supporting evidence.
                        </p>
                        <input
                            type="file"
                            name="images[]"
                            multiple
                            accept="image/*"
                            class="block w-full text-sm text-slate-700"
                        >
                    </div>

                    
                    <div class="pt-6 flex justify-center">
                        <button
                            type="submit"
                            class="rounded-xl bg-red-600 px-8 py-3 text-sm font-medium text-white
                                   hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300"
                        >
                            Submit report
                        </button>
                    </div>
                    <input type="hidden" name="reporter_id" value="<?php echo e($user_id); ?>">
                    <input type="hidden" name="reporter_role" value="<?php echo e($user_role); ?>">
                </form>
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/complaint/create.blade.php ENDPATH**/ ?>