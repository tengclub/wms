<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>TENGCLUB-WMS</title>
    <link rel="stylesheet" href="{{ asset('/css/layui/layui/css/layui.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/static/css/style.css') }}">
<!--     <script type="text/javascript" src="{{ asset('/js/jquery-2.2.4.min.js') }}"></script> -->
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
	@yield('hf')
	<script type="text/javascript">
	/*<![CDATA[*/
	jQuery(function($) {
		@yield('jq')
	});
	/*]]>*/
	</script>
	<script type="text/javascript">
		@yield('js')
	</script>

</head>
@yield('body')

</html>
