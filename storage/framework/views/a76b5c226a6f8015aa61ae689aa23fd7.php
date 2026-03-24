<?php if (isset($component)) { $__componentOriginalc98b3e35bd8155af0bdb37c6a10156df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.accounts','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.accounts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<div class="max-w-5xl mx-auto">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Suspended Accounts</h2>

    
    <h3 class="text-lg font-semibold text-slate-900 mt-6 mb-2">Students</h3>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="p-3 border rounded mb-2 flex items-center justify-between">
            <div><?php echo e($u->firstname); ?> <?php echo e($u->surname); ?> <span class="text-slate-500">(#<?php echo e($u->id); ?>)</span></div>
            <form method="POST" action="<?php echo e(route('admin.accounts.reactivate', ['type'=>'student','id'=>$u->id])); ?>">
                <?php echo csrf_field(); ?>
                <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Reactivate</button>
            </form>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-slate-500 text-sm">No suspended students.</div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <h3 class="text-lg font-semibold text-slate-900 mt-8 mb-2">Landlords</h3>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $landlords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="p-3 border rounded mb-2 flex items-center justify-between">
            <div><?php echo e($u->firstname); ?> <?php echo e($u->surname); ?> <span class="text-slate-500">(#<?php echo e($u->id); ?>)</span></div>
            <form method="POST" action="<?php echo e(route('admin.accounts.reactivate', ['type'=>'landlord','id'=>$u->id])); ?>">
                <?php echo csrf_field(); ?>
                <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Reactivate</button>
            </form>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-slate-500 text-sm">No suspended landlords.</div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <h3 class="text-lg font-semibold text-slate-900 mt-8 mb-2">Service Providers</h3>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="p-3 border rounded mb-2 flex items-center justify-between">
            <div><?php echo e($u->firstname); ?> <?php echo e($u->surname); ?> — <?php echo e($u->companyname); ?> <span class="text-slate-500">(#<?php echo e($u->id); ?>)</span></div>
            <form method="POST" action="<?php echo e(route('admin.accounts.reactivate', ['type'=>'serviceprovider','id'=>$u->id])); ?>">
                <?php echo csrf_field(); ?>
                <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Reactivate</button>
            </form>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-slate-500 text-sm">No suspended service providers.</div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df)): ?>
<?php $attributes = $__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df; ?>
<?php unset($__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc98b3e35bd8155af0bdb37c6a10156df)): ?>
<?php $component = $__componentOriginalc98b3e35bd8155af0bdb37c6a10156df; ?>
<?php unset($__componentOriginalc98b3e35bd8155af0bdb37c6a10156df); ?>
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/suspended-accounts.blade.php ENDPATH**/ ?>