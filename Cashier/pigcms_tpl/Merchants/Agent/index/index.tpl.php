<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>代理商|首页</title>
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
                            <a>Agent</a>
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
                <div style="background: #FFFFFF; width: 100%; padding-bottom: 30px;">
                    <p style="width: 100%; border-bottom: 1px solid #d9e6e9; text-align: left; height: 40px; line-height: 40px; padding-left: 10px; border-top: 4px solid #edfbfe;">交易统计</p>
                    <div class="transaction clearfix">
                        <div style="width: 25%;">
                            <p>昨日交易</p>
                            

                            <div>

                                <p>金额/笔数</p>
                                <p><span><?php if (empty($LastDayDeal['sum'])) {echo 0;}else{echo $LastDayDeal['sum'];} ?>元</span><span><?php if (empty($LastDayDeal['num'])) {echo 0;}else{echo $LastDayDeal['num'];} ?>笔</span></p>
                            </div>
                        </div>
                        <div style="width: 25%;">
                            <p>今日交易</p>
                            <div>
                                <p>金额/笔数</p>
                                <p><span><?php if (empty($TodayDeal['sum'])) {echo 0;}else{echo $TodayDeal['sum'];} ?>元</span><span><?php if (empty($TodayDeal['num'])) {echo 0;}else{echo $TodayDeal['num'];} ?>笔</span></p>
                            </div>
                        </div>
                        <div class="cumulative" style="width: 50%;">
                            <p>月累计交易</p>
                            <div class="clearfix">
                                <div>
                                    <p>月累计交易金额</p>
                                    <p><span><?php if (empty($AllDeal['sum'])) {echo 0;}else{echo $AllDeal['sum'];} ?>元</span></p>
                                </div>
                                <div>
                                    <p>月累计交易笔数</p>
                                    <p><span><?php if (empty($AllDeal['num'])) {echo 0;}else{echo $AllDeal['num'];} ?>笔</span></p>
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
                                <p><span><?php echo $merchantNum;?></span></p>
                            </div>
                        </div>
                        <div style="width: 50%;">
                            <p>门店数量</p>
                            <div>
                                <p><span><?php echo $storeNum;?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div style="background: #FFFFFF; width: 100%; padding-bottom: 10px; margin-top: 20px;">
                    <p style="width: 100%; border-bottom: 1px solid #d9e6e9; text-align: left; height: 40px; line-height: 40px; padding-left: 10px; border-top: 4px solid #edfbfe;">系统公告</p>
                    <ul class="journal">
                    <?php foreach ($notice as $nk => $nvv): ?> 
                        <li><a href="?m=Agent&c=index&a=notice&nid=<?php echo $nvv['id']; ?>"><span><i>></i><?php echo $nvv['title']; ?></span><span>[<?php echo date('Y-m-d',$nvv['addtime']); ?>]</span></a></li>
                     <?php endforeach ?>
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