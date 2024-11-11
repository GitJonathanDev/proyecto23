<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteVentaController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Devolvemos los datos a la vista de Vue usando Inertia
        return Inertia::render('Cliente', [
            'clientName' => $user->name,
            'clientEmail' => $user->email,
            'clientPhone' => $user->telefono, // Asegúrate de que tienes estos datos en el modelo User o Cliente
            'clientAge' => $user->edad, // Lo mismo aquí
            'clientSex' => $user->sexo, // Lo mismo
        ]);
    }
}
