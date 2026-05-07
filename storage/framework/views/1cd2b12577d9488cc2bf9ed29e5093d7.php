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


<div class="p-6 max-w-4xl mx-auto bg-white rounded-xl shadow">

    <h2 class="text-2xl font-bold text-gray-900 mb-4">Listing Details</h2>

    <?php
        // images stored as JSON array of relative paths like "rentals/abc.jpg"
        $images   = json_decode($rental->images ?? '[]', true) ?? [];
        $imgCount = count($images);
    ?>

    
    
    
    <div class="relative mb-3" data-carousel data-key="detail-<?php echo e($rental->id); ?>" data-count="<?php echo e($imgCount); ?>">
        <div class="overflow-hidden rounded-lg">
            <div id="track-detail-<?php echo e($rental->id); ?>" class="flex transition-transform duration-300 ease-out">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="w-full shrink-0">
                        <img
                            src="<?php echo e(asset('storage/' . ltrim($img, '/'))); ?>"
                            alt="Listing image"
                            class="w-full h-64 object-cover rounded-lg" />
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="w-full h-64 bg-slate-200 rounded-lg flex items-center justify-center text-slate-500">
                        No Image
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
            <button
                onclick="prevImage('detail', <?php echo e($rental->id); ?>)"
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-3 py-1 rounded-full shadow"
                aria-label="Previous image">‹</button>

            <button
                onclick="nextImage('detail', <?php echo e($rental->id); ?>)"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-3 py-1 rounded-full shadow"
                aria-label="Next image">›</button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="mb-6">
            <span class="inline-flex items-center gap-1 rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">
            Listing ID: <?php echo e($rental->id); ?>

        </span>
    </div>

    
    
    
    <div class="space-y-3 text-gray-800">

        <p class="text-xl font-semibold">
            <?php echo e($rental->housenumber); ?> <?php echo e($rental->street); ?>, <?php echo e($rental->county); ?>

        </p>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rental->housetype): ?>
            <p><strong>House Type:</strong> <?php echo e($rental->housetype); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rental->nightsperweek): ?>
            <p><strong>Nights Per Week:</strong> <?php echo e($rental->nightsperweek); ?></p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <p><strong>Rent Per Month:</strong> €<?php echo e(number_format($rental->rentpermonth, 2)); ?></p>

        <p><strong>Available From:</strong> <?php echo e($rental->availablefrom); ?></p>
        <p><strong>Available Until:</strong> <?php echo e($rental->availableuntil); ?></p>

        <p><strong>Description:</strong></p>
        <p class="whitespace-pre-line"><?php echo e($rental->description); ?></p>

        
        <div class="pt-4 text-center">
            <a href="<?php echo e(route('admin.accounts.landlords')); ?>" class="text-slate-500 hover:text-slate-700 text-sm">
                &lt; Back to Landlords
            </a>
        </div>
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

        carouselState[key].index =
            carouselState[key].index === 0 ? count - 1 : carouselState[key].index - 1;

        updateCarousel(view, id);
    }

    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll("[data-carousel]").forEach(carousel => {
            const key = carousel.dataset.key;
            const [view, id] = key.split("-");
            carouselState[key] = { index: 0, count: carousel.dataset.count ?? 0 };
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/view-listing.blade.php ENDPATH**/ ?>