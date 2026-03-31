<x-app-layout>

    <x-slot name="header">
        <div class="flex items-start justify-start">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">
                    RentConnect
                </div>
                <div class="mt-1 font-semibold text-gray-800">
                    Reports
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- Reports sub-navigation --}}
        <nav class="mt-3 border-b border-slate-200">
            <ul class="flex gap-6 text-sm">

                <li>
                    <a href="{{ route('admin.reports') }}"
                       class="{{ $activeTab === 'pending'
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Reports to be handled
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.reports.action') }}"
                       class="{{ $activeTab === 'action'
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Action required
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.reports.noaction') }}"
                       class="{{ $activeTab === 'noaction'
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        No action required
                    </a>
                </li>

            </ul>
        </nav>

        <div class="mt-6">
            {{ $slot }}
        </div>

    </div>

</x-app-layout>
