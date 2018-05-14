<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>TENGCLUB-WMS</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/aui/auicss/css/aui.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/aui/alifont/iconfont.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/aui/css/base.css') }}" />
    <script src="{{ asset('/js/jquery-3.2.1.min.js') }}"></script>
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
<body>
@yield('body')
</body>
</html>
