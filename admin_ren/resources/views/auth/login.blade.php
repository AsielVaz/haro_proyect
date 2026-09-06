<!DOCTYPE html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Acceso · HARO Motor</title>@vite(['resources/css/app.css', 'resources/js/app.js'])</head>
<body class="grid min-h-screen place-items-center bg-asphalt p-6 text-white">
<div class="absolute inset-0 overflow-hidden"><div class="absolute -right-32 top-10 size-[520px] rounded-full bg-red-600/10 blur-3xl"></div><div class="absolute -left-24 bottom-0 size-96 rounded-full bg-amber-500/8 blur-3xl"></div></div>
<form method="POST" action="{{ route('login.store') }}" class="relative w-full max-w-md rounded-[2rem] border border-white/10 bg-carbon/90 p-8 shadow-2xl backdrop-blur-xl">@csrf
    <div class="mb-8 flex items-center gap-4"><span class="grid size-14 place-items-center rounded-2xl bg-racing-red text-2xl font-black shadow-glow">H</span><div><h1 class="text-2xl font-black tracking-[.18em]">HARO</h1><p class="text-xs uppercase tracking-widest text-zinc-500">Motor Control</p></div></div>
    <h2 class="text-xl font-bold">Bienvenido de vuelta</h2><p class="mb-7 mt-1 text-sm text-zinc-500">Accede al centro de operación automotriz.</p>
    <label class="field-label">Correo</label><input class="field" type="email" name="email" value="{{ old('email') }}" required autofocus>
    <label class="field-label mt-5">Contraseña</label><input class="field" type="password" name="password" required>
    <button class="btn-primary mt-7 w-full justify-center">Entrar al panel</button>
</form><x-liquid-alerts /></body></html>
