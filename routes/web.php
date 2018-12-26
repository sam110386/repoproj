<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
use Illuminate\Routing\Router;

Auth::routes();
Auth::routes(['register' => false]);
Route::get('/', 'HomeController@index')->name('home');
// Route::get('/account', 'AccountController@index')->name('account');
Route::group([
    'prefix'        => 'account',
    'middleware'    => 'auth',
], function (Router $router) {
    $router->get('/', 'AccountController@index')->name('account');
    $router->get('/dashboard', 'AccountController@index')->name('dashboard');
    $router->get('/profile', 'AccountController@view')->name('profile');
    $router->post('/profile', 'AccountController@updateProfile')->name('profile-info-save');
    $router->post('/password', 'AccountController@updatePassword')->name('profile-password-save');

    $router->get('/report', 'ReportsController@index')->name('report');
	$router->get('/report/add', 'ReportsController@add')->name('report-add');	
    $router->post('/report/save', 'ReportsController@save')->name('report-info-save');
    $router->get('/report/{id}', 'ReportsController@view')->where('id', '[0-9]+');
    $router->get('/report/export', 'ReportsController@export')->name('export');
});
