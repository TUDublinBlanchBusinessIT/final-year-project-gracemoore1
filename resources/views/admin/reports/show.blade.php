<x-admin.reports>

    <div class="p-6 bg-white shadow rounded-lg max-w-4xl mx-auto">

        <h2 class="text-xl font-bold text-gray-900 mb-4">
            Report Details
        </h2>

        <div class="space-y-3 text-gray-800 mb-6">

            {{-- Subject (clean display) --}}
            <div class="mb-6">
                <p class="text-slate-500">Subject</p>
                <p class="font-medium text-slate-900">
                    {{ $subject }}
                </p>
            </div>

            <p><strong>Reporter:</strong> {{ $reporterName }} ({{ $report->reporter_role }})</p>
            <p><strong>Reported user:</strong> {{ $reportedName }} ({{ $report->reported_user_role }})</p>
            <p>
                <strong>Submitted:</strong>
                {{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y H:i') }}
            </p>
        </div>

        <hr class="my-4">

        <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-2">Full Report</h3>
            <pre class="bg-slate-50 p-4 rounded-lg text-sm whitespace-pre-wrap">
            {{ $cleanDescription }}
            </pre>
        </div>

        <div class="mb-6">
            <h3 class="font-semibold text-gray-900 mb-2">Evidence</h3>


            @if(!empty($evidencePaths))
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($evidencePaths as $path)
                        <img
                            src="{{ url('/evidence/' . basename($path)) }}"
                            class="rounded-lg border object-cover"
                            alt="Uploaded evidence"
                        >
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-600">No evidence uploaded.</p>
            @endif
        </div>

        <div class="flex gap-4">
            <form method="POST" action="{{ route('admin.reports.noaction.submit', $report->id) }}">
                @csrf
                <button class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    No action needed
                </button>
            </form>

            <form method="POST" action="{{ route('admin.reports.suspend', $report->id) }}">
                @csrf
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Suspend reported account
                </button>
            </form>
        </div>

    </div>

</x-admin.reports>