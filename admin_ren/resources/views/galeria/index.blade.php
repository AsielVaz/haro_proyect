@extends('layouts.app')
@section('title', 'Galería de autos')
@section('content')
<section class="panel mb-6"><div class="panel-heading"><div><p class="eyebrow">Carga múltiple</p><h3>Agregar fotografías</h3></div></div><form method="POST" enctype="multipart/form-data" action="{{ route('galeria.store') }}" class="flex flex-col gap-3 sm:flex-row">@csrf<input type="file" name="imagenes[]" multiple accept="image/jpeg,image/png,image/webp" class="field flex-1" required><button class="btn-primary">Subir a galería</button></form></section>
<div class="mb-5 flex items-center justify-between"><div><p class="eyebrow">Banco disponible</p><h3 class="text-xl font-bold">Imágenes sin asignar</h3></div><span class="badge badge-amber">{{ $imagenes->total() }} DISPONIBLES</span></div>
<div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6">
    @forelse($imagenes as $image)
        <article class="overflow-hidden rounded-2xl border border-white/8 bg-white/3"><img src="{{ $image->url }}" class="aspect-[4/3] w-full object-cover"><div class="p-3"><form method="POST" action="{{ route('galeria.assign',$image) }}" class="space-y-2" data-confirm="La fotografía quedará vinculada al auto seleccionado." data-confirm-title="¿Asignar fotografía?" data-confirm-action="Asignar">@csrf @method('PATCH')<select name="auto_id" class="field text-xs">@foreach($autos as $auto)<option value="{{ $auto->id }}">#{{ $auto->id }} {{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }}</option>@endforeach</select><button class="btn-secondary w-full justify-center">Asignar</button></form><form method="POST" action="{{ route('galeria.destroy',$image) }}" class="mt-2 text-center" data-confirm="La fotografía se eliminará de la galería y del almacenamiento. Esta acción no se puede deshacer." data-confirm-title="¿Eliminar fotografía?" data-confirm-action="Eliminar" data-confirm-danger>@csrf @method('DELETE')<button class="text-xs text-red-400">Eliminar</button></form></div></article>
    @empty
        <div class="panel col-span-full py-12 text-center text-zinc-500">No hay imágenes pendientes de asignar.</div>
    @endforelse
</div>
<div class="mt-8">{{ $imagenes->links() }}</div>
@endsection
