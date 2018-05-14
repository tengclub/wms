<?php
class MakeHtmlPager
{
	
	public  function classHtmlPager($cid=null)
	{
//		var_dump('123');
//		exit();
		$rs=null;
		if(Config::isHtml)
		{
			$model=MainArctype::model()->findByPk($cid);
			$temple = Yii::app()->basePath. "/templet/index.html";
			
			if ($model)
			{
				if($model->templist)
				{
					$temple=$model->templist;
				}
			}
			
		
		    $handle = fopen($temple, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
		    //通过filesize获得文件大小，将整个文件一下子读到一个字符串中
		    $contents = fread($handle, filesize ($temple));
		    fclose($handle);  
		    
		    $txt=$this->arcListFindPagerInit($contents);
		    if($txt)
		    {
		    	$contents=str_replace('</head>', '<link href="'.Yii::app()->baseUrl.'/css/pager/pager.css" type="text/css" rel="stylesheet" />'."\n\r</head>", $contents);
		    }
		    
			$strWhere=' 1=1 ';
			$indexCss='';
			$rsHtml='';
			$txt=str_replace('{/bstn:arcListPager}', '', $txt);
			$txt=str_replace('bstn:arcListPager', '', $txt);
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
	//					if(isset($arrTmp['indexCss']))
	//					{
	//						$indexCss=$arrTmp['indexCss'];
	//					}
					}
				}else {
					$strWhere.=' and (typeid="'.$cid.'" or typeid2="'.$cid.'") ';
				}
			}
			
			$fildStr=substr($txt,strripos($txt,'}')+1);
			
			$model=MainArchives::model()->findAll($strWhere);
			$totalRecord=count($model);
			$totalPage=ceil($totalRecord/Config::pageSize);
			$pager=array(
				'totalRecord'=>$totalRecord,
				'pageSize'=>Config::pageSize,
				'totalPage'=>$totalPage,
				'pageIndex'=>1,
			);
			
			
			
	//		var_dump($totalPage);
	//		exit();
			
