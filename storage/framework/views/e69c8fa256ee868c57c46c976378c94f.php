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
            Home
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="pb-28">

        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">
                <h1 class="text-3xl font-bold text-blue-600 mb-10">
                    Welcome back, <?php echo e(Auth::user()->name); ?>!
                </h1>

                <p class="text-gray-700 text-lg">
                    This is your dashboard.
                    You can manage your account, update your profile, and access new features as they are added.
                </p>
            </div>
        </div>

        
        <?php
            $landlordId = \App\Models\Landlord::where('email', Auth::user()->email)->value('id');
            $rentals = $landlordId
                ? \App\Models\LandlordRental::where('landlordid', $landlordId)->latest('id')->get()
                : collect();
        ?>

        <div class="mt-10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-slate-900">Your Listings</h2>

                <a href="<?php echo e(route('landlord.rentals.create')); ?>"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    + Add Listing
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $rentals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

                    <?php
                        $imageList = is_array($rental->images) ? $rental->images : json_decode($rental->images, true);
                        $firstImage = $imageList[0] ?? null;
                    ?>

                    <?php
                        $acceptedApplication = \App\Models\Application::with('student')
                            ->where('rentalid', $rental->id)
                            ->where('status', 'accepted')
                            ->first();
                    ?>

                    <?php
                        $endDate = $rental->availableuntil ? \Carbon\Carbon::parse($rental->availableuntil) : null;
                        $daysUntilEnd = $endDate ? now()->diffInDays($endDate, false) : null;
                    ?>                    

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition">

                        
                        <div class="w-full h-56 bg-slate-100">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($firstImage): ?>
                                <img src="<?php echo e(asset('storage/' . $firstImage)); ?>"
                                     alt="Rental image"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                                    No image uploaded
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        
                        <div class="p-5">
                            <div class="font-semibold text-slate-900 text-lg">
                                <?php echo e($rental->housenumber ? $rental->housenumber . ' ' : ''); ?>

                                <?php echo e($rental->street); ?>, <?php echo e($rental->county); ?>

                            </div>

                            <div class="mt-2 text-sm text-slate-600">
                                €<?php echo e(number_format($rental->rentpermonth ?? 0, 2)); ?> / month
                            </div>

                            <div class="mt-1 text-xs text-slate-500">
                                Available: <?php echo e($rental->availablefrom); ?> → <?php echo e($rental->availableuntil); ?>

                            </div>

                            <div class="mt-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs border
                                    <?php echo e($rental->status === 'available'
                                        ? 'bg-green-50 text-green-700 border-green-200'
                                        : ($rental->status === 'let_agreed'
                                            ? 'bg-blue-50 text-blue-700 border-blue-200'
                                            : 'bg-slate-100 text-slate-700 border-slate-200')); ?>">
                                    <?php echo e($rental->status === 'let_agreed' ? 'Let Agreed' : ucfirst($rental->status ?? 'unknown')); ?>

                                </span>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rental->status === 'let_agreed' && $acceptedApplication && $acceptedApplication->student): ?>
                                <div class="mt-2 text-sm text-slate-700">
                                    <span class="font-medium">Accepted Student:</span>
                                    <?php echo e($acceptedApplication->student->firstname); ?> <?php echo e($acceptedApplication->student->surname); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rental->status === 'let_agreed' && $endDate): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($daysUntilEnd < 0): ?>
                                    <div class="mt-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                        This agreement has ended. Please update the dates or make the listing available for new tenants.
                                    </div>
                                <?php elseif($daysUntilEnd <= 14): ?>
                                    <div class="mt-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                                        This listing is ending soon. Please update the current agreement or add new dates for new tenants.
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>                            

                            <p class="mt-3 text-sm text-slate-600 line-clamp-2">
                                <?php echo e(\Illuminate\Support\Str::limit($rental->description, 120)); ?>

                            </p>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="<?php echo e(route('landlord.rentals.edit', $rental)); ?>"
                                   class="px-4 py-2 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="<?php echo e(route('landlord.rentals.destroy', $rental)); ?>"
                                      onsubmit="return confirm('Delete this listing?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl bg-red-50 text-red-600 font-semibold hover:bg-red-100 transition">
                                        Delete
                                    </button>
                                </form>

                                <a href="<?php echo e(route('landlord.applications.index', $rental->id)); ?>"
                                   class="px-4 py-2 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                                    View Applications
                                </a>
                            </div>
                        </div>
                    </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                    <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-10 text-center md:col-span-2">
                        <div class="text-slate-700 font-semibold text-lg">
                            No listings yet
                        </div>

                        <div class="text-slate-500 text-sm mt-1">
                            Add your first listing to get started.
                        </div>

                        <a href="<?php echo e(route('landlord.rentals.create')); ?>"
                           class="inline-flex items-center justify-center mt-5 w-14 h-14 rounded-full bg-blue-600 text-white text-3xl font-bold hover:bg-blue-700 transition">
                            +
                        </a>
                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/landlord/dashboard.blade.php ENDPATH**/ ?>