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
	<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-form-list">
    <li class="aui-list-item">
    <div class="aui-card-list-footer aui-text-center b-bg-75" >[进度]</div>
    </li>
     @foreach($model->status_data as $s)
		<li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-input">
                  {{ $s['text'] }} -  
                  @if(isset($s['object']['text']))
			       {{ $s['object']['text'] }}&nbsp;&nbsp;&nbsp;&nbsp;
			       @endif
			       {{ $s['user'] }} | {{ $s['time'] }}
                </div>
            </div>
        </li>
		@endforeach
		@if($model->status_over!=App\Lib\SysKey::$orderStatusStatusIngValue)
		<li class="aui-list-item">
            <div class="aui-list-item-inner">
                <div class="aui-list-item-label">
                  {{ App\Lib\SysKey::getOrderStatusStatusByValue($model->status_over) }}
                </div>
            </div>
        </li>
		@endif
    </ul>
    </div>
@endif   
	<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-form-list">
    
    @if($model->status_over==App\Lib\SysKey::$orderStatusStatusIngValue&&$nextStatus->object_type)<!-- 订单状态 -->
	@if(in_array($nextStatus->id, $myStatus)|| $user->level==App\Lib\SysKey::$sysUserLevelSuperAdminValue)<!-- 用户权限-->
	<li class="aui-list-item">
    <div class="aui-card-list-footer aui-text-center b-bg-75" >[操作]</div>
    </li>
	@switch ($nextStatus->object_type)
		@case (App\Lib\SysKey::$orderStatusTypeNoneValue)
		
			@break
		@case (App\Lib\SysKey::$orderStatusTypeInputValue)
			<li class="aui-list-item">
	            <div class="aui-list-item-inner">
	                <div class="aui-list-item-label">
	                  {{$nextStatus->object_lable}}
	                </div>
	                <div class="aui-list-item-input">
	                  <input type="text"  value="{{ $nextStatus->object_value }}" name="status_object_value"  placeholder="{{ $nextStatus->object_lable }}" >
	                </div>
	            </div>
	        </li>
			@break
		@case (App\Lib\SysKey::$orderStatusTypeRadioValue)
			<li class="aui-list-item">
	            <div class="aui-list-item-inner">
	                <div class="aui-list-item-label">
	                  {{$nextStatus->object_lable}}
	                </div>
	                <div class="aui-list-item-input">
	                 @foreach($nextStatus->object_value as $key=>$value)
			         @if($key==0)
			         <label><input class="aui-radio"  type="radio" name="status_object_value" value="{{ $value[0] }}" checked>{{ $value[1] }}</label>
			         @else
			         <label><input class="aui-radio"  type="radio" name="status_object_value" value="{{ $value[0] }}" >{{ $value[1] }}</label>
			         @endif
			         @endforeach
	                </div>
	            </div>
	        </li>
			@break
		@case (App\Lib\SysKey::$orderStatusTypeCheckboxValue)
		<li class="aui-list-item">
	            <div class="aui-list-item-inner">
	                <div class="aui-list-item-label">
	                  {{$nextStatus->object_lable}}
	                </div>
	                <div class="aui-list-item-input">
	                 @foreach($nextStatus->object_value as $key=>$value)
			         @if($key==0)
			          <label><input type="checkbox"  class="aui-checkbox" name="status_object_value[{{ $value[0] }}]" value="{{ $value[0] }}"  checked>{{ $value[1] }}</label>
			         @else
			          <label><input type="checkbox"  class="aui-checkbox" name="status_object_value[{{ $value[0] }}]" value="{{ $value[0] }}" >{{ $value[1] }}</label>
			         @endif
			         @endforeach
			         </div>
	            </div>
	        </li>
			@break
		@case (App\Lib\SysKey::$orderStatusTypeDropdownValue)
		<li class="aui-list-item">
	            <div class="aui-list-item-inner">
	                <div class="aui-list-item-label">
	                  {{$nextStatus->object_lable}}
	                </div>
	                <div class="aui-list-item-input">
	                <select name="status_object_value" lay-verify="">
			         @foreach($nextStatus->object_value as $key=>$value)
						<option value="{{ $value[0] }}">{{ $value[1] }}</option>
			         @endforeach
			        </select>  
			         </div>
	            </div>
	        </li>
			@break
		@case (App\Lib\SysKey::$orderStatusTypeTextareaValue)
		<li class="aui-list-item">
	            <div class="aui-list-item-inner">
	                <div class="aui-list-item-label">
	                  {{$nextStatus->object_lable}}
	                </div>
	                <div class="aui-list-item-input">
	                <textarea name="status_object_value" placeholder="{{ $nextStatus->object_lable }}" >{{ $nextStatus->object_value }}</textarea>
			         </div>
	            </div>
	        </li>
			@break
		@case (App\Lib\SysKey::$orderStatusTypeInputDateValue)
			
			@break
		@case (App\Lib\SysKey::$orderStatusTypeInputDateTimeValue)
			

			@break
		@default

	@endswitch
	

 		<li class="aui-list-item">
			<div class="aui-list-item-inner aui-list-item-center aui-list-item-btn">
				<input class="aui-btn aui-btn-info aui-margin-r-5" id="btn-ok" type="button" value="同意">
				<input class="aui-btn aui-btn-info aui-margin-r-5" id="btn-no" type="button" value="不同意">
			</div>
		</li>
    </ul>
    </div>
    @endif
    @endif
    
  