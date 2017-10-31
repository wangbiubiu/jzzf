<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>总后台 | 首页</title>
	{pg:include file="$tplHome/System/public/header.tpl.php"}
	<link href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RlStaticResource}plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="{pg:$smarty.const.RL_PIGCMS_STATIC_PATH}plugins/css/footable/footable.core.css" rel="stylesheet">
	<style>
        .clearfix:after {
                height: 0;
                content: " ";
                display: block;
                overflow: hidden;
                clear: both;
        }
        .clearfix {
                zoom: 1;/*IE低版本浏览器不支持after伪类所以要加这一句*/
        }
        ul li{ list-style: none;}
        a{text-decoration: none;}
        .transaction{ width: 90%; margin: 0px auto; border: 1px solid #e1e4e9;}
        .transaction>div{float: left;}
        .transaction>div:first-child{
                border-right:1px solid #e1e4e9;
                box-sizing: border-box;
        }
        .transaction>div:nth-child(2){
                border-right:1px solid #e1e4e9;
                box-sizing: border-box;
        }
        .transaction>div>p{ text-align: center; height: 40px; line-height: 40px;color: #565656;font-size: 18px; border-bottom: 1px solid #e1e4e9; background: #f5f5f6; margin-bottom: 0px;}
        .transaction>div>div>p{ text-align: center; margin-top: 30px; margin-bottom: 20px;font-size: 14px; color: #8A8A8A;}
        .transaction>div>div>p>span{font-size: 18px; color: #000000; margin: 0 10px;}

        .journal li{ margin-top: 10px;}
        .journal li a{ color: #58a7e3;font-size: 14px; display: block}
        .journal li a span{color: #676a6c; display: inline-block;}
        .journal li a span i{color: #58a7e3;font-style:normal;}
        .journal li a span:first-child{ margin-right: 50px; width: 50%; overflow: hidden;text-overflow:ellipsis; }

        .cumulative>div>div{float: left; width: 50%; text-align: center;}
        .cumulative>div>div:first-child{border-right: 1px solid #f2f2f2;}
        .cumulative>div>div>p{margin-top: 30px; margin-bottom: 20px;font-size: 14px; color: #8A8A8A;}
        .cumulative>div>div>p>span{font-size: 18px; color: #000000; margin: 0 10px;}
        </style>    
</head>


<body>
    <div id="wrapper">
	{pg:include file="$tplHome/System/public/leftmenu.tpl.php"}
        <div id="page-wrapper" class="gray-bg dashbard-1">
	{pg:include file="$tplHome/System/public/top.tpl.php"}
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>管理后台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="#">System</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>首页</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight" >
              	<div style="background: #FFFFFF; width: 100%; padding-bottom: 30px;">
              		<p style="width: 100%; border-bottom: 1px solid #d9e6e9; text-align: left; height: 40px; line-height: 40px; padding-left: 10px; border-top: 4px solid #edfbfe;">交易统计</p>
              		<div class="transaction clearfix">
              			<div style="width: 25%;">
              				<p>昨日交易</p>
              				<div>
              					<p>金额/笔数</p>
              					<p><span>{pg: $money }元</span><span>{pg: $number }笔</span></p>
              				</div>
              			</div>
              			<div style="width: 25%;">
              				<p>今日交易</p>
              				<div>
              					<p>金额/笔数</p>
              					<p><span>{pg: $money2 }元</span><span>{pg: $number2 }笔</span></p>
              				</div>
              			</div>
              			<div class="cumulative" style="width: 50%;">
              				<p>月累计交易</p>
              				<div class="clearfix">
              					<div>
		              				<p>月累计交易金额</p>
		              				<p><span>{pg:$total_money}元</span></p>
		              			</div>
		              			<div>
		              				<p>月累计交易笔数</p>
		              				<p><span>{pg:$total_num}笔</span></p>
		              			</div>
              				</div>
              			</div>

              		</div>
              	</div>
              	
              	<!--
                  	作者：2721190987@qq.com
                  	时间：2016-10-21
                  	描述：商家统计
                  -->
              	<div style="background: #FFFFFF; width: 100%; padding-bottom: 30px; margin-top: 30px;">
              		<p style="width: 100%; border-bottom: 1px solid #d9e6e9; text-align: left; height: 40px; line-height: 40px; padding-left: 10px; border-top: 4px solid #edfbfe;">门店统计</p>
              		<div class="transaction clearfix">
              			<div style="width: 50%;">
              				<p>商户数量</p>
              				<div>
								<p><span>{pg:$m_num}</span></p>
              				</div>
              			</div>
              			<div style="width: 50%;">
              				<p>门店数量</p>
              				<div>
              					<p><span>{pg:$s_num}</span></p>
              				</div>
              			</div>
              		</div>
              	</div>
           		
           		<div style="background: #FFFFFF; width: 100%; padding-bottom: 10px; margin-top: 20px;">
              		<p style="width: 100%; border-bottom: 1px solid #d9e6e9; text-align: left; height: 40px; line-height: 40px; padding-left: 10px; border-top: 4px solid #edfbfe;">系统公告<a href="/merchants.php?m=System&c=index&a=addNotice" style="color: #008fd3;padding-right: 10px; float: right;">+添加公告</a></p>
              		<ul class="journal">
                            {pg: foreach item=v from=$notice }
                            <li class="clearfix" style=" position: relative">
                                <a  href="/merchants.php?m=System&c=index&a=notice&id={pg:$v.id}">
                                    <span><i>></i>{pg:$v.title}</span>
                                    <span style="height: 40px;line-height: 40px">[{pg:$v.addtime}]</span>
                                </a><a href="#" data-id ="{pg:$v.id}"  class="del" style=" position: absolute; right: 20px; top: 10px">删除</a>
                            </li>
                            {pg: /foreach}
              		</ul>
              	</div>

            </div>
            </div>
        </div>

  
   {pg:include file="$tplHome/System/public/footer.tpl.php"}
</body>

</html>
<script>
    $('.del').click(function(){
       var id = $(this).attr('data-id');
         $.post('?m=System&c=index&a=delNotice',{id:id},function(reg){
            if(reg.code==1){               
                 swal({
                    title: "删除成功",
                    text: '',
                    type: "success"
            }, function () {
                    window.location.reload();
                    });
            }else{
                swal("删除失败", '' , "error");
            }
        },'json');
    })
</script>