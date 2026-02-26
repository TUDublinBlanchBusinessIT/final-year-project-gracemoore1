<x-app-layout>

    <x-slot name="header">
        <div class="flex items-start justify-between">
            <button type="button" class="text-slate-700 hover:text-slate-900" aria-label="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div class="text-right">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">RentConnect</div>
                <div class="mt-1 font-semibold text-gray-800">Support</div>
            </div>
        </div>
    </x-slot>

    <div class="bg-white p-6 rounded-xl shadow-sm">
        <h2 class="text-2xl font-bold text-slate-900">Student Support</h2>
        <p class="text-slate-600 mt-2">Coming soon.</p>
    </div>

</x-app-layout>