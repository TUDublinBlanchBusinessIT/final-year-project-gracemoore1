<x-app-layout>
    <div class="bg-white p-6 rounded-xl shadow-sm max-w-2xl mx-auto">

        <h2 class="text-2xl font-bold text-slate-900">Student Profile</h2>

        <div class="mt-6 grid grid-cols-1 gap-4">

            <!-- Applications -->
            <a href="{{ route('student.profile.new.applications') }}"
               class="block bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700">
                Applications
            </a>

            <!-- Account Details -->
            <a href="{{ route('student.profile.new.account') }}"
               class="block bg-gray-800 text-white text-center py-3 rounded-lg font-semibold hover:bg-gray-900">
                Account Details
            </a>

        </div>

    </div>
</x-app-layout>