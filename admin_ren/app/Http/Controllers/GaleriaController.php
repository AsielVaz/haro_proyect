<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Imagen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
