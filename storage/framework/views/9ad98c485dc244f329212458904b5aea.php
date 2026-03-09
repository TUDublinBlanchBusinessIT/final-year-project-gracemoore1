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
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Applications
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="pb-28 lg:pl-70">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">

                
                <?php if(session('success')): ?>
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg border border-green-300 text-sm">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                
                <h1 class="text-base font-semibold text-slate-700 mb-6">
                    Applications for
                    <span class="font-bold text-slate-900">
                        <?php echo e($rental->housenumber ? $rental->housenumber . ' ' : ''); ?>

                        <?php echo e($rental->street); ?>, <?php echo e($rental->county); ?>

                    </span>
                </h1>

                <?php if($applications->isEmpty()): ?>
                    <p class="text-sm text-gray-600">No applications yet.</p>
                <?php else: ?>

                    <div class="space-y-5">

                        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-5 bg-white border rounded-xl shadow">

                                
                                <h3 class="text-sm font-semibold text-slate-900">
                                    <?php echo e($app->student->firstname); ?> <?php echo e($app->student->surname); ?>

                                </h3>

                                <p class="text-xs text-slate-500 mb-3">
                                    Applied: <?php echo e(\Carbon\Carbon::parse($app->dateapplied)->format('d M Y')); ?>

                                </p>

                                
                                <div class="mt-2 space-y-1 text-sm text-slate-700">

                                    <p><span class="font-medium">Application Type:</span> <?php echo e(ucfirst($app->applicationtype)); ?></p>

                                    <?php if($app->applicationtype === 'single'): ?>
                                        <p><span class="font-medium">Age:</span> <?php echo e($app->age); ?></p>
                                        <p><span class="font-medium">Gender:</span> <?php echo e(ucfirst($app->gender)); ?></p>
                                    <?php endif; ?>

                                    <?php if($app->additional_details): ?>
                                        <p><span class="font-medium">Additional Info:</span> <?php echo e($app->additional_details); ?></p>
                                    <?php endif; ?>

                                    <?php if($app->applicationtype === 'group'): ?>
                                        <div class="mt-1">
                                            <p class="font-medium">Group Members:</p>
                                            <ul class="ml-5 list-disc text-sm">
                                                <?php $__currentLoopData = json_decode($app->group_members, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li>
                                                        <?php echo e($member['full_name']); ?>

                                                        (<?php echo e($member['age']); ?> yrs, <?php echo e(ucfirst($member['gender'])); ?>)
                                                    </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                
                                <div class="mt-3 flex items-center justify-between">

                                    
                                    <span class="px-2 py-1 rounded text-[11px] bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>

                                    
                                    <div class="flex gap-2">

                                        
                                        <form action="<?php echo e(route('landlord.applications.reject', $app->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button 
                                                class="px-3 py-1 rounded bg-red-600 text-white text-xs hover:bg-red-700">
                                                Reject
                                            </button>
                                        </form>

                                        
                                        <form action="<?php echo e(route('landlord.applications.accept', $app->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button 
                                                class="px-3 py-1 rounded bg-green-600 text-white text-xs hover:bg-green-700">
                                                Accept
                                            </button>
                                        </form>

                                    </div>

                                </div>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>

                <?php endif; ?>

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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/landlord/rentals/applications.blade.php ENDPATH**/ ?>