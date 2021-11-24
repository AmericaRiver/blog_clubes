<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['middleware'=>['cors']], function() use($router){
        $router->get('/login/{id}/{password}', 'AuthController@login');
        
    });
    
    $router->group(['middleware'=>['auth', 'cors']], function() use($router){
        $router->get('/alumnos', 'AlumnoController@index');
        $router->get('/alumnos/{id}', 'AlumnoController@get');
        $router->post('/alumnos', 'AlumnoController@create');
        $router->put('/alumnos/{id}', 'AlumnoController@update');
        $router->delete('/alumnos/{id}', 'AlumnoController@destroy');

        $router->get('/instructores', 'InstructorController@index');
        $router->get('/instructores/{id}', 'InstructorController@get');
        $router->post('/instructores', 'InstructorController@create');
        $router->put('/instructores/{id}', 'InstructorController@update');
        $router->delete('/instructores/{id}', 'InstructorController@destroy');

        $router->get('/clubes', 'ClubController@index');
        $router->get('/clubes/{id}', 'ClubController@get');
        $router->post('/clubes', 'ClubController@create');
        $router->post('/clubes/{id}', 'ClubController@update');
        $router->delete('/clubes/{id}', 'ClubController@destroy');

        $router->get('/clubes-alumnos', 'ClubalumnoController@index');
        $router->get('/clubes-alumnos/{id}', 'ClubalumnoController@get');
        $router->post('/clubes-alumnos', 'ClubalumnoController@create');
        $router->put('/clubes-alumnos/{id}', 'ClubalumnoController@update');
        $router->delete('/clubes-alumnos/{id}', 'ClubalumnoController@destroy');

}
);
    