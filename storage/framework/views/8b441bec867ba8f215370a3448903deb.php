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
            <p class="text-lg font-bold uppercase tracking-[0.16em] text-blue-700">
                Profile
            </p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-5xl mx-auto px-4 py-8">

        
        <nav class="mt-3 border-b border-slate-200">
            <ul class="flex gap-6 text-sm">
                <li>
                    <a href="<?php echo e(route('student.profile.new.applications')); ?>"
                       class="<?php echo e(request()->routeIs('student.profile.new.applications')
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Applications
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('student.profile.new.account')); ?>"
                       class="<?php echo e(request()->routeIs('student.profile.new.account')
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300'); ?>">
                        Account details
                    </a>
                </li>
            </ul>
        </nav>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="mt-4 mb-4 p-3 bg-green-100 text-green-800 rounded-lg border border-green-300">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="mt-6 space-y-10">

            
            <section class="applications-pending">
                <h3 class="mt-10 mb-5 text-base font-semibold text-blue-600">Pending Applications</h3>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pending->isEmpty()): ?>
                    <p class="text-gray-500 mt-1">No pending applications.</p>
                <?php else: ?>

                    
                    <div class="mt-4 flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php $r = $app->rental; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$r): ?> <?php continue; ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                                $labelMap = [
                                    'any' => 'Any',
                                    'single_private' => 'Single room in private home',
                                    'private_shared' => 'Private room in shared house',
                                    'whole_property_group' => 'Whole property (group application only)',
                                ];
                            ?>

                            <div class="min-w-[390px] bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                                
                                <div class="relative" data-carousel data-key="app-mobile-<?php echo e($r->id); ?>" data-count="<?php echo e($imgCount); ?>">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-app-mobile-<?php echo e($r->id); ?>" class="flex transition-transform duration-300 ease-out">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <div class="w-full shrink-0">
                                                    <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-40 object-cover rounded-lg" alt="Listing image" />
                                                </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <div class="w-full h-40 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                                                    No image
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
                                        <button onclick="prevImage('app-mobile', <?php echo e($r->id); ?>)"
                                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>
                                        <button onclick="nextImage('app-mobile', <?php echo e($r->id); ?>)"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <a href="<?php echo e(route('listing.show', $r->id)); ?>" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        <?php echo e($r->housenumber ? $r->housenumber . ' ' : ''); ?><?php echo e($r->street); ?>, <?php echo e($r->county); ?>

                                    </div>

                                    <p class="text-sm text-slate-600">
                                        <?php echo e($labelMap[trim($r->housetype ?? '')] ?? trim($r->housetype ?? '')); ?>

                                    </p>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->nightsperweek): ?>
                                        <div class="text-sm text-slate-700">
                                            <?php echo e($r->nightsperweek); ?> nights / week
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="text-sm text-slate-600 mt-1">
                                        Available: <?php echo e($r->availablefrom); ?> → <?php echo e($r->availableuntil); ?>

                                    </div>

                                    <div class="text-base text-slate-800 font-bold mt-2">
                                        €<?php echo e(number_format((float)$r->rentpermonth, 2)); ?> / month
                                    </div>
                                </a>

                                
                                <div class="mt-3 flex items-center justify-between">

                                    
                                    <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>

                                    <form action="<?php echo e(route('applications.withdraw', $app->id)); ?>"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this application? This cannot be undone.');">

                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->applicationtype === 'group'): ?>
                                            <button class="px-3 py-1 rounded text-xs bg-red-100 text-red-700 hover:bg-red-200">
                                                Delete Group Application
                                            </button>
                                        <?php else: ?>
                                            <button class="px-3 py-1 rounded text-xs bg-red-100 text-red-700 hover:bg-red-200">
                                                Withdraw
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </form>

                                </div>

                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    
                    <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php $r = $app->rental; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$r): ?> <?php continue; ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                            ?>

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                                
                                <div class="relative" data-carousel data-key="app-desktop-<?php echo e($r->id); ?>" data-count="<?php echo e($imgCount); ?>">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-app-desktop-<?php echo e($r->id); ?>" class="flex transition-transform duration-300 ease-out">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <div class="w-full shrink-0">
                                                    <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-48 object-cover rounded-lg" alt="Listing image"/>
                                                </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <div class="w-full h-48 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                                                    No image
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
                                        <button onclick="prevImage('app-desktop', <?php echo e($r->id); ?>)"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>
                                        <button onclick="nextImage('app-desktop', <?php echo e($r->id); ?>)"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <a href="<?php echo e(route('listing.show', $r->id)); ?>" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        <?php echo e($r->housenumber ? $r->housenumber . ' ' : ''); ?><?php echo e($r->street); ?>, <?php echo e($r->county); ?>

                                    </div>
                                    <p class="text-sm text-slate-600">
                                        <?php echo e($labelMap[trim($r->housetype ?? '')] ?? trim($r->housetype ?? '')); ?>

                                    </p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->nightsperweek): ?>
                                        <div class="text-sm text-slate-700"><?php echo e($r->nightsperweek); ?> nights / week</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="text-sm text-slate-600 mt-1">
                                        Available: <?php echo e($r->availablefrom); ?> → <?php echo e($r->availableuntil); ?>

                                    </div>

                                    <div class="text-base text-slate-800 font-bold mt-2">
                                        €<?php echo e(number_format((float)$r->rentpermonth, 2)); ?> / month
                                    </div>
                                </a>

                                
                                <div class="mt-3 flex items-center justify-between">

                                    <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>

                                    <form action="<?php echo e(route('applications.withdraw', $app->id)); ?>"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this application? This cannot be undone.');">

                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($app->applicationtype === 'group'): ?>
                                            <button class="px-3 py-1 rounded text-xs bg-red-100 text-red-700 hover:bg-red-200">
                                                Delete Group Application
                                            </button>
                                        <?php else: ?>
                                            <button class="px-3 py-1 rounded text-xs bg-red-100 text-red-700 hover:bg-red-200">
                                                Withdraw
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </form>

                                </div>

                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </section>

            
            <section class="applications-accepted">
                <h3 class="text-base font-semibold text-green-600">Accepted Applications</h3>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($accepted->isEmpty()): ?>
                    <p class="text-gray-500 mt-1">No accepted applications.</p>
                <?php else: ?>

                    
                    <div class="mt-4 flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $accepted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php $r = $app->rental; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$r): ?> <?php continue; ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                                $labelMap = [
                                    'any' => 'Any',
                                    'single_private' => 'Single room in private home',
                                    'private_shared' => 'Private room in shared house',
                                    'whole_property_group' => 'Whole property (group application only)',
                                ];
                            ?>

                            <div class="min-w-[390px] bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                                
                                <div class="relative" data-carousel data-key="acc-mobile-<?php echo e($r->id); ?>" data-count="<?php echo e($imgCount); ?>">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-acc-mobile-<?php echo e($r->id); ?>" class="flex transition-transform duration-300 ease-out">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <div class="w-full shrink-0">
                                                    <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-40 object-cover rounded-lg" />
                                                </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <div class="w-full h-40 bg-slate-100 flex justify-center items-center rounded-lg text-slate-500">No image</div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
                                        <button onclick="prevImage('acc-mobile',<?php echo e($r->id); ?>)"
                                                class="absolute left-2 top-1/2 bg-white/80 px-2 py-1 rounded-full shadow">‹</button>
                                        <button onclick="nextImage('acc-mobile',<?php echo e($r->id); ?>)"
                                                class="absolute right-2 top-1/2 bg-white/80 px-2 py-1 rounded-full shadow">›</button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <a href="<?php echo e(route('listing.show',$r->id)); ?>" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        <?php echo e($r->housenumber ? $r->housenumber.' ' : ''); ?><?php echo e($r->street); ?>, <?php echo e($r->county); ?>

                                    </div>
                                    <p class="text-sm text-slate-600"><?php echo e($labelMap[$r->housetype] ?? $r->housetype); ?></p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->nightsperweek): ?>
                                        <div class="text-sm text-slate-700"><?php echo e($r->nightsperweek); ?> nights / week</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="text-sm text-slate-600 mt-1">
                                        Available: <?php echo e($r->availablefrom); ?> → <?php echo e($r->availableuntil); ?>

                                    </div>
                                    <div class="text-base text-slate-800 font-bold mt-2">
                                        €<?php echo e(number_format($r->rentpermonth, 2)); ?> / month
                                    </div>
                                </a>

                                <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-green-100 text-green-800">Accepted</div>

                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    
                    <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $accepted; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php $r = $app->rental; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$r): ?> <?php continue; ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                            ?>

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                                <div class="relative" data-carousel data-key="acc-desktop-<?php echo e($r->id); ?>" data-count="<?php echo e($imgCount); ?>">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-acc-desktop-<?php echo e($r->id); ?>" class="flex transition-transform duration-300 ease-out">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <div class="w-full shrink-0">
                                                    <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-48 object-cover rounded-lg" />
                                                </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <div class="w-full h-48 bg-slate-100 flex justify-center items-center rounded-lg text-slate-500">No image</div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
                                        <button onclick="prevImage('acc-desktop',<?php echo e($r->id); ?>)"
                                                class="absolute left-2 top-1/2 bg-white/80 px-2 py-1 rounded-full shadow">‹</button>
                                        <button onclick="nextImage('acc-desktop',<?php echo e($r->id); ?>)"
                                                class="absolute right-2 top-1/2 bg-white/80 px-2 py-1 rounded-full shadow">›</button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <a href="<?php echo e(route('listing.show',$r->id)); ?>" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        <?php echo e($r->housenumber ? $r->housenumber.' ' : ''); ?><?php echo e($r->street); ?>, <?php echo e($r->county); ?>

                                    </div>
                                    <p class="text-sm text-slate-600"><?php echo e($labelMap[$r->housetype] ?? $r->housetype); ?></p>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->nightsperweek): ?>
                                        <div class="text-sm text-slate-700"><?php echo e($r->nightsperweek); ?> nights / week</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="text-sm text-slate-600 mt-1">
                                        Available: <?php echo e($r->availablefrom); ?> → <?php echo e($r->availableuntil); ?>

                                    </div>

                                    <div class="text-base text-slate-800 font-bold mt-2">
                                        €<?php echo e(number_format($r->rentpermonth, 2)); ?> / month
                                    </div>
                                </a>

                                <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-green-100 text-green-800">Accepted</div>

                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </section>

            
            <section class="applications-rejected">
                <h3 class="text-base font-semibold text-red-600">Rejected Applications</h3>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rejected->isEmpty()): ?>
                    <p class="text-gray-500 mt-1">No rejected applications.</p>
                <?php else: ?>

                    
                    <div class="mt-4 flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $rejected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php $r = $app->rental; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$r): ?> <?php continue; ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                                $labelMap = [
                                    'any' => 'Any',
                                    'single_private' => 'Single room in private home',
                                    'private_shared' => 'Private room in shared house',
                                    'whole_property_group' => 'Whole property (group application only)',
                                ];
                            ?>

                            <div class="min-w-[390px] bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                                <div class="relative" data-carousel data-key="rej-mobile-<?php echo e($r->id); ?>" data-count="<?php echo e($imgCount); ?>">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-rej-mobile-<?php echo e($r->id); ?>" class="flex transition-transform duration-300 ease-out">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <div class="w-full shrink-0">
                                                    <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-40 object-cover rounded-lg"/>
                                                </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <div class="w-full h-40 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">No image</div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
                                        <button onclick="prevImage('rej-mobile',<?php echo e($r->id); ?>)"
                                                class="absolute left-2 top-1/2 bg-white/80 px-2 py-1 rounded-full shadow">‹</button>
                                        <button onclick="nextImage('rej-mobile',<?php echo e($r->id); ?>)"
                                                class="absolute right-2 top-1/2 bg-white/80 px-2 py-1 rounded-full shadow">›</button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <a href="<?php echo e(route('listing.show',$r->id)); ?>" class="block mt-3">
                                    <div class="font-semibold text-slate-900">
                                        <?php echo e($r->housenumber ? $r->housenumber.' ' : ''); ?><?php echo e($r->street); ?>, <?php echo e($r->county); ?>

                                    </div>
                                    <p class="text-sm text-slate-600"><?php echo e($labelMap[$r->housetype] ?? $r->housetype); ?></p>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->nightsperweek): ?>
                                        <div class="text-sm text-slate-700"><?php echo e($r->nightsperweek); ?> nights / week</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="text-sm text-slate-600 mt-1">
                                        Available: <?php echo e($r->availablefrom); ?> → <?php echo e($r->availableuntil); ?>

                                    </div>

                                    <div class="text-base text-slate-800 font-bold mt-2">
                                        €<?php echo e(number_format($r->rentpermonth, 2)); ?> / month
                                    </div>
                                </a>

                                <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-red-100 text-red-800">Rejected</div>

                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                    
                    <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $rejected; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php $r = $app->rental; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$r): ?> <?php continue; ?> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php
                                $images = json_decode($r->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                            ?>

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                                <div class="relative" data-carousel data-key="rej-desktop-<?php echo e($r->id); ?>" data-count="<?php echo e($imgCount); ?>">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-rej-desktop-<?php echo e($r->id); ?>" class="flex transition-transform duration-300 ease-out">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                                <div class="w-full shrink-0">
                                                    <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-48 object-cover rounded-lg"/>
                                                </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                <div class="w-full h-48 bg-slate-100 text-slate-500 rounded-lg flex items-center justify-center">No image</div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
                                        <button onclick="prevImage('rej-desktop',<?php echo e($r->id); ?>)"
                                                class="absolute left-2 top-1/2 bg-white/80 px-2 py-1 rounded-full shadow">‹</button>
                                        <button onclick="nextImage('rej-desktop',<?php echo e($r->id); ?>)"
                                                class="absolute right-2 top-1/2 bg-white/80 px-2 py-1 rounded-full shadow">›</button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <a href="<?php echo e(route('listing.show',$r->id)); ?>" class="block mt-3">
                                    <div class="font-semibold text-slate-900"><?php echo e($r->housenumber ? $r->housenumber.' ' : ''); ?><?php echo e($r->street); ?>,<?php echo e($r->county); ?></div>
                                    <p class="text-sm text-slate-600"><?php echo e($labelMap[$r->housetype] ?? $r->housetype); ?></p>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->nightsperweek): ?>
                                        <div class="text-sm text-slate-700"><?php echo e($r->nightsperweek); ?> nights/week</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div class="text-sm text-slate-600 mt-1">
                                        Available: <?php echo e($r->availablefrom); ?> → <?php echo e($r->availableuntil); ?>

                                    </div>

                                    <div class="text-base text-slate-800 font-bold mt-2">
                                        €<?php echo e(number_format($r->rentpermonth, 2)); ?> / month
                                    </div>
                                </a>

                                <div class="mt-3 inline-block px-2 py-1 rounded text-xs bg-red-100 text-red-800">Rejected</div>

                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </section>

        </div>
    </div>

    
    <script>
        const carouselState = {};

        function appStateKey(view, id) { return `${view}-${id}` }

        function updateAppCarousel(view, id) {
            const key = appStateKey(view,id);
            const track = document.getElementById(`track-${view}-${id}`);
            if (!track) return;

            const s = carouselState[key] || { index:0, count:track.children.length };
            track.style.transform = `translateX(-${s.index * 100}%)`;

            Array.from(track.children).forEach(c => c.style.width = "100%");
        }

        function nextImage(view, id) {
            const key = appStateKey(view,id);
            const wrap = document.querySelector(`[data-key="${view}-${id}"]`);
            const count = parseInt(wrap?.dataset.count || 0);

            if (!carouselState[key]) carouselState[key] = { index:0, count };
            if (count <= 1) return;

            carouselState[key].index = (carouselState[key].index + 1) % count;
            updateAppCarousel(view,id);
        }

        function prevImage(view, id) {
            const key = appStateKey(view,id);
            const wrap = document.querySelector(`[data-key="${view}-${id}"]`);
            const count = parseInt(wrap?.dataset.count || 0);

            if (!carouselState[key]) carouselState[key] = { index:0, count };
            if (count <= 1) return;

            carouselState[key].index =
                carouselState[key].index === 0 ? count - 1 : carouselState[key].index - 1;

            updateAppCarousel(view,id);
        }

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("[data-carousel]").forEach(c => {
                const key = c.dataset.key;
                const count = parseInt(c.dataset.count || 0);
                carouselState[key] = { index:0, count };

                const parts = key.split("-");
                const view = parts[0] + "-" + parts[1];
                const id = parts[2];

                updateAppCarousel(view,id);
            });
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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/student/profile-applications.blade.php ENDPATH**/ ?>