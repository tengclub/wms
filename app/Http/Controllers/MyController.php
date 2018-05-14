<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Includes\MacAddInfo;
use App\Includes\Net\MakeUrlCode;
use App\Includes\Wechat\Auth;
use App\Includes\Wechat\Pay\JsApiPay;
use App\Includes\Net\Curl;
use App\Includes\SysKey;
use App\Includes\EditImage;
use App\Models\WxInfo;
use App\Models\System;
use App\Includes\Wechat\Pay\Lib\WxPayShortUrl;
use App\Includes\App\Includes;
use Illuminate\Support\Facades\DB;

class MyController extends Controller
{
	private $plength = 2;
	private $nameSpace = 'Admin';
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
    	$results = DB::select('show TABLES ');
    	foreach ($results as $row)
    	{
    		foreach ($row as $t)
    		{
    			echo '表'.$t.'&nbsp;&nbsp;&nbsp;';
    			echo '<a href="'.url('my/m/'.$t).'">[创建Model]</a>&nbsp;&nbsp;';
    			echo '<a href="'.url('my/c/'.$t).'">[创建Controller]</a>&nbsp;&nbsp;';
    			echo '<a href="'.url('my/v/'.$t).'">[创建View]</a><br/>&nbsp;&nbsp;';
    		}

    	}
    	
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function v($tb)
    {
    	$table = $tb;
    	$tableCn = DB::select('show table status where name="'.$tb.'"')[0]->Comment;
    	$tbArray = explode('_',substr($table, $this->plength));
    	$name = '';
    	foreach ($tbArray as $v)
    	{
    		$name .= ucfirst($v);
    	}
    	$lcfirstName = lcfirst($this->nameSpace).'.'.lcfirst($name);
    	$lcfirstNameUrl = lcfirst($this->nameSpace).'/'.lcfirst($name);
    	//---创建目录－－－－
    	$dir = app_path('/../resources/views/'.$lcfirstNameUrl);
    	if(!is_dir($dir))
    	{
    		mkdir($dir, 0777,true);
    	}
    	
    	//---创建_form---
    	
    	eval('$ml =\App\Models\\'.$name.'::getLabels();');
    	$_html = '';
    	foreach ($ml as $key=>$value)
    	{
    		$_html .= '	<div class="layui-form-item">
        <label class="layui-form-label">{{ $model->labels[\''.$key.'\'] }}</label>
        <div class="layui-input-block">
            <input type="text"  value="{{ $model->'.$key.' }}" name="page['.$key.']"  lay-verify="title" autocomplete="off" placeholder="{{ $model->labels[\''.$key.'\'] }}" class="layui-input">
        	{{ str_replace(\''.$key.'\',$model->labels[\''.$key.'\'],$model->errors->first(\''.$key.'\') ) }}
        </div>
    </div>
';
//     		$_html .= '
// 							<div class="form-group row">
// 								<label class="col-md-1 form-control-label" for="text-input">{{ $model->labels[\''.$key.'\'] }}</label>
// 								<div class="col-md-9">
// 									<input type="text" value="{{ $model->'.$key.' }}" name="page['.$key.']" class="form-control"  placeholder="{{ $model->labels[\''.$key.'\'] }}">
// 									{{ str_replace(\''.$key.'\',$model->labels[\''.$key.'\'],$model->errors->first(\''.$key.'\') ) }}
// 								</div>
// 							</div>';
    	}
    	$html = '<blockquote class="layui-elem-quote layui-text">
</blockquote>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	<legend>'.$tableCn.'</legend>
</fieldset>

<form class="layui-form" action="{{ Request::getRequestUri() }}"  method="POST" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	'.$_html.'    
	<div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            <a class="layui-btn  layui-btn-primary" id="btn-add" href="{{ URL(\''.$lcfirstNameUrl.'/index\') }}">返回</a>
        </div>
    </div>
</form>
@section(\'bodyEnd\')
<script>
	layui.use([\'form\'], function(){
		var form = layui.form;
});
</script>
@endsection';
    	
    	
    	$file = $dir.'/_form.blade.php';
    	$code = '';
    	if(!file_exists($file))
    	{
    		$myfile = fopen($file, "w");
    		fwrite($myfile, $html);
    		fclose($myfile);
    		$code = $file.'文件生成成功';
    	}else {
    		$code = '文件'.$file.'已存在';
    	}
    	echo $code.'<br/>';
    	
    	//-----创建index---
    	
    	$_search = '';
    	$_gridHead = '';
    	$_gridBody = '';
    	foreach ($ml as $key=>$value)
    	{
    		$_search .= '
    			<div class="layui-inline">
					<label class="layui-form-label">{{ $model->labels["'.$key.'"] }}</label>
					<div class="layui-input-inline">
						<input type="text" id="'.$key.'" name="'.$key.'" value="{{$model->'.$key.'}}"  autocomplete="off" class="layui-input">
					</div>
				</div>'."\n";
//     		$_search .= '
// 													<input class="form-control" placeholder="{{ $model->labels["'.$key.'"] }}" type="text" name="'.$key.'" value="{{$model->'.$key.'}}">';
    		if($key == 'id')
    		{
    			$_gridBody .= '{field: "id", title: "ID", width: 80, sort: true ,checkbox: true, }'."\n";
    		}else {
    			$_gridBody .= "\n".',{field: "'.$key.'", title: "{{ $model->labels["'.$key.'"] }}",  sort: true}';
    		}
    		
    				
    	}
    	$html = '@extends(\'layouts.mainBody\')
@section(\'bodyOption\')
	class="body"
@endsection
@section(\'content\')
<fieldset class="layui-elem-field">
	<legend>检索</legend>
	<div class="layui-field-box">
		<form class="layui-form" action="{{ Request::getRequestUri() }}">
			<div class="layui-form-item">
				'.$_search.'
				<div class="layui-inline">
					<button class="layui-btn  layui-btn-small" lay-submit="" ><i class="layui-icon">&#xe615;</i></button>
				</div>
			</div>
		</form>
	</div>
</fieldset>
<!-- 工具集 -->
<div class="my-btn-box">
	<span class="fl">
		<a class="layui-btn layui-btn-danger radius btn-delect layui-btn-sm" id="btn-delete-all">批量删除</a>
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-add" href="{{ URL(\''.$lcfirstNameUrl.'/create\') }}">添加</a>
		<a class="layui-btn btn-add btn-default layui-btn-sm" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
	</span>
</div>
<table id="dataTable" lay-filter="dataTable"></table>
<script type="text/html" id="barOption">
	<a lay-event="edit" title="编辑">&nbsp;<i class="layui-icon">&#xe642;</i>&nbsp;&nbsp;</a>
	<a lay-event="del" title="删除"><i class="layui-icon">&#xe640;</i></a>
</script>
@endsection

@section(\'bodyEnd\')
<script>
layui.use("table", function(){
	var table = layui.table;
	var tableIns = table.render({ //其它参数在此省略
		elem: "#dataTable"//指定原始表格元素选择器（推荐id选择器）
		,url: "?__data=json&"+$("form").serialize()
		, cols: [[ 
				'.$_gridBody.'
			, {fixed: "right", title: "操作", width: 150, align: "center", toolbar: "#barOption"} //这里的toolbar值是模板元素的选择器
		]]
		,size: "sm" 
		, id: "id"
		, method: "get"
		, page: true
		, limits: [10, 20, 30, 40, 50,100,200]
		, limit: 10 
		, loading: true
		, done: function (res, curr, count) {
		}
	}); 
	table.on("sort(dataTable)", function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
	  //尽管我们的 table 自带排序功能，但并没有请求服务端。
	  //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，如：
		tableIns.reload({
			initSort: obj //记录初始排序，如果不设的话，将无法标记表头的排序状态。 layui 2.1.1 新增参数
			,where: { //请求参数
				field: obj.field //排序字段
				,order: obj.type //排序方式
			}
		});
	});
	//监听工具条
	table.on("tool(dataTable)", function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
		var data = obj.data //获得当前行数据
		,layEvent = obj.event; //获得 lay-event 对应的值
		if(layEvent === "del"){
			layer.confirm("真的删除吗？", function(index){
	        	//向服务端发送删除指令
				$.ajax({ 
					type: "GET",
					url: "{{URL("'.$lcfirstNameUrl.'/ajaxDestroy")}}/"+data.id, 
					dataType: "json",
					success: function(data){
						if(data.code=="000")
						{
							obj.del(); //删除对应行（tr）的DOM结构
							layer.close(index);
						}
						 layer.msg(data.msg);
			      	}
				});
			});
		} else if(layEvent === "edit"){
			layer.msg("编辑操作");
			window.location.href="{{ url("'.$lcfirstNameUrl.'/edit/") }}/"+data.id;
		}
	});
	// 刷新
	$("#btn-refresh").on("click", function () {
		tableIns.reload();
	});
	// 批量删除
	$("#btn-delete-all").on("click", function () {
		var checkStatus = table.checkStatus("id");
		var chkValue =[];
		$.each(checkStatus.data, function(){
			chkValue.push(this.id);
		})
		var ids = chkValue.join(",");
		$.ajax({ 
			type: "GET",
			url: "{{URL("'.$lcfirstNameUrl.'/ajaxDestroy")}}/"+ids, 
			dataType: "json",
			success: function(data){
				if(data.code=="000")
				{
					 tableIns.reload();
				}
				layer.msg(data.msg);
			}
		});
    });
});
</script>
@endsection
    	';
    	
    	$file = $dir.'/index.blade.php';
    	$code = '';
    	if(!file_exists($file))
    	{
    		$myfile = fopen($file, "w");
    		fwrite($myfile, $html);
    		fclose($myfile);
    		$code = $file.'文件生成成功';
    	}else {
    		$code = '文件'.$file.'已存在';
    	}
    	echo $code.'<br/>';
    	
//     	echo $html;
    	
    	
    	//---创建create---
    	$html = '@extends(\'layouts.mainBody\')
@section(\'bodyOption\')
	class="body"
@endsection
@section(\'content\')
	@include(\''.$lcfirstName.'._form\')
@endsection
 ';   			

    	$file = $dir.'/create.blade.php';
    	$code = '';
    	if(!file_exists($file))
    	{
    		$myfile = fopen($file, "w");
    		fwrite($myfile, $html);
    		fclose($myfile);
    		$code = $file.'文件生成成功';
    	}else {
    		$code = '文件'.$file.'已存在';
    	}
    	echo $code.'<br/>';
    	
    	//---创建edit---
    	$html = '@extends(\'layouts.mainBody\')
@section(\'bodyOption\')
	class="body"
@endsection
@section(\'content\')
	@include(\''.$lcfirstName.'._form\')
@endsection
 ';  
    	$file = $dir.'/edit.blade.php';
    	$code = '';
    	if(!file_exists($file))
    	{
    		$myfile = fopen($file, "w");
    		fwrite($myfile, $html);
    		fclose($myfile);
    		$code = $file.'文件生成成功';
    	}else {
    		$code = '文件'.$file.'已存在';
    	}
    	echo $code.'<br/>';
    	
//     	echo $html;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function m($tb)
    {
    	
    	$table = $tb;
    	$tbArray = explode('_',substr($table, $this->plength));
    	$name = '';
    	foreach ($tbArray as $v)
    	{
    		$name .= ucfirst($v);
    	}
    	$results = DB::select('show full fields from '.$table);
    	$table = substr($table, $this->plength);
    	$code = "<?php\r\n";
    	$code .= "namespace App\Models;\r\n\r\n";
//     	$code .= "use Illuminate\Database\Eloquent\Model;\r\n";
//     	$code .= "use App\Includes\Common;\r\n";
    	$code .= "class $name extends SysModel\r\n";
    	$code .= "{\r\n";
    	$code .= '	protected $table = \''.$table."';\r\n";
		$code .= "	public static function getLabels()\r\n";
    	$code .= "	{\r\n";
    	$code .= "		return [\r\n";
    	foreach ($results as $row)
    	{
    		$code .= "			'".$row->Field."'=>'".$row->Comment."',\r\n";
    	}
    	$code .= "		];\r\n";  			
    	$code .= "	}\r\n";
    	$code .= "}\r\n";
    	$file = app_path("Models/{$name}.php");
    	if(!file_exists($file))
    	{
    		$myfile = fopen($file, "w");
    		fwrite($myfile, $code);
    		fclose($myfile);
    		$code = $file.'文件生成成功';
    	}else {
    		$code = '文件'.$file.'已存在';
    	}
    	echo $code;
    }
    public function c($tb)
    {
    	$table = $tb;
    	$tbArray = explode('_',substr($table, $this->plength));
    	$name = '';
    	foreach ($tbArray as $v)
    	{
    		$name .= ucfirst($v);
    	}
    	$lcfirstNameUrl = lcfirst($this->nameSpace).'/'.lcfirst($name);
    	
    	$code = "<?php\r\n";
    	$code .= "namespace App\Http\Controllers\\".ucfirst($this->nameSpace).";\r\n";
    	$code .= "use Illuminate\Http\Request;\r\n";
    	$code .= "use App\Http\Controllers\Controller;\r\n";
    	$code .= "use Illuminate\View\View;\r\n";
    	$code .= "use Illuminate\Database\Eloquent\Model;\r\n";
    	$code .= "use Illuminate\Support\Facades\Validator;\r\n";
    	$code .= "use Input;\r\n";
    	$code .= "use App\Page;\r\n";
    	$code .= "use App\Models\\".$name.";\r\n";
    	$code .= "use App\Models\SysLog;\r\n";
    	$code .= "use App\Lib\Common;\r\n";
    	$code .= "use App\Lib\SysKey;\r\n\r\n";
    	$code .= "class {$name}Controller \r\n";
    	$code .= "{\r\n";
    	
    	$code .= '	/**'."\r\n";
    	$code .= '	 * 全部列表'."\r\n";
    	$code .= '	 * @return \Illuminate\View\View'."\r\n";
    	$code .= '	 */'."\r\n";
    	$code .= '	public function index(Request $request)'."\r\n";
    	$code .= '	{'."\r\n";
    	$code .= '		$model = new '.$name.'();'."\r\n";
    	$code .= '		$condtion = \'1=1\';'."\r\n";
    	$code .= '		$page = null;'."\r\n";
    	$code .= '		if(Input::all())'."\r\n";
    	$code .= '		{'."\r\n";
    	$code .= '			$page = Input::all();'."\r\n";
    	$code .= '			foreach ($page as $key=>$value)'."\r\n";
    	$code .= '			{'."\r\n";
    	$code .= '				if(in_array($key,array_keys($model->labels)))'."\r\n";
    	$code .= '				{'."\r\n";
    	$code .= '					$model->$key = $value;'."\r\n";
    	$code .= '					$condtion .=\' and \'.$key.\' like "%\'.$value.\'%"\';'."\r\n";
    	$code .= '				}'."\r\n";
    	$code .= '			}'."\r\n";
    	$code .= '		}'."\r\n";
    	$code .= '		if($request->get(\'__data\'))'."\r\n";
    	$code .= '		{'."\r\n";
    	$code .= '			$_data = null;'."\r\n";
 		$code .= '    		$data = '.$name.'::whereRaw($condtion)->orderBy($request->get(\'field\',\'id\'),$request->get(\'order\',\'desc\'))->paginate($request->get(\'limit\'));'."\r\n";
 		$code .= '    		foreach ($data as $obj) {'."\r\n";
 		$code .= '    			foreach ($obj->getAttributes() as $k=>$v) {'."\r\n";
 		$code .= '    				$_tmp[$k] = $v;'."\r\n";
 		$code .= '    			}'."\r\n";
 		$code .= '    			$_data[] = $_tmp;'."\r\n";
 		$code .= '    		}'."\r\n";
 		$code .= '    		echo json_encode([\'data\'=>$_data,\'count\'=>$data->total(),\'code\'=>0,\'msg\'=>\'\']);'."\r\n";
 		$code .= '    		return;'."\r\n";
 		$code .= '    	}'."\r\n";
    	$code .= '		return view(\''.lcfirst($this->nameSpace).'.'.lcfirst($name).'.index\', [\'model\'=>$model]);'."\r\n";
    	$code .= '	}'."\r\n";
    	
// 		$code .= '    	/**'."\r\n";
// 		$code .= '    	 * 全部列表'."\r\n";
// 		$code .= '    	 * @return \Illuminate\View\View'."\r\n";
// 		$code .= '    	 */'."\r\n";
// 		$code .= '    	public function ajaxData(Request $request)'."\r\n";
// 		$code .= '    	{'."\r\n";
// 		$code .= '    		$_data = null;'."\r\n";
// 		$code .= '    		$model = new SysGroup();'."\r\n";
// 		$code .= '    		$condtion = \'1=1\';'."\r\n";
// 		$code .= '    		$page = null;'."\r\n";
// 		$code .= '    		if(Input::all())'."\r\n";
// 		$code .= '    		{'."\r\n";
// 		$code .= '    			$page = Input::all();'."\r\n";
// 		$code .= '    			foreach ($page as $key=>$value)'."\r\n";
// 		$code .= '    			{'."\r\n";
// 		$code .= '    				if(in_array($key,array_keys($model->getLabels())))'."\r\n";
// 		$code .= '    				{'."\r\n";
// 		$code .= '    					if($key&&$value)'."\r\n";
// 		$code .= '    					{'."\r\n";
// 		$code .= '    						$model->$key = $value;'."\r\n";
// 		$code .= '    						$condtion .=\' and \'.$key.\' like "%\'.$value.\'%"\';'."\r\n";
// 		$code .= '    					}'."\r\n";
// 		$code .= '    				}'."\r\n";
// 		$code .= '    			}'."\r\n";
// 		$code .= '    		}'."\r\n";
// 		$code .= '    		$data = SysGroup::whereRaw($condtion)->orderBy($request->get(\'field\',\'id\'),$request->get(\'order\',\'desc\'))->paginate($request->get(\'limit\'));'."\r\n";
// 		$code .= '    		foreach ($data as $boj) {'."\r\n";
// 		$code .= '    			foreach ($boj->getAttributes() as $k=>$v) {'."\r\n";
// 		$code .= '    				$_tmp[$k] = $v;'."\r\n";
// 		$code .= '    			}'."\r\n";
// 		$code .= '    			$_data[] = $_tmp;'."\r\n";
// 		$code .= '    		}'."\r\n";
// 		$code .= '    		echo json_encode([\'data\'=>$_data,\'count\'=>$data->total(),\'code\'=>0,\'msg\'=>\'\']);'."\r\n";
// 		$code .= '    	}'."\r\n";
    	
    	$code .= '	/**'."\r\n";
    	$code .= '	 * Show the form for creating a new resource.'."\r\n";
    	$code .= '	 *'."\r\n";
    	$code .= '	 * @return Response'."\r\n";
    	$code .= '	 */'."\r\n";
    	$code .= '	public function create()'."\r\n";
    	$code .= '	{'."\r\n";
    	$code .= '		$model = new '.$name.'();'."\r\n";
    	$code .= '		if(isset($_POST[\'page\']))'."\r\n";
    	$code .= '		{'."\r\n";
    	$code .= '			$page = $_POST[\'page\'];'."\r\n";
    	$code .= '			$validator = Validator::make($page,'."\r\n";
    	$code .= '				['."\r\n";
    	$code .= '					//\'id\' => \'required|unique:table_name\','."\r\n";
    	$code .= '				]'."\r\n";
    	$code .= '			);'."\r\n";
    	$code .= '			foreach ($page as $key=>$value)'."\r\n";
    	$code .= '			{'."\r\n";
    	$code .= '				$model->$key = $value;'."\r\n";
    	$code .= '			}'."\r\n";
    	$code .= '			if ($validator->passes())'."\r\n";
    	$code .= '			{'."\r\n";
    	$code .= '				$model->id = Common::getId();'."\r\n";
    	$code .= '				if ($model->save()) {'."\r\n";
//     	$code .= '					$sysLog = new SysLog();'."\r\n";
//     	$code .= '					$sysLog->log_type = SysKey::$sysLogAddValue;'."\r\n";
//     	$code .= '					$sysLog->content = \'用户信息\';'."\r\n";
//     	$code .= '					$sysLog->esave();'."\r\n";
    	$code .= '					return view(\''.lcfirst($this->nameSpace).'.public.msgOk\', [\'msg\'=>\'保存成功\',\'url\'=>url(\''.$lcfirstNameUrl.'/index\')]);'."\r\n";
    	$code .= '				} else {'."\r\n";
    	$code .= '					return Redirect::back()->withInput()->withErrors(\'保存失败！\');'."\r\n";
    	$code .= '				}'."\r\n";
    	$code .= '			}else {'."\r\n";
    	$code .= '				$model->errors = $validator->messages();'."\r\n";
    	$code .= '			}'."\r\n";
    	$code .= '		}else {'."\r\n";
    	$code .= '			$validator = Validator::make(array(),array());'."\r\n";
    	$code .= '			$model->errors = $validator->messages();'."\r\n";
    	$code .= '		}'."\r\n";
    	$code .= '		return view(\''.lcfirst($this->nameSpace).'.'.lcfirst($name).'.create\', [\'model\'=>$model]);'."\r\n";
    	$code .= '	}'."\r\n";
    	
    	$code .= '	/**'."\r\n";
    	$code .= '	 * Show the form for creating a new resource.'."\r\n";
    	$code .= '	 * @param  int  $id'."\r\n";
    	$code .= '	 * @return Response'."\r\n";
    	$code .= '	 */'."\r\n";
    	$code .= '	public function edit($id)'."\r\n";
    	$code .= '	{'."\r\n";
    	$code .= '		$model = '.$name.'::findOrNew($id);'."\r\n";
    	$code .= '		if(isset($_POST[\'page\']))'."\r\n";
    	$code .= '		{'."\r\n";
    	$code .= '			$page = $_POST[\'page\'];'."\r\n";
    	$code .= '			$validator = Validator::make($page,'."\r\n";
    	$code .= '				['."\r\n";
    	$code .= '					//\'id\' => \'required|unique:tale_name\','."\r\n";
    	$code .= '				]'."\r\n";
    	$code .= '			);'."\r\n";
    	$code .= '			foreach ($page as $key=>$value)'."\r\n";
    	$code .= '			{'."\r\n";
    	$code .= '				$model->$key = $value;'."\r\n";
    	$code .= '			}'."\r\n";
    	$code .= '			if ($validator->passes())'."\r\n";
    	$code .= '			{'."\r\n";
    	$code .= '				if ($model->save()) {'."\r\n";
    	$code .= '					$sysLog = new SysLog();'."\r\n";
    	$code .= '					$sysLog->log_type = SysKey::$sysLogUpdateValue;'."\r\n";
    	$code .= '					$sysLog->content = \'用户信息\';'."\r\n";
    	$code .= '					$sysLog->esave();'."\r\n";
    	$code .= '					return view(\''.lcfirst($this->nameSpace).'.public.msgOk\', [\'msg\'=>\'保存成功\',\'url\'=>url(\''.$lcfirstNameUrl.'/index\')]);'."\r\n";
    	$code .= '				} else {'."\r\n";
    	$code .= '					return Redirect::back()->withInput()->withErrors(\'保存失败！\');'."\r\n";
    	$code .= '				}'."\r\n";
    	$code .= '			}else {'."\r\n";
    	$code .= '				$model->errors = $validator->messages();'."\r\n";
    	$code .= '			}'."\r\n";
    	$code .= '		}else {'."\r\n";
    	$code .= '			$validator = Validator::make(array(),array());'."\r\n";
    	$code .= '			$model->errors = $validator->messages();'."\r\n";
    	$code .= '		}'."\r\n";
    	$code .= '		return view(\''.lcfirst($this->nameSpace).'.'.lcfirst($name).'.create\', [\'model\'=>$model]);'."\r\n";
    	$code .= '	}'."\r\n";
    	
    	$code .= '	/**'."\r\n";
    	$code .= '	 * Remove the specified resource from storage.'."\r\n";
    	$code .= '	 *'."\r\n";
    	$code .= '	 * @param  int  $id'."\r\n";
    	$code .= '	 * @return Response'."\r\n";
    	$code .= '	 */'."\r\n";
    	$code .= '	public function destroy($id)'."\r\n";
    	$code .= '	{'."\r\n";
    	$code .= '		//'."\r\n";
    	$code .= '		$ids = explode(\',\', $id);'."\r\n";
    	$code .= '		foreach ($ids as $id)'."\r\n";
    	$code .= '		{'."\r\n";
    	$code .= '			$model = '.$name.'::findOrNew($id);'."\r\n";
//     	$code .= '			$sysLog = new SysLog();'."\r\n";
//     	$code .= '			$sysLog->log_type = SysKey::$sysLogDelValue;'."\r\n";
//     	$code .= '			$sysLog->content = \'信息\';'."\r\n";
//     	$code .= '			$sysLog->esave();'."\r\n";
    	$code .= '			'.$name.'::destroy($id);'."\r\n";
    	$code .= '		}'."\r\n";
    	$code .= '		return redirect(\''.$lcfirstNameUrl.'/index\');'."\r\n";
   		$code .= '	}'."\r\n";
   		
   		$code .= '	/**'."\r\n";
   		$code .= '	 * Remove the specified resource from storage.'."\r\n";
   		$code .= '	 *'."\r\n";
   		$code .= '	 * @param  int  $id'."\r\n";
   		$code .= '	 * @return Response'."\r\n";
   		$code .= '	 */'."\r\n";
   		$code .= '	public function ajaxDestroy($id)'."\r\n";
   		$code .= '	{'."\r\n";
   		$code .= '		$rs = [\'code\'=>\'000\',\'msg\'=>\'删除成功\'];'."\r\n";
   		$code .= '		$ids = explode(\',\', $id);'."\r\n";
   		$code .= '		foreach ($ids as $id)'."\r\n";
   		$code .= '		{'."\r\n";
   		$code .= '			$model = '.$name.'::findOrNew($id);'."\r\n";
//     	$code .= '			$sysLog = new SysLog();'."\r\n";
//     	$code .= '			$sysLog->log_type = SysKey::$sysLogDelValue;'."\r\n";
//     	$code .= '			$sysLog->content = \'信息\';'."\r\n";
//     	$code .= '			$sysLog->esave();'."\r\n";
   		$code .= '			'.$name.'::destroy($id);'."\r\n";
   		$code .= '		}'."\r\n";
   		$code .= '		echo json_encode($rs);'."\r\n";
   		$code .= '	}'."\r\n";
   		
    	
    	$code .= '}'."\r\n";
    	 
    	
    	
    	$file = app_path("Http/Controllers/".ucfirst($this->nameSpace)."/{$name}Controller.php");
    	if(!file_exists($file))
    	{
    		$myfile = fopen($file, "w");
    		fwrite($myfile, $code);
    		fclose($myfile);
    		$code = $file.'文件生成成功';
    	}else {
    		$code = '文件'.$file.'已存在';
    	}
    	echo $code;
    	
    }
 
    public function test()
    {
//     	var_dump(url()->full());
//     	$str='{"appid":"wxba8904a78921735c","attach":"13896850833055","bank_type":"ICBC_DEBIT","cash_fee":"134085","coupon_count":"1","coupon_fee":"15","coupon_fee_0":"15","coupon_id_0":"2000000001349012120","fee_type":"CNY","is_subscribe":"Y","mch_id":"1461221502","nonce_str":"8ascxs00hc2p0a94dt8vl5i3vlzw39f7","openid":"oyPo-wyQJx5b6RQiORJ2tZGvGid8","out_trade_no":"138968508330551","result_code":"SUCCESS","return_code":"SUCCESS","sign":"DBA026544F5F72809310032F51C7090C","time_end":"20170814191406","total_fee":"134100","trade_type":"NATIVE","transaction_id":"4003892001201708146225224651"}';
//     	$str = json_decode($str);
//     	dd($str);
    	$rs1 = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','X'];
//     	$aa = 
    	dd(System::orderTable());
    foreach ($rs1 as $a)
    {
    	echo '\''.$a.'\'=>\''.$a.'\',';
    }
    }
    public function index2($id)
    {
    	var_dump($id.'---123');
    }

   
}
