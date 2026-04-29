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
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


<div class="p-6 bg-white shadow rounded-lg max-w-4xl mx-auto">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Service Provider Profile</h2>

    <div class="space-y-2 text-gray-800">
        <p><strong>Firstname:</strong> <?php echo e($provider->firstname); ?></p>
        <p><strong>Surname:</strong> <?php echo e($provider->surname); ?></p>
        <p><strong>Company Name:</strong> <?php echo e($provider->companyname); ?></p>
        <p><strong>Email:</strong> <?php echo e($provider->email); ?></p>
        <p><strong>Phone:</strong> <?php echo e($provider->phone); ?></p>
        <p><strong>County:</strong> <?php echo e($provider->county); ?></p>
        <p><strong>Service Type:</strong> <?php echo e($provider->servicetype); ?></p>
        <p><strong>Commission Per Job:</strong>
            €<?php echo e($provider->commissionperjob ?? '0'); ?>

        </p>
        <p><strong>Fee Per Month:</strong>
            €<?php echo e($provider->feepermonth ?? '0'); ?>

        </p>
        <p><strong>Created By Admin:</strong>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($admin): ?>
                <?php echo e($admin->firstname); ?> <?php echo e($admin->surname); ?>

            <?php else: ?>
                Unknown
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </p>
    </div>

    <div class="mt-8 flex gap-4">
        <form method="POST" action="<?php echo e(route('admin.accounts.suspend', ['type'=>'serviceprovider','id'=>$provider->id])); ?>">
            <?php echo csrf_field(); ?>
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Suspend Account</button>
        </form>

        <form method="POST" action="<?php echo e(route('admin.accounts.reactivate', ['type'=>'serviceprovider','id'=>$provider->id])); ?>">
            <?php echo csrf_field(); ?>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Reactivate Account</button>
        </form>
    </div>
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/view-serviceprovider.blade.php ENDPATH**/ ?>