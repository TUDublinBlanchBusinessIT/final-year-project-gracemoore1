<x-app-layout>

    <x-slot name="header">
        <div class="flex items-start justify-start">
            <div class="text-left">
                <div class="text-2xl font-extrabold text-blue-600 leading-none">
                    RentConnect
                </div>
                <div class="mt-1 font-semibold text-gray-800">
                    Service Provider Profile
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 py-8 space-y-6">

        {{-- Account Details --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h2 class="text-lg font-medium text-gray-900">Account Details</h2>

            <div class="mt-6 space-y-2 text-gray-800">
                <p><strong>Full Name:</strong> {{ $provider->firstname }} {{ $provider->surname }}</p>
                <p><strong>Company Name:</strong> {{ $provider->companyname }}</p>
                <p><strong>Email:</strong> {{ $provider->email }}</p>
                <p><strong>Phone Number:</strong> {{ $provider->phone }}</p>
                <p><strong>County:</strong> {{ $provider->county }}</p>

                @if($provider->commissionperjob !== null)
                    <p>
                        <strong>Commission per Job:</strong>
                        {{ rtrim(rtrim(number_format($provider->commissionperjob, 2), '0'), '.') }}%
                    </p>
                @else
                    <p>
                        <strong>Monthly Partnership Fee:</strong>
                        €{{ number_format($provider->feepermonth, 2) }}
                    </p>
                @endif

                <p>
                    <strong>Account Created:</strong>
                    {{ $provider->created_at->format('d M Y') }}
                </p>
            </div>
        </div>

        {{-- Update Password --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h3 class="text-lg font-medium text-gray-900">Update Password</h3>
            <p class="mt-1 text-sm text-gray-600">
                Enter your current password and choose a new one.
            </p>

            <form method="POST"
                  action="{{ route('serviceprovider.profile.resetpassword') }}"
                  class="mt-6 space-y-4">
                @csrf

                {{-- Current Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Current Password
                    </label>
                    <input type="password"
                           name="current_password"
                           required
                           class="mt-1 block w-full border border-slate-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        New Password
                    </label>
                    <input type="password"
                           name="password"
                           required
                           class="mt-1 block w-full border border-slate-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Confirm New Password
                    </label>
                    <input type="password"
                           name="password_confirmation"
                           required
                           class="mt-1 block w-full border border-slate-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <div class="flex items-center gap-4">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-md hover:bg-slate-800 font-semibold">
                        Save
                    </button>

                    @if(session('status') === 'password-updated')
                        <p class="text-sm text-green-700">Password updated.</p>
                    @endif
                </div>

            </form>
        </div>

        <div class="border-t border-slate-200 pt-6 mt-10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <div class="flex justify-center">
                    <button
                        type="submit"
                        class="rounded-md bg-blue-600 px-6 py-2
                            text-sm font-semibold text-white
                            hover:bg-blue-700 transition">
                        Log out
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>