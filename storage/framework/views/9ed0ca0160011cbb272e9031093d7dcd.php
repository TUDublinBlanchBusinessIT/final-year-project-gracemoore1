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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="max-w-6xl mx-auto px-4 py-6">

        <!-- Tabs -->
        <nav class="border-b border-slate-200">
            <ul class="flex gap-6 text-sm">
                <li>
                    <a href="<?php echo e(route('admin.analytics', ['tab' => 'applications'])); ?>"
                       class="<?php echo e(request('tab', 'applications') === 'applications'
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Applications
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('admin.analytics', ['tab' => 'listings'])); ?>"
                       class="<?php echo e(request('tab') === 'listings'
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Listings
                    </a>
                </li>

                <li>
                    <a href="<?php echo e(route('admin.analytics', ['tab' => 'complaints'])); ?>"
                       class="<?php echo e(request('tab') === 'complaints'
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Complaints
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Chart Section -->
        <div class="mt-6 bg-white p-6 rounded-xl shadow">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('tab', 'applications') === 'applications'): ?>
                <h3 class="text-lg font-semibold mb-4">Applications per County</h3>
                <canvas id="applicationsChart"></canvas>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('tab') === 'listings'): ?>
                <h3 class="text-lg font-semibold mb-4">Listings per County</h3>
                <canvas id="listingsChart"></canvas>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('tab') === 'complaints'): ?>
                <h3 class="text-lg font-semibold mb-4">Complaints by Type</h3>
                <canvas id="complaintsChart"></canvas>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
    </div>

    <script>
        // Applications chart
        <?php if(isset($applications)): ?>
        if (document.getElementById('applicationsChart')) {
            new Chart(document.getElementById('applicationsChart'), {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($applications->keys()); ?>,
                    datasets: [{
                        data: <?php echo json_encode($applications->values()); ?>,
                        backgroundColor: [
                            '#4F46E5','#22C55E','#F59E0B','#EF4444','#6366F1','#10B981'
                        ]
                    }]
                }
            });
        }
        <?php endif; ?>

        // Listings chart
        <?php if(isset($listings)): ?>
        if (document.getElementById('listingsChart')) {
            new Chart(document.getElementById('listingsChart'), {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($listings->keys()); ?>,
                    datasets: [{
                        data: <?php echo json_encode($listings->values()); ?>,
                        backgroundColor: [
                            '#6366F1','#10B981','#F59E0B','#F43F5E','#8B5CF6'
                        ]
                    }]
                }
            });
        }
        <?php endif; ?>

        // Complaints chart
        <?php if(isset($complaints)): ?>
        if (document.getElementById('complaintsChart')) {
            new Chart(document.getElementById('complaintsChart'), {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($complaints->keys()); ?>,
                    datasets: [{
                        data: <?php echo json_encode($complaints->values()); ?>,
                        backgroundColor: [
                            '#EF4444','#F97316','#6B7280','#3B82F6','#F59E0B'
                        ]
                    }]
                }
            });
        }
        <?php endif; ?>
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/chatbot.blade.php ENDPATH**/ ?>