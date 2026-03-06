<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Applications
        </h2>
    </x-slot>

    <div class="pb-28 lg:pl-70">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-8 text-gray-900">

                <h1 class="text-3xl font-bold text-blue-600 mb-4">
                    Applications for
                    {{ $rental->housenumber ? $rental->housenumber . ' ' : '' }}
                    {{ $rental->street }}, {{ $rental->county }}
                </h1>

                <p class="text-gray-700 text-lg">
                    No applications yet.
                </p>

            </div>
        </div>

    </div>

</x-app-layout>