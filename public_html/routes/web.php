<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Registro de Administrador 
$router->post('/registro/administrador', 'AdministradorController@registroAdministrador');

//Registro de Usuario
$router->post('/registro/Usuario', 'UsuarioController@registroUsuario');

//Inicio Sesion de Administrador 
$router->post('/Inicio_Sesion/administrador', 'AdministradorController@InicioSesionAdministrador');

//CategoriaController
$router->post('/categoria/registro', 'CategoriaController@registro');
$router->get('/categoria/listar', 'CategoriaController@listar');

//DireccionController
$router->post('/direccion/registro', 'DireccionController@registro');
$router->get('/direccion/listar', 'DireccionController@listar');

//SitiosController
$router->post('/sitios/registro', 'SitiosController@registro');
$router->post('/sitios/actualizar', 'SitiosController@editar');
$router->get('/sitios/listar', 'SitiosController@listar');
$router->post('/sitios/buscar', 'SitiosController@buscarPorId');
