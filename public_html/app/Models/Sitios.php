<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Sitios extends Model{
    protected $table = 'sitios';
    public $timestamps = false;
    //lista blancas
    protected $fillable = ['nombre','descripcion','foto','id_categoria','id_direccion'];
    //lista negra
    protected $guarded = ['id'];
    
    //Relacion PERTENECE a
    public function Categorias(){
        return $this->belongsTo('App\Models\Categoria', 'id_categoria');
    }
    
    //Relacion UNO a UNO
    public function Direccion(){
        return $this->hasOne('App\Models\Direccion', 'id_direccion');
    }

    //Relacion PERTENECE a
    public function Administrador(){
        return $this->belongsTo('App\Models\Administrador', 'id_administrador');
    }
}