<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    Route::name('admin.')->group(function(Router $router) {
        $router->resource('gameMaps', GameMapsController::class);
        $router->resource('users', UsersController::class);
        $router->resource('topics', TopicsController::class);
        $router->post('topics/upload_image', 'TopicsController@apiUploadImage')->name('topics.upload_image');
        $router->resource('links', LinksController::class);
        $router->resource('categories', CategoriesController::class);
    });
});
