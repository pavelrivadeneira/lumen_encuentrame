<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Administrador extends Model{
    //Nombre del modelo como se encuentra en la base de datos
    protected $table = 'administrador';
    //Se coloca falso si no utilizamos campos update
    public $timestamps = false;
    //lista blancas (datos visibles al usuario)
    protected $fillable = ['nombre', 'apellido', 'correo', 'contraseña', 'external_id'];
    //lista negra(datos que no queremos que sean visibles al usuario)
    protected $guarded = ['id'];
    
    
    //Relacion UNO a MUCHOS
    public function Sitios(){
        return $this->hasMany('App\Models\Sitios', 'id_administrador');
    }
}