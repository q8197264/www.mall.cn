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
route::get('admin/users/{id?}/{li?}', 'UsersController@list')->name('users.list');
route::get('admin/users/{id?}', 'UsersController@show')->name('users.show');
route::post('admin/users', 'UsersController@register')->name('users.register');
route::put('admin/users', 'UsersController@edit')->name('users.edit');
route::delete('admin/users', 'UsersController@delete')->name('users.delete');

//商品管理
route::get('admin/goods/{id?}/{li?}', 'GoodsController@list')->name('goods.list');
route::get('admin/goods/{id?}', 'GoodsController@show')->name('goods.show');
route::post('admin/goods', 'GoodsController@register')->name('goods.register');
route::put('admin/goods', 'GoodsController@edit')->name('goods.edit');
route::delete('admin/goods', 'GoodsController@delete')->name('goods.delete');

//订单管理
route::get('admin/orders/{id?}/{li?}', 'OrdersController@list')->name('orders.list');
route::get('admin/orders/{id?}', 'OrdersController@show')->name('orders.show');
route::post('admin/orders', 'OrdersController@register')->name('orders.register');
route::put('admin/orders', 'OrdersController@edit')->name('orders.edit');
route::delete('admin/orders', 'OrdersController@delete')->name('orders.delete');

//购物车管理
route::get('www/carts/{id?}/{li?}', 'CartsController@list')->name('carts.list');
route::get('www/carts/{id?}', 'CartsController@show')->name('carts.show');
route::post('www/carts', 'CartsController@register')->name('carts.register');
route::put('www/carts', 'CartsController@edit')->name('carts.edit');
route::delete('www/carts', 'CartsController@delete')->name('carts.delete');