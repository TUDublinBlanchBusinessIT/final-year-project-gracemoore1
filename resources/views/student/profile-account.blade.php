<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 py-8">
        {{-- Profile heading --}}
        <h1 class="text-2xl font-bold text-slate-900">Profile</h1>

        {{-- Sub-nav: text links side-by-side, underline active --}}
        <nav class="mt-3 border-b border-slate-200">
            <ul class="flex gap-6 text-sm">
                <li>
                    <a href="{{ route('student.profile.new.applications') }}"
                       class="{{ request()->routeIs('student.profile.new.applications')
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Applications
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.profile.new.account') }}"
                       class="{{ request()->routeIs('student.profile.new.account')
                            ? 'text-slate-900 font-semibold border-b-2 border-slate-900'
                            : 'text-slate-600 border-b-2 border-transparent hover:text-slate-900 hover:border-slate-300' }}">
                        Account details
                    </a>
                </li>
            </ul>
        </nav>

        {{-- CONTENT: Account details (landlord-style cards, only specified fields) --}}
        <div class="mt-6 space-y-6">
            {{-- Read-only details --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900">Account details</h2>
                <div class="mt-6 space-y-2 text-gray-800">
                    <p><strong>Firstname:</strong> {{ $student->firstname }}</p>
                    <p><strong>Surname:</strong> {{ $student->surname }}</p>
                    <p><strong>Email:</strong> {{ $student->email }}</p>
                    <p><strong>Date of Birth:</strong> {{ $student->dateofbirth }}</p>
                </div>
            </div>

            {{-- Update password --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Update Password</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Ensure your account is using a long, random password to stay secure.
                </p>

                <form method="post" action="{{ route('student.profile.new.resetpassword') }}" class="mt-6 space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="mt-1 block w-full border border-slate-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="mt-1 block w-full border border-slate-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-md hover:bg-slate-800 font-semibold">
                            Save
                        </button>

                        @if (session('status') === 'password-updated')
                            <p class="text-sm text-gray-600">Saved.</p>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Delete account --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900">Delete Account</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Once your account is deleted, all of its resources and data will be permanently deleted.
                    Before deleting your account, please download any data or information that you wish to retain.
                </p>

                <form method="post" action="{{ route('student.profile.new.delete') }}" class="mt-6">
                    @csrf
                    @method('delete')

                    <button type="submit"
                            onclick="return confirm('Are you sure? This cannot be undone.')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>