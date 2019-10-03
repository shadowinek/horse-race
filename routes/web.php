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

$router->get('/', ['uses' => 'Controller@index', 'as' => 'index']);
$router->get('/race/{id}', 'Controller@showRace');
$router->get('/horse/{id}', 'Controller@showHorse');
$router->post('/progress', ['uses' => 'Controller@progressRaces', 'as' => 'progress']);
$router->post('/generate', ['uses' => 'Controller@generateRace', 'as' => 'generate']);
