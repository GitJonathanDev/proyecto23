<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Especificar la tabla asociada
    protected $table = 'Categoria';

    // Clave primaria personalizada
    protected $primaryKey = 'codCategoria';

    // Indicar si la clave primaria es autoincremental
    public $incrementing = true;

    // Tipo de la clave primaria
    protected $keyType = 'int';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
    ];

    // Convertir atributos a tipos específicos
    protected $casts = [
        'nombre' => 'string', // Esto es redundante, pero lo mantendremos para claridad
    ];

    // Desactivar timestamps si no existen columnas `created_at` y `updated_at` en la tabla
    public $timestamps = false;

    // Relaciones: Definir que una categoría puede tener muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'codCategoriaF', 'codCategoria');
    }
}
