<?php
//login
route::get('/', 'AdministratorController@login')->name('administrator.login');
route::get('admin/login', 'AdministratorController@login')->name('administrator.login');
route::post('admin/checkLogin', 'AdministratorController@checkLogin')->name('administrator.checkLogin');

//管理员管理
route::get('admin/administrator/{oid}/{lid}', 'AdministratorController@listing')->name('administrator.listing');
route::get('admin/administrator/{id?}', 'AdministratorController@show')->name('administrator.show');
route::post('admin/administrator', 'AdministratorController@create')->name('administrator.create');
route::put('admin/administrator', 'AdministratorController@edit')->name('administrator.edit');
route::delete('admin/administrator', 'AdministratorController@delete')->name('administrator.delete');

//分类管理
route::get('admin/category/{cid?}', 'CategoriesController@show')->name('category.show');
route::post('admin/category', 'CategoriesController@add')->name('category.add');
route::put('admin/category', 'CategoriesController@edit')->name('category.edit');
route::delete('admin/category/{cid?}', 'CategoriesController@delete')->name('category.delete');

//用户管理
route::get('admin/users/', 'UsersController@page')->name('users.page');
route::get('admin/users/{id?}', 'UsersController@show')->name('users.show');
route::get('admin/users/{id?}/{li?}', 'UsersController@list')->name('users.listing');
route::post('admin/users', 'UsersController@register')->name('users.register');
route::put('admin/users', 'UsersController@edit')->name('users.edit');
route::delete('admin/users', 'UsersController@delete')->name('users.delete');