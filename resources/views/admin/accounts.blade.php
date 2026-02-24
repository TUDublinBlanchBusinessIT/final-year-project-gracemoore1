<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Accounts
        </h2>
    </x-slot>

    <style>
        body {
            background: #f5f7fb;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .coming-soon-container {
            max-width: 500px;
            margin: 80px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            padding: 60px 30px;
            text-align: center;
        }
        .coming-soon-title {
            font-size: 30px;
            font-weight: 800;
            color: rgb(38, 98, 227);
            margin-bottom: 10px;
        }
        .coming-soon-text {
            font-size: 20px;
            color: #444;
            margin-top: 18px;
        }
    </style>

    <div class="coming-soon-container">
        <div class="coming-soon-title">Accounts Coming Soon</div>
        <div class="coming-soon-text">
            This feature will be available soon. Stay tuned!
        </div>
    </div>
</x-app-layout>