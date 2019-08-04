<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "clientes";
    protected $fillable = [
        'id', 'nome', 'cpf'
    ];
    public function compras() {
        return $this->belongsToMany(Compra::class, 'compras_clientes', 'cliente_id','compra_id');
    }
}
