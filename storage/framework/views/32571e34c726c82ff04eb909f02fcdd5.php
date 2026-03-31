<?php if (isset($component)) { $__componentOriginalf05426b2055438d67d172ae68c8fe3ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf05426b2055438d67d172ae68c8fe3ad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.reports','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.reports'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


    <div class="p-6 bg-white shadow rounded-lg max-w-4xl mx-auto">

        <h2 class="text-xl font-bold text-gray-900 mb-4">
            Report Details
        </h2>

        <div class="space-y-3 text-gray-800 mb-6">

            
            <div class="mb-3">
                <p class="text-sm text-slate-500">Subject</p>
                <p class="text-lg font-semibold text-slate-900">
                    <?php echo e($subject); ?>

                </p>
            </div>

            <p><strong>Reporter:</strong> <?php echo e($reporterName); ?> (<?php echo e($report->reporter_role); ?>)</p>
            <p><strong>Reported user:</strong> <?php echo e($reportedName); ?> (<?php echo e($report->reported_user_role); ?>)</p>
            <p>
                <strong>Submitted:</strong>
                <?php echo e(\Carbon\Carbon::parse($report->created_at)->format('d/m/Y H:i')); ?>

            </p>
        </div>

        <hr class="my-4">

        <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-2">Full Report</h3>
            <pre class="bg-slate-50 p-4 rounded-lg text-sm whitespace-pre-wrap">
<?php echo e($report->description); ?>

            </pre>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-2">Evidence</h3>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(empty($evidencePaths)): ?>
                <p class="text-sm text-gray-600">No evidence uploaded.</p>
            <?php else: ?>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $evidencePaths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <img
                            src="<?php echo e(asset('storage/'.$path)); ?>"
                            class="rounded-lg border"
                        >
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="flex gap-4">
            <form method="POST" action="<?php echo e(route('admin.reports.noaction', $report->id)); ?>">
                <?php echo csrf_field(); ?>
                <button class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    No action needed
                </button>
            </form>

            <form method="POST" action="<?php echo e(route('admin.reports.suspend', $report->id)); ?>">
                <?php echo csrf_field(); ?>
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Suspend reported account
                </button>
            </form>
        </div>

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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/reports/show.blade.php ENDPATH**/ ?>