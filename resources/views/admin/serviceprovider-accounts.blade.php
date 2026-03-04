<x-admin.accounts>
    <div class="p-6 bg-white shadow rounded-lg">

        <h2 class="text-lg font-semibold text-gray-900">Service Provider Accounts</h2>

        <table class="mt-4 w-full text-left text-sm">
            <thead class="border-b font-semibold text-slate-700">
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Full Name</th>
                    <th class="py-2">Company Name</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Created By (Admin)</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">

                @foreach ($providers as $p)

                    @php
                        $staff = \App\Models\Staff::find($p->administratorid);
                    @endphp

                    <tr class="border-b">

                        <td class="py-2">{{ $p->id }}</td>

                        <td class="py-2">
                            {{ $p->firstname }} {{ $p->surname }}
                        </td>

                        <td class="py-2">{{ $p->companyname }}</td>

                        <td class="py-2">{{ $p->email }}</td>

                        <td class="py-2">
                            @if ($staff)
                                {{ $staff->firstname }} {{ $staff->surname }}
                            @else
                                Unknown
                            @endif
                        </td>

                    </tr>

                @endforeach

            </tbody>
        </table>

    </div>
</x-admin.accounts>