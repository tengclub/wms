@extends('layouts.mainBody')
@section('bodyOption')
 class="body" style="height: 100%; margin: 0"
@endsection
@section('hf') 
	<script type="text/javascript" src="{{ asset('/js/echarts.min.js') }}"></script>
@endsection
@section('content')
<div class="layui-row layui-col-space10 my-index-main">

<!-- 为ECharts准备一个具备大小（宽高）的Dom -->

    <div id="main" style="width:98%;height:800px"></div>
    <script type="text/javascript">
 // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));
    
    
	option = {
		tooltip: {
			show: true,
			formatter: function (params) {
			    // 假设此轴的 type 为 'time'。
			    return params.name;
			}
		},
		series: [{
			type: 'treemap',
			visibleMin: 300,
			label: {
				show: true,
				formatter: '{b}'
			},
	          itemStyle: {
	              normal: {
	                  borderColor: '#fff'
	              }
	          },
    	        data: {!!$data!!}
    	    }]
    	};

    myChart.setOption(option);
    </script>


   
@endsection

