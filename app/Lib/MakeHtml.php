<?php
class MakeHtml
{
	/**
	 * 生成html
	 * Enter description here ...
	 */
	public function classHtml($cid=null,$filePath=null,$fileTmeplet=null)
	{
		
		$rs=false;
		
		if(Config::isHtml)
		{
			$model=MainArctype::model()->findByPk($cid);
			$temple = Yii::app()->basePath. "/templet/index.html";
			
			if ($model)
			{
				if($model->templist)
				{
					$temple=Yii::app()->basePath.'/'.$model->templist;
				}
			}
			if($fileTmeplet)
			{
				$temple=$fileTmeplet;
			}
		    $handle = fopen($temple, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
		    //通过filesize获得文件大小，将整个文件一下子读到一个字符串中
		    $contents = fread($handle, filesize ($temple));
		    fclose($handle);  
		    $contents=$this->arcListFind($contents,$cid);
		    $contents=$this->arcTypelistFind($contents,$cid);
		    $contents=str_replace('$[page-rooturl]', Yii::app()->baseUrl, $contents);
		   	   
		    if($model)
		    {
		    	$contents=$this->getPageInfo($contents,array('keywords'=>$model->keywords,'description'=>$model->description,'title'=>$model->typename));
		    }
		
		    if($filePath)
		    {
		    	$rs=Common::writeFile($contents,$filePath);
		    }else {
		    	if($model->typedir=='@')
		    	{
		    		$fileName='index.html';
			    	if($model->defaultname)
		    		{
		    			$fileName=$model->defaultname;
		    		}
		    		$rs=Common::writeFile($contents,Yii::app()->basePath.'/'.$fileName);
		    	}else{
		    		
		    	$rs=Common::writeFile($contents,Yii::app()->basePath.'/../html/'.$this->getClassPath($model));
		    	}
		    }
		}else {
			$rs=true;
		}
	 	return $rs;
	}
	
	/**
	 * 获取文件分类页面地址
	 * Enter description here ...
	 * @param unknown_type $model
	 */
	public  function getClassPath($model)
	{
		$tmpPath='error';
	    $fileName='index.html';
	    if($model)
	    {
	    	if($model->defaultname)
	    	{
	    		$fileName=$model->defaultname;
	    	}
	    	$tmpPath=$model->id;
	    	if($model->typedir)
	    	{
	    		$tmpPath=$model->typedir;
	    	}
	    }
	    return $tmpPath.'/'.$fileName;
	}
	/**
	 * 获取news地址
	 * Enter description here ...
	 * @param unknown_type $model
	 */
	public  function getNewsPath($model)
	{
	 	return $model->senddate.'/'.$model->id.'.html';	
	}
	/**
	 * 生成html
	 * Enter description here ...
	 */
	public function newsHtml($nid)
	{
		$rs=false;
		if(Config::isHtml)
		{
			$model=MainArchives::model()->findByPk($nid);
			$tmodel=MainArctype::model()->findByPk($model->typeid);
			$temple = Yii::app()->basePath. "/templet/news.html";
			if($tmodel->temparticle)
			{
				if(substr($tmodel->temparticle, 0,1)=='/')
				{
					$temple = Yii::app()->basePath.$tmodel->temparticle;
				}else {
					$temple = Yii::app()->basePath.'/'.$tmodel->temparticle;
				}
			}
		    $handle = fopen($temple, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
		    //通过filesize获得文件大小，将整个文件一下子读到一个字符串中
		    $contents = fread($handle, filesize ($temple));
		    fclose($handle);  
		    $contents=$this->arcListFind($contents);
		    $contents=$this->arcTypelistFind($contents,$model->typeid);
		    $contents=$this->archivesHtml($contents,$model);
	    	$contents=str_replace('$[page-rooturl]', Yii::app()->baseUrl, $contents);
		    $contents=$this->getPageInfo($contents,array('keywords'=>$model->keywords,'description'=>$model->description,'title'=>$model->title));
			$rs=   Common::writeFile($contents,Yii::app()->basePath.'/../html/'.$this->getNewsPath($model));
		}else {
			$rs=true;
		}
		return $rs;

	}
	
	/**
	 * 
	 * 解析页面标签 $[page-*]
	 * @param string $txt
	 * @param array $pageInfo 如 ：$pageInfo=array('keywords'=>'关键字')
	 */
	public  function getPageInfo($txt,$pageInfo=array())
	{
		
		foreach ($pageInfo as $key=>$value)
		{
			$txt=str_replace('$[page-'.$key.']', $value, $txt);
		}
		return $txt;
	}

	/**
	 * 查找所{/bstn:arcList}标签
	 * @param unknown_type $txt
	 */
	public  function arcListFind($txt='',$cid=null)
	{
		$labelCount= substr_count($txt, '{/bstn:arcList}');
		for ($i=0;$i<$labelCount;$i++)
		{
			$sstart=stripos($txt, '{bstn:arcList');		
		    $startLen=stripos($txt, '{/bstn:arcList}')-$sstart+15;
		    $topStr=substr($txt, 0,$sstart);
		    $bottomStr=substr($txt, stripos($txt, '{/bstn:arcList}')+15);	    
		    $arcList=substr($txt, $sstart,$startLen);		     
		   	$txt=$topStr.$this->arcListHtml($arcList,$cid).$bottomStr;
		}
		return $txt;
	}
	
	/**
	 * 标签{/bstn:arcList}解析
	 * @param unknown_type $txt
	 */
	private function arcListHtml($txt='',$cid=null)
	{
		$strWhere=' 1=1 ';
		$indexCss='';
		$rsHtml='';
		$txt=str_replace('{/bstn:arcList}', '', $txt);
		$txt=str_replace('bstn:arcList', '', $txt);
		$arrStr=substr($txt, 0,strripos($txt,'}')+1);
		$arrTmp=json_decode($arrStr,true);
	
		if(isset($arrTmp['where']))
		{
			$strWhere.=' '.$arrTmp['where'];
		}
		if($cid)
		{
			if(isset($arrTmp['where']))
			{
				if(!(substr_count($arrTmp['where'],'typeid')||substr_count($arrTmp['where'],'typeid2')))
				{
					$strWhere.=' and (typeid="'.$cid.'" or typeid2="'.$cid.'") ';
				}
			}else {
				$strWhere.=' and (typeid="'.$cid.'" or typeid2="'.$cid.'") ';
			}
		}
		
		$fildStr=substr($txt,strripos($txt,'}')+1);
		$model=MainArchives::model()->findAll($strWhere);
		foreach ($model as $v)
		{
			$rsTmp=$fildStr;
			foreach ($v as $key=>$value)
			{
				if($key=='title'&&isset($arrTmp['tlen']))
				{
					$value= Common::csubstr($value,0, $arrTmp['tlen']) ;
				}
				$rsTmp=str_replace('$['.$key.']', $value, $rsTmp);
			}
			$rsTmp=str_replace('$[path-url]',Yii::app()->baseUrl.'/html/'.$v->senddate.'/'.$v->id.'.html', $rsTmp);
			$rsHtml.=$rsTmp;
			
		}
		return $rsHtml;
	}
	/**
	 * 标签{/bstn:archives}解析
	 * @param unknown_type $nid
	 */
	private function archivesHtml($txt,$model)
	{
		$sstart=stripos($txt, '{bstn:archives');		
	    $startLen=stripos($txt, '{/bstn:archives}')-$sstart+16;
	    $topStr=substr($txt, 0,$sstart);
	    $bottomStr=substr($txt, stripos($txt, '{/bstn:archives}')+16);	    
	    $txt=substr($txt, $sstart,$startLen);		     
		
		$txt=str_replace('{/bstn:archives}', '', $txt);
		$txt=str_replace('bstn:archives', '', $txt);
		$arrStr=substr($txt, 0,strripos($txt,'}')+1);
		$arrTmp=json_decode($arrStr,true);
		$fildStr=substr($txt,strripos($txt,'}')+1);
		$rsTmp=$fildStr;
		foreach ($model as $key=>$value)
		{
			$rsTmp=str_replace('$['.$key.']', $value, $rsTmp);
		}
		$bmodel=MainAddonarticle::model()->findByPk($model->id);
		foreach ($bmodel as $key=>$value)
		{
			$rsTmp=str_replace('$['.$key.']', $value, $rsTmp);
		}
		$txt=$topStr.$rsTmp.$bottomStr;
		return $txt;
	}
	/**
	 * 查找所{/bstn:arcTypelist}标签
	 * @param unknown_type $txt
	 */
	public function arcTypelistFind($txt='',$cid=null)
	{
		$labelCount= substr_count($txt, '{/bstn:arcTypelist}');
		for ($i=0;$i<$labelCount;$i++)
		{
			$sstart=stripos($txt, '{bstn:arcTypelist');		
		    $startLen=stripos($txt, '{/bstn:arcTypelist}')-$sstart+19;
		    $topStr=substr($txt, 0,$sstart);
		    $bottomStr=substr($txt, stripos($txt, '{/bstn:arcTypelist}')+19);	    
		    $bstnStr=substr($txt, $sstart,$startLen);		     

		   	$txt=$topStr.$this->arcTypeListHtml($bstnStr,$cid).$bottomStr;
		}
		return $txt;
	}
	/**
	 * 解析bstn:arcTypelist标签 
	 * Enter description here ...
	 * @param unknown_type $typeid
	 */
	private function arcTypeListHtml($txt='',$typeid)
	{
		$indexId=$typeid;
		$strWhere=' 1=1 ';
		$indexCss='';
		$rsHtml='';
		$txt=str_replace('{/bstn:arcTypelist}', '', $txt);
		$txt=str_replace('bstn:arcTypelist', '', $txt);
		$arrStr=substr($txt, 0,strripos($txt,'}')+1);
		$arrTmp=json_decode($arrStr,true);
	
		if(isset($arrTmp['where']))
		{
			$strWhere.=' '.$arrTmp['where'];
		}
		if(isset($arrTmp['pid']))
		{
			$strWhere.=' reid="'.$arrTmp['pid'].'"';
		}
		if(isset($arrTmp['indexcss']))
		{
			$indexCss=$arrTmp['indexcss'];
		}
		
		if(isset($arrTmp['indexid']))
		{
			$indexId=$arrTmp['indexid'];
		}
		
		$fildStr=substr($txt,strripos($txt,'}')+1);
		$model=MainArctype::model()->findAll($strWhere);
		foreach ($model as $v)
		{
			$rsTmp=$fildStr;
			foreach ($v as $key=>$value)
			{
				$rsTmp=str_replace('$['.$key.']', $value, $rsTmp);
			}
			if($v->id=$indexId)
			{
				if(substr_count($rsTmp,'class="'))
				{
					$rsTmp=str_replace('class="','class="'.$indexCss.' ', $rsTmp);
				}else {
					if(substr_count($rsTmp,'$[class-css]'))
					{
						$rsTmp=str_replace('$[class-css]"',' class="'.$indexCss.'" ', $rsTmp);
					}
				}
			}
			$rsTmp=str_replace('$[class-css]',' ', $rsTmp);			
			$rsTmp=str_replace('$[path-url]',Yii::app()->baseUrl.'/html/'.$this->getClassPath($v), $rsTmp);
			$rsHtml.=$rsTmp;
		}
		return $rsHtml;
	}
}
?>