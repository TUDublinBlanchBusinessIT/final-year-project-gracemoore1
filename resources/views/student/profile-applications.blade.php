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
        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-100 border border-green-300 text-green-800">
                {{ session('success') }}
            </div>
        @endif
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
                                    {{-- PENDING --}}
                                        <h3 class="text-base font-semibold text-blue-600">Pending</h3>

                                        @if(count($pending) === 0)
                                            <p class="text-gray-500 mt-1">No pending applications.</p>
                                        @else
                                            <div class="mt-4 space-y-4">
                                                @foreach($pending as $app)
                                                    <div class="p-4 border rounded-lg bg-white shadow flex gap-4">

                                                        {{-- Rental Image --}}
                                                        {{ asset('uploads/' . $app->rental->image) }}

                                                        <div class="flex-1">
                                                            <div class="font-bold text-lg">
                                                                {{ $app->rental->street }}, {{ $app->rental->county }}
                                                            </div>

                                                            <div class="text-gray-700 text-sm mt-1">
                                                                <strong>House type:</strong> {{ $app->rental->housetype }} <br>
                                                                <strong>Nights per week:</strong> {{ $app->rental->nights }} <br>
                                                                <strong>Available from:</strong> {{ $app->rental->availablefrom }} <br>
                                                                <strong>Available to:</strong> {{ $app->rental->availableto }} <br>
                                                                <strong>Rent:</strong> €{{ $app->rental->rent }} per week
                                                            </div>

                                                            <div class="mt-2 inline-block px-2 py-1 rounded text-xs bg-yellow-200 text-yellow-800">
                                                                Pending
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
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