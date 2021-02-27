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
$router->group(['prefix' => '/api/auth'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});

$router->group(['prefix' => '/api/user', 'middleware' => 'auth:api'], function () use ($router) {
    $router->get('/me', 'AuthController@me');
});
$router->group(['prefix' => '/api/product'], function () use ($router) {
    $router->get('/{id}', 'ProductController@getProduct'); //produk per kategori
    $router->get('/s/{id}', 'ProductController@getDetailProduct'); //produk per kategori
    $router->get('/', 'ProductController@getProducts');
    $router->post('/', 'ProductController@addProduct');
});

$router->group(['prefix' => '/api/category'], function () use ($router) {
    $router->get('/', 'CategoryController@getCategory');
    $router->post('/', 'CategoryController@addCategory');
});
$router->group(['prefix' => '/api/article'], function () use ($router) {
    $router->get('/', 'ArticleController@getArticle');
    $router->post('/', 'ArticleController@addArticle');
});