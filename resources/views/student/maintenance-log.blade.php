@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="border-b border-slate-200 px-6 py-3 bg-white">
            <div class="flex items-center gap-4">
                <a href="{{ route('student.messages.show', $application->id) }}"
                    class="flex items-center justify-center w-9 h-9 rounded-full text-slate-500 hover:text-blue-600 hover:bg-slate-100 text-xl transition">
                    ←
                </a>

                <p class="text-lg font-bold uppercase tracking-[0.16em] text-blue-700">
                    Messages <span class="mx-1 text-slate-300">/</span> Maintenance Log
                </p>
            </div>
        </div>
    </x-slot>

    <div class="pb-20 lg:pl-70">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">
                <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                    <div class="px-6 py-3 bg-white border-b border-slate-200">
                        <div class="flex items-center gap-4">
                            <div class="min-w-0">
                                <h3 class="text-lg font-semibold text-slate-900 truncate">
                                    {{ $application->rental->landlord->firstname ?? 'Landlord' }}
                                    {{ $application->rental->landlord->surname ?? '' }}
                                </h3>

                                <p class="text-sm text-slate-500 truncate mt-1">
                                    {{ $application->rental->housenumber ?? '' }}
                                    {{ $application->rental->street ?? '' }},
                                    {{ $application->rental->county ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                

                <div id="maintenanceContainer" class="px-8 py-6 bg-slate-50 min-h-[200px] max-h-[420px] overflow-y-auto">
                    @if(session('success'))
                        <div class="mb-6 rounded-xl bg-green-100 text-green-800 px-4 py-3">
                            {{ session('success') }}
                        </div>
                    @endif

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
                            <div class="flex justify-end">
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
                                                     class="mt-3 rounded-xl max-h-40 w-auto object-cover border border-white/20 shadow-sm cursor-pointer">
                                            </a>
                                        </div>
                                    @endif

                                    <div class="text-xs mt-4 opacity-90">
                                        {{ optional($log->timestamp)->format('d M Y H:i')
                                            ?? optional($log->created_at)->format('d M Y H:i') }}
                                    </div>
                                </div>
                            </div>

                           <div class="flex justify-start">
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

                                    @if(!empty($log->landlord_note) || !empty($log->landlord_image))
                                        <p class="text-xs text-slate-400 mt-3">
                                            Last updated: {{ optional($log->updated_at)->format('d M Y H:i') }}
                                        </p>
                                    @else
                                        <p class="text-sm text-slate-400">
                                            No landlord update yet.
                                        </p>
                                    @endif
                                </div>
                            </div> 
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center text-center text-slate-400 py-12">
                            <div class="text-4xl mb-3">🛠</div>
                            <p class="text-base font-medium text-slate-500">No maintenance issues logged yet</p>
                            <p class="text-sm text-slate-400 mt-1">Submit an issue below and it will appear here.</p>
                        </div>
                    @endforelse
                </div>

                <div class="border-t border-slate-200 bg-white px-8 py-6">
                    <form method="POST" action="{{ route('student.maintenance-log.store', $application->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-end">

                            <div class="lg:col-span-7">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Describe the issue
                                </label>
                                <textarea
                                    name="description"
                                    rows="3"
                                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Example: There is a leak under the kitchen sink."
                                >{{ old('description') }}</textarea>

                                @error('description')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="lg:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Priority
                                </label>
                                <select
                                    name="priority"
                                    class="w-full rounded-2xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Select</option>
                                    <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>🔴 High</option>
                                    <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>🟠 Medium</option>
                                    <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>🟢 Low</option>
                                </select>

                                @error('priority')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="lg:col-span-3">
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    Add image
                                </label>
                                <input
                                    type="file"
                                    name="image"
                                    accept="image/*"
                                    class="block w-full text-sm text-slate-600
                                           file:mr-3 file:py-2 file:px-4
                                           file:rounded-xl file:border-0
                                           file:text-sm file:font-medium
                                           file:bg-slate-100 file:text-slate-700
                                           hover:file:bg-slate-200"
                                >

                                @error('image')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 flex justify-end">
                            <button
                                type="submit"
                                class="inline-flex items-center rounded-2xl bg-blue-600 px-6 py-3 text-white font-semibold hover:bg-blue-700 transition">
                                Save Maintenance Issue
                            </button>
                        </div>
                    </form>
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