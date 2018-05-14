<?php

namespace App\Http\Controllers\Wap;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

use Input;
use App\Lib\Common;
use App\Page;
use App\Models\SysMenu;
use App\Models\Warehouse;
use App\Models\WhArea;
use App\Models\WhItems;
use App\Models\WhShelf;
use App\Models\WhUnit;
use App\Lib\SysKey;


class ItemsController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
    	$model = new WhItems();
		$condtion = 'status='.SysKey::$statusOkValue;
		$page = null;
		$searchKey = null;
		if($request->get('searchKey'))
		{
			$searchKey = $request->get('searchKey');
			$condtion .=' and (code like "%'.$searchKey.'%" or title like "%'.$searchKey.'%")';
		}
		
		if($request->get('__data'))
		{
			$_data = null;
			$_html = '';
			$_more = '点击查看更多';
			$page = $request->get('page',1);
    		$data = WhItems::whereRaw($condtion)->orderBy('code','asc')->paginate(10);
    		foreach ($data as $obj) {
    			$_html .= '<li class="aui-list-item aui-list-item-middle">';
    			$_html .= '<div class="aui-media-list-item-inner">';
    			$_html .= '<div class="aui-list-item-media" style="width: 3rem;">';
    			if($obj->img1)
    			{
    				$_html .= '<img src="'.asset($obj->img1).'" class="aui-list-img-sm">';
    			}else{
//     				$_html .= '<img src="'.asset($obj->img1).'" class="aui-img-round aui-list-img-sm">';
    			}
    			$_unit = '';
    			
    			$whUnit = WhUnit::where('wh_items_id',$obj->id)->orderBy('order_by_out')->first();
    			if($whUnit)
    			{

    				$_unit = Warehouse::findOrNew($whUnit->warehouse_id)->title.' '.WhArea::findOrNew($whUnit->wh_area_id)->title.' '.WhShelf::findOrNew($whUnit->wh_shelf_id)->title.' '.$whUnit->code;
    			}
    			
    			$_html .= '</div>';
    			$_html .= '<div class="aui-list-item-inner aui-list-item-arrow">';
    			$_html .= '<div class="aui-list-item-text">';
    			$_html .= '<div class="aui-list-item-title aui-font-size-14">'.$obj->title.' 编号：'.$obj->code.'</div>';
    			$_html .= '<div class="aui-list-item-right">数量：'. WhUnit::where('wh_items_id',$obj->id)->sum('wh_items_num').'</div>';
    			$_html .= '</div>';
    			$_html .= '<div class="aui-list-item-text">';
    			$_html .= $_unit;
    			$_html .= '</div>';
    			$_html .= '</div>';
    			$_html .= '</div>';
    			$_html .= '</li>';
    			
    		}
    		if($data->total()<1)
    		{
    			$_more = '暂无数据';
    		}elseif($data->total()<=$page*10){
    			$_more = '已是全部数据';
    		}
    		echo json_encode(['html'=>$_html,'more'=>$_more,'code'=>'000','msg'=>'','page'=>$page+1]);
    		return;
    	}
		return view('wap.items.index', ['model'=>$model,'searchKey'=>$searchKey]);
    }
   
}
