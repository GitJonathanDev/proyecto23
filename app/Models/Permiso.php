<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    // Tabla y clave primaria
    protected $table = 'permiso'; 
    protected $primaryKey = 'codPermiso'; 

    // Propiedad fillable para asignación masiva
    protected $fillable = [
        'codOpcionF',
        'accion' // Agregado el campo codOpcionF
        // Aquí puedes agregar otros campos que quieras permitir para asignación masiva
    ];

    // Relación con la tabla Opcion
    public function opcion()
    {
        return $this->belongsTo(Opcion::class, 'codOpcionF', 'codOpcion');
    }

    // Relación con la tabla TipoUsuario
    public function tipoUsuarios()
    {
        return $this->belongsToMany(TipoUsuario::class, 'tipoUsuarioPermiso', 'codPermisoF', 'codTipoUsuarioF');
    }
}
