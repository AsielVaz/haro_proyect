<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Http\Requests\ModeloRequest;
use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CatalogoController extends Controller
{
    public function index(): View
    {
        return view('catalogos.index', ['marcas' => Marca::withCount('modelos')->orderBy('marca')->get(), 'modelos' => Modelo::with('marca:id,marca')->orderBy('modelo')->paginate(30)]);
    }

    public function storeMarca(MarcaRequest $request): RedirectResponse
    {
        $path = '';
        if ($request->hasFile('imagen')) {
            $name = 'marca_'.Str::uuid().'.'.$request->file('imagen')->guessExtension();
            $directory = dirname(base_path()).DIRECTORY_SEPARATOR.'cat_marcas_img';
            if (! is_dir($directory)) {
                mkdir($directory, 0775, true);
            }
            $request->file('imagen')->move($directory, $name);
            $path = '/cat_marcas_img/'.$name;
        }
        Marca::create(['marca' => $request->string('marca'), 'imagen' => $path]);

        return back()->with('success', 'Marca agregada.');
    }

    public function destroyMarca(Marca $marca): RedirectResponse
    {
        if ($marca->modelos()->exists()) {
            return back()->withErrors(['marca' => 'No se puede eliminar una marca que tiene modelos.']);
        }
        $marca->delete();

        return back()->with('success', 'Marca eliminada.');
    }

    public function storeModelo(ModeloRequest $request): RedirectResponse
    {
        Modelo::create($request->validated());

        return back()->with('success', 'Modelo agregado.');
    }

    public function destroyModelo(Modelo $modelo): RedirectResponse
    {
        if ($modelo->autos()->exists()) {
            return back()->withErrors(['modelo' => 'No se puede eliminar un modelo utilizado por autos.']);
        }
        $modelo->delete();

        return back()->with('success', 'Modelo eliminado.');
    }
}
