@extends('layouts.app')
@section('title', 'Inventario')
@section('content')
<form class="mb-6 flex flex-col gap-3 rounded-2xl border border-white/8 bg-white/3 p-3 sm:flex-row">
    <input class="field flex-1" name="q" value="{{ request('q') }}" placeholder="Buscar marca, modelo, año o descripción">
    <select class="field sm:w-52" name="estado"><option value="">Disponibles</option>@foreach(['pausados'=>'Pausados','consignacion'=>'Consignación','vendidos'=>'Vendidos'] as $key=>$label)<option value="{{ $key }}" @selected(request('estado')===$key)>{{ $label }}</option>@endforeach</select>
    <button class="btn-secondary">Buscar</button>
</form>

<section class="panel overflow-hidden p-0">
    <div class="panel-heading p-6">
        <div><p class="eyebrow">Parque vehicular</p><h3>Lista de unidades</h3></div>
        <span class="badge badge-amber">{{ $autos->total() }} AUTOS</span>
    </div>

    <div class="divide-y divide-white/7">
    @forelse($autos as $auto)
        @php($photo = $auto->imagen ?: $auto->imagenes->first()?->url)
        <article class="inventory-row">
            <div class="inventory-photo">
                @if($photo)<img src="{{ $photo }}" alt="{{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }}">@else<span>◆</span>@endif
            </div>

            <div class="min-w-0">
                <p class="eyebrow">Unidad #{{ $auto->id }}</p>
                <h3 class="truncate text-lg font-black">{{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }}</h3>
                <p class="mt-1 text-xs text-zinc-500">{{ $auto->anio }} · {{ number_format($auto->kilometrage) }} km · {{ $auto->combustible }} · {{ $auto->color }}</p>
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
                @if($auto->almacen)<span class="badge bg-white/5 text-zinc-400 ring-1 ring-white/10">{{ $auto->almacen->des_gen }}</span>@endif
            </div>

            <div class="inventory-actions">
                @if(!$auto->vendido)
                    <a class="vehicle-action vehicle-action--green" href="{{ route('operaciones.index', ['seccion' => 'ventas', 'auto' => $auto->id]) }}"><span>↗</span> Venta nueva</a>
                    <a class="vehicle-action vehicle-action--amber" href="{{ route('autos.edit', $auto) }}"><span>✎</span> Editar</a>
                    <form method="POST" action="{{ route('autos.renew', $auto) }}" data-confirm="La unidad pasará al inicio del inventario con un folio nuevo; sus imágenes y registros asociados se conservarán." data-confirm-title="¿Renovar publicación?" data-confirm-action="Renovar">@csrf @method('PATCH')<button class="vehicle-action vehicle-action--blue" type="submit"><span>↻</span> Renovar</button></form>
                    <a class="vehicle-action" href="{{ route('autos.qr', $auto) }}"><span>▦</span> Código QR</a>
                    <form method="POST" action="{{ route('autos.pause', $auto) }}" data-confirm="{{ $auto->pausado ? 'La unidad volverá a mostrarse públicamente.' : 'La unidad dejará de mostrarse públicamente.' }}" data-confirm-title="{{ $auto->pausado ? '¿Mostrar unidad?' : '¿Ocultar unidad?' }}" data-confirm-action="{{ $auto->pausado ? 'Mostrar' : 'Ocultar' }}">@csrf @method('PATCH')<button class="vehicle-action {{ $auto->pausado ? 'vehicle-action--green' : '' }}" type="submit"><span>{{ $auto->pausado ? '◉' : '⊘' }}</span> {{ $auto->pausado ? 'Poner visible' : 'Ocultar' }}</button></form>
                    @if(!$auto->pausado)
                        <form method="POST" action="{{ route('autos.banner', $auto) }}" data-confirm="{{ $auto->en_banner ? 'La unidad se retirará del banner principal.' : 'La unidad se destacará en el banner principal del sitio.' }}" data-confirm-title="{{ $auto->en_banner ? '¿Quitar del banner?' : '¿Mostrar en banner?' }}" data-confirm-action="{{ $auto->en_banner ? 'Quitar' : 'Agregar' }}">@csrf @method('PATCH')<button class="vehicle-action {{ $auto->en_banner ? '' : 'vehicle-action--blue' }}" type="submit"><span>▣</span> {{ $auto->en_banner ? 'Quitar banner' : 'Poner banner' }}</button></form>
                    @endif
                    <form method="POST" action="{{ route('autos.destroy', $auto) }}" data-confirm="La unidad se archivará como vendida, se ocultará del sitio y saldrá del inventario disponible." data-confirm-title="¿Archivar como vendido?" data-confirm-action="Archivar auto" data-confirm-danger>@csrf @method('DELETE')<button class="vehicle-action vehicle-action--red" type="submit"><span>⌫</span> Eliminar</button></form>
                @else
                    <a class="vehicle-action vehicle-action--amber" href="{{ route('autos.edit', $auto) }}"><span>✎</span> Consultar / editar</a>
                    <a class="vehicle-action" href="{{ route('autos.qr', $auto) }}"><span>▦</span> Código QR</a>
                    <form method="POST" action="{{ route('autos.restore', $auto) }}" data-confirm="La unidad regresará al inventario en estado oculto para que puedas revisarla antes de publicarla." data-confirm-title="¿Recuperar unidad?" data-confirm-action="Recuperar">@csrf @method('PATCH')<button class="vehicle-action vehicle-action--green" type="submit"><span>↺</span> Recuperar</button></form>
                @endif
            </div>
        </article>
    @empty
        <div class="p-12 text-center text-zinc-500">No hay unidades con estos filtros.</div>
    @endforelse
    </div>
</section>
<div class="mt-8">{{ $autos->links() }}</div>
@endsection
