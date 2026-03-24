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
            Messages
        </h2>
     <?php $__env->endSlot(); ?>


    <div class="pb-28 lg:pl-70">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <div class="border-b border-slate-200 px-6 py-4 bg-white">
                    <div class="flex items-center gap-4">
                        <a href="<?php echo e(route('student.messages')); ?>" class="text-slate-500 hover:text-slate-700 text-xl">
                            ←
                        </a>

                        <div class="w-11 h-11 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-lg font-semibold">
                            <?php echo e(strtoupper(substr($application->rental->landlord->firstname ?? 'L', 0, 1))); ?>

                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">
                                <?php echo e($application->rental->landlord->firstname ?? 'Landlord'); ?>

                                <?php echo e($application->rental->landlord->surname ?? ''); ?>

                            </h3>
                            <p class="text-sm text-slate-500">
                                <?php echo e($application->rental->housenumber ?? ''); ?>

                                <?php echo e($application->rental->street ?? ''); ?>,
                                <?php echo e($application->rental->county ?? ''); ?>

                            </p>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->applicationtype === 'group' && $groupMembers->count()): ?>
                                <p class="text-xs text-slate-400 mt-1">
                                    Group members:
                                    <?php echo e($groupMembers->pluck('firstname')->implode(', ')); ?>

                                </p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->status === 'accepted'): ?>
                        <a href="<?php echo e(route('student.rent.page', ['application' => $application->id])); ?><?php echo e($application->group_id ? ('?group_id=' . $application->group_id) : ''); ?>"
                        class="ml-auto h-9 w-9 flex items-center justify-center rounded-full hover:bg-gray-100"
                        title="Rent Tracker">
                            <span class="text-emerald-600 text-xl font-semibold">€</span>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div id="chatContainer" class="bg-slate-50 px-6 py-6 h-[500px] overflow-y-auto space-y-4">

                    <?php
                        $lastDate = null;
                    ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $messageDate = \Carbon\Carbon::parse($message->created_at)->format('d M Y');
                            $loggedInStudentId = session('student_id');
                            $isOwnMessage = $message->sender_type === 'student' && $message->studentid == $loggedInStudentId;
                        ?>                        

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($lastDate !== $messageDate): ?>
                            <div class="flex justify-center my-4">
                                <span class="px-4 py-1 rounded-full bg-slate-200 text-slate-600 text-xs">
                                    <?php echo e($messageDate); ?>

                                </span>
                            </div>
                            <?php
                                $lastDate = $messageDate;
                            ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex <?php echo e($isOwnMessage ? 'justify-end' : 'justify-start'); ?>">
                        
                            <div class="max-w-[75%]">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($application->applicationtype === 'group'): ?>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($message->sender_type === 'student'): ?>
                                        <p class="text-xs text-black font-medium mb-1 <?php echo e($isOwnMessage ? 'text-right' : 'text-left'); ?>">
                                            <?php echo e(\App\Models\Student::find($message->studentid)->firstname ?? 'Student'); ?>

                                        </p>
                                    <?php else: ?>
                                        <p class="text-xs text-black font-medium mb-1 text-left">
                                            <?php echo e($application->rental->landlord->firstname ?? 'Landlord'); ?>

                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            
                                <div class="px-4 py-3 rounded-2xl text-sm shadow-sm
                                    <?php echo e($isOwnMessage ? 'bg-blue-600 text-white rounded-br-md' : 'bg-white text-slate-800 border border-slate-200 rounded-bl-md'); ?>">
                                    <?php echo e($message->content); ?>

                                </div>

                                <div class="mt-1 text-[11px] text-slate-400 <?php echo e($isOwnMessage ? 'text-right' : 'text-left'); ?>">
                                    <?php echo e(\Carbon\Carbon::parse($message->created_at)->format('H:i')); ?>


                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOwnMessage): ?>
                                        <span class="ml-1">
                                            <?php echo e($message->is_read_by_landlord ? 'Seen' : 'Sent'); ?>

                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="flex justify-center items-center h-full">
                            <p class="text-sm text-slate-500">No messages yet.</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>

                <div class="border-t border-slate-200 bg-white px-6 py-4">
                    <form action="<?php echo e(route('student.messages.store', $application->id)); ?>" method="POST" class="flex items-end gap-3">
                        <?php echo csrf_field(); ?>

                        <div class="flex-1">
                            <textarea
                                name="message"
                                rows="2"
                                class="w-full resize-none rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-400 focus:ring focus:ring-blue-100"
                                placeholder="Type your message here..."
                                required></textarea>
                        </div>

                        <button
                            type="submit"
                            class="rounded-2xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700">
                            Send
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function () {
            const chatBox = document.getElementById('chatBox');
            if (chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const chat = document.getElementById("chatContainer");
        if (chat) {
            chat.scrollTop = chat.scrollHeight;
        }
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/student/messages/chat.blade.php ENDPATH**/ ?>