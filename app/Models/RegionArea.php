<?php
namespace App\Models;

class RegionArea extends SysModel
{
	protected $table = 'region_area';
	public static function getLabels()
	{
		return [
			'id'=>'',
			'area_id'=>'',
			'area'=>'',
			'city_id'=>'',
		];
	}
	public static function getListByCityId($city_id = null,$select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		if($city_id)
		{
			$data = self::where('city_id',$city_id)->get();
		}else{
			$data = self::all();
		}
		foreach ($data as $obj)
		{
			$rs[$obj->area_id] = $obj->area;
		}
		return $rs;
	}
}
