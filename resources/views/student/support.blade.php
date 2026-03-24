<x-app-layout>

    <x-slot name="header">
        <div class="flex items-start justify-start">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">RentConnect</div>
                <div class="mt-1 font-semibold text-gray-800">Student Support</div>
            </div>
        </div>
    </x-slot>

    <style>
        details {
            border-bottom: 1px solid #e2e8f0;
            padding: .5rem 0;
        }
        summary {
            list-style: none;
        }
        /* ARROW ROTATION FIX */
        .arrow {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        /* When the <details> element is open → rotate the arrow 90 degrees */
        details[open] .arrow {
            transform: rotate(90deg);
        }
        .accordion-summary {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            padding: .5rem 0;
            cursor: pointer;
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

            {{-- SUSI --}}
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> SUSI Grants
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    SUSI provides financial support to help students cover tuition and living costs.
                </p>
                <a href="https://www.susi.ie" target="_blank" class="support-link">Visit SUSI →</a>
            </details>

            {{-- Bike Hire --}}
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Bike Hire Schemes
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Affordable public bike hire options to reduce commuting costs.
                </p>
                <a href="https://www.dublinbikes.ie" target="_blank" class="support-link">DublinBikes →</a><br>
                <a href="https://www.bikeshare.ie" target="_blank" class="support-link">Other Bike Shares →</a>
            </details>

            {{-- Student Discounts --}}
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Student Discounts
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Access discounts on fashion, tech, food and travel.
                </p>
                <a href="https://www.myunidays.com" target="_blank" class="support-link">UNiDAYS – Student Deals →</a><br>
                <a href="https://www.studentbeans.com" target="_blank" class="support-link">Student Beans – Discounts →</a><br>
                <a href="https://about.leapcard.ie/young-adult-and-student-card-launch" target="_blank" class="support-link">
                    Student Leap Card – Transport Savings →
                </a>
            </details>

            {{-- Budget Planner --}}
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Accommodation Budget Planner
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Use Ireland’s official budget calculator to estimate your monthly living costs.
                </p>
                <a href="https://www.ccpc.ie/consumers/tools-and-calculators/budget-planner/" 
                   target="_blank" class="support-link">
                    Open Budget Planner →
                </a>
            </details>

        </section>


        {{-- LEGAL SUPPORT --}}
        <section>
            <h2 class="text-xl font-bold text-slate-900 mb-4">Legal Support</h2>

            {{-- Tenant Rights --}}
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Tenant Rights
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Citizens Information guidelines outlining tenant rights, deposits, repairs and rent rules.
                </p>
                <a href="https://www.citizensinformation.ie/en/housing/renting-a-home/tenants-rights-and-responsibilities/tenants-rights-and-obligations/"
                   target="_blank" class="support-link">
                    View Tenant Rights →
                </a>
            </details>

            {{-- Garda --}}
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> An Garda Síochána – Emergency & Safety Info
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Official Garda website for safety advice, emergency numbers, and reporting information.
                </p>
                <a href="https://www.garda.ie/en/" target="_blank" class="support-link">Garda Safety Information →</a>
            </details>

        </section>


        {{-- MENTAL HEALTH SUPPORT --}}
        <section>
            <h2 class="text-xl font-bold text-slate-900 mb-4">Mental Health Support</h2>

            {{-- HSE Mental Health --}}
            <details>
                <summary class="accordion-summary">
                   <span class="arrow">></span> HSE Mental Health Supports
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    National HSE mental health hub offering wellbeing support and crisis services.
                </p>
                <a href="https://www2.hse.ie/mental-health/" target="_blank" class="support-link">Mental Health Support →</a>
            </details>

            {{-- Mindfulness --}}
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Mindfulness & Guided Exercises
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Official HSE mindfulness exercises, guided audio, and techniques to help reduce stress.
                </p>
                <a href="https://www2.hse.ie/mental-health/self-help/activities/mindfulness/" target="_blank" class="support-link">
                    HSE Mindfulness →
                </a>
            </details>

            {{-- Anxiety --}}
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Stress & Anxiety Support
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Evidence‑based guidance and coping strategies for anxiety, stress, and overthinking.
                </p>
                <a href="https://www2.hse.ie/mental-health/issues/anxiety/" target="_blank" class="support-link">
                    HSE Anxiety Tools →
                </a>
            </details>

            {{-- Exam Stress --}}
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Exam Stress Support
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    Advice and techniques for managing exam pressure, staying focused, and coping during stressful study periods.
                </p>
                <a href="https://www2.hse.ie/mental-health/life-situations-events/exam-stress/" target="_blank" class="support-link">
                    HSE Exam Stress →
                </a>
            </details>

            {{-- SpunOut --}}
            <details>
                <summary class="accordion-summary">
                    <span class="arrow">></span> Youth Wellbeing Resources
                </summary>
                <p class="mt-2 text-slate-700 text-sm">
                    SpunOut provides wellbeing tips, mental health articles, and youth support resources.
                </p>
                <a href="https://www.spunout.ie/mental-health" target="_blank" class="support-link">
                    SpunOut Wellbeing Hub →
                </a>
            </details>

        </section>

    </div>


    {{-- CHATBOT BUTTON --}}
    <button id="chatbotBtn"
        class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 
               text-white w-14 h-14 rounded-full shadow-xl flex items-center 
               justify-center z-[99999]">

        {{-- Chatbot Icon --}}
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
            viewBox="0 0 24 24" stroke="white" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 8h10M7 12h6m1 8l-4-4H6a2 2 0 01-2-2V6a2
                   2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
        </svg>

    </button>

    {{-- CHATBOT MODAL --}}
    <div id="chatbotModal"
         class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center 
                justify-center z-[99998]">
        <div class="bg-white p-6 rounded-xl shadow-xl w-80 text-center">
            <h2 class="text-xl font-bold text-slate-900 mb-3">AI Chatbot (Coming Soon)</h2>
            <p class="text-slate-600 text-sm mb-4">
                This feature will be available in a future update.
            </p>
            <button onclick="document.getElementById('chatbotModal').classList.add('hidden')"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Close
            </button>
        </div>
    </div>

    <script>
        const btn = document.getElementById('chatbotBtn');
        const modal = document.getElementById('chatbotModal');

        btn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
    </script>

</x-app-layout>
