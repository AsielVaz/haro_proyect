<?php

namespace App\Http\Controllers;

use App\Models\Auto;
use App\Models\Pago;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $resumenAutos = Auto::query()->toBase()->selectRaw('COUNT(*) total')->selectRaw('SUM(vendido = 0) disponibles')->selectRaw('SUM(consig = 1 AND vendido = 0) consignacion')->selectRaw('SUM(pausado = 1 AND vendido = 0) pausados')->selectRaw('COALESCE(SUM(CASE WHEN vendido = 0 THEN precio ELSE 0 END), 0) valor_inventario')->first();
        $ventas = Venta::query()->selectRaw("DATE_FORMAT(fecha_inserta, '%Y-%m') periodo, COUNT(*) cantidad, COALESCE(SUM(precio_pactado), 0) monto")->whereNotNull('fecha_inserta')->groupBy('periodo')->orderByDesc('periodo')->limit(12)->get()->reverse()->values();
        $marcas = Auto::query()->join('marca', 'marca.id', '=', 'auto.id_marca')->where('auto.vendido', 0)->select('marca.marca')->selectRaw('COUNT(*) cantidad')->groupBy('marca.id', 'marca.marca')->orderByDesc('cantidad')->limit(8)->get();

        return view('dashboard', ['resumen' => $resumenAutos, 'ventas' => $ventas, 'marcas' => $marcas, 'pagosPendientes' => Pago::query()->where('estatus', '!=', 'Aprobado')->count(), 'ultimosAutos' => Auto::with(['marca:id,marca', 'modelo:id,modelo'])->where('vendido', 0)->orderByDesc('fecha_cap')->orderByDesc('id')->limit(6)->get(), 'actividad' => DB::table('log_cambio_auto')->orderByDesc('id')->limit(7)->get()]);
    }
}
