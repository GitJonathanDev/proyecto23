<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'carnet_identidad' => 'required',
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'sexo' => 'required|in:masculino,femenino',
            'telefono' => 'required|string|max:15',
            'edad' => 'required|integer',
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);

        $codTipoUsuario = 1;
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'codTipoUsuarioF' => $codTipoUsuario,
        ]);
        $cliente = Cliente::create([
            'carnetIdentidad' => $validated['carnet_identidad'],
            'codUsuarioF' => $user->codUsuario,
            'nombre' => $validated['nombre'],
            'apellidoPaterno' => $validated['apellido_paterno'],
            'apellidoMaterno' => $validated['apellido_materno'],
            'sexo' => $validated['sexo'],
            'telefono' => $validated['telefono'],
            'edad' => $validated['edad'],
        ]);
        auth()->login($user);
        return redirect()->route('vista-cliente');
    }
}

