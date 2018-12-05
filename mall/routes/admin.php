<?php
/**
 * Admin router.
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 14:20
 */
route::get('/', 'UsersController@login')->name('users.login');
route::get('admin/login', 'UsersController@login')->name('users.login');

route::get('admin/categories/{cid?}', 'CategoriesController@show')->name('Categories.show');
route::post('admin/categories', 'CategoriesController@add')->name('Categories.add');
route::put('admin/categories', 'CategoriesController@edit')->name('Categories.edit');
route::delete('admin/categories/{cid?}', 'CategoriesController@delete')->name('Categories.delete');

route::get('admin/users/{id?}', 'UsersController@show')->name('users.show');
route::post('admin/users', 'UsersController@create')->name('users.create');
route::put('admin/users', 'UsersController@edit')->name('users.edit');
route::delete('admin/users', 'UsersController@delete')->name('users.delete');