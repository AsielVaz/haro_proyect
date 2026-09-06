@extends('layouts.app')
@section('title', $title)
@section('content')
<details class="panel mb-7" {{ $errors->any() || request()->filled('auto') ? 'open' : '' }}>
    <summary class="flex cursor-pointer list-none items-center justify-between">
        <div><p class="eyebrow">Nuevo registro</p><h3>Agregar a {{ strtolower($title) }}</h3></div>
        <span class="btn-primary">+ CAPTURAR</span>
    </summary>
    <form method="POST" action="{{ route('operaciones.store', $seccion) }}" class="form-grid mt-7">
        @csrf
        @if($seccion === 'clientes')
            <label class="field"><span>Nombre</span><input name="nombre" value="{{ old('nombre') }}" required></label>
            <label class="field"><span>Apellidos</span><input name="apellidos" value="{{ old('apellidos') }}" required></label>
            <label class="field"><span>Correo</span><input type="email" name="email" value="{{ old('email') }}" required></label>
            <label class="field"><span>Teléfono</span><input name="telefono" value="{{ old('telefono') }}" required></label>
            <label class="field"><span>Comisión</span><input type="number" step="0.01" min="0" name="comision" value="{{ old('comision', 0) }}"></label>
        @elseif($seccion === 'ventas')
            <label class="field"><span>Auto</span><select name="id_auto" required><option value="">Selecciona</option>@foreach($autos as $auto)<option value="{{ $auto->id }}" @selected(old('id_auto', request('auto')) == $auto->id)>#{{ $auto->id }} · {{ $auto->marca?->marca }} {{ $auto->modelo?->modelo }} {{ $auto->anio }}</option>@endforeach</select></label>
            <label class="field"><span>Cliente</span><select name="id_cliente" required><option value="">Selecciona</option>@foreach($clientes as $cliente)<option value="{{ $cliente->id }}" @selected(old('id_cliente') == $cliente->id)>{{ $cliente->nombre }} {{ $cliente->apellidos }}</option>@endforeach</select></label>
            <label class="field"><span>Precio inicial</span><input type="number" step="0.01" min="0" name="precio_inicial" value="{{ old('precio_inicial') }}" required></label>
            <label class="field"><span>Precio pactado</span><input type="number" step="0.01" min="0" name="precio_pactado" value="{{ old('precio_pactado') }}" required></label>
            <label class="field"><span>Pago inicial</span><input type="number" step="0.01" min="0" name="pago_inicial" value="{{ old('pago_inicial', 0) }}" required></label>
            <label class="field"><span>Inicio de pagos</span><input type="date" name="fecha_inicio_pagos" value="{{ old('fecha_inicio_pagos') }}" required></label>
            <label class="field"><span>Cantidad de pagos</span><input type="number" min="1" max="120" name="acuerdo_pagos" value="{{ old('acuerdo_pagos') }}" required></label>
            <label class="field"><span>Plazo de venta (meses)</span><select name="periodo_venta" required>@foreach([3,6,12,24,36] as $months)<option value="{{ $months }}" @selected(old('periodo_venta', 12) == $months)>{{ $months }} meses</option>@endforeach</select></label>
            <label class="field"><span>Método del pago inicial</span><select name="metodo_pago" required><option>Efectivo</option><option>Transferencia</option><option>Tarjeta</option><option>Depósito</option></select></label>
            <label class="field"><span>Comisión</span><input type="number" step="0.01" name="comision" value="{{ old('comision', 0) }}"></label>
            <label class="field"><span>Porcentaje pactado</span><input type="number" step="0.01" name="porcentaje_pactado" value="{{ old('porcentaje_pactado', 0) }}"></label>
        @elseif($seccion === 'pagos')
            <label class="field"><span>Venta</span><select name="id_venta" required><option value="">Selecciona</option>@foreach($ventas as $venta)<option value="{{ $venta->id }}" @selected(old('id_venta') == $venta->id)>Venta #{{ $venta->id }} · Auto #{{ $venta->id_auto }}</option>@endforeach</select></label>
            <label class="field"><span>Monto</span><input type="number" step="0.01" min="0" name="monto" value="{{ old('monto') }}" required></label>
            <label class="field"><span>Estado</span><select name="estatus" required><option>Pendiente</option><option>Pagado</option><option>Aprobado</option></select></label>
            <label class="field"><span>Fecha de pago</span><input type="date" name="fecha_pago" value="{{ old('fecha_pago') }}" required></label>
            <label class="field"><span>Método</span><select name="metodo" required><option>Efectivo</option><option>Transferencia</option><option>Tarjeta</option><option>Depósito</option></select></label>
            <label class="field"><span>Tipo de pago</span><select name="tipo_pago" required><option>Mensualidad</option><option>Inicial</option><option>Abono</option><option>Liquidación</option></select></label>
        @elseif($seccion === 'almacenes')
            <label class="field"><span>Nombre</span><input name="des_gen" value="{{ old('des_gen') }}" required></label>
            <label class="field md:col-span-2"><span>Dirección</span><input name="direccion" value="{{ old('direccion') }}" required></label>
            <label class="field"><span>Código postal</span><input name="cp" value="{{ old('cp') }}" required></label>
            <label class="field"><span>Latitud</span><input type="number" step="any" name="lat" value="{{ old('lat', 0) }}"></label>
            <label class="field"><span>Longitud</span><input type="number" step="any" name="lon" value="{{ old('lon', 0) }}"></label>
        @elseif($seccion === 'car-hunter')
            <label class="field"><span>Nombre</span><input name="nombre" value="{{ old('nombre') }}" required></label>
            <label class="field"><span>Correo</span><input type="email" name="email" value="{{ old('email') }}" required></label>
            <label class="field"><span>Marca buscada</span><input name="marca" value="{{ old('marca') }}" required></label>
            <label class="field"><span>Modelo</span><input name="modelo" value="{{ old('modelo') }}"></label>
            <label class="field"><span>Precio mínimo</span><input type="number" min="0" name="precio_min" value="{{ old('precio_min') }}" required></label>
            <label class="field"><span>Precio máximo</span><input type="number" min="0" name="precio_max" value="{{ old('precio_max') }}" required></label>
            <label class="field"><span>Año mínimo</span><input type="number" name="anio_min" value="{{ old('anio_min') }}" required></label>
            <label class="field"><span>Año máximo</span><input type="number" name="anio_max" value="{{ old('anio_max') }}" required></label>
        @elseif($seccion === 'usuarios')
            <label class="field"><span>Nombre</span><input name="nombre" value="{{ old('nombre') }}" required></label>
            <label class="field"><span>Correo</span><input type="email" name="email" value="{{ old('email') }}" required></label>
            <label class="field"><span>Contraseña</span><input type="password" name="password" minlength="6" required></label>
            <label class="field"><span>Teléfono</span><input name="telefono" value="{{ old('telefono') }}"></label>
            <label class="field"><span>Perfil</span><select name="permiso_banca" required><option>Banca</option><option>Cashier</option></select></label>
        @endif
        <div class="flex items-end"><button class="btn-primary" type="submit">GUARDAR REGISTRO</button></div>
    </form>
</details>

<section class="panel overflow-hidden p-0">
    <div class="panel-heading p-6"><div><p class="eyebrow">Operación</p><h3>{{ $title }}</h3></div><span class="badge badge-amber">{{ $records->total() }} REGISTROS</span></div>
    @if(in_array($seccion, ['ventas', 'pagos'], true))
        <div class="flex flex-wrap gap-2 border-b border-white/10 px-6 pb-5">
            <a class="btn-secondary" href="{{ route('operaciones.index', $seccion) }}">Todos</a>
            @foreach($seccion === 'ventas' ? ['Pendiente', 'Liquidada'] : ['Pendiente', 'Aprobado'] as $status)
                <a class="btn-secondary" href="{{ route('operaciones.index', [$seccion, 'estado' => $status]) }}">{{ $status }}</a>
            @endforeach
        </div>
    @endif
    <div class="overflow-x-auto"><table class="data-table"><thead><tr>@foreach($columns as $label)<th>{{ $label }}</th>@endforeach @if($seccion === 'pagos')<th>Acciones</th>@endif</tr></thead><tbody>@forelse($records as $record)<tr>@foreach(array_keys($columns) as $column)<td>@if(in_array($column,['precio_pactado','pago_inicial','monto','comision'],true))${{ number_format((float)$record->{$column},2) }}@else{{ $record->{$column} }}@endif</td>@endforeach @if($seccion === 'pagos')<td>@if($record->estatus === 'Pendiente' && session('haro_admin.permiso') === 'Banca')<form method="POST" action="{{ route('pagos.approve', $record) }}" data-confirm="Se aprobará el pago #{{ $record->id }} por ${{ number_format((float) $record->monto, 2) }} y se recalculará el saldo de la venta." data-confirm-title="¿Aprobar pago?" data-confirm-action="Aprobar pago">@csrf @method('PATCH')<button class="btn-primary" type="submit">APROBAR</button></form>@elseif($record->estatus === 'Aprobado')<span class="badge badge-green">APROBADO</span>@else<span class="badge badge-amber">PENDIENTE</span>@endif</td>@endif</tr>@empty<tr><td colspan="{{ count($columns) + ($seccion === 'pagos' ? 1 : 0) }}" class="text-center text-zinc-500">Sin registros</td></tr>@endforelse</tbody></table></div>
</section>
<div class="mt-7">{{ $records->links() }}</div>
@endsection
