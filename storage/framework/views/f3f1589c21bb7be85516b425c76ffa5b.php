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
            Edit Listing
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-2xl p-8">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                        <p class="font-semibold mb-2">Please fix the following:</p>
                        <ul class="list-disc ml-5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <li class="text-sm"><?php echo e($error); ?></li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <form method="POST" action="<?php echo e(route('landlord.rentals.update', $rental)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="text-sm font-semibold text-gray-700">House Number (optional)</label>
                            <input name="housenumber" value="<?php echo e(old('housenumber', $rental->housenumber)); ?>"
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. 14">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Street *</label>
                            <input name="street" value="<?php echo e(old('street', $rental->street)); ?>" required
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. The Green">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">County *</label>
                            <input name="county" value="<?php echo e(old('county', $rental->county)); ?>" required
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. Dublin">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Postcode (optional)</label>
                            <input name="postcode" value="<?php echo e(old('postcode', $rental->postcode)); ?>"
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. D12XY89">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Measurement (optional)</label>
                            <input name="measurement" value="<?php echo e(old('measurement', $rental->measurement)); ?>"
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. 15sqm">
                        </div>

                        
                        <div>
                            <label class="text-sm font-semibold text-slate-700">House Type</label>
                            <select name="housetype" class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="any" <?php if(old('housetype', $rental->housetype) === 'any'): echo 'selected'; endif; ?>>Any</option>
                                <option value="single_private" <?php if(old('housetype', $rental->housetype) === 'single_private'): echo 'selected'; endif; ?>>
                                    Single room in private home (e.g. in a family home)
                                </option>
                                <option value="private_shared" <?php if(old('housetype', $rental->housetype) === 'private_shared'): echo 'selected'; endif; ?>>
                                    Private room in shared house (e.g. shared with other tenants)
                                </option>
                                <option value="whole_property_group" <?php if(old('housetype', $rental->housetype) === 'whole_property_group'): echo 'selected'; endif; ?>>
                                    Whole property (group application only)
                                </option>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['housetype'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Accommodation Type</label>
                            <select name="accommodation_type"
                                    class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="" <?php if(old('accommodation_type', $rental->accommodation_type) === null): echo 'selected'; endif; ?>>Select</option>
                                <option value="house" <?php if(old('accommodation_type', $rental->accommodation_type) === 'house'): echo 'selected'; endif; ?>>House</option>
                                <option value="apartment" <?php if(old('accommodation_type', $rental->accommodation_type) === 'apartment'): echo 'selected'; endif; ?>>Apartment</option>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['accommodation_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label for="application_type" class="text-sm font-semibold text-slate-700">Application Type</label>
                            <select
                                id="application_type"
                                name="application_type"
                                class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                                <option value="" <?php if(old('application_type', $rental->application_type) === null): echo 'selected'; endif; ?>>Select</option>
                                <option value="single" <?php if(old('application_type', $rental->application_type) === 'single'): echo 'selected'; endif; ?>>Single Applications</option>
                                <option value="group"  <?php if(old('application_type', $rental->application_type) === 'group'): echo 'selected'; endif; ?>>Group Applications</option>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['application_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div>
                            <label class="text-sm font-semibold text-slate-700">Nights per Week</label>
                            <input
                                type="number"
                                name="nightsperweek"
                                value="<?php echo e(old('nightsperweek', $rental->nightsperweek)); ?>"
                                min="0"
                                max="7"
                                step="1"
                                class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                placeholder="e.g. 5"
                            />
                            <p class="mt-1 text-xs text-slate-500">Enter a number from 0 to 7</p>
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Rent per month (€) *</label>
                            <input name="rentpermonth" type="number" step="0.01" min="0" required
                                   value="<?php echo e(old('rentpermonth', $rental->rentpermonth)); ?>"
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. 850">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Status *</label>
                            <select name="status" required
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="available" <?php echo e(old('status', $rental->status) === 'available' ? 'selected' : ''); ?>>Available</option>
                                <option value="occupied"  <?php echo e(old('status', $rental->status) === 'occupied'  ? 'selected' : ''); ?>>Occupied</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4 md:col-span-2">
                            <div>
                                <label class="text-sm font-semibold text-gray-700">Available from *</label>
                                <input name="availablefrom" type="date" required
                                       value="<?php echo e(old('availablefrom', optional($rental->availablefrom)->format('Y-m-d'))); ?>"
                                       class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-gray-700">Available until *</label>
                                <input name="availableuntil" type="date" required
                                       value="<?php echo e(old('availableuntil', optional($rental->availableuntil)->format('Y-m-d'))); ?>"
                                       class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    
                    <div class="mt-6">
                        <label class="text-sm font-semibold text-gray-700">Description *</label>
                        <textarea name="description" rows="5" required
                                  class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Describe the listing..."><?php echo e(old('description', $rental->description)); ?></textarea>
                    </div>

                    <div class="flex items-center justify-between pt-4">
                        <a href="<?php echo e(route('dashboard')); ?>"
                           class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                            ← Back to dashboard
                        </a>

                        <button type="submit"
                                class="px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/landlord/rentals/edit.blade.php ENDPATH**/ ?>