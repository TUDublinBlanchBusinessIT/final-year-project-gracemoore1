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

<div class="p-6 bg-white shadow rounded-lg max-w-5xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-900 mb-6">Landlord Profile</h2>

    
    <div class="space-y-2 text-gray-800">
        <p><strong>Firstname:</strong> <?php echo e($landlord->firstname); ?></p>
        <p><strong>Surname:</strong> <?php echo e($landlord->surname); ?></p>
        <p><strong>Email:</strong> <?php echo e($landlord->email); ?></p>
        <p><strong>Phone:</strong> <?php echo e($landlord->phone ?? 'N/A'); ?></p>
        <p><strong>Verified:</strong> <?php echo e($landlord->verified == 1 ? 'Yes' : 'No'); ?></p>
    </div>

    <hr class="my-6">

    
    
    
    <h3 class="text-xl font-semibold text-slate-900 mb-4">Current Listings</h3>

    <?php
        $currentListings = \App\Models\LandlordRental::where('landlordid', $landlord->id)->get();
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentListings->count() == 0): ?>
        <p class="text-gray-500">No current listings.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $currentListings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php
                    $images = json_decode($rental->images ?? '[]', true) ?? [];
                    $imgCount = count($images);
                ?>

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                    
                    <div class="relative" data-carousel data-key="landlord-<?php echo e($rental->id); ?>" data-count="<?php echo e($imgCount); ?>">
                        <div class="overflow-hidden rounded-lg">
                            <div id="track-landlord-<?php echo e($rental->id); ?>" class="flex transition-transform duration-300 ease-out">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="w-full shrink-0">
                                        <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-48 object-cover rounded-lg" />
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="w-full h-48 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                                        No image
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
                            <button onclick="prevImage('landlord', <?php echo e($rental->id); ?>)"
                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/90 text-slate-700 px-2 py-1 rounded-full shadow">
                                ‹
                            </button>

                            <button onclick="nextImage('landlord', <?php echo e($rental->id); ?>)"
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/90 text-slate-700 px-2 py-1 rounded-full shadow">
                                ›
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="mt-3">
                        <div class="font-semibold text-slate-900">
                            <?php echo e($rental->housenumber ? $rental->housenumber . ' ' : ''); ?>

                            <?php echo e($rental->street); ?>, <?php echo e($rental->county); ?>

                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rental->housetype): ?>
                            <div class="text-sm text-slate-700 mt-1">
                                <?php echo e($rental->housetype); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rental->nightsperweek): ?>
                            <div class="text-sm text-slate-700">
                                <?php echo e($rental->nightsperweek); ?> nights / week
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="text-sm text-slate-600 mt-1">
                            Available: <?php echo e($rental->availablefrom); ?> → <?php echo e($rental->availableuntil); ?>

                        </div>

                        <div class="text-base text-slate-800 font-bold mt-2">
                            €<?php echo e(number_format($rental->rentpermonth, 2)); ?> / month
                        </div>
                    </div>

                    
                    <a href="<?php echo e(route('admin.listing.view', $rental->id)); ?>">
                        <button class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                            View Details
                        </button>
                    </a>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    
    <div class="mt-8 flex gap-4">
        <form method="POST" action="<?php echo e(route('admin.accounts.suspend', ['type'=>'landlord','id'=>$landlord->id])); ?>">
            <?php echo csrf_field(); ?>
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Suspend Account</button>
        </form>

        <form method="POST" action="<?php echo e(route('admin.accounts.reactivate', ['type'=>'landlord','id'=>$landlord->id])); ?>">
            <?php echo csrf_field(); ?>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Reactivate Account</button>
        </form>
    </div>

</div>


<script>
    const carouselState = {};

    function updateCarousel(view, id) {
        const key = `${view}-${id}`;
        const track = document.getElementById(`track-${view}-${id}`);
        if (!track) return;
        const state = carouselState[key] || { index: 0, count: track.children.length };
        track.style.transform = `translateX(-${state.index * 100}%)`;
    }

    function nextImage(view, id) {
        const key = `${view}-${id}`;
        const track = document.getElementById(`track-${view}-${id}`);
        if (!track) return;
        const count = track.children.length;
        if (!carouselState[key]) carouselState[key] = { index: 0, count };
        carouselState[key].index = (carouselState[key].index + 1) % count;
        updateCarousel(view, id);
    }

    function prevImage(view, id) {
        const key = `${view}-${id}`;
        const track = document.getElementById(`track-${view}-${id}`);
        if (!track) return;
        const count = track.children.length;
        if (!carouselState[key]) carouselState[key] = { index: 0, count };
        carouselState[key].index = carouselState[key].index === 0 ? count - 1 : carouselState[key].index - 1;
        updateCarousel(view, id);
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("[data-carousel]").forEach(carousel => {
            const key = carousel.dataset.key;
            const [view, id] = key.split("-");
            carouselState[key] = { index: 0, count: carousel.dataset.count };
            updateCarousel(view, id);
        });
    });
</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df)): ?>
<?php $attributes = $__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df; ?>
<?php unset($__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc98b3e35bd8155af0bdb37c6a10156df)): ?>
<?php $component = $__componentOriginalc98b3e35bd8155af0bdb37c6a10156df; ?>
<?php unset($__componentOriginalc98b3e35bd8155af0bdb37c6a10156df); ?>
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/view-landlord.blade.php ENDPATH**/ ?>