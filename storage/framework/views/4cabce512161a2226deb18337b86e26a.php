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
            Group Application – <?php echo e($rental->street); ?>, <?php echo e($rental->county); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded-xl shadow">

        <h3 class="text-lg font-semibold mb-4">Group Application Form</h3>

        <form method="POST" action="<?php echo e(route('applications.submit.group', $rental->id)); ?>">
            <?php echo csrf_field(); ?>

            <div id="tenant-container" class="space-y-6">

                
                <div class="tenant-card p-4 border rounded-lg bg-slate-50">
                    <h4 class="font-semibold mb-2">Tenant 1 (You)</h4>

                    
                    <input type="hidden" name="tenants[0][full_name]"
                           value="<?php echo e($student->firstname); ?> <?php echo e($student->surname); ?>">

                    <input type="hidden" name="tenants[0][email]"
                           value="<?php echo e($student->email); ?>">

                    
                    <label class="block mb-1 font-medium">Full Name</label>
                    <input type="text"
                           class="w-full bg-slate-100 rounded-lg px-3 py-2"
                           value="<?php echo e($student->firstname); ?> <?php echo e($student->surname); ?>"
                           disabled>

                    
                    <label class="block mt-3 mb-1 font-medium">Email</label>
                    <input type="email"
                           class="w-full bg-slate-100 rounded-lg px-3 py-2"
                           value="<?php echo e($student->email); ?>"
                           disabled>

                    
                    <label class="block mt-3 mb-1 font-medium">Age</label>
                    <input name="tenants[0][age]" type="number" required
                           class="w-full border rounded-lg px-3 py-2">

                    
                    <font-medium">Gender</label>
                    <select name="tenants[0][gender]" required
                            class="w-full border rounded-lg px-3 py-2">
                        <option value="">Select…</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="nonbinary">Non-binary</option>
                        <option value="prefer_not_say">Prefer not to say</option>
                    </select>
                </div>

            </div>

            
            <button type="button"
                    onclick="addTenant()"
                    class="mt-4 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                + Add Another Tenant
            </button>

            
            <div class="mt-6">
                <label class="block font-medium mb-1">Additional Details (optional)</label>
                <textarea name="additional_details" rows="4"
                          class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>

            
            <button type="submit"
                    class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">
                Submit Group Application
            </button>

        </form>
    </div>

    <script>
        let tenantIndex = 1;

        function addTenant() {
            if (tenantIndex >= 6) {
                alert("You can add up to 6 tenants only.");
                return;
            }

            const container = document.getElementById('tenant-container');

            const card = document.createElement('div');
            card.className = "tenant-card p-4 border rounded-lg bg-white";

            card.innerHTML = `
                <h4 class="font-semibold mb-2">Tenant ${tenantIndex + 1}</h4>

                <label class="block mb-1 font-medium">Full Name</label>
                <input name="tenants[${tenantIndex}][full_name]" required
                       class="w-full border rounded-lg px-3 py-2">

                <label class="block mt-3 mb-1 font-medium">Email</label>
                <input name="tenants[${tenantIndex}][email]" type="email" required
                       class="w-full border rounded-lg px-3 py-2">

                <label class="block mt-3 mb-1 font-medium">Age</label>
                <input name="tenants[${tenantIndex}][age]" type="number" required
                       class="w-full border rounded-lg px-3 py-2">

                <label class="block mt-3 mb-1 font-medium">Gender</label>
                <select name="tenants[${tenantIndex}][gender]" required
                        class="w-full border rounded-lg px-3 py-2">
                    <option value="">Select…</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="nonbinary">Non-binary</option>
                    <option value="prefer_not_say">Prefer not to say</option>
                </select>
            `;

            container.appendChild(card);

            tenantIndex++;
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/applications/start-group.blade.php ENDPATH**/ ?>