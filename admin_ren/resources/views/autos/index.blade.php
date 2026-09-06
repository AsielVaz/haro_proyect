@extends('layouts.app')
@section('title', 'Inventario')
@section('content')
<form role="search" aria-label="Filtrar inventario" class="mb-6 flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-3 sm:flex-row">
    <input class="field flex-1" aria-label="Buscar autos" name="q" value="{{ request('q') }}" placeholder="Buscar marca, modelo, año o descripción">
    <select class="field sm:w-52" aria-label="Estado del inventario" name="estado"><option value="">Disponibles</option>@foreach(['pausados'=>'Pausados','consignacion'=>'Consignación','vendidos'=>'Vendidos'] as $key=>$label)<option value="{{ $key }}" @selected(request('estado')===$key)>{{ $label }}</option>@endforeach</select>
    <button class="btn-secondary">Buscar</button>
</form>

<section class="panel overflow-hidden p-0">
    <div class="panel-heading p-6">
        <div><p class="eyebrow">Parque vehicular</p><h3>Lista de unidades</h3></div>
        <span class="badge badge-amber">{{ $autos->total() }} AUTOS</span>
    </div>

    <div class="divide-y divide-slate-100">
    @forelse($autos as $auto)
        @php($photo = $auto->imagen ?: $auto->imagenes->first()?->url)
        <article class="inventory-row">
            <div class="inventory-photo">
                @if($photo)<img loading="lazy" decoding="async" src="{{ $photo }}" alt="{{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }}">@else<x-icon name="car" />@endif
            </div>

            <div class="min-w-0">
                <p class="eyebrow">Unidad #{{ $auto->id }}</p>
                <h3 class="truncate text-lg font-black">{{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }}</h3>
                <p class="mt-1 text-xs text-slate-500">{{ $auto->anio }} · {{ number_format($auto->kilometrage) }} km · {{ $auto->combustible }} · {{ $auto->color }}</p>
            </div>

            <div class="inventory-price">
                <span>Precio</span>
                <strong>${{ number_format($auto->precio) }}</strong>
            </div>

            <div class="flex flex-wrap gap-2 lg:max-w-36">
                @if($auto->vendido)<span class="badge badge-red">VENDIDO</span>@endif
                @if($auto->consig)<span class="badge badge-amber">CONSIGNACIÓN</span>@endif
                @if($auto->pausado && !$auto->vendido)<span class="badge badge-red">OCULTO</span>@endif
                @if(!$auto->pausado && !$auto->vendido)<span class="badge badge-green">VISIBLE</span>@endif
                @if($auto->en_banner && !$auto->pausado)<span class="badge badge-blue">BANNER</span>@endif
                @if($auto->almacen)<span class="badge bg-slate-100 text-slate-600 ring-1 ring-slate-200">{{ $auto->almacen->des_gen }}</span>@endif
            </div>

            <x-vehicle-actions :auto="$auto" />
        </article>
    @empty
        <div class="empty-state"><x-icon name="car" /><strong class="text-slate-800">No encontramos unidades</strong><p>Prueba con otra búsqueda o cambia el estado seleccionado.</p><a href="{{ route('autos.index') }}" class="btn-secondary">Restablecer filtros</a></div>
    @endforelse
    </div>
</section>
<div class="mt-8">{{ $autos->links() }}</div>
@endsection
