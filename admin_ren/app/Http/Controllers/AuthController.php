<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\UsuarioHaro;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View|RedirectResponse
    {
        return session()->has('haro_admin.id') ? redirect()->route('dashboard') : view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $usuario = UsuarioHaro::query()->where('email', $request->string('email')->toString())->where('contrasena', sha1($request->string('password')->toString()))->first();
        if (! $usuario || ! in_array($usuario->permiso_banca, ['Banca', 'Cashier'], true)) {
            return back()->withErrors(['email' => 'Credenciales o permisos incorrectos.'])->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put('haro_admin', ['id' => $usuario->id, 'nombre' => $usuario->nombre, 'permiso' => $usuario->permiso_banca]);

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
