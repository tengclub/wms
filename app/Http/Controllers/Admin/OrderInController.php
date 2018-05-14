<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Input;
use App\Page;
use App\Models\OrderIn;
use App\Models\SysLog;
use App\Models\WhItems;
use App\Models\WhUnit;
use App\Models\WhShelf;
use App\Models\Warehouse;
use App\Models\WhArea;
use App\Models\OrderAndStatusType;
use App\Models\OrderStatus;
use App\Models\OrderStatusLog;
use App\Models\OrderStatusType;
use App\Models\SysGroupOrderStatus;
use App\Models\SysGroup;
use App\Models\SysGroupUser;

use App\Lib\Common;
use App\Lib\SysKey;


class OrderInController 
{
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function index(Request $request)
	{
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
    		$data = OrderIn::whereRaw($condtion)->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
    		foreach ($data as $boj) {
    			foreach ($boj->getAttributes() as $k=>$v) {
    				$_tmp[$k] = $v;
    				if($k=='wh_items_id')
    				{
    					$_tmp['wh_items_text'] = WhItems::findOrNew($v)->title;
    				}
    				if($k=='in_status')
    				{
    					$_tmp['in_status_text'] = SysKey::getYesOrNoByValue($v);
    				}
    				if($k=='status_over')
    				{
    					$_tmp['status_over_text'] = SysKey::getOrderStatusStatusByValue($v);
    				}
    				if($k=='status')
    				{
    					$statusData = json_decode($boj->status_data,true);
    					if($statusData[$boj->status])
    					{
    						$_tmp['status_text'] = $statusData[$boj->status]['text'];
    					}else{
    						$_tmp['status_text'] = $boj->status;
    					}
    				}
    				
    			}
    			$_data[] = $_tmp;
    		}
    		echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
    		return;
    	}
		return view('admin.orderIn.index', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
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
				$model->create_user = session('admin')->user;
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
					$orderStatusLog->create_user = session('admin')->user;
					$orderStatusLog->create_time = Common::getDateTime();
					$orderStatusLog->update_user = session('admin')->user;
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
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/orderIn/index')]);
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
		return view('admin.orderIn.create', ['model'=>$model]);
	}
	/**
	 * Show the form for creating a new resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$model = OrderIn::findOrNew($id);
		if(isset($_POST['page']))
		{
			$page = $_POST['page'];
			$validator = Validator::make($page,
				[
					//'id' => 'required|unique:tale_name',
				]
			);
			foreach ($page as $key=>$value)
			{
				$model->$key = $value;
			}
			if ($validator->passes())
			{
				$model->update_user = session('admin')->user;
				$model->update_time = Common::getDateTime();
				if ($model->save()) {
					$sysLog = new SysLog();
					$sysLog->log_type = SysKey::$sysLogUpdateValue;
					$sysLog->content = '用户信息';
					$sysLog->esave();
					return view('admin.public.msgOk', ['msg'=>'保存成功','url'=>url('admin/orderIn/index')]);
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
		return view('admin.orderIn.create', ['model'=>$model]);
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$ids = explode(',', $id);
		foreach ($ids as $id)
		{
			$model = OrderIn::findOrNew($id);
			OrderIn::destroy($id);
		}
		return redirect('admin/orderIn/index');
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function ajaxDestroy($id)
	{
		$rs = ['code'=>'000','msg'=>'删除成功'];
		$ids = explode(',', $id);
		foreach ($ids as $id)
		{
			$model = OrderIn::findOrNew($id);
			OrderIn::destroy($id);
		}
		echo json_encode($rs);
	}
	/**
	 * 全部列表
	 * @return \Illuminate\View\View
	 */
	public function inWhUnit(Request $request)
	{
		
		$model = new WhUnit();
		$orderId = $request->get('orderId');
		$order = OrderIn::findOrNew($orderId);
		if($order->status_over!=SysKey::$orderStatusStatusOkValue)
		{
			return view('admin.public.msgNo', ['msg'=>'该订单审核 ['.SysKey::getOrderStatusStatusByValue($order->status_over).']','url'=>url('admin/orderIn/index')]);
		}
		$items = WhItems::findOrNew($order->wh_items_id);
		if($order->in_quantity >=$order->wh_items_quantity)
		{
			return view('admin.public.msgNo', ['msg'=>$items->title.'&nbsp;数量['.$order->wh_items_quantity.']&nbsp;已全部入库','url'=>url('admin/orderIn/index')]);
		}
		
		$condtion = ' ((wh_items_id = '.$order->wh_items_id.' and wh_items_num<volume) or wh_items_id is null or wh_items_id=0) ';
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
			$data = WhUnit::whereRaw($condtion)->where(['status'=>SysKey::$statusOkValue])->orderBy($request->get('field','id'),$request->get('order','desc'))->paginate($request->get('limit'));
			foreach ($data as $boj) {
				foreach ($boj->getAttributes() as $k=>$v) {
					if($k!='length')
					{
						$_tmp[$k] = $v;
						if($k=='status')
						{
							$_tmp['status_text'] = SysKey::getStatusByValue($v);
						}
						if($k=='warehouse_id')
						{
							$_tmp['warehouse_text'] = Warehouse::findOrNew($v)->title;
						}
						if($k=='wh_area_id')
						{
							$_tmp['wh_area_text'] = WhArea::findOrNew($v)->title;
						}
						if($k=='wh_shelf_id')
						{
							$_tmp['wh_shelf_text'] = WhShelf::findOrNew($v)->title;
						}
						if($k=='wh_items_id')
						{
							$_tmp['wh_items_text'] = WhItems::findOrNew($v)->title;
						}
					}
				}
				$_data[] = $_tmp;
			}
			echo json_encode(['data'=>$_data,'count'=>$data->total(),'code'=>0,'msg'=>'']);
			return;
		}
		return view('admin.orderIn.inWhUnit', ['model'=>$model,'orderId'=>$orderId,'items'=>$items,'order'=>$order]);
	}
	
	public function setInUnit(Request $request)
	{
		$orderId = $request->get('orderId');
		$unitId = $request->get('unitId');
		$num = $request->get('num');
		$order = OrderIn::findOrNew($orderId);
 		
		$unit = WhUnit::findOrNew($unitId);
		$ItemsNum = $order->wh_items_quantity-$order->in_quantity;
		$items = WhItems::findOrNew($order->wh_items_id);
		if($order->in_status == SysKey::$yesValue)
		{
			return view('admin.public.msgNo', ['msg'=>'已全部入库'.$unit->volume,'url'=>'###']);
		}
		
		if($num)
		{
			if($num<=$unit->volume-$unit->wh_items_num)
			{
				$unit->wh_items_id = $order->wh_items_id;
				$unit->wh_items_num += $num;
				if($unit->save())
				{
					$order->in_quantity +=$num;
					if($order->in_quantity==$order->wh_items_quantity)
					{
						$order->in_status = SysKey::$yesValue;
					}
					$order->save();
					return view('admin.public.msgOkP', ['msg'=>'入库成功'.$num,'url'=>url('admin/orderIn/inWhUnit').'?orderId='.$orderId]);
				}
			}else{
				return view('admin.public.msgNo', ['msg'=>'入库数量不能大于'.$unit->volume-$unit->wh_items_num,'url'=>'###']);
			}
		}
		if($ItemsNum>$unit->volume)
		{
			$num = $unit->volume;
		}else{
			$num = $ItemsNum;
		}
		
		return view('admin.orderIn.setInUnit', ['order'=>$order,'unit'=>$unit,'num'=>$num,'items'=>$items]);
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function status(Request $request,$id)
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
			$model->status_user = session('admin')->user;
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
				$model->status_user = session('admin')->user;
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
				return view('admin.public.msgOk', ['msg'=>'审核成功','url'=>url('admin/orderIn/status',['id'=>$id])]);
			}
		}

		$nextStatus = OrderStatus::getNextById($model->status);
		$model->status_data = json_decode($model->status_data,true);
		
		$userGroup = SysGroupUser::where('user',session('admin')->user)->pluck('group_id');
		$myStatus = SysGroupOrderStatus::whereIn('group_id',$userGroup)->pluck('order_status_id')->toArray();
		
		return view('admin.orderIn.status', ['model'=>$model,'nextStatus'=>$nextStatus,'myStatus'=>$myStatus]);
	}
}
