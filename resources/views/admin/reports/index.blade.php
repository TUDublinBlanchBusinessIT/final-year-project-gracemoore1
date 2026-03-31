<x-admin.reports :activeTab="$activeTab">

    <div class="p-6 bg-white shadow rounded-lg">

        <h2 class="text-lg font-semibold text-gray-900 mb-4">
            Reports
        </h2>

        @if($reports->count() === 0)
            <p class="text-sm text-gray-600">No reports found.</p>
        @else
            <table class="w-full text-left text-sm">
                <thead class="border-b font-semibold text-slate-700">
                    <tr>
                        <th class="py-2">ID</th>
                        <th class="py-2">Preview</th>
                        <th class="py-2">Submitted</th>
                        <th class="py-2">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($reports as $r)
                        <tr class="border-b">
                            <td class="py-2">{{ $r->id }}</td>
                            <td class="py-2">{{ \Illuminate\Support\Str::limit($r->description, 60) }}</td>
                            <td class="py-2">
                                {{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y') }}
                            </td>
                            <td class="py-2">
                                <a href="{{ route('admin.reports.view', $r->id) }}"
                                   class="text-blue-600 hover:underline">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

</x-admin.reports>
