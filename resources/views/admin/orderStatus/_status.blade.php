@section('jq')
$("#btn-ok").click(function(){
	$('form').submit();
});
$("#btn-no").click(function(){
	$("#_status").val(9);
	$('form').submit();
});

@endsection
@if($model->status_data)
	<div class="layui-form-item">
		<label class="layui-form-label">进程</label>
		<div class="layui-input-block">
		    <ul class="layui-timeline">
		    @foreach($model->status_data as $s)
			  <li class="layui-timeline-item">
			    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
			    <div class="layui-timeline-content layui-text">
			      <h3 class="layui-timeline-title">{{ $s['text'] }}</h3>
			      <p>
			      @if(isset($s['object']['text']))
			       {{ $s['object']['text'] }}&nbsp;&nbsp;&nbsp;&nbsp;
			       @endif
			       {{ $s['user'] }} | {{ $s['time'] }}
			       
			      </p>
			    </div>
			  </li>
		    @endforeach
		    @if($model->status_over!=App\Lib\SysKey::$orderStatusStatusIngValue)
		       <li class="layui-timeline-item">
			    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
			    <div class="layui-timeline-content layui-text">
			      <h3 class="layui-timeline-title">{{ App\Lib\SysKey::getOrderStatusStatusByValue($model->status_over) }}</h3>
			    </div>
			  </li>
		    @endif
			</ul>
    	</div>
	</div>
	@endif	
	@if($model->status_over==App\Lib\SysKey::$orderStatusStatusIngValue&&$nextStatus->object_type)<!-- 订单状态 -->
	@if(in_array($nextStatus->id, $myStatus)|| $user->level==App\Lib\SysKey::$sysUserLevelSuperAdminValue)<!-- 用户权限-->
	@switch ($nextStatus->object_type)
		@case (App\Lib\SysKey::$orderStatusTypeNoneValue)
		
			@break
		@case (App\Lib\SysKey::$orderStatusTypeInputValue)
			<div class="layui-form-item">
		        <label class="layui-form-label">{{$nextStatus->object_lable}}</label>
		        <div class="layui-input-block">
		            <input type="text"  value="{{ $nextStatus->object_value }}" name="status_object_value"  lay-verify="title" autocomplete="off" placeholder="{{ $nextStatus->object_lable }}" class="layui-input">
		        </div>
	    	</div>
			@break
		@case (App\Lib\SysKey::$orderStatusTypeRadioValue)
			<div class="layui-form-item">
		        <label class="layui-form-label">{{$nextStatus->object_lable}}</label>
		        <div class="layui-input-block">
		        <?php //dd($nextStatus->object_value)?>
		         @foreach($nextStatus->object_value as $key=>$value)
		         @if($key==0)
		         <input type="radio" name="status_object_value" value="{{ $value[0] }}" title="{{ $value[1] }}" checked>
		         @else
		         <input type="radio" name="status_object_value" value="{{ $value[0] }}" title="{{ $value[1] }}">
		         @endif
		         @endforeach
		        </div>
	    	</div>
	    	@section('bodyEnd')
	    	<script>
				layui.use(['form'], function(){
					var form = layui.form;
				})
			</script>
			@endsection
			@break
		@case (App\Lib\SysKey::$orderStatusTypeCheckboxValue)
			<div class="layui-form-item">
		        <label class="layui-form-label">{{$nextStatus->object_lable}}</label>
		        <div class="layui-input-block">
		         @foreach($nextStatus->object_value as $key=>$value)
		         @if($key==0)
		         <input type="checkbox" name="status_object_value[{{ $value[0] }}]" value="{{ $value[0] }}" title="{{ $value[1] }}" checked>
		         @else
		         <input type="checkbox" name="status_object_value[{{ $value[0] }}]" value="{{ $value[0] }}" title="{{ $value[1] }}">
		         @endif
		         @endforeach
		        </div>
	    	</div>
	    	@section('bodyEnd')
	    	<script>
				layui.use(['form'], function(){
					var form = layui.form;
				})
			</script>
			@endsection
			@break
		@case (App\Lib\SysKey::$orderStatusTypeDropdownValue)
			<div class="layui-form-item">
		        <label class="layui-form-label">{{$nextStatus->object_lable}}</label>
		        <div class="layui-input-block">
		        <select name="status_object_value" lay-verify="">
		         @foreach($nextStatus->object_value as $key=>$value)
					<option value="{{ $value[0] }}">{{ $value[1] }}</option>
		         @endforeach
		        </select>  
		        </div>
	    	</div>
	    	@section('bodyEnd')
	    	<script>
				layui.use(['form'], function(){
					var form = layui.form;
				})
			</script>
			@endsection
			@break
		@case (App\Lib\SysKey::$orderStatusTypeTextareaValue)
			<div class="layui-form-item">
		        <label class="layui-form-label">{{$nextStatus->object_lable}}</label>
		        <div class="layui-input-block">
		         <textarea name="status_object_value" placeholder="{{ $nextStatus->object_lable }}" class="layui-textarea">{{ $nextStatus->object_value }}</textarea>
		        </div>
	    	</div>
			@break
		@case (App\Lib\SysKey::$orderStatusTypeInputDateValue)
			<div class="layui-form-item">
		        <label class="layui-form-label">{{$nextStatus->object_lable}}</label>
		        <div class="layui-input-block">
		          <input type="text" id="status_object_value"  value="{{ $nextStatus->object_value }}" name="status_object_value"  lay-verify="title" autocomplete="off" placeholder="{{ $nextStatus->object_lable }}" class="layui-input">
		        </div>
	    	</div>
	    	@section('bodyEnd')
			<script>
				layui.use(['laydate'], function(){
					var laydate = layui.laydate;
					laydate.render({
						elem: '#status_object_value'
						,type: 'date'
					});
				})
			</script>
			@endsection
			@break
		@case (App\Lib\SysKey::$orderStatusTypeInputDateTimeValue)
			<div class="layui-form-item">
		        <label class="layui-form-label">{{$nextStatus->object_lable}}</label>
		        <div class="layui-input-block">
		          <input type="text" id="status_object_value"  value="{{ $nextStatus->object_value }}" name="status_object_value"  lay-verify="title" autocomplete="off" placeholder="{{ $nextStatus->object_lable }}" class="layui-input">
		        </div>
	    	</div>
	    	@section('bodyEnd')
			<script>
				layui.use(['laydate'], function(){
					var laydate = layui.laydate;
					laydate.render({
						elem: '#status_object_value'
						,type: 'datetime'
					});
				})
			</script>
			@endsection
			@break
		@default

	@endswitch
	
	
	<div class="layui-form-item">
        <div class="layui-input-block">
            <a href="###" class="layui-btn" id="btn-ok">同意</a>
            <a href="###" class="layui-btn" id="btn-no">不同意</a>
        </div>
    </div>
    @endif
    @endif
    
  