<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Includes\Common;
use App\Models\Province;
use App\Models\Area;
use App\Models\City;
class System 
{
	private static $plength = 2;
	public static function orderTable()
	{
		$rs = [''=>'请选择'];
		$results = DB::select('show TABLES  LIKE "%order%"');
		foreach ($results as $row)
		{
			foreach ($row as $t)
			{
				if(strpos($t,'_status')===false){
					$tableCn = DB::select('show table status where name="'.$t.'"')[0]->Comment;
					$rs[substr($t,self::$plength)] = $tableCn;
				}
			}
		}
		 return $rs;
	}
	
}
