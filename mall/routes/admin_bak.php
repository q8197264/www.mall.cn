<?php
//login
echo 'admin';
//Route::group(['prefix' => 'admin'], function () {
Route::group(['middleware' => 'auth.admin'], function () {
    Route::get('/', 'IndexController@index');
});
Route::get('admin/login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('admin/login', 'LoginController@checkLogin');
Route::post('admin/logout', 'LoginController@logout');
//});
route::get('admin/index', 'IndexController@index')->name('index.index');
//route::get('/', 'AdministratorController@login')->name('administrator.login');
//route::get('admin/login', 'AdministratorController@login')->name('administrator.login');
//route::post('admin/checkLogin', 'AdministratorController@checkLogin')->name('administrator.checkLogin');
//route::delete('admin/logout', 'AdministratorController@logOut')->name('administrator.logOut');

//管理员管理
route::get('admin/administrator/list/{offset?}', 'AdministratorController@list')->name('administrator.list');
route::get('admin/administrator/{id?}', 'AdministratorController@show')->name('administrator.show');
route::post('admin/administrator', 'AdministratorController@register')->name('administrator.register');
route::put('admin/administrator', 'AdministratorController@edit')->name('administrator.edit');
route::delete('admin/administrator', 'AdministratorController@delete')->name('administrator.delete');

//分类管理-后台菜单
route::get('admin/navigate/{cid?}', 'NavigatesController@show')->name('navigates.show');
route::post('admin/navigate', 'NavigatesController@add')->name('navigates.add');
route::put('admin/navigate', 'NavigatesController@edit')->name('navigates.edit');
route::delete('admin/navigate/{cid?}', 'NavigatesController@del')->name('navigates.del');
//商品分类
route::get('admin/category/{cid?}', 'CategoriesController@show')->name('category.show');
route::post('admin/category', 'CategoriesController@add')->name('category.add');
route::put('admin/category', 'CategoriesController@edit')->name('category.edit');
route::delete('admin/category/{cid?}', 'CategoriesController@del')->name('category.del');

//用户管理
route::get('admin/users/list/{offset?}', 'UsersController@list')->name('users.list');
route::get('admin/users/{id?}', 'UsersController@show')->name('users.show');
route::post('admin/users', 'UsersController@register')->name('users.register');
route::put('admin/users', 'UsersController@edit')->name('users.edit');
route::delete('admin/users', 'UsersController@delete')->name('users.delete');

//商品管理
route::get('admin/goods/list/{offset?}', 'GoodsController@list')->name('goods.list');
route::get('admin/goods/{id?}', 'GoodsController@show')->name('goods.show');
route::post('admin/goods', 'GoodsController@add')->name('goods.add');
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