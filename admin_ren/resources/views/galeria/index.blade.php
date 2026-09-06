@extends('layouts.app')
@section('title', 'Galería de autos')
@section('content')
<section class="panel mb-6"><div class="panel-heading"><div><p class="eyebrow">Carga múltiple</p><h3>Agregar fotografías</h3></div></div><p class="mb-4 text-sm text-slate-500">Selecciona fotografías JPG, PNG o WebP para preparar la presentación de tus unidades.</p><form method="POST" enctype="multipart/form-data" action="{{ route('galeria.store') }}" class="upload-zone flex flex-col gap-3 sm:flex-row">@csrf<input type="file" aria-label="Fotografías para subir" data-upload-input name="imagenes[]" multiple accept="image/jpeg,image/png,image/webp" class="field flex-1" required><button class="btn-primary">Subir a galería</button></form><p data-upload-status class="mt-3 text-xs text-slate-500" aria-live="polite"></p><div data-upload-preview class="upload-preview"></div></section>
<div class="mb-5 flex flex-wrap items-center justify-between gap-3"><div><p class="eyebrow">Banco disponible</p><h3 class="text-xl font-bold">Imágenes sin asignar</h3><p class="mt-2 text-sm text-slate-500">Elige un auto en cada fotografía y guarda todas las asignaciones de esta página al terminar.</p></div><span class="badge badge-amber">{{ $imagenes->total() }} DISPONIBLES</span></div>
@if($imagenes->isNotEmpty())
    <form id="gallery-assignments" method="POST" action="{{ route('galeria.assign-batch') }}" data-gallery-assignments data-confirm="Se guardarán las fotografías que tengan un auto seleccionado. Las demás seguirán sin asignar." data-confirm-title="¿Guardar asignaciones?" data-confirm-action="Guardar cambios">
        @csrf
        @method('PATCH')
        <div class="gallery-save-bar">
            <div><strong data-assignment-count aria-live="polite">Selecciona los autos para tus fotografías</strong><p>Los cambios se aplican al guardar. Guarda antes de cambiar de página.</p></div>
            <button type="submit" class="btn-primary" data-save-assignments><x-icon name="check" /> Guardar cambios</button>
        </div>
    </form>
@endif
<div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6">
    @forelse($imagenes as $image)
        <article class="gallery-assignment-card overflow-hidden rounded-2xl border border-slate-200 bg-white" data-assignment-card>
            <img loading="lazy" decoding="async" src="{{ $image->url }}" class="aspect-[4/3] w-full object-cover" alt="Fotografía de vehículo #{{ $image->id }}">
            <div class="space-y-3 p-3">
                <div class="flex flex-wrap items-center justify-between gap-2"><span class="text-xs font-semibold text-slate-600">Foto #{{ $image->id }}</span><span class="badge badge-amber" data-assignment-pending hidden>Sin guardar</span></div>
                <input type="hidden" form="gallery-assignments" name="assignments[{{ $image->id }}][image_id]" value="{{ $image->id }}">
                <div class="vehicle-picker" data-vehicle-picker>
                    <select id="vehicle-select-{{ $image->id }}" form="gallery-assignments" aria-label="Auto para la fotografía #{{ $image->id }}" name="assignments[{{ $image->id }}][auto_id]" class="field text-xs" data-vehicle-select>
                        <option value="">Selecciona un auto</option>
                        @foreach($autos as $auto)<option value="{{ $auto->id }}" @selected(old('assignments.'.$image->id.'.auto_id') == $auto->id)>#{{ $auto->id }} {{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }} · {{ $auto->anio }}</option>@endforeach
                    </select>
                </div>
                <button type="button" class="text-xs font-medium text-slate-500 hover:text-red-700" data-clear-assignment hidden>Quitar selección</button>
                <form method="POST" action="{{ route('galeria.destroy',$image) }}" class="border-t border-slate-100 pt-2 text-center" data-confirm="La fotografía se eliminará de la galería y del almacenamiento. Esta acción no se puede deshacer." data-confirm-title="¿Eliminar fotografía?" data-confirm-action="Eliminar" data-confirm-danger>@csrf @method('DELETE')<button class="text-xs text-red-700">Eliminar</button></form>
            </div>
        </article>
    @empty
        <div class="panel col-span-full py-12 text-center text-slate-500">No hay imágenes pendientes de asignar.</div>
    @endforelse
</div>
<div class="mt-8">{{ $imagenes->links() }}</div>
@endsection
