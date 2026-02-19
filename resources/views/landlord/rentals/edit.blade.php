<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Listing
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-2xl p-8">

                @if ($errors->any())
                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
                        <p class="font-semibold mb-2">Please fix the following:</p>
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('landlord.rentals.update', $rental) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-700">House Number</label>
                            <input name="housenumber" value="{{ old('housenumber', $rental->housenumber) }}"
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. 14">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Street *</label>
                            <input name="street" value="{{ old('street', $rental->street) }}" required
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. The Green">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">County *</label>
                            <input name="county" value="{{ old('county', $rental->county) }}" required
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. Dublin">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Postcode *</label>
                            <input name="postcode" value="{{ old('postcode', $rental->postcode) }}" required
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. D12XY89">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Size (optional)</label>
                            <input name="measurement" value="{{ old('measurement', $rental->measurement) }}"
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. 15sqm">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Rent per month (€) *</label>
                            <input name="rentpermonth" type="number" step="0.01" min="0" required
                                   value="{{ old('rentpermonth', $rental->rentpermonth) }}"
                                   class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="e.g. 850">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Status *</label>
                            <select name="status" required
                                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="available" {{ old('status', $rental->status) === 'available' ? 'selected' : '' }}>Available</option>
                                <option value="occupied" {{ old('status', $rental->status) === 'occupied' ? 'selected' : '' }}>Occupied</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-semibold text-gray-700">Available from *</label>
                                <input name="availablefrom" type="date" required
                                       value="{{ old('availablefrom', $rental->availablefrom) }}"
                                       class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-gray-700">Available until *</label>
                                <input name="availableuntil" type="date" required
                                       value="{{ old('availableuntil', $rental->availableuntil) }}"
                                       class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-700">Description *</label>
                        <textarea name="description" rows="5" required
                                  class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Describe the listing...">{{ old('description', $rental->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('dashboard') }}"
                           class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                            ← Back to dashboard
                        </a>

                        <button type="submit"
                                class="px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700">
                            Save Changes
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
