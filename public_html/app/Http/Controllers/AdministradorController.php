<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Administrador;
/**
 * @author Grupo Project_Encuentrame
 */
class AdministradorController extends Controller 
{

	/*
	*@function registroAdministrador nos permite registrar un usuario que sera de tipo administrador el mismo que tiene los permisos para realizar la gestión de los sitios,  categorias de nuestro servicio web.  
	*@param recibe como parametro una peticiòn de tipo Request para comparar nuestros datos.
	*@return retorna toda la informacion en forma de peticion en formato json, response()->json()
	*/
    public function registroAdministrador(Request $request){
    	//Se verifica si los datos son de tipo json, extraemos todo con la funcion all(), para luego convertirlos en un arreglo
        if($request->isJson()){
            $data = $request->json()->all();
            //Consulta donde si el campo correo de modelo administrador sera igual al correo del BD, se obtendra siempre el primero dato con la funcion first().
            $admin = Administrador::where("correo", $data["correo"])->first();
            //Si no existe nuestro administrador se lo registra.
            if(!$admin){
                try {
// Se compara si los datos no estan vacios para el registro
                    if ($data["nombre"] != "" && $data["apellido"] != "" && $data["correo"] != "" && $data["contraseña"] != "" ){
                        //Se crea un nuevo objeto de Administrador, para que los campos se refresquen es decir, que todos los campos esyen vacios
                        $Administrador = new Administrador();
                        //Guardamos nombre en el campo nombre, de la misma manera apellido, correo y contraseña 
                        $Administrador->nombre = $data["nombre"];
                        $Administrador->apellido = $data["apellido"];
                        $Administrador->correo = $data["correo"];
                        $Administrador->contraseña = $data["contraseña"];
                      //La función v4() nos permite genera el external Id en base64 el mismo que es un id aleartorio que es casi imposible que se repita 
                        $Administrador->external_id = Utilidades\UUID::v4(); 
//Guardamos los datos en el objeto administrador
                        $Administrador->save();

//Si todo esta correcto retornamos este mensaje 
                        return response()->json(["Mensaje"=> "Perfecto"], 200);
                    }else{
                    	//Si falta aun campo por llenar enviamos el siguiente mensaje 
                        return response()->json(["Mensaje"=> "LLene los campos"], 203);
                    } 
                } catch (\Exception $exc) {
                    return response()->json(["Mensaje" => $exc], 403); 
                }
            }else{
            	//Se retornara esto en caso, de que suceda si se desea ingresar un administrador con los mismo datos. 
                return response()->json(["Mensaje" => "El correo ya existe..."], 403); 
        
            }

        }else{
        	//Se retorna este mensaje si los datos no estan en el orden especifico
            return response()->json(["Mensaje" => "La data no tiene el formato deseado"], 403); 
        
        }

    }



/*
	*funtion InicioSesionAdministrador, nos permite realizar el inicio de sesion del administrador con los campos correo y contraseña para poder realizar la gestion de los datos pertinentes. 
	*@param recibe como parametro una peticiòn Request
	*@return retorna toda la informacion en forma de
	* peticion en formato json, response()->json()
*/
public function InicioSesionAdministrador(Request $request){
	//Se verifica si los datos son de tipo json,
        if($request->json()){
            try {
            	//Se solicita todos los datos por medio de la petición para transformar los datos a  json
                $data= $request->json()->all(); 
                //En esta varible se guarda las consultas para obtener los dos campos del administrador  en donde se busca el primer correo  y contraseña, se la guarda en un arreglo
                $admin= Administrador::where ("correo", $data["correo"])
                ->where ("contraseña", $data["contraseña"])->first(); 
               
//Si existe el administrador 
                if ($admin){
                	//Otra comparacion mas segura para que no haya exepcion de mayusculas es decir si esta identico con en la BD.
                    if($admin->correo ===$data["correo"] && $admin->contraseña === $data["contraseña"]){
//Hasta este punto significa que ya se pudo realizar el inicio de sesion y se retorna toda la información apuntando a su respectivo campo retornando en la varible especificada.
                        return response()->json(["nombre"=>$admin->nombre,
                            "apellido"=>$admin->apellido,
                            "correo"=>$admin->correo,
                            "external_id"=>$admin->external_id,
                            // aqui se encripta el external Id juntamente con el correo para generar el token para poder realiar la autentificación de que si existe ese usuario y se retorna todos los datos del administrador 
                            "token"=>base64_encode($admin->external_id.'---'.$admin->correo),
                            "mensaje"=>"Perfecto", "siglas"=>"OP"], 200); 
                    }else{
                    	//Se retorna este mensaje cuando los datos estan ingresados incorrectamente
                        return response()->json(["mensaje"=>"Usuario y Clave Incorrectos ", "siglas"=>"OI" ], 203);
                    }
                    
                }else{

                    return response()->json(["Mensaje"=> "Datos Incorrectos el administrador ingresado no existe..."], 203);
                } 
            } catch (\Exception $exc) {
                return response()->json(["Mensaje" => $exc], 403); 
            }
        }else{
            return response()->json(["Mensaje" => "La data no tiene el formato deseado"], 403); 
        }
    }

    
}
