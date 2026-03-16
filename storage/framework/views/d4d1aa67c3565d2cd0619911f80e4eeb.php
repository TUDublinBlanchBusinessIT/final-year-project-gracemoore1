
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
        <h2 class="font-bold text-xl text-gray-800">
            Listing Details
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="mb-4">
        <a href="<?php echo e(url()->previous()); ?>" 
        class="inline-block px-4 py-2 bg-gray-200 text-gray-800 text-sm rounded hover:bg-gray-300">
            ← Back
        </a>
    </div>

    <div class="max-w-5xl mx-auto mt-6 px-4 sm:px-6 lg:px-8">

        <?php
            // Images are stored as JSON array like: ["rentals/abc.jpg", "rentals/def.jpg"]
            $images = json_decode($rental->images ?? '[]', true) ?? [];
            $imgCount = count($images);
        ?>

        
        <div class="relative bg-white rounded-xl border border-slate-200 shadow overflow-hidden">
            <div id="detail-track-<?php echo e($rental->id); ?>" class="flex transition-transform duration-300 ease-out">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="w-full shrink-0">
                        <div class="w-full h-72 sm:h-80 md:h-[28rem] bg-slate-100">
                            <img
                                src="<?php echo e(asset('storage/' . $img)); ?>"
                                alt="Listing photo <?php echo e($loop->iteration); ?>"
                                class="w-full h-full object-cover" />
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="w-full shrink-0">
                        <div class="w-full h-72 sm:h-80 md:h-[28rem] bg-slate-100 flex items-center justify-center text-slate-500">
                            No images available
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgCount > 1): ?>
                
                <button
                    type="button"
                    onclick="detailPrev(<?php echo e($rental->id); ?>)"
                    class="absolute left-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-slate-700 px-3 py-2 rounded-full shadow">
                    ‹
                </button>

                <button
                    type="button"
                    onclick="detailNext(<?php echo e($rental->id); ?>)"
                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-slate-700 px-3 py-2 rounded-full shadow">
                    ›
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="bg-white border border-slate-200 rounded-xl p-6 mt-6 shadow space-y-4">

            
            <h1 class="text-2xl font-bold text-slate-900">
                <?php echo e($rental->housenumber ? $rental->housenumber . ' ' : ''); ?>

                <?php echo e($rental->street); ?>, <?php echo e($rental->county); ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rental->postcode)): ?>
                    , <?php echo e($rental->postcode); ?>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </h1>

            
            <div class="flex flex-wrap items-center gap-3 text-slate-700">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rental->measurement)): ?>
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-sm">
                        Size: <?php echo e($rental->measurement); ?>

                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rental->status)): ?>
                    <span class="inline-flex items-center rounded-full border px-3 py-1 text-sm
                        <?php echo e($rental->status === 'available'
                            ? 'bg-green-50 text-green-700 border-green-200'
                            : 'bg-slate-100 text-slate-700 border-slate-200'); ?>">
                        <?php echo e(ucfirst($rental->status)); ?>

                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>


                        
            <div class="space-y-2 text-slate-700">

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rental->housetype)): ?>
                    <div>
                        <span class="font-semibold">House Type:</span>
                        <?php echo e($rental->housetype); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rental->accommodation_type)): ?>
                    <div>
                        <span class="font-semibold">Accommodation Type:</span>
                        <?php echo e(ucfirst($rental->accommodation_type)); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rental->application_type)): ?>
                    <div>
                        <span class="font-semibold">Application Type:</span>
                        <?php echo e(ucfirst($rental->application_type)); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rental->nightsperweek)): ?>
                    <div>
                        <span class="font-semibold">Nights per Week:</span>
                        <?php echo e($rental->nightsperweek); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rental->measurement)): ?>
                    <div>
                        <span class="font-semibold">Size:</span>
                        <?php echo e($rental->measurement); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            </div>
            
            <div class="text-slate-700">
                <span class="font-semibold">Availability:</span>
                <?php echo e($rental->availablefrom); ?> → <?php echo e($rental->availableuntil); ?>

            </div>

            
            <div class="text-slate-900 font-bold text-xl">
                €<?php echo e(number_format($rental->rentpermonth, 2)); ?> / month
            </div>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($rental->description)): ?>
                <div class="pt-2">
                    <h2 class="text-lg font-semibold text-slate-900 mb-1">Description</h2>
                    <p class="text-slate-700 leading-relaxed">
                        <?php echo e($rental->description); ?>

                    </p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



            
                <button type="button"
                        onclick="openApplyModal()"
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">
                    Apply Now
                </button>
        </div>
    </div>

    
    <script>
        // Maintain per-listing gallery state in a simple map.
        const detailState = {}; // key: rentalId -> { index, count }

        function ensureDetailState(id) {
            if (!detailState[id]) {
                const track = document.getElementById(`detail-track-${id}`);
                const count = track ? track.children.length : 0;
                detailState[id] = { index: 0, count: count };
                // Make each slide fill container width
                if (track) {
                    Array.from(track.children).forEach(child => {
                        child.style.width = '100%';
                    });
                }
            }
            return detailState[id];
        }

        function detailUpdate(id) {
            const track = document.getElementById(`detail-track-${id}`);
            if (!track) return;
            const state = ensureDetailState(id);
            const translate = -state.index * 100;
            track.style.transform = `translateX(${translate}%)`;
        }

        function detailNext(id) {
            const state = ensureDetailState(id);
            if (state.count <= 1) return;
            state.index = (state.index + 1) % state.count;
            detailUpdate(id);
        }

        function detailPrev(id) {
            const state = ensureDetailState(id);
            if (state.count <= 1) return;

            state.index = (state.index - 1 + state.count) % state.count;
            detailUpdate(id);
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('detail-track-<?php echo e($rental->id); ?>');
            if (track) {
                ensureDetailState(<?php echo e($rental->id); ?>);
                detailUpdate(<?php echo e($rental->id); ?>);
            }
        });
    </script>
        <!-- Application Modal -->
        <div id="applyModal"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden justify-center items-center p-4">
            <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-6 space-y-4">

                <h2 class="text-xl font-bold text-slate-800 text-center">
                    Choose Application Type
                </h2>

                <div class="space-y-3">
                    <button onclick="selectApplicationType('single')"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold">
                        Single Application
                    </button>

                    <button onclick="selectApplicationType('group')"
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-lg font-semibold">
                        Group Application
                    </button>
                </div>

                <button onclick="closeApplyModal()"
                    class="w-full mt-4 text-slate-600 hover:text-slate-800 font-medium underline">
                    Cancel
                </button>

            </div>
        </div>
        <script>
            function openApplyModal() {
                document.getElementById('applyModal').classList.remove('hidden');
                document.getElementById('applyModal').classList.add('flex');
            }

            function closeApplyModal() {
                document.getElementById('applyModal').classList.add('hidden');
                document.getElementById('applyModal').classList.remove('flex');
            }

            function selectApplicationType(type) {
                // Redirect to a dedicated route
                window.location.href = "/applications/start/<?php echo e($rental->id); ?>/" + type;
            }
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/student/listing-show.blade.php ENDPATH**/ ?>