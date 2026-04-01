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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Post Your Listing
        </h2>
     <?php $__env->endSlot(); ?>

    
    <div class="pb-28 lg:pl-70">
        <div class="py-10">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700">
                        <div class="font-semibold">Please fix the following:</div>
                        <ul class="list-disc pl-5 mt-2 text-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                                <li><?php echo e($error); ?></li>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 sm:p-8">

                        <div class="flex items-start justify-between gap-6">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">Post Your Listing</h1>
                                <p class="text-slate-600 mt-1 text-sm">
                                    Add images and details. Keep them clear and accurate for students.
                                </p>
                            </div>

                            <a href="<?php echo e(route('dashboard')); ?>"
                               class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                                ← Back
                            </a>
                        </div>

                        <form class="mt-8 space-y-8"
                              method="POST"
                              action="<?php echo e(route('landlord.rentals.store')); ?>"
                              enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <input type="hidden" name="premium_listing" id="premium_listing" value="0">
                            <input type="hidden" name="premium_payment_intent" id="premium_payment_intent">

                            
                            
                            <section class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-bold text-slate-900">Images</h2>
                                    <span id="imgCountBadge"
                                        class="hidden text-xs font-bold bg-blue-600 text-white px-2 py-1 rounded-full">
                                        0
                                    </span>
                                </div>

    
                                <label class="block cursor-pointer" id="addMoreImagesBtn">
                                    <div class="rounded-2xl border border-dashed border-slate-300 p-6 hover:border-blue-400 transition">
                                        <div class="flex items-center gap-4">
                                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 16l4-4a3 3 0 014 0l2 2a3 3 0 004 0l4-4M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2z"/>
                                                </svg>
                                            </div>

                                            <div class="flex-1">
                                                <div class="font-semibold text-slate-900">Upload images of your listing</div>
                                                <div class="text-sm text-slate-600">PNG/JPG/WebP, up to 5 images recommended.</div>
                                                <div class="text-xs text-slate-500 mt-1">You can add images in multiple picks.</div>
                                            </div>

                                            <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center text-2xl font-bold">
                                                +
                                            </div>
                                        </div>
                                    </div>
                                </label>

    
                                
                                <div id="imagesInputs"></div>
    
                                <div id="previewGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3"></div>
                            </section>

                            <!-- Listing Details (FULL RESTORED + UPDATED DROPDOWNS) -->
                            <section class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">House Number (optional)</label>
                                    <input name="housenumber" value="<?php echo e(old('housenumber')); ?>"
                                        class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="e.g. 14" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Street</label>
                                    <input name="street" value="<?php echo e(old('street')); ?>" required
                                        class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="e.g. The Green" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">County</label>
                                    <input name="county" value="<?php echo e(old('county')); ?>" required
                                        class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="e.g. Dublin" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Postcode</label>
                                    <input name="postcode" value="<?php echo e(old('postcode')); ?>"
                                        class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="e.g. D14" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Measurement</label>
                                    <input name="measurement" value="<?php echo e(old('measurement')); ?>"
                                        class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="e.g. 15sqm" />
                                </div>

                                <!-- House Type -->
                                <!-- <div>
                                 <label class="text-sm font-semibold text-slate-700">House Type</label>
                                    <select name="housetype"
                                            class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="Any">Any</option>
                                        <option value="Single room in private home">Single room in private home (E.g., In a family home)</option>
                                        <option value="Private room in shared house">Private room in shared house (E.g., House is shared with other tenants)</option>
                                    </select>
                                </div> -->

                                <!-- House Type-->
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">House Type</label>
                                    <select name="housetype" class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="any" <?php if(old('housetype') === 'any'): echo 'selected'; endif; ?>>Any</option>
                                        <option value="single_private" <?php if(old('housetype') === 'single_private'): echo 'selected'; endif; ?>>Single room in private home (e.g. in a family home)</option>
                                        <option value="private_shared" <?php if(old('housetype') === 'private_shared'): echo 'selected'; endif; ?>>Private room in shared house (e.g. shared with other tenants)</option>
                                        <option value="whole_property_group" <?php if(old('housetype') === 'whole_property_group'): echo 'selected'; endif; ?>>
                                            Whole property (group application only)
                                        </option>
                                    </select>
                                </div> 

                                <!-- Accommodation Type -->
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Accommodation Type</label>
                                    <select name="accommodation_type"
                                            class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="" <?php if(old('accommodation_type') === null): echo 'selected'; endif; ?>>Select</option>
                                        <option value="house" <?php if(old('accommodation_type') === 'house'): echo 'selected'; endif; ?>>House</option>
                                        <option value="apartment" <?php if(old('accommodation_type') === 'apartment'): echo 'selected'; endif; ?>>Apartment</option>
                                    </select>
                                </div>

                                <!---Application Type -->
                                <div>
                                    <label for="application_type" class="text-sm font-semibold text-slate-700">Application Type</label>
                                    <select
                                        id="application_type"
                                        name="application_type"
                                        class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                        required
                                    >
                                        <option value="" <?php if(old('application_type') === null): echo 'selected'; endif; ?>>Select</option>
                                        <option value="single" <?php if(old('application_type') === 'single'): echo 'selected'; endif; ?>>Single Applications</option>
                                        <option value="group" <?php if(old('application_type') === 'group'): echo 'selected'; endif; ?>>Group Applications</option>
                                    </select>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['application_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- UPDATED: Nights Per Week -->
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Nights per Week</label>
                                    <input
                                        type="number"
                                        name="nightsperweek"
                                        value="<?php echo e(old('nightsperweek')); ?>"
                                        min="0"
                                        max="7"
                                        step="1"
                                        class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="e.g. 5"
                                    />
                                    <p class="mt-1 text-xs text-slate-500">Enter a number from 0 to 7</p>
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Rent per month (€)</label>
                                    <input name="rentpermonth" value="<?php echo e(old('rentpermonth')); ?>" required type="number" step="0.01" min="0"
                                        class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="e.g. 850" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Status</label>
                                    <select name="status" class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="available" <?php if(old('status')==='available'): echo 'selected'; endif; ?>>Available</option>
                                        <option value="occupied" <?php if(old('status')==='occupied'): echo 'selected'; endif; ?>>Occupied</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-semibold text-slate-700">Available from</label>
                                        <input name="availablefrom" value="<?php echo e(old('availablefrom')); ?>" type="date" required
                                            class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                    <div>
                                        <label class="text-sm font-semibold text-slate-700">Available until</label>
                                        <input name="availableuntil" value="<?php echo e(old('availableuntil')); ?>" type="date" required
                                            class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                </div>

                            </section>

                            <!-- Description -->
                            <section>
                                <label class="text-sm font-semibold text-slate-700">Description</label>
                                <textarea name="description" rows="5" required
                                        class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Brief description about the accommodation..."><?php echo e(old('description')); ?></textarea>
                            </section>
                            <section class="rounded-2xl border border-slate-200 bg-slate-50 p-6 space-y-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h2 class="text-lg font-bold text-slate-900">Premium listing</h2>
                                        <p class="text-sm text-slate-600 mt-1">
                                            Premium listings appear at the top of the student homepage.
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm font-semibold text-slate-900">€4.99</div>
                                        <div class="text-xs text-slate-500">one‑time payment</div>
                                    </div>
                                </div>

                                <label class="flex items-center gap-3">
                                    <input type="checkbox" id="premiumToggle" class="rounded border-slate-300">
                                    <span class="text-sm text-slate-800">Make this a premium listing</span>
                                </label>

                                <div id="premiumStripeBox"
                                    class="hidden border border-slate-200 bg-white rounded-xl p-4 space-y-3">

                                    <p class="text-sm text-slate-700 font-medium">Card details</p>

                                    <div id="premium-card"
                                        class="border border-slate-300 rounded-xl px-4 py-3 bg-white"></div>

                                    <p id="premium-error" class="text-sm text-red-600"></p>

                                    <button type="button" id="premiumPayBtn"
                                        class="rounded-2xl bg-blue-600 px-5 py-3 text-sm text-white">
                                        Pay €4.99
                                    </button>

                                    <p id="premiumSuccess"
                                    class="hidden text-sm text-green-700 font-semibold">
                                        Premium payment completed.
                                    </p>

                                </div>
                            </section>

                            
                            <div class="flex items-center justify-end gap-3 pt-2">
                                <a href="<?php echo e(route('dashboard')); ?>"
                                   class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50">
                                    Cancel
                                </a>

                                <button type="submit" id="saveListingBtn"
                                    class="px-5 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700">
                                    Save Listing
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    

<script>
    const inputsContainer = document.getElementById('imagesInputs');
    const previewGrid     = document.getElementById('previewGrid');
    const badge           = document.getElementById('imgCountBadge');
    const addMoreBtn      = document.getElementById('addMoreImagesBtn');

    // Track how many files have been selected (across all inputs)
    let totalSelected = 0;
    const MAX_FILES = 5;

    function updateBadge() {
        if (totalSelected > 0) {
            badge.classList.remove('hidden');
            badge.textContent = totalSelected;
        } else {
            badge.classList.add('hidden');
            badge.textContent = '0';
        }
    }

    function createInput() {
        const inp = document.createElement('input');
        inp.type = 'file';
        inp.name = 'images[]';
        inp.accept = 'image/*';
        inp.multiple = true;  // user can pick several in one go
        inp.className = 'hidden';

        inp.addEventListener('change', () => {
            const files = Array.from(inp.files || []);
            if (!files.length) return;

            // Enforce MAX_FILES across all inputs
            let remaining = MAX_FILES - totalSelected;
            const toUse = files.slice(0, Math.max(0, remaining));

            toUse.forEach(file => {
                totalSelected++;
                const url  = URL.createObjectURL(file);
                const tile = document.createElement('div');
                tile.className = 'relative overflow-hidden rounded-xl border border-slate-200 bg-slate-50';

                tile.innerHTML = `
                    <img src="${url}" class="w-full h-24 object-cover" alt="preview" />
                `;
                previewGrid.appendChild(tile);
            });

            updateBadge();

            if (totalSelected >= MAX_FILES) {
                // Reached limit; prevent creating more inputs
                addMoreBtn.style.pointerEvents = 'none';
                addMoreBtn.style.opacity = '0.6';
            }
        });

        inputsContainer.appendChild(inp);
        return inp;
    }

    // First input at load (kept hidden)
    let currentInput = createInput();

    // Clicking the "Add" area triggers a NEW input each time
    addMoreBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        if (totalSelected >= MAX_FILES) return;

        // Create a fresh input so previous selection remains intact
        currentInput = createInput();
        currentInput.click();
    });

    // Optional: also open the picker on pressing Enter when focused
    addMoreBtn?.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            if (totalSelected >= MAX_FILES) return;
            currentInput = createInput();
            currentInput.click();
        }
    });
