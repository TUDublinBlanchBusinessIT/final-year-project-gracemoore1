{{-- resources/views/admin/accounts.blade.php --}}
<x-app-layout>

    <x-slot name="header">
        <div class="flex items-start justify-start">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">RentConnect</div>
                <div class="mt-1 font-semibold text-gray-800">Accounts</div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto px-4 py-8">

        {{-- Sub-nav (same style as student profile) --}}
        <nav class="mt-3 border-b border-slate-200">
            <ul class="flex gap-6 text-sm">

                <li>
                    <a href="{{ route('admin.accounts.students') }}"
                       class="{{ request()->routeIs('admin.accounts.students')
                                ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                                : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Students
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.accounts.landlords') }}"
                       class="{{ request()->routeIs('admin.accounts.landlords')
                                ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                                : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Landlords
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.accounts.serviceproviders') }}"
                       class="{{ request()->routeIs('admin.accounts.serviceproviders')
                                ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                                : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Service Providers
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.accounts.suspended') }}"
                    class="{{ request()->routeIs('admin.accounts.suspended')
                                    ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                                    : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Suspended Accounts
                    </a>
                </li>

            </ul>
        </nav>

        <div class="mt-6">
            {{ $slot ?? '' }}
        </div>

    </div>

</x-app-layout>
