<?php

/** @var \Laravel\Lumen\Routing\Router $router */


$router->get('/','CorretoresController@index');
$router->get('/index','CorretoresController@getAll');
$router->get('/{id}','CorretoresController@find');
$router->delete('/{id}','CorretoresController@delete');
$router->patch('/{id}','CorretoresController@update');
$router->post('/','CorretoresController@create');