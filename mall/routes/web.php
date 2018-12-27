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
//后台路由
Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function () {
    Route::group(['middleware' => 'auth.admin'], function () {
        Route::get('/', 'IndexController@index');
    });
    Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'LoginController@authenticate');
    Route::post('logout', 'LoginController@logout');

    route::get('index', 'IndexController@index')->name('index.index');

    //管理员管理
    route::get('administrator/{offset?}', 'AdministratorController@list')->name('administrator.list');
    route::get('administrator/{id}/show', 'AdministratorController@show')->name('administrator.show');
    route::post('administrator', 'AdministratorController@register')->name('administrator.register');
    route::put('administrator', 'AdministratorController@edit')->name('administrator.edit');
    route::delete('administrator', 'AdministratorController@delete')->name('administrator.delete');

    //分类管理-后台菜单
    route::get('navigate/{cid?}', 'NavigatesController@show')->name('navigates.show');
    route::post('navigate', 'NavigatesController@add')->name('navigates.add');
    route::put('navigate', 'NavigatesController@edit')->name('navigates.edit');
    route::delete('navigate/{cid?}', 'NavigatesController@del')->name('navigates.del');
    //商品分类
    route::get('category/{cid?}', 'CategoriesController@show')->name('category.show');
    route::post('category', 'CategoriesController@add')->name('category.add');
    route::put('category', 'CategoriesController@edit')->name('category.edit');
    route::delete('category/{cid?}', 'CategoriesController@del')->name('category.del');

    //用户管理
    route::get('users/{offset?}', 'UsersController@list')->name('users.list');
    route::get('users/{id}/show', 'UsersController@show')->name('users.show');
    route::post('users', 'UsersController@register')->name('users.register');
    route::put('users', 'UsersController@edit')->name('users.edit');
    route::delete('users', 'UsersController@delete')->name('users.delete');

    //商品管理
    route::get('goods/{offset?}', 'GoodsController@list')->name('goods.list');
    route::get('goods/{id}/show', 'GoodsController@show')->name('goods.show');
    route::post('goods', 'GoodsController@add')->name('goods.add');
    route::put('goods', 'GoodsController@edit')->name('goods.edit');
    route::delete('goods', 'GoodsController@delete')->name('goods.delete');

    //订单管理
    route::get('orders/{offset?}', 'OrdersController@list')->name('orders.list');
    route::get('orders/{id}/show', 'OrdersController@show')->name('orders.show');
    route::post('orders', 'OrdersController@register')->name('orders.register');
    route::put('orders', 'OrdersController@edit')->name('orders.edit');
    route::delete('orders', 'OrdersController@delete')->name('orders.delete');
});


Route::get('WechatServerFirstConnectingVerify', 'Frontend\WechatServerFirstConnectingVerify@index');

//前端路由
    Auth::routes();
    Route::group(['namespace'=>'Auth'],function(){
        Route::get('login', 'LoginController@index')->name('login');
        Route::post('login', 'LoginController@authenticate');
        Route::post('logout', 'LoginController@logout');
        Route::post('register', 'RegisterController@register');

    });

    Route::group(['namespace'=>'Frontend'], function(){
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/', 'HomeController@index');
            Route::get('comment', 'CommentController@index');
        });



        Route::get('home', 'HomeController@index')->name('home');
//购物车
        route::get('carts/{cid?}', 'CartsController@show')->name('carts.show');
        route::post('carts', 'CartsController@add')->name('carts.add');
        route::put('carts', 'CartsController@edit')->name('carts.edit');
        route::put('carts/selected', 'CartsController@selected')->name('carts.selected');
        route::delete('carts/{cid?}', 'CartsController@del')->name('carts.del');
//商品分类
        route::get('category/{cid?}', 'CategoriesController@show')->name('category.show');
        route::post('category', 'CategoriesController@add')->name('category.add');
        route::put('category', 'CategoriesController@edit')->name('category.edit');
        route::delete('category/{cid?}', 'CategoriesController@del')->name('category.del');

//用户管理
        route::get('users/{offset?}', 'UsersController@list')->name('users.list');
        route::get('users/{id}/show', 'UsersController@show')->name('users.show');
        route::post('users', 'UsersController@register')->name('users.register');
        route::put('users', 'UsersController@edit')->name('users.edit');
        route::delete('users', 'UsersController@delete')->name('users.delete');

//商品管理
        route::get('goods/{offset?}', 'GoodsController@list')->name('goods.list');
        route::get('goods/{id}/show', 'GoodsController@show')->name('goods.show');
        route::post('goods', 'GoodsController@add')->name('goods.add');
        route::put('goods', 'GoodsController@edit')->name('goods.edit');
        route::delete('goods', 'GoodsController@delete')->name('goods.delete');

//地址管理
//        route::get('address/{offset?}', 'AddressController@list')->name('address.list');
        route::get('address/show', 'AddressController@show')->name('address.show');
        route::post('address', 'AddressController@add')->name('address.add');
        route::put('address', 'AddressController@edit')->name('address.edit');
        route::get('address/{id}/checked', 'AddressController@setDefault');
        route::delete('address', 'AddressController@del')->name('address.del');

//订单
//        route::get('orders/{offset?}', 'OrdersController@list')->name('orders.list');
        route::get('orders/show', 'OrdersController@show')->name('orders.show');
        route::post('orders/detail', 'OrdersController@detail')->name('orders.detail');
        route::post('orders', 'OrdersController@create')->name('orders.create');
        route::put('orders', 'OrdersController@edit')->name('orders.edit');
        route::delete('orders', 'OrdersController@delete')->name('orders.delete');

//评论
        route::get('comment/{oid}/link', 'CommentController@link')->name('comment.link');
        route::get('comment/{oid}/order/{kid}/todo', 'CommentController@todo')->name('comment.todo');
        route::get('comment/{oid}/todo', 'CommentController@todo')->name('comment.todo');
        route::post('comment', 'CommentController@add')->name('comment.add');

        //test
        Route::get('test', 'HomeController@queueTest')->name('home.queueTest');
    });
