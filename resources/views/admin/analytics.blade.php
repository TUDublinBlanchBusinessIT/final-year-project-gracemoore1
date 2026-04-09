<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Account Analytics
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="max-w-6xl mx-auto px-4 py-6">

        <!-- Main Tabs -->
        <nav class="border-b border-slate-200">
            <ul class="flex gap-6 text-sm">
                <li>
                    <a href="{{ route('admin.analytics', ['tab' => 'applications']) }}"
                       class="{{ $tab === 'applications' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Applications
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.analytics', ['tab' => 'listings']) }}"
                       class="{{ $tab === 'listings' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Listings
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.analytics', ['tab' => 'complaints']) }}"
                       class="{{ $tab === 'complaints' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Complaints
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Complaints Sub-Tabs -->
        @if($tab === 'complaints')
        <nav class="border-b border-slate-200 mt-4">
            <ul class="flex gap-6 text-sm">
                <li>
                    <a href="{{ route('admin.analytics', ['tab' => 'complaints', 'complaint_tab' => 'subject']) }}"
                       class="{{ $complaintTab === 'subject' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        By Subject
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.analytics', ['tab' => 'complaints', 'complaint_tab' => 'county']) }}"
                       class="{{ $complaintTab === 'county' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        By County
                    </a>
                </li>
            </ul>
        </nav>
        @endif

        <!-- Chart Section -->
        <div class="mt-6 bg-white p-6 rounded-xl shadow">

            @if($tab === 'applications')
                <h3 class="text-lg font-semibold mb-4">Applications per County</h3>
                <canvas id="applicationsChart"></canvas>
            @elseif($tab === 'listings')
                <h3 class="text-lg font-semibold mb-4">Listings per County</h3>
                <canvas id="listingsChart"></canvas>
            @elseif($tab === 'complaints')
                <h3 class="text-lg font-semibold mb-4">
                    Complaints {{ $complaintTab === 'subject' ? 'by Subject' : 'by County' }}
                </h3>
                <canvas id="complaintsChart"></canvas>
            @endif
        </div>
    </div>

    <script>
        // Applications Chart
        @if(isset($applications) && $applications->count())
        if (document.getElementById('applicationsChart')) {
            new Chart(document.getElementById('applicationsChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($applications->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($applications->values()) !!},
                        backgroundColor: ['#4F46E5','#22C55E','#F59E0B','#EF4444','#6366F1','#10B981']
                    }]
                }
            });
        }
        @endif

        // Listings Chart
        @if(isset($listings) && $listings->count())
        if (document.getElementById('listingsChart')) {
            new Chart(document.getElementById('listingsChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($listings->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($listings->values()) !!},
                        backgroundColor: ['#6366F1','#10B981','#F59E0B','#F43F5E','#8B5CF6']
                    }]
                }
            });
        }
        @endif

        // Complaints Chart
        @if(isset($complaints) && $complaints->count())
        if (document.getElementById('complaintsChart')) {
            new Chart(document.getElementById('complaintsChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($complaints->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($complaints->values()) !!},
                        backgroundColor: ['#EF4444','#F97316','#6B7280','#3B82F6','#F59E0B']
                    }]
                }
            });
        }
        @endif
    </script>
</x-app-layout>