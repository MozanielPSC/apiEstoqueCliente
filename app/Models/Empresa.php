<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Empresa extends Model{
    protected $table = 'empresa';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['id','cnpj','email'];
    public $timestamps = false;
}