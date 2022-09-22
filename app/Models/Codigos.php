<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Codigos extends Model{
    protected $table = 'CODIGOS';
    protected $fillable = ['cod_id_cnpj','cod_chave_terminal','cod_identificador','cod_localizacao','cod_codigo','cod_preco','cod_quantidade'];
    public $timestamps = false;
}