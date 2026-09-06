<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f7fa">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') · Haro Smart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-body antialiased">
<a class="skip-link" href="#main-content">Saltar al contenido</a>
<div class="min-h-screen lg:grid lg:grid-cols-[270px_1fr]">
    <aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-50 flex w-[270px] -translate-x-full flex-col lg:sticky lg:top-0 lg:translate-x-0" aria-label="Menú principal">
        <a href="{{ route('dashboard') }}" class="brand-lockup"><img src="{{ asset('images/haro-logo.png') }}" alt="Haro Seminuevos" width="90" height="51"><span><strong>Haro <em>Smart</em></strong><small>Gestión automotriz</small></span></a><button type="button" class="sidebar-close icon-button lg:hidden" data-sidebar-close aria-label="Cerrar menú">×</button>
        <nav aria-label="Navegación principal" class="flex-1 space-y-7 overflow-y-auto px-4 py-6">
            @php
                $groups = [
                    'Operación' => [
                        ['route' => 'dashboard', 'label' => 'Tablero', 'icon' => 'dashboard'],
                        ['route' => 'autos.index', 'label' => 'Inventario', 'icon' => 'car'],
                        ['route' => 'autos.create', 'label' => 'Alta de auto', 'icon' => 'plus'],
                        ['route' => 'galeria.index', 'label' => 'Galería', 'icon' => 'image'],
                    ],
                    'Administración' => [
                        ['route' => 'catalogos.index', 'label' => 'Marcas y modelos', 'icon' => 'catalog'],
                        ['route' => 'operaciones.index', 'params' => 'clientes', 'label' => 'Clientes', 'icon' => 'users'],
                        ['route' => 'operaciones.index', 'params' => 'ventas', 'label' => 'Ventas', 'icon' => 'sales'],
                        ['route' => 'operaciones.index', 'params' => 'pagos', 'label' => 'Pagos', 'icon' => 'check'],
                    ],
                    'Control' => [
                        ['route' => 'operaciones.index', 'params' => 'almacenes', 'label' => 'Almacenes', 'icon' => 'home'],
                        ['route' => 'operaciones.index', 'params' => 'car-hunter', 'label' => 'Car Hunter', 'icon' => 'target'],
                        ['route' => 'operaciones.index', 'params' => 'usuarios', 'label' => 'Usuarios', 'icon' => 'user'],
                    ],
                ];
            @endphp
            @foreach($groups as $group => $links)
                <div>
                    <p class="px-3 pb-2 text-[10px] font-bold uppercase tracking-[.22em] text-slate-500">{{ $group }}</p>
                    <div class="space-y-1">
                        @foreach($links as $link)
                            <a href="{{ route($link['route'], $link['params'] ?? []) }}" @if(request()->routeIs($link['route']) && (!isset($link['params']) || request()->route('seccion') === $link['params'])) aria-current="page" @endif class="nav-link {{ request()->routeIs($link['route']) && (!isset($link['params']) || request()->route('seccion') === $link['params']) ? 'active' : '' }}">
                                <span class="nav-icon"><x-icon :name="$link['icon']" /></span><span>{{ $link['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>
        <div class="sidebar-account border-t border-slate-200 p-4">
            <div class="mb-3 rounded-2xl bg-slate-50 p-3"><p class="text-sm font-semibold">{{ session('haro_admin.nombre') }}</p><p class="text-xs text-red-700">{{ session('haro_admin.permiso') }}</p></div>
            <form method="POST" action="{{ route('logout') }}" data-confirm="Tu sesión actual se cerrará de forma segura." data-confirm-title="¿Cerrar sesión?" data-confirm-action="Cerrar sesión">@csrf<button class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm text-slate-600 hover:border-red-500/40 hover:text-slate-900">Cerrar sesión</button></form>
        </div>
    </aside>

    <main id="main-content" tabindex="-1" class="min-w-0">
        <header class="app-header">
            <div class="flex items-center gap-4"><button type="button" data-sidebar-toggle aria-controls="sidebar" aria-expanded="false" aria-label="Abrir menú" class="icon-button lg:hidden"><x-icon name="menu" /></button><div><p class="text-[10px] font-bold uppercase tracking-[.22em] text-red-700">Haro Smart / Administración</p><h1 class="text-lg font-bold">@yield('title', 'Panel')</h1></div></div>
            <a href="{{ route('autos.create') }}" class="btn-primary hidden sm:inline-flex"><x-icon name="plus" /> Nuevo auto</a>
        </header>
        <div class="page-content p-5 md:p-9">
            @yield('content')
        </div>
    </main>
</div>
<div data-sidebar-overlay class="fixed inset-0 z-40 hidden bg-slate-900/35 lg:hidden"></div>
<x-liquid-alerts />
@stack('scripts')
</body>
</html>
