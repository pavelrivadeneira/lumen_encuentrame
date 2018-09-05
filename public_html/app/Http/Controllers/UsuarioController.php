<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Usuario;
/**
 * @author Grupo Project_Encuentrame
 */
class UsuarioController extends Controller 
{
    
    /*
    *@function registroUsuario nos permite registrar un usuario que sera de tipo usuario el mismo que nos servira para obtener esos campos en nuestra app al momento de logearse con Facebook 
    *@param recibe como parametro una peticiòn de tipo Request para comparar nuestros datos.
    *@return retorna toda la informacion una vez que el registro o inicio de sesion sean correctos 
    */
    public function registroUsuario(Request $request){
        //Se verifica por medio de una petición si los datos son de tipo json
        if($request->isJson()){
            //Por medio de la peticion traemos todos los datos y los convetimos de json a un  arreglo. 
            $data = $request->json()->all();
            //Guardamos en esta variable la consulta a la tabla Usuario donde se busca el primer dato de los campos nombre y apellido 
            $user = Usuario::where("nombre", $data["nombre"])
            ->where("apellido", $data["apellido"])
            ->first();

//Sino esxite el  usuario se lo agrega 
            if(!$user){
                try {
                    //Se pregunta si los campos estan vacios 
                    if ($data["nombre"] != "" && $data["apellido"] != ""){
                        //Se crea un objeto de tipo usuario 
                        $Usuario = new Usuario();
                        //Accedemos a los campos donde se guardan los respectivos datos nombre y apellido.
                        $Usuario->nombre = $data["nombre"];
                        $Usuario->apellido = $data["apellido"];
                       //Se guardan los datos del Usuario en el objeto Usuario
                        $Usuario->save();

//Se retorna por medio de una peticion de tipo json todos los datos del ingesados del usuario , diciendo que todo esta bien 
                        return response()->json(["Mensaje"=> "Perfecto"], 200);
                    }else{
                        //Se retorna si faltana datos por llenar 
                        return response()->json(["Mensaje"=> "LLene los campos"], 203);
                    } 
                } catch (\Exception $exc) {
                    return response()->json(["Mensaje" => $exc], 403); 
                }
            }else{
                //Se retorna si ya se inicio sesion con los datos de un usuario con el cual ya se ingreso.
                return response()->json(["Mensaje" => "Ya se ha iniciado sesion"], 200); 
        
            }

        }else{
            // Se retorna si no tiene el formato en que se envian los datos 
            return response()->json(["Mensaje" => "La data no tiene el formato deseado"], 403); 
        
        }

    }
}