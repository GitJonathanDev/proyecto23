<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CustomLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            switch ($user->codTipoUsuarioF) {
                case 1:
                    return redirect()->route('vista-cliente');
                case 2:
                    return redirect()->route('encargado');
                case 3:
                    return redirect()->route('admin');
                default:
                    return redirect()->route('login');
            }
        }
        return back()->withErrors(['email' => 'Las credenciales son incorrectas']);
    }
    public function logout(Request $request)
    {
        // Cerrar la sesión del usuario
        Auth::logout();
    
        // Invalidar la sesión actual
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Limpiar cualquier sesión almacenada
        Session::flush();
    
        // Redirigir al login y agregar encabezados para evitar cache
        return redirect()->route('login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate', // Evitar la caché
            'Pragma' => 'no-cache', // Evitar la caché
            'Expires' => '0', // Evitar la caché
        ]);
    }
}

