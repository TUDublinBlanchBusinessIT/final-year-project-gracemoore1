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
        <h2 class="font-bold text-xl text-gray-800">
            Group Application – <?php echo e($rental->street); ?>, <?php echo e($rental->county); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded-xl shadow">
        <h3 class="text-lg font-semibold mb-4">Group Application</h3>

        
        <form method="POST" action="<?php echo e(route('applications.submit.group', $rental->id)); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="mb-4">
                <label class="font-semibold">Choose a group</label>
                <select id="mode-select" name="mode" class="w-full border rounded-lg px-3 py-2" onchange="toggleMode()">
                    <option value="existing">Use existing group</option>
                    <option value="new">Create new group</option>
                </select>
            </div>

            
            <div id="existing-group-section">
                <label class="block mb-1 font-medium">Existing groups</label>
                <select name="existing_group_id" class="w-full border rounded-lg px-3 py-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $existingGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <?php
                            $label = $g->members->map(fn($m) => trim($m->firstname.' '.$m->surname))->implode(', ');
                        ?>
                        <option value="<?php echo e($g->id); ?>"><?php echo e($label); ?></option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <option value="">No saved groups yet</option>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            
            <div id="new-group-section" class="hidden">
                
                <div class="tenant-card p-4 border rounded-lg bg-slate-50">
                    <h4 class="font-semibold mb-2">Tenant 1 (You)</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-medium">Full Name</label>
                            <input type="text" class="w-full bg-slate-100 rounded-lg px-3 py-2"
                                   value="<?php echo e($student->firstname); ?> <?php echo e($student->surname); ?>" disabled>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Email</label>
                            <input type="email" class="w-full bg-slate-100 rounded-lg px-3 py-2"
                                   value="<?php echo e($student->email); ?>" disabled>
                        </div>
                    </div>

                    <p class="text-xs text-slate-500 mt-2">
                        You will be added as the group leader automatically.
                    </p>
                </div>

                <div id="tenant-container" class="space-y-6 mt-4"></div>

                <button type="button" onclick="addTenant()"
                        class="mt-4 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                    + Add Another Tenant
                </button>
            </div>

            
            <div class="mt-6">
                <label class="block font-medium mb-1">Additional Details (optional)</label>
                <textarea name="additional_details" rows="4" class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>

            <button type="submit"
                    class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">
                Submit Group Application
            </button>
        </form>
    </div>

    <script>
        let tenantIndex = 0;

        function toggleMode() {
            const mode = document.getElementById('mode-select').value;
            document.getElementById('existing-group-section').classList.toggle('hidden', mode !== 'existing');
            document.getElementById('new-group-section').classList.toggle('hidden', mode !== 'new');
        }

        function addTenant() {
            if (tenantIndex >= 5) { // 5 extra (you + 5 = 6)
                alert("You can add up to 6 tenants total (including you).");
                return;
            }
            const container = document.getElementById('tenant-container');
            const card = document.createElement('div');
            card.className = "tenant-card p-4 border rounded-lg bg-white";

            card.innerHTML = `
                <h4 class="font-semibold mb-2">Additional Member ${tenantIndex + 1}</h4>

                <label class="block mb-1 font-medium">Full Name</label>
                <input name="tenants[${tenantIndex}][full_name]" required class="w-full border rounded-lg px-3 py-2">

                <label class="block mt-3 mb-1 font-medium">Email</label>
                <input name="tenants[${tenantIndex}][email]" type="email" required class="w-full border rounded-lg px-3 py-2">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                    <div>
                        <label class="block mb-1 font-medium">Age</label>
                        <input name="tenants[${tenantIndex}][age]" type="number" required class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Gender</label>
                        <select name="tenants[${tenantIndex}][gender]" required class="w-full border rounded-lg px-3 py-2">
                            <option value="">Select…</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="nonbinary">Non-binary</option>
                            <option value="prefer_not_say">Prefer not to say</option>
                        </select>
                    </div>
                </div>
            `;
            container.appendChild(card);
            tenantIndex++;
        }

        document.addEventListener('DOMContentLoaded', toggleMode);
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/applications/start-group.blade.php ENDPATH**/ ?>