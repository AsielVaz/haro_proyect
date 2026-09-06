@extends('layouts.app')
@section('title', $auto ? 'Editar unidad #'.$auto->id : 'Alta de auto')
@section('content')
<form method="POST" action="{{ $auto ? route('autos.update',$auto) : route('autos.store') }}" class="grid gap-6 xl:grid-cols-[1fr_360px]">@csrf @if($auto) @method('PUT') @endif
<div class="space-y-6">
<section class="panel"><div class="panel-heading"><div><p class="eyebrow">Ficha técnica</p><h3>Datos del vehículo</h3></div><x-icon name="car" class="size-7 text-red-600" /></div>
<div class="form-grid">
    <label><span>Marca</span><select class="field" id="brand" name="id_marca" required><option value="">Selecciona</option>@foreach($marcas as $marca)<option value="{{ $marca->id }}" @selected(old('id_marca',$auto?->id_marca)==$marca->id)>{{ $marca->marca }}</option>@endforeach</select></label>
    <label><span>Modelo</span><select class="field" id="model" name="id_modelo" required><option value="">Selecciona</option>@foreach($modelos as $modelo)<option value="{{ $modelo->id }}" data-brand="{{ $modelo->id_marca }}" @selected(old('id_modelo',$auto?->id_modelo)==$modelo->id)>{{ $modelo->modelo }}</option>@endforeach</select></label>
    <label><span>Transmisión</span><select class="field" name="id_transmision">@foreach($transmisiones as $item)<option value="{{ $item->id }}" @selected(old('id_transmision',$auto?->id_transmision)==$item->id)>{{ $item->transmision }}</option>@endforeach</select></label>
    <label><span>Interior</span><select class="field" name="id_interiores">@foreach($interiores as $item)<option value="{{ $item->id }}" @selected(old('id_interiores',$auto?->id_interiores)==$item->id)>{{ $item->interior }}</option>@endforeach</select></label>
    <label><span>Dueño</span><select class="field" name="id_duenio">@foreach($clientes as $item)<option value="{{ $item->id }}" @selected(old('id_duenio',$auto?->id_duenio)==$item->id)>{{ $item->nombre }} {{ $item->apellidos }}</option>@endforeach</select></label>
    <label><span>Almacén</span><select class="field" name="id_almacen"><option value="">Sin asignar</option>@foreach($almacenes as $item)<option value="{{ $item->id }}" @selected(old('id_almacen',$auto?->id_almacen)==$item->id)>{{ $item->des_gen }}</option>@endforeach</select></label>
    @foreach([['anio','Año','number'],['cilindrage','Cilindraje','number'],['precio','Precio','number'],['kilometrage','Kilometraje','number'],['asientos','Asientos','number'],['nacionalidad','Nacionalidad','text'],['estatus','Estatus','text'],['combustible','Combustible','text'],['color','Color','text'],['cuerpo','Carrocería','text'],['poder','Potencia','text']] as [$name,$label,$type])
    <label><span>{{ $label }}</span><input class="field" type="{{ $type }}" name="{{ $name }}" value="{{ old($name,$auto?->{$name}) }}" required></label>
    @endforeach
    <label class="flex items-center gap-3 pt-7"><input type="checkbox" name="consig" value="1" class="size-5 accent-red-600" @checked(old('consig',$auto?->consig))><span>Auto en consignación</span></label>
</div>
<label class="mt-5 block"><span class="field-label">Descripción comercial</span><textarea class="field min-h-36" name="descripcion" required>{{ old('descripcion',$auto?->descripcion) }}</textarea></label>
</section>

