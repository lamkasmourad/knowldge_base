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



$router->group(['prefix'=>'api'], function() use($router){
    $router->group(['prefix' => 'category'], function() use ($router){

    });
    $router->get('test', function () {
        return "it's working";
    });

    $router->post('contenu/keywords/save', 'Contenu\ContenuController@saveContenuAndKeywords');

    $router->group(['prefix' => 'contenu'], function() use ($router){
        $router->post('create','Contenu\ContenuController@createContenu');
        $router->get('get/{contenu_id}','Contenu\ContenuController@getContenu');
    });
    $router->group(['prefix' => 'category'], function() use ($router){
        $router->get('all','Category\CategoryController@getAllCategories');
    });
});
