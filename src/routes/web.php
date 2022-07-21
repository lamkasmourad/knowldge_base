<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\Communication\ContenuController;

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
    $router->post('contenu/keywords/save', 'Contenu\ContenuController@saveContenuAndKeywords');
    $router->post('contenu/create','Contenu\ContenuController@createContenu');
    $router->group(['prefix' => 'category'], function() use ($router){
        $router->get('all','Category\CategoryController@getAllCategories');
    });
});
