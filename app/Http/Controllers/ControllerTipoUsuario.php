<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerTipoUsuario extends Controller
{
    public function index()
    {
        $tipoUsuario=tipoUsuario::all();
        return Inertia::render('TipoUsuario/index',compact('tipoUsuario'));
    }
    public function create() {
    }
    public function store(Request $request) {
    }
    public function show(User $user) {
    }
    public function edit(User $user) {
    }
    public function update(Request $request, User $user) {
    }
    public function destroy(User $user) {
    }
}
