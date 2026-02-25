<x-app-layout>
    <div class="bg-white p-6 rounded-xl shadow-sm max-w-xl mx-auto">

        <h2 class="text-2xl font-bold text-slate-900">Account Details</h2>

        <div class="mt-4 space-y-2 text-gray-800">
            <p><strong>Firstname:</strong> {{ $student->firstname }}</p>
            <p><strong>Surname:</strong> {{ $student->surname }}</p>
            <p><strong>Email:</strong> {{ $student->email }}</p>
            <p><strong>Date of Birth:</strong> {{ $student->dateofbirth }}</p>
        </div>

        <hr class="my-6">

        <!-- RESET PASSWORD SECTION -->
        <h3 class="text-xl font-semibold text-slate-900 mb-4">Reset Password</h3>

        {{ route('student.profile.new.resetpassword') }}
            @csrf

            <label class="block font-semibold">New Password</label>
            <input type="password" name="password" required class="w-full p-2 border rounded-lg mb-4">

            <label class="block font-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full p-2 border rounded-lg">

            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white p-3 mt-4 rounded-lg font-semibold">
                Update Password
            </button>
        </form>

        <hr class="my-6">

        <!-- DELETE ACCOUNT SECTION -->
        {{ route('student.profile.new.delete') }}
            @csrf
            <button class="w-full bg-red-600 hover:bg-red-700 text-white p-3 rounded-lg font-semibold"
                    onclick="return confirm('Are you sure? This cannot be undone.')">
                Delete Account
            </button>
        </form>

    </div>
</x-app-layout>