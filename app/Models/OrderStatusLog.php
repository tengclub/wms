<?php
namespace App\Models;
use App\Lib\Common;


class OrderStatusLog extends SysModel
{
	protected $table = 'order_status_log';
	public static function getLabels()
	{
		return [
			'id'=>'表主键',
			'order_id'=>'订单',
			'order_status_id'=>'状态id',
			'order_status_title'=>'订单状态名称',
			'status_value'=>'状态',
			'object_type'=>'分类(文本，日期，下拉，单选，多选,提示)',
			'object_value'=>'附加项(1是，2|否）',
			'object_lable'=>'附加信息名称',
			'create_user'=>'创建人',
			'create_time'=>'创建时间',
			'update_user'=>'更新用户',
			'update_time'=>'更新时间',
			'remark'=>'备注',
		];
	}
	public static function setLog($orderId,$orderStatus,$objectValue=null)
	{
		$orderStatusLog = new OrderStatusLog();
		$orderStatusLog->id = Common::getId();
		$orderStatusLog->order_id = $orderId;
		$orderStatusLog->order_status_id = $orderStatus->status;
		$orderStatusLog->order_status_title = $orderStatus->title;
		$orderStatusLog->status_value = $orderStatus->status;
		$orderStatusLog->object_value = $objectValue;
		$orderStatusLog->object_type =  $orderStatus->object_type;
		$orderStatusLog->object_lable =  $orderStatus->object_lable;
		$user = '';
		if(session('admin'))
		{
			$user = session('admin')->user;
		}elseif(session('wapUser')){
			$user = session('wapUser')->user;
		}
		$orderStatusLog->create_user = $user;
		$orderStatusLog->create_time = Common::getDateTime();
		$orderStatusLog->update_user = $user;
		$orderStatusLog->update_time = Common::getDateTime();
		return $orderStatusLog->save();
	}
}
