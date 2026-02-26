<x-app-layout>

    <x-slot name="header">
        <div class="flex items-start justify-start">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">RentConnect</div>
                <div class="mt-1 font-semibold text-gray-800">Profile</div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 py-8">

        {{-- Sub-nav --}}
        <nav class="mt-3 border-b border-slate-200">
            <ul class="flex gap-6 text-sm">
                <li>
                    <a href="{{ route('student.profile.new.applications') }}"
                       class="{{ request()->routeIs('student.profile.new.applications')
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Applications
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.profile.new.account') }}"
                       class="{{ request()->routeIs('student.profile.new.account')
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Account details
                    </a>
                </li>
            </ul>
        </nav>

        {{-- CONTENT: Applications --}}
        <div class="mt-6 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900">Your Applications</h2>

                <div class="mt-6">
                    {{-- Pending --}}
                    <h3 class="text-base font-semibold text-blue-600">Pending</h3>
                    @if(count($pending) === 0)
                        <p class="text-gray-500 mt-1">No pending applications.</p>
                    @else
                        <div class="mt-3 space-y-3">
                            @foreach($pending as $app)
                                <div class="p-3 border rounded-lg">
                                    <p class="font-semibold">{{ $app->title ?? 'Application' }}</p>
                                    <p class="text-sm text-gray-600">
                                        Submitted: {{ optional($app->created_at)->format('d M Y') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Accepted --}}
                    <h3 class="text-base font-semibold text-green-600 mt-6">Accepted</h3>
                    @if(count($accepted) === 0)
                        <p class="text-gray-500 mt-1">No accepted applications.</p>
                    @else
                        <div class="mt-3 space-y-3">
                            @foreach($accepted as $app)
                                <div class="p-3 border rounded-lg">
                                    <p class="font-semibold">{{ $app->title ?? 'Application' }}</p>
                                    <p class="text-sm text-gray-600">
                                        Decision date: {{ optional($app->updated_at)->format('d M Y') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Rejected --}}
                    <h3 class="text-base font-semibold text-red-600 mt-6">Rejected</h3>
                    @if(count($rejected) === 0)
                        <p class="text-gray-500 mt-1">No rejected applications.</p>
                    @else
                        <div class="mt-3 space-y-3">
                            @foreach($rejected as $app)
                                <div class="p-3 border rounded-lg">
                                    <p class="font-semibold">{{ $app->title ?? 'Application' }}</p>
                                    <p class="text-sm text-gray-600">
                                        Decision date: {{ optional($app->updated_at)->format('d M Y') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>