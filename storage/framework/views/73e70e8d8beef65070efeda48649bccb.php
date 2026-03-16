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

<div class="p-6 bg-white shadow rounded-lg max-w-4xl mx-auto">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Student Profile</h2>

    
    <div class="space-y-2 text-gray-800">
        <p><strong>Firstname:</strong> <?php echo e($student->firstname); ?></p>
        <p><strong>Surname:</strong> <?php echo e($student->surname); ?></p>
        <p><strong>Date of Birth:</strong> <?php echo e($student->dateofbirth); ?></p>
        <p><strong>Phone Number:</strong> <?php echo e($student->phonenumber); ?></p>
        <p><strong>Email:</strong> <?php echo e($student->email); ?></p>
        <p><strong>Email Verified:</strong>
            <?php echo e($student->email_verified == 1 ? 'Yes' : 'No'); ?>

        </p>
        <p><strong>ID Verified:</strong>
            <?php echo e($student->id_verified ? 'Yes' : 'No'); ?>

        </p>
        <p><strong>Account Created:</strong>
            <?php echo e($student->created_at ? $student->created_at->format('d/m/Y') : 'Unknown'); ?>

        </p>
    </div>

    <hr class="my-6">

    
    <h3 class="text-lg font-semibold text-gray-900 mb-2">Current Listings</h3>

    <?php
        $currentListings = \App\Models\LandlordRental::where('studentid', $student->id)
                            ->where('status', 'current')
                            ->get();
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentListings->count() == 0): ?>
        <p class="text-gray-500">No current listings.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $currentListings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="p-4 border rounded-lg shadow-sm bg-white">
                    <h4 class="font-bold text-gray-900"><?php echo e($listing->housenumber); ?> <?php echo e($listing->street); ?></h4>
                    <p class="text-gray-700"><?php echo e($listing->county); ?></p>
                    <p class="text-blue-700 font-semibold mt-1">€<?php echo e($listing->rentpermonth); ?> / month</p>

                    <?php
                        $images = explode(',', $listing->images);
                        $firstImage = $images[0] ?? null;
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($firstImage): ?>
                        <img src="<?php echo e(asset('storage/' . $img)); ?>" class="w-full h-48 object-cover rounded-lg" />
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-2">Previous Listings</h3>

    <?php
        $previousListings = \App\Models\LandlordRental::where('studentid', $student->id)
                                ->where('status', 'previous')
                                ->get();
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($previousListings->count() == 0): ?>
        <p class="text-gray-500">No previous listings.</p>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $previousListings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="p-4 border rounded-lg shadow-sm bg-white">
                    <h4 class="font-bold text-gray-900"><?php echo e($listing->housenumber); ?> <?php echo e($listing->street); ?></h4>
                    <p class="text-gray-700"><?php echo e($listing->county); ?></p>
                    <p class="text-blue-700 font-semibold mt-1">€<?php echo e($listing->rentpermonth); ?> / month</p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="mt-8 flex gap-4">
        <form method="POST" action="<?php echo e(route('admin.accounts.suspend', ['type'=>'student','id'=>$student->id])); ?>">
            <?php echo csrf_field(); ?>
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Suspend Account</button>
        </form>

        <form method="POST" action="<?php echo e(route('admin.accounts.reactivate', ['type'=>'student','id'=>$student->id])); ?>">
            <?php echo csrf_field(); ?>
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Reactivate Account</button>
        </form>
    </div>

</div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df)): ?>
<?php $attributes = $__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df; ?>
<?php unset($__attributesOriginalc98b3e35bd8155af0bdb37c6a10156df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc98b3e35bd8155af0bdb37c6a10156df)): ?>
<?php $component = $__componentOriginalc98b3e35bd8155af0bdb37c6a10156df; ?>
<?php unset($__componentOriginalc98b3e35bd8155af0bdb37c6a10156df); ?>
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/view-student.blade.php ENDPATH**/ ?>