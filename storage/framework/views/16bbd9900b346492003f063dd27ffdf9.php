<?php if (isset($component)) { $__componentOriginalf05426b2055438d67d172ae68c8fe3ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf05426b2055438d67d172ae68c8fe3ad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.reports','data' => ['activeTab' => $activeTab]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.reports'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['activeTab' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeTab)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


    <div class="p-6 bg-white shadow rounded-lg">

        <h2 class="text-lg font-semibold text-gray-900 mb-4">
            Reports
        </h2>

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
                            <td class="py-2 font-medium text-slate-900">
                                <?php echo e($r->subject_preview); ?>

                            </td>
                            <td class="py-2">
                                <?php echo e(\Carbon\Carbon::parse($r->created_at)->format('d/m/Y')); ?>

                            </td>
                            <td class="py-2">
                                <a href="<?php echo e(route('admin.reports.view', $r->id)); ?>"
                                   class="text-blue-600 hover:underline">
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
<?php if (isset($__attributesOriginalf05426b2055438d67d172ae68c8fe3ad)): ?>
<?php $attributes = $__attributesOriginalf05426b2055438d67d172ae68c8fe3ad; ?>
<?php unset($__attributesOriginalf05426b2055438d67d172ae68c8fe3ad); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf05426b2055438d67d172ae68c8fe3ad)): ?>
<?php $component = $__componentOriginalf05426b2055438d67d172ae68c8fe3ad; ?>
<?php unset($__componentOriginalf05426b2055438d67d172ae68c8fe3ad); ?>
<?php endif; ?>
<?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>