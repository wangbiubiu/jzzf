<!DOCTYPE html>
<html>
<head>
<title>{pg:$thisCard.cardname}</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<meta name="Keywords" content=""/>
<meta name="Description" content=""/>
<!-- Mobile Devices Support @begin -->
<meta content="application/xhtml+xml;charset=UTF-8" http-equiv="Content-Type">
<meta content="telephone=no, address=no" name="format-detection">
<meta name="apple-mobile-web-app-capable" content="yes"/>
<!-- apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
<!-- Mobile Devices Support @end -->
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/cardmain.css" rel="stylesheet" type="text/css">
<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/weui/weui.css" rel="stylesheet" type="text/css">
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>

</head>
<body onselectstart="return true;" ondragstart="return false;">
<div class="container addr_add">
    <header class="center">
        <label style="display:inline-block;">
            <span>&nbsp;</span>
            会员卡消费
        </label>
    </header>
    <div class="body">
        <div>
            <form action="" name="myform" id="Js-myform" method="post">
				<input type="hidden" name="cdid" value="{pg:$cdid}">
				<input type="hidden" name="mid" value="{pg:$mid}">
				<input type="hidden" name="openid" value="{pg:$openid}">
                <table class="table_addr">
                <tr>
				  {pg:if !empty($allmidstores)}
                    <td>
                        消费门店
                    </td>
                    <td>
                        <select name="storeid" id="storeid" class="select">
                          <option value="0">请选择商家门店</option>
						  {pg:foreach item=row from=$allmidstores}
                            <option value="{pg:$row.id}">{pg:$row.business_name}{pg:$row.branch_name}</option>
						  {pg:/foreach}
                        </select>
						 </td>
					{pg:else}
						<td>
							消费商家
						</td>
						<td>
						<input type="text" value="{pg:if !empty($merinfo.wxname)}{pg:$merinfo.wxname}{pg:else}{pg:$merinfo.weixin}{pg:/if}" readonly="readonly"/>
						</td>
					{pg:/if}
                   
					
                </tr>
				<!---
                {pg:if true}
                <tr  class="consume_show"  style="display:none;">
                    <td>
                        使用卡券
                    </td>
                    <td>
                        <select name="consume_id" id="consume_id" class="select"><option value="">请选择优惠方式</option></select>
                    </td>
                </tr>
                {pg:else}
                <tr>
                    <td>
                        使用卡券
                    </td>
                    <td>
                       
                        <input type="hidden" name="consume_id" value="">
                    </td>
                </tr>
                {pg:/if}
				

                <tr class="is_show" style="display:none;">
                    <td>
                        核销号码
                    </td>
                    <td>
                        <input type="text" name="cancel_code" id="cancel_code" value="" readonly>
                    </td>
                </tr>
				--->

                <tr>
                    <td>
                        支付方式
                    </td>
                    <td>
                        <select name="pay_type" id="pay_type" class="select">
                            <option value="0">线下支付</option>
                            <option value="1" selected="selected">会员卡余额支付</option>
                        </select>
                    </td>
                </tr>
				 <tr id="vipbalance" style="display:none;">
                    <td>
                        卡余额
                    </td>
                    <td style="color:green;height: 30px;">
						<span>{pg:$UserInfo.balance}</span> 元
                    </td>
                </tr>

                <tr>
                    <td>
                        消费金额
                    </td>
                    <td>
                        <input type="text" value="" name="price" id="price" placeholder="请输入实际消费金额"/>
                    </td>
                </tr>

             	<tr id="vippaypwd" style="display:none;">
                    <td>
                        支付密码
                    </td>
                    <td>
						<input type="password" value="" name="paypwd" id="paypwd" placeholder="请输入支付密码"/>
                    </td>
                </tr>

                <tr id="offpay">
                    <td colspan="2" style="padding:0;">
                        <table width="100%" class="type1">
                            <tr>
                                <td>
                                    店员用户名
                                </td>
                                <td>
                                    <input type="text" value="" name="username" class="username" id="username" placeholder="请输入商家店员用户名"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    店员密码
                                </td>
                                <td>
                                    <input type="password" value="" name="password" id="password" placeholder="请输入店员密码"/>
                                </td>
                            </tr>
                            <tr>

                            </tr>
                        </table>
                    </td>
                </tr>

                </table>
            </form>
        </div>
        <div class="pt_10 pb_10 pl_10 pr_10">
            <a href="javascript:void(0);" class="button">提&nbsp;&nbsp;&nbsp;交</a>
        </div>
    </div>
