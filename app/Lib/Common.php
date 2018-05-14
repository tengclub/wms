<?php
namespace App\Lib;
use  Illuminate\Support\Facades\DB;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
class Common
{

	/**
	 * 获取唯一ID
	 * Enter description here ...
	 */
	public static function  getId($isDecimal = true)
	{
		list($usec, $sec) = explode(" ", microtime());
		//新时间截定义,
		$endtime = 1356019200;//2012-12-12时间戳
		$curtime = time();//当前时间戳
		$newtime = $curtime - $endtime;//新时间戳
		$usec = $usec*1000000;
		$all = $newtime.$usec;
		if($isDecimal==false)
		{
			$all = base_convert($all,10,36);//把10进制转为36进制的唯一ID
		}
		return $all;
	}

	/**
	 * 获取格式化日期
	 * Enter description here ...
	 * @param unknown_type $t
	 */
	public static function  getDate($t=null)
	{
		date_default_timezone_set('PRC');
		if(!isset($t))
		{
			$t=time();
		}
		$rs=date('Y-m-d', $t);
		return $rs;
	}
	public static function  getDateTime($t=null)
	{
		date_default_timezone_set('PRC'); 
		if(!isset($t))
		{
			$t=time();
		}
		$rs=date('Y-m-d H:i:s', $t);
		return $rs;
	}

	public static function  formatTimeStamp2DateTime($t=null,$formStr='Y-m-d H:i:s')
	{
		if(!isset($t))
		{
			$t=time();
		}
		$rs=date($formStr, $t);
		return $rs;
	}
	public static function  formatTimeStamp2Date($t=null,$formStr='Y-m-d')
	{
		if(!isset($t))
		{
			$t=time();
		}
		$rs=date($formStr, $t);
		return $rs;
	}
	/**
	 * 按给定格式将时间字符串转换为字符串
	 *@param string $format
	 *@param string $strTime
	 * @return string
	 */
	static function formatStrTime2String($strTime, $format='Y-m-d H:i:s') {
		$datetime = new \DateTime($strTime);
		$rs = $datetime->format($format);
		return $rs;
	}

	/*
	* 中文截取，支持gb2312,gbk,utf-8,big5
	*
	* @param string $str 要截取的字串

	* @param int $start 截取起始位置

	* @param int $length 截取长度

	* @param string $charset utf-8|gb2312|gbk|big5 编码

	* @param $suffix 是否加尾缀

	*/

	public static function csubstr($str, $start=0, $length, $charset="utf-8", $suffix=false)

	{

		if(function_exists("mb_substr"))

		{

			if(mb_strlen($str, $charset) <= $length) return $str;

			$slice = mb_substr($str, $start, $length, $charset);

		}

		else

		{

			$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";

			$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";

			$re['gbk']          = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";

			$re['big5']          = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";

			preg_match_all($re[$charset], $str, $match);

			if(count($match[0]) <= $length) return $str;

			$slice = join("",array_slice($match[0], $start, $length));

		}

		if($suffix) return $slice."…";

		return $slice;

	}
	
	//将秒转为 天 时 分 秒
	public static function formatSecondToDaysHousMinSec($second)
	{
		$d = floor($second/(3600*24));
		if($d)
		{
			$second -= $d*3600*24;
			$string .= $d."天";
		}
		$h = floor($second/(3600));
		if($h)
		{
			$second -= $h*3600;
			$string .= $h."时";
		}
		$s = floor($second/(60));
		if($s)
		{
			$second -= $s*60;
			$string .= $s."分";
		}
		$string .= "{$t12}秒";
		return  $string;
	
	}
	
	
	public static function getDaysHousMinSec($timeMax,$timeMin)
	{
		$time1 = $timeMax;//第一个时间
		$time2 = $timeMin;//第二个时间
		$t1 = strtotime($time1);
		$t2 = strtotime($time2);
		$t12 = abs($t1-$t2);
		$start = 0;
		$string = "";
		$y = floor($t12/(3600*24*360));
		if($start || $y )
		{
		$start = 1;
		$t12 -= $y*3600*24*360;
		$string .= $y."年";
		}
		$m = floor($t12/(3600*24*31));
		if($start || $m)
		{
		$start = 1;
		$t12 -= $m*3600*24*31;
		$string .= $m."月";
		}
		$d = floor($t12/(3600*24));
		if($start || $d)
		{
		$start = 1;
		$t12 -= $d*3600*24;
		$string .= $d."天";
		}
		$h = floor($t12/(3600));
		if($start || $h)
		{
		$start = 1;
		$t12 -= $h*3600;
		$string .= $h."时";
		}
		$s = floor($t12/(60));
		if($start || $s)
		{
		$start = 1;
		$t12 -= $s*60;
		$string .= $s."分";
		}
		$string .= "{$t12}秒";
		return $string;
	}
	
	public static function setLog($content,$type = null)
	{
		$islog = true;
		if(isset(config('other')['is_log_file']))
		{
			$islog = config('other')['is_log_file'];
		}
		if($islog)
		{
			$path = app_path ('Data/log');
			if ($type)
			{
				$path = app_path ('Data/log/'.$type);
			}
			if(!is_dir($path))
			{
				mkdir($path,0777,true);
			}
			$path .='/'.date('Ymd').'.log';
			
// 			$tmp = '---------------'..' start '.Common::getDateTime().'--------------'."\r\n";
			$tmp ='['.$type.' '.Common::getDateTime().']'. $content."\r\n";
// 			$tmp .= '---------------'.$unstr.' end --------------'."\r\n";
// 			$txtPath= dirname(__FILE__).'/../../log/error'.Common::getDate().'.txt';
			$fp = fopen($path, 'a'); 
			fwrite($fp, $tmp);
			fclose($fp); 		
		}
	}
	/**
	 * 
	 *  生成文件
	 * @param string $content
	 * @param string $path 决对路径 
	 */
	public static function writeFile($content,$path=null)
	{
		$rs=false;
		$path = str_replace('\\', '/', $path);
		if($path)
		{
			$pathDir=substr($path, 0,strripos($path, '/'));
			self::makeDir($pathDir);
			$fp = fopen($path, 'w'); 
			fwrite($fp, $content);
			$rs=fclose($fp); 		
		}else {
			self::setLog('生成文件错误','writeFile');
		}
		return $rs;
	}
	/**
	 * 创建文件夹
	 * Enter description here ...
	 * @param unknown_type $dir
	 */
	public  static function makeDir($dir){
		if(!is_dir($dir)){
			mkdir($dir,0777,true);
		}
	}
	/**
	 * url 转换 & url重写时
	 * Enter description here ...
	 * @param unknown_type $url
	 */
	public  static function getUrlAndParameter($url){
		$rs=trim($url);
		if(Yii::app()->components['urlManager']->urlFormat=='path')
		{
			if((!strpos($url,'?'))&&strpos($url,'&'))
			{
				$start=substr($url,0, strpos($url,'&'));
				$end=substr($url,strpos($url,'&')+1);
				$rs=$start.'?'.$end;
			}
		}
		return $rs;
	}
	/**
	 *
	 * @param date $date 2001-01-01
	 * @return array
	 */
	public  static function getSubDateByDate($date,$day=1){
		$s = strtotime($date);
		$d= date('Y-m-d', strtotime('-'.$day.' days', $s));
		return $d;
	}
	/**
	 *
	 * @param date $date 2001-01-01
	 * @return array
	 */
	public  static function getAddDateByDate($date,$day=1){
		$s = strtotime($date);
		$d= date('Y-m-d', strtotime('+'.$day.' days', $s));
		return $d;
	}
	/**
	 *
	 * @param date $date 2001-01-01
	 * @return array
	 */
	public  static function getDayStartAndEndByDate($date,$isNow=false){
		$s = strtotime($date);
		$start = date("Y-m-d", strtotime("-1 days", $s));
		if(strtotime($start)<strtotime(Config::topStartDate)&&$isNow=false)
		{
			$start = Config::topStartDate;
		}
		return array('start'=>$start,'end'=>$date);
	}
	/**
	 * 
	 * @param date $date 2001-01-01
	 * @return array
	 */
	public  static function getWeekStartAndEndByDate($date,$isNow=false){
		$s = strtotime($date);
		$w = date('w', strtotime("-1 days",$s)); // 得到指定日期是星期几+1是因为系统以周日为开始
		$add1 = 0 - $w;  // 周日，和指定日期相差的天数
		$add2 = 6 - $w;  // 周六，和指定日期相差的天数
		$s1 = strtotime("$add1 days", $s);
		$s2 = strtotime("$add2 days", $s);
		$start = date("Y-m-d", $s1);
		$end = date("Y-m-d", $s2);
		if(strtotime($start)<strtotime(Config::topStartDate)&&$isNow=false)
		{
			$start = Config::topStartDate;
		}
		return array('start'=>$start,'end'=>$end);
	}
	/**
	 *
	 * @param date $date 2001-01-01
	 * @return array
	 */
	public  static function getWeekStartAndEndDateByDate($date,$isNow=false){
		$s = strtotime($date);
		$w = date('w', strtotime("-1 days",$s)); // 得到指定日期是星期几+1是因为系统以周日为开始
		$add1 = 0 - $w;  // 周日，和指定日期相差的天数
		$add2 = 6 - $w;  // 周六，和指定日期相差的天数
		$s1 = strtotime("$add1 days", $s);
		$s2 = strtotime("$add2 days", $s);
		$start = date("Y-m-d", $s1);
// 		$end = date("Y-m-d", $s2);
		$end = $date;
		if(strtotime($start)<strtotime(Config::topStartDate)&&$isNow=false)
		{
			$start = Config::topStartDate;
		}
		return array('start'=>$start,'end'=>$end);
	}
	/**
	 *
	 * @param num $w 28
	 * @return array
	 */
	public  static function getWeekStartAndEndByWeek($w,$isNow=false){
		  //获取当前年份
	    $year = date('Y');
	    $firstWeekDay = date('w',strtotime($year.'-01-01'));
	    var_dump($firstWeekDay);
	    if($firstWeekDay === 0)
	        $firstWeekDay = 7;
	    //第二周的周一 = 1号 + 8-1号所属的周几
	    //这个地方8天比较难理解,可以好好思考
	    $secondMonday = 9-$firstWeekDay;
	    $secondMondayDate = $year.'-01-0'.$secondMonday;
	
	    //当前周 W 是从周一开始的
	    //这里的3周和之前的8天很类似 关于日期的计算果然很麻烦阿 哈哈
	    $starDays = ($w - 2)*7;
	    $endDays = ($w - 1)*7-1;
	
	    //上周的星期一
	    $start = date('Y-m-d',strtotime($secondMondayDate." + $starDays days"));
	    $end = date('Y-m-d',strtotime($secondMondayDate." + $endDays days"));
		if(strtotime($start)<strtotime(Config::topStartDate)&&$isNow=false)
		{
			$start = Config::topStartDate;
		}
	   return array('start'=>$start,'end'=>$end);
	}
	
	/**
	 * 
	 * @param date $date 2015-01-01
	 * @return array
	 */
	public  static	function getMonthStartAndEndByDate($date,$isNow=false){
		$start = date('Y-m-01',strtotime($date));
		$end = date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month -1 day'));
		if(strtotime($start)<strtotime(Config::topStartDate)&&$isNow=false)
		{
			$start = Config::topStartDate;
		}
		return array('start'=>$start,'end'=>$end);
	}
	/**
	 *
	 * @param date $date 2015-01-01
	 * @return array
	 */
	public  static	function getMonthStartAndEndDateByDate($date,$isNow=false){
		$start = date('Y-m-01',strtotime($date));
// 		$end = date('Y-m-d', strtotime(date('Y-m-01', strtotime($date)) . ' +1 month -1 day'));
		$end = $date;
		if(strtotime($start)<strtotime(Config::topStartDate)&&$isNow=false)
		{
			$start = Config::topStartDate;
		}
		return array('start'=>$start,'end'=>$end);
	}
	/**
	 * 
	 * @param num $m 01
	 * @return array
	 */
	public  static	function getMonthStartAndEndByMonth($m,$isNow=false) {
		
		//获取当前的时间
		$year = date('Y');
		$firstdate = date('Y-m-01',strtotime($year.'-01-01'));
		$start=intval(date("m",strtotime($firstdate)));
		for($i=0;$i<$m;$i++){
			if(($start+$i)>12){
				$resultDay = date("Y-".(($start+$i)-12)."-01",strtotime("+1 year"));
			}else{
				$resultDay = date("Y-".($start+$i)."-01",strtotime($firstdate));
			}
			$day = date("t",strtotime($resultDay));
			$resultDay = date("Y-m-d",(strtotime($resultDay)+($day-1)*24*3600));
		}
		$start = date('Y-m-01',strtotime($resultDay));
		$end = $resultDay;
		if(strtotime($start)<strtotime(Config::topStartDate)&&$isNow=false)
		{
			$start = Config::topStartDate;
		}
		return array('start'=>$start,'end'=>$end);
	}
	/**
	 * 替换字符串中的关键字
	 * @param string $xStr
	 */
	public static function replaceSemiangleStr($str){

		$str = str_replace('\'', '‘', $str);
		$str = str_replace('"', '“', $str);
		$str = str_replace(',', '，', $str);
		$str = str_replace('(', '）', $str);
		$str = str_replace(')', '（', $str);
		return $str;
	}
	/**
	 * 获得随机的字符串
	 *
	 * @param integer $iLength 生成的字符串的长度
	 * @param integer $iType 类型 1: 全小写 2: 全大写 3: 数字+小写 4: 数字+大写 5: 小写+大写 6: 数字+小写+大写
	 * @return string
	 */
	public static function getRandomString($iLength, $iType = 0)
	{
		$s_random_string = '';
		switch ($iType)
		{
			case 1:
				$s_characters = 'abcdefghijklmnopqrstuvwxyz';
				break;
			case 2:
				$s_characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 3:
				$s_characters = '0123456789abcdefghijklmnopqrstuvwxyz';
				break;
			case 4:
				$s_characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 5:
				$s_characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			case 6:
				$s_characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			default:
				$s_characters = '0123456789';
				break;
		}
		$i_length_max = strlen($s_characters) - 1;
		for($i = 0; $i < $iLength; $i++)
		{
		$s_random_string .= $s_characters[mt_rand(0, $i_length_max)];
		}
		return $s_random_string;
	}
	
	/**
	* 获得随机的指定范围的数字
	 *
	 * @param integer $iMax 最大数字
	 * @param integer $iMin 最小数字
	 * @return integer
	 */
	 public static function getRandomNumber($iMax, $iMin = 0)
	 {
	 	return mt_rand($iMin, $iMax);
	 }
	 
	 /**
	  * 获取文件的上传目录
	  * @param String $uploadCat:文件所属的模块目录，如product_img
	  * @return string:返回值格式为"根目录/年月/模块目录"
	  */
	 public static function getUploadPath($uploadCat)
	 {
	 	return config("other")["upload_root_path"]."/".date('Ym')."/".$uploadCat; //获取配置的文件上传路径
	 }
	 
	 /**
	  * 上传文件，并返回文件的路径及文件名
	  * @param file $file
	  * @param String $uploadCat:文件所属的模块名，如product_img
	  * @return string:返回值格式为"根目录/年月/模块目录/文件名.后缀"
	  */	 
	 public static function uploadFile($file, $uploadCat){
	 	$newFileName = "";
	 	$upload_directory = config("other")["upload_root_path"]."/".date('Ym')."/".$uploadCat; //获取配置的文件上传目录
	 	self::makeDir($upload_directory);
	 	$clientName = $file->getClientOriginalName();	//文件名
	 	 
	 	$extension = $file->getClientOriginalExtension(); //上传文件的后缀.
	 
	 	$newFileName = time().".".$extension;//新的文件名
	 	 
	 	$path = $file -> move($upload_directory,$newFileName);
	 	return $upload_directory."/".$newFileName;
	 }
	 
	 /**
	  * 获取商品分类级别
	  */
	 public static function getProductTypeLevel(){
	 	return config("epconfig")["product_type_level"]; //获取商品分类级别
	 }
	 
	 /**
	  * 是否显示商品分类上级，当只有一级时，不显示上级分类
	  */
	 public static function isDisplayParentType(){
	 	$levelValue = self::getProductTypeLevel();
	 	if($levelValue<=1)
	 	{
	 		return false;
	 	}else{
	 		return true;
	 	}
	 }
	 
	 /**
	  * 根据商品分类级别组成级别条件
	  * @return string
	  */
	 
	 public static function getProdTypeLevelCond(){
	 	$levelValue = self::getProductTypeLevel();
	 	$conditon = '';
	 	
	 	if($levelValue==1)
	 	{
	 		$conditon .= ' level_id=2';
	 	}else if($levelValue==2){
	 		$conditon .= ' (level_id=1 or level_id=2)';
	 	}
	 	
	 	return $conditon;
	 }
	
	 /**
	  * 创建cps链接添加用户code
	  * @param Request $request
	  * @param string $userCode
	  * @return multitype:string
	  */
	 public static function addUcodeUrl(Request $request,$userCode)
	 {
	 	$wechat_share_level = config("epconfig")["wechat_share_level"]; //获取分享级别
	 	for ($i=1; $i<=$wechat_share_level;$i++)
	 	{
		 	if(!$request->get('ucode'.$i))
		 	{
		 		break;
		 	}
		 }
		 $url = $request->getRequestUri();
		 if(strripos($url,'?')===false)
		 {
		 	$url .= '?ucode'.$i.'='.$userCode;
		 }else {
		 	$url .= '&ucode'.$i.'='.$userCode;
		 }
		
	 	 return $url;
	}
	/**
	 * 解析url分享用户code
	 * @param Request $request
	 * @return array
	 */
	public static function getUcodeByUrl(Request $request)
	{
		$ucodeData = null;
		$wechat_share_level = config("epconfig")["wechat_share_level"]; //获取分享级别
		for ($i=1; $i<=$wechat_share_level;$i++)
		{
			if($request->get('ucode'.$i))
			{
				$ucodeData[$i]= $request->get('ucode'.$i);
			}else {
				break;
			}
		}
		return $ucodeData;
	}
	
	/**
	 * 保存分享用户到cookie
	 * @param Request $request
	 * @return array
	 */
	public static function saveWechatShare(Request $request, $productId)
	{
		//获取分享链接人员
		$ucode = self::getUcodeByUrl($request);
		$ucodes = '';
		if(isset($ucode) &&!empty($ucode))
		{
			$ucodes = implode(',',$ucode);
			$wechatShareKey = $productId;
			setcookie('wechatShareCook['.$wechatShareKey.']', $ucodes, time()+43200, '/');
		}
	}
	public static function writeLog($type = null)
	{
		$path = app_path ('Data/log');
		if ($type)
		{
			$path = app_path ('Data/log/'.$type);
		}
		
		if(is_dir($path))
		{
			mkdir($path,0777,true);
		}
		$path .='/'.date('Ymd').'.log';
		if(isset($response['shop_id']))
				{
					$myfile = fopen(app_path ( "Data/dd/access_token_".$response['shop_id'].".json" ), "w") or die("Unable to open file!");
				}else {
					$myfile = fopen(app_path ( "Data/dd/access_token.json" ), "w") or die("Unable to open file!");
				}
				fwrite($myfile, json_encode($response));
	    		fclose($myfile);
	}
	public static function getDir($pathName)
	{
		//将结果保存在result变量中
		$result = array();
		$temp = array();
		//判断传入的变量是否是目录
		if(!is_dir($pathName) || !is_readable($pathName)) {
			return null;
		}
		//取出目录中的文件和子目录名,使用scandir函数
		$allFiles = scandir($pathName);
		
		//遍历他们
		foreach($allFiles as $fileName) {
			//判断是否是.和..因为这两个东西神马也不是。。。
			if(in_array($fileName, array('.', '..'))) {
				continue;
			}
			//路径加文件名
			$fullName = $pathName.'/'.$fileName;
			//如果是目录的话就继续遍历这个目录
			if(is_dir($fullName)) {
				//将这个目录中的文件信息存入到数组中
				$result[$fullName] = self::getDir($fullName);
			}else {
				//如果是文件就先存入临时变量
				$temp[] = $fullName;
			}
		}
		//取出文件
		if($temp) {
			foreach($temp as $f) {
				$result[] = $f;
			}
		}
		return $result;
	}
	public static function getNewsTempletFile($prefix=null)
	{
		$pathName = resource_path('views/web/templet');
		//将结果保存在result变量中
		$result = [''=>'无'];
		$temp = array();
		//判断传入的变量是否是目录
		if(!is_dir($pathName) || !is_readable($pathName)) {
			return null;
		}
		//取出目录中的文件和子目录名,使用scandir函数
		$allFiles = scandir($pathName);
	
		//遍历他们
		foreach($allFiles as $fileName) {
			//判断是否是.和..因为这两个东西神马也不是。。。
			if(in_array($fileName, array('.', '..'))) {
				continue;
			}
			//路径加文件名
			$fullName = $pathName.'/'.$fileName;
			//如果是目录的话就继续遍历这个目录
			if(is_dir($fullName)) {
				//将这个目录中的文件信息存入到数组中
				$result[$fullName] = self::getDir($fullName);
			}else {
				//如果是文件就先存入临时变量
				$temp[] = $fullName;
			}
		}
		//取出文件
		if($temp) {
			foreach($temp as $f) {
				$_f = strrchr($f,'/');
				$_f = substr($_f, 1,-10);
				if($_f)
				{
					if($prefix)
					{
						if(strpos($_f,$prefix) !== false){
							$result[$_f] = $_f;
						}
					}else{
						$result[$_f] = $_f;
					}
				}
			}
		}
		return $result;
	}
	static function strLength($int, $length = 7) {
		for ($i = strlen($int); $i<$length ; $i++)
		{
			$int = '0'.$int;
		}
		return $int;
	}

}
?>