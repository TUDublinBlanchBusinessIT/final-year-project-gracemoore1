<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(session('welcome'))
    <div id="welcomePopup" 
         style="
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2d6cff;
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            z-index: 9999;
            animation: fadeIn 0.4s ease-out;
         ">
        {{ session('welcome') }}
    </div>

    <script>
        setTimeout(() => {
            const popup = document.getElementById('welcomePopup');
            if (popup) {
                popup.style.transition = "opacity 0.5s";
                popup.style.opacity = "0";
                setTimeout(() => popup.remove(), 600);
            }
        }, 3500);
    </script>
@endif


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
