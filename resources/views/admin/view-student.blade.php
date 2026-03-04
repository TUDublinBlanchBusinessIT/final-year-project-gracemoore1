<x-admin.accounts>

<div class="p-6 bg-white shadow rounded-lg max-w-3xl mx-auto">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Student Profile</h2>

    <div class="space-y-2 text-gray-800">
        <p><strong>Firstname:</strong> {{ $student->firstname }}</p>
        <p><strong>Surname:</strong> {{ $student->surname }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <p><strong>Date of Birth:</strong> {{ $student->dateofbirth }}</p>
        <p><strong>Phone:</strong> {{ $student->phone ?? 'N/A' }}</p>
        <p><strong>Account Created:</strong> {{ $student->created_at ?? 'Unknown' }}</p>
    </div>

    <hr class="my-4">

    <h3 class="font-semibold text-gray-900">Current Listings</h3>
    <p class="text-gray-500 text-sm">Not implemented yet</p>

    <h3 class="mt-4 font-semibold text-gray-900">Previous Listings</h3>
    <p class="text-gray-500 text-sm">Not implemented yet</p>

    <div class="mt-6 flex gap-4">
        <button class="px-4 py-2 bg-red-600 text-white rounded-md">Suspend Account</button>
        <button class="px-4 py-2 bg-green-600 text-white rounded-md">Reactivate Account</button>
    </div>

</div>

</x-admin.accounts>