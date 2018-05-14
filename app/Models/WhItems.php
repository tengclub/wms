<?php
namespace App\Models;

use App\Lib\SysKey;

class WhItems extends SysModel
{
	protected $table = 'wh_items';
	public static function getLabels()
	{
		return [
			'id'=>'表主键',
			'code'=>'编码',
			'title'=>'名称',
			'img1'=>'图片',
			'img2'=>'图片',
			'length'=>'长（mm）',
			'width'=>'宽(mm)',
			'height'=>'高（mm）',
			'border'=>'间隔( 上|下|前|后|左|右)',
			'out_code'=>'外部编码',
			'weight'=>'重量（kg）',
			'status'=>'状态',
		];
	}
	public static function getList($select = false)
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
}
