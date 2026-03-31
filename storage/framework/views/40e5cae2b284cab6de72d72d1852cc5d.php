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
        <h2 class="font-semibold text-base text-gray-800 leading-tight">Report account</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="mb-4 p-3 rounded-xl bg-green-50 text-green-700 text-sm">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form action="<?php echo e(route('complaint.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <input type="hidden" name="reported_user_id" value="<?php echo e($reported_user_id); ?>">
                <input type="hidden" name="reported_user_role" value="<?php echo e($reported_user_role); ?>">

                <label class="block text-sm font-medium text-slate-700">Subject</label>
                <input name="subject" required maxlength="150"
                       class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm">

                <label class="block text-sm font-medium text-slate-700 mt-4">Description</label>
                <textarea name="details" required rows="6"
                          class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm"></textarea>

                <label class="block text-sm font-medium text-slate-700 mt-4">Evidence (up to 5 images)</label>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="mt-1 block w-full text-sm">

                <button type="submit"
                        class="mt-6 rounded-2xl bg-red-600 px-5 py-3 text-sm font-medium text-white hover:bg-red-700">
                    Submit report
                </button>
            </form>
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