			for ($i=1;$i<=$totalPage;$i++)
			{
				$pager['pageIndex']=$i;
				$rs.=$this->writeClassHtml($cid,$contents,$pager);
			}
		}else {
			$rs='true';
		}
		return $rs;
	}
	
	/**
	 * 生成html
	 * Enter description here ...
	 */
	public function writeClassHtml($cid=null,$contents,$pager)
	{
		$makeHtml=new MakeHtml();
		$model=MainArctype::model()->findByPk($cid);
	    $contents=$makeHtml->arcTypelistFind($contents,$cid);
	    $contents=$makeHtml->getPageInfo($contents,array('keywords'=>$model->keywords,'description'=>$model->description,'title'=>$model->typename));
	    $contents=$makeHtml->arcListFind($contents,$cid);
	    $contents=$this->arcListPagerFind($contents,$cid,$pager);
	 	return    Common::writeFile($contents,Yii::app()->basePath.'/../html/'.$this->getClassPathByPager($model,$pager['pageIndex']));
	}
	
	
	/**
	 * 获取文件分类页面地址
	 * Enter description here ...
	 * @param unknown_type $model
	 */
	public  function getClassPathByPager($model,$n=null)
	{
		$rsPath='';
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
	    }else {
	    	if($filePath)
	    	{
	    		$tmpPath=$filePath;
	    	}
	    }
	    $rsPath=$tmpPath.'/'.$fileName;
	    if($n)
	    {
	    	if($n>1)
	    	{
		    	$strA=substr($rsPath, 0,strripos($rsPath,'.'));
		    	$strB=substr($rsPath, strripos($rsPath,'.'));
		    	$rsPath=$strA.'_'.$n.$strB;
	    	}
	    }
	    return $rsPath;
	}
	


	/**
	 * 查找所{/bstn:arcList}标签
	 * @param unknown_type $txt
	 */
	public  function arcListPagerFind($txt='',$cid=null,$pager=null)
	{
		 
		$labelCount= substr_count($txt, '{/bstn:arcListPager}');
		for ($i=0;$i<$labelCount;$i++)
		{
			$sstart=stripos($txt, '{bstn:arcListPager');		
		    $startLen=stripos($txt, '{/bstn:arcListPager}')-$sstart+20;
		    $topStr=substr($txt, 0,$sstart);
		    $bottomStr=substr($txt, stripos($txt, '{/bstn:arcListPager}')+20);	    
		    $arcList=substr($txt, $sstart,$startLen);		     
		   	$txt=$topStr.$this->arcListHtmlByPager($arcList,$cid,$pager).$bottomStr;
		}
		return $txt;
	}
	/**
	 * 查找所{/bstn:arcList}带分页标签
	 * @param unknown_type $txt
	 */
	public  function arcListFindPagerInit($txt='')
	{
		 
		$labelCount= substr_count($txt, '{/bstn:arcListPager}');
		$rsStr=null;
		for ($i=0;$i<$labelCount;$i++)
		{
			$sstart=stripos($txt, '{bstn:arcListPager');		
		    $startLen=stripos($txt, '{/bstn:arcListPager}')-$sstart+20;
		    $topStr=substr($txt, 0,$sstart);
		    $bottomStr=substr($txt, stripos($txt, '{/bstn:arcListPager}')+20);	    
		    $arcList=substr($txt, $sstart,$startLen);		  
		    if(substr_count($txt, '$[page-pager]'))   
		    {
		    	$rsStr=$arcList;
		    	break;
		    }
		}
		return $rsStr;
	}
	
	/**
	 * 标签{/bstn:arcList}解析
	 * @param unknown_type $txt
	 */
	public function arcListHtmlByPager($txt='',$cid=null,$pager=null)
	{
		$strWhere=' 1=1 ';
		$indexCss='';
		$rsHtml='';
		$txt=str_replace('{/bstn:arcListPager}', '', $txt);
		$txt=str_replace('bstn:arcListPager', '', $txt);
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
		if(!isset($arrTmp['where'])||(isset($arrTmp['where'])&&!substr_count($arrTmp['where'],'order')))
		{
			$strWhere.=' order by senddate desc ';
		}
		if($pager)
		{
			$start=($pager['pageIndex']-1)*$pager['pageSize'];
			$strWhere.=' limit '.$start.','.$pager['pageSize'];
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
			$rsTmp=str_replace('$[page-pager]','', $rsTmp);
			$rsHtml.=$rsTmp;
			
		}
		if(substr_count($fildStr,'$[page-pager]'))
		{
			$rsHtml.=$this->getPageHtml($pager);
		}
		return $rsHtml;
	}
	public function getPageHtml($pager)
	{
//		$pager=array(
//			'totalRecord'=>count($model),
//			'pageSize'=>Config::pageSize,
//			'totalPage'=>ceil($totalRecord/$pageSize),
//			'pageIndex'=>$pindex,
//		);
		$count5=ceil($pager['totalPage']/1);
//		$index5=floor($pager['pageIndex']/5);
		$index5=ceil($pager['pageIndex']/5);
		$rsHmtlTop='<table >
			<tbody>
			<tr><td><div id="showTotal"></div></td>
			<td style="width:10px;">&nbsp;</td>
			<td id="pagerContainer"><div class="sm-pages" id="pager">';
		
		$rsHmtlbd='<a href="#" >上5页</a>
			<a href="#"  class="sm-pages-prev-un">&nbsp;</a>
			<a href="#"  class="sm-pages-prev">&nbsp;</a>
			<a href="#">1</a>
			<a href="#" class="current">2</a>
			<a href="#" class="sm-pages-next-un">下一页</a>
			<a href="#" >下5页</a>
			<!--<span class="pl10">到<input type="text" class="sm-pages-text">页<input type="button" class="sm-pages-btn" value="确定"></span>-->
			</div>';
		$rsHmtlbottom='</td></tr></tbody></table>';
		$tmp='';
		if($pager['pageIndex']>$index5*5)
		{
			
			if($n)
			{
				$n=$pager['pageIndex']-5;
				$tmp.='<a href="index_'.$n.'.html" >上5页</a>';
			}else {
				$tmp.='<a href="index.html" >上5页</a>';
			}
		}
		
		$ind='';
		$prev='';
		$next='';
		if($pager['pageIndex']<=2)
		{
			$prev='';
		}else {
			$prev='_'.($pager['pageIndex']-1);
		}
		if($pager['pageIndex']<=1)
		{
			$tmp.='<a href="#"  class="sm-pages-prev-un">&nbsp;</a>';
		}else{
			$tmp.='<a href="index'.$prev.'.html"  class="sm-pages-prev">&nbsp;</a>';
		}
		for($i=1;$i<=$pager['totalPage'];$i++)
		{
			$n='';
			if($i<=1)
			{
				$n='';
			}else {
				$n='_'.$i;
			}
			if($i<=1)
			{
				$n='';
			}else {
				$n='_'.$i;
			}
			if($i==$pager['pageIndex'])
			{
				$tmp.='<a href="index'.$n.'.html" class="current">'.$i.'</a>';
			}else {
				$tmp.='<a href="index'.$n.'.html">'.$i.'</a>';
			}
		}
		if($pager['pageIndex']>=$pager['totalPage'])
		{
			$next='_'.$pager['totalPage'];
		}else {
			$next='_'.($pager['pageIndex']+1);
		}
		if($pager['pageIndex']>=$pager['totalPage'])
		{
			$tmp.='<a href="#"  class="sm-pages-next-un">下一页</a>';
		}else{
			$tmp.='<a href="index'.$next.'.html"  class="sm-pages-next">下一页</a>';
		}
		if($pager['totalPage']>5)
		{
			if($pager['pageIndex']<($index5+1)*5&&($index5+1)*5<=$pager['totalPage'])
			{
				if($n)
				{
					$n=$pager['pageIndex']+5;
					$tmp.='<a href="index_'.$n.'.html" >下5页</a>';
				}
			
			}else {
				$tmp.='<a href="index_'.$pager['totalPage'].'.html" >下5页</a>';
			}
		}
		return $rsHmtlTop.$tmp.$rsHmtlbottom;
	}
}
?>