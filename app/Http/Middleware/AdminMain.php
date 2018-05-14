<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Models\SysMenu;
use App\Lib\SysKey;

class AdminMain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//         if (Auth::guard($guard)->check()) {
//             return redirect('/home');
//         }
// config
// 		$prefix = config::get('database.connections.mysql.prefix');
// 		$prefix = 'ufeng_';
		if(Session::has('admin')) {
			$user = session('admin');
			
			
			//获取选中左侧菜单
// 			$mi =  $request->get('mi',0);
// 			if($mi)
// 	       	{
// 	       		Session::put('mi', $mi);
// 	       	}elseif (Session::get('mi')){
// 	       		$mi = Session::get('mi');
// 	       	}
// 			$indexMenu = SysMenu::find($mi);
// 			if(!$indexMenu)
// 			{
// 				$indexMenu = new Sysmenu();
// 				$indexMenu->pid = 0;
// 			}
// 			//用户权限
// 			if(SysKey::$sysUserLevelSuperAdminValue==$user->level)
// 			{
// 				$topMenu = SysMenu::where('pid', '0')->orderBy('order_id', 'asc')->get();
// 				$leftMenu = SysMenu::where('pid', $indexMenu->pid)->orderBy('group', 'asc')->orderBy('order_id', 'asc')->get();
// 			}else {
// 				$where = ['pid'=>'0'];
// 				$condition = 'id in(select menu_id from '.$prefix.'sys_group_menu where group_id in(select group_id from '.$prefix.'sys_group_user where user="'.$user->user.'"))';
// 				$topMenu = SysMenu::where($where)->whereRaw($condition)->groupBy('id')->orderBy('order_id', 'asc')->get();
// 				$where = ['pid'=>$indexMenu->pid];
// 				$leftMenu = SysMenu::where($where)->whereRaw($condition)->groupBy('id')->orderBy('order_id', 'asc')->get();
// 			}
			//用户权限
// 			if(SysKey::$sysUserLevelSuperAdminValue==$user->level)
// 			{
// 				$topMenu = SysMenu::where('pid', '0')->orderBy('order_id', 'asc')->get();
// 				$leftMenu = SysMenu::where('pid','<>',0)->orderBy('group', 'asc')->orderBy('order_id', 'asc')->get();
// 			}else {
// 				$where = ['pid'=>'0'];
// 				$condition = 'id in(select menu_id from '.$prefix.'sys_group_menu where group_id in(select group_id from '.$prefix.'sys_group_user where user="'.$user->user.'"))';
// 				$topMenu = SysMenu::where($where)->whereRaw($condition)->groupBy('id')->orderBy('order_id', 'asc')->get();
// 				$leftMenu = SysMenu::where('pid','<>',0)->whereRaw($condition)->groupBy('id')->orderBy('order_id', 'asc')->get();
// 			}
			
// 			$menu['p'] = $topMenu;
// 			foreach ($leftMenu as $obj) {
// 				$menu['c'][$obj->pid][$obj->id] = $obj;
// 			}
			
			view()->share('user', $user); //角色信息
// 			view()->share('menu', $menu); //角色信息
// 	       	view()->share('menuIndex', ['ti'=>$indexMenu->pid,'li'=>$mi]); //tih 上部菜单key li左侧菜单key
	       	//菜单当前样式　end
	       	
	       }else{
				Header("Location: " . url('admin/pub/login') . '?reUrl=' . URL::full());
				exit;
	       }

        return $next($request);
    }
}
