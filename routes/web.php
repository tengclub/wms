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
// Route::group(['prefix' => 'admin'], function () {
// // 	//
// // 	Route::group(['middleware' => ['admin.main']], function () {
// // 		Route::get('/', function () {
// // 			return view('welcome');
// // 		});
// // 	});
	Route::get('/', function () {
		return view('welcome');
	});
	
// });

	Route::group(['prefix' => 'admin','namespace' => 'Admin'], function () {
// 		Route::get('/', function () {
// 			return view('welcome');
// 		});

		//后台登录
		Route::any('pub', 'PublicController@login');
		Route::any('pub/login', 'PublicController@login');
		Route::any('pub/logout', 'PublicController@logout');
			
			
	});
	Route::group(['middleware' => ['admin.main'],'prefix' => 'admin','namespace' => 'Admin'], function () {
		Route::any('home/index', 'HomeController@index');
		Route::any('home/welcome', 'HomeController@welcome');
		Route::any('home/treeData', 'HomeController@treeData');
		
		//系统用户
		Route::any('sysUser/index', 'SysUserController@index');
		Route::any('sysUser/ajaxData', 'SysUserController@ajaxData');
		Route::any('sysUser/create', 'SysUserController@create');
		Route::any('sysUser/edit/{id}', 'SysUserController@edit');
		Route::any('sysUser/destroy/{id}', 'SysUserController@destroy');
		Route::any('sysUser/ajaxDestroy/{id}', 'SysUserController@ajaxDestroy');
		Route::any('sysUser/group/{gid}', 'SysUserController@group');
// 		Route::any('sysUser/userEditPwd/', 'SysUserController@userEditPwd');
		
		
		//系统菜单
		Route::any('sysMenu/index', 'SysMenuController@index');
		Route::any('sysMenu/adminTree', 'SysMenuController@adminTree');
		
		Route::any('sysMenu/create', 'SysMenuController@create');
		Route::any('sysMenu/edit/{id}', 'SysMenuController@edit');
		Route::any('sysMenu/destroy/{id}', 'SysMenuController@destroy');
		//Route::resource('sysMenu', 'SysMenuController'); //后台菜单
		
		Route::any('sysMenu/gridGroup', 'SysMenuController@gridGroup');
		Route::any('sysMenu/gridGroupTree/{gid}', 'SysMenuController@gridGroupTree');
		Route::any('sysMenu/adminTree', 'SysMenuController@adminTree');
		Route::any('sysMenu/ajaxSave', 'SysMenuController@ajaxSave');
		Route::any('sysMenu/del/{ids}', 'SysMenuController@del');
		Route::any('sysMenu/ajaxDel/{ids}', 'SysMenuController@ajaxDel');
		Route::any('sysMenu/move', 'SysMenuController@move');
		
		
		//系统组
		Route::any('sysGroup/index', 'SysGroupController@index');
		Route::any('sysGroup/create', 'SysGroupController@create');
		Route::any('sysGroup/edit/{id}', 'SysGroupController@edit');
		Route::any('sysGroup/destroy/{id}', 'SysGroupController@destroy');
		Route::any('sysGroup/ajaxDestroy/{id}', 'SysGroupController@ajaxDestroy');
		Route::any('sysGroup/user/{gid}', 'SysGroupController@user');
// 		Route::any('sysGroup/ajaxAddUser', 'SysGroupController@ajaxAddUser');
// 		Route::any('sysGroup/ajaxDelUser', 'SysGroupController@ajaxDelUser');
		
		Route::any('sysGroup/menu/{gid}', 'SysGroupController@menu');
		Route::any('sysGroup/menuTree/{gid}', 'SysGroupController@menuTree');
		Route::any('sysGroup/ajaxAddMenu', 'SysGroupController@ajaxAddMenu');
		Route::any('sysGroup/ajaxDelMenu', 'SysGroupController@ajaxDelMenu');
		Route::any('sysGroup/ajaxData', 'SysGroupController@ajaxData');
		
		
		//系统组
		Route::any('sysGroupUser/index/{gid}', 'SysGroupUserController@index');
		Route::any('sysGroupUser/create', 'SysGroupUserController@create');
		Route::any('sysGroupUser/edit/{id}', 'SysGroupUserController@edit');
		Route::any('sysGroupUser/destroy/{id}', 'SysGroupUserController@destroy');
		Route::any('sysGroupUser/ajaxDestroy/{id}', 'SysGroupUserController@ajaxDestroy');
		Route::any('sysGroupUser/ajaxAddUser', 'SysGroupUserController@ajaxAddUser');
		
		//系统组菜单
		Route::any('sysGroupMenu/index', 'SysGroupMenuController@index');
		Route::any('sysGroupMenu/create', 'SysGroupMenuController@create');
		Route::any('sysGroupMenu/edit/{id}', 'SysGroupMenuController@edit');
		Route::any('sysGroupMenu/destroy/{id}', 'SysGroupMenuController@destroy');
		Route::any('sysGroupMenu/ajaxDestroy/{id}', 'SysGroupMenuController@ajaxDestroy');
		Route::any('sysGroupMenu/adminTree/{gid}', 'SysGroupMenuController@adminTree');
		Route::any('sysGroupMenu/ajaxAddMenu', 'SysGroupMenuController@ajaxAddMenu');
		Route::any('sysGroupMenu/ajaxDel/{ids}', 'SysGroupMenuController@ajaxDel');
		
		//系统组订单状态
		Route::any('sysGroupOrderStatus/index/{gid}', 'SysGroupOrderStatusController@index');
		Route::any('sysGroupOrderStatus/create', 'SysGroupOrderStatusController@create');
		Route::any('sysGroupOrderStatus/edit/{id}', 'SysGroupOrderStatusController@edit');
		Route::any('sysGroupOrderStatus/destroy/{id}', 'SysGroupOrderStatusController@destroy');
		Route::any('sysGroupOrderStatus/ajaxDestroy/{id}', 'SysGroupOrderStatusController@ajaxDestroy');
		Route::any('sysGroupOrderStatus/ajaxAdd', 'SysGroupOrderStatusController@ajaxAdd');
		//系统日志
		Route::any('sysLog/index', 'SysLogController@index');
		Route::any('sysLog/ajaxData', 'SysLogController@ajaxData');
		Route::any('sysLog/create', 'SysLogController@create');
		Route::any('sysLog/edit/{id}', 'SysLogController@edit');
		Route::any('sysLog/destroy/{id}', 'SysLogController@destroy');
		
		//wap菜单
		Route::any('wapMenu/index', 'WapMenuController@index');
		Route::any('wapMenu/create', 'WapMenuController@create');
		Route::any('wapMenu/edit/{id}', 'WapMenuController@edit');
		Route::any('wapMenu/destroy/{id}', 'WapMenuController@destroy');
		Route::any('wapMenu/ajaxDestroy/{id}', 'WapMenuController@ajaxDestroy');
		Route::any('wapMenu/group/{gid}', 'WapMenuController@group');
		
		//组wap菜单
		Route::any('sysGroupWapMenu/index/{gid}', 'SysGroupWapMenuController@index');
		Route::any('sysGroupWapMenu/create', 'SysGroupWapMenuController@create');
		Route::any('sysGroupWapMenu/edit/{id}', 'SysGroupWapMenuController@edit');
		Route::any('sysGroupWapMenu/destroy/{id}', 'SysGroupWapMenuController@destroy');
		Route::any('sysGroupWapMenu/ajaxDestroy/{id}', 'SysGroupWapMenuController@ajaxDestroy');
		Route::any('sysGroupWapMenu/ajaxAdd', 'SysGroupWapMenuController@ajaxAdd');
		
		Route::get('/b', function () {
			return view('welcome');
		});
		//仓库
		Route::any('warehouse/index', 'WarehouseController@index');
		Route::any('warehouse/create', 'WarehouseController@create');
		Route::any('warehouse/edit/{id}', 'WarehouseController@edit');
		Route::any('warehouse/destroy/{id}', 'WarehouseController@destroy');
		//仓库区域
		Route::any('whArea/index', 'WhAreaController@index');
		Route::any('whArea/create', 'WhAreaController@create');
		Route::any('whArea/edit/{id}', 'WhAreaController@edit');
		Route::any('whArea/destroy/{id}', 'WhAreaController@destroy');
		//仓库物品
		Route::any('whItems/index', 'WhItemsController@index');
		Route::any('whItems/create', 'WhItemsController@create');
		Route::any('whItems/edit/{id}', 'WhItemsController@edit');
		Route::any('whItems/destroy/{id}', 'WhItemsController@destroy');
		Route::any('whItems/whUnit/{wh_items_id}', 'WhItemsController@whUnit');
		//仓库位
		Route::any('whUnit/index', 'WhUnitController@index');
		Route::any('whUnit/create', 'WhUnitController@create');
		Route::any('whUnit/edit/{id}', 'WhUnitController@edit');
		Route::any('whUnitwhUnit/destroy/{id}', 'WhUnitController@destroy');
		//仓库货架
		Route::any('whShelf/index', 'WhShelfController@index');
		Route::any('whShelf/create', 'WhShelfController@create');
		Route::any('whShelf/edit/{id}', 'WhShelfController@edit');
		Route::any('whShelf/destroy/{id}', 'WhShelfController@destroy');
		Route::any('whShelf/ajaxDestroy/{id}', 'WhShelfController@ajaxDestroy');
		
		//入库订单
		Route::any('orderIn/index', 'OrderInController@index');
		Route::any('orderIn/create', 'OrderInController@create');
		Route::any('orderIn/edit/{id}', 'OrderInController@edit');
		Route::any('orderIn/destroy/{id}', 'OrderInController@destroy');
		Route::any('orderIn/ajaxDestroy/{id}', 'OrderInController@ajaxDestroy');
		Route::any('orderIn/inWhUnit', 'OrderInController@inWhUnit');
		Route::any('orderIn/setInUnit', 'OrderInController@setInUnit');
		Route::any('orderIn/status/{id}', 'OrderInController@status');
		
		//出库订单
		Route::any('orderOut/index', 'OrderOutController@index');
		Route::any('orderOut/create', 'OrderOutController@create');
		Route::any('orderOut/edit/{id}', 'OrderOutController@edit');
		Route::any('orderOut/destroy/{id}', 'OrderOutController@destroy');
		Route::any('orderOut/ajaxDestroy/{id}', 'OrderOutController@ajaxDestroy');
		Route::any('orderOut/outWhUnit', 'OrderOutController@outWhUnit');
		Route::any('orderOut/setOutUnit', 'OrderOutController@setOutUnit');
		Route::any('orderOut/status/{id}', 'OrderOutController@status');
		
		//订单状态分类
		Route::any('orderStatusType/index', 'OrderStatusTypeController@index');
		Route::any('orderStatusType/create', 'OrderStatusTypeController@create');
		Route::any('orderStatusType/edit/{id}', 'OrderStatusTypeController@edit');
		Route::any('orderStatusType/destroy/{id}', 'OrderStatusTypeController@destroy');
		Route::any('orderStatusType/ajaxDestroy/{id}', 'OrderStatusTypeController@ajaxDestroy');
		
		//订单状态
		Route::any('orderStatus/index', 'OrderStatusController@index');
		Route::any('orderStatus/create', 'OrderStatusController@create');
		Route::any('orderStatus/edit/{id}', 'OrderStatusController@edit');
		Route::any('orderStatus/destroy/{id}', 'OrderStatusController@destroy');
		Route::any('orderStatus/ajaxDestroy/{id}', 'OrderStatusController@ajaxDestroy');
		
		Route::any('orderStatus/group/{gid}', 'OrderStatusController@group');
		
		//订单状态日志
		Route::any('orderStatusLog/index', 'OrderStatusLogController@index');
		Route::any('orderStatusLog/create', 'OrderStatusLogController@create');
		Route::any('orderStatusLog/edit/{id}', 'OrderStatusLogController@edit');
		Route::any('orderStatusLog/destroy/{id}', 'OrderStatusLogController@destroy');
		Route::any('orderStatusLog/ajaxDestroy/{id}', 'OrderStatusLogController@ajaxDestroy');
		
		//订单状态分类
		Route::any('orderAndStatusType/index', 'OrderAndStatusTypeController@index');
		Route::any('orderAndStatusType/create', 'OrderAndStatusTypeController@create');
		Route::any('orderAndStatusType/edit/{id}', 'OrderAndStatusTypeController@edit');
		Route::any('orderAndStatusType/destroy/{id}', 'OrderAndStatusTypeController@destroy');
		Route::any('orderAndStatusType/ajaxDestroy/{id}', 'OrderAndStatusTypeController@ajaxDestroy');
		
	});
	
	

	
	
	
	
	//生产环境请删除
	Route::any('my', 'MyController@index');
	Route::any('my/test', 'MyController@test');
	Route::any('my/m/{tb}', 'MyController@m');
	Route::any('my/v/{tb}', 'MyController@v');
	Route::any('my/c/{tb}', 'MyController@c');
	
	//kindEditor
	Route::any('kindEditor/uploadJson', 'KindEditorController@uploadJson');
	Route::any('kindEditor/fileManageerJson', 'KindEditorController@fileManageerJson');
	
	Route::any('util/ajaxCitySelect/{pid}', 'UtilController@ajaxCitySelect');
	Route::any('util/ajaxAreaSelect/{cid}', 'UtilController@ajaxAreaSelect');
	Route::any('util/ajaxWhAreaSelect/{cid}', 'UtilController@ajaxWhAreaSelect');
	Route::any('util/ajaxWhShelfSelect/{cid}', 'UtilController@ajaxWhShelfSelect');
	
	
	Route::group(['namespace' => 'Web'], function () {
		Route::any('web', 'HomeController@index');
		Route::any('list/{typeId}', 'HomeController@newsType');
	});
		
	//后台登录
	Route::any('weixin/payNative/{orderId}', 'WeixinController@payNative');
	Route::any('weixin/qrcode', 'WeixinController@qrcode');
	Route::any('weixin/payNotify', 'WeixinController@payNotify');
	Route::any('weixin/ajaxPayOrderQuery', 'WeixinController@ajaxPayOrderQuery');
	Route::any('weixin/login/{r}', 'WeixinController@login');

			

