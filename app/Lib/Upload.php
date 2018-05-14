<?php
namespace App\Lib;
use App\Lib\WaterMark;
class Upload 
{
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $upload
	 * @param unknown_type $type
	 * @param unknown_type $act
	 * @param unknown_type $imgurl
	 */
	public static function createFile($upload,$type,$act,$imgurl='',$isWater=false){
		if(!empty($imgurl)&&$act==='update'){
			$deleteFile=Yii::app()->basePath.'/../'.$imgurl;
			if(is_file($deleteFile))
			unlink($deleteFile);
		}
//		$uploadDir=Yii::app()->basePath.'/../uploads/'.date('Y-m',time()).'/'.$type;
		$uploadDir=Yii::app()->basePath.'/../uploads/'.$type;
		self::recursionMkDir($uploadDir);
		$imgname=time().'-'.rand().'.'.$upload->extensionName;
	
		//图片存储路径
//		$imageurl='uploads/'.date('Y-m',time()).'/'.$type.'/'.$imgname;
		$imageurl='uploads/'.$type.'/'.$imgname;
		//存储绝对路径
		$uploadPath=$uploadDir.'/'.$imgname;
		if($upload->saveAs($uploadPath)){
			if($isWater)
			{
				$waterMark=new WaterMark();
				$waterMark->imageWaterMark($uploadPath); 
			}
			return $imageurl;
		}else{
			return null;
		}
	}
	/**
	 * 创建文件夹
	 * Enter description here ...
	 * @param unknown_type $dir
	 */
	public  static function recursionMkDir($dir){
		if(!is_dir($dir)){
			if(!is_dir(dirname($dir))){
				self::recursionMkDir(dirname($dir));
				mkdir($dir,0777,true);
			}else{
				mkdir($dir,0777,true);
			}
		}
	}
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $upload
	 * @param unknown_type $type
	 * @param unknown_type $act
	 * @param unknown_type $imgurl
	 */
	public static function UploadImageAndSmall($upload,$type,$act,$imgurl='',$width=null,$height=null,$isWater=Config::isWaterMark){
		if(!empty($imgurl)&&$act==='update'){
			$deleteFile=Yii::app()->basePath.'/../'.$imgurl;
			if(is_file($deleteFile))
			unlink($deleteFile);
		}
		$uploadDir=Yii::app()->basePath.'/../uploads/'.date('Y-m',time()).'/'.$type;
		self::recursionMkDir($uploadDir);
		$imgname=time().'-'.rand().'.'.$upload->extensionName;
	
		//图片存储路径
		$imageurl='uploads/'.date('Y-m',time()).'/'.$type.'/'.$imgname;
		//存储绝对路径
		$uploadPath=$uploadDir.'/'.$imgname;
		$uploadPathSmall=substr($uploadPath, 0,-4).'-s'.substr($uploadPath,-4);
		if($upload->saveAs($uploadPath)){
			if($width&&$height)
			{
				$editImg=new EditImage();
				$editImg->resizeImage($uploadPath,$width,$height,$uploadPathSmall);
			}
			if($isWater)
			{
				$waterMark=new WaterMark();
				$waterMark->imageWaterMark($uploadPath); 
			}
			return $imageurl;
		}else{
			return null;
		}
	}
	
}
?>