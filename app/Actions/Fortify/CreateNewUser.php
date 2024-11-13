<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\CreatesNewUsers; 
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input)
    {
        $validated = validator($input, [
            'carnet_identidad' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'sexo' => ['required', 'in:masculino,femenino'],
            'telefono' => ['required', 'string', 'max:15'],
            'edad' => ['required', 'integer', 'min:1'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $codTipoUsuarioF = 3;
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'codTipoUsuarioF' => $codTipoUsuarioF,
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
        Auth::login($user); 
        return redirect()->route('vista-cliente');
    }
}
