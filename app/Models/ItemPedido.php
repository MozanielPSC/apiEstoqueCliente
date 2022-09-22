<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class ItemPedido extends Model{
    protected $table = 'itempedido';
    protected $fillable = ['codigo','codpedido','codproduto','quantidade','preco'];
}