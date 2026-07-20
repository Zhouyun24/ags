@php
    $user = $user ?? auth()->user();
    $navItems = [
        ['label' => 'Beranda', 'route' => 'mahasiswa.beranda.index', 'icon' => 'home'],
        ['label' => 'Ajukan Bimbingan', 'route' => 'mahasiswa.ajukan-bimbingan.index', 'icon' => 'plus'],
        ['label' => 'Status Jadwal', 'route' => 'mahasiswa.status-jadwal.index', 'icon' => 'calendar'],
        ['label' => 'Riwayat Bimbingan', 'route' => 'mahasiswa.riwayat-bimbingan.index', 'icon' => 'book'],
        ['label' => 'Evaluasi Akademik', 'route' => 'mahasiswa.evaluasi-akademik.index', 'icon' => 'chart'],
    ];
@endphp

<div x-data x-cloak>
    <div
        x-show="open"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="open = !open"
        class="fixed inset-0 z-40 bg-slate-900/40"
    ></div>
    <aside
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        @keydown.escape.window="open = !open"
        class="fixed inset-y-0 left-0 z-50 flex min-w-[286px] min-h-screen flex-col bg-white shadow-xl"
    >
        <div class="relative bg-gradient-to-bl from-[#3B82F6] to-[#2563EB] w-full min-h-[150px] flex justify-center items-center">
            <button
                type="button"
                @click="open = !open"
                aria-label="Tutup menu"
                class="absolute right-4 top-4 flex h-[30px] w-[30px] items-center justify-center rounded-lg bg-white/25 text-white hover:bg-white/30"
            >
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <path d="M6 6l12 12M18 6 6 18" />
                </svg>
            </button>
            <div class="flex items-center justify-center gap-3">
                <div class="flex h-[50px] w-[50px] items-center justify-center rounded-lg bg-white/25 border border-white/25">
                    @if ($user?->foto)
                        <img src="{{ $user->foto }}" alt="{{ $user->nama }}" class="h-[50px] w-[50px] rounded-2xl object-cover">
                    @else
                        <svg class="h-[30px] w-[30px] text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="8" r="4" />
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                        </svg>
                    @endif
                </div>
                <div>
                    <p class="font-jakarta text-base font-extrabold text-white">
                        {{ $user?->nama ?? 'Nama Pengguna' }}
                    </p>
                    <p class="font-inter text-xs text-white">
                        {{ $user?->peran ?? 'Mahasiswa' }} &bull; NIM: {{ $user?->nim ?? '10124257' }}
                    </p>
                </div>
            </div>
        </div>
        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1">
                @foreach ($navItems as $item)
                    @php $active = request()->routeIs($item['route']); @endphp
                    <li>
                        <a
                            href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}"
                            class="flex items-center gap-3 py-3 font-inter text-sm font-medium transition
                                {{ $active ? 'border-l-[3px] border-[#2563EB] bg-[#EFF6FF] text-[#2563EB] px-4' : 'text-black hover:bg-slate-50 px-5' }}"
                        >
                            <span class="flex h-[34px] w-[34px] items-center justify-center rounded-lg {{ $active ? 'bg-[#2563EB]/20' : 'bg-[#EFF6FF]' }}">
                                <svg class="h-4 w-4 {{ $active ? 'text-[#2563EB]' : 'text-black' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    @switch($item['icon'])
                                        @case('home')
                                            <path d="M4 11 12 4l8 7" />
                                            <path d="M6 10v9a1 1 0 0 0 1 1h4v-6h2v6h4a1 1 0 0 0 1-1v-9" />
                                            @break

                                        @case('plus')
                                            <path d="M12 5v14M5 12h14" />
                                            @break

                                        @case('calendar')
                                            <rect x="3" y="4" width="18" height="17" rx="2" />
                                            <path d="M3 9h18M8 2v4M16 2v4" />
                                            @break

                                        @case('book')
                                            <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z" />
                                            <path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5v-13Z" />
                                            @break

                                        @case('chart')
                                            <path d="M5 20V10M12 20V4M19 20v-7" />
                                            @break
                                    @endswitch
                                </svg>
                            </span>
                            {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="border-t border-slate-100 px-5 py-5">
            <form method="POST" action="#">
                @csrf
                <button
                    type="submit"
                    class="flex w-full items-center justify-center rounded-[10px] border border-red-200 bg-red-50 py-[10px] font-inter text-sm font-medium text-[#EF4444] transition hover:bg-red-100"
                >
                    Keluar
                </button>
            </form>
        </div>
    </aside>
</div>