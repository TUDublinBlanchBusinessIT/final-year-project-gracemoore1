<x-admin.accounts>
    <div class="p-6 bg-white shadow rounded-lg">

        <h2 class="text-lg font-semibold text-gray-900">Student Accounts</h2>

        <table class="mt-4 w-full text-left text-sm">
            <thead class="border-b font-semibold text-slate-700">
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Full Name</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">

                @foreach ($students as $s)
                    <tr class="border-b">

                        <td class="py-2">{{ $s->id }}</td>

                        <td class="py-2">
                            {{ $s->firstname }} {{ $s->surname }}
                        </td>

                        <td class="py-2">{{ $s->email }}</td>

                        <td class="py-2">
                            <a href="{{ route('admin.accounts.student.view', $s->id) }}"
                            class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                                View
                            </a>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
</x-admin.accounts>