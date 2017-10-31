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

.notice_nr_tit{ text-align: center; border-bottom: 1px  dashed #f2f2f2; padding-top: 30px;}
.notice_nr_tit p{ margin-bottom: 10px; font-size: 18px; color: #36a9e0;}
.notice_nr_tit p span{font-size: 14px; color: #cccccc;}
.notice_nr_zt{ max-width: 530px; margin: 20px auto;}
.notice_nr_zt div{ margin: 10px 0;}
.notice_nr_zt div h4{ font-size: 18px;}
.notice_nr_zt div p{font-size: 14px;}
</style>
<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/managerleft.tpl.php';?>
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
                            <a>首页</a>
                        </li>
                        <li>
                            <a>公告</a>
                        </li>
                        <li class="active">
                            <strong>详情</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight" >
 
              	<div class="notice_nr" style="background: #FFFFFF; width: 100%; padding-bottom: 30px; margin-top: 30px;">
              		<div class="notice_nr_tit">
              			<p><?php echo $row['title'];?></p>
              			<p><span>来源：<?php echo $row['source']?></span>&nbsp&nbsp&nbsp<span>时间：<?php echo date('Y-m-d H:i:s',$row['addtime']); ?></span></p>
              		</div>
              		<div class="notice_nr_zt">
              			<?php echo htmlspecialchars_decode($row['content']); ?>
              		</div>
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