<div class="weui_dialog_confirm" id="dialogconfirm" style="display: none;">
	<div class="weui_mask"></div>
	<div class="weui_dialog">
		<div class="weui_dialog_hd"><strong class="weui_dialog_title">温馨提示</strong></div>
		<div class="weui_dialog_bd">自定义弹窗内容，居左对齐显示，告知需要确认的信息等</div>
		<div class="weui_dialog_ft">
			<a href="javascript:;" class="weui_btn_dialog default">取消</a>
			<a href="javascript:;" class="weui_btn_dialog primary">确定</a>
		</div>
	</div>
</div>

<div class="weui_dialog_alert" id="dialogalert" style="display: none;">
	<div class="weui_mask"></div>
	<div class="weui_dialog">
		<div class="weui_dialog_hd"><strong class="weui_dialog_title">温馨提示</strong></div>
		<div class="weui_dialog_bd">弹窗内容，告知当前页面信息等</div>
		<div class="weui_dialog_ft">
			<a href="javascript:;" class="weui_btn_dialog primary">确定</a>
		</div>
	</div>
</div>

<div id="toast" style="display: none;">
	<div class="weui_mask_transparent"></div>
	<div class="weui_toast">
		<i class="weui_icon_toast"></i>
		<p class="weui_toast_content">已完成</p>
	</div>
</div>

{pg:if ($route_Action!='userInfo')}
<footer>
    <nav class="nav">
        <ul class="box">
            <li>
                <a href="/merchants.php?m=Wap&c=vcard&a=index&mid={pg:$mid}&cdid={pg:$cdid}&openid={pg:$openid}" class="{pg:if ($route_Action=='index')}on{pg:/if}">
                    <p class="share"></p>
                    <span>
                        领卡/
                        换卡
                    </span>
                </a>
            </li>
            <li>
                <a href="/merchants.php?m=Wap&c=vcard&a=mycard&mid={pg:$mid}&cdid={pg:$cdid}&openid={pg:$openid}" class="{pg:if ($route_Action=='mycard')}on{pg:/if}">
                    <p class="card"></p>
                    <span>会员卡</span>
                </a>
            </li>
            <li>
                <a href="/merchants.php?m=Wap&c=vcard&a=mycenter&mid={pg:$mid}&cdid={pg:$cdid}&openid={pg:$openid}" class="{pg:if ($route_Action=='mycenter')}on{pg:/if}" >
                    <p class="my"  ></p>
                    <span>我的</span>
                </a>
            </li>
            <li>
                <a href="/merchants.php?m=Wap&c=vcard&a=notice&mid={pg:$mid}&cdid={pg:$cdid}&openid={pg:$openid}" class="{pg:if ($route_Action=='notice')}on{pg:/if}">
                    <p id="Js-msg-num" class="msg" data-count="1" ></p>
                    <span>消息</span>
                </a>
            </li>
            <li>
                <a href="/merchants.php?m=Wap&c=vcard&a=perSign&mid={pg:$mid}&cdid={pg:$cdid}&openid={pg:$openid}" class="{pg:if ($route_Action=='perSign')}on{pg:/if}">
                    <p class="sign"></p>
                    <span>签到</span>
                </a>
            </li>
        </ul>
    </nav>
</footer>
{pg:/if}

  <div class="window" id="windowcenter" style="margin-top:50px;">
    <div class="tip">
      <div id="txt"></div>
    </div>
  </div>

<script type="text/javascript">
$('#dialogalert .primary').click(function(){
   $('#dialogalert').hide();
   $('#dialogalert .weui_dialog_bd').html('');
});

$('#dialogconfirm .default').click(function(){
   $('#dialogconfirm').hide();
   $('#dialogconfirm .weui_dialog_bd').html('');
});

function myalert(title){ 
	$("#windowcenter").slideToggle("slow"); 
	$("#txt").html(title);
	setTimeout(function(){
		$("#windowcenter").slideUp(500)
	},3000);
} 

</script>