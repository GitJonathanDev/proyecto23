<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    use HasFactory;

    protected $table = 'Pagina';
    protected $fillable = [
        'nombrePagina',
        'conteoVisitas',
    ];

    protected $casts = [
        'conteoVisitas' => 'integer',
    ];
    protected $attributes = [
        'conteoVisitas' => 0,
    ];
    public $timestamps = false;
}
