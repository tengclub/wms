<?php
namespace App\Models;

class RegionCity extends SysModel
{
	protected $table = 'region_city';
	public static function getLabels()
	{
		return [
			'id'=>'',
			'city_id'=>'',
			'city'=>'',
			'province_id'=>'',
		];
	}
	public static function getListByProvinceId($province_id = null,$select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		if($province_id)
		{
			$data = self::where('province_id',$province_id)->get();
		}else{
			$data = self::all();
		}
		foreach ($data as $obj)
		{
			$rs[$obj->city_id] = $obj->city;
		}
		return $rs;
	}
}
