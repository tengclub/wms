@extends('layouts.main')
@section('body')
<body class="login-body body">
	@yield('content')
	<script type="text/javascript" src="{{ asset('/css/layui/layui/layui.js') }}"></script>
	@yield('bodyEnd')
</body>
@endsection