@if($auto && $auto->imagenes->isNotEmpty())
<section class="panel cover-library" aria-labelledby="cover-library-title">
    <div class="panel-heading">
        <div class="cover-library__heading"><span class="cover-library__icon"><x-icon name="image" /></span><div><p class="eyebrow">Imágenes asignadas</p><h3 id="cover-library-title">Portada de la unidad</h3></div></div>
        <span class="cover-library__total">{{ $auto->imagenes->count() }} fotografías</span>
    </div>
    <p class="cover-library__description">Elige la imagen que presentará este auto en el inventario. El cambio se aplica al confirmar.</p>
    <div class="cover-library__grid">
        @foreach($auto->imagenes as $image)
            <article class="cover-card {{ $auto->imagen === $image->url ? 'is-current' : '' }}">
                <div class="cover-card__photo">
                    <img loading="lazy" decoding="async" src="{{ $image->url }}" alt="Fotografía #{{ $image->id }} de {{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }}">
                    @if($auto->imagen === $image->url)<span class="cover-card__badge"><x-icon name="check" /> Portada actual</span>@endif
                </div>
                <div class="cover-card__body">
                    <div class="cover-card__meta"><span>Foto #{{ $image->id }}</span><x-icon name="image" /></div>
                    @if($auto->imagen === $image->url)
                        <span class="cover-card__active"><x-icon name="check" /> Imagen principal</span>
                    @else
                        <button type="submit" form="cover-{{ $image->id }}" class="cover-card__button" aria-label="Usar fotografía #{{ $image->id }} como portada"><x-icon name="image" /> Elegir como portada<x-icon name="arrow" /></button>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif

<section class="panel media-library" aria-labelledby="media-library-title">
    <div class="panel-heading">
        <div><p class="eyebrow">Banco de medios</p><h3 id="media-library-title">Seleccionar de la galería</h3></div>
        <a href="{{ route('galeria.index',['estado'=>'libres']) }}" class="btn-secondary"><x-icon name="image" /> Abrir galería</a>
    </div>
    <div class="media-library__intro">
        <p id="media-library-help">Elige las fotografías para esta unidad. Se vincularán al guardar los cambios.</p>
        <span class="media-library__count" data-gallery-count aria-live="polite" hidden></span>
    </div>
    <div class="media-library__grid" role="group" aria-label="Fotografías disponibles" aria-describedby="media-library-help">
        @forelse($galeria as $image)
            <label class="gallery-choice">
                <input type="checkbox" name="gallery_images[]" value="{{ $image->id }}" class="sr-only" aria-label="Seleccionar fotografía #{{ $image->id }}">
                <span class="gallery-choice__photo">
                    <img loading="lazy" decoding="async" src="{{ $image->url }}" alt="Fotografía de vehículo #{{ $image->id }}">
                    <span class="gallery-choice__check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 4 4 10-10" /></svg></span>
                </span>
                <span class="gallery-choice__footer">
                    <span class="gallery-choice__identity"><x-icon name="image" /><span>Foto <strong>#{{ $image->id }}</strong></span></span>
                    <span class="gallery-choice__status" aria-hidden="true"><span class="gallery-choice__idle">Seleccionar</span><span class="gallery-choice__selected">Seleccionada</span></span>
                </span>
            </label>
        @empty
            <div class="empty-state"><x-icon name="image" /><strong class="text-slate-800">Tu galería está al día</strong><p>No hay fotografías libres. Agrega nuevas imágenes desde la galería.</p></div>
        @endforelse
    </div>
</section>


</div>
<aside class="space-y-5"><div class="panel sticky top-28"><p class="eyebrow">Publicación</p><h3 class="mt-1 text-xl font-bold">Guardar unidad</h3><p class="mt-2 text-sm text-slate-500">Los datos quedarán disponibles en inventario y estadísticas.</p><button class="btn-primary mt-6 w-full justify-center">{{ $auto ? 'Guardar cambios' : 'Registrar auto' }}</button><a href="{{ route('autos.index') }}" class="btn-secondary mt-3 w-full justify-center">Cancelar</a>@if($auto && !$auto->vendido)<button type="submit" form="sell-auto" class="mt-5 w-full rounded-xl border border-red-500/25 px-4 py-2.5 text-sm font-bold text-red-700 hover:bg-red-500/10">Marcar como vendido</button>@endif</div></aside>
</form>
@if($auto)@foreach($auto->imagenes as $image)<form id="cover-{{ $image->id }}" method="POST" action="{{ route('autos.cover',[$auto,$image]) }}" data-confirm="Esta fotografía será la imagen principal de la unidad." data-confirm-title="¿Cambiar portada?" data-confirm-action="Cambiar portada">@csrf @method('PATCH')</form>@endforeach @endif
@if($auto && !$auto->vendido)<form id="sell-auto" method="POST" action="{{ route('autos.destroy', $auto) }}" data-confirm="La unidad #{{ $auto->id }} se archivará como vendida y dejará de aparecer entre los autos disponibles." data-confirm-title="¿Marcar auto como vendido?" data-confirm-action="Marcar vendido" data-confirm-danger>@csrf @method('DELETE')</form>@endif

@endsection
