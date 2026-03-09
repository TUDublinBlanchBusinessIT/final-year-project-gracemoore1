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

    
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-start justify-start">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">RentConnect</div>
                <div class="mt-1 font-semibold text-gray-800">Dashboard</div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <?php
        /** @var \App\Models\Student|null $student */
        $student = \App\Models\Student::find(session('student_id'));

        $collegeToCounty = [
            'TCD' => 'Dublin',
            'UCD' => 'Dublin',
            'UL'  => 'Limerick',
            'NUIG'=> 'Galway',
            'TUD' => 'Dublin',
            'UCC' => 'Cork',
            'Maynooth' => 'Kildare',
            'CIT' => 'Cork',
            'RCSI' => 'Dublin',
        ];

        // Fixed order, Dublin first:
        $counties = ['Dublin', 'Galway', 'Limerick', 'Cork', 'Kildare'];
    ?>

    <div>
        
        <h1 class="text-2xl font-bold text-slate-900 mb-8">
            Welcome back, <?php echo e($student->firstname ?? $student->name ?? 'Student'); ?>!
        </h1>

        
        
        
        <form id="searchForm" method="GET" action="<?php echo e(route('student.dashboard')); ?>" class="flex items-center bg-white border border-slate-300 rounded-xl px-4 py-3 shadow-sm">
            <svg class="h-5 w-5 text-slate-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35M10 4a6 6 0 1 0 0 12 6 6 0 0 0 0-12z" />
            </svg>

            <input type="text"
                   name="q"
                   value="<?php echo e(request('q')); ?>"
                   placeholder="Search listings..."
                   class="ml-3 w-full focus:ring-0 border-none focus:outline-none text-slate-800" />

            
            <input type="hidden" name="county"              value="<?php echo e(request('county')); ?>">
            <input type="hidden" name="housetype"           value="<?php echo e(request('housetype')); ?>">
            <input type="hidden" name="accommodation_type"  value="<?php echo e(request('accommodation_type')); ?>">
            <input type="hidden" name="application_type"    value="<?php echo e(request('application_type')); ?>">
            <input type="hidden" name="from"                value="<?php echo e(request('from')); ?>">
            <input type="hidden" name="until"               value="<?php echo e(request('until')); ?>">
            <input type="hidden" name="min_rent"            value="<?php echo e(request('min_rent')); ?>">
            <input type="hidden" name="max_rent"            value="<?php echo e(request('max_rent')); ?>">
            <input type="hidden" name="nights_bucket"       value="<?php echo e(request('nights_bucket','any')); ?>">

            <button type="submit" class="ml-3 text-slate-600 hover:text-blue-600" title="Search" aria-label="Search">
                Search
            </button>

            <button id="filterToggle" type="button" class="ml-3 text-slate-600 hover:text-blue-600" title="Filters" aria-label="Filters">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 6h18M6 12h12M10 18h8" />
                </svg>
            </button>
        </form>

        
        
        
        <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $collegeToCounty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $college => $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button
                    type="button"
                    onclick="filterCounty('<?php echo e($county); ?>')"
                    class="shrink-0 px-3 py-2 rounded-full border border-blue-500 text-blue-600 bg-white text-sm font-semibold hover:bg-blue-50">
                    <?php echo e($college); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <a href="<?php echo e(route('student.dashboard')); ?>"
               class="shrink-0 px-3 py-2 rounded-full border border-slate-300 text-slate-700 bg-white text-sm font-semibold hover:bg-slate-50">
                Clear
            </a>
        </div>

        
        
        
        <div id="filterDrawer"
             class="hidden bg-white border border-slate-300 rounded-xl shadow-sm px-6 py-6 mt-4">
            <form method="GET" action="<?php echo e(route('student.dashboard')); ?>" class="space-y-4">
                
                <input type="hidden" name="q" value="<?php echo e(request('q')); ?>">

                
                <div>
                    <label class="font-semibold text-slate-700">Location (County)</label>
                    <input id="countyInput" name="county" type="text"
                           value="<?php echo e(request('county')); ?>"
                           class="w-full mt-1 rounded-lg border-slate-300"
                           placeholder="Dublin" />
                </div>

                
                <div>
                    <label class="font-semibold text-slate-700">House Type</label>
                    <select name="housetype" class="w-full mt-1 rounded-lg border-slate-300">
                        <option value="">Any</option>
                        <option value="single_private"       <?php if(request('housetype')==='single_private'): echo 'selected'; endif; ?>>Single room in private home</option>
                        <option value="private_shared"       <?php if(request('housetype')==='private_shared'): echo 'selected'; endif; ?>>Private room in shared house</option>
                        <option value="whole_property_group" <?php if(request('housetype')==='whole_property_group'): echo 'selected'; endif; ?>>Whole property (group-only)</option>
                    </select>
                </div>

                
                <div>
                    <label class="font-semibold text-slate-700">Accommodation Type</label>
                    <select name="accommodation_type" class="w-full mt-1 rounded-lg border-slate-300">
                        <option value="">Any</option>
                        <option value="house"     <?php if(request('accommodation_type')==='house'): echo 'selected'; endif; ?>>House</option>
                        <option value="apartment" <?php if(request('accommodation_type')==='apartment'): echo 'selected'; endif; ?>>Apartment</option>
                    </select>
                </div>

                
                <div>
                    <label class="font-semibold text-slate-700">Application Type</label>
                    <select name="application_type" class="w-full mt-1 rounded-lg border-slate-300">
                        <option value="">Any</option>
                        <option value="single" <?php if(request('application_type')==='single'): echo 'selected'; endif; ?>>Single Applications</option>
                        <option value="group"  <?php if(request('application_type')==='group'): echo 'selected'; endif; ?>>Group Applications</option>
                    </select>
                </div>

                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-slate-700">Available From</label>
                        <input type="date" name="from" value="<?php echo e(request('from')); ?>" class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                    <div>
                        <label class="font-semibold text-slate-700">Until</label>
                        <input type="date" name="until" value="<?php echo e(request('until')); ?>" class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                </div>

                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-slate-700">Min Rent (€)</label>
                        <input type="number" name="min_rent" value="<?php echo e(request('min_rent')); ?>" class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                    <div>
                        <label class="font-semibold text-slate-700">Max Rent (€)</label>
                        <input type="number" name="max_rent" value="<?php echo e(request('max_rent')); ?>" class="w-full mt-1 rounded-lg border-slate-300" />
                    </div>
                </div>

                
                <div>
                    <label class="font-semibold text-slate-700">Nights per Week</label>
                    <select name="nights_bucket" class="w-full mt-1 rounded-lg border-slate-300">
                        <option value="any" <?php if(request('nights_bucket','any')==='any'): echo 'selected'; endif; ?>>Any</option>
                        <option value="1-3" <?php if(request('nights_bucket')==='1-3'): echo 'selected'; endif; ?>>1–3 nights</option>
                        <option value="4-5" <?php if(request('nights_bucket')==='4-5'): echo 'selected'; endif; ?>>4–5 nights</option>
                        <option value="6-7" <?php if(request('nights_bucket')==='6-7'): echo 'selected'; endif; ?>>6–7 nights</option>
                    </select>
                </div>

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">
                    Apply Filters
                </button>
            </form>
        </div>

        
        
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $countyListings = collect($listings)->where('county', $county);
            ?>

            <div class="mt-10 county-section" data-county="<?php echo e($county); ?>">
                <h2 class="text-xl font-bold text-slate-900 mb-3"><?php echo e($county); ?></h2>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($countyListings->count() > 0): ?>
                    
                    
                    
                    <div class="flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $countyListings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $images = json_decode($rental->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                            ?>

                            <div class="min-w-[390px] bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                                
                                <div class="relative" data-carousel data-key="mobile-<?php echo e($rental->id); ?>" data-count="<?php echo e($imgCount); ?>">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-mobile-<?php echo e($rental->id); ?>" class="flex transition-transform duration-300 ease-out">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div class="w-full shrink-0">
                                                    <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-40 object-cover rounded-lg" alt="Listing image" />
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <div class="w-full h-40 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                                                    No image
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
                                        <button onclick="prevImage('mobile', <?php echo e($rental->id); ?>)"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>

                                        <button onclick="nextImage('mobile', <?php echo e($rental->id); ?>)"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
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
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    
                    
                    <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $countyListings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rental): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $images = json_decode($rental->images ?? '[]', true) ?? [];
                                $imgCount = count($images);
                            ?>

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4 hover:shadow-md transition">

                                
                                <div class="relative" data-carousel data-key="desktop-<?php echo e($rental->id); ?>" data-count="<?php echo e($imgCount); ?>">
                                    <div class="overflow-hidden rounded-lg">
                                        <div id="track-desktop-<?php echo e($rental->id); ?>" class="flex transition-transform duration-300 ease-out">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <div class="w-full shrink-0">
                                                    <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-48 object-cover rounded-lg" alt="Listing image" />
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <div class="w-full h-48 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500">
                                                    No image
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
                                        <button onclick="prevImage('desktop', <?php echo e($rental->id); ?>)"
                                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">‹</button>

                                        <button onclick="nextImage('desktop', <?php echo e($rental->id); ?>)"
                                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 text-slate-700 px-2 py-1 rounded-full shadow">›</button>
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
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    
                    <div class="flex gap-4 overflow-x-auto pb-2 lg:hidden">
                        <div class="min-w-[390px] bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                            <div class="font-semibold text-slate-700">No listings available yet</div>
                            <div class="text-slate-500 text-sm mt-1">
                                Listings in <?php echo e($county); ?> will appear here.
                            </div>
                        </div>
                    </div>

                    <div class="hidden lg:grid lg:grid-cols-2 lg:gap-6">
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-4">
                            <div class="font-semibold text-slate-700">No listings available yet</div>
                            <div class="text-slate-500 text-sm mt-1">
                                Listings in <?php echo e($county); ?> will appear here.
                            </div>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    
    
    <script>
        // Filter drawer open/close
        (function() {
            const btn = document.getElementById('filterToggle');
            const drawer = document.getElementById('filterDrawer');
            if (btn && drawer) {
                btn.addEventListener('click', () => drawer.classList.toggle('hidden'));
            }
        })();

        // College chips: set county and submit search form
        function filterCounty(county) {
            const form = document.getElementById('searchForm');
            if (!form) return;
            const hiddenCounty = form.querySelector('input[name="county"]');
            if (hiddenCounty) hiddenCounty.value = county;

            // Mirror into the visible county field in the drawer if present
            const countyInput = document.getElementById('countyInput');
            if (countyInput) countyInput.value = county;

            form.submit();
        }

        // --- Carousel as you had it originally ---
        const carouselState = {};

        function stateKey(view, id) {
            return `${view}-${id}`;
        }

        function updateCarousel(view, id) {
            const key = stateKey(view, id);
            const track = document.getElementById(`track-${view}-${id}`);
            if (!track) return;

            const state = carouselState[key] || { index: 0, count: track.children.length };

            const translate = -state.index * 100;
            track.style.transform = `translateX(${translate}%)`;

            // Ensure each slide takes full width
            Array.from(track.children).forEach(child => child.style.width = "100%");
        }

        function nextImage(view, id) {
            const key = stateKey(view, id);
            const container = document.querySelector(`[data-key="${view}-${id}"]`);
            const count = parseInt(container?.dataset.count || '0', 10);

            if (!carouselState[key]) carouselState[key] = { index: 0, count };
            if (count <= 1) return;

            carouselState[key].index = (carouselState[key].index + 1) % count;
            updateCarousel(view, id);
        }

        function prevImage(view, id) {
            const key = stateKey(view, id);
            const container = document.querySelector(`[data-key="${view}-${id}"]`);
            const count = parseInt(container?.dataset.count || '0', 10);

            if (!carouselState[key]) carouselState[key] = { index: 0, count };
            if (count <= 1) return;

            carouselState[key].index =
                carouselState[key].index === 0 ? count - 1 : carouselState[key].index - 1;

            updateCarousel(view, id);
        }

        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("[data-carousel]").forEach(carousel => {
                const key = carousel.dataset.key;
                const [view, id] = key.split("-");
                const count = parseInt(carousel.dataset.count || '0', 10);

                carouselState[key] = { index: 0, count };
                updateCarousel(view, id);
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
<?php endif; ?>
<?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/student/dashboard.blade.php ENDPATH**/ ?>