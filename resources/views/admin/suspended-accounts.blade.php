<x-admin.accounts>

<div class="max-w-5xl mx-auto">

    <h2 class="text-xl font-bold text-gray-900 mb-4">Suspended Accounts</h2>

    {{-- STUDENTS --}}
    <h3 class="text-lg font-semibold text-slate-900 mt-6 mb-2">Students</h3>
    @forelse ($students as $u)
        <div class="p-3 border rounded mb-2 flex items-center justify-between">
            <div>{{ $u->firstname }} {{ $u->surname }} <span class="text-slate-500">(#{{ $u->id }})</span></div>
            <form method="POST" action="{{ route('admin.accounts.reactivate', ['type'=>'student','id'=>$u->id]) }}">
                @csrf
                <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Reactivate</button>
            </form>
        </div>
    @empty
        <div class="text-slate-500 text-sm">No suspended students.</div>
    @endforelse

    {{-- LANDLORDS --}}
    <h3 class="text-lg font-semibold text-slate-900 mt-8 mb-2">Landlords</h3>
    @forelse ($landlords as $u)
        <div class="p-3 border rounded mb-2 flex items-center justify-between">
            <div>{{ $u->firstname }} {{ $u->surname }} <span class="text-slate-500">(#{{ $u->id }})</span></div>
            <form method="POST" action="{{ route('admin.accounts.reactivate', ['type'=>'landlord','id'=>$u->id]) }}">
                @csrf
                <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Reactivate</button>
            </form>
        </div>
    @empty
        <div class="text-slate-500 text-sm">No suspended landlords.</div>
    @endforelse

    {{-- SERVICE PROVIDERS --}}
    <h3 class="text-lg font-semibold text-slate-900 mt-8 mb-2">Service Providers</h3>
    @forelse ($providers as $u)
        <div class="p-3 border rounded mb-2 flex items-center justify-between">
            <div>{{ $u->firstname }} {{ $u->surname }} — {{ $u->companyname }} <span class="text-slate-500">(#{{ $u->id }})</span></div>
            <form method="POST" action="{{ route('admin.accounts.reactivate', ['type'=>'serviceprovider','id'=>$u->id]) }}">
                @csrf
                <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Reactivate</button>
            </form>
        </div>
    @empty
        <div class="text-slate-500 text-sm">No suspended service providers.</div>
    @endforelse>

</div>

</x-admin.accounts>