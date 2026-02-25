<x-app-layout>
    <div class="bg-white p-6 rounded-xl shadow-sm max-w-3xl mx-auto">

        <h2 class="text-2xl font-bold text-slate-900">Your Applications</h2>

        <!-- Pending -->
        <h3 class="text-xl font-semibold text-blue-600 mt-6">Pending</h3>
        @if(count($pending) == 0)
            <p class="text-gray-500">No pending applications.</p>
        @endif

        <!-- Accepted -->
        <h3 class="text-xl font-semibold text-green-600 mt-6">Accepted</h3>
        @if(count($accepted) == 0)
            <p class="text-gray-500">No accepted applications.</p>
        @endif

        <!-- Rejected -->
        <h3 class="text-xl font-semibold text-red-600 mt-6">Rejected</h3>
        @if(count($rejected) == 0)
            <p class="text-gray-500">No rejected applications.</p>
        @endif

    </div>
</x-app-layout>