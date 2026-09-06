@extends('layouts.app')
@section('title', 'Tablero automotriz')
@section('content')
<section class="mb-8 overflow-hidden rounded-[2rem] border border-white/8 bg-gradient-to-br from-zinc-900 to-black p-7 md:p-10">
    <div class="relative z-10 max-w-2xl"><span class="badge badge-red">OPERACIÓN EN VIVO</span><h2 class="mt-5 text-3xl font-black tracking-tight md:text-5xl">Tu inventario, bajo control.</h2><p class="mt-3 text-zinc-400">Autos, fotografías, ventas y catálogos en una sola cabina de mando.</p></div>
</section>
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
    @foreach([['Disponibles',$resumen->disponibles,'text-emerald-400'],['Consignación',$resumen->consignacion,'text-amber-400'],['Pausados',$resumen->pausados,'text-red-400'],['Pagos pendientes',$pagosPendientes,'text-sky-400'],['Valor inventario','$'.number_format($resumen->valor_inventario,0), 'text-white']] as $stat)
        <div class="metric-card"><p>{{ $stat[0] }}</p><strong class="{{ $stat[2] }}">{{ $stat[1] }}</strong></div>
    @endforeach
</div>
<div class="mt-7 grid gap-6 xl:grid-cols-[1.45fr_1fr]">
    <section class="panel"><div class="panel-heading"><div><p class="eyebrow">Últimas unidades</p><h3>Inventario reciente</h3></div><a href="{{ route('autos.index') }}" class="text-sm text-amber-400">Ver todos →</a></div>
        <div class="grid gap-4 md:grid-cols-2">@foreach($ultimosAutos as $auto)<a href="{{ route('autos.edit',$auto) }}" class="vehicle-row"><div class="vehicle-thumb">@if($auto->imagen)<img src="{{ $auto->imagen }}" alt="">@else<span>◆</span>@endif</div><div><strong>{{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }}</strong><p>{{ $auto->anio }} · {{ number_format($auto->kilometrage) }} km</p><span>${{ number_format($auto->precio) }}</span></div></a>@endforeach</div>
    </section>
    <section class="panel"><div class="panel-heading"><div><p class="eyebrow">Distribución</p><h3>Marcas activas</h3></div></div><div class="space-y-4">@foreach($marcas as $marca)<div><div class="mb-1 flex justify-between text-sm"><span>{{ $marca->marca }}</span><b>{{ $marca->cantidad }}</b></div><div class="h-2 rounded-full bg-white/5"><div class="h-2 rounded-full bg-gradient-to-r from-red-600 to-amber-400" style="width:{{ min(100,$marca->cantidad/max(1,$resumen->disponibles)*100) }}%"></div></div></div>@endforeach</div></section>
</div>
<section class="panel mt-7"><div class="panel-heading"><div><p class="eyebrow">Rendimiento comercial</p><h3>Ventas de los últimos 12 meses</h3></div></div>@php($maxVentas=max(1,(float)$ventas->max('monto')))<div class="flex h-52 items-end gap-2 border-b border-white/8 pb-2">@forelse($ventas as $periodo)<div class="group flex min-w-0 flex-1 flex-col items-center justify-end gap-2"><span class="hidden text-[10px] text-amber-300 group-hover:block">${{ number_format($periodo->monto/1000) }}k</span><div class="w-full rounded-t-lg bg-gradient-to-t from-red-700 to-amber-400" style="height:{{ max(5,($periodo->monto/$maxVentas)*165) }}px"></div><span class="text-[9px] text-zinc-600">{{ substr($periodo->periodo,2) }}</span></div>@empty<p class="m-auto text-sm text-zinc-500">Aún no hay ventas para graficar.</p>@endforelse</div></section>
@endsection
