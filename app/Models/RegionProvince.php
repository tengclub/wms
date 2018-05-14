<?php
namespace App\Models;

class RegionProvince extends SysModel
{
	protected $table = 'region_province';
	public static function getLabels()
	{
		return [
			'id'=>'',
			'province_id'=>'',
			'province'=>'',
		];
	}
	public static function getListAll($select = false)
	{
		$rs = null;
		if($select)
		{
			$rs[''] = '请选择';
		}
		$data = self::all();
		foreach ($data as $obj)
		{
			$rs[$obj->province_id] = $obj->province;
		}
		return $rs;
	}
}
