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

<div class="p-6 bg-white shadow rounded-lg max-w-4xl mx-auto">

    <h2 class="text-2xl font-bold mb-4">Group Application Details</h2>

    
    <div class="mb-6">
        <h3 class="text-lg font-semibold">Listing</h3>
        <p><strong>ID:</strong> <?php echo e($app->rental->id); ?></p>
        <p><strong>Address:</strong>
            <?php echo e($app->rental->housenumber ? $app->rental->housenumber.' ' : ''); ?>

            <?php echo e($app->rental->street); ?>, <?php echo e($app->rental->county); ?>

        </p>
        <p><strong>Landlord:</strong>
           <?php
            $landlord = \App\Models\Landlord::find($app->rental->landlordid);
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($landlord): ?>
            <?php echo e($landlord->firstname); ?> <?php echo e($landlord->surname); ?> (<?php echo e($landlord->email); ?>)
        <?php else: ?>
            Unknown
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </p>
    </div>

    
    <div class="mb-6">
        <h3 class="text-lg font-semibold">Group Members</h3>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $app->group->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="p-2 border rounded mb-2">
                <p><strong>ID:</strong> <?php echo e($m->id); ?></p>
                <p><strong>Name:</strong> <?php echo e($m->firstname); ?> <?php echo e($m->surname); ?></p>
                <p><strong>Email:</strong> <?php echo e($m->email); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div>
        <h3 class="text-lg font-semibold mb-1">Application Info</h3>
        <p><strong>Application ID:</strong> <?php echo e($app->id); ?></p>
        <p><strong>Group ID:</strong> <?php echo e($app->group_id); ?></p>
        <p><strong>Status:</strong> <?php echo e(ucfirst($app->status)); ?></p>
        <p><strong>Date Applied:</strong> <?php echo e($app->dateapplied); ?></p>
    </div>

</div>
<a href="<?php echo e(route('admin.accounts.groupapplications')); ?>" class="text-blue-600 hover:underline">
    ← Back to Group Applications
</a>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df)): ?>
<?php $attributes = $__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df; ?>
<?php unset($__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc98b3e35bd8155af0bdb37c6a10156df)): ?>
<?php $component = $__componentOriginalc98b3e35bd8155af0bdb37c6a10156df; ?>
<?php unset($__componentOriginalc98b3e35bd8155af0bdb37c6a10156df); ?>
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/view-group-applicationS.blade.php ENDPATH**/ ?>