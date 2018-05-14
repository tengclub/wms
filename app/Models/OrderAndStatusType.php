<?php
namespace App\Models;

class OrderAndStatusType extends SysModel
{
	protected $table = 'order_and_status_type';
	public static function getLabels()
	{
		return [
			'id'=>'表主键',
			'order_table'=>'订单',
			'order_type'=>'订单类型',
			'order_status_type_id'=>'状态分类',
			'create_user'=>'创建人',
			'create_time'=>'创建时间',
			'update_user'=>'更新用户',
			'update_time'=>'更新时间',
		];
	}
}
