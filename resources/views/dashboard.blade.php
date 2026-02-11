<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">

                    <h1 class="text-3xl font-bold text-blue-600 mb-4">
                        Welcome back, {{ Auth::user()->name }}!
                    </h1>

                    <p class="text-gray-700 text-lg">
                        This is your dashboard.  
                        You can manage your account, update your profile, and access new features as they’re added.
                    </p>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>
