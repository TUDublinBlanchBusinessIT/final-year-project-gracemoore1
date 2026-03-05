<x-admin.accounts>

<div class="p-6 bg-white shadow rounded-lg max-w-4xl mx-auto">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Service Provider Profile</h2>

    <div class="space-y-2 text-gray-800">
        <p><strong>Firstname:</strong> {{ $provider->firstname }}</p>
        <p><strong>Surname:</strong> {{ $provider->surname }}</p>
        <p><strong>Company Name:</strong> {{ $provider->companyname }}</p>
        <p><strong>Email:</strong> {{ $provider->email }}</p>
        <p><strong>Phone:</strong> {{ $provider->phone }}</p>
        <p><strong>County:</strong> {{ $provider->county }}</p>
        <p><strong>Service Type:</strong> {{ $provider->servicetype }}</p>
        <p><strong>Commission Per Job:</strong>
            €{{ $provider->commissionperjob ?? '0' }}
        </p>
        <p><strong>Fee Per Month:</strong>
            €{{ $provider->feepermonth ?? '0' }}
        </p>
        <p><strong>Created By Admin:</strong>
            @if($admin)
                {{ $admin->firstname }} {{ $admin->surname }}
            @else
                Unknown
            @endif
        </p>
    </div>

    <div class="mt-8 flex gap-4">
        <form method="POST" action="{{ route('admin.accounts.suspend', ['type'=>'serviceprovider','id'=>$provider->id]) }}">
            @csrf
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Suspend Account</button>
        </form>

        <form method="POST" action="{{ route('admin.accounts.reactivate', ['type'=>'serviceprovider','id'=>$provider->id]) }}">
            @csrf
            <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Reactivate Account</button>
        </form>
    </div>
</div>

</x-admin.accounts>