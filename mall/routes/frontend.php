<?php
/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 14:43
 */
Route::get('/', 'HomeController@index')->name('Home.index');

Route::get('login/{id?}', 'UsersController@login')->name('users.login');
//user
Route::get('users/{id?}', 'UsersController@show')->name('users.show');
Route::get('users/create', 'UsersController@create')->name('users.create');
Route::get('users/{id}/edit', 'UsersController@edit')->name('users.edit');
Route::post('users', 'UsersController@store')->name('users.store');
Route::put('users/{id}', 'UsersController@update')->name('users.update');
Route::delete('users/{id}', 'UsersController@destroy')->name('users.destroy');

//order
Route::get('orders/{id?}', 'OrdersController@show')->name('orders.show');