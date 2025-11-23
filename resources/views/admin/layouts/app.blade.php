<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - JerukPin')</title>
    <!-- Tailwind CDN Fallback for immediate styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { margin: 0; font-family: system-ui, -apple-system, sans-serif; }
        .admin-container { display: flex; height: 100vh; overflow: hidden; }
        .sidebar { width: 260px; background: linear-gradient(180deg, #ea580c 0%, #c2410c 100%); color: white; display: flex; flex-direction: column; box-shadow: 2px 0 10px rgba(0,0,0,0.1); }
        .sidebar-logo { padding: 24px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-logo h1 { margin: 0; font-size: 24px; display: flex; align-items: center; gap: 12px; }
        .sidebar-logo p { margin: 4px 0 0 0; font-size: 12px; opacity: 0.8; }
        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .nav-link {display: block; padding: 12px 16px; margin-bottom: 4px; border-radius: 8px; color: white; text-decoration: none; transition: all 0.2s; display: flex; align-items: center; gap: 12px; }
        .nav-link:hover { background: rgba(255,255,255,0.1); }
        .nav-link.active { background: rgba(0,0,0,0.2); box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .nav-icon { font-size: 20px; }
        .sidebar-footer { padding: 16px; border-top: 1px solid rgba(255,255,255,0.1); }
        .user-info { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
       .user-avatar { width: 40px; height: 40px; background: white; color: #ea580c; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px; }
        .user-details { flex: 1; min-width: 0; }
        .user-name { font-weight: 600; font-size: 14px; margin: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .user-email { font-size: 11px; opacity: 0.7; margin: 2px 0 0 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .logout-btn { width: 100%; padding: 10px; background: rgba(0,0,0,0.2); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .logout-btn:hover { background: rgba(0,0,0,0.3); }
        .main-content { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .top-header { background: white; padding: 20px 24px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; }
        .page-title { font-size: 28px; font-weight: bold; color: #111827; margin: 0; }
        .page-desc { font-size: 14px; color: #6b7280; margin: 4px 0 0 0; }
        .content-area { flex: 1; overflow-y: auto; padding: 24px; background: #f3f4f6; }
        .alert { padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; }
        .alert-success { background: #d1fae5; border-left: 4px solid #10b981; color: #065f46; }
        .alert-error { background: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; }
        .mobile-toggle { display: none; padding: 8px; background: #f3f4f6; border: none; border-radius: 8px; cursor: pointer; }
        
        @media (max-width: 1023px) {
            .sidebar { position: fixed; left: 0; top: 0; bottom: 0; z-index: 1000; transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.open { transform: translateX(0); }
            .mobile-toggle { display: block; }
            .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; }
            .sidebar-overlay.show { display: block; }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <a href="{{ route('admin.dashboard') }}" style="color: white; text-decoration: none;">
                    <h1><span>🍊</span> JerukPin</h1>
                    <p>Admin Panel</p>
                </a>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <span class="nav-icon">📁</span>
                    <span>Kategori</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <span class="nav-icon">🍊</span>
                    <span>Produk</span>
                </a>
                <a href="{{ route('admin.flash-sale-campaigns.index') }}" class="nav-link {{ request()->routeIs('admin.flash-sale-campaigns.*') || request()->routeIs('admin.flash-sales.*') ? 'active' : '' }}">
                    <span class="nav-icon">⚡</span>
                    <span>Flash Sale</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <span class="nav-icon">📦</span>
                    <span>Pesanan</span>
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <span class="nav-icon">⭐</span>
                    <span>Review</span>
                </a>
                <a href="{{ route('admin.payment-methods.index') }}" class="nav-link {{ request()->routeIs('admin.payment-methods.*') ? 'active' : '' }}">
                    <span class="nav-icon">💳</span>
                    <span>Metode Bayar</span>
                </a>
                <a href="{{ route('admin.shipping-methods.index') }}" class="nav-link {{ request()->routeIs('admin.shipping-methods.*') ? 'active' : '' }}">
                    <span class="nav-icon">🚚</span>
                    <span>Metode Pengiriman</span>
                </a>
                <div style="margin: 16px 0; border-top: 1px solid rgba(255,255,255,0.1);"></div>
                <a href="{{ route('home') }}" target="_blank" class="nav-link">
                    <span class="nav-icon">🏪</span>
                    <span>Lihat Toko</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">{{ auth()->user() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'A' }}</div>
                    <div class="user-details">
                        <p class="user-name">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="user-email">{{ auth()->user()->email ?? 'admin@jerukpin.com' }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <header class="top-header">
                <div>
                    <h2 class="page-title">@yield('page-title', 'Dashboard')</h2>
                    <p class="page-desc">@yield('page-description', 'Ringkasan performa toko JerukPin')</p>
                </div>
                <button class="mobile-toggle" id="mobile-toggle">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </header>

            <!-- Flash Messages -->
            @if(session('success'))
                <div style="padding: 0 24px; margin-top: 16px;">
                    <div class="alert alert-success">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span style="font-weight: 500;">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div style="padding: 0 24px; margin-top: 16px;">
                    <div class="alert alert-error">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span style="font-weight: 500;">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Content -->
            <main class="content-area">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('mobile-toggle');
        const overlay = document.getElementById('sidebar-overlay');

        toggle?.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });

        overlay?.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });

        // Close on link click (mobile)
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('show');
                }
            });
        });
    </script>
    
    <!-- Toast Notifications -->
    @include('components.toast')
</body>
</html>