</script>
<script src="https://js.stripe.com/v3"></script>

<script>
document.addEventListener("DOMContentLoaded", async () => {

    const stripe = Stripe("<?php echo e(config('services.stripe.public_key')); ?>");
    const elements = stripe.elements();

    const card = elements.create('card', {
        hidePostalCode: true,
        style: {
            base: {
                fontSize: '16px',
                fontFamily: 'ui-sans-serif, system-ui, sans-serif',
                color: '#374151'
            }
        }
    });

    const toggle = document.getElementById('premiumToggle');
    const box = document.getElementById('premiumStripeBox');
    const payBtn = document.getElementById('premiumPayBtn');
    const saveBtn = document.getElementById('saveListingBtn');
    const premiumFlag = document.getElementById('premium_listing');
    const piInput = document.getElementById('premium_payment_intent');
    const errorEl = document.getElementById('premium-error');
    const successEl = document.getElementById('premiumSuccess');
    // ✅ SUBMIT GUARD — blocks saving premium listings without payment
    const formEl = document.querySelector('form');

    formEl.addEventListener('submit', (e) => {
        if (premiumFlag.value === '1' && !piInput.value) {
            e.preventDefault();

            errorEl.textContent =
                "Please complete the €4.99 premium payment before saving.";

            box.classList.remove('hidden');
            setSave(false);
        }
    });

    card.mount('#premium-card');

    function setSave(enabled) {
        saveBtn.disabled = !enabled;
        saveBtn.classList.toggle('opacity-60', !enabled);
    }

    toggle.addEventListener('change', () => {
        if (toggle.checked) {
            box.classList.remove('hidden');
            premiumFlag.value = '1';
            setSave(false);
        } else {
            box.classList.add('hidden');
            premiumFlag.value = '0';
            piInput.value = '';
            successEl.classList.add('hidden');
            errorEl.textContent = '';
            setSave(true);
        }
    });

    payBtn.addEventListener('click', async () => {
        errorEl.textContent = '';
        payBtn.disabled = true;

        const res = await fetch("<?php echo e(route('landlord.rentals.premium.intent')); ?>", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Content-Type': 'application/json'
            }
        });

        const data = await res.json();

        const { error, paymentIntent } = await stripe.confirmCardPayment(
            data.client_secret,
            { payment_method: { card } }
        );

        if (error) {
            errorEl.textContent = error.message;
            payBtn.disabled = false;
            return;
        }

        piInput.value = paymentIntent.id;
        successEl.classList.remove('hidden');

        // ✅ allow user to click Save Listing manually
        setSave(true);

        // ✅ optional: lock the pay button so they don’t pay twice
        payBtn.disabled = true;
    });

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
<?php endif; ?>
<?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/landlord/rentals/create.blade.php ENDPATH**/ ?>