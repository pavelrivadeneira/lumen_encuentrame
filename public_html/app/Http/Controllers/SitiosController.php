<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Sitios;
use \App\Models\Categoria;
use \App\Models\Direccion;
/**
 * @author Grupo Project_Encuentrame
 */
class SitiosController extends Controller 
{

    /*
    *@function registro nos permite registrar una Sitios en nuestro servicio web.
    *@param recibe como parametro una peticiòn de tipo Request para comparar nuestros datos.
    *@return retorna toda la informacion una vez que el registro se realizo, o faltan datos, o el formato no es el correcto 
    */
    public function registro(Request $request){
        //Se verifica por medio de una petición si los datos son de tipo json
        if($request->isJson()){
             //Por medio de la peticion traemos todos los datos y los convetimos de json a un  arreglo.
            $data = $request->json()->all();
             //Se pregunta los campos estan vacios 
            if ($data["nombre"] != "" && $data["descripcion"] != "" && $data["foto"] != "" &&
                $data["id_categoria"] != "" && $data["id_direccion"] != ""){
                //Se crea un objeto de tipo sitios
                $sitios = new Sitios();
            //Accedemos a los campos de la tabla y guardamos el dato especifico cuando lo realizamos por medio de teclado en el campo cuando estamos en la pagina web.
                $sitios->nombre = $data["nombre"];
                $sitios->descripcion = $data["descripcion"];
                $sitios->foto = $data["foto"];
                $sitios->id_categoria = $data["id_categoria"];
                $sitios->id_direccion = $data["id_direccion"];
                //Guardamos los datos en este objeto 
                $sitios->save();
                //Se retorna toda la informacion por medio de una petion en formato json, aclarando que el proceso fue exitoso.
                return response()->json(["Mensaje"=> "Perfecto"], 200);
            }else{
                //Se retorna si faltan campos por llenar 
                return response()->json(["Mensaje"=> "LLene los campos"], 203);
            } 
        }else{
            //Se retorna si esta mal el formato de los datos 
            return response()->json(["Mensaje" => "La data no tiene el formato deseado"], 403); 
        }
    }



    /*
    *@function editar nos permite editar nuestros datos de los campos sitios descripcion en nuestro servicio web.
    *@param recibe como parametro una peticiòn de tipo Request para comparar nuestros datos.
    *@return retorna toda la informacion una vez que el registro se realizo, o faltan datos, o el formato no es el correcto 
    */
    public function editar(Request $request){
         //Se verifica por medio de una petición si los datos son de tipo json
        if($request->json()){
         //Por medio de la peticion traemos todos los datos y los convetimos de json a un  arreglo.
            $data = $request->json()->all();
            //En esta variable objetoSitio accedemos a la tabla Sitio para poder realizar
            //la consulta donde buscaremos siempre el primer id. 
            $objSitio = Sitios::where("id", $data["id_sitio"])->first();
            //Preguntamos si existe el id buscado  
            if($objSitio){
                //Se pregunta los campos estan vacios 
                if ($data["nombre"] != "" && $data["descripcion"] != "" && $data["foto"] != "" &&
                    $data["id_categoria"] != "" && $data["id_direccion"] != ""){
                    $sitios = Sitios::find($objSitio->id);
                    $sitios->nombre = $data["nombre"];
                    $sitios->descripcion = $data["descripcion"];
                    $sitios->foto = $data["foto"];
                    $sitios->id_categoria = $data["id_categoria"];
                    $sitios->id_direccion = $data["id_direccion"];
                    //Se guarda todos los datos en este objeto
                    $sitios->save();
                    //Se retorna toda la informacion por medio de una petion en formato json, aclarando que el proceso fue exitoso.
                    return response()->json(["Mensaje"=> "Perfecto"], 200);
                }else{
                     //Se retorna si faltan campos por llenar 
                    return response()->json(["Mensaje"=> "LLene los campos"], 203);
                }     
            }else{
                return response()->json(["Mensaje"=> "No se encontro el sitio"], 203); 
            }
        }else{
             //Se retorna si esta mal el formato de los datos 
            return response()->json(["Mensaje" => "La data no tiene el formato deseado"], 403); 
        }
    }


    /*
    * @function listar nos permite listar es decir obtener todos los datos de un Sitio
    *@param solo vammos a presentar datos no necesitamos retornar nada en este caso
    */
    public function listar(){
        //Se guarda en la variable listaSitios la consulta, en donde se realiza la consulta a la BD que nos retorne todos los datos de la union de la tabla sitios y categoria y que nos ordene de forma accedente.
        $listaSitios  = Sitios::join('categoria','sitios.id_categoria','=','categoria.id')
            ->join('direccion','sitios.id_direccion','=','direccion.id')
            ->orderBy('sitios.id', 'ASC')->get();
            //Se pregunta si tiene datos mayores a 0 la varible listaSitios es decir hasta el tamaño de este arreglo. 
        if($listaSitios->count() > 0){
                //Se declara una variable data de tipo arreglo
                $data = array();
            //Se realiza un ciclo para obtener todos los datos del arreglo y gauradarlos en el campo correspndiente
                foreach ($listaSitios as $sit){
                    $data[] = ["nombre"=>$sit->nombre,
                            "descripcion"=>$sit->descripcion,
                            "foto"=>$sit->foto,
                            "categoria"=>$sit->categoria,
                            "latitud"=>$sit->latitud,
                            "longitud"=>$sit->longitud,
                            "id"=>$sit->id];
                }
                //Se retorna una peticion jason con los datos del arreglo
             return response()->json($data, 200);
        }else{
            //Se retorna en caso que este vacio
             return response()->json(["Mensaje" =>
                "Todo se ha ejecutado con exito, pero no hay Sitios"], 200);
        }
    }



    /*
    *@function buscarPorId nos permite buscar por un id en nuestroservicio web.
    *@param recibe como parametro una peticiòn de tipo Request para comparar nuestros datos.
    *@return retorna toda la informacion una vez que el registro se realizo, o faltan datos, o el formato no es el correcto 
    */
    public function buscarPorId(Request $request){
        //Se pregunta se la peticion es tipo json
        if($request->json()){
            try {
                //Transformar los datos de la peticion a  json
                $data= $request->json()->all(); 
                //En la tabla Sitios de la BD realizamos la consulta para poder encontrar el primer dato
                $sitio= Sitios::where("id", $data["id_sitio"])->first(); 
//Se pregunta si existe el id guardado en al variable 
                if ($sitio){
                    //Retornamosla peticion json con los datos buscados si ocurrio con exito
                    return response()
                    ->json(["id"=>$sitio->id,
                        "nombre"=>$sitio->nombre,
                        "descripcion"=>$sitio->descripcion], 200);
                    
                }else{
                    //Se retorna en caso que no ocurrio la petición
                    return response()->json(["Mensaje"=> "No encontrado"], 203);
                } 
            } catch (\Exception $exc) {
                //Se retorna si existe una exepcion
                return response()->json(["Mensaje" => $exc], 403); 
            }
        }else{
            //Se retorna si no tienen los datos el formato correcto 
            return response()->json(["Mensaje" => "La data no tiene el formato deseado"], 403); 
        }
    }   
}
