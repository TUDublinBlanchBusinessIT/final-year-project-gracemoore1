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


<div class="p-6 bg-white shadow rounded-lg">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Group Applications</h2>

    
    <form method="GET" class="mb-6 flex gap-2">
        <input name="q" value="<?php echo e($term); ?>"
               placeholder="Search by student ID or listing address..."
               class="border px-3 py-2 rounded w-80">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
    </form>

    <table class="w-full text-left text-sm">
        <thead class="border-b font-semibold text-slate-700">
            <tr>
                <th class="py-2">Application ID</th>
                <th class="py-2">Group ID</th>
                <th class="py-2">Student IDs</th>
                <th class="py-2">Listing Address</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php
                    $members = optional($app->group)->members ?? collect();
                    $idList = $members->pluck('id')->implode(', ');
                ?>

                <tr class="border-b">
                    <td class="py-2"><?php echo e($app->id); ?></td>
                    <td class="py-2"><?php echo e($app->group_id); ?></td>

                    <td class="py-2">
                        <?php echo e($idList ?: 'N/A'); ?>

                    </td>

                    <td class="py-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->rental): ?>
                            <?php echo e($app->rental->housenumber ? $app->rental->housenumber.' ' : ''); ?>

                            <?php echo e($app->rental->street); ?>, <?php echo e($app->rental->county); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>

                    <td class="py-2">
                        <a href="<?php echo e(route('admin.accounts.groupapplications.view', $app->id)); ?>"
                           class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                            View
                        </a>
                    </td>
                </tr>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr><td colspan="5" class="py-3 text-slate-500">No group applications found.</td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>

    <div class="mt-4"><?php echo e($results->links()); ?></div>

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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/admin/group-applications.blade.php ENDPATH**/ ?>