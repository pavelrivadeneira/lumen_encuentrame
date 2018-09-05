<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Usuario extends Model{
    protected $table = 'usuario';
    public $timestamps = false;
    //lista blancas
    protected $fillable = ['nombre', 'apellido'];
    //lista negra
    protected $guarded = ['id'];
    
    
    //Relacion UNO a MUCHOS
    public function Sitios(){
        return $this->hasMany('App\Models\Sitios', 'id_usuario');
    }
}