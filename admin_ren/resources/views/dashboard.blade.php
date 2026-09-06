@extends('layouts.app')
@section('title', 'Resumen general')
@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
    @foreach([['Disponibles',$resumen->disponibles,'text-emerald-700'],['Consignación',$resumen->consignacion,'text-amber-800'],['Pausados',$resumen->pausados,'text-red-700'],['Pagos pendientes',$pagosPendientes,'text-sky-700'],['Valor inventario','$'.number_format($resumen->valor_inventario,0), 'text-slate-900']] as $stat)
        <div class="metric-card"><div class="metric-icon"><x-icon name="car" /></div><p>{{ $stat[0] }}</p><strong class="{{ $stat[2] }}">{{ $stat[1] }}</strong></div>
    @endforeach
</div>
<div class="mt-7 grid gap-6 xl:grid-cols-[1.45fr_1fr]">
    <section class="panel"><div class="panel-heading"><div><p class="eyebrow">Últimas unidades</p><h3>Inventario reciente</h3></div><a href="{{ route('autos.index') }}" class="text-sm text-amber-800">Ver todos →</a></div>
        <div class="grid gap-4 md:grid-cols-2">@forelse($ultimosAutos as $auto)
<article data-inventory-context data-context-all aria-label="{{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }}, unidad #{{ $auto->id }}">
<a href="{{ route('autos.edit',$auto) }}" class="vehicle-row h-full"><div class="vehicle-thumb">@if($auto->imagen)<img src="{{ $auto->imagen }}" alt="" loading="lazy" decoding="async">@else<x-icon name="car" />@endif</div><div><strong>{{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }}</strong><p>{{ $auto->anio }} · {{ number_format($auto->kilometrage) }} km</p><span>${{ number_format($auto->precio) }}</span></div></a>
<div hidden><x-vehicle-actions :auto="$auto" /></div>
</article>
@empty<div class="empty-state"><x-icon name="car" /><p>Tu próximo auto empieza aquí.</p><a class="btn-secondary" href="{{ route('autos.create') }}">Registrar primera unidad</a></div>@endforelse</div>
    </section>
    <section class="panel"><div class="panel-heading"><div><p class="eyebrow">Distribución</p><h3>Marcas activas</h3></div></div><div class="space-y-4">@forelse($marcas as $marca)<div><div class="mb-1 flex justify-between text-sm"><span>{{ $marca->marca }}</span><b>{{ $marca->cantidad }}</b></div><div class="h-2 rounded-full bg-slate-100"><div class="chart-bar h-2 rounded-full bg-gradient-to-r from-red-700 to-red-400" style="width:{{ min(100,$marca->cantidad/max(1,$resumen->disponibles)*100) }}%"></div></div></div>@empty<p class="py-6 text-sm text-slate-500">Las marcas aparecerán al registrar unidades.</p>@endforelse</div></section>
</div>
<section class="panel mt-7"><div class="panel-heading"><div><p class="eyebrow">Rendimiento comercial</p><h3>Ventas de los últimos 12 meses</h3></div></div>@php($maxVentas=max(1,(float)$ventas->max('monto')))<div class="flex h-52 items-end gap-2 border-b border-slate-200 pb-2">@forelse($ventas as $periodo)<div class="group flex min-w-0 flex-1 flex-col items-center justify-end gap-2"><span class="text-[10px] text-slate-600">${{ number_format($periodo->monto/1000) }}k</span><div class="chart-bar w-full rounded-t-lg bg-gradient-to-t from-slate-700 to-slate-400" style="height:{{ max(5,($periodo->monto/$maxVentas)*165) }}px"></div><span class="text-[9px] text-slate-500">{{ substr($periodo->periodo,2) }}</span></div>@empty<p class="m-auto text-sm text-slate-500">Aún no hay ventas para graficar.</p>@endforelse</div></section>
@endsection
