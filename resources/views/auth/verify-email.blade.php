<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Thanks for signing up to RentConnect! Please check your email and click the verification link before continuing.
    </div>

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                Resend Verification Email
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                Log out
            </button>
        </form>
    </div>
</x-guest-layout>
