                            <div class="mt-5 flex flex-wrap gap-3">
                                <a href="{{ route('serviceprovider.messages.show', $providerRequest->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl font-medium hover:bg-blue-700 transition">
                                    Open Chat
                                </a>

                                <form method="POST" action="{{ route('serviceprovider.upcoming.complete', $providerRequest->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-xl font-medium hover:bg-green-700 transition">
                                        Mark as Completed
                                    </button>
                                </form>
                            </div>