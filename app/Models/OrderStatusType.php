<?php
namespace App\Models;

class OrderStatusType extends SysModel
{
	protected $table = 'order_status_type';
	public static function getLabels()
	{
		return [
			'id'=>'表主键',
			'title'=>'名称',
			'code'=>'编码',
			'status'=>'状态',
			'create_user'=>'创建人',
			'create_time'=>'创建时间',
			'update_user'=>'更新用户',
			'update_time'=>'更新时间',
		];
	}
	public static function getList($select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		$data = self::all();
		foreach ($data as $obj)
		{
			$rs[$obj->id] = $obj->title;
		}
		return $rs;
	}
}
