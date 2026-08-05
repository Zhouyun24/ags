<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Academic Guidance System</title>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    @php
        $role = \Illuminate\Support\Facades\Auth::user()?->role;
        $roleMap = [
            1 => 'operator',
            2 => 'mahasiswa',
            3 => 'dosen',
        ];

        $namaKomponenNavbar = 'organism.' . ($roleMap[$role] ?? 'mahasiswa') . '.navbar';
        $namaKomponenSidebar = 'organism.' . ($roleMap[$role] ?? 'mahasiswa') . '.sidebar';
    @endphp 

    <body class="font-inter antialiased">
        <div class="mx-auto min-h-dvh w-full bg-slate-50" x-data="{ open: false }">
            @if(!isset($navbarVisibility) || $navbarVisibility == 1)   
                <x-dynamic-component :component="$namaKomponenNavbar" />
            @endif
            @if(!isset($sidebarVisibility) || $sidebarVisibility == 1)
                <x-dynamic-component :component="$namaKomponenSidebar" />
            @endif
            @yield("layouts")
        </div>
    </body>
</html>
