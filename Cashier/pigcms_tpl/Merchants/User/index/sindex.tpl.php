<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首页</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	
</head>
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
.transaction>div{float: left; width: 50%;}
.transaction>div:first-child{
	border-right:1px solid #e1e4e9;
	box-sizing: border-box;
}
.transaction>div>p{ text-align: center; height: 40px; line-height: 40px;color: #565656;font-size: 18px; border-bottom: 1px solid #e1e4e9; background: #f5f5f6;}
.transaction>div>div>p{ text-align: center; margin-top: 30px; margin-bottom: 20px;font-size: 14px; color: #8A8A8A;}
.transaction>div>div>p>span{font-size: 18px; color: #000000; margin: 0 10px;}

.journal li{ margin-top: 10px;}
.journal li a{ color: #58a7e3;font-size: 14px; display: block}
.journal li a span{color: #676a6c; display: inline-block;}
.journal li a span i{color: #58a7e3;font-style:normal;}
.journal li a span:first-child{ margin-right: 50px; width: 50%; overflow: hidden;text-overflow:ellipsis; }
</style>
<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>首页</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Index</a>
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
              	<div style="background: #FFFFFF; width: 100%; padding-bottom: 10px;">
              		<p style="width: 100%; border-bottom: 1px solid #d9e6e9; text-align: left; height: 40px; line-height: 40px; padding-left: 10px; border-top: 4px solid #edfbfe;">交易统计</p>
              		<div class="transaction clearfix">
              			<div>
              				<p>昨日交易</p>
              				<div>
              					<p>金额/笔数</p>
              					<p><span><?php echo $money; ?>元</span><span><?php echo $number; ?>笔</span></p>
              				</div>
              			</div>
              			<div>
              				<p>今日交易</p>
              				<div>
              					<p>金额/笔数</p>
              					<p><span><?php echo $money2; ?>元</span><span><?php echo $number2; ?>笔</span></p>
              				</div>
              			</div>
              		</div>
              	</div>
           		
           		<div style="background: #FFFFFF; width: 100%; padding-bottom: 10px; margin-top: 20px;">
              		<p style="width: 100%; border-bottom: 1px solid #d9e6e9; text-align: left; height: 40px; line-height: 40px; padding-left: 10px; border-top: 4px solid #edfbfe;">系统公告</p>
              		<ul class="journal">
                            <?php foreach($notice as $v){ ?>
              			<li><a href="?m=User&c=index&a=notice&id=<?php echo $v['id']?>"><span><i>></i><?php  echo $v['title']?></span><span>[<?php  echo date('Y-m-d',$v['addtime'])?>]</span></a></li>
                            <?php  }?>
              		</ul>
              	</div>
           		
            </div>
            </div>
        </div>
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
</body>
<script type = "text/javascript">
	if(navigator.userAgent.indexOf("AlipayClient")!=-1){
	    $('#shuakahah').attr('href','/merchants.php?m=User&c=alicashier&a=alipayment&type=1');
		$('#shuakaaha').attr('href','/merchants.php?m=User&c=alicashier&a=index');
	}
</script>
</html>