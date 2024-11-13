<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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
                case 3:
                    return redirect()->route('vista-cliente');
                case 5:
                    return redirect()->route('encargado');
                case 4:
                    return redirect()->route('admin');
                default:
                    return redirect()->route('vista-cliente');
            }
        }
        return back()->withErrors(['email' => 'Las credenciales son incorrectas']);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

