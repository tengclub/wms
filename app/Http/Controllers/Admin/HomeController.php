<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

use Input;
use App\Includes\Common;
use App\Includes\Ehtml;
use App\Page;
use App\Models\SysMenu;
use App\Models\Warehouse;
use App\Models\WhArea;
use App\Models\WhItems;
use App\Models\WhShelf;
use App\Models\WhUnit;
use App\Lib\SysKey;


class HomeController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    	$user = session('admin');
    	$menu = null;
    	if(SysKey::$sysUserLevelSuperAdminValue==$user->level)
    	{
    		$pmenu = SysMenu::where('pid', '0')->orderBy('order_id', 'asc')->get();
    		
    		foreach ($pmenu as $pm)
    		{
    			$smenu = SysMenu::where(['pid'=>$pm->id])->orderBy('group', 'asc')->orderBy('order_id', 'asc')->get();
    			$menu[] = ['i'=>$pm,'s'=>$smenu];
    		}
    		
    	}else {
    		$where = ['pid'=>'0'];
    		$condition = 'id in(select menu_id from '.$prefix.'sys_group_menu where group_id in(select group_id from '.$prefix.'sys_group_user where user="'.$user->user.'"))';
    		$pmenu = SysMenu::where($where)->whereRaw($condition)->groupBy('id')->orderBy('order_id', 'asc')->get();
    		foreach ($pmenu as $pm)
    		{
    			$smenu = SysMenu::where(['pid'=>$pm->id])->whereRaw($condition)->groupBy('id')->orderBy('order_id', 'asc')->get();
    			$menu[] = ['i'=>$pm,'s'=>$smenu];
    		}
    	}
        return view('admin.home.index',['menu'=>$menu]);
    }
	public function welcome()
    {
        $data = [];
    	$warehouse = Warehouse::where('status',SysKey::$statusOkValue)->get();
    	foreach ($warehouse as $wh) {
    		$_wh = null;
    		$_wh['name'] = $wh->code.'库';
    		$_wh['path'] = $wh->code;
    		$whArea = WhArea::where('warehouse_id',$wh->id)->get();
    		$_wh['value'] = count($warehouse);
    		foreach ($whArea as $area)
    		{
    			$_area = null;
    			$_area['name'] = $area->code.'区';
    			$_area['path'] = $wh->code.'/'.$area->code;
    			$whShelf = WhShelf::where(['warehouse_id'=>$wh->id,'wh_area_id'=>$area->id])->get();
    			$_area['value'] = count($whArea);
    			foreach($whShelf as $shelf)
    			{
    				$_shelf = null;
    				$_shelf['name'] = $area->code.'区'.$shelf->code.'架';
    				$_shelf['path'] = $wh->code.'/'.$area->code.'/'.$shelf->code;
    				$whUnit = WhUnit::where(['warehouse_id'=>$wh->id,'wh_area_id'=>$area->id,'wh_shelf_id'=>$shelf->id])->get();
    				$_shelf['value'] = count($whShelf);
    				foreach($whUnit as $unit)
    				{
    					$_unit = null;
    					$_unit['value'] = $unit->wh_items_num;
    					if($unit->wh_items_id)
    					{
    						$_unit['name'] = $area->code.'区'.$shelf->code.'架'."\n\n".$unit->code."容积：".$unit->volume;
    						$_unit['name'] .= "\n\n现".WhItems::findOrNew($unit->wh_items_id)->title."\n[".$unit->wh_items_num."]件";
    						
    					}else{
    						$_unit['name'] = "空\n\n容积：".$area->code.'区'.$shelf->code.'架'.$unit->code.$unit->volume;
    					}
    					
    					$_unit['path'] = $wh->code.'/'.$area->code.'/'.$shelf->code.'/'.$unit->code;
    					$_shelf['children'][] = $_unit;
    				}
    				$_area['children'][] = $_shelf;
    			}
    			$_wh['children'][] = $_area;
    		}
    		$data[] = $_wh;
    	}
    	$data = json_encode($data);
        return view('admin.home.welcome',['data'=>$data]);
    }
    public function treeData()
    {
    	$data = [];
    	$warehouse = Warehouse::where('status',SysKey::$statusOkValue)->get();
    	foreach ($warehouse as $wh) {
    		$_wh = null;
    		$_wh['name'] = $wh->code;
    		$_wh['path'] = $wh->code;
    		$whArea = WhArea::where('warehouse_id',$wh->id)->get();
    		$_wh['value'] = count($warehouse);
    		foreach ($whArea as $area)
    		{
    			$_area = null;
    			$_area['name'] = $area->code;
    			$_area['path'] = $wh->code.'/'.$area->code;
    			$whShelf = WhShelf::where(['warehouse_id'=>$wh->id,'wh_area_id'=>$area->id])->get();
    			$_area['value'] = count($whArea);
    			foreach($whShelf as $shelf)
    			{
    				$_shelf = null;
    				$_shelf['name'] = $shelf->code;
    				$_shelf['path'] = $wh->code.'/'.$area->code.'/'.$shelf->code;
    				$whUnit = WhUnit::where(['warehouse_id'=>$wh->id,'wh_area_id'=>$area->id,'wh_shelf_id'=>$shelf->id])->get();
    				$_shelf['value'] = count($whShelf);
//     				foreach($whUnit as $unit)
//     				{
//     					$_unit = null;
//     					$_unit['value'] = $unit->wh_items_num;
//     					if($unit->wh_items_id)
//     					{
//     						$_unit['name'] = $wh->code.'库'.$area->code.'区'.$shelf->code.'架'.$unit->code."容积：".$unit->volume;
//     						$_unit['name'] .= "\n\n现".WhItems::findOrNew($unit->wh_items_id)->title."\n[".$unit->wh_items_num."]件";
//     					}else{
//     						$_unit['name'] = "空\n\n容积：".$wh->code.'库房'.$area->code.'区'.$shelf->code.'架'.$_unit->code.$unit->volume;
//     					}
    					
//     					$_unit['path'] = $wh->code.'/'.$area->code.'/'.$shelf->code.'/'.$unit->code;
//     					$_shelf['children'][] = $_unit;
//     				}
//     				$_area['children'][] = $_shelf;
    			}
    			$_wh['children'][] = $_area;
    		}
    		$data[] = $_wh;
    	}
    	
    	
//     	$data = [];
//     	$warehouse = Warehouse::where('status',SysKey::$statusOkValue)->get();
//     	foreach ($warehouse as $wh) {
//     		$_wh = null;
//     		$_wh['value'] = 10;
//     		$_wh['name'] = $wh->code;
//     		$_wh['path'] = $wh->code;
//     		$whArea = WhArea::where('warehouse_id',$wh->id)->get();
//     		foreach ($whArea as $area)
//     		{
//     			$_area = null;
//     			$_area['value'] = 10;
//     			$_area['name'] = $area->code.$wh->code;
//     			$_area['path'] = $wh->code.'/'.$area->code.$wh->code;
//     			$whShelf = WhShelf::where(['warehouse_id'=>$wh->id,'wh_area_id'=>$area->id])->get();
//     			foreach($whShelf as $shelf)
//     			{
//     				$_shelf = null;
//     				$_shelf['value'] = 10;
//     				$_shelf['name'] = $shelf->code.$area->code.$wh->code;
//     				$_shelf['path'] = $wh->code.'/'.$area->code.$wh->code.'/'.$shelf->code.$area->code.$wh->code;
//     				$whUnit = WhUnit::where(['warehouse_id'=>$wh->id,'wh_area_id'=>$area->id,'wh_shelf_id'=>$shelf->id])->get();
//     				foreach($whUnit as $unit)
//     				{
//     					$_unit = null;
//     					$_unit['value'] = 10;
//     					$_unit['name'] = $unit->code.$shelf->code.$area->code.$wh->code;
//     					$_unit['path'] = $wh->code.'/'.$area->code.$wh->code.'/'.$shelf->code.$area->code.$wh->code.'/'.$unit->code.$shelf->code.$area->code.$wh->code;
//     					$_shelf['children'][] = $_unit;
//     				}
//     				$_area['children'][] = $_shelf;
//     			}
//     			$_wh['children'][] = $_area;
//     		}
//     		$data[] = $_wh;
//     	}
    	 
    	echo json_encode($data);
    }
   
}
