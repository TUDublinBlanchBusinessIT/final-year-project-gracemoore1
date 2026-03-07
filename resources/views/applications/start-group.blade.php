<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">
            Group Application – {{ $rental->street }}, {{ $rental->county }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded-xl shadow">

        <h3 class="text-lg font-semibold mb-4">Group Application Form</h3>

        <form method="POST" action="{{ route('applications.submit.group', $rental->id) }}">
            @csrf

            <div id="tenant-container" class="space-y-6">

                {{-- Tenant 1 (auto-filled) --}}
                <div class="tenant-card p-4 border rounded-lg bg-slate-50">
                    <h4 class="font-semibold mb-2">Tenant 1 (You)</h4>

                    {{-- Hidden values passed --}}
                    <input type="hidden" name="tenants[0][full_name]"
                           value="{{ $student->firstname }} {{ $student->surname }}">

                    <input type="hidden" name="tenants[0][email]"
                           value="{{ $student->email }}">

                    {{-- Display full name --}}
                    <label class="block mb-1 font-medium">Full Name</label>
                    <input type="text"
                           class="w-full bg-slate-100 rounded-lg px-3 py-2"
                           value="{{ $student->firstname }} {{ $student->surname }}"
                           disabled>

                    {{-- Display email --}}
                    <label class="block mt-3 mb-1 font-medium">Email</label>
                    <input type="email"
                           class="w-full bg-slate-100 rounded-lg px-3 py-2"
                           value="{{ $student->email }}"
                           disabled>

                    {{-- Age --}}
                    <label class="block mt-3 mb-1 font-medium">Age</label>
                    <input name="tenants[0][age]" type="number" required
                           class="w-full border rounded-lg px-3 py-2">

                    {{-- Gender --}}
                    font-medium">Gender</label>
                    <select name="tenants[0][gender]" required
                            class="w-full border rounded-lg px-3 py-2">
                        <option value="">Select…</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="nonbinary">Non-binary</option>
                        <option value="prefer_not_say">Prefer not to say</option>
                    </select>
                </div>

            </div>

            {{-- Add tenant button --}}
            <button type="button"
                    onclick="addTenant()"
                    class="mt-4 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                + Add Another Tenant
            </button>

            {{-- Additional details --}}
            <div class="mt-6">
                <label class="block font-medium mb-1">Additional Details (optional)</label>
                <textarea name="additional_details" rows="4"
                          class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>

            {{-- Submit button --}}
            <button type="submit"
                    class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">
                Submit Group Application
            </button>

        </form>
    </div>

    <script>
        let tenantIndex = 1;

        function addTenant() {
            if (tenantIndex >= 6) {
                alert("You can add up to 6 tenants only.");
                return;
            }

            const container = document.getElementById('tenant-container');

            const card = document.createElement('div');
            card.className = "tenant-card p-4 border rounded-lg bg-white";

            card.innerHTML = `
                <h4 class="font-semibold mb-2">Tenant ${tenantIndex + 1}</h4>

                <label class="block mb-1 font-medium">Full Name</label>
                <input name="tenants[${tenantIndex}][full_name]" required
                       class="w-full border rounded-lg px-3 py-2">

                <label class="block mt-3 mb-1 font-medium">Email</label>
                <input name="tenants[${tenantIndex}][email]" type="email" required
                       class="w-full border rounded-lg px-3 py-2">

                <label class="block mt-3 mb-1 font-medium">Age</label>
                <input name="tenants[${tenantIndex}][age]" type="number" required
                       class="w-full border rounded-lg px-3 py-2">

                <label class="block mt-3 mb-1 font-medium">Gender</label>
                <select name="tenants[${tenantIndex}][gender]" required
                        class="w-full border rounded-lg px-3 py-2">
                    <option value="">Select…</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="nonbinary">Non-binary</option>
                    <option value="prefer_not_say">Prefer not to say</option>
                </select>
            `;

            container.appendChild(card);

            tenantIndex++;
        }
    </script>
</x-app-layout>