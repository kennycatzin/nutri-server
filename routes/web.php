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
$router->post(
    'auth/login', 
    [
       'uses' => 'AuthController@authenticate'
    ]
);
$router->group(
    ['middleware' => 'jwt.auth'], 
    function() use ($router) {
        $router->get('users', function() {
            $users = \App\User::all();
            return response()->json($users);
        });
    }
);
$router->get('email', 'HolaController@index');

$router->group(['prefix' => 'api/alimentos'], function () use ($router) {
    $router->get('', 'AlimentoController@index');
    $router->get('{id}', 'AlimentoController@show');
    $router->get('paginacion/{desde}', 'AlimentoController@paginacion');
    $router->get('get-clasificacion/{id}', 'AlimentoController@getClasificacion');
    $router->put('{id}', 'AlimentoController@update');
    $router->post('', 'AlimentoController@store');
    $router->delete('{id}', 'AlimentoController@destroy');
    $router->post('busqueda', 'AlimentoController@busqueda');
});
$router->group(['prefix' => 'api/ejercicios'], function () use ($router) {
    $router->get('', 'EjercicioController@index');
    $router->get('{id}', 'EjercicioController@show');
    $router->get('paginacion/{desde}', 'EjercicioController@paginacion');
    $router->put('{id}', 'EjercicioController@update');
    $router->post('', 'EjercicioController@store');
    $router->delete('{id}', 'EjercicioController@destroy');
    $router->post('busqueda', 'EjercicioController@busqueda');
    $router->post('file/{id}', 'EjercicioController@fileUpload');
    $router->delete('delete-img/{id}', 'EjercicioController@eliminarImagen');
    $router->get('get-ejercicio-clasificado/{clasificacion_id}', 'EjercicioController@getEjercicioClasificado');

    

});
$router->group(['prefix' => 'api/pasientes'], function () use ($router) {
    $router->get('', 'PasienteController@index');
    $router->get('buscar/file/{id}', 'PasienteController@imagenUsuario');
    $router->get('{id}', 'PasienteController@show');
    $router->get('paginacion/{desde}', 'PasienteController@paginacion');
    $router->put('{id}', 'PasienteController@update');
    $router->post('', 'PasienteController@store');
    $router->post('file/{id}', 'PasienteController@fileUpload');
    $router->delete('{id}', 'PasienteController@destroy');
    $router->post('busqueda', 'PasienteController@busqueda');
});
$router->group(['prefix' => 'api/clasificaciones'], function () use ($router) {
    $router->get('paginacion/{desde}', 'ClasificacionController@index');
    $router->get('alimentacion', 'ClasificacionController@Alimentacion');
    $router->get('muscular', 'ClasificacionController@Muscular');
    $router->get('receta', 'ClasificacionController@receta');
    $router->get('otro', 'ClasificacionController@indexOtro');
    $router->get('{id}', 'ClasificacionController@show');
    $router->post('', 'ClasificacionController@store');
    $router->put('{id}', 'ClasificacionController@update');
    $router->delete('{id}', 'ClasificacionController@destroy');
    $router->get('paginacion/{desde}', 'ClasificacionController@paginacion');
    $router->post('busqueda', 'ClasificacionController@busqueda');
});
$router->group(['prefix' => 'api/sesiones'], function () use ($router) {
    $router->get('send-pdf/{sesion}', 'SesionController@sendPDFs');
    $router->post('', 'SesionController@store');
    $router->get('prueba/{sesionId}', 'SesionController@consultaDieta');
    $router->get('entrenamiento/{sesionId}', 'SesionController@consultaEntrenamiento');
    $router->get('dieta/{sesionId}', 'SesionController@consultaDieta');

    $router->get('email', 'SesionController@update');

    $router->get('get-sesion/{id}', 'SesionController@getSesion');
    $router->get('correo', 'SesionController@correo');


    
});

$router->group(['prefix' => 'api/recetas'], function () use ($router) {
  
    $router->post('store-receta', 'RecetaController@store');
    $router->delete('delete-detalle/{id_detalle}', 'RecetaController@deleteDetalle');
    $router->delete('delete-receta/{id}', 'RecetaController@deleteReceta');
    $router->get('get-receta-paginado/{id}', 'RecetaController@getRecetasPaginado');
    $router->get('get-receta-clasificacion/{id_clasificacion}/{valor}', 'RecetaController@getRecetasClasificacion');
    $router->post('busqueda-receta', 'RecetaController@busqueda');
    $router->get('get-info-receta/{id_receta}', 'RecetaController@getInfoReceta');
    $router->post('fileUpload/{id}', 'RecetaController@fileUpload');
});
$router->group(['prefix' => 'api/unidades'], function () use ($router) {

    $router->get('get-unidades', 'UnidadController@getElementos');
    $router->get('get-byid/{id}', 'UnidadController@getById');

});
$router->group(['prefix' => 'api/imagen'], function () use ($router) {

    $router->post('file-upload/{tipo}/{id}', 'ImagenController@fileUpload');
    $router->get('get-imagen/{tipo}/{id}', 'ImagenController@getImagen');

});


