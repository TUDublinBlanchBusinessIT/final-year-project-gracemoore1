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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Partnership
        </h2>
     <?php $__env->endSlot(); ?>

    <style>
        body {
            background: #f5f7fb;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .form-container {
            max-width: 1000px;
            margin: 5px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            padding: 40px 30px;
        }
        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: rgb(38, 98, 227);
            margin-bottom: 24px;
            text-align: center;
        }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; }
        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #d0d5dd;
            font-size: 16px;
        }
        /* Checkbox alignment & visibility fix */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 12px 0 18px;
        }
        .checkbox-group input[type="checkbox"] {
            width: 18px;
            height: 18px;
            appearance: auto;
            -webkit-appearance: auto;
            accent-color: rgb(38, 98, 227);
            flex-shrink: 0;
            margin: 0; /* reset previous top/right margins */
        }
        .checkbox-group label {
            margin: 0;
            font-weight: 400;
            font-size: 12px;
            line-height: 1.35;
        }
        .btn {
            background: rgb(38, 98, 227);
            color: #fff;
            border: none;
            padding: 12px 0;
            width: 100%;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
        }
        .error { color: #d32f2f; font-size: 15px; margin-bottom: 10px; }
        .success-popup {
            background: #e6f4ea;
            color: #256029;
            border: 1px solid #b7e1cd;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 18px;
            text-align: center;
        }
    </style>

    <div class="form-container">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="success-popup"><?php echo e(session('success')); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="error">
                <ul style="margin:0; padding-left:18px;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.partnerships.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="servicetype">Type</label>
                <select name="servicetype" id="servicetype" required>
                    <option value="">Select type</option>
                    <option value="Plumbing">Plumbing</option>
                    <option value="Electrician">Electrician</option>
                    <option value="Cleaning">Cleaning</option>
                    <option value="Estate Agent">Estate Agent</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" required>
            </div>

            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" name="surname" id="surname" required>
            </div>

            <div class="form-group">
                <label for="companyname">Status (Company Name or "Independent")</label>
                <input type="text" name="companyname" id="companyname" required>
            </div>

            <div class="form-group">
                <label for="email">Partnership Email (login & notification)</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" required>
            </div>

            <div class="form-group">
                <label for="county">County</label>
                <input type="text" name="county" id="county" required>
            </div>

            <div class="form-group">
                <label for="password">Create Partnership Password</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Partnership Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <div class="form-group">
                <label for="fee_type">Partnership Fee</label>
                <select name="fee_type" id="fee_type" required onchange="toggleFeeInput()">
                    <option value="">Select fee type</option>
                    <option value="commission">Commission</option>
                    <option value="monthly_fee">Monthly Fee</option>
                </select>
            </div>

            <div class="form-group" id="commission_group" style="display:none;">
                <label for="commission">Commission Percentage (%)</label>
                <input type="number" name="commission" id="commission" min="0" max="100" step="0.01" placeholder="Enter commission percentage">
            </div>

            <div class="form-group" id="monthly_fee_group" style="display:none;">
                <label for="monthly_fee">Monthly Fee (€)</label>
                <input type="number" name="monthly_fee" id="monthly_fee" min="0" step="0.01" placeholder="Enter monthly fee in euro">
            </div>

            
            <div class="checkbox-group">
                <input type="checkbox" name="verification" id="verification" value="1" required>
                <label for="verification">
                    All verification and background checks for this partnership have been successfully completed with the partnership fee structure being fully agreed upon and approved by both parties.
                    This company is now approved as an official RentConnect partner and has accepted the platform’s
                    terms and conditions.
                </label>
            </div>

            <button type="submit" class="btn">Create Account</button>
        </form>
    </div>

    <script>
        function toggleFeeInput() {
            var feeType = document.getElementById('fee_type').value;
            document.getElementById('commission_group').style.display = (feeType === 'commission') ? 'block' : 'none';
            document.getElementById('monthly_fee_group').style.display = (feeType === 'monthly_fee') ? 'block' : 'none';
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
<?php endif; ?><?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/admin/partnerships.blade.php ENDPATH**/ ?>