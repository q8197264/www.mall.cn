<?php
/**
 * Admin router.
 * User: liuxiaoquan
 * Date: 2018-11-22
 * Time: 14:20
 */
route::get('/', 'AdministratorController@login')->name('administrator.login');
route::get('admin/login', 'AdministratorController@login')->name('administrator.login');
route::post('admin/checkLogin', 'AdministratorController@checkLogin')->name('administrator.checkLogin');

route::get('admin/administrator/{oid}/{lid}', 'AdministratorController@list')->name('administrator.list');
route::get('admin/administrator/{id?}', 'AdministratorController@show')->name('administrator.show');
route::post('admin/administrator', 'AdministratorController@create')->name('administrator.create');
route::put('admin/administrator', 'AdministratorController@edit')->name('administrator.edit');
route::delete('admin/administrator', 'AdministratorController@delete')->name('administrator.delete');

route::get('admin/categories/{cid?}', 'CategoriesController@show')->name('categories.show');
route::post('admin/categories', 'CategoriesController@add')->name('categories.add');
route::put('admin/categories', 'CategoriesController@edit')->name('categories.edit');
route::delete('admin/categories/{cid?}', 'CategoriesController@delete')->name('categories.delete');

route::get('admin/users/{id?}', 'UsersController@show')->name('users.show');
route::post('admin/users', 'UsersController@create')->name('users.create');
route::put('admin/users', 'UsersController@edit')->name('users.edit');
route::delete('admin/users', 'UsersController@delete')->name('users.delete');