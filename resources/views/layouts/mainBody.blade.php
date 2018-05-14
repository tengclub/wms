@extends('layouts.main')
@section('body')
<body @yield('bodyOption')>
	@yield('content')
	<script type="text/javascript" src="{{ asset('/css/layui/layui/layui.js') }}"></script>
	@yield('bodyEnd')
</body>
@endsection
