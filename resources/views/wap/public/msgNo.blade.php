@extends('layouts.wapBody')
@section('hf')
<script type="text/javascript" src="{{ asset('/css/aui/auicss/script/aui-toast.js') }}" ></script>
@endsection
@section('jq')
	var toast = new auiToast();
 	toast.fail({
		title:"{{$msg}}",
		duration:10000
	});
	setTimeout(function(){
		window.location.href='{{ $url }}';
	}, 3000)
	
@endsection
@section('content')

@endsection

