<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f7fa">
    <title>Acceso · Haro Smart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-page">
    <main class="login-shell">
        <section class="login-story" aria-label="Haro Smart">
            <div class="flex items-center gap-4"><img class="login-logo" src="{{ asset('images/haro-logo.png') }}" alt="Haro Seminuevos" width="100" height="56"><span class="border-l border-slate-300 pl-4 text-sm font-semibold">Haro <span class="text-red-700">Smart</span></span></div>
            <div><span class="hero-kicker mt-10">Tu siguiente nivel</span><h1>El control de tu negocio.<br><span class="text-red-700">En tus manos.</span></h1><p>Conecta tu inventario, tus clientes y cada nueva venta en un solo lugar.</p></div>
            <img src="{{ asset('images/smart-drive.svg') }}" class="hero-art my-5 hidden lg:block" alt="" width="640" height="320">
            <div class="mt-6 flex flex-wrap gap-5 text-xs font-medium text-slate-600"><span class="flex items-center gap-2"><x-icon name="car" /> Inventario</span><span class="flex items-center gap-2"><x-icon name="users" /> Clientes</span><span class="flex items-center gap-2"><x-icon name="sales" /> Ventas</span></div>
        </section>
        <section class="login-form">
            <p class="eyebrow">Bienvenido a Haro Smart</p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight">Inicia sesión</h2>
            <p class="mb-8 mt-3 text-sm leading-6 text-slate-500">Ingresa con tu cuenta para continuar con la operación de tu agencia.</p>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <label for="email" class="field-label">Correo electrónico</label>
                <input id="email" class="field" type="email" name="email" value="{{ old('email') }}" autocomplete="username" placeholder="tu@correo.com" required autofocus>
                <label for="password" class="field-label mt-5">Contraseña</label>
                <div class="password-wrap"><input id="password" class="field pr-20" type="password" name="password" autocomplete="current-password" placeholder="Tu contraseña" required><button type="button" class="password-toggle" data-password-toggle aria-controls="password" aria-pressed="false">Mostrar</button></div>
                <button class="btn-primary mt-7 w-full justify-between" type="submit">Entrar a Haro Smart <x-icon name="arrow" /></button>
            </form>
            <p class="mt-8 border-t border-slate-100 pt-6 text-xs leading-5 text-slate-500">¿Necesitas acceso? Contacta al administrador de tu agencia.</p>
        </section>
    </main>
    <x-liquid-alerts />
</body>
</html>
