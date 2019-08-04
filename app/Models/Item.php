<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
 protected $table = "items";
 protected $fillable = [
     "produto", "variedade", "pais", "categoria", "safra", 'preco'
 ];
}
