<x-app-layout>
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <div class="flex items-center gap-4">
                <a href="{{ route('landlord.messages.show', $application->id) }}"
                    class="text-slate-500 hover:text-slate-700 text-xl transition">
                    ←
                </a>

                <p class="text-sm font-semibold uppercase tracking-[0.12em] text-blue-600">
                    Messages <span class="mx-1 text-slate-300">/</span> Maintenance Log
                </p>
            </div>
        </div>
    </x-slot>

    <div class="pb-20 lg:pl-70">
        <div class="max-w-5xl mx-auto">

            @if(session('success'))
                <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <div class="border-b border-slate-200 px-8 py-5 bg-white">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('landlord.messages.show', $application->id) }}"
                           class="text-slate-500 hover:text-slate-700 text-xl">
                            
                        </a>

                        

                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">
                                Maintenance Tracker
                            </h3>
                            <p class="text-slate-500 text-base">
                                {{ $application->rental->housenumber ?? '' }}
                                {{ $application->rental->street ?? '' }},
                                {{ $application->rental->county ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div id="maintenanceContainer" class="px-8 py-6 bg-slate-50 min-h-[260px] max-h-[520px] overflow-y-auto">

                    @php
                        $lastDate = null;
                    @endphp

                    @forelse($logs as $log)

                        @php
                            $logDate = optional($log->timestamp)->format('d M Y')
                                ?? optional($log->created_at)->format('d M Y');
                        @endphp

                        @if($lastDate !== $logDate)
                            <div class="flex justify-center my-4">
                                <span class="px-4 py-1 rounded-full bg-slate-200 text-slate-600 text-xs">
                                    {{ $logDate }}
                                </span>
                            </div>
                            @php
                                $lastDate = $logDate;
                            @endphp
                        @endif

                        <div class="mb-8 space-y-4">

                            <div class="flex justify-start">
                                <div class="max-w-md rounded-3xl px-6 py-5 shadow-sm
                                    @if($log->priority === 'high') bg-red-500 text-white
                                    @elseif($log->priority === 'medium') bg-orange-400 text-white
                                    @else bg-green-500 text-white
                                    @endif">

                                    <div class="text-sm font-semibold uppercase tracking-wide mb-2">
                                        {{ $log->priority }} priority
                                    </div>

                                    <div class="text-lg font-semibold mb-2">
                                        Maintenance Issue
                                    </div>

                                    <div class="text-sm leading-6">
                                        {{ $log->description }}
                                    </div>

                                    @if(!empty($log->images))
                                        <div class="mt-3">
                                            <a href="{{ asset('storage/' . $log->images) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $log->images) }}"
                                                     alt="Maintenance issue image"
                                                     class="block mt-3 rounded-xl max-h-40 w-auto object-cover border border-white/20 shadow-sm cursor-pointer">
                                            </a>
                                        </div>
                                    @endif

                                    <div class="text-xs mt-4 opacity-90">
                                        {{ optional($log->timestamp)->format('d M Y H:i')
                                            ?? optional($log->created_at)->format('d M Y H:i') }}
                                    </div>
                                </div>
                            </div>

                            @if(!empty($log->landlord_note) || !empty($log->landlord_image))
                                <div class="flex justify-end">
                                    <div class="max-w-md rounded-3xl bg-white border border-slate-200 px-6 py-5 shadow-sm">
                                        <div class="flex items-center justify-between gap-3 mb-3">
                                            <h4 class="text-sm font-semibold text-slate-900">
                                                Landlord Update
                                            </h4>

                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                                @if($log->status === 'resolved') bg-green-100 text-green-700
                                                @elseif($log->status === 'in_progress') bg-blue-100 text-blue-700
                                                @else bg-yellow-100 text-yellow-700
                                                @endif">
                                                {{ $log->status === 'in_progress' ? 'In Progress' : ucfirst($log->status) }}
                                            </span>
                                        </div>

                                        @if(!empty($log->landlord_note))
                                            <p class="text-sm text-slate-700 leading-6">
                                                {{ $log->landlord_note }}
                                            </p>
                                        @endif

                                        @if(!empty($log->landlord_image))
                                            <div class="mt-3">
                                                <a href="{{ asset('storage/' . $log->landlord_image) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $log->landlord_image) }}"
                                                         alt="Landlord update image"
                                                         class="rounded-xl max-h-40 w-auto object-cover border border-slate-200 shadow-sm cursor-pointer">
                                                </a>
                                            </div>
                                        @endif

                                        <p class="text-xs text-slate-400 mt-3">
                                            Last updated: {{ optional($log->updated_at)->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if($log->status !== 'resolved')
                                <div class="border-t border-slate-200 pt-4">

                                    <div class="mb-4">
                                        @if(in_array($log->id, $requestedLogIds ?? []))
                                            <button
                                                type="button"
                                                disabled
                                                class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-100 text-slate-500 border border-slate-200 cursor-not-allowed"
                                            >
                                                Service Provider Requested
                                            </button>
                                        @else
                                            <a
                                                href="{{ route('landlord.service-request.create', $log->id) }}"
                                                class="inline-flex items-center px-4 py-2 rounded-xl bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 transition"
                                            >
                                                Book Service Provider
                                            </a>
                                        @endif
                                    </div>

                                    <form action="{{ route('landlord.maintenance-log.update', [$application->id, $log->id]) }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">

                                            <div class="lg:col-span-7">
                                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                                    Add update for student
                                                </label>

                                                <textarea
                                                    name="landlord_note"
                                                    rows="3"
                                                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                    placeholder="Example: I will come by this evening and get this fixed."
                                                >{{ old('landlord_note', $log->landlord_note) }}</textarea>
                                            </div>

                                            <div class="lg:col-span-3">
                                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                                    Issue Status
                                                </label>

                                                <select
                                                    name="status"
                                                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                    <option value="pending" {{ $log->status === 'pending' ? 'selected' : '' }}>
                                                        Pending
                                                    </option>

                                                    <option value="in_progress" {{ $log->status === 'in_progress' ? 'selected' : '' }}>
                                                        In Progress
                                                    </option>

                                                    <option value="resolved" {{ $log->status === 'resolved' ? 'selected' : '' }}>
                                                        Resolved
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="lg:col-span-3">
                                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                                    Add image
                                                </label>

                                                <input
                                                    type="file"
                                                    name="landlord_image"
                                                    accept="image/*"
                                                    class="block w-full text-sm text-slate-600
                                                        file:mr-3 file:py-2 file:px-4
                                                        file:rounded-xl file:border-0
                                                        file:text-sm file:font-medium
                                                        file:bg-slate-100 file:text-slate-700
                                                        hover:file:bg-slate-200"
                                                >
                                            </div>

                                            <div class="lg:col-span-2">
                                                <button
                                                    type="submit"
                                                    class="w-full inline-flex items-center justify-center rounded-2xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700 transition">
                                                    Save
                                                </button>
                                            </div>

                                        </div>

                                        @error('landlord_note')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror

                                        @error('status')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror

                                        @error('landlord_image')
                                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                        @enderror

                                    </form>
                                </div>
                            @endif

                        </div>

                    @empty
                        <div class="flex flex-col items-center justify-center text-center text-slate-400 py-12">
                            <div class="text-4xl mb-3">🛠</div>
                            <p class="text-base font-medium text-slate-500">No maintenance issues logged yet</p>
                            <p class="text-sm text-slate-400 mt-1">Any issues submitted by the student will appear here.</p>
                        </div>
                    @endforelse

                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const container = document.getElementById("maintenanceContainer");
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</x-app-layout>