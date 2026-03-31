<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-base text-gray-800 leading-tight">Report account</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">

            @if(session('success'))
                <div class="mb-4 p-3 rounded-xl bg-green-50 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="reported_user_id" value="{{ $reported_user_id }}">
                <input type="hidden" name="reported_user_role" value="{{ $reported_user_role }}">

                <label class="block text-sm font-medium text-slate-700">Subject</label>
                <input name="subject" required maxlength="150"
                       class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm">

                <label class="block text-sm font-medium text-slate-700 mt-4">Description</label>
                <textarea name="details" required rows="6"
                          class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-2 text-sm"></textarea>

                <label class="block text-sm font-medium text-slate-700 mt-4">Evidence (up to 5 images)</label>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="mt-1 block w-full text-sm">

                <button type="submit"
                        class="mt-6 rounded-2xl bg-red-600 px-5 py-3 text-sm font-medium text-white hover:bg-red-700">
                    Submit report
                </button>
            </form>
        </div>
    </div>
</x-app-layout>