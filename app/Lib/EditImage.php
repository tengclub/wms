<?php
namespace App\Lib;
class EditImage
{
	
	function getExtend($imgPath)
	{
		$rs=substr(strripos($imgPath,'.'));
		return $rs;
	}
	/**
	 * 剪切图片
	 * @param string $sourcePath 源文件地址
	 * @param int $targetWidth　目标文件宽
	 * @param int $targetHeight　目标文件高
	 * @param bool $isCreate　是否创建文件
	 * @param string $targetPath　创建目标文件地址
	 * @return boolean
	 */
	public static  function  imageCropper($sourcePath, $targetWidth, $targetHeight,$isCreate = true,$targetPath = null)
	{
		$source_info   = getimagesize($sourcePath);
		$source_width  = $source_info[0];
		$source_height = $source_info[1];
		$source_mime   = $source_info['mime'];
		$source_ratio  = $source_height / $source_width;
		$target_ratio  = $targetHeight / $targetWidth;
		$rs = true;
		// 源图过高
		if ($source_ratio > $target_ratio)
		{
			$cropped_width  = $source_width;
			$cropped_height = $source_width * $target_ratio;
			$source_x = 0;
			$source_y = ($source_height - $cropped_height) / 2;
		}
		// 源图过宽
		elseif ($source_ratio < $target_ratio)
		{
			$cropped_width  = $source_height / $target_ratio;
			$cropped_height = $source_height;
			$source_x = ($source_width - $cropped_width) / 2;
			$source_y = 0;
		}
		// 源图适中
		else
		{
			$cropped_width  = $source_width;
			$cropped_height = $source_height;
			$source_x = 0;
			$source_y = 0;
		}
	
		switch ($source_mime)
		{
			case 'image/gif':
				$source_image = imagecreatefromgif($sourcePath);
				break;
	
			case 'image/jpeg':
				$source_image = imagecreatefromjpeg($sourcePath);
				break;
	
			case 'image/png':
				$source_image = imagecreatefrompng($sourcePath);
				break;
	
			default:
				return false;
				break;
		}
	
		$target_image  = imagecreatetruecolor($targetWidth, $targetHeight);
		$cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);
	
		// 裁剪
		imagecopy($cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height);
		// 缩放
		imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $targetWidth, $targetHeight, $cropped_width, $cropped_height);
	
		header('Content-Type: image/jpeg');
		if($isCreate)
		{
			if($targetPath)
			{
				$rs = imagejpeg($target_image,$targetPath);
			}else {
				$rs = imagejpeg($target_image,$sourcePath);
			}
		}else {
			$rs = imagejpeg($target_image);
		}
		imagedestroy($source_image);
		imagedestroy($target_image);
		imagedestroy($cropped_image);
		return $rs;
	}
}
?>