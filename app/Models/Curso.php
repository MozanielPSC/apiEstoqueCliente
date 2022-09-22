<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Curso extends Model{
    protected $table = 'curso';
    protected $fillable = ['codigo','nome','categoria','professor','imagem','url_imagem'];
}