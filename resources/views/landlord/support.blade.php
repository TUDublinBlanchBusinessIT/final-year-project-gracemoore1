<x-app-layout>

    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <p class="text-m font-semibold uppercase tracking-[0.12em] text-blue-600">
                Support
            </p>
        </div>
    </x-slot>

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


        {{-- FINANCIAL SUPPORT --}}
        <section>
            <h2 class="text-xl font-bold text-slate-900 mb-4">Financial Support</h2>

            {{-- Rent-a-Room Relief --}}
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

            {{-- Guidance on Setting Rent --}}
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

            {{-- Landlord Grants --}}
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




        {{-- LEGAL SUPPORT --}}
        <section>
            <h2 class="text-xl font-bold text-slate-900 mb-4">Legal Support</h2>

            {{-- Landlord Rights & Responsibilities --}}
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

            {{-- IPOA --}}
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




        {{-- RENTING REGULATIONS & COMPLIANCE --}}
        <section>
            <h2 class="text-xl font-bold text-slate-900 mb-4">Renting Regulations & Compliance</h2>

            {{-- RPZ Calculator --}}
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

            {{-- RPZ Rules --}}
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

            {{-- Notice Periods --}}
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

            {{-- Deposit Rules --}}
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



    {{-- CHATBOT BUTTON --}}
    <a href="{{ route('landlord.chatbot') }}"
       class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700
              text-white w-14 h-14 rounded-full shadow-xl flex items-center
              justify-center z-[9999]">

        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="white" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M7 8h10M7 12h6m1 8-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v6a2 2 0 01-2 2h-3l-4 4z"/>
        </svg>

    </a>
</x-app-layout>
