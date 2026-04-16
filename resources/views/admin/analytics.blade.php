<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Account Analytics
        </h2>
    </x-slot>

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
                    <a href="{{ route('admin.analytics', ['tab' => 'complaints', 'complaint_tab' => 'reported']) }}"
                       class="{{ $complaintTab === 'reported' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Who Is Being Reported
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.analytics', ['tab' => 'complaints', 'complaint_tab' => 'reporter']) }}"
                       class="{{ $complaintTab === 'reporter' ? 'text-slate-900 font-semibold border-b-2 border-slate-900' : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Who Is Reporting
                    </a>
                </li>
            </ul>
        </nav>
        @endif

        <!-- Table Section -->
        <div class="mt-6 bg-white p-6 rounded-xl shadow">

            @if($tab === 'applications')
                <h3 class="text-lg font-semibold mb-4">Applications per County</h3>
                <table class="w-full text-left text-sm">
                    <thead class="border-b font-semibold text-slate-700">
                        <tr>
                            <th class="py-2">County</th>
                            <th class="py-2">Total Applications</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $county => $total)
                            <tr class="border-b hover:bg-slate-50">
                                <td class="py-2">{{ $county ?: 'Unknown' }}</td>
                                <td class="py-2">{{ $total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-slate-500">No data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            @elseif($tab === 'listings')
                <h3 class="text-lg font-semibold mb-4">Listings per County</h3>
                <table class="w-full text-left text-sm">
                    <thead class="border-b font-semibold text-slate-700">
                        <tr>
                            <th class="py-2">County</th>
                            <th class="py-2">Total Listings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listings as $county => $total)
                            <tr class="border-b hover:bg-slate-50">
                                <td class="py-2">{{ $county ?: 'Unknown' }}</td>
                                <td class="py-2">{{ $total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-slate-500">No data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            @elseif($tab === 'complaints')
                <h3 class="text-lg font-semibold mb-4">
                    {{ $complaintTab === 'reported' ? 'Who Is Being Reported' : 'Who Is Reporting' }}
                </h3>
                <table class="w-full text-left text-sm">
                    <thead class="border-b font-semibold text-slate-700">
                        <tr>
                            <th class="py-2">Role</th>
                            <th class="py-2">Total Complaints</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $role => $total)
                            <tr class="border-b hover:bg-slate-50">
                                <td class="py-2">{{ ucfirst($role) }}</td>
                                <td class="py-2">{{ $total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-slate-500">No data available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif

        </div>
    </div>

</x-app-layout>