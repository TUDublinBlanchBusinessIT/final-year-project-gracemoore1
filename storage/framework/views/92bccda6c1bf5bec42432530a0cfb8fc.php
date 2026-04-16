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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Account Analytics
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-6xl mx-auto px-4 py-6">

        <!-- Main Tabs -->
        <nav class="border-b border-slate-200">
            <ul class="flex gap-6 text-sm">
                <li>
                    <a href="<?php echo e(route('admin.analytics', ['tab' => 'applications'])); ?>"
                       class="<?php echo e($tab === 'applications' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Applications
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.analytics', ['tab' => 'listings'])); ?>"
                       class="<?php echo e($tab === 'listings' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Listings
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.analytics', ['tab' => 'complaints'])); ?>"
                       class="<?php echo e($tab === 'complaints' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Complaints
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Complaints Sub-Tabs -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tab === 'complaints'): ?>
        <nav class="border-b border-slate-200 mt-4">
            <ul class="flex gap-6 text-sm">
                <li>
                    <a href="<?php echo e(route('admin.analytics', ['tab' => 'complaints', 'complaint_tab' => 'reported'])); ?>"
                       class="<?php echo e($complaintTab === 'reported' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Who Is Being Reported
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.analytics', ['tab' => 'complaints', 'complaint_tab' => 'reporter'])); ?>"
                       class="<?php echo e($complaintTab === 'reporter' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Who Is Reporting
                    </a>
                </li>
            </ul>
        </nav>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Table Section -->
        <div class="mt-6 bg-white p-6 rounded-xl shadow">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tab === 'applications'): ?>
                <h3 class="text-lg font-semibold mb-4">Applications per County</h3>
                <table class="w-full text-left text-sm">
                    <thead class="border-b font-semibold text-slate-700">
                        <tr>
                            <th class="py-2">County</th>
                            <th class="py-2">Total Applications</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr class="border-b hover:bg-slate-50">
                                <td class="py-2"><?php echo e($county ?: 'Unknown'); ?></td>
                                <td class="py-2"><?php echo e($total); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="2" class="py-4 text-slate-500">No data available.</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>

            <?php elseif($tab === 'listings'): ?>
                <h3 class="text-lg font-semibold mb-4">Listings per County</h3>
                <table class="w-full text-left text-sm">
                    <thead class="border-b font-semibold text-slate-700">
                        <tr>
                            <th class="py-2">County</th>
                            <th class="py-2">Total Listings</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $listings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr class="border-b hover:bg-slate-50">
                                <td class="py-2"><?php echo e($county ?: 'Unknown'); ?></td>
                                <td class="py-2"><?php echo e($total); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="2" class="py-4 text-slate-500">No data available.</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>

            <?php elseif($tab === 'complaints'): ?>
                <h3 class="text-lg font-semibold mb-4">
                    <?php echo e($complaintTab === 'reported' ? 'Who Is Being Reported' : 'Who Is Reporting'); ?>

                </h3>
                <table class="w-full text-left text-sm">
                    <thead class="border-b font-semibold text-slate-700">
                        <tr>
                            <th class="py-2">Role</th>
                            <th class="py-2">Total Complaints</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $complaints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <tr class="border-b hover:bg-slate-50">
                                <td class="py-2"><?php echo e(ucfirst($role)); ?></td>
                                <td class="py-2"><?php echo e($total); ?></td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="2" class="py-4 text-slate-500">No data available.</td>
                            </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/analytics.blade.php ENDPATH**/ ?>