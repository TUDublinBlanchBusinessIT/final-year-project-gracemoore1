<?php
    use Illuminate\Support\Facades\Storage;
?>

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
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Maintenance Log
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="pb-20 lg:pl-70">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <div class="border-b border-slate-200 px-8 py-5 bg-white">
                    <div class="flex items-center gap-4">
                        <a href="<?php echo e(route('student.messages.show', $application->id)); ?>"
                           class="text-slate-500 hover:text-slate-700 text-xl">
                            ←
                        </a>

                        <div class="h-14 w-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-2xl font-semibold">
                            M
                        </div>

                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">
                                Maintenance Tracker
                            </h3>
                            <p class="text-slate-500 text-base">
                                <?php echo e($application->rental->housenumber ?? ''); ?>

                                <?php echo e($application->rental->street ?? ''); ?>,
                                <?php echo e($application->rental->county ?? ''); ?>

                            </p>
                        </div>
                    </div>
                </div>

                <div id="maintenanceContainer" class="px-8 py-6 bg-slate-50 min-h-[260px] max-h-[420px] overflow-y-auto">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                        <div class="mb-6 rounded-xl bg-green-100 text-green-800 px-4 py-3">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php
                        $lastDate = null;
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $logDate = optional($log->timestamp)->format('d M Y')
                                ?? optional($log->created_at)->format('d M Y');
                        ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastDate !== $logDate): ?>
                            <div class="flex justify-center my-4">
                                <span class="px-4 py-1 rounded-full bg-slate-200 text-slate-600 text-xs">
                                    <?php echo e($logDate); ?>

                                </span>
                            </div>
                            <?php
                                $lastDate = $logDate;
                            ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="flex justify-end mb-6">
                            <div class="max-w-md rounded-3xl px-6 py-5 shadow-sm
                                <?php if($log->priority === 'high'): ?> bg-red-500 text-white
                                <?php elseif($log->priority === 'medium'): ?> bg-orange-400 text-white
                                <?php else: ?> bg-green-500 text-white
                                <?php endif; ?>">

                                <div class="text-sm font-semibold uppercase tracking-wide mb-2">
                                    <?php echo e($log->priority); ?> priority
                                </div>

                                <div class="text-lg font-semibold mb-2">
                                    Maintenance Issue
                                </div>

                                <div class="text-sm leading-6">
                                    <?php echo e($log->description); ?>

                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($log->images)): ?>
                                    <div class="mt-3">
                                        <a href="<?php echo e(asset('storage/' . $log->images)); ?>" target="_blank">
                                            <img src="<?php echo e(asset('storage/' . $log->images)); ?>"
                                                 alt="Maintenance issue image"
                                                 class="mt-3 rounded-xl max-h-40 w-auto object-cover border border-white/20 shadow-sm cursor-pointer">
                                        </a>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <div class="text-xs mt-4 opacity-90">
                                    <?php echo e(optional($log->timestamp)->format('d M Y H:i')
                                        ?? optional($log->created_at)->format('d M Y H:i')); ?>

                                </div>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="flex flex-col items-center justify-center text-center text-slate-400 py-12">
                            <div class="text-4xl mb-3">🛠</div>
                            <p class="text-base font-medium text-slate-500">No maintenance issues logged yet</p>
                            <p class="text-sm text-slate-400 mt-1">Submit an issue below and it will appear here.</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="border-t border-slate-200 bg-white px-8 py-6">
                    <form method="POST" action="<?php echo e(route('student.maintenance-log.store', $application->id)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">

                            <div class="lg:col-span-7">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Describe the issue
                                </label>
                                <textarea
                                    name="description"
                                    rows="3"
                                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Example: There is a leak under the kitchen sink."
                                ><?php echo e(old('description')); ?></textarea>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Priority
                                </label>
                                <select
                                    name="priority"
                                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    <option value="high" <?php echo e(old('priority') === 'high' ? 'selected' : ''); ?>>🔴 High</option>
                                    <option value="medium" <?php echo e(old('priority') === 'medium' ? 'selected' : ''); ?>>🟠 Medium</option>
                                    <option value="low" <?php echo e(old('priority') === 'low' ? 'selected' : ''); ?>>🟢 Low</option>
                                </select>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <div class="lg:col-span-3">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Add image
                                </label>
                                <input
                                    type="file"
                                    name="image"
                                    accept="image/*"
                                    class="block w-full text-sm text-slate-600
                                           file:mr-3 file:py-2 file:px-4
                                           file:rounded-xl file:border-0
                                           file:text-sm file:font-medium
                                           file:bg-slate-100 file:text-slate-700
                                           hover:file:bg-slate-200"
                                >

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <div class="mt-5 flex justify-end">
                            <button
                                type="submit"
                                class="inline-flex items-center rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition">
                                Save Maintenance Issue
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("maintenanceContainer");
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/student/maintenance-log.blade.php ENDPATH**/ ?>