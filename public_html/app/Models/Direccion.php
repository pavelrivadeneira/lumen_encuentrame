<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Direccion extends Model{
    protected $table = 'direccion';
    public $timestamps = false;
    //lista blancas
    protected $fillable = ['longitud', 'latitud', 'id_persona'];
    //lista negra
    protected $guarded = ['id'];
    
    //Relacion UNO a UNO
    public function Sitios(){
        return $this->hasOne('App\Models\Sitios', 'id_direccion');
    }
}