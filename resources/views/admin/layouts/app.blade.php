<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - JerukPin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient-shift 5s ease infinite;
        }
    </style>
</head>
<body class="bg-neutral-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Left Sidebar -->
        <aside id="sidebar" class="w-64 bg-gradient-to-b from-orange-600 to-orange-700 gradient-animate text-white flex-shrink-0 flex flex-col shadow-2xl transition-all duration-300">
            <!-- Logo -->
            <div class="p-6 border-b border-orange-500/30">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="text-4xl transform group-hover:scale-110 transition-transform">🍊</div>
                    <div>
                        <h1 class="text-2xl font-bold">JerukPin</h1>
                        <p class="text-xs text-orange-200">Admin Panel</p>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-orange-800/50 shadow-lg' : 'hover:bg-orange-700/30' }}">
                    <span class="text-2xl">📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-orange-800/50 shadow-lg' : 'hover:bg-orange-700/30' }}">
                    <span class="text-2xl">📁</span>
                    <span class="font-medium">Kategori</span>
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.products.*') ? 'bg-orange-800/50 shadow-lg' : 'hover:bg-orange-700/30' }}">
                    <span class="text-2xl">🍊</span>
                    <span class="font-medium">Produk</span>
                </a>
                
                <a href="{{ route('admin.flash-sales.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.flash-sales.*') ? 'bg-orange-800/50 shadow-lg' : 'hover:bg-orange-700/30' }}">
                    <span class="text-2xl">⚡</span>
                    <span class="font-medium">Flash Sale</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-orange-800/50 shadow-lg' : 'hover:bg-orange-700/30' }}">
                    <span class="text-2xl">📦</span>
                    <span class="font-medium">Pesanan</span>
                </a>
                
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('admin.reviews.*') ? 'bg-orange-800/50 shadow-lg' : 'hover:bg-orange-700/30' }}">
                    <span class="text-2xl">⭐</span>
                    <span class="font-medium">Review</span>
                </a>

                <div class="my-4 border-t border-orange-500/30"></div>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-orange-700/30 transition-all">
                    <span class="text-2xl">🏪</span>
                    <span class="font-medium">Lihat Toko</span>
                </a>
            </nav>

            <!-- User Profile -->
            <div class="p-4 border-t border-orange-500/30">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-orange-600 font-bold text-lg shadow-md">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-orange-200 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-orange-800/50 hover:bg-orange-800 rounded-lg transition-all text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-neutral-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-neutral-900">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm text-neutral-600">@yield('page-description', 'Kelola toko JerukPin Anda')</p>
                    </div>
                    <button id="sidebar-toggle" class="lg:hidden p-2 rounded-lg hover:bg-neutral-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mx-6 mt-4">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-lg shadow-sm flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-4">
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-lg shadow-sm flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>

    <script>
        // Mobile sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Close sidebar on mobile when clicking a link
        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add('-translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
