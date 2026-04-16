<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">
            Group Application – {{ $rental->street }}, {{ $rental->county }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded-xl shadow">
        <a href="{{ url()->previous() }}" class="inline-block mb-4 text-slate-500 hover:text-slate-700 text-sm">← Back</a>
        <h3 class="text-lg font-semibold mb-4">Group Application</h3>

        {{-- ✅ REAL FORM TAG HERE --}}
        <form method="POST" action="{{ route('applications.submit.group', $rental->id) }}">
            @csrf

            {{-- Mode --}}
            <div class="mb-4">
                <label class="font-semibold">Choose a group</label>
                <select id="mode-select" name="mode" class="w-full border rounded-lg px-3 py-2" onchange="toggleMode()">
                    <option value="existing">Use existing group</option>
                    <option value="new">Create new group</option>
                </select>
            </div>

            {{-- Existing groups --}}
            <div id="existing-group-section">
                <label class="block mb-1 font-medium">Existing groups</label>
                <select name="existing_group_id" class="w-full border rounded-lg px-3 py-2">
                    @forelse($existingGroups as $g)
                        @php
                            $label = $g->members->map(fn($m) => trim($m->firstname.' '.$m->surname))->implode(', ');
                        @endphp
                        <option value="{{ $g->id }}">{{ $label }}</option>
                    @empty
                        <option value="">No saved groups yet</option>
                    @endforelse
                </select>
            </div>

            {{-- New group --}}
            <div id="new-group-section" class="hidden">
                {{-- Tenant 1 (You) --}}
                <div class="tenant-card p-4 border rounded-lg bg-slate-50">
                    <h4 class="font-semibold mb-2">Tenant 1 (You)</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1 font-medium">Full Name</label>
                            <input type="text" class="w-full bg-slate-100 rounded-lg px-3 py-2"
                                   value="{{ $student->firstname }} {{ $student->surname }}" disabled>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Email</label>
                            <input type="email" class="w-full bg-slate-100 rounded-lg px-3 py-2"
                                   value="{{ $student->email }}" disabled>
                        </div>
                    </div>

                    <p class="text-xs text-slate-500 mt-2">
                        You will be added as the group leader automatically.
                    </p>
                </div>

                <div id="tenant-container" class="space-y-6 mt-4"></div>

                <button type="button" onclick="addTenant()"
                        class="mt-4 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                    + Add Another Tenant
                </button>
            </div>

            {{-- Additional details --}}
            <div class="mt-6">
                <label class="block font-medium mb-1">Additional Details (optional)</label>
                <textarea name="additional_details" rows="4" class="w-full border rounded-lg px-3 py-2"></textarea>
            </div>

            <button type="submit"
                    class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">
                Submit Group Application
            </button>
        </form>
    </div>

    <script>
        let tenantIndex = 0;

        function toggleMode() {
            const mode = document.getElementById('mode-select').value;
            document.getElementById('existing-group-section').classList.toggle('hidden', mode !== 'existing');
            document.getElementById('new-group-section').classList.toggle('hidden', mode !== 'new');
        }

        function addTenant() {
            if (tenantIndex >= 5) { // 5 extra (you + 5 = 6)
                alert("You can add up to 6 tenants total (including you).");
                return;
            }
            const container = document.getElementById('tenant-container');
            const card = document.createElement('div');
            card.className = "tenant-card p-4 border rounded-lg bg-white";

            card.innerHTML = `
                <h4 class="font-semibold mb-2">Additional Member ${tenantIndex + 1}</h4>

                <label class="block mb-1 font-medium">Full Name</label>
                <input name="tenants[${tenantIndex}][full_name]" required class="w-full border rounded-lg px-3 py-2">

                <label class="block mt-3 mb-1 font-medium">Email</label>
                <input name="tenants[${tenantIndex}][email]" type="email" required class="w-full border rounded-lg px-3 py-2">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                    <div>
                        <label class="block mb-1 font-medium">Age</label>
                        <input name="tenants[${tenantIndex}][age]" type="number" required class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block mb-1 font-medium">Gender</label>
                        <select name="tenants[${tenantIndex}][gender]" required class="w-full border rounded-lg px-3 py-2">
                            <option value="">Select…</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="nonbinary">Non-binary</option>
                            <option value="prefer_not_say">Prefer not to say</option>
                        </select>
                    </div>
                </div>
            `;
            container.appendChild(card);
            tenantIndex++;
        }

        document.addEventListener('DOMContentLoaded', toggleMode);
    </script>
</x-app-layout>