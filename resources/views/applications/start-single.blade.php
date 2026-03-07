<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">
            Apply for {{ $listing->street }}, {{ $listing->county }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white shadow border rounded-xl p-6 mt-6">

        <h3 class="text-lg font-semibold mb-4">Single Application</h3>

        <form method="POST" action="{{ route('applications.submit.single', $listing->id) }}">
            @csrf

            {{-- Pre-filled Full Name --}}
            <div class="mb-4">
                <label class="font-semibold">Full Name</label>
                <input type="text" value="{{ auth()->user()->firstname }} {{ auth()->user()->surname }}"
                       class="w-full bg-slate-100 border rounded-lg px-3 py-2" disabled>
            </div>

            {{-- Pre-filled Email --}}
            <div class="mb-4">
                <label class="font-semibold">Email</label>
                <input type="text" value="{{ auth()->user()->email }}"
                       class="w-full bg-slate-100 border rounded-lg px-3 py-2" disabled>
            </div>

            {{-- Hidden application type --}}
            <input type="hidden" name="applicationtype" value="single">

            {{-- Age --}}
            <div class="mb-4">
                <label class="font-semibold">Age</label>
                <input type="number" name="age"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            {{-- Gender --}}
            <div class="mb-4">
                <label class="font-semibold">Gender</label>
                <select name="gender" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">Select...</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="nonbinary">Non-binary</option>
                    <option value="prefer_not_say">Prefer not to say</option>
                </select>
            </div>

            {{-- Additional Details --}}
            <div class="mb-4">
                <label class="font-semibold">Additional Details (optional)</label>
                <textarea name="additional_details"
                          class="w-full border rounded-lg px-3 py-2"
                          rows="4"></textarea>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold">
                Submit Application
            </button>

        </form>

    </div>

</x-app-layout>