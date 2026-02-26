{{-- resources/views/partials/student-header.blade.php --}}
<div class="bg-white shadow-sm border-b border-slate-200">
    <div class="px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">

        {{-- LEFT: RentConnect brand --}}
        <div class="text-2xl font-extrabold text-blue-600">
            RentConnect
        </div>

        {{-- RIGHT: simple action icons just for students (SVG icons, no emojis) --}}
        <div class="flex items-center gap-5">

            {{-- Messages --}}
            <a href="{{ route('student.messages') }}"
               class="text-slate-600 hover:text-blue-600 transition"
               title="Messages" aria-label="Messages">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 15a4 4 0 01-4 4H8l-5 3V7a4 4 0 014-4h10a4 4 0 014 4z"/>
                </svg>
            </a>

            {{-- Profile --}}
            <a href="{{ route('student.profile.new.account') }}"
               class="text-slate-600 hover:text-blue-600 transition"
               title="Profile" aria-label="Profile">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 10-16 0"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </a>
        </div>
    </div>

    {{-- PAGE TITLE --}}
    <div class="px-4 sm:px-6 lg:px-8 pb-4">
        <h2 class="text-xl font-semibold text-slate-900">
            {{ $title }}
        </h2>
    </div>
</div>
