<x-mail::message>

{{-- Header / Logo --}}
<x-slot:header>
    <div style="text-align: center; padding: 20px 0;">
        <img src="{{ asset('images/RentConnectlogo.png') }}"
             alt="RentConnect"
             style="height: 55px;">
    </div>
</x-slot:header>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
# Hello!
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<x-mail::button :url="$actionUrl" color="primary">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
Regards,  
**RentConnect**

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
If you're having trouble clicking the **"{{ $actionText }}"** button,
copy and paste the URL below into your web browser:

<span class="break-all">
{{ $actionUrl }}
</span>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
    <div style="text-align: center; color: #6b7280; font-size: 12px;">
        © {{ date('Y') }} RentConnect. All rights reserved.
    </div>
</x-slot:footer>

</x-mail::message>