</div>

{pg:include file="$tplHome/Wap/public/cardfooter.tpl.php"}
<script>
$(function(){
 
    if($('#pay_type').val() == 1){
        $('.type1').css('display','none');
		$('#vipbalance,#vippaypwd').css('display','table-row');
    }else{
		$('#vipbalance,#vippaypwd').css('display','none');
        $('.type1').css('display','table');
    }

   /* $('#storeid').change(function(){
        var company_id = $(this).val();
        var submitData = {
            company_id:company_id,
        };
        $.post("", submitData,
        function(data) {
            if (data.err == 0) {
                if (data.res.length > 0) {
                    var html   = '<option value="">点击选择优惠方式</option>';
                    for (var i = data.res.length - 1; i >= 0; i--) {
                        html += '<option value="'+data.res[i]['id']+'" cancel-code="'+data.res[i]['cancel_code']+'">'+data.res[i]['coupon_name']+'</option>';
                    };
                    $("#consume_id").html(html); 
                    $('.consume_show').show();
                }
            }
        }, "json");
    });*/

    $('#pay_type').change(function(){
        if($(this).val() == 0){
            $('.type1').css('display','table');
			$('#vipbalance,#vippaypwd').css('display','none');
			
        }else if($(this).val() == 1){
            $('.type1').css('display','none');
			$('#vipbalance,#vippaypwd').css('display','table-row');
        }
    });
    
    $('.button').click(function(){
        //var coupon_type = $('#coupon_type').val();
        var price    = $('#price').val();
        var pay_type = $('#pay_type').val();
		pay_type=parseInt(pay_type);
        var username = $.trim($('#username').val());
        var pwd      = $.trim($('#password').val());
        //var consume_id = $('#consume_id').val();
        var storeid = 0;
        //var cancel_code = $('#cancel_code').val();
        var prg     = /^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/;
        
        if($('#storeid').size() >0){
			 storeid=$.trim($('#storeid').val());
			 if(!(storeid>0)){
				 $('#dialogalert .weui_dialog_bd').html('请选择消费门店').css('color','red');
				 $('#dialogalert').show();
				 return false;
			 }
        }
		if(!prg.test(price)){
			$('#dialogalert .weui_dialog_bd').html('请填写正确的消费金额').css('color','red');
			$('#price').focus();
			$('#dialogalert').show();
			return false;
        }
		if(pay_type==0){
            if(!username){
				$('#dialogalert .weui_dialog_bd').html('请填写商家用户名').css('color','red');
				$('#dialogalert').show();
				return false;
            }
            if(!pwd){
				$('#dialogalert .weui_dialog_bd').html('请填写商家密码').css('color','red');
				$('#dialogalert').show();
				return false;
            }   
        }else{
		   var paypwd=$.trim($('#paypwd').val());
		   if(!paypwd){
		    	$('#dialogalert .weui_dialog_bd').html('支付密码不能为空！').css('color','red');
				$('#dialogalert').show();
				return false;   
		   }
		
		}

            $('#Js-myform').submit();
    });
    
   /* $('.table_addr').on('change','#consume_id',function(){
        var cancel_code =  $(this).children('option:selected').attr('cancel-code');
        $('#cancel_code').val(cancel_code);
        $('.is_show').show();
    });*/

});
</script>
</body>
</html>