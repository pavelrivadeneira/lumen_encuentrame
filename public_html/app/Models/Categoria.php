<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Categoria extends Model{
    protected $table = 'categoria';
    public $timestamps = false;
    //lista blancas
    protected $fillable = ['categoria'];
    //lista negra
    protected $guarded = ['id'];
    
    //Relacion UNO a MUCHOS
    public function Sitios(){
        return $this->hasMany('App\Models\Sitios', 'id_categoria');
    }
}