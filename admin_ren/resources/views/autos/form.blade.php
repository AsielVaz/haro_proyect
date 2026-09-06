@extends('layouts.app')
@section('title', $auto ? 'Editar unidad #'.$auto->id : 'Alta de auto')
@section('content')
<form method="POST" action="{{ $auto ? route('autos.update',$auto) : route('autos.store') }}" class="grid gap-6 xl:grid-cols-[1fr_360px]">@csrf @if($auto) @method('PUT') @endif
<div class="space-y-6">
<section class="panel"><div class="panel-heading"><div><p class="eyebrow">Ficha técnica</p><h3>Datos del vehículo</h3></div><span class="text-3xl text-red-500">◆</span></div>
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

<section class="panel"><div class="panel-heading"><div><p class="eyebrow">Banco de medios</p><h3>Seleccionar de la galería</h3></div><a href="{{ route('galeria.index',['estado'=>'libres']) }}" class="text-sm text-amber-400">Abrir galería →</a></div>
<div class="grid grid-cols-2 gap-3 md:grid-cols-4">@forelse($galeria as $image)<label class="gallery-choice"><input type="checkbox" name="gallery_images[]" value="{{ $image->id }}" class="peer sr-only"><img src="{{ $image->url }}" alt=""><span>Seleccionar</span></label>@empty<p class="col-span-full text-sm text-zinc-500">No hay imágenes libres.</p>@endforelse</div>
</section>

@if($auto && $auto->imagenes->isNotEmpty())<section class="panel"><div class="panel-heading"><div><p class="eyebrow">Imágenes asignadas</p><h3>Portada de la unidad</h3></div></div><div class="grid grid-cols-2 gap-3 md:grid-cols-4">@foreach($auto->imagenes as $image)<div class="overflow-hidden rounded-xl border {{ $auto->imagen===$image->url ? 'border-amber-400' : 'border-white/8' }}"><img src="{{ $image->url }}" class="aspect-video w-full object-cover"><button form="cover-{{ $image->id }}" class="w-full px-2 py-2 text-xs hover:bg-white/5">{{ $auto->imagen===$image->url ? 'Portada actual' : 'Usar como portada' }}</button></div>@endforeach</div></section>@endif
</div>
<aside class="space-y-5"><div class="panel sticky top-28"><p class="eyebrow">Publicación</p><h3 class="mt-1 text-xl font-bold">Guardar unidad</h3><p class="mt-2 text-sm text-zinc-500">Los datos quedarán disponibles en inventario y estadísticas.</p><button class="btn-primary mt-6 w-full justify-center">{{ $auto ? 'Guardar cambios' : 'Registrar auto' }}</button><a href="{{ route('autos.index') }}" class="btn-secondary mt-3 w-full justify-center">Cancelar</a>@if($auto && !$auto->vendido)<button type="submit" form="sell-auto" class="mt-5 w-full rounded-xl border border-red-500/25 px-4 py-2.5 text-sm font-bold text-red-300 hover:bg-red-500/10">Marcar como vendido</button>@endif</div></aside>
</form>
@if($auto)@foreach($auto->imagenes as $image)<form id="cover-{{ $image->id }}" method="POST" action="{{ route('autos.cover',[$auto,$image]) }}" data-confirm="Esta fotografía será la imagen principal de la unidad." data-confirm-title="¿Cambiar portada?" data-confirm-action="Cambiar portada">@csrf @method('PATCH')</form>@endforeach @endif
@if($auto && !$auto->vendido)<form id="sell-auto" method="POST" action="{{ route('autos.destroy', $auto) }}" data-confirm="La unidad #{{ $auto->id }} se archivará como vendida y dejará de aparecer entre los autos disponibles." data-confirm-title="¿Marcar auto como vendido?" data-confirm-action="Marcar vendido" data-confirm-danger>@csrf @method('DELETE')</form>@endif
@push('scripts')<script>window.HaroAdmin?.filterModels();</script>@endpush
@endsection
