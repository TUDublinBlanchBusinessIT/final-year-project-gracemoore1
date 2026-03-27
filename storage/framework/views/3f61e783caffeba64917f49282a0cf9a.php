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
        <div class="flex items-start justify-start">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">RentConnect</div>
                <div class="mt-1 font-semibold text-gray-800">Landlord Support</div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <style>
        details {
            border-bottom: 1px solid #e2e8f0;
            padding: .5rem 0;
        }
        summary {
            list-style: none;
            cursor: pointer;
        }
        .accordion-summary {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            padding: .5rem 0;
            cursor: pointer;
            color: #0f172a;
        }
        .arrow {
            display: inline-block;
            transition: transform .3s ease;
            font-size: 1.1rem;
        }
        details[open] .arrow {
            transform: rotate(90deg);
        }
        .support-link {
            color: #2563eb;
            text-decoration: underline;
        }
    </style>

    <div class="bg-white p-6 rounded-xl shadow-sm space-y-10">


        
        <section>
            <h2 class="text-xl font-bold text-slate-900 mb-4">Financial Support</h2>

            
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Rent‑a‑Room Relief
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Revenue’s Rent‑a‑Room Relief allows landlords to earn income tax‑free when renting a room in their home.
                </p>
                <a href="https://www.revenue.ie/en/personal-tax-credits-reliefs-and-exemptions/land-and-property/rent-a-room-relief/index.aspx"
                   target="_blank" class="support-link">
                    Rent‑a‑Room Relief →
                </a>
            </details>

            
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Guidance on Setting Rent
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Rent Estimate Calculator helps landlords with understanding how much to charge for rent based off of typical rents for similar properties nationwide.
                </p>
                <a href="https://findqo.ie/rental-estimate-tool"
                   target="_blank" class="support-link">
                    Rent Estimate Calculator
                </a>
            </details>

            
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Landlord Grants
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Upgrade grants and home‑energy supports available for improving rental properties in Ireland.
                </p>
                <a href="https://www.seai.ie/grants/home-energy-grants/supports-for-landlords"
                   target="_blank" class="support-link">
                    SEAI Home Energy Grants →
                </a>
            </details>

        </section>




        
        <section>
            <h2 class="text-xl font-bold text-slate-900 mb-4">Legal Support</h2>

            
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Landlord Rights & Responsibilities
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    RTB guidelines outlining landlord obligations including notice periods, deposits, repairs, and tenant communication.
                </p>
                <a href="https://rtb.ie/renting/rights-responsibilities/landlord-rights-responsibilities/"
                   target="_blank" class="support-link">
                    RTB Landlord Responsibilities →
                </a>
            </details>

            
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Irish Property Owners Association (IPOA)
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    The IPOA provides legal updates, documentation templates, and guidance for Irish landlords.
                </p>
                <a href="https://www.ipoa.ie"
                   target="_blank" class="support-link">
                    Visit IPOA →
                </a>
            </details>

        </section>




        
        <section>
            <h2 class="text-xl font-bold text-slate-900 mb-4">Renting Regulations & Compliance</h2>

            
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Rental Price Guidance (What Other Areas Are Charging)
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    View rental trends and average rents across Ireland to help you understand what similar properties are charging.
                </p>
                <a href="https://findqo.ie/rental-estimate-tool"
                target="_blank" class="support-link">
                    Rental Price Guidance →
                </a>
            </details>

            
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Maximum Rent & RPZ Rules
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Check if your property is in a Rent Pressure Zone and calculate the maximum legal rent you can charge.
                </p>
                <a href="https://rtb.ie/rtb-rent-calculator/?_gl=1*zxlzew*_up*MQ..*_ga*NjY3MzA4MTUzLjE3NzQxMTI0MTc.*_ga_SQ54Y7X4WL*czE3NzQxMTI0MTckbzEkZzAkdDE3NzQxMTI0MTckajYwJGwwJGgw"
                target="_blank" class="support-link">
                    RPZ Rent & Rules →
                </a>
            </details>

            
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Notice Period Requirements
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Official rules for notice periods, termination documentation and valid grounds for ending a tenancy.
                </p>
                <a href="https://rtb.ie/renting/how-a-landlord-can-end-a-tenancy/?_gl=1*150s0f3*_up*MQ..*_ga*MTQ2MzgxOTQ4MC4xNzc0MTExODI2*_ga_SQ54Y7X4WL*czE3NzQxMTE4MjYkbzEkZzAkdDE3NzQxMTE4MjYkajYwJGwwJGgw"
                   target="_blank" class="support-link">
                    Ending a Tenancy →
                </a>
            </details>

            
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Deposit Rules & Dispute Resolution
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Information on deposits, withholding rules, and RTB dispute resolution services.
                </p>
                <a href="https://www.rtb.ie/disputes"
                   target="_blank" class="support-link">
                    Dispute Resolution →
                </a>
            </details>

        </section>

    </div>



    
    <a href="<?php echo e(route('landlord.chatbot')); ?>"
       class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700
              text-white w-14 h-14 rounded-full shadow-xl flex items-center
              justify-center z-[9999]">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="white" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 8h10M7 12h6m1 8-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v6a2 2 0 01-2 2h-3l-4 4z"/>
        </svg>

    </a>
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
<?php /**PATH C:\Users\gmoor\final-year-project-gracemoore1\resources\views/landlord/support.blade.php ENDPATH**/ ?>