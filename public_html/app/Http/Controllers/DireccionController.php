<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Direccion;
/**
 * @author Grupo Project_Encuentrame
 */
class DireccionController extends Controller 
{

    /*
    *@function registro nos permite registrar una Direccion en nuestro servicio web.
    *@param recibe como parametro una peticiòn de tipo Request para comparar nuestros datos.
    *@return retorna toda la informacion una vez que el registro se realizo, o faltan datos, o el formato no es el correcto 
    */
    public function registro(Request $request){
        //Se verifica por medio de una petición si los datos son de tipo json
        if($request->isJson()){
             //Por medio de la peticion traemos todos los datos y los convetimos de json a un  arreglo. 
            $data = $request->json()->all();
            try {
                 //Se pregunta si este campos esta vacios 
                if ($data["latitud"] != "" && $data["longitud"] != ""){
                       //Se crea un objeto de tipo categoria
                    $direccion = new Direccion();
                     //Accedemos a los campos de la tabla y guardamos el dato especifico cuando lo realizamos por medio de teclado en el campo cuando estamos en la pagina web.
                    $direccion->latitud = $data["latitud"];
                    $direccion->longitud = $data["longitud"];
                     //Guardamos los datos en este objeto 
                    $direccion->save();
                    //Se retorna toda la informacion por medio de una petion en formato json, aclarando que el proceso fue exitoso.
                    return response()->json(["Mensaje"=> "Perfecto"], 200);
                }else{
                    //Se retorna cuando faltan datos por llenar en los campos 
                    return response()->json(["Mensaje"=> "LLene los campos"], 203);
                } 
            } catch (\Exception $exc) {
                return response()->json(["Mensaje" => $exc], 403); 
            }
        }else{
            return response()->json(["Mensaje" => "La data no tiene el formato deseado"], 403); 
        }
    }


    /*
    * @function listar nos permite listar es decir obtener todos los datos de una dirección
    *@param solo vammos a presentar datos no necesitamos retornar nada en este caso
    */
    public function listar(){
        //Se crea una variable en donde se guardara la consulta en donde se obtienen todas las direcciones de nuestra base de datos.
        $listaDireccion  = Direccion::get();
        //Se pregunta si esta variable contiene datos ,si tiene mas de o hasta llegar al tamaño del arreglo.
        if($listaDireccion->count() > 0){
              $data = array();
              //Se realiza in ciclo para obtener todos los datos del arrglo 
                foreach ($listaDireccion as $dir){
                      //Se guarda los datos en un arreglo, aquellos que son obtenidos por cada iteracción
                    $data[] = $dir->latitud.", ".$dir->longitud;
                }
                //Se retorna una peticion json en forma de arrglo con todos los datos
             return response()->json(["Coordenadas"=>$data], 200);
        }else{
            //Se retorna en caso que este vacio 
             return response()->json( ["Mensaje" =>
                "Todo se ha ejecutado con exito, pero no hay direcciones"], 200);
        }
    }
}