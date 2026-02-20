<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Post Your Listing
        </h2>
    </x-slot>

    {{-- Push content away from landlord sidebar + leave room for mobile bottom nav --}}
    <div class="pb-28 lg:pl-60">
        <div class="py-10">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700">
                        <div class="font-semibold">Please fix the following:</div>
                        <ul class="list-disc pl-5 mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 sm:p-8">

                        <div class="flex items-start justify-between gap-6">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">Post Your Listing</h1>
                                <p class="text-slate-600 mt-1 text-sm">
                                    Add images and details. Keep them clear and accurate for students.
                                </p>
                            </div>

                            <a href="{{ route('dashboard') }}"
                               class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                                ← Back
                            </a>
                        </div>

                        <form class="mt-8 space-y-8"
                              method="POST"
                              action="{{ route('landlord.rentals.store') }}"
                              enctype="multipart/form-data">
                            @csrf

                            {{-- Images --}}
                            <section class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-lg font-bold text-slate-900">Images</h2>
                                    <span id="imgCountBadge"
                                          class="hidden text-xs font-bold bg-blue-600 text-white px-2 py-1 rounded-full">
                                        0
                                    </span>
                                </div>

                                <label class="block">
                                    <div class="rounded-2xl border border-dashed border-slate-300 p-6 hover:border-blue-400 transition cursor-pointer">
                                        <div class="flex items-center gap-4">
                                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-slate-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16l4-4a3 3 0 014 0l2 2a3 3 0 004 0l4-4M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>

                                            <div class="flex-1">
                                                <div class="font-semibold text-slate-900">Upload images of your listing</div>
                                                <div class="text-sm text-slate-600">PNG/JPG, up to 5 images recommended.</div>
                                            </div>

                                            <div class="w-12 h-12 rounded-full bg-blue-600 text-white flex items-center justify-center text-2xl font-bold">
                                                +
                                            </div>
                                        </div>

                                        <input id="imagesInput"
                                               name="images[]"
                                               type="file"
                                               accept="image/*"
                                               multiple
                                               class="hidden" />
                                    </div>
                                </label>

                                <div id="previewGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3"></div>
                            </section>

                            {{-- Location + Basics --}}
                            <section class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="text-sm font-semibold text-slate-700">House Number (optional)</label>
                                    <input name="housenumber" value="{{ old('housenumber') }}"
                                           class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g. 14" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Street</label>
                                    <input name="street" value="{{ old('street') }}" required
                                           class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g. The Green" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">County</label>
                                    <input name="county" value="{{ old('county') }}" required
                                           class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g. Dublin" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Postcode (optional)</label>
                                    <input name="postcode" value="{{ old('postcode') }}"
                                           class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g. D14" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Measurement (optional)</label>
                                    <input name="measurement" value="{{ old('measurement') }}"
                                           class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g. 15sqm" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Rent per month (€)</label>
                                    <input name="rentpermonth" value="{{ old('rentpermonth') }}" required type="number" step="0.01" min="0"
                                           class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                           placeholder="e.g. 850" />
                                </div>

                                <div>
                                    <label class="text-sm font-semibold text-slate-700">Status</label>
                                    <select name="status" class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500">
                                        <option value="available" @selected(old('status') === 'available')>Available</option>
                                        <option value="occupied" @selected(old('status') === 'occupied')>Occupied</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm font-semibold text-slate-700">Available from</label>
                                        <input name="availablefrom" value="{{ old('availablefrom') }}" type="date" required
                                               class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                    <div>
                                        <label class="text-sm font-semibold text-slate-700">Available until</label>
                                        <input name="availableuntil" value="{{ old('availableuntil') }}" type="date" required
                                               class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                </div>
                            </section>

                            {{-- Description --}}
                            <section>
                                <label class="text-sm font-semibold text-slate-700">Description</label>
                                <textarea name="description" rows="5" required
                                          class="mt-2 w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                          placeholder="Brief description about the accommodation...">{{ old('description') }}</textarea>
                            </section>

                            {{-- Actions --}}
                            <div class="flex items-center justify-end gap-3 pt-2">
                                <a href="{{ route('dashboard') }}"
                                   class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50">
                                    Cancel
                                </a>

                                <button type="submit"
                                        class="px-5 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                                    Save Listing
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Image preview script --}}
    <script>
        const input = document.getElementById('imagesInput');
        const grid = document.getElementById('previewGrid');
        const badge = document.getElementById('imgCountBadge');

        input?.addEventListener('change', () => {
            grid.innerHTML = '';
            const files = Array.from(input.files || []);

            if (files.length) {
                badge.classList.remove('hidden');
                badge.textContent = files.length;
            } else {
                badge.classList.add('hidden');
            }

            files.slice(0, 10).forEach(file => {
                const url = URL.createObjectURL(file);
                const wrap = document.createElement('div');
                wrap.className = 'relative overflow-hidden rounded-xl border border-slate-200 bg-slate-50';

                wrap.innerHTML = `
                    <img src="${url}" class="w-full h-24 object-cover" />
                `;
                grid.appendChild(wrap);
            });
        });
    </script>
</x-app-layout>
