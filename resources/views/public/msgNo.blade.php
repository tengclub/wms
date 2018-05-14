@extends('layouts.mainBody')
@section('content')
<fieldset class="layui-elem-field site-demo-button" style="margin: 100px auto; width:30%">
  <legend>失败</legend>
  <div>
  {{$msg}}
  </div>
  
  <div>
  <hr class="layui-bg-red">
  <a href="{{$url}}" class="layui-btn layui-btn-danger layui-btn-small fr">确定</a>
  </div>
</fieldset>

@endsection