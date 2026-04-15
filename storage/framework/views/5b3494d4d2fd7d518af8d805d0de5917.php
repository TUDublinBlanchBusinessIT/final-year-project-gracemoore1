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

        <h2 class="text-lg font-semibold text-gray-900">Service Provider Accounts</h2>

        <table class="mt-4 w-full text-left text-sm">
            <thead class="border-b font-semibold text-slate-700">
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Full Name</th>
                    <th class="py-2">Company Name</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Created By</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

                    <?php
                        $staff = \App\Models\Staff::find($p->administratorid);
                    ?>

                    <tr class="border-b">
                        <td class="py-2"><?php echo e($p->id); ?></td>

                        <td class="py-2">
                            <?php echo e($p->firstname); ?> <?php echo e($p->surname); ?>

                        </td>

                        <td class="py-2"><?php echo e($p->companyname); ?></td>

                        <td class="py-2"><?php echo e($p->email); ?></td>

                        <td class="py-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($staff): ?>
                                <?php echo e($staff->firstname); ?> <?php echo e($staff->surname); ?>

                            <?php else: ?>
                                Unknown
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>

                        <td class="py-2">
                            <a href="<?php echo e(route('admin.accounts.serviceprovider.view', $p->id)); ?>"
                               class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                View
                            </a>
                        </td>
                    </tr>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            </tbody>
        </table>

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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/admin/serviceprovider-accounts.blade.php ENDPATH**/ ?>