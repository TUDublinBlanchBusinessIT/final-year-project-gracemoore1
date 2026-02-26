<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-500 leading-tight">
            RentConnect
        </h2>                              
    </x-slot>

    

    @include('profile.partials.sp-header', ['title' => 'Upcoming Jobs'])

    <style>
        .coming-box {
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            padding: 60px 50px;
            text-align: center;
        }
        .title { font-size: 30px; font-weight: 800; color: rgb(38,98,227); }
        .text  { font-size: 20px; color: #444; margin-top: 18px; }
    </style>

    <div class="coming-box">
        <div class="title">Upcoming Jobs — Coming Soon</div>
        <div class="text">This feature is currently in development.</div>
    </div>
</x-app-layout>