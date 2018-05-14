<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Lib\Common;
class SysLog extends SysModel
{
	
    //
	protected $table = 'sys_log';
	public static  function getLabels()
	{
		return array(
			'id' => 'ID',
			'data_time' => '时间',
			'user' => '用户',
			'log_type' => '操作类型',
			'content' => '操作内容',
		);
	}
	/**
	 * 保存log
	 */
	public function esave()
	{
		$this->id = Common::getId();
		$this->data_time = Common::formatTimeStamp2DateTime();
		if(!$this->user)
		{
			$admin = session('admin');
			$login = session('login');
			if(isset($admin))
			{
				$this->user = session('admin')->user;
			}else if(isset($login)){
				$this->user = session('login')->user;
			}
		}
		$this->save();
		SysLog::where('data_time',"<=", date('Y-m-d', strtotime('-30 days')))->delete();
	}
}
