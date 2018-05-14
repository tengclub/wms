<?php 
$_fi = 1;
if(isset($_fmi))
{
	$_fi = $_fmi;
}

?>
    <footer class="aui-bar aui-bar-tab z-index-100" id="footer">
        <div class="aui-bar-tab-item" tapmode>
        	<a href="{{ url('wap/home/index') }}"   class="b-color-75 @if($_fi==1) aui-active @endif" >
            <i class="aui-iconfont aui-icon-home"></i>
            <div class="aui-bar-tab-label">首页</div>
            </a>
        </div>
       
        <div class="aui-bar-tab-item" tapmode>
            <a href="{{ url('wap/order/in') }}" class="b-color-75 @if($_fi==3) aui-active @endif">
            <i class="aui-iconfont iconfont icon-danju-xianxing"></i>
            <div class="aui-bar-tab-label">订单</div>
            </a>
        </div>
<!--         <div class="aui-bar-tab-item" tapmode> -->
<!--             <a href="{{ url('wap/order/out') }}" class="b-color-75 @if($_fi==3) aui-active @endif" > -->
<!--             <div class="aui-badge">99</div> -->
<!--             <i class="aui-iconfont iconfont icon-danju"></i> -->
<!--             <div class="aui-bar-tab-label">出库订单</div> -->
<!--             </a> -->
<!--         </div> -->
        <div class="aui-bar-tab-item" tapmode>
                <a href="{{ url('wap/items/index') }}" class="b-color-75 @if($_fi==5) aui-active @endif">
                <i class="aui-iconfont iconfont icon-tijikongjian-xianxing"></i>
                <div class="aui-bar-tab-label">货物</div>
            	</a>
        </div>
         <div class="aui-bar-tab-item" tapmode>
           
                <div class="aui-dot"></div>
                <a href="{{ url('wap/user/index') }}" class="b-color-75 @if($_fi==7) aui-active @endif">
                <i class="aui-iconfont aui-icon-my"></i>
                <div class="aui-bar-tab-label">我的</div>
            	</a>
        </div>
    </footer>