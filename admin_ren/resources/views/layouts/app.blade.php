<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel') · HARO Motor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-asphalt text-zinc-100 antialiased">
<div class="min-h-screen lg:grid lg:grid-cols-[270px_1fr]">
    <aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-50 flex w-[270px] -translate-x-full flex-col border-r border-white/8 bg-carbon transition-transform lg:sticky lg:top-0 lg:translate-x-0">
        <a href="{{ route('dashboard') }}" class="flex h-24 items-center gap-3 border-b border-white/8 px-7">
            <span class="grid size-12 place-items-center rounded-2xl bg-racing-red text-2xl shadow-glow">H</span>
            <span><strong class="block text-xl tracking-[.22em]">HARO</strong><small class="text-zinc-500">MOTOR CONTROL</small></span>
        </a>
        <nav class="flex-1 space-y-7 overflow-y-auto px-4 py-6">
            @php
                $groups = [
                    'Operación' => [
                        ['route' => 'dashboard', 'label' => 'Tablero', 'icon' => '◫'],
                        ['route' => 'autos.index', 'label' => 'Inventario', 'icon' => '◆'],
                        ['route' => 'autos.create', 'label' => 'Alta de auto', 'icon' => '+'],
                        ['route' => 'galeria.index', 'label' => 'Galería', 'icon' => '▧'],
                    ],
                    'Administración' => [
                        ['route' => 'catalogos.index', 'label' => 'Marcas y modelos', 'icon' => '⌁'],
                        ['route' => 'operaciones.index', 'params' => 'clientes', 'label' => 'Clientes', 'icon' => '◎'],
                        ['route' => 'operaciones.index', 'params' => 'ventas', 'label' => 'Ventas', 'icon' => '$'],
                        ['route' => 'operaciones.index', 'params' => 'pagos', 'label' => 'Pagos', 'icon' => '✓'],
                    ],
                    'Control' => [
                        ['route' => 'operaciones.index', 'params' => 'almacenes', 'label' => 'Almacenes', 'icon' => '⌂'],
                        ['route' => 'operaciones.index', 'params' => 'car-hunter', 'label' => 'Car Hunter', 'icon' => '⌖'],
                        ['route' => 'operaciones.index', 'params' => 'usuarios', 'label' => 'Usuarios', 'icon' => '◉'],
                    ],
                ];
            @endphp
            @foreach($groups as $group => $links)
                <div>
                    <p class="px-3 pb-2 text-[10px] font-bold uppercase tracking-[.22em] text-zinc-600">{{ $group }}</p>
                    <div class="space-y-1">
                        @foreach($links as $link)
                            <a href="{{ route($link['route'], $link['params'] ?? []) }}" class="nav-link {{ request()->routeIs($link['route']) && (!isset($link['params']) || request()->route('seccion') === $link['params']) ? 'active' : '' }}">
                                <span class="nav-icon">{{ $link['icon'] }}</span><span>{{ $link['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </nav>
        <div class="border-t border-white/8 p-4">
            <div class="mb-3 rounded-2xl bg-white/4 p-3"><p class="text-sm font-semibold">{{ session('haro_admin.nombre') }}</p><p class="text-xs text-amber-400">{{ session('haro_admin.permiso') }}</p></div>
            <form method="POST" action="{{ route('logout') }}" data-confirm="Tu sesión actual se cerrará de forma segura." data-confirm-title="¿Cerrar sesión?" data-confirm-action="Cerrar sesión">@csrf<button class="w-full rounded-xl border border-white/10 px-4 py-2 text-sm text-zinc-400 hover:border-red-500/40 hover:text-white">Cerrar sesión</button></form>
        </div>
    </aside>

    <main class="min-w-0">
        <header class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-white/8 bg-asphalt/85 px-5 backdrop-blur-xl md:px-9">
            <div class="flex items-center gap-4"><button data-sidebar-toggle class="grid size-10 place-items-center rounded-xl border border-white/10 lg:hidden">☰</button><div><p class="text-[10px] font-bold uppercase tracking-[.22em] text-amber-400">Centro de mando</p><h1 class="text-lg font-bold">@yield('title', 'Panel')</h1></div></div>
            <a href="{{ route('autos.create') }}" class="btn-primary hidden sm:inline-flex">+ Nuevo auto</a>
        </header>
        <div class="p-5 md:p-9">
            @yield('content')
        </div>
    </main>
</div>
<div data-sidebar-overlay class="fixed inset-0 z-40 hidden bg-black/70 lg:hidden"></div>
<x-liquid-alerts />
@stack('scripts')
</body>
</html>
