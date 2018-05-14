<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

use Input;
use App\Lib\Common;
use App\Lib\Ehtml;
use App\Page;
use App\Models\News;
use App\Models\NewsType;
use App\Lib\SysKey;


class HomeController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('web.index');
    }
 	public function newsType($typeId)
    {
    	$model = NewsType::find($typeId);
    	if($model==null)
    	{
    		$model = NewsType::firstOrNew(['type_dir'=>$typeId]);
    		$typeId = $model->id;
    	}
    	$type = NewsType::where(['status'=>SysKey::$statusOkValue])->get();
    	$condtion = ['type_id'=>$typeId];
    	$news['list'] = News::where($condtion)->paginate(10);
    	$news['hot'] = News::where('flag', 'like','%'.SysKey::$newsFlagHotValue.'%')->limit(10)->get();
    	$news['top'] = News::where('flag', 'like','%'.SysKey::$newsFlagTopValue.'%')->limit(10)->get();
// 		$newList->appends($page)->setPath('index');
		$temp = 'error';
		if($model->temp_list)
		{
			$temp = $model->temp_list;
		}
    	
        return view('web.templet.'.$temp,['model'=>$model,'news'=>$news,'type'=>$type]);
    }
   
}
