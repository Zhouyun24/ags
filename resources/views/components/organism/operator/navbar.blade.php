<div class="flex items-center justify-between bg-white px-5 py-4">
    <div class="flex items-center gap-3">
        <button type="button" class="text-[#2653EB] flex h-10 w-10 items-center justify-center rounded-[13px] bg-[#2653EB]/15" @click="open = !open">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <div class="flex items-center gap-2">
            <div class="flex h-9 w-9 items-center justify-center rounded-md bg-[#2653EB]">
                <svg class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 3 1 8.5l11 5.5 9-4.5V17h2V8.5L12 3Z" />
                    <path d="M5 10.9V15c0 1.7 3.1 4 7 4s7-2.3 7-4v-4.1l-7 3.5-7-3.5Z" />
                </svg>
            </div>
            <span class="font-['Plus_Jakarta_Sans'] text-lg font-extrabold text-slate-900">AGS</span>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('operator.notifikasi.index') }}"
            class="flex h-10 w-10 items-center justify-center rounded-[13px] bg-[#2653EB]/15 text-[#2653EB]">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9" />
                <path d="M13.7 21a2 2 0 0 1-3.4 0" />
            </svg>
        </a>
        <a href="{{ route('operator.profile.index') }}"
            class="flex h-10 w-10 items-center justify-center rounded-[13px] bg-[#2653EB]/15 text-[#2653EB]">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="8" r="4" />
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
            </svg>
        </a>
    </div>
</div>
