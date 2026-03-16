<x-admin.accounts>

<div class="p-6 bg-white shadow rounded-lg">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Group Applications</h2>

    {{-- SEARCH BAR --}}
    <form method="GET" class="mb-6 flex gap-2">
        <input name="q" value="{{ $term }}"
               placeholder="Search by student ID or listing address..."
               class="border px-3 py-2 rounded w-80">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
    </form>

    <table class="w-full text-left text-sm">
        <thead class="border-b font-semibold text-slate-700">
            <tr>
                <th class="py-2">Application ID</th>
                <th class="py-2">Group ID</th>
                <th class="py-2">Student IDs</th>
                <th class="py-2">Listing Address</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($results as $app)
                @php
                    $members = optional($app->group)->members ?? collect();
                    $idList = $members->pluck('id')->implode(', ');
                @endphp

                <tr class="border-b">
                    <td class="py-2">{{ $app->id }}</td>
                    <td class="py-2">{{ $app->group_id }}</td>

                    <td class="py-2">
                        {{ $idList ?: 'N/A' }}
                    </td>

                    <td class="py-2">
                        @if($app->rental)
                            {{ $app->rental->housenumber ? $app->rental->housenumber.' ' : '' }}
                            {{ $app->rental->street }}, {{ $app->rental->county }}
                        @else
                            N/A
                        @endif
                    </td>

                    <td class="py-2">
                        <a href="{{ route('admin.accounts.groupapplications.view', $app->id) }}"
                           class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                            View
                        </a>
                    </td>
                </tr>

            @empty
                <tr><td colspan="5" class="py-3 text-slate-500">No group applications found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $results->links() }}</div>

</div>

</x-admin.accounts>