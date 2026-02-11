<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Log in to RentConnect</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif




        <form method="POST" action="{{ route('login') }}">
            @csrf



            <label class="block mb-2 font-semibold">Email</label>
            <input type="email" name="email" required class="w-full p-2 border rounded mb-4">

            <label class="block mb-2 font-semibold">Password</label>
            <input type="password" name="password" required class="w-full p-2 border rounded mb-6">

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Log In
            </button>
        </form>
    </div>
</div>
