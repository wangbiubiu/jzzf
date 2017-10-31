<!DOCTYPE html>
<html>
<head>
    <title>收银台 | 收款记录</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
	<style>
		.ibox-title h5 {
  			margin: 10px 0 0px;
		}
		select.input-sm {
  			height: 35px;
  			line-height: 35px;
		}
		.float-e-margins .btn-info{
			margin-bottom:0px;
		}
		.fa-paste{
			margin-right:7px;
			padding: 0px;
		}
		.dz-preview{
			display:none;
		}
		.ibox-title ul{ list-style: outside none none !important; margin: 0; padding: 0;}
		.ibox-title li:nth-child(1) { float: left;width: 30%; }
		.ibox-title li:nth-child(2) { float: left;width: 32%; }
		.ibox-title li:nth-child(3){width: 35%; }
		#commonpage {float: right;margin-bottom: 10px;}
		#table-list-body .btn-st{background-color: #337ab7;border-color: #2e6da4;cursor:auto;}
		#oderinfo{overflow-y: scroll;}
		.float-e-margins .ibox-content{border-style:none;}
		.nav-tabs > li > a:hover,
		.nav-tabs > li > a:focus {
		 background-color: #FFF;
		}
		.nav-tabs li.active  a {border-color:#dddddd #dddddd #fff}
		.nav-tabs li.active  a:hover,.nav-tabs li.active a:focus {border-color:#dddddd #dddddd #fff;background-color:#FFF;}
		#screenForm .input-group{display: inline-block;width: 280px;}
		#screenForm select{display: inline-block;float:none;width: 70%;}
		#dataselect  input {border-radius: 7px;height: 35px;display: inline-block;width:220px;margin-bottom:1px;}
	</style>
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/navlist.tpl.php';?>     
            </div>
       
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-12">
            	    <div class="ibox float-e-margins">
					
					<div class="ibox-title" id="screenForm">
					  <form method="get" action="/merchants.php?m=User&c=statistics&a=orderLists">
					    <input type="hidden" value="User" name="m" >
						<input type="hidden" value="statistics" name="c" >
						<input type="hidden" value="orderLists" name="a" >
						<div class="form-group">
							<div class="form-group input-group">
							   <label class="font-noraml">订单来源</label>&nbsp;&nbsp;&nbsp;
								<select class="form-control m-b" name="cfr">
								<option value="0">不选择</option>
								<option value="1" <?php if($cfr==1) echo 'selected="selected"';?>>本平台和APP</option>
								<option value="2" <?php if($cfr==2) echo 'selected="selected"';?>>本平台</option>
								<option value="3" <?php if($cfr==3) echo 'selected="selected"';?>>APP端支付</option>
								<option value="4" <?php if($cfr==4) echo 'selected="selected"';?>>第三方平台对接</option>
								</select>
							</div>
							<div class="form-group input-group">
							   <label class="font-noraml">支付方式</label>&nbsp;&nbsp;&nbsp;
								<select class="form-control m-b" name="pty">
								<option value="0">不选择</option>
								<option value="weixin" <?php if($pty=='weixin') echo 'selected="selected"';?>>微信支付</option>
								<option value="alipay" <?php if($pty=='alipay') echo 'selected="selected"';?>>支付宝支付</option>
								</select>
							</div>
							<?php if($this->storeid>0){?>
							  <div class="form-group input-group">
							   <label class="font-noraml">门店：</label>&nbsp;&nbsp;&nbsp;<?php echo $allStore['business_name'].$allStore['branch_name'];?>
							   </div>
							<?php }elseif(!empty($allStore)){?>
							<div class="form-group input-group">
							   <label class="font-noraml">选择门店</label>&nbsp;&nbsp;&nbsp;
								<select class="form-control m-b" name="sid">
								<option value="0">不选择门店</option>
								<?php foreach ($allStore as $store) {?>
								<option value="<?php echo $store['id'];?>" <?php if($store['id']==$sid) echo 'selected="selected"';?>><?php echo $store['business_name'] . $store['branch_name'];?></option>
								<?php }?>
								</select>
								
							</div>
							<?php }?>

							<?php if(!empty($allEmployee)){?>
							<div class="form-group input-group">
							<label class="font-noraml">选择店员</label>&nbsp;&nbsp;&nbsp;
								<select class="form-control m-b" name="eid">
								<option value="0">不选择店员</option>
								<?php foreach ($allEmployee as $emp) {?>
								<option value="<?php echo $emp['eid'];?>" <?php if($emp['eid']==$eid) echo 'selected="selected"';?>><?php echo $emp['username'];?></option>
								<?php }?>
								</select>
								
							</div>
							<?php }?>
						</div>
						<div id="dataselect" class="form-group">
							<div id="datepicker" class="input-daterange">
								<label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
								<input type="text" value="<?php if(isset($getdata['start'])) echo $getdata['start'];?>" name="start" class="input-sm form-control" id="datestart" placeholder="开始时间">
								&nbsp;<span> 到 </span>&nbsp; 
								<input type="text" value="<?php if(isset($getdata['end'])) echo $getdata['end'];?>" name="end" class="input-sm form-control" id="dateend" placeholder="结束时间"> 
								&nbsp;&nbsp;&nbsp;<input class="btn btn-primary" type="submit" value="查 询" style="width:70px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary"  style="width:80px;" href="javascript:;" onclick="exportExcel();">导 出</a>
							</div>
						</div>
					  </form>
					</div>
					
<div class="ibox-content"> 

   <div class="app__content js-app-main page-cashier">
    <div>
      <!-- 实时交易信息展示区域 --> 
      <div class="cashier-realtime"> 
       <div class="realtime-title-block clearfix"> 
        <h1 class="realtime-title">收款情况</h1> 
       </div> 
      </div> 
      <div class="js-real-time-region realtime-list-box loading">
       <div class="widget-list">
        <div class="js-list-filter-region clearfix ui-box" style="position: relative;">
         <div class="widget-list-filter"></div>
        </div> 
        <div class="ui-box"> 
         <table class="ui-table ui-table-list" data-page-size="20" style="padding: 0px;"> 
          <thead class="js-list-header-region tableFloatingHeaderOriginal">
           <tr class="widget-list-header">
		    <th>编号</th>
            <th data-hide="phone">付款人</th> 
            <th data-hide="phone">付款时间</th> 
            <th data-hide="phone">付款理由</th> 
			<th data-hide="phone">交易类型</th> 
            <th data-hide="phone">付款金额(元)</th>
			<th data-hide="phone">退款情况</th>
			<th  data-hide="phone">对账情况</th>
			<th  data-hide="phone">收款门店</th>
			<th  data-hide="phone">收款人</th>
            <th>操作</th>
           </tr>
          </thead>
          <tbody class="js-list-body-region" id="table-list-body">
		   <?php if(!empty($neworder)){
		      foreach($neworder as $ovv){
		   ?>
           <tr class="widget-list-item">
            <td><?php echo $ovv['id'];?></td> 
            <td><?php if(!empty($ovv['nickname'])){
				echo $ovv['nickname'];
			}elseif(!empty($ovv['truename'])){
			     echo htmlspecialchars_decode($ovv['truename'],ENT_QUOTES);
			}elseif(!empty($ovv['openid'])){
			    echo $ovv['openid'];
			}else{
			    echo '未知客户';
			}?></td> 
            <td><?php $paytime=$ovv['paytime'] > 0 ? $ovv['paytime'] : $ovv['add_time']; echo date('Y-m-d H:i:s',$paytime);?></td> 
            <td><?php echo htmlspecialchars_decode($ovv['goods_name'],ENT_QUOTES);?></td> 
			<td><?php if($ovv['comefrom']==0){echo '本平台 ';}elseif($ovv['comefrom']==1){echo '微信营销 ';}elseif($ovv['comefrom']==2){echo '电商平台 ';}elseif($ovv['comefrom']==3){echo 'O2O平台 ';}elseif($ovv['comefrom']==4){
			  echo 'APP客户端 ';
			}?>
			<?php if($ovv['pay_way']=='alipay'){echo '支付宝支付';}elseif($ovv['pay_way']=='weixin'){echo '微信支付';}else{echo '其他支付';}?>
			</td>
			<td><?php echo $ovv['goods_price'];?></td>
			<td><?php if($ovv['refund']==1){?>
			     <font>退款中...</font>
			<?php }elseif($ovv['refund']==2){?>
			     <font color="#2e6da4">已退款</font>
			<?php }elseif($ovv['refund']==3){?>
			     <font color="#ed5565">退款失败</font>
			 <?php }else{
			     echo '<font color="#44b549">已支付</font>';
			 } ?>
			</td> 
			<td>
			<?php if($ovv['mchtype']==2){ ?>
			<?php if($ovv['state']==2){echo '<font color="#047609">已对账</font>';}else{echo '<font color="#E00A23">未对账</font>';}?>
			<?php }else{
			  echo '<font>无</font>';
			}?>
			</td>
			<td><?php echo $ovv['storename'];?></td>
			<td><?php echo $ovv['optername'];?></td>
            <td>
			<?php if($ovv['comefrom']>0 || (($ovv['state']==2) && ($ovv['mchtype']>0))){ ?> <button class="btn btn-sm btn-success btn-st"><strong> 已支付 </strong></button> <?php }elseif($ovv['refund']!=2 && $ovv['refund']!=1){?> <button class="btn btn-sm btn-warning" onclick="<?php if($ovv['pay_way']=='weixin'){echo 'wx';}elseif($ovv['pay_way']=='alipay'){echo 'ali';}?>RefundBtn(this,<?php echo $ovv['id'];?>,<?php echo $ovv['mid'];?>);"><strong> 退&nbsp;&nbsp;&nbsp;款 </strong></button>  <?php }elseif($ovv['refund']==2){?><button class="btn btn-sm btn-success btn-st"><strong> 已退款 </strong></button>  <?php }?>
			<button class="btn btn-sm btn-info" onclick="GetDetail(<?php echo $ovv['id'];?>,<?php echo $ovv['mid'];?>);"><strong>支付详情</strong></button>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if(($ovv['ispay']!=1) || (($ovv['ispay']==1) && ($ovv['refund']==2))){?>
			<button class="btn btn-sm btn-danger" onclick="deltheOrder(this,<?php echo $ovv['id'];?>,<?php echo $ovv['mid'];?>);"><strong> 删 除 </strong></button>
			 <?php }else{?>
			  <button class="btn btn-sm btn-gray"><strong>不可删</strong></button>
			 <?php }?>
			</td>
           </tr>
		   <?php }}else{?>
		   <tr class="widget-list-item"><td colspan="11">暂无订单</td></tr>
		   <?php }?>
          </tbody> 
         </table> 
         <div class="js-list-empty-region"></div> 
        </div> 
        <div class="js-list-footer-region ui-box">
         <div class="widget-list-footer"></div>
        </div> 
       </div>
      </div> 
     </div>
    </div>
   </div> 
  </div>    
            	</div>
				<?php echo $pagebar;?>
            </div>
        </div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>

		<div class="modal inmodal" tabindex="-1" role="dialog"  id="oderinfo">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header">
                    <button type="button" class="close _close"><span style="font-size: 35px;">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">支付详情</h4>
                </div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-white _close">关闭</button>
                </div>
			</div>
		</div>
	</div>

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

</body>
<script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>cashier/commonfunc.js"></script>
 <script>
 	if(is_mobile()){
	  $('.row .col-lg-12').css('padding','1px');
	  $('.float-e-margins .ibox-content').css('padding','15px 5px 20px 5px');
	  $('.nav-tabs li a').css('padding','10px');
  }
 $(document).ready(function(){
   $('.ui-table-list').footable();
	$('#datepicker .input-sm').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		format: "yyyy-mm-dd",
		autoclose: true
	});

  });

	var screenH=$(window).height();
	screenH=  screenH-20;
	$('#oderinfo').css('height',screenH);


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
 <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>cashier/lhsw.js"></script>

</html>