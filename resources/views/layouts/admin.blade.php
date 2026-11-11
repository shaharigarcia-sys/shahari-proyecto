<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administración — En tu hogar')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Ajustes de fuente, escala y lectura adaptable. -->
    <link rel="stylesheet" href="{{ asset('css/typography.css') }}">
    <style>
      .admin-layout {
        display: grid;
        grid-template-columns: 240px 1fr;
        min-height: 100vh;
        background: #f8fcfe;
      }
      .admin-sidebar {
        background: #fff;
        border-right: 1px solid var(--border);
        padding: 24px 18px;
        display: flex;
        flex-direction: column;
        gap: 20px;
      }
      .admin-nav {
        display: flex;
        flex-direction: column;
        gap: 6px;
      }
      .admin-nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--muted);
        text-decoration: none;
        transition: all 0.15s ease;
      }
      .admin-nav-item:hover, .admin-nav-item.active {
        background: var(--aqua);
        color: var(--blue-dark);
      }
      .admin-content {
        padding: 32px 36px;
        max-width: 1200px;
        width: 100%;
      }
      .admin-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 28px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
      }
      .table-responsive {
        overflow-x: auto;
      }
      .data-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
      }
      .data-table th {
        background: #f0f7f9;
        color: var(--blue-dark);
        padding: 12px 14px;
        font-weight: 700;
        border-bottom: 1px solid var(--border);
      }
      .data-table td {
        padding: 14px;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
      }
      .badge-success {
        background: #d8f5ed;
        color: #236b5b;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
      }
      .badge-secondary {
        background: #f0f0f0;
        color: #666;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
      }
      @media(max-width: 900px) {
        .admin-layout { grid-template-columns: 1fr; }
        .admin-sidebar { border-right: none; border-bottom: 1px solid var(--border); }
        .admin-content { padding: 20px; }
      }
    </style>
    @stack('styles')
</head>
<body>
    <div class="topbar" style="background: var(--blue-dark); color: #fff;">
      <span>⚙️</span> Panel de Administración · <strong>En tu hogar (Laravel Full Stack)</strong>
    </div>

    <div class="admin-layout">
      <aside class="admin-sidebar">
        <a class="logo" href="{{ route('home') }}" title="Ir al sitio público">
          <span class="logo-a">en tu</span><span class="logo-b">hogar</span>
          <small>Admin</small>
        </a>

        <div style="font-size: 12px; color: var(--muted); border-bottom: 1px solid var(--border); padding-bottom: 14px;">
          Sesión: <strong>{{ auth()->user()->name }}</strong>
        </div>

        <nav class="admin-nav">
          <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span>📊</span> Dashboard
          </a>
          <a href="{{ route('admin.settings.edit') }}" class="admin-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <span>✏️</span> CMS de Portada (Hero)
          </a>
          <a href="{{ route('admin.products.index') }}" class="admin-nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <span>💧</span> Catálogo de Productos
          </a>
          <a href="{{ route('home') }}" target="_blank" class="admin-nav-item">
            <span>🌐</span> Ver Sitio Público ↗
          </a>
        </nav>

        <div style="margin-top: auto; padding-top: 14px; border-top: 1px solid var(--border);">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-ghost btn-sm" style="width: 100%; cursor: pointer;">
              Cerrar sesión
            </button>
          </form>
        </div>
      </aside>

      <main class="admin-content">
        @if(session('success'))
          <div style="background: #eafff2; border: 1px solid #b7f0c8; color: #156d35; padding: 14px 18px; border-radius: 12px; font-size: 13px; margin-bottom: 24px;">
            ✅ {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div style="background: #fff1f1; border: 1px solid #ffd0d0; color: #9e1c1c; padding: 14px 18px; border-radius: 12px; font-size: 13px; margin-bottom: 24px;">
            ❌ {{ session('error') }}
          </div>
        @endif

        @yield('content')
      </main>
    </div>

    @stack('scripts')
</body>
</html>

