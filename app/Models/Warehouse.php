<?php
namespace App\Models;
use App\Lib\SysKey;

class Warehouse extends SysModel
{
	protected $table = 'warehouse';
	public static function getLabels()
	{
		return [
			'id'=>'表主键',
			'code'=>'编号',
			'title'=>'名称',
			'contacts'=>'联系人',
			'tel'=>'电话',
			'status'=>'状态',
			'region_province_province_id'=>'省',
			'region_city_city_id'=>'市',
			'region_area_area_id'=>'区县',
			'address'=>'地址',
			'lon'=>'经度',
			'lat'=>'纬度',
			'start_time'=>'开放开始',
			'end_time'=>'开放结束',
			'create_time'=>'创建时间',
			'create_user'=>'创建人',
			'update_time'=>'更新时间',
			'update_user'=>'更新人',
			'remark'=>'备注',
		];
	}
	public static function getIdListByAll($select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		$data = self::where(['status'=>SysKey::$statusOkValue])->get();
		foreach ($data as $obj)
		{
			$rs[$obj->id] = $obj->title;
		}
		return $rs;
	}
	public static function getCodeListByAll($select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		$data = self::where(['status'=>SysKey::$statusOkValue])->get();
		foreach ($data as $obj)
		{
			$rs[$obj->code] = $obj->title;
		}
		return $rs;
	}
}
