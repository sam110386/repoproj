<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
     // Institutes Routes
    $router->get('/institutes', 'InstitutesController@index')->name('Institutes.index');
    $router->get('/institutes/{id}', 'InstitutesController@show')->name('Institutes.show')->where('id', '[0-9]+');
    $router->get('/institutes/{id}/edit/', 'InstitutesController@edit')->name('Institutes.edit')->where('id', '[0-9]+');

    $router->get('/institutes/create', 'InstitutesController@create')->name('Institutes.create');

    $router->post('/institutes', 'InstitutesController@store')->name('Institutes.store');
    $router->match(['put', 'patch'], '/institutes/{id}','InstitutesController@update');
    $router->delete('/institutes/{id}', 'InstitutesController@destroy')->where('id', '[0-9]+');
    $router->get('/institutes/autocomplete', 'InstitutesController@autocomplete')->name('Institutes.autocomplete');

});
