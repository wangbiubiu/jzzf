<!DOCTYPE html>
<html>
	<head>
		<title>补单处理</title>
		{pg:include file="$tplHome/System/public/header.tpl.php"}
		
		<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
		<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
		<link href="{pg:$smarty.const.RlStaticResource}plugins/css/iCheck/custom.css" rel="stylesheet">
		<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
		<style>
		
.payment_allocation h1 {
	font-size: 18px;
	border-bottom: 1px solid #d9e6e9;
	border-top: 3px solid #edfbfe;
	background: #FFFFFF;
	height: 40px;
	line-height: 40px;
	padding: 0px 20px; 
	margin-bottom: 0px;
}
#or{width: 200px;}
.payment_allocation>div{ background: #FFFFFF;padding: 10px;}
.payment_allocation>div>form{
	border: 1px solid #f2f2f2;
	position: relative;
}
.payment_allocation>div>form{ margin-bottom: 20px;}
.payment_allocation>div>form:nth-child(2){ margin-bottom: 60px;}
.payment_allocation>div>form>h2{ height: 40px; line-height: 40px; font-size: 16px; font-weight: normal; background: #f2f2f2; margin-top: 0px; margin-bottom: 0px; padding-left: 20px;}
.payment_allocation>div>form>div{border-top: 1px solid #f2f2f2; height: 50px; line-height: 50px;}
.payment_allocation>div>form>div>input{ height: 25px; line-height: 25px;}
.payment_allocation>div>form>div>input:nth-child(3){margin-top: 3px; border: none; border-radius: 2px; color: #FFFFFF; background: #3E94DB;}
.payment_allocation>div>form>input{height: 30px; line-height: 30px; position: absolute; bottom: -50px; left: 50%; margin-left: -35px;border: none; border-radius: 2px; color: #FFFFFF; background: #3E94DB;}
.payment_allocation>div>form>div>label{ display: inline-block; width: 100px; text-align: right; margin-right: 10px;}
</style>
		<script src="{pg:$smarty.const.RlStaticResource}plugins/js/footable/footable.all2.min.js"></script>
	</head>

	<body>
		<div id="wrapper">
			{pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
			
			<div id="page-wrapper" class="gray-bg">
				{pg:include file="$tplHome/System/public/top.tpl.php"}
				
				<div class="row wrapper border-bottom white-bg page-heading">
					<div class="col-lg-10">
						<h2>补单处理</h2>
						<ol class="breadcrumb">
							<li>
								<a>
									User
								</a>
							</li>
							
							<li class="active">
								<strong>补单处理</strong>
							</li>
						</ol>
					</div>
					<div class="col-lg-2"></div>
				</div>
				<div class="wrapper wrapper-content animated fadeInRight" >
					<div class="row payment_allocation">
						<h1>补充订单 </h1>
						<div>
                                                        <form action="merchants.php?m=System&c=order&a=index" method="post">
								<h2>订单查询</h2>
                                                               
								<div>
									<label>订单号</label>
                                                                        <input type="text" id="or" name="order_id"  placeholder="输入需要查询的订单号" onkeyup="this.value=this.value.replace(/\D/g,'')"/>
									<input type="submit" value="确定查询">
								</div>
							</form>
							
							<form>
								<h2>订单详情</h2>
								<div>
									<label>订单号:</label>
									<span>{pg:$order.order_id}</span>
								</div>
								<div>
									<label>支付总金额:</label>
									<span>{pg:$order.goods_price}</span>
								</div>
								<div>
									<label>支付状态:</label>
									<span>{pg:if $order.ispay==1}支付成功{pg:elseif $order.ispay=='0'}支付失败{pg:/if}</span>
								</div>
								<div>
									<label>支付时间:</label>
									<span>{pg:$order.add_time}</span>
								</div>
                                                                    
                                                                <input type="button" class="sub" value="申请补单">
									
								
							</form>
							
						</div>
					</div>
						
					<!--
                    	作者：2721190987@qq.com
                    	时间：2016-10-25
                    	描述：二维码弹出框
                    -->	
								
						
					</div>
				</div>
			</div>
		</div>
	

	</body>
	<script>

	
$('.sub').click(function(){
            var order_id = {pg:$order.order_id};//$('#order_id').val();
            var ispay = {pg:$order.ispay};
            if(!order_id){
                return false;
            }
            if(ispay==1){
                swal('订单已支付成功!','','error');
                return false;
            }
            $.post('/merchants.php?m=System&c=order&a=ajaxispay',{order_id:order_id},function(re){
                if(re.code==1){
                    swal({
                        title: "补单成功!",
                        text: '',
                        type: "success",
                        closeOnConfirm: false
                    }, function () {
                        location.reload();
                    });
                }else{
                    swal('补单失败!','','error');
                }
            },'json');
        })
	
	</script>
	<!-- iCheck -->
	<script src="{pg:$smarty.const.RlStaticResource}plugins/js/iCheck/icheck.min.js"></script>
</html>