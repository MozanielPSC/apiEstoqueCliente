<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Terminal extends Model{
    protected $table = 'terminal';
    protected $fillable = ['id','terminal','chave'];
    public $timestamps = false;
}