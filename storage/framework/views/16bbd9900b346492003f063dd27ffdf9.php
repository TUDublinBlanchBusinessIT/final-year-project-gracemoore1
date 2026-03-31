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

        <h2 class="text-lg font-semibold text-gray-900 mb-4">
            Reports
        </h2>

        
        <div class="mb-6 border-b border-slate-200">
            <nav class="flex gap-6 text-sm">
                <a href="<?php echo e(route('admin.reports')); ?>"
                   class="<?php echo e($activeTab === 'pending' ? 'font-semibold border-b-2 border-slate-900' : 'text-slate-600'); ?>">
                    Reports to be handled
                </a>

                <a href="<?php echo e(route('admin.reports.action')); ?>"
                   class="<?php echo e($activeTab === 'action' ? 'font-semibold border-b-2 border-slate-900' : 'text-slate-600'); ?>">
                    Action required
                </a>

                <a href="<?php echo e(route('admin.reports.noaction')); ?>"
                   class="<?php echo e($activeTab === 'noaction' ? 'font-semibold border-b-2 border-slate-900' : 'text-slate-600'); ?>">
                    No action required
                </a>
            </nav>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reports->count() === 0): ?>
            <p class="text-sm text-gray-600">No reports found.</p>
        <?php else: ?>
            <table class="w-full text-left text-sm">
                <thead class="border-b font-semibold text-slate-700">
                    <tr>
                        <th class="py-2">ID</th>
                        <th class="py-2">Preview</th>
                        <th class="py-2">Submitted</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <tr class="border-b">
                            <td class="py-2"><?php echo e($r->id); ?></td>
                            <td class="py-2"><?php echo e(Str::limit($r->description, 60)); ?></td>
                            <td class="py-2"><?php echo e(\Carbon\Carbon::parse($r->created_at)->format('d/m/Y')); ?></td>
                            <td class="py-2">
                                <?php echo e(route('admin.reports.view', $r->id)); ?>

                                    View
                                </a>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </tbody>
            </table>
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>