<?php
namespace App\Models;

class WhUnit extends SysModel
{
	protected $table = 'wh_unit';
	public static function getLabels()
	{
		return [
			'id'=>'表主键',
			'code'=>'编码',
			'title'=>'名称',
			'status'=>'状态',
			'volume'=>'容积',
			'type'=>'分类',
			'length'=>'长（mm）',
			'width'=>'宽（mm）',
			'height'=>'高（mm）',
			'wh_items_id'=>'物品',
			'wh_items_num'=>'物品数量',
			'lock_num'=>'锁定数量',
			'create_time'=>'创建时间',
			'create_user'=>'创建人',
			'update_time'=>'更新时间',
			'update_user'=>'更新人',
			'order_by_out'=>'出库顺序',
			'warehouse_id'=>'仓库',
			'warehouse_code'=>'仓库编码',
			'wh_area_id'=>'区域',
			'wh_area_code'=>'域编码',
			'wh_shelf_id'=>'货架',
			'wh_shelf_code'=>'货架编码',
		];
	}
}
