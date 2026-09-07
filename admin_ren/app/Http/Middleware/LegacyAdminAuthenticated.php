<?php

namespace App\Http\Middleware;

use App\Models\UsuarioHaro;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LegacyAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('haro_admin.id')) {
            return redirect()->route('login');
        }

        $usuario = UsuarioHaro::find($request->session()->get('haro_admin.id'));
        if (! $usuario || ! in_array($usuario->permiso_banca, ['Banca', 'Cashier'], true)) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
        }
        $request->session()->put('haro_admin.nombre', $usuario->nombre);
        $request->session()->put('haro_admin.permiso', $usuario->permiso_banca);

        return $next($request);
    }
}
