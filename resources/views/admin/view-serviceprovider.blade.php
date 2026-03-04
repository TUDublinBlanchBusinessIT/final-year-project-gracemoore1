<x-admin.accounts>

<div class="p-6 bg-white shadow rounded-lg max-w-3xl mx-auto">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Service Provider Profile</h2>

    <div class="space-y-2 text-gray-800">
        <p><strong>Firstname:</strong> {{ $provider->firstname }}</p>
        <p><strong>Surname:</strong> {{ $provider->surname }}</p>
        <p><strong>Company Name:</strong> {{ $provider->companyname }}</p>
        <p><strong>Email:</strong> {{ $provider->email }}</p>
        <p><strong>Phone:</strong> {{ $provider->phone }}</p>
        <p><strong>Service Type:</strong> {{ $provider->servicetype }}</p>
    </div>

    <hr class="my-4">

    <p><strong>Created By Admin:</strong>
        @if($admin)
            {{ $admin->firstname }} {{ $admin->surname }}
        @else
            Unknown
        @endif
    </p>

    <div class="mt-6 flex gap-4">
        <button class="px-4 py-2 bg-red-600 text-white rounded-md">Suspend Account</button>
        <button class="px-4 py-2 bg-green-600 text-white rounded-md">Reactivate Account</button>
    </div>

</div>

</x-admin.accounts>