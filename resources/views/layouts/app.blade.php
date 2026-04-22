<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Apotek Surya Pharma Medika')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f7fd;
        }
        .text-navy { color: #1b4985; }
        .bg-navy { background-color: #1b4985; }
        .header-gradient {
            background: linear-gradient(90deg, #1b4985 0%, #7da2d1 100%);
        }
    </style>

    @stack('styles')
</head>

<body class="antialiased text-gray-700">

<div class="flex h-screen overflow-hidden">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="w-[280px] bg-white border-r border-blue-50 flex flex-col">

        {{-- LOGO --}}
        <div class="pt-16 pb-10 text-center">
            <h1 class="text-navy font-bold text-[22px] leading-tight">
                Apotek<br>Surya Pharma<br>Medika
            </h1>
        </div>

        {{-- MENU --}}
        <nav class="px-6 space-y-3 font-medium">

    @auth   
            <a href="{{ url('/dashboard') }}"
               class="flex items-center p-4 rounded-xl transition
               {{ request()->is('dashboard') ? 'bg-navy text-white shadow-lg shadow-blue-200' : 'text-gray-400 hover:bg-blue-50' }}">
                <i class="fas fa-th-large w-10 text-xl"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ url('/obat') }}"
               class="flex items-center p-4 rounded-xl transition
               {{ request()->is('obat*') ? 'bg-navy text-white shadow-lg shadow-blue-200' : 'text-gray-400 hover:bg-blue-50' }}">
                <i class="fas fa-pills w-10 text-xl"></i>
                <span>Daftar Obat</span>
            </a>
    
        @if(auth()->user()->role === 'owner')
            <a href="{{ url('/faktur') }}"
               class="flex items-center p-4 rounded-xl transition
               {{ request()->is('faktur*') ? 'bg-navy text-white shadow-lg shadow-blue-200' : 'text-gray-400 hover:bg-blue-50' }}">
                <i class="fas fa-file-invoice w-10 text-xl"></i>
                <span>Daftar Faktur</span>
            </a>
        @endif
    
        @if(auth()->user()->role === 'owner')
            <a href="{{ url('/distributors') }}"
               class="flex items-center p-4 rounded-xl transition
               {{ request()->is('distributor*') ? 'bg-navy text-white shadow-lg shadow-blue-200' : 'text-gray-400 hover:bg-blue-50' }}">
                <i class="fas fa-truck w-10 text-xl"></i>
                <span>Distributor</span>
            </a>
        @endif
    
            <a href="{{ url('/pengguna') }}"
               class="flex items-center p-4 rounded-xl transition
               {{ request()->is('pengguna*') ? 'bg-navy text-white shadow-lg shadow-blue-200' : 'text-gray-400 hover:bg-blue-50' }}">
                <i class="fas fa-users w-10 text-xl"></i>
                <span>Pengguna</span>
            </a>
       
    @endauth
            {{-- KELUAR --}}
            <a href="{{ url('/logout') }}"
               class="flex items-center p-4 rounded-xl transition text-red-500 hover:bg-red-50 font-semibold">
                <i class="fas fa-right-from-bracket w-10 text-xl"></i>
                <span>Keluar</span>
            </a>
        
        </nav>
    </aside>

    {{-- ================= MAIN ================= --}}
    <div class="flex-1 flex flex-col">

        <header class="h-[90px] header-gradient flex justify-end items-center px-12 text-white">
            <div class="flex items-center gap-8">
                <i class="far fa-bell text-2xl"></i>
                <div class="h-10 w-px bg-white/30"></div>

                <div class="flex items-center gap-4">
                @auth
                    <div class="user-info">
                        <span class="text-sm font-bold">
                            {{ Auth::user()->name }} ({{ Auth::user()->role }})
                        </span>
                        <br>
                        <span class="text-xs opacity">
                            {{ Auth::user()->email }}
                        </span>
                    </div>
                @endauth
                    <div class="w-11 h-11 rounded-full bg-white/20 border border-white/30 flex items-center justify-center">
                        <i class="far fa-user"></i>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 px-14 pt-10 pb-12 overflow-y-auto">
            <h2 class="text-navy font-bold text-xl mb-8">
                @yield('page_title')
            </h2>

            @yield('content')
        </main>

    </div>
</div>

@stack('scripts')
</body>
</html>