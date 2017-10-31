<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>账户设置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link href="<?php echo $this->RlStaticResource;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo RL_PIGCMS_STATIC_PATH;?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/animate_new.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/style.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/app.css" rel="stylesheet">
    <!-- Mainly scripts -->
    <script src="<?php echo $this->RlStaticResource;?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/Cashier/pigcms_static/plugins/layer/layer.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>js/inspinia.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/pace/pace.min.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/jquery.qrcode.min.js"></script>
    <!----开放式头部，请在自己的页面加上--</head>-->
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
    <script src="https://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
    <style type="text/css">
        body{padding: 0;margin: 0;font-size: 14px;background-color: #fff;color:#333;}
        a{text-decoration: none;}
        input[type='text']{width: 100%;height: 30px;border: none;text-indent: 10px;}
    </style>
</head>
<body>
<!--<div style="width: 100%;height: 50px;line-height: 50px;background-color: #008fd3;">
    <a href="/merchants.php?m=User&c=index&a=sindex" onclick="" style="color:#fff;padding:0 20px 0 10px;display: inline-block;">< 返回</a>
</div>
<div id="bg" style="width: 100%;height: 1000px;background-color: rgba(0,0,0,0.5);position: fixed;top: 0;z-index: 3;display: none;left: 0;" onclick="$('#sx').animate({left:'-85%'},'fast');$('#bg').fadeOut();">
</div>
<div style="position: fixed;width: 85%;height: 1000px;background-color: #fefefe;top: 0;left:-85%;z-index: 4;box-shadow: 0 0 5px #eee;" id="sx">
    <div style="width: 100%;text-align: right;line-height: 49px;border-bottom: 1px solid #efefef;">
        <a href="javascript:;" onclick="$('#sx').animate({left:'-85%'});$('#bg').fadeOut();" style="margin-right: 10px;color:#333;display: inline-block;">关闭筛选</a>
    </div>
    <div style="padding: 10px;">
        <form method="get" action="/merchants.php?m=User&c=manager&a=myOrders">
            <input type="hidden" value="User" name="m" >
            <input type="hidden" value="staff" name="c" >
            <input type="hidden" value="myOrders" name="a" >
            <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id" >
            <div>支付方式</div>
            <div style="margin: 10px 0 20px;">
                <select name="type" style="width: 100%;height: 40px;text-indent: 10px;border: 1px solid #efefef;">
                    <option value="">全部</option>
                    <option value="weixin" <?php if($_GET['type'] == "weixin"){echo 'selected="selected"';} ?>>微信</option>
                    <option value="alipay" <?php if($_GET['type'] == "alipay"){echo 'selected="selected"';} ?>>支付宝</option>
                </select>
            </div>
            <div>选择日期</div>
            <div style="margin: 10px 0;">
                <input type="text" value="<?php if(isset($getdata['start'])) echo $getdata['start'];?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style="text-indent: 0;text-align: center; padding:5px 10px;margin-bottom: 0px; width: 40%;border: 1px solid #efefef;height: 40px;display: inline-block;">
                <span style="width: 15%;display: inline-block;text-align: center;">到</span>
                <input type="text" value="<?php if(isset($getdata['end'])) echo $getdata['end'];?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style="text-indent: 0;text-align: center; padding:5px 10px;margin-bottom: 0px; width: 40%;border: 1px solid #efefef;height: 40px;display: inline-block;">
            </div>
            <div style="margin-top: 30px;text-align: center;">
                <input type="submit" value="搜索" style="width: 50%;height: 40px;border: none;color:#fff;background-color: #008fd3;"/>
            </div>
        </form>
    </div>
</div>-->
<div style="width: 100%;height: 50px;line-height: 50px;border-bottom: 1px solid #efefef;background-color: #008fd3;">
    <!--    <a href="javascript:;" onclick="$('#bg').fadeIn();$('#sx').animate({left:'0%'});" style="color:#333;padding:0 20px 0 10px;display: block;float:left;">筛选</a>-->
    <a href="/merchants.php?m=User&c=staff&a=index" onclick="" style="padding:0 20px 0 10px;display: block;float:left;color:#fff;">< 返回</a>
<!--    <a href="/merchants.php?m=User&c=manager&a=CashierCount" onclick="" style="padding:0 10px 0 20px;display: block;float:right;color:#fff;">全部收银员</a>-->
</div>
<div style="padding:15px 10px;border-bottom: 1px solid #efefef;">
    <?php  if($getdata['type']=='weixin'){?>
        <div style="width: 49%;float:left;text-align: center;border-right: 1px solid #efefef;">
            <div style="margin-bottom: 5px;font-size: 24px;color:#008fd3;"><?php echo sprintf("%.2f",$weixin);?></div>
            <div style="color:#999;">收款金额（元）</div>
        </div>
        <div style="width: 49%;float:right;text-align: center;">
            <div style="margin-bottom: 5px;font-size: 24px;color:#008fd3;"><?php echo sprintf("%.2f",$weixin_income);?></div>
            <div style="color:#999;">实收金额（元）</div>
        </div>
    <?php  }elseif($getdata['type']=='alipay'){?>
        <div style="width: 49%;float:left;text-align: center;border-right: 1px solid #efefef;">
            <div style="margin-bottom: 5px;font-size: 24px;color:#008fd3;"><?php echo sprintf("%.2f",$alipay);?></div>
            <div style="color:#999;">收款金额（元）</div>
        </div>
        <div style="width: 49%;float:right;text-align: center;">
            <div style="margin-bottom: 5px;font-size: 24px;color:#008fd3;"><?php echo sprintf("%.2f",$alipay_income);?></div>
            <div style="color:#999;">实收金额（元）</div>
        </div>
    <?php  }else{?>
        <div style="width: 49%;float:left;text-align: center;border-right: 1px solid #efefef;">
            <div style="margin-bottom: 5px;font-size: 24px;color:#008fd3;"><?php echo sprintf("%.2f",$total);?></div>
            <div style="color:#999;">收款金额（元）</div>
        </div>
        <div style="width: 49%;float:right;text-align: center;">
            <div style="margin-bottom: 5px;font-size: 24px;color:#008fd3;"><?php echo sprintf("%.2f",$total_income);?></div>
            <div style="color:#999;">实收金额（元）</div>
        </div>
    <?php  }?>
    <div style="clear: both;"></div>
</div>
<div style="padding: 10px;border-bottom: 1px solid #efefef;">
    <form method="get" action="/merchants.php?m=User&c=staff&a=myOrders">
        <input type="hidden" value="User" name="m" >
        <input type="hidden" value="staff" name="c" >
        <input type="hidden" value="myOrders" name="a" >
        <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id" >
        <div style="padding: 10px 0;">
            <div style="width: 20%;float:left;line-height: 30px;">选择日期</div>
            <div style="width: 80%;float:right;">
                <input type="text" readonly="readonly" value="<?php if(isset($getdata['start'])){echo $getdata['start'];}else{echo date('Y-m-d');}?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style="text-indent: 0;text-align: center; padding:5px 10px;margin-bottom: 0px; width: 40%;border: 1px solid #efefef;height: 30px;display: inline-block;">
                <span style="width: 15%;display: inline-block;text-align: center;">到</span>
                <input type="text" readonly="readonly" value="<?php if(isset($getdata['end'])){echo $getdata['end'];}else{echo date('Y-m-d');}?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style="text-indent: 0;text-align: center; padding:5px 10px;margin-bottom: 0px; width: 40%;border: 1px solid #efefef;height: 30px;display: inline-block;">
            </div>
            <div style="clear: both;"></div>
        </div>
        <div style="padding: 0 0 10px;">
            <div style="width: 20%;float:left;line-height: 30px;">支付方式</div>
            <div style="width:80%;float:right;">
                <select name="type" style="width: 50%;height: 30px;text-indent: 10px;border: 1px solid #efefef;">
                    <option value="">全部</option>
                    <option value="weixin" <?php if($_GET['type'] == "weixin"){echo 'selected="selected"';} ?>>微信</option>
                    <option value="alipay" <?php if($_GET['type'] == "alipay"){echo 'selected="selected"';} ?>>支付宝</option>
                </select>
                <input type="submit" value="搜索" style="width: 30%;height: 30px;border: none;color:#fff;background-color: #008fd3;"/>
            </div>
            <div style="clear: both;"></div>
        </div>
    </form>
</div>
<div style="padding:0 10px;">
    <style type="text/css">
        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9{
            padding: 0;;
        }
        input[type='text']{border: 1px solid #eee;;height: auto;width: auto;}
        .pagination{margin: 0 0 20px;}
    </style>
    <table border="1" class="payment1" style="margin: 20px 0 20px 0;text-align: center;" width="100%" bordercolor="#e0e0e0">
        <tbody>
        <tr style="height: 40px;">
            <th style="text-align: center;">应收金额</th>
            <th style="text-align: center;">实收金额</th>
            <th style="text-align: center;">交易时间</th>
            <th style="text-align: center;">交易类型</th>
            <?php if($this->employer['is_refund'] > 0){?>
                <th style="text-align: center;">操作</th>
            <?php }?>

        </tr>
        <?php
        if(!empty($neworder)){
            foreach($neworder as $v){
                ?>
                <tr style="height: 40px;">
                    <td><?php echo $v['goods_price'] ?></td>
                    <td><?php echo $v['income']?></td>
                    <td style="font-size: 12px;"><?php echo date('Y-m-d',$v['paytime'])."<br/>";echo date('H:i:s',$v['paytime']);?></td>
                    <td><?php if($v['pay_way']=='weixin'){ echo '微信支付';}elseif($v['pay_way']=='alipay'){echo '支付宝';}?></td>
                    <?php if($this->employer['is_refund'] > 0){?>
                        <?php if($v['refund'] != '2'){ ?>
                            <td><button class="btn btn-sm"  data-val="<?php echo $v['goods_price'];?>" style="background: #008000;color: #FFF;" onclick="<?php if($v['pay_way']=='weixin'){echo 'wx';}elseif($v['pay_way']=='alipay'){echo 'ali';}?>RefundBtn(this,<?php echo $v['id'];?>,<?php echo $v['mid'];?>);"><strong> 退&nbsp;&nbsp;&nbsp;款 </strong></button> </td>
                        <?php  }else{ ?>
                            <td><button class="btn btn-sm btn-success btn-st"><strong> 已退款 </strong></button></td>
                        <?php } ?>

                    <?php }?>
                </tr>
            <?php }}else{?>
            <tr class="widget-list-item" style="height: 40px;"><td colspan="11">暂无订单</td></tr>
        <?php }?>
        </tbody>
    </table>
    <?php echo $pagebar;?>
</div>
<script src="/Cashier/pigcms_static/plugins/cashier/commonfunc.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.input-sm').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            format: "yyyy-mm-dd",
            autoclose: true
        });
        $('#datepicker .input-sm').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            format: "yyyy-mm",
            autoclose: true
        });
    });
</script>
</body>
</html>