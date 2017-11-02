<?php //var_dump($merchants);exit; ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>代理商|商户统计</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
    <link   href="http://cashier.b0.upaiyun.com/pigcms_static/plugins/css/datapicker/datepicker3.css" rel="stylesheet">
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<script
    src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
<!-- Data picker -->
<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
</head>

<style>
button{ color:#ffffff}
#commonpage{
        float: right;
    margin-top: 20px;
}
#commonpage>div{float: right;}
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
    .tit ul li{ float:left; font-size: 12px; padding: 0 20px; height: 40px; line-height: 40px;}
    .tit ul li a{color: #BDBDBD ; display: inline-block;}
    .tit ul li:hover{ background: #FFFFFF;}
    .tit ul li:hover a{ color: #000000 !important;}
    
    .content{background: #FFFFFF;}
    .content a{color:#000000 !important;}
    
#dataselect .input-group-btn, #ym-select .input-group-btn {
    width: 12%;
}

#dataselect .input-sm, #ym-select .input-sm {
    border-radius: 7px;
    height: 40px;
}

#dataselect .btn-primary, #ym-select .btn-primary {
    margin-left: 20px;
    border-radius: 4px;
    margin-bottom: 0px;
}

#dataselect .input-group-addon, #ym-select .input-group-addon {
    border-radius: 7px;
}

.ibox-content {
    min-height: 550px;
}

.input-group .form-control {
    width: 45%;
    float: none;
}
#cibox-content{ min-height:550px;}
      #dataselect .input-group-btn,#ym-select .input-group-btn{width: 12%;}
      #dataselect .input-sm ,#ym-select .input-sm{ border-radius: 7px; height:40px;}
      #dataselect .btn-primary ,#ym-select .btn-primary{ margin-left: 20px; border-radius:4px;margin-bottom: 0px;}
      #dataselect .input-group-addon,#ym-select .input-group-addon{border-radius: 7px;}
      .input-group .form-control {
    width: 45%;
    float: none;
 }

.store tbody tr th{ background: #f2f2f2; height: 40px; text-align: center;}
.store tbody tr td{height: 40px; line-break: 40px; text-align: center;}
.store tbody tr td p{ width: 100%; height: 40px; line-height: 40px; border-top: 1px solid #f2f2f2; margin-bottom: 0px;}
.store tbody tr td button{border: none; width: 75px; height: 32px; background: #44b549; text-align: center; line-height: 32px; margin: 0px auto; border-radius: 5px;}
.store tbody tr td button a{ color: #FFFFFF;}
.bg_hide{display: none;}

.hz{background: #f2f2f2; width: 98%; margin-left: 1%;height: 60px; line-height: 60px;}
.hz p{ float: right; margin-left: 150px; margin-right: 50px; margin-bottom: 0px; }
.form-control{display: inline-block !important;}
#ym-select .input-group-btn {
    width: 20%;
}
</style>
<body>
    <div id="wrapper">
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>商户统计</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Agent</a>
                        </li>
                        <li>
                            <a>统计管理</a>
                        </li>   
                        <li class="active">
                            <strong>商户统计</strong>
                        </li>
                    </ol>
                </div>
        </div>
        <div class="row wrapper page-heading iconList">
                <div class="store_nr" style="margin-top: 30px">
                <div class="wrapper wrapper-content animated fadeInRight" style="width: 100%; background: #FFFFFF;">
                    <div class="row">
                    <form action="?m=Agent&c=statistics&a=forMerchants" method="get">
                    <input type="hidden" name='m' value="Agent">
                    <input type="hidden" name='c' value="statistics">
                    <input type="hidden" name='a' value="forMerchants">
                        <div id="dataselect" class="form-group" style="padding: 0 10px;">
                            <div id="datepicker" class="input-daterange">
                             <label class="font-noraml">商户名称</label>

                                <input class="input form-control" type="text" name='username' placeholder="商户名称" style="width: 20%;border-radius: 2px;height: 30px;" value="<?php if(isset($getdata['username'])) echo $getdata['username'];?>">

                                <label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
                                <input type="text" value="<?php if(isset($getdata['start'])){ echo $getdata['start'];}else{ echo date('Y-m-d'); }?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间" style=" margin-bottom: 0px; width: 20%; height: 30px;border-radius: 2px;">
                                &nbsp;<span> 到 </span>&nbsp; 
                                <input type="text" value="<?php if(isset($getdata['end'])){echo $getdata['end'];}else{ echo date('Y-m-d'); }?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间" style=" margin-bottom: 0px; width: 20%; height: 30px;border-radius: 2px;">
                                &nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:100px;" href="?m=Agent&c=statistics&a=data2ExcelMerchants" >导出excel</a>
                            </div>
                        </div>
                </form>
                        <table class="store" border="1" bordercolor="#f2f2f2" width="98%" style="margin-left:1%;">
                            <tbody>
                                <tr>
                                    <th>商户名称</th>
                                    <th>支付方式</th>
                                    <th>支付金额</th>
                                    <th>交易笔数</th>
                                    <th>商户费率</th>
                                    <th>我的佣金收入</th>
                                    <th>详情</th>
                                </tr>


                            <?php if (!empty($merchants)){ foreach ($merchants as $vk => $ovv): ?>
    

                                <tr>
                                    <td><?php echo $ovv['company']; ?></td>

                                    <td>
                                            <p>微信</p>
                                            <?php if($ovv['mtype']!=3){?><p>支付宝</p><?php }?>
                                            <?php if($ovv['mtype']==3){?><p>qq</p><?php }?>
                                    </td>
                                    
                                    <?php if (!isset($ovv['static'])) { ?>
                                    <td>
                                        <p>0</p>
                                        <p>0</p>
                                    </td>
                                    <td>
                                        <p>0</p>
                                        <p>0</p>
                                    </td>
                                     <td>
                                        <p><?php if ( !empty($ovv['commission']) ){ echo $ovv['commission']*100 .' %';}else{echo '0';} ?></p>
                                        <?php if($ovv['mtype']!=3){?><p><?php if ( !empty($ovv['alicommission']) ){ echo $ovv['alicommission']*100 .' %';}else{echo '0';} ?></p><?php }?>
                                        <?php if($ovv['mtype']==3){?><p><?php if ( !empty($ovv['qqcommission']) ){ echo $ovv['qqcommission']*100 .' %';}else{echo '0';} ?></p><?php }?>
                                    </td>
                                    <td>
                                        <p>0</p>
                                        <p>0</p>
                                    </td>
                                    <?php } ?>
                                    <?php if (isset($ovv['static'])) { ?>
                                    <td>
                                        <p><?php if (isset($ovv['static']['weixin']['total'])) {echo round($ovv['static']['weixin']['total'],2);}else{echo 0;} ?></p>
                                        <?php if($ovv['mtype']!=3){?><p><?php if (isset($ovv['static']['alipay']['total'])) {echo round($ovv['static']['alipay']['total'],2);}else{echo 0;} ?></p><?php }?>
                                        <?php if($ovv['mtype']==3){?><p><?php if (isset($ovv['static']['qq']['total'])) {echo round($ovv['static']['qq']['total'],2);}else{echo 0;} ?></p><?php }?>
                                    </td>
                                    <td>
                                        <p><?php if (isset($ovv['static']['weixin']['num'])) {echo $ovv['static']['weixin']['num'];}else{echo 0;} ?></p>

                                        <?php if($ovv['mtype']!=3){?><p><?php if (isset($ovv['static']['alipay']['num'])) {echo $ovv['static']['alipay']['num'];}else{echo 0;} ?></p><?php }?>
                                        <?php if($ovv['mtype']==3){?><p><?php if (isset($ovv['static']['qq']['num'])) {echo $ovv['static']['qq']['num'];}else{echo 0;} ?></p><?php }?>
                                    </td>
                                    
                                     <td>
                                        <p><?php if ( !empty($ovv['commission']) ){ echo $ovv['commission']*100 .' %';}else{echo '0';} ?></p>
                                        <?php if($ovv['mtype']!=3){?><p><?php if ( !empty($ovv['alicommission']) ){ echo $ovv['alicommission']*100 .' %';}else{echo '0';} ?></p><?php }?>
                                        <?php if($ovv['mtype']==3){?><p><?php if ( !empty($ovv['qqcommission']) ){ echo $ovv['qqcommission']*100 .' %';}else{echo '0';} ?></p><?php }?>
                                    </td>
                                    
                                    <td>
                                        <p>
                                        <?php if (isset($ovv['static']['weixin']['sincome'])) {echo round($ovv['static']['weixin']['sincome'],2);}else{echo 0;} ?></p>
                                        <p>
                                        <?php if (isset($ovv['static']['alipay']['sincome'])) {echo round($ovv['static']['alipay']['sincome'],2);}else{echo 0;} ?>
                                            
                                        </p>
                                    </td>


                                    <?php } ?>
                                    <td><a style='width: 110%;height: 100%;' href="?m=Agent&c=statistics&a=merchantInfo&mid=<?php echo $ovv['mid']; ?><?php  if (!empty($getdata['start'])){ echo '&start='.$getdata['start']; } ?><?php  if (!empty($getdata['end'])){ echo '&end='.$getdata['end']; } ?>"><button >查看流水</button></a></td>
                                </tr>

                            <?php endforeach ?>
                            <?php } ?>

                            </tbody>
                        </table>
                        <div class="hz clearfix">
                            <p>我的佣金总收入：<?php if (!empty($sum['Income'])){echo round($sum['Income'],2);}else{echo 0;} ?>元</p>
                            <p>总笔数：<?php if (!empty($sum['count'])){echo $sum['count'];}else{echo 0;} ?>笔</p>
                            <p>总支付金额：<?php if (!empty($sum['Total'])){echo round($sum['Total'],2);}else{echo 0;} ?>元</p>
                        </div>
                    <?php echo $p; ?> 
               </div>

             </div> 
              
           </div>   


        </div>

    </div>
   </div>

<!--导出弹窗-->
<div class="modal inmodal" tabindex="-1" role="dialog"  id="Export_excel_pop">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h6 class="modal-title">请耐心等待导出完成...</h6>
                    <span>数据比较多请耐心等待导出完成，不要点取消！</span>
                </div>
                <div class="modal-body">
                <ul></ul>
                </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-white" onclick="$('#Export_excel_pop').hide();$('.modal-backdrop').remove();"> 取 消 </button>
                </div>
                </div>
            </div>
        </div>
    </div>


   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
<script>
    $(".tit>ul>li").click(function(){
        var index = $(this).index();
        $(this).siblings().removeClass("content");
        $(this).addClass("content");
        $(".store_nr>div").hide();
        $(".store_nr>div").eq(index).show();

    });
</script>


<script type="text/javascript">
if(mobilecheck()){
$("#side-menu li").click(function () {
   $("#side-menu li").find('.nav-second-level').css('display','none');
   $(this).find('.nav-second-level').css('display','block').css('min-width','140px');
 });
}
    if(navigator.userAgent.indexOf("AlipayClient")!=-1){
        $('#shou-kuan').attr('href','/merchants.php?m=User&c=alicashier&a=alipayment&type=1');
        $('#tui-kuan').attr('href','/merchants.php?m=User&c=alicashier&a=alipayment&type=2');
    }
</script> 
<script type="text/javascript">
                $(document).ready(function() {
                    $('#datepicker .input-sm').datepicker({
                        keyboardNavigation: false,
                        forceParse: false,
                        format: "yyyy-mm-dd",
                        autoclose: true
                    });
                    $('#ymdatepicker .input-sm').datepicker({
                        keyboardNavigation: false,
                        forceParse: false,
                        format: "yyyy-mm",
                        autoclose: true
                    });
                   
                 GetChartData('smcount','linecountChart','canvasdesc');
                $('#dataselect .btn-primary').click(function(){
                    GetChartData('smcount','linecountChart','canvasdesc');
                });
        });
    </script>


   <script>
    /******导出处理********/
var tipshtm='';
var excellock=false;
function exportExcel(){
   if(excellock){
        $('#Export_excel_pop').show();
        $('body').append('<div class="modal-backdrop in"></div>');
        return false;
    }
    excellock=true;
    $('#Export_excel_pop ul').html('<li style="padding-top:20px;">正在导出您的数据，请稍等......</li>');
  $('#Export_excel_pop').show();
  $('body').append('<div class="modal-backdrop in"></div>');
  var fromData=$('form').serialize();
      $.post('/merchants.php?m=User&c=statistics&a=exportExcel', fromData, function(resp){
             if (resp.error){
                 alert(resp.msg);
                 return false;
             } else {
                if(resp.tt>0){
                  tipshtm="<li>已经导出1到5000数据......."+
                   "<li id='extpage_1'>正在为您导出5001到10000条数据......</li>";
                    $('#Export_excel_pop ul').append(tipshtm);
                  Run_Export_excel(2);
                }else{
                  tipshtm="<li>数据导出完成&nbsp;&nbsp;&nbsp;<a href='"+resp.fileurl+"'>下载<a></li>"
                  $('#Export_excel_pop ul').append(tipshtm);
                  excellock=false;
                }
             }                                      
        }, 'json');
   
    return false;
}


 
function Run_Export_excel(page){
     var fromData=$('form').serialize();
     fromData=fromData+'&page='+page;
      $.post('/merchants.php?m=User&c=statistics&a=exportExcel', fromData, function(resp){
             if (resp.error){
                 alert(resp.msg);
                 return false;
             } else {
                var tmp= resp.p +1;
                var idxs=(page-1);
                if(!resp.flag && (tmp<=resp.tt)){
                  var mc1=5000*idxs +1;
                  var mc2=5000*page;
                  var mc3=5000*tmp;
                   $('#extpage_'+idxs).html('已经导出'+mc1+'到'+mc2+'数据.......');
                    mc2=mc2+1;
                    tipshtm="<li id='extpage_"+page+"'>正在为您导出"+mc2+"到"+mc3+"条数据......</li>";
                    $('#Export_excel_pop ul').append(tipshtm);
                    Run_Export_excel(tmp);
                }else{
                  tipshtm="<li id='extpage_end'>完成导出,正在为你打包导出的文件......</li>";
                  $('#Export_excel_pop ul').append(tipshtm);
                    if(true){
                    $.post('/merchants.php?m=User&c=statistics&a=export_excel_zip', {page:resp.p}, function(rest){
                         if (rest.error){
                            alert(resp.msg);
                            return false;
                            } else {
                                     tipshtm="<li>打包完成。&nbsp;&nbsp;&nbsp;<a href='"+rest.fileurl+"'>下 载<a></li>";
                                    $('#Export_excel_pop ul').append(tipshtm);
                                    excellock=false;
                            }
                    }, 'json');
                    }
                }
                 //window.location.reload();
             }                                      
        }, 'json');
}

   </script>

    </body>
</html>