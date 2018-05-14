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
use App\Models\OrderIn;
use App\Models\OrderOut;
use App\Models\OrderAndStatusType;
use App\Models\OrderStatus;
use App\Models\OrderStatusLog;
use App\Models\OrderStatusType;
use App\Models\SysGroupOrderStatus;
use App\Models\SysGroup;
use App\Models\SysGroupUser;
use App\Lib\SysKey;


class OrderController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function out(Request $request)
    {
    	$user = session('wapUser');
    	$model = new OrderOut();
		$condtion = '1=1';
		$page = null;
		if(Input::all())
		{
			$page = Input::all();
			foreach ($page as $key=>$value)
			{
				if(in_array($key,array_keys($model->labels)))
				{
					$model->$key = $value;
					$condtion .=' and '.$key.' like "%'.$value.'%"';
				}
			}
		}
		
		if($request->get('__data'))
		{
			$_data = null;
			$_html = '';
			$_more = '点击查看更多';
			$page = $request->get('page',1);
			if($user->level==SysKey::$sysUserLevelUserValue)
			{
				$data = OrderOut::whereRaw($condtion)->where(['create_user'=>$user->user])->orderBy('create_time','desc')->paginate(10);
			}else{
				$data = OrderOut::whereRaw($condtion)->orderBy('create_time','desc')->paginate(10);
			}
    		
    		foreach ($data as $obj) {
    			$_html .= '<div class="aui-card-list">';
    			$_html .= '<div class="aui-card-list-header">订单'.$obj->id.'</div>';
    			$_html .= '<div class="aui-card-list-content-padded">';
    			$_html .= WhItems::findOrNew($obj->wh_items_id)->title.'数量:'.$obj->wh_items_quantity.' 已出:'.$obj->out_quantity.'&nbsp;&nbsp;&nbsp;&nbsp;';
    			$statusData = json_decode($obj->status_data,true);
    			if($statusData[$obj->status])
    			{
    				$statusText = $statusData[$obj->status]['text'];
    			}else{
    				$statusText = $obj->status;
    			}
    			$_html .= '<br/>状态:'.SysKey::getOrderStatusStatusByValue($obj->status_over).'-'.$statusText;
//     			$_html .= '<br/>审核:'.$obj->status_user.' '.$obj->status_time;
    			$_html .= '</div>';
    			$_html .= '<div class="aui-card-list-footer">创建:'.$obj->create_user.'&nbsp;&nbsp;'.$obj->create_time.'<a href="'.url('wap/order/outStatus',['id'=>$obj->id]).'">审</a></div>';
    			$_html .= '</div>';
    			
    		}
    		if($data->total()<1)
    		{
    			$_more = '暂无数据';
    		}elseif($data->total()<$page*10){
    			$_more = '已是全部数据';
    		}
    		echo json_encode(['html'=>$_html,'more'=>$_more,'code'=>'000','msg'=>'','page'=>$page+1]);
    		return;
    	}
		return view('wap.order.out', ['model'=>$model]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function outCreate(Request $request)
    {
    	$model = new OrderOut();
    	if(isset($_POST['page']))
    	{
    		$page = $_POST['page'];
    		$validator = Validator::make($page,
    				[
    						//'id' => 'required|unique:table_name',
    				]
    		);
    		foreach ($page as $key=>$value)
    		{
    			$model->$key = $value;
    		}
    	
    		if ($validator->passes())
    		{
    			//验证数量
    			$itemsNum = WhUnit::where('wh_items_id',$model->wh_items_id)->sum('wh_items_num');
    			$condition = ['wh_items_id'=>$model->wh_items_id,'status_over'=>SysKey::$orderStatusStatusIngValue];
    			$lockNum =  OrderOut::where($condition)->sum('wh_items_quantity');
    			$_num = $itemsNum-$lockNum;
    			if($model->wh_items_quantity>$_num)
    			{
    				$validator->errors()->add('wh_items_quantity', '库存数量少于'.$model->wh_items_quantity.'，锁定'.$lockNum.'剩余 '.$_num);
    				$model->errors = $validator->messages();
    				return view('wap.order.outCreate', ['model'=>$model]);
    			}
    	
    	
    			$model->create_time = Common::getDateTime();
    			$model->create_user = session('wapUser')->user;
    			$model->id = Common::getId();
    			$model->order_no = $model->id;
    	
    			$orderAndStatusType = OrderAndStatusType::firstOrNew(['order_table'=>$model::$_tb,'order_type'=>SysKey::$orderTypeNoneValue]);
    			$model->order_status_type_id = $orderAndStatusType->order_status_type_id;
    			$model->order_type = SysKey::$orderTypeNoneValue;
    	
    			$orderStatusKey = OrderStatus::getKeysOrNullByTypeId($model->order_status_type_id);
    			if(isset($orderStatusKey[0]))
    			{
    				$orderStatus = OrderStatus::findOrNew($orderStatusKey[0]);
    	
    				$model->status = $orderStatusKey[0];
    				$model->status_time = Common::getDateTime();
    				$model->status_data = json_encode([$model->status=>['time'=>$model->status_time,'text'=>$orderStatus->title,'user'=>$model->create_user]]);
    				$model->status_over = $orderStatus->status;
    	
    				$orderStatusLog = new OrderStatusLog();
    				$orderStatusLog->id = Common::getId();
    				$orderStatusLog->order_id = $model->id;
    				$orderStatusLog->order_status_id = $model->status;
    				$orderStatusLog->order_status_title = $orderStatus->title;
    				$orderStatusLog->status_value = $model->status;
    				$orderStatusLog->object_type = SysKey::$orderStatusTypeNoneValue;
    				$orderStatusLog->create_user = session('wapUser')->user;
    				$orderStatusLog->create_time = Common::getDateTime();
    				$orderStatusLog->update_user = session('wapUser')->user;
    				$orderStatusLog->update_time =Common::getDateTime();
    				$orderStatusLog->save();
    			}else{
    				$model->status = 1;
    				$model->status_time = Common::getDateTime();
    				$model->status_data = json_encode([$model->status=>['time'=>$model->status_time,'text'=>'无审通过','user'=>$model->create_user]]);
    				$model->status_over = SysKey::$orderStatusStatusOkValue;
    				$model->status_user = $model->create_user;
    			}
    	
    			if ($model->save()) {
    				return view('wap.public.msgOk', ['msg'=>'保存成功','url'=>url('wap/order/out')]);
    			} else {
    				return view('wap.public.msgNo', ['msg'=>'保存失败','url'=>url('wap/order/outCreate')]);
    			}
    		}else {
    			$model->errors = $validator->messages();
    		}
    	}else {
    		$validator = Validator::make(array(),array());
    		$model->errors = $validator->messages();
    	}
    	return view('wap.order.outCreate', ['model'=>$model]);
    	
    	
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function outStatus(Request $request,$id)
    {
    	$model = OrderOut::findOrNew($id);
    	// 		if($model->status_over!=SysKey::$orderStatusStatusIngValue)
    	// 		{
    	// 			return view('admin.public.msgNo', ['msg'=>'该订单已'.SysKey::getOrderStatusStatusByValue($model->status_over),'url'=>url('admin/orderIn/index')]);
    	// 		}
    	if(!$model->order_status_type_id)
    	{
    		$model->status = 1;
    		$model->status_time = Common::getDateTime();
    		$model->status_data = json_encode([$model->status=>['time'=>$model->status_time,'text'=>'无审通过','user'=>$model->create_user]]);
    		$model->status_over = SysKey::$orderStatusStatusOkValue;
    		$model->status_user = session('wapUser')->user;
    		$model->save();
    	}
    	if(isset($_POST['page']))
    	{
    		$page = $_POST['page'];
    		$statusObjectValue = null;
    		if(isset($_POST['status_object_value']))
    		{
    			$statusObjectValue = $_POST['status_object_value'];
    		}
    		if(isset($page['status']))
    		{
    			$model->status = $page['status'];
    			$model->status_user = session('wapUser')->user;
    			$model->status_time = Common::getDateTime();
    
    			$statusObjectText = $statusObjectValue;
    			$orderStatus = OrderStatus::findOrNew($model->status);
    			if($orderStatus->object_type==SysKey::$orderStatusTypeRadioValue||
    					$orderStatus->object_type==SysKey::$orderStatusTypeCheckboxValue||
    					$orderStatus->object_type==SysKey::$orderStatusTypeDropdownValue)
    			{
    				if($orderStatus->object_value)
    				{
    					$orderStatus->object_value = explode(',',$orderStatus->object_value);
    					$statusObjectText = null;
    					foreach ($orderStatus->object_value as $value)
    					{
    						$_tmp = explode('|',$value);
    						if(isset($_tmp[1]))
    						{
    							if(is_array($statusObjectValue))
    							{
    
    								foreach ($statusObjectValue as $key=>$ov)
    								{
    									if($_tmp[0]==$ov)
    									{
    										$statusObjectText[] = $_tmp[1];
    										break;
    									}
    								}
    							}else{
    								if($_tmp[0]==$statusObjectValue)
    								{
    									$statusObjectText = $_tmp[1];
    									break;
    								}
    							}
    
    						}
    					}
    				}
    			}
    			if(is_array($statusObjectValue))
    			{
    				$statusObjectValue = implode(',',$statusObjectValue);
    			}
    			if(is_array($statusObjectText))
    			{
    				$statusObjectText = implode(',',$statusObjectText);
    			}
    			$_object = ['type'=>$orderStatus->object_type,'value'=>$statusObjectValue,'text'=>$statusObjectText,'lable'=>$orderStatus->object_lable];
    
    			$_data = json_decode($model->status_data,true);
    			$_data[$model->status] = ['time'=>$model->status_time,'text'=>$orderStatus->title,'user'=>$model->create_user,'object'=>$_object];
    			$model->status_data = json_encode($_data);
    			$model->status_over = $orderStatus->status;
    			OrderStatusLog::setLog($id, $orderStatus,$statusObjectValue);
    
    			if($request->get('_status')==9)
    			{
    				$model->status_over = SysKey::$orderStatusStatusRefuseValue;
    			}
    		}
    		if($model->save())
    		{
    			return view('wap.public.msgOk', ['msg'=>'审核成功','url'=>url('wap/order/outStatus',['id'=>$id])]);
    		}
    	}
    
    	$nextStatus = OrderStatus::getNextById($model->status);
    	$model->status_data = json_decode($model->status_data,true);
    
    	$userGroup = SysGroupUser::where('user',session('wapUser')->user)->pluck('group_id');
    	$myStatus = SysGroupOrderStatus::whereIn('group_id',$userGroup)->pluck('order_status_id')->toArray();
    
    	return view('wap.order.outStatus', ['model'=>$model,'nextStatus'=>$nextStatus,'myStatus'=>$myStatus]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function in(Request $request)
    {
    	$user = session('wapUser');
    	$model = new OrderIn();
		$condtion = '1=1';
		$page = null;
		if(Input::all())
		{
			$page = Input::all();
			foreach ($page as $key=>$value)
			{
				if(in_array($key,array_keys($model->labels)))
				{
					$model->$key = $value;
					$condtion .=' and '.$key.' like "%'.$value.'%"';
				}
			}
		}
		
		if($request->get('__data'))
		{
			$_data = null;
			$_html = '';
			$_more = '点击查看更多';
			$page = $request->get('page',1);
    		
    		if($user->level==SysKey::$sysUserLevelUserValue)
    		{
    			$data = OrderIn::whereRaw($condtion)->where(['create_user'=>$user->user])->orderBy('create_time','desc')->paginate(10);
    		}else{
    			$data = OrderIn::whereRaw($condtion)->orderBy('create_time','desc')->paginate(10);
    		}
    		foreach ($data as $obj) {
    			$_html .= '<div class="aui-card-list">';
    			$_html .= '<div class="aui-card-list-header">订单'.$obj->id.'</div>';
    			$_html .= '<div class="aui-card-list-content-padded">';
    			$_html .= WhItems::findOrNew($obj->wh_items_id)->title.'数量:'.$obj->wh_items_quantity.' 已入:'.$obj->out_quantity.'&nbsp;&nbsp;&nbsp;&nbsp;';
    			$statusData = json_decode($obj->status_data,true);
    			if($statusData[$obj->status])
    			{
    				$statusText = $statusData[$obj->status]['text'];
    			}else{
    				$statusText = $obj->status;
    			}
    			$_html .= '<br/>状态:'.SysKey::getOrderStatusStatusByValue($obj->status_over).'-'.$statusText;
//     			$_html .= '<br/>审核:'.$obj->status_user.' '.$obj->status_time;
    			$_html .= '</div>';
    			$_html .= '<div class="aui-card-list-footer">创建:'.$obj->create_user.'&nbsp;&nbsp;'.$obj->create_time.'<a href="'.url('wap/order/inStatus',['id'=>$obj->id]).'">审</a></div>';
    			$_html .= '</div>';
    			
    		}
    		if($data->total()<1)
    		{
    			$_more = '暂无数据';
    		}elseif($data->total()<$page*10){
    			$_more = '已是全部数据';
    		}
    		echo json_encode(['html'=>$_html,'more'=>$_more,'code'=>'000','msg'=>'','page'=>$page+1]);
    		return;
    	}
		return view('wap.order.in', ['model'=>$model]);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function inCreate(Request $request)
    {
    	$model = new OrderIn();
		if(isset($_POST['page']))
		{
			$page = $_POST['page'];
			$validator = Validator::make($page,
				[
					//'id' => 'required|unique:table_name',
				]
			);
			foreach ($page as $key=>$value)
			{
				$model->$key = $value;
			}
			if ($validator->passes())
			{
				$model->create_time = Common::getDateTime();
				$model->create_user = session('wapUser')->user;
				$model->id = Common::getId();
				$model->order_no = $model->id;
				
				$orderAndStatusType = OrderAndStatusType::firstOrNew(['order_table'=>$model::$_tb,'order_type'=>SysKey::$orderTypeNoneValue]);
				$model->order_status_type_id = $orderAndStatusType->order_status_type_id;
				$model->order_type = SysKey::$orderTypeNoneValue;
				
				$orderStatusKey = OrderStatus::getKeysOrNullByTypeId($model->order_status_type_id);
				if(isset($orderStatusKey[0]))
				{
					$orderStatus = OrderStatus::findOrNew($orderStatusKey[0]);
					
					$model->status = $orderStatusKey[0];
					$model->status_time = Common::getDateTime();
					$model->status_data = json_encode([$model->status=>['time'=>$model->status_time,'text'=>$orderStatus->title,'user'=>$model->create_user]]);
					$model->status_over = $orderStatus->status;
					
					$orderStatusLog = new OrderStatusLog();
					$orderStatusLog->id = Common::getId();
					$orderStatusLog->order_id = $model->id;
					$orderStatusLog->order_status_id = $model->status;
					$orderStatusLog->order_status_title = $orderStatus->title;
					$orderStatusLog->status_value = $model->status;
					$orderStatusLog->object_type = SysKey::$orderStatusTypeNoneValue;
					$orderStatusLog->create_user = session('wapUser')->user;
					$orderStatusLog->create_time = Common::getDateTime();
					$orderStatusLog->update_user = session('wapUser')->user;
					$orderStatusLog->update_time =Common::getDateTime();
					$orderStatusLog->save();
				}else{
					$model->status = 1;
					$model->status_time = Common::getDateTime();
					$model->status_data = json_encode([$model->status=>['time'=>$model->status_time,'text'=>'无审通过','user'=>$model->create_user]]);
					$model->status_over = SysKey::$orderStatusStatusOkValue;
					$model->status_user = $model->create_user;
				}
				
				
				if ($model->save()) {
					return view('wap.public.msgOk', ['msg'=>'保存成功','url'=>url('wap/order/in')]);
				} else {
					return Redirect::back()->withInput()->withErrors('保存失败！');
				}
			}else {
				$model->errors = $validator->messages();
			}
		}else {
			$validator = Validator::make(array(),array());
			$model->errors = $validator->messages();
		}
		return view('wap.order.inCreate', ['model'=>$model]);
    	 
    	 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function inStatus(Request $request,$id)
    {
    	$model = OrderIn::findOrNew($id);
    	// 		if($model->status_over!=SysKey::$orderStatusStatusIngValue)
    		// 		{
    		// 			return view('admin.public.msgNo', ['msg'=>'该订单已'.SysKey::getOrderStatusStatusByValue($model->status_over),'url'=>url('admin/orderIn/index')]);
    		// 		}
    	if(!$model->order_status_type_id)
    	{
    		$model->status = 1;
    		$model->status_time = Common::getDateTime();
    		$model->status_data = json_encode([$model->status=>['time'=>$model->status_time,'text'=>'无审通过','user'=>$model->create_user]]);
    		$model->status_over = SysKey::$orderStatusStatusOkValue;
    		$model->status_user = session('wapUser')->user;
    		$model->save();
    	}
    	if(isset($_POST['page']))
    	{
    		$page = $_POST['page'];
    		$statusObjectValue = null;
    		if(isset($_POST['status_object_value']))
    		{
    			$statusObjectValue = $_POST['status_object_value'];
    		}
    		if(isset($page['status']))
    		{
    			$model->status = $page['status'];
    			$model->status_user = session('wapUser')->user;
    			$model->status_time = Common::getDateTime();
    
    			$statusObjectText = $statusObjectValue;
    			$orderStatus = OrderStatus::findOrNew($model->status);
    			if($orderStatus->object_type==SysKey::$orderStatusTypeRadioValue||
    					$orderStatus->object_type==SysKey::$orderStatusTypeCheckboxValue||
    					$orderStatus->object_type==SysKey::$orderStatusTypeDropdownValue)
    			{
    				if($orderStatus->object_value)
    				{
    					$orderStatus->object_value = explode(',',$orderStatus->object_value);
    					$statusObjectText = null;
    					foreach ($orderStatus->object_value as $value)
    					{
    						$_tmp = explode('|',$value);
    						if(isset($_tmp[1]))
    						{
    							if(is_array($statusObjectValue))
    							{
    									
    								foreach ($statusObjectValue as $key=>$ov)
    								{
    									if($_tmp[0]==$ov)
    									{
    										$statusObjectText[] = $_tmp[1];
    										break;
    									}
    								}
    							}else{
    								if($_tmp[0]==$statusObjectValue)
    								{
    									$statusObjectText = $_tmp[1];
    									break;
    								}
    							}
    
    						}
    					}
    				}
    			}
    			if(is_array($statusObjectValue))
    			{
    				$statusObjectValue = implode(',',$statusObjectValue);
    			}
    			if(is_array($statusObjectText))
    			{
    				$statusObjectText = implode(',',$statusObjectText);
    			}
    			$_object = ['type'=>$orderStatus->object_type,'value'=>$statusObjectValue,'text'=>$statusObjectText,'lable'=>$orderStatus->object_lable];
    
    			$_data = json_decode($model->status_data,true);
    			$_data[$model->status] = ['time'=>$model->status_time,'text'=>$orderStatus->title,'user'=>$model->create_user,'object'=>$_object];
    			$model->status_data = json_encode($_data);
    			$model->status_over = $orderStatus->status;
    			OrderStatusLog::setLog($id, $orderStatus,$statusObjectValue);
    
    			if($request->get('_status')==9)
    			{
    				$model->status_over = SysKey::$orderStatusStatusRefuseValue;
    			}
    		}
    		if($model->save())
    		{
    			return view('wap.public.msgOk', ['msg'=>'审核成功','url'=>url('wap/order/inStatus',['id'=>$id])]);
    		}
    	}
    
    	$nextStatus = OrderStatus::getNextById($model->status);
    	$model->status_data = json_decode($model->status_data,true);
    
    	$userGroup = SysGroupUser::where('user',session('wapUser')->user)->pluck('group_id');
    	$myStatus = SysGroupOrderStatus::whereIn('group_id',$userGroup)->pluck('order_status_id')->toArray();
    
    	return view('wap.order.inStatus', ['model'=>$model,'nextStatus'=>$nextStatus,'myStatus'=>$myStatus]);
    }
}
