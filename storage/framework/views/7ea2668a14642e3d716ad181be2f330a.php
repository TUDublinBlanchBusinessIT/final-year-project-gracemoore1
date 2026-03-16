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
            Message Student
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
                    Conversation with
                    <span class="font-bold text-slate-900">
                        <?php echo e($application->student->firstname ?? 'Student'); ?> <?php echo e($application->student->surname ?? ''); ?>

                    </span>
                    about
                    <span class="font-bold text-slate-900">
                        <?php echo e($application->rental->housenumber ?? ''); ?>

                        <?php echo e($application->rental->street ?? ''); ?>,
                        <?php echo e($application->rental->county ?? ''); ?>

                    </span>
                </h1>

                <div class="border rounded-xl p-4 bg-slate-50 space-y-3 mb-6 max-h-[400px] overflow-y-auto">
                    <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="<?php echo e($message->landlordid ? 'text-right' : 'text-left'); ?>">
                            <div class="inline-block px-4 py-2 rounded-xl text-sm <?php echo e($message->landlordid ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800'); ?>">
                                <?php echo e($message->content); ?>

                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                <?php echo e(\Carbon\Carbon::parse($message->created_at)->format('d M Y H:i')); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-sm text-gray-500">No messages yet. Start the conversation below.</p>
                    <?php endif; ?>
                </div>

                <form action="<?php echo e(route('landlord.messages.store', $application->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <textarea
                            name="message"
                            rows="4"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring focus:ring-blue-200"
                            placeholder="Type your message to the student here..."
                            required></textarea>
                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700">
                        Send Message
                    </button>
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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/landlord/rentals/message-student.blade.php ENDPATH**/ ?>