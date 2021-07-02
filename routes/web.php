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
    $router->post('/register', 'AuthController@registerC');
    $router->post('/registera', 'AuthController@registerA');
    $router->post('/login', 'AuthController@loginC');
    $router->post('/logina', 'AuthController@loginA');
});

$router->group(['prefix' => '/api/user', 'middleware' => 'auth:api'], function () use ($router) {
    $router->get('/me', 'AuthController@me');
});
$router->group(['prefix' => '/api/product'], function () use ($router) {
    $router->get('/{id}', 'ProductController@getProduct'); //produk per kategori
    $router->get('/s/{id}', 'ProductController@getDetailProduct'); //produk per kategori
    $router->get('/', 'ProductController@getProducts');
    $router->post('/', 'ProductController@addProduct');
    $router->get('/rec/{id}', 'ProductController@getReccomProduct');
});

$router->group(['prefix' => '/api/category'], function () use ($router) {
    $router->get('/', 'CategoryController@getCategory');
    $router->post('/', 'CategoryController@addCategory');
});
$router->group(['prefix' => '/api/article'], function () use ($router) {
    $router->get('/', 'ArticleController@getArticle');
    $router->get('/big', 'ArticleController@getArticleBig');
    $router->post('/', 'ArticleController@addArticle');
});

$router->group(['prefix' => '/api/cart', 'middleware' => 'auth:api'], function () use ($router) {
    $router->get('/', 'CartController@getCart');
    $router->get('/total', 'CartController@getTotal');
    $router->post('/', 'CartController@addCart');
});

$router->group(['prefix' => '/api/order', 'middleware' => 'auth:api'], function () use ($router) {
    $router->post('/pivot', 'OrderController@orderProduct');
    $router->post('/edit', 'OrderController@putOrder');
    $router->get('/', 'OrderController@getOrder');
    $router->get('/total', 'OrderController@getTotal');
    $router->post('/payment/{id}', 'OrderController@pembayaran');
});

$router->group(['prefix' => '/api/wishlist', 'middleware' => 'auth:api'], function () use ($router) {
    $router->post('/add', 'WishlistController@addWishlist');
    $router->get('/get', 'WishlistController@getWishlist');
    $router->get('/del', 'WishlistController@delWishlist');
});

$router->group(['prefix' => '/api/voucher'], function () use ($router) {
    $router->post('/', 'VoucherController@add');
    $router->get('/active', 'VoucherController@getActive');
    $router->get('/{id}', 'VoucherController@get');
    $router->put('/', 'VoucherController@edit');
    $router->delete('/{id}', 'VoucherController@remove');
});

$router->group(['prefix' => '/api/address', 'middleware' => 'auth:api'], function () use ($router) {
    $router->post('/add', 'AddressController@add');
    $router->get('/get', 'AddressController@get');
    $router->put('/selected', 'AddressController@putSelected');
    $router->get('/province', 'AddressController@getProvince');
    $router->put('/edit/{id}', 'AddressController@editProfile');
    $router->delete('/{id}', 'AddressController@delete');
});
$router->post('api/callback', 'midtransCallback@Callback');
$router->get('api/search', 'SearchController@get');

$router->group(['prefix' => '/api/profile', 'middleware' => 'auth:api'], function () use ($router) {
    $router->get('/get', 'UserController@getProfile');
    $router->put('/put', 'UserController@editProfile');
    $router->get('/all', 'UserController@editProfile');
});
$router->group(['prefix' => '/api/ongkir'], function () use ($router) {
    $router->get('/getP', 'CourierController@getProvince');
    $router->get('/getC', 'CourierController@getCity');
    $router->post('/cost', 'CourierController@getCost');
    $router->post('/city', 'CourierController@postCity');
    $router->post('/cities/{province_id}', 'CourierController@getCities');
});
$router->get('/api/user/all', 'UserController@getAllUser');
