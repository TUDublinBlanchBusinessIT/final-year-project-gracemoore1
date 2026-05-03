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
    <div class="border-b border-slate-200 px-6 py-3 bg-white">
        <div class="flex items-center gap-4">
            <a href="<?php echo e(url()->previous()); ?>"
               class="text-slate-500 hover:text-slate-700 text-xl">←</a>

            <div class="min-w-0">
                <p class="text-m font-semibold uppercase tracking-[0.12em] text-blue-600">
                    Messages <span class="mx-1 text-slate-300">/</span> Maintenance Log <span class="mx-1 text-slate-300">/</span> Book Service Provider
                </p>
            </div>
        </div>
    </div>
 <?php $__env->endSlot(); ?>

    <div class="pb-28 lg:pl-70">
        <div class="max-w-3xl mx-auto bg-white shadow-sm sm:rounded-2xl border border-slate-200 p-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    <ul class="list-disc pl-5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <li><?php echo e($error); ?></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(route('landlord.service-request.store', $log->id)); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="servicetype" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Select type</option>
                        <option value="Plumbing" <?php echo e(old('servicetype') == 'Plumbing' ? 'selected' : ''); ?>>Plumbing</option>
                        <option value="Electrician" <?php echo e(old('servicetype') == 'Electrician' ? 'selected' : ''); ?>>Electrician</option>
                        <option value="Cleaning" <?php echo e(old('servicetype') == 'Cleaning' ? 'selected' : ''); ?>>Cleaning</option>
                        <option value="Estate Agent" <?php echo e(old('servicetype') == 'Estate Agent' ? 'selected' : ''); ?>>Estate Agent</option>
                        <option value="Other" <?php echo e(old('servicetype') == 'Other' ? 'selected' : ''); ?>>Other</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">House Number</label>
                        <input type="text" name="housenumber" value="<?php echo e(old('housenumber', $rental->housenumber)); ?>"
                            class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Postcode</label>
                        <input type="text" name="postcode" value="<?php echo e(old('postcode', $rental->postcode)); ?>"
                            class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Street</label>
                    <input type="text" name="street" value="<?php echo e(old('street', $rental->street)); ?>"
                        class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">County</label>
                    <input type="text" name="county" value="<?php echo e(old('county', $rental->county)); ?>"
                        class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="5"
                        class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                        required><?php echo e(old('description', $log->description)); ?></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Optional Image</label>
                    <input type="file" name="image"
                        class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="mb-6">
                    <label class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_urgent"
                            value="1"
                            <?php echo e(old('is_urgent') ? 'checked' : ''); ?>

                            class="mt-1 rounded border-slate-300 text-red-600 focus:ring-red-500"
                        >
                        <div>
                            <span class="block text-sm font-semibold text-red-700">Urgent</span>
                            <span class="block text-sm text-red-600">Needed today</span>
                        </div>
                    </label>
                </div>
                
                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                        Submit Request
                    </button>

                    <a href="<?php echo e(url()->previous()); ?>"
                        class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
                        Cancel
                    </a>
                </div>
            </form>
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/landlord/maintenance/book-service-provider.blade.php ENDPATH**/ ?>