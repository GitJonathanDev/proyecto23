<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    use HasFactory;

    protected $table = 'opcion'; 
    protected $primaryKey = 'codOpcion'; 

    protected $fillable = [
        'nombre',
        'ruta',
        'icono',
        'codMenuF' // Agregado el campo codOpcionF
        // Aquí puedes agregar otros campos que quieras permitir para asignación masiva
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'codMenuF', 'codMenu');
    }
    
    public function permisos()
    {
        return $this->hasMany(Permiso::class, 'codOpcionF', 'codOpcion');
    }
}
