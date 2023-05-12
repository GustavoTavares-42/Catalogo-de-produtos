<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaModel extends Model
{
    protected $table = 'categorias';
    
    protected $fillable = [
        'nome'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}