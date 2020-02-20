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

$router->group(['prefix' => 'api/alimentos'], function () use ($router) {
    $router->get('', 'AlimentoController@index');
    $router->get('{id}', 'AlimentoController@show');
    $router->get('paginacion/{desde}', 'AlimentoController@paginacion');
    $router->put('{id}', 'AlimentoController@update');
    $router->post('', 'AlimentoController@store');
    $router->delete('{id}', 'AlimentoController@destroy');
    $router->get('busqueda/{valor}', 'AlimentoController@busqueda');
});
$router->group(['prefix' => 'api/ejercicios'], function () use ($router) {
    $router->get('', 'EjercicioController@index');
    $router->get('{id}', 'EjercicioController@show');
    $router->get('paginacion/{desde}', 'EjercicioController@paginacion');
    $router->put('{id}', 'EjercicioController@update');
    $router->post('', 'EjercicioController@store');
    $router->delete('{id}', 'EjercicioController@destroy');
    $router->get('busqueda/{valor}', 'EjercicioController@busqueda');
});
$router->group(['prefix' => 'api/pasientes'], function () use ($router) {
    $router->get('', 'PasienteController@index');
    $router->get('{id}', 'PasienteController@show');
    $router->get('paginacion/{desde}', 'PasienteController@paginacion');
    $router->put('{id}', 'PasienteController@update');
    $router->post('', 'PasienteController@store');
    $router->delete('{id}', 'PasienteController@destroy');
    $router->get('busqueda/{valor}', 'PasienteController@busqueda');
});
$router->group(['prefix' => 'api/clasificaciones'], function () use ($router) {
    $router->get('', 'clasificacionController@index');
    $router->get('alimentacion/', 'clasificacionController@indexAlimentacion');
    $router->get('muscular/', 'clasificacionController@indexMuscular');
    $router->get('otro/', 'clasificacionController@indexOtro');
    $router->get('{id}', 'clasificacionController@show');
    $router->post('', 'clasificacionController@store');
    $router->patch('{id}', 'clasificacionController@update');
    $router->delete('{id}', 'clasificacionController@destroy');

});

