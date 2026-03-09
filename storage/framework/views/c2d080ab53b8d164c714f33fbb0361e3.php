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

     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-bold text-xl text-gray-800">
            Apply for <?php echo e($rental->street); ?>, <?php echo e($rental->county); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-2xl mx-auto bg-white shadow border rounded-xl p-6 mt-6">

        <h3 class="text-lg font-semibold mb-4">Single Application</h3>

        <form method="POST" action="<?php echo e(route('applications.submit.single', $rental->id)); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="mb-4">
                <label class="font-semibold">Full Name</label>
                <input type="text" 
                       class="w-full bg-slate-100 border rounded-lg px-3 py-2" 
                       value="<?php echo e($student->firstname); ?> <?php echo e($student->surname); ?>"
                       disabled>
            </div>
            <div class="mb-4">
                <label class="font-semibold">Email</label>
                <input type="email" 
                       class="w-full bg-slate-100 border rounded-lg px-3 py-2" 
                       value="<?php echo e($student->email); ?>"
                       disabled>
            </div>

            <input type="hidden" name="applicationtype" value="single">

            
            <div class="mb-4">
                <label class="font-semibold">Age</label>
                <input type="number" name="age" required
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            
            <div class="mb-4">
                <label class="font-semibold">Gender</label>
                <select name="gender" required class="w-full border rounded-lg px-3 py-2">
                    <option value="">Select…</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="nonbinary">Non-binary</option>
                    <option value="prefer_not_say">Prefer not to say</option>
                </select>
            </div>

            
            <div class="mb-4">
                <label class="font-semibold">Additional Details (optional)</label>
                <textarea name="additional_details" rows="4"
                          class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">
                Submit Application
            </button>

        </form>

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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/applications/start-single.blade.php ENDPATH**/ ?>