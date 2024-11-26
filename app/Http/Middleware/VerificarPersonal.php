<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificarPersonal
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Verifica si el tipo de usuario es personal (codTipoUsuarioF = 2 o 3)
            if (in_array(Auth::user()->codTipoUsuarioF, [2, 3])) {
                return $next($request); // Permitir el acceso
            }
        }

        // Redirigir a la página anterior con un mensaje de error
        return redirect()->back()->with('error', 'Acceso no autorizado. Solo personal autorizado puede acceder.');
    }
}
