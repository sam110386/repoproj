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
    //report tab pagination
    //$router->get('/institutes/{id}?_pjax', 'InstitutesController@paginatereport')->where('id', '[0-9]+');
    $router->get('/institutes/{id}', 'InstitutesController@show')->name('Institutes.show')->where('id', '[0-9]+');
    $router->get('/institutes/{id}/edit/', 'InstitutesController@edit')->name('Institutes.edit')->where('id', '[0-9]+');

    $router->get('/institutes/create', 'InstitutesController@create')->name('Institutes.create');

    $router->post('/institutes', 'InstitutesController@store')->name('Institutes.store');
    $router->match(['put', 'patch'], '/institutes/{id}','InstitutesController@update');
    $router->delete('/institutes/{id}', 'InstitutesController@destroy')->where('id', '[0-9]+');
    $router->get('/institutes/autocomplete', 'InstitutesController@autocomplete')->name('Institutes.autocomplete');
    //export pdf
    $router->get('/institutes/{id}/exportpdf', 'InstitutesController@export')->where('id', '[0-9]+');
    //create institute reports
    $router->get('/institutes/{id}/create', 'InstitutesController@createreport')->name('Institutes.createreport');
    $router->post('/institutes/{id}/createreportsave', 'InstitutesController@createreportsave')->name('Institutes.createreportsave');
    $router->delete('/institutes/{id}/{reportid}', 'InstitutesController@deletereport')->where('id', '[0-9]+');
    $router->get('/institutes/{id}/{reportid}', 'InstitutesController@viewreport')->where('id', '[0-9]+');
    
    //edit institute report
    $router->get('/institutes/{id}/{reportid}/edit', 'InstitutesController@editreport')->name('Institutes.editreport');
    $router->post('/institutes/{id}/{reportid}/editreportsave', 'InstitutesController@editreportsave')->name('Institutes.editreportsave');

    
    //Reports Routes
    $router->get('/reports', 'ReportsController@index')->name('Report.index')->where('id', '[0-9]+');
    $router->get('/reports/grid/{id}', 'ReportsController@reportgrid')->name('Report.show')->where('id', '[0-9]+');
    $router->get('/reports/{id}', 'ReportsController@show')->name('Reports.show')->where('id', '[0-9]+');
    $router->get('/reports/{id}/edit/', 'ReportsController@edit')->name('Reports.edit')->where('id', '[0-9]+');
    $router->delete('/reports/{id}', 'ReportsController@destroy')->where('id', '[0-9]+');
    $router->get('/reports/create', 'ReportsController@create')->name('Reports.create');

    $router->post('/reports', 'ReportsController@store')->name('Reports.store');
    $router->match(['put', 'patch'], '/reports/{id}','ReportsController@update');
    $router->post('/reports/update/{id}','ReportsController@update');
    
    //Statistics Route
    $router->get('/statistics', 'StatisticsController@index')->name('Statistics.index')->where('id', '[0-9]+');
    $router->get('/statistics/instituteautocomplete', 'StatisticsController@instituteautocomplete')->name('Statistics.instituteautocomplete');
    $router->post('/statistics/loadchartdata', 'StatisticsController@loadchartdata')->name('Statistics.loadchartdata');


});
