<?php
    $images = json_decode($rental->images ?? '[]', true) ?? [];
    $imgCount = count($images);
?>

<div class="min-w-[420px] bg-white rounded-xl border
    <?php echo e($rental->is_premium ? 'border-yellow-400 ring-1 ring-yellow-300' : 'border-slate-200'); ?>

    shadow-sm p-4 hover:shadow-md transition">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rental->is_premium): ?>
        <div class="mb-2 text-xs font-bold text-yellow-700 uppercase tracking-wide">
            Premium
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="relative" data-carousel
        data-key="<?php echo e($trackPrefix); ?>-<?php echo e($rental->id); ?>"
        data-count="<?php echo e($imgCount); ?>">

        <div class="overflow-hidden rounded-lg">
            <div id="track-<?php echo e($trackPrefix); ?>-<?php echo e($rental->id); ?>"
                class="flex transition-transform duration-300 ease-out">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="w-full shrink-0">
                        <img src="<?php echo e(asset('storage/' . $img)); ?>"
                            class="w-full h-48 object-cover rounded-lg" />
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="w-full h-48 bg-slate-100 flex items-center justify-center text-slate-500">
                        No image
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
            <button type="button"
                onclick="prevImage('<?php echo e($trackPrefix); ?>', <?php echo e($rental->id); ?>)"
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">
                ‹
            </button>

            <button type="button"
                onclick="nextImage('<?php echo e($trackPrefix); ?>', <?php echo e($rental->id); ?>)"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">
                ›
            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <a href="<?php echo e(route('listing.show', $rental->id)); ?>" class="block mt-3">
        <div class="font-semibold text-slate-900">
            <?php echo e($rental->housenumber ? $rental->housenumber . ' ' : ''); ?>

            <?php echo e($rental->street); ?>, <?php echo e($rental->county); ?>

        </div>

        <p class="text-sm text-slate-600">
            <?php echo e([
                'any' => 'Any',
                'single_private' => 'Single room in private home',
                'private_shared' => 'Private room in shared house',
                'whole_property_group' => 'Whole property (group application only)',
            ][trim($rental->housetype ?? '')] ?? trim($rental->housetype ?? '')); ?>

        </p>

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
    </a>
</div><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/partials/listing-card.blade.php ENDPATH**/ ?>