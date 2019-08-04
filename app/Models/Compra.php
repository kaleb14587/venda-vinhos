<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = "compras";
    protected $fillable = [
        'cliente', 'codigo', 'created_at', 'valorTotal'
    ];
    public function items() {
        return $this->belongsToMany(Item::class, 'compras_items', 'compra_id', 'item_id');
    }
}
