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
                        <a href="{{ route('landlord.messages.show', $application->id) }}"
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

                <div id="maintenanceContainer" class="px-8 py-6 bg-slate-50 min-h-[260px] max-h-[420px] overflow-y-auto">

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

                        <div class="flex justify-start mb-6">
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