<?php
namespace App\Models;

class OrderOut extends SysModel
{
	protected $table = 'order_out';
	public static $_tb = 'order_out';
	public static function getLabels()
	{
		return [
			'id'=>'表主键',
			'order_no'=>'订单号',
			'wh_items_id'=>'物品',
			'wh_items_quantity'=>'货物量',
			'status'=>'状态',
			'create_time'=>'创建时间',
			'create_user'=>'创建人',
			'remark'=>'备注',
			'data'=>'返馈信息',
			'status_over'=>'审核完成',
			'out_status'=>'是否已出库',
			'out_quantity'=>'出库数量',
				'in_quantity'=>'入库数量',
				'order_status_type_id'=>'状态分类',
				'order_type'=>'订单分类',
				'status_data'=>'订单状态数据',
				'status_time'=>'审核时间',
				'status_user'=>'审核人'
		];
	}
}
