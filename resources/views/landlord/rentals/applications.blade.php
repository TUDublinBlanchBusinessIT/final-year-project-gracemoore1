<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Applications
        </h2>
    </x-slot>

    <div class="pb-28 lg:pl-70">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">

                {{-- Flash success --}}
                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-lg border border-green-300 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- SMALLER TITLE --}}
                <h1 class="text-base font-semibold text-slate-700 mb-6">
                    <a href="{{ route('landlord.dashboard') }}"
                        class="text-gray-600 hover:text-black text-lg">
                        ←
                    </a>
                    Applications for
                    <span class="font-bold text-slate-900">
                        {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                        {{ $rental->street }}, {{ $rental->county }}
                    </span>
                </h1>

                @if($applications->isEmpty())
                    <p class="text-sm text-gray-600">No applications yet.</p>
                @else

                    <div class="space-y-5">

                        @foreach($applications as $app)
                            <div class="p-5 bg-white border rounded-xl shadow">

                                {{-- Student --}}
                                <h3 class="text-sm font-semibold text-slate-900">
                                    {{ $app->student->firstname }} {{ $app->student->surname }}
                                </h3>

                                <p class="text-xs text-slate-500 mb-3">
                                    Applied: {{ \Carbon\Carbon::parse($app->dateapplied)->format('d M Y') }}
                                </p>

                                {{-- Application details --}}
                                <div class="mt-2 space-y-1 text-sm text-slate-700">

                                    <p><span class="font-medium">Application Type:</span> {{ ucfirst($app->applicationtype) }}</p>

                                    @if($app->applicationtype === 'single')
                                        <p><span class="font-medium">Age:</span> {{ $app->age }}</p>
                                        <p><span class="font-medium">Gender:</span> {{ ucfirst($app->gender) }}</p>
                                    @endif

                                    @if($app->additional_details)
                                        <p><span class="font-medium">Additional Info:</span> {{ $app->additional_details }}</p>
                                    @endif

                                    @if($app->applicationtype === 'group' && $app->group)
                                        <div class="mt-1">
                                            <p class="font-medium">Group Members:</p>
                                            <ul class="ml-5 list-disc text-sm">
                                                @foreach($app->group->members as $m)
                                                    <li>
                                                        {{ $m->firstname }} {{ $m->surname }}
                                                        (ID: {{ $m->id }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                </div>

                                {{-- STATUS --}}
                                <div class="mt-3 flex items-center justify-between">

                                    {{-- STATUS LABEL --}}
                                    <span class="px-2 py-1 rounded text-[11px] bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>

                                    {{-- BUTTONS: Accept / Reject --}}
                                    <div class="flex gap-2">

                                        {{-- Reject --}}
                                        <form action="{{ route('landlord.applications.reject', $app->id) }}" method="POST">
                                            @csrf
                                            <button 
                                                class="px-3 py-1 rounded bg-red-600 text-white text-xs hover:bg-red-700">
                                                Reject
                                            </button>
                                        </form>

                                        {{-- Accept --}}
                                        <form action="{{ route('landlord.applications.accept', $app->id) }}" method="POST">
                                            @csrf
                                            <button 
                                                class="px-3 py-1 rounded bg-green-600 text-white text-xs hover:bg-green-700">
                                                Accept
                                            </button>
                                        </form>

                                        <a href="{{ route('landlord.messages.show', $app->id) }}"
                                            class="px-3 py-1 rounded bg-blue-600 text-white text-xs hover:bg-blue-700">
                                            Message Student
                                        </a>

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                @endif

            </div>
        </div>

    </div>

</x-app-layout>