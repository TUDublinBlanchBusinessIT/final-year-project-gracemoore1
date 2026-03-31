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
        <div>
            <h2 class="text-2xl font-bold text-slate-900 leading-tight">
                Messages
            </h2>
            <p class="mt-1 text-sm text-blue-600">
                Manage conversations with landlords
            </p>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="pb-28 lg:pl-70">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">

            <div class="p-6">

    
    <div class="mb-6 flex flex-wrap gap-3 items-center">

                    <?php $active = request('filter', 'all'); ?>

                    <a href="<?php echo e(request()->fullUrlWithQuery(['filter' => 'all'])); ?>"
                        class="px-4 py-2 text-sm font-medium rounded-full transition
                        <?php echo e($active === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                        All
                    </a>

                    <a href="<?php echo e(request()->fullUrlWithQuery(['filter' => 'unread'])); ?>"
                    class="px-4 py-2 text-sm font-medium rounded-full transition
                    <?php echo e($active === 'unread' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                        Unread
                    </a>

                    <a href="<?php echo e(request()->fullUrlWithQuery(['filter' => 'group'])); ?>"
                    class="px-4 py-2 text-sm font-medium rounded-full transition
                    <?php echo e($active === 'group' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                        Group chats
                    </a>

                    <a href="<?php echo e(request()->fullUrlWithQuery(['filter' => 'individual'])); ?>"
                    class="px-4 py-2 text-sm font-medium rounded-full transition
                    <?php echo e($active === 'individual' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                        Individual
                    </a>

                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($applications->count() == 0): ?>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-600">
                        No messages yet.
                    </div>
                <?php else: ?>
                    <div class="space-y-4">

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $application): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <?php
                                $loggedInStudentId = session('student_id');

                                if ($application->applicationtype === 'group' && $application->group_id) {
                                    $lastMessage = \App\Models\Message::where('group_id', $application->group_id)
                                        ->where('rentalid', $application->rentalid)
                                        ->latest('created_at')
                                        ->first();

                                    $unreadCount = \App\Models\Message::where('group_id', $application->group_id)
                                        ->where('rentalid', $application->rentalid)
                                        ->where('is_read_by_student', false)
                                        ->where(function ($query) use ($loggedInStudentId) {
                                            $query->where('sender_type', 'landlord')
                                                ->orWhere(function ($subQuery) use ($loggedInStudentId) {
                                                    $subQuery->where('sender_type', 'student')
                                                        ->where('studentid', '!=', $loggedInStudentId);
                                                });
                                        })
                                        ->count();

                                    $groupMembers = \Illuminate\Support\Facades\DB::table('student_groups')
                                        ->join('student', 'student.id', '=', 'student_groups.student_id')
                                        ->where('student_groups.group_id', $application->group_id)
                                        ->where('student.id', '!=', $loggedInStudentId)
                                        ->select('student.firstname', 'student.surname')
                                        ->get();

                                    $otherMemberNames = $groupMembers->map(function ($member) {
                                        return trim(($member->firstname ?? '') . ' ' . ($member->surname ?? ''));
                                    })->filter()->values();

                                    $groupSubtitle = $otherMemberNames->count()
                                        ? 'With ' . $otherMemberNames->implode(', ')
                                        : 'Group application';

                                } else {
                                    $lastMessage = \App\Models\Message::where('studentid', $application->studentid)
                                        ->where('rentalid', $application->rentalid)
                                        ->latest('created_at')
                                        ->first();

                                    $unreadCount = \App\Models\Message::where('studentid', $application->studentid)
                                        ->where('rentalid', $application->rentalid)
                                        ->where('sender_type', 'landlord')
                                        ->where('is_read_by_student', false)
                                        ->count();

                                    $groupSubtitle = 'Individual application';
                                }
                            ?>

                            <a href="<?php echo e(route('student.messages.show', $application->id)); ?>"
                               class="block rounded-xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <h3 class="text-base font-semibold text-slate-900 truncate">
                                                <?php echo e($application->rental->landlord->firstname ?? 'Landlord'); ?>

                                                <?php echo e($application->rental->landlord->surname ?? ''); ?>

                                            </h3>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->applicationtype === 'group' && $application->group_id): ?>
                                                <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                                    Group
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->status === 'accepted'): ?>
                                                <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                                    Current Accommodation
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>

                                        <p class="mt-1 text-sm text-slate-500">
                                            <?php echo e($groupSubtitle); ?>

                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            <?php echo e($application->rental->housenumber ?? ''); ?>

                                            <?php echo e($application->rental->street ?? ''); ?>,
                                            <?php echo e($application->rental->county ?? ''); ?>

                                        </p>

                                        <p class="mt-3 text-sm text-slate-700 truncate">
                                            <?php echo e($lastMessage ? \Illuminate\Support\Str::limit($lastMessage->content, 80) : 'No messages yet.'); ?>

                                        </p>
                                    </div>

                                    <div class="ml-4 flex flex-col items-end gap-2 shrink-0">
                                        <div class="text-xs text-slate-400 whitespace-nowrap">
                                            <?php echo e($lastMessage && $lastMessage->created_at ? $lastMessage->created_at->format('d M Y H:i') : ''); ?>

                                        </div>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
                                            <span class="inline-flex items-center justify-center min-w-[22px] h-[22px] rounded-full bg-red-500 px-2 text-xs font-semibold text-white">
                                                <?php echo e($unreadCount); ?>

                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>                       
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/student/messages/index.blade.php ENDPATH**/ ?>