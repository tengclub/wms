<?php




	//-------Wap----------
	Route::group(['namespace' => 'Wap'], function () {
		// 		Route::get('/', function () {
		// 			return view('welcome');
		// 		});
	
		//后台登录
		Route::any('pub', 'PublicController@login');
		Route::any('pub/login', 'PublicController@login');
		Route::any('pub/logout', 'PublicController@logout');
			
			
	});
	Route::group(['middleware' => ['wap'],'namespace' => 'Wap'], function () {
		Route::any('home/index', 'HomeController@index');
		Route::any('order/out', 'OrderController@out');
		Route::any('order/in', 'OrderController@in');
		Route::any('order/outCreate', 'OrderController@outCreate');
		Route::any('order/outStatus/{id}', 'OrderController@outStatus');
		Route::any('order/inCreate', 'OrderController@inCreate');
		Route::any('order/inStatus/{id}', 'OrderController@inStatus');
		Route::any('items/index', 'ItemsController@index');
		
		Route::any('user/index', 'UserController@index');
	});