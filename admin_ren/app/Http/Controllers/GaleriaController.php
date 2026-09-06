<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Imagen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class GaleriaController extends Controller
{
    public function index(): View
    {
        $imagenes = Imagen::where('id_auto', 0)->orderByDesc('id')->paginate(36);

        return view('galeria.index', ['imagenes' => $imagenes, 'autos' => Auto::with(['marca:id,marca', 'modelo:id,modelo'])->where('vendido', 0)->orderByDesc('id')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(['imagenes' => ['required', 'array', 'max:20'], 'imagenes.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:12288']]);
        $directory = dirname(base_path()).DIRECTORY_SEPARATOR.'cat_autos_img';
        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }
        foreach ($validated['imagenes'] as $upload) {
            $name = 'panel_'.Str::uuid().'.'.$upload->guessExtension();
            $upload->move($directory, $name);
            Imagen::create(['id_auto' => 0, 'url' => '/cat_autos_img/'.$name, 'fecha_subida' => now()]);
        }

        return back()->with('success', 'Imágenes agregadas a la galería.');
    }

    public function assignBatch(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'assignments' => ['required', 'array', 'min:1', 'max:36'],
            'assignments.*' => ['required', 'array:image_id,auto_id'],
            'assignments.*.image_id' => ['required', 'integer', 'distinct'],
            'assignments.*.auto_id' => ['nullable', 'integer'],
        ]);
        $assignments = collect($validated['assignments'])
            ->filter(fn (array $assignment): bool => ! empty($assignment['auto_id']));

        if ($assignments->isEmpty()) {
            throw ValidationException::withMessages(['assignments' => 'Selecciona un auto en al menos una fotografía.']);
        }

        DB::transaction(function () use ($assignments): void {
            $autoIds = $assignments->pluck('auto_id')->unique();
            $autos = Auto::whereIn('id', $autoIds)->where('vendido', 0)
                ->orderBy('id')->lockForUpdate()->get()->keyBy('id');
            $imagenes = Imagen::whereIn('id', $assignments->pluck('image_id'))
                ->where('id_auto', 0)->orderBy('id')->lockForUpdate()->get()->keyBy('id');

            if ($autos->count() !== $autoIds->count()) {
                throw ValidationException::withMessages(['assignments' => 'Uno de los autos ya no está disponible. Revisa las selecciones antes de guardar.']);
            }
            if ($imagenes->count() !== $assignments->count()) {
                throw ValidationException::withMessages(['assignments' => 'Una fotografía ya fue asignada o eliminada. Actualiza la galería y vuelve a seleccionar.']);
            }

            foreach ($assignments as $assignment) {
                $imagen = $imagenes->get($assignment['image_id']);
                $auto = $autos->get($assignment['auto_id']);
                $imagen->update(['id_auto' => $auto->id]);
                if (empty($auto->imagen)) {
                    $auto->update(['imagen' => $imagen->url]);
                }
            }
        });

        return back()->with('success', $assignments->count().' fotografías asignadas correctamente.');
    }

    public function assign(Request $request, Imagen $imagen): RedirectResponse
    {
        $validated = $request->validate(['auto_id' => ['required', 'integer', 'exists:auto,id']]);
        $imagen->update(['id_auto' => $validated['auto_id']]);
        $auto = Auto::findOrFail($validated['auto_id']);
        if ($auto->imagen === '') {
            $auto->update(['imagen' => $imagen->url]);
        }

        return back()->with('success', 'Imagen asignada al auto.');
    }

    public function destroy(Imagen $imagen): RedirectResponse
    {
        abort_unless((int) $imagen->id_auto === 0, 422, 'Solo se pueden eliminar imágenes sin asignar.');
        $absolutePath = dirname(base_path()).str_replace('/', DIRECTORY_SEPARATOR, $imagen->url);
        $imagen->delete();
        if (is_file($absolutePath)) {
            unlink($absolutePath);
        }

        return back()->with('success', 'Imagen eliminada.');
    }
}
