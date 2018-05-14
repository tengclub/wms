<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\RegionArea;
use App\Models\RegionCity;
use App\Models\RegionProvince;
use App\Models\WhArea;
use App\Models\WhShelf;

use Illuminate\Support\Facades\DB;

class UtilController extends Controller
{
	
	/**
	 * 市selec option html
	 * @param int $pid
	 */
	public function ajaxCitySelect($pid)
	{
		$rs = '';
		$data = RegionCity::getListByProvinceId($pid);
		if($data)
		{
			foreach ($data as $key=>$value)
			{
				$rs .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}
		echo $rs;
	}
	/**
	 * 区selec option html
	 * @param int $cid
	 */
	public function ajaxAreaSelect($cid)
	{
		$rs = '';
		$data = RegionArea::getListByCityId($cid);
		if($data)
		{
			foreach ($data as $key=>$value)
			{
				$rs .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}
		echo $rs;
	}
	/**
	 * 仓库区域selec option html
	 * @param int $pid
	 */
	public function ajaxWhAreaSelect($whId)
	{
		$rs = '';
		$data = WhArea::getIdList($whId);
		if($data)
		{
			foreach ($data as $key=>$value)
			{
				$rs .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}
		echo $rs;
	}
	/**
	 * 货架selec option html
	 * @param int $cid
	 */
	public function ajaxWhShelfSelect($areaId)
	{
		$rs = '';
		$data = WhShelf::getIdList($areaId);
		if($data)
		{
			foreach ($data as $key=>$value)
			{
				$rs .= '<option value="'.$key.'">'.$value.'</option>';
			}
		}
		echo $rs;
	}

   
}
