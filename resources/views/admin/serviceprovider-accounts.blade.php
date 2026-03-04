<x-admin.accounts>
    <div class="p-6 bg-white shadow rounded-lg">
        <h2 class="text-lg font-semibold text-gray-900">Service Provider Accounts</h2>

        <table class="mt-4 w-full text-left text-sm">
            <thead class="border-b font-semibold text-slate-700">
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($providers as $p)
                    <tr class="border-b">
                        <td>{{ $p->id }}</td>
                        <td>{{ $p->firstname }} {{ $p->surname }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin.accounts>