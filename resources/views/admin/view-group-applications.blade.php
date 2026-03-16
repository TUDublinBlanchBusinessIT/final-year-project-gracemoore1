<x-admin.accounts>

<div class="p-6 bg-white shadow rounded-lg max-w-4xl mx-auto">

    <h2 class="text-2xl font-bold mb-4">Group Application Details</h2>

    {{-- LISTING INFO --}}
    <div class="mb-6">
        <h3 class="text-lg font-semibold">Listing</h3>
        <p><strong>ID:</strong> {{ $app->rental->id }}</p>
        <p><strong>Address:</strong>
            {{ $app->rental->housenumber ? $app->rental->housenumber.' ' : '' }}
            {{ $app->rental->street }}, {{ $app->rental->county }}
        </p>
        <p><strong>Landlord:</strong>
            {{ $app->rental->landlord->firstname }} {{ $app->rental->landlord->surname }}
            ({{ $app->rental->landlord->email }})
        </p>
    </div>

    {{-- GROUP MEMBERS --}}
    <div class="mb-6">
        <h3 class="text-lg font-semibold">Group Members</h3>

        @foreach($app->group->members as $m)
            <div class="p-2 border rounded mb-2">
                <p><strong>ID:</strong> {{ $m->id }}</p>
                <p><strong>Name:</strong> {{ $m->firstname }} {{ $m->surname }}</p>
                <p><strong>Email:</strong> {{ $m->email }}</p>
            </div>
        @endforeach
    </div>

    {{-- APPLICATION META --}}
    <div>
        <h3 class="text-lg font-semibold mb-1">Application Info</h3>
        <p><strong>Application ID:</strong> {{ $app->id }}</p>
        <p><strong>Group ID:</strong> {{ $app->group_id }}</p>
        <p><strong>Status:</strong> {{ ucfirst($app->status) }}</p>
        <p><strong>Date Applied:</strong> {{ $app->dateapplied }}</p>
    </div>

</div>

</x-admin.accounts>