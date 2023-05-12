<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoModel extends Model
{
    protected $table = 'produtos';
    
    protected $fillable = [
        'categoria_id',
        'codigo',
        'nome',
        'preco',
        'preco_promocional',
        'ativo'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaModel::class);
    }
}