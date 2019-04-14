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
    return 'Servicio API RESTFUL LUMEN..is running...';
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('cargo', 'CargoController@index');
    $router->get('cargo/{id}','CargoController@show');
    $router->post('cargo','CargoController@store');
    $router->put('cargo/{id}','CargoController@update');
    $router->delete('cargo/{id}','CargoController@destroy');
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('operativo', 'OperativoController@index');
    $router->get('operativo/{id}','OperativoController@show');
    $router->post('operativo','OperativoController@store');
    $router->put('operativo/{id}','OperativoController@update');
    $router->delete('operativo/{id}','OperativoController@destroy');
});
