<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutoRequest;
use App\Models\Almacen;
use App\Models\Auto;
use App\Models\ClienteBanca;
use App\Models\Imagen;
use App\Models\Interior;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Transmision;
use App\Services\AutoQrLabelService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $autos = Auto::with(['marca:id,marca', 'modelo:id,modelo', 'imagenes:id,id_auto,url', 'almacen:id,des_gen'])
            ->when($request->string('q')->isNotEmpty(), function (Builder $query) use ($request): void {
                $term = '%'.$request->string('q')->toString().'%';
                $query->where(fn (Builder $sub) => $sub->where('descripcion', 'like', $term)->orWhere('anio', 'like', $term)->orWhereHas('marca', fn (Builder $brand) => $brand->where('marca', 'like', $term))->orWhereHas('modelo', fn (Builder $model) => $model->where('modelo', 'like', $term)));
            })
            ->when($request->filled('estado'), fn (Builder $query) => match ($request->string('estado')->toString()) {
                'vendidos' => $query->where('vendido', 1), 'consignacion' => $query->where('vendido', 0)->where('consig', 1), 'pausados' => $query->where('vendido', 0)->where('pausado', 1), default => $query->where('vendido', 0)
            })
            ->when(! $request->filled('estado'), fn (Builder $query) => $query->where('vendido', 0))
            ->orderByDesc('id')->paginate(30)->withQueryString();

        return view('autos.index', compact('autos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('autos.form', $this->formData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AutoRequest $request): RedirectResponse
    {
        $auto = DB::transaction(function () use ($request): Auto {
            $data = $this->normalizedData($request);
            $data += ['en_banner' => 0, 'pausado' => 0, 'imagen' => '', 'kilometragePermitido' => 0, 'fecha_subido' => now()->toDateString(), 'vendido' => 0, 'fecha_venta' => '1970-01-01 00:00:00', 'notificado' => 0, 'almacen_verificado' => 0];
            $auto = Auto::create($data);
            $this->assignGalleryImages($auto, $request->input('gallery_images', []));

            return $auto;
        });

        return redirect()->route('autos.edit', $auto)->with('success', 'Auto registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Auto $auto): RedirectResponse
    {
        return redirect()->route('autos.edit', $auto);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auto $auto): View
    {
        return view('autos.form', $this->formData($auto));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AutoRequest $request, Auto $auto): RedirectResponse
    {
        DB::transaction(function () use ($request, $auto): void {
            $auto->update($this->normalizedData($request));
            $this->assignGalleryImages($auto, $request->input('gallery_images', []));
            DB::table('log_cambio_auto')->insert(['id_auto' => $auto->id, 'ip' => mb_substr((string) $request->ip(), 0, 20), 'mensaje' => "El auto con id {$auto->id} fue actualizado desde Laravel", 'ultima_act' => now(), 'id_usuario' => session('haro_admin.id')]);
        });

        return back()->with('success', 'Cambios guardados.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auto $auto): RedirectResponse
    {
        DB::transaction(function () use ($auto): void {
            $snapshot = Arr::except($auto->getAttributes(), ['id', 'fecha_subido', 'consig', 'vendido', 'fecha_venta', 'notificado', 'fecha_cap', 'id_almacen', 'almacen_verificado']);
            $snapshot['id_previo'] = $auto->id;
            $snapshot['fecha_eliminacion'] = now();
            DB::table('autohistorico')->insert($snapshot);
            $auto->update(['vendido' => 1, 'fecha_venta' => now(), 'en_banner' => 0, 'pausado' => 1, 'consig' => 0]);
        });

        return redirect()->route('autos.index')->with('success', 'Auto movido a vendidos.');
    }

    public function togglePause(Auto $auto): RedirectResponse
    {
        $auto->update(['pausado' => ! $auto->pausado]);

        return back()->with('success', 'Estado actualizado.');
    }

    public function toggleBanner(Auto $auto): RedirectResponse
    {
        if ($auto->vendido || $auto->pausado) {
            return back()->with('error', 'Un auto vendido u oculto no puede mostrarse en el banner.');
        }

        $auto->update(['en_banner' => ! $auto->en_banner]);

        return back()->with('success', $auto->en_banner ? 'Auto agregado al banner principal.' : 'Auto retirado del banner principal.');
    }

    public function renew(Auto $auto): RedirectResponse
    {
        if ($auto->vendido) {
            return back()->with('error', 'No se puede renovar una unidad vendida.');
        }

        $newId = DB::transaction(function () use ($auto): int {
            $highestId = DB::table('auto')->orderByDesc('id')->lockForUpdate()->value('id');
            $nextId = ((int) $highestId) + 1;
            DB::table('auto')->where('id', $auto->id)->update(['id' => $nextId, 'notificado' => 0, 'fecha_subido' => now()->toDateString()]);
            DB::table('imagen')->where('id_auto', $auto->id)->update(['id_auto' => $nextId]);
            DB::table('log_cambio_auto')->where('id_auto', $auto->id)->update(['id_auto' => $nextId]);

            return $nextId;
        });

        return redirect()->route('autos.edit', $newId)->with('success', "Unidad renovada correctamente. Su nuevo folio es #{$newId}.");
    }

    public function restore(Auto $auto): RedirectResponse
    {
        if (! $auto->vendido) {
            return back()->with('warning', 'La unidad ya se encuentra activa.');
        }

        DB::transaction(function () use ($auto): void {
            $auto->update(['vendido' => 0, 'fecha_venta' => '1970-01-01 00:00:00', 'pausado' => 1, 'en_banner' => 0]);
            DB::table('autohistorico')->where('id_previo', $auto->id)->delete();
        });

        return redirect()->route('autos.index', ['estado' => 'pausados'])->with('success', 'Auto recuperado. Quedó oculto hasta que decidas publicarlo nuevamente.');
    }

    public function qr(Auto $auto, AutoQrLabelService $label): Response
    {
        $png = $label->generate($auto);

        return response($png, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="etiqueta-qr-auto-'.$auto->id.'.png"',
            'Content-Length' => (string) strlen($png),
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ]);
    }

    public function setCover(Auto $auto, Imagen $imagen): RedirectResponse
    {
        abort_unless((int) $imagen->id_auto === $auto->id, 422);
        $auto->update(['imagen' => $imagen->url]);

        return back()->with('success', 'Portada actualizada.');
    }

    private function formData(?Auto $auto = null): array
    {
        $auto?->load('imagenes');

        return ['auto' => $auto, 'marcas' => Marca::orderBy('marca')->get(), 'modelos' => Modelo::orderBy('modelo')->get(), 'transmisiones' => Transmision::orderBy('transmision')->get(), 'interiores' => Interior::orderBy('interior')->get(), 'clientes' => ClienteBanca::orderBy('nombre')->get(), 'almacenes' => Almacen::orderBy('des_gen')->get(), 'galeria' => Imagen::where('id_auto', 0)->orderByDesc('id')->limit(80)->get()];
    }

    private function normalizedData(AutoRequest $request): array
    {
        $data = Arr::except($request->validated(), ['gallery_images', 'consig']);
        $data['consig'] = $request->boolean('consig');

        return $data;
    }

    private function assignGalleryImages(Auto $auto, array $imageIds): void
    {
        if ($imageIds === []) {
            return;
        }
        Imagen::whereIn('id', $imageIds)->where('id_auto', 0)->update(['id_auto' => $auto->id]);
        if ($auto->imagen === '') {
            $auto->update(['imagen' => Imagen::where('id_auto', $auto->id)->value('url') ?? '']);
        }
    }
}
