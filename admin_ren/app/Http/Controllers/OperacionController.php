<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Auto;
use App\Models\CarHunter;
use App\Models\ClienteBanca;
use App\Models\Pago;
use App\Models\PagoEvento;
use App\Models\UsuarioHaro;
use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OperacionController extends Controller
{
    public function index(Request $request, string $seccion): View
    {
        $editable = in_array($seccion, ['clientes', 'almacenes', 'usuarios'], true);
        $canManage = $seccion !== 'usuarios' || session('haro_admin.permiso') === 'Banca';
        $editing = null;
        if ($editable && $request->filled('editar')) {
            abort_unless($canManage, 403);
            $request->validate(['editar' => ['integer', 'min:1']]);
            $editing = $this->record($seccion, $request->integer('editar'));
        }
        [$title, $columns, $query] = match ($seccion) {
            'clientes' => ['Clientes', ['id' => 'ID', 'nombre' => 'Nombre', 'apellidos' => 'Apellidos', 'email' => 'Correo', 'telefono' => 'Teléfono', 'comision' => 'Comisión'], ClienteBanca::query()->orderByDesc('id')],
            'ventas' => ['Ventas', ['id' => 'Folio', 'id_auto' => 'Auto', 'id_cliente' => 'Cliente', 'precio_pactado' => 'Precio pactado', 'pago_inicial' => 'Inicial', 'estatus_venta' => 'Estado', 'fecha_inserta' => 'Fecha'], Venta::query()->when($request->filled('estado'), fn ($query) => $query->where('estatus_venta', $request->string('estado')->toString()))->orderByDesc('id')],
            'pagos' => ['Pagos', ['id' => 'Folio', 'id_venta' => 'Venta', 'monto' => 'Monto', 'estatus' => 'Estado', 'fecha_pago' => 'Fecha', 'metodo' => 'Método'], Pago::query()->when($request->filled('estado'), fn ($query) => $query->where('estatus', $request->string('estado')->toString()))->orderByDesc('id')],
            'almacenes' => ['Almacenes', ['id' => 'ID', 'des_gen' => 'Nombre', 'direccion' => 'Dirección', 'cp' => 'CP', 'lat' => 'Latitud', 'lon' => 'Longitud'], Almacen::query()->orderBy('des_gen')],
            'car-hunter' => ['Car Hunter', ['id' => 'ID', 'nombre' => 'Nombre', 'email' => 'Correo', 'marca' => 'Marca', 'modelo' => 'Modelo', 'precio_min' => 'Precio mín.', 'precio_max' => 'Precio máx.', 'fecha' => 'Fecha'], CarHunter::query()->orderByDesc('id')],
            'usuarios' => ['Usuarios', ['id' => 'ID', 'nombre' => 'Nombre', 'email' => 'Correo', 'telefono' => 'Teléfono', 'permiso_banca' => 'Perfil'], UsuarioHaro::query()->orderBy('nombre')],
            default => abort(404),
        };
        /** @var LengthAwarePaginator $records */
        $records = $query->paginate(30)->withQueryString();

        return view('operaciones.index', compact('title', 'columns', 'records', 'seccion', 'editable', 'canManage', 'editing') + [
            'autos' => in_array($seccion, ['ventas'], true) ? Auto::with(['marca:id,marca', 'modelo:id,modelo'])->where('vendido', 0)->orderByDesc('id')->get() : collect(),
            'clientes' => $seccion === 'ventas' ? ClienteBanca::orderBy('nombre')->get() : collect(),
            'ventas' => $seccion === 'pagos' ? Venta::orderByDesc('id')->get() : collect(),
        ]);
    }

    public function store(Request $request, string $seccion): RedirectResponse
    {
        abort_if($seccion === 'usuarios' && session('haro_admin.permiso') !== 'Banca', 403);
        match ($seccion) {
            'clientes' => $this->createClient($request),
            'almacenes' => $this->createWarehouse($request),
            'car-hunter' => $this->createHunterRequest($request),
            'usuarios' => $this->createUser($request),
            'ventas' => $this->createSale($request),
            'pagos' => $this->createPayment($request),
            default => abort(404),
        };

        return back()->with('success', 'Registro agregado correctamente.');
    }

    public function approvePayment(Pago $pago): RedirectResponse
    {
        abort_unless(session('haro_admin.permiso') === 'Banca', 403);

        DB::transaction(function () use ($pago): void {
            $pago->update(['estatus' => 'Aprobado', 'usuario_aprueba' => session('haro_admin.id')]);
            $venta = Venta::find($pago->id_venta);
            if ($venta) {
                $approved = Pago::where('id_venta', $venta->id)->where('estatus', 'Aprobado')->sum('monto');
                if ((float) $approved >= (float) $venta->precio_pactado + (float) $venta->comision) {
                    $venta->update(['estatus_venta' => 'Liquidada']);
                }
            }
        });

        return back()->with('success', 'Pago aprobado correctamente.');
    }

    private function record(string $seccion, int $registro): ClienteBanca|Almacen|UsuarioHaro
    {
        return match ($seccion) {
            'clientes' => ClienteBanca::findOrFail($registro),
            'almacenes' => Almacen::findOrFail($registro),
            'usuarios' => UsuarioHaro::findOrFail($registro),
            default => abort(404),
        };
    }

    public function update(Request $request, string $seccion, int $registro): RedirectResponse
    {
        abort_if($seccion === 'usuarios' && session('haro_admin.permiso') !== 'Banca', 403);
        $record = $this->record($seccion, $registro);
        if ($seccion === 'usuarios' && (int) session('haro_admin.id') === $registro && $request->input('permiso_banca') !== 'Banca') {
            throw ValidationException::withMessages(['permiso_banca' => 'No puedes retirar el perfil Banca de tu propia cuenta.']);
        }
        match ($seccion) {
            'clientes' => $this->createClient($request, $record),
            'almacenes' => $this->createWarehouse($request, $record),
            'usuarios' => $this->createUser($request, $record),
        };

        return redirect()->route('operaciones.index', $seccion)->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy(string $seccion, int $registro): RedirectResponse
    {
        abort_if($seccion === 'usuarios' && session('haro_admin.permiso') !== 'Banca', 403);
        $record = $this->record($seccion, $registro);
        $blocked = match ($seccion) {
            'clientes' => Venta::where('id_cliente', $registro)->exists() || Auto::where('id_duenio', $registro)->exists(),
            'almacenes' => Auto::where('id_almacen', $registro)->exists(),
            'usuarios' => (int) session('haro_admin.id') === $registro
                || Venta::where('usuario_inserta', $registro)->exists()
                || Pago::where('usuario_inserta', $registro)->orWhere('usuario_aprueba', $registro)->exists()
                || DB::table('log_cambio_auto')->where('id_usuario', $registro)->exists(),
        };
        if ($blocked) {
            return back()->withErrors(['registro' => 'No se puede eliminar: el registro tiene operaciones asociadas o corresponde a tu cuenta actual.']);
        }
        $record->delete();

        return redirect()->route('operaciones.index', $seccion)->with('success', 'Registro eliminado correctamente.');
    }

    private function createClient(Request $request, ?ClienteBanca $record = null): ClienteBanca
    {
        $data = $request->validate(['nombre' => ['required', 'string', 'max:50'], 'apellidos' => ['required', 'string', 'max:100'], 'email' => ['required', 'email', 'max:100'], 'telefono' => ['required', 'string', 'max:20'], 'comision' => ['nullable', 'numeric', 'min:0']]);
        $data['comision'] ??= 0;
        if ($record) {
            $record->update($data);

            return $record;
        }
        $data['imagen'] = '';

        return ClienteBanca::create($data);
    }

    private function createWarehouse(Request $request, ?Almacen $record = null): Almacen
    {
        $data = $request->validate(['des_gen' => ['required', 'string', 'max:100'], 'direccion' => ['required', 'string', 'max:350'], 'cp' => ['required', 'string', 'max:15'], 'lat' => ['nullable', 'numeric'], 'lon' => ['nullable', 'numeric']]);
        $data['lat'] ??= 0;
        $data['lon'] ??= 0;
        if ($record) {
            $record->update($data);

            return $record;
        }

        return Almacen::create($data);
    }

    private function createHunterRequest(Request $request): CarHunter
    {
        $data = $request->validate(['nombre' => ['required', 'string', 'max:50'], 'email' => ['required', 'email', 'max:100'], 'marca' => ['required', 'string', 'max:20'], 'modelo' => ['nullable', 'string', 'max:20'], 'precio_min' => ['required', 'integer', 'min:0'], 'precio_max' => ['required', 'integer', 'gte:precio_min'], 'anio_min' => ['required', 'integer'], 'anio_max' => ['required', 'integer', 'gte:anio_min']]);
        $data['modelo'] ??= '';
        $data['avisado'] = 0;
        $data['fecha'] = now();

        return CarHunter::create($data);
    }

    private function createUser(Request $request, ?UsuarioHaro $record = null): UsuarioHaro
    {
        $data = $request->validate(['nombre' => ['required', 'string', 'max:45'], 'email' => ['required', 'email', 'max:45', Rule::unique('usuario', 'email')->ignore($record)], 'password' => [$record ? 'nullable' : 'required', 'string', 'min:6'], 'telefono' => ['nullable', 'string', 'max:45'], 'permiso_banca' => ['required', 'in:Banca,Cashier']]);
        if ($record) {
            $attributes = ['nombre' => $data['nombre'], 'email' => $data['email'], 'telefono' => $data['telefono'] ?? '', 'permiso_banca' => $data['permiso_banca']];
            if (! empty($data['password'])) {
                $attributes['contrasena'] = sha1($data['password']);
            }
            $record->update($attributes);

            return $record;
        }

        return UsuarioHaro::create(['nombre' => $data['nombre'], 'email' => $data['email'], 'contrasena' => sha1($data['password']), 'telefono' => $data['telefono'] ?? '', 'permiso_banca' => $data['permiso_banca'], 'permiso' => 100, 'tipo_usuario' => 100]);
    }

    private function createSale(Request $request): Venta
    {
        $data = $request->validate(['id_auto' => ['required', 'integer', 'exists:auto,id'], 'id_cliente' => ['required', 'integer', 'exists:clientes_banca,id'], 'precio_inicial' => ['required', 'numeric', 'min:0'], 'precio_pactado' => ['required', 'numeric', 'min:0'], 'pago_inicial' => ['required', 'numeric', 'min:0', 'lte:precio_pactado'], 'fecha_inicio_pagos' => ['required', 'date'], 'acuerdo_pagos' => ['required', 'integer', 'min:1', 'max:120'], 'periodo_venta' => ['required', 'integer', 'min:1'], 'metodo_pago' => ['required', 'string', 'max:50'], 'comision' => ['nullable', 'numeric'], 'porcentaje_pactado' => ['nullable', 'numeric']]);
        $data['comision'] ??= 0;
        $data['porcentaje_pactado'] ??= 0;

        return DB::transaction(function () use ($data): Venta {
            $paymentMethod = $data['metodo_pago'];
            unset($data['metodo_pago']);
            $venta = Venta::create($data + ['fecha_inserta' => now()->toDateString(), 'usuario_inserta' => session('haro_admin.id'), 'estatus_venta' => 'Pendiente', 'interes_acumulado' => 0]);
            Auto::whereKey($data['id_auto'])->update(['vendido' => 1, 'fecha_venta' => now(), 'pausado' => 1, 'en_banner' => 0]);
            $this->createPaymentSchedule($venta);

            if ((float) $venta->pago_inicial > 0) {
                Pago::create([
                    'monto' => $venta->pago_inicial,
                    'id_venta' => $venta->id,
                    'estatus' => session('haro_admin.permiso') === 'Banca' ? 'Aprobado' : 'Pendiente',
                    'fecha_pago' => now()->toDateString(),
                    'fecha_inserta' => now(),
                    'usuario_inserta' => session('haro_admin.id'),
                    'metodo' => $paymentMethod,
                    'tipo_pago' => 'Pago Inicial',
                    'usuario_aprueba' => session('haro_admin.permiso') === 'Banca' ? session('haro_admin.id') : 0,
                ]);
            }

            return $venta;
        });
    }

    private function createPaymentSchedule(Venta $venta): void
    {
        $payments = max(1, (int) $venta->acuerdo_pagos);
        $remaining = max(0, (float) $venta->precio_pactado - (float) $venta->pago_inicial);
        $basePayment = $remaining / $payments;
        $outstanding = $remaining;

        for ($index = 0; $index < $payments; $index++) {
            $interest = $outstanding * ((float) $venta->porcentaje_pactado / 100);
            PagoEvento::create([
                'id_venta' => $venta->id,
                'fecha_prospecto' => Carbon::parse($venta->fecha_inicio_pagos)->addMonthsNoOverflow($index)->toDateString(),
                'monto_acumulado' => $basePayment * ($index + 1),
                'monto_pagar' => $basePayment + $interest,
                'monto_interes' => $interest,
                'se_atraso' => 0,
                'num_pago' => $index + 1,
            ]);
            $outstanding = max(0, $outstanding - $basePayment);
        }
    }

    private function createPayment(Request $request): Pago
    {
        $data = $request->validate(['id_venta' => ['required', 'integer', 'exists:venta,id'], 'monto' => ['required', 'numeric', 'min:0'], 'estatus' => ['required', 'string', 'max:100'], 'fecha_pago' => ['required', 'date'], 'metodo' => ['required', 'string', 'max:50'], 'tipo_pago' => ['required', 'string', 'max:50']]);

        return Pago::create($data + ['fecha_inserta' => now(), 'usuario_inserta' => session('haro_admin.id'), 'usuario_aprueba' => 0]);
    }
}
