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
        <div>
            <h2 class="text-2xl font-bold text-slate-900 leading-tight">
                Messages
            </h2>
            <p class="mt-1 text-sm text-blue-600">
                Manage conversations with students
            </p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="pb-28 lg:pl-70">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">

                <?php if($applications->count() == 0): ?>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
                        No messages yet.
                    </div>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php
                                if ($application->applicationtype === 'group' && $application->group_id) {

                                    $lastMessage = \App\Models\Message::where('group_id', $application->group_id)
                                        ->where('rentalid', $application->rentalid)
                                        ->latest('created_at')
                                        ->first();

                                    $groupMembers = \Illuminate\Support\Facades\DB::table('student_groups')
                                        ->join('student', 'student.id', '=', 'student_groups.student_id')
                                        ->where('student_groups.group_id', $application->group_id)
                                        ->select('student.firstname', 'student.surname')
                                        ->get();

                                    $memberCount = $groupMembers->count();

                                    $chatName = ($application->student->firstname ?? 'Student') . ' ' . ($application->student->surname ?? '');

                                    if ($memberCount > 1) {
                                        $chatName .= ' +' . ($memberCount - 1) . ' other' . ($memberCount - 1 > 1 ? 's' : '');
                                    }

                                    $chatType = 'Group application';

                                } else {

                                    $lastMessage = \App\Models\Message::where('studentid', $application->studentid)
                                        ->where('rentalid', $application->rentalid)
                                        ->latest('created_at')
                                        ->first();

                                    $chatName = ($application->student->firstname ?? 'Student') . ' ' . ($application->student->surname ?? '');

                                    $chatType = 'Individual application';

                                }
                            ?>

                            <a href="<?php echo e(route('landlord.messages.show', $application->id)); ?>"
                               class="block rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-blue-200 hover:shadow-md">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-base font-semibold text-black truncate">
                                                <?php echo e(trim($chatName)); ?>

                                            </h3>

                                            <?php if($application->applicationtype === 'group' && $application->group_id): ?>
                                                <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                                    Group
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <p class="mt-1 text-sm text-slate-500">
                                            <?php echo e($chatType); ?>

                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            <?php echo e($application->rental->housenumber ?? ''); ?>

                                            <?php echo e($application->rental->street ?? ''); ?>,
                                            <?php echo e($application->rental->county ?? ''); ?>

                                        </p>

                                        <p class="mt-3 text-sm text-slate-700 truncate">
                                            <?php echo e($lastMessage ? \Illuminate\Support\Str::limit($lastMessage->content, 90) : 'No messages yet.'); ?>

                                        </p>
                                    </div>

                                    <div class="shrink-0 text-xs text-slate-400 whitespace-nowrap">
                                        <?php echo e($lastMessage && $lastMessage->created_at ? $lastMessage->created_at->format('d M Y H:i') : ''); ?>

                                    </div>
                                </div>
                            </a>

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
<?php endif; ?><?php /**PATH C:\Users\moyak\final-year-project-gracemoore1\resources\views/landlord/messages/index.blade.php ENDPATH**/ ?>