@php use Illuminate\Support\Facades\Storage; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">
            Maintenance Log
        </h2>
    </x-slot>

    <div class="pb-20 lg:pl-70">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-slate-200 overflow-hidden">

                <div class="border-b border-slate-200 px-8 py-5 bg-white">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('student.messages.show', $application->id) }}"
                           class="text-slate-500 hover:text-slate-700 text-xl">
                            ←
                        </a>

                        <div class="h-14 w-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 text-2xl font-semibold">
                            M
                        </div>

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

                <div class="px-8 py-6 bg-slate-50 min-h-[260px] max-h-[420px] overflow-y-auto">
                    @if(session('success'))
                        <div class="mb-6 rounded-xl bg-green-100 text-green-800 px-4 py-3">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse($logs as $log)
                        <div class="flex justify-end mb-6">
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
                                    {{ optional($log->timestamp)->format('H:i') ?? optional($log->created_at)->format('H:i') }}
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
</x-app-layout>