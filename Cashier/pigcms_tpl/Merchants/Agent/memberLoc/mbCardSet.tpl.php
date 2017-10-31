<!DOCTYPE html>
<html>
<head>
    <title>本站会员卡</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
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

		.float-e-margins .ibox-content{border-style:none;}
		.nav-tabs > li > a:hover,
		.nav-tabs > li > a:focus {
		 background-color: #FFF;
		}
		.nav-tabs li.active  a {border-color:#dddddd #dddddd #fff}
		.nav-tabs li.active  a:hover,.nav-tabs li.active a:focus {border-color:#dddddd #dddddd #fff;background-color:#FFF;}
	#qyChaXun {border-radius: 7px;display: inline-block;float: none;height: 35px;margin-bottom: 1px;width: 250px;}
	#rechargeMoney_pop .modal-footer {text-align: center;}
	</style>
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all2.min.js"></script>
</head>

<body>
    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>会员管理</h2>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-12">
            	    <div class="ibox float-e-margins">
					
					<form class="col-lg-6">
							<div class="form-group">
							<label class="font-noraml">会员卡号：</label>
							<input type="text" class="form-control" id="qyChaXun" placeholder="输入会员卡号搜索" value="<?php echo $numstr;?>">
							&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" style="width:70px;" onclick="qyChaXun()">查 询</a>
						</div>
					</form>


<div class="ibox-content"> 
	<div style="margin-top:20px;" class="alert alert-warning">
	   注意:后台这里充值将不享受充值赠送金额</div>
   <div class="app__content js-app-main page-cashier">
    <div>
      <!-- 实时交易信息展示区域 --> 
      <div class="cashier-realtime"> 
       <div class="realtime-title-block clearfix"> 
        <h3 class="realtime-title">会员列表</h3> 
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
            <th data-hide="phone">卡号</th> 
            <th data-hide="phone">会员姓名</th> 

			<th data-hide="phone">微信昵称</th> 
			<th data-hide="phone">头像</th> 

            <th data-hide="phone">联系电话</th> 
			<th data-hide="phone">领卡时间</th> 
            <th data-hide="phone">积分</th>
			<th data-hide="phone">消费总额(元)</th>
			<th  data-hide="phone">余额</th>
            <th>操作</th>
           </tr>
          </thead>
          <tbody class="js-list-body-region" id="table-list-body">
		   <?php if(!empty($memberArr)){
		      foreach($memberArr as $kvv){
		   ?>
           <tr class="widget-list-item">
            <td><?php echo $kvv['id'];?></td> 
            <td><?php echo $kvv['numstr']?></td> 
            <td class="pname"><?php if(!empty($kvv['truename'])){echo $kvv['truename'];}elseif(!empty($kvv['nickname'])){
			  echo $kvv['nickname'];
			}else{
			  echo $kvv['openid'];
			}?></td> 
			<td><?php echo $kvv['nickname'];?></td> 
			<td>
			<?php if(!empty($kvv['headimgurl'])){ ?>
			<img width="50px" height="50px" src="<?php echo $kvv['headimgurl'];?>">
			<?php } ?>
			</td> 
            <td><?php echo $kvv['tel'];?></td> 
			<td><?php echo date('Y-m-d H:i:s',$kvv['getcardtime']);?>
			</td>
			<td><span><?php echo $kvv['total_score'];?></span>&nbsp;&nbsp;<a class="icon_edit js_modify_quantity" href="javascript:;" data-actionid="<?php echo $kvv['id'];?>"><i class="fa fa-pencil"></i></a></td>
			<td>
			<?php echo $kvv['expensetotal'];?>
			</td> 
			<td>
			<?php echo $kvv['balance'];?>
			</td>

            <td>
			<button class="btn btn-sm btn-info" onclick="rechargeMoney(this,<?php echo $kvv['id'];?>)"><strong> 充 &nbsp; 值 </strong></button> &nbsp; &nbsp; 

			<a class="btn btn-sm btn-info" href="/merchants.php?m=User&c=memberLoc&a=payRecord&cdid=<?php echo $cdid;?>&memberno=<?php echo $kvv['numstr'];?>"><strong>消费记录</strong></a>&nbsp; &nbsp; 

			<button class="btn btn-sm btn-danger" onclick="deltheItem(this,<?php echo $kvv['id'];?>);"><strong> 删 &nbsp; 除 </strong></button>
			</td>
           </tr>
		   <?php }}else{?>
		   <tr class="widget-list-item"><td colspan="11">暂无会员</td></tr>
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

<div class="popover" id="quantitypopover">
    <div class="popover_inner">
        <div class="popover_content"><div class="pop_store">
	<!--增减库存-->
	
	<div class="frm_control_group">
        <div class="frm_controls">
			<label class="frm_radio_label selected">
				<input type="radio" class="frm_radio" value="1" checked="" name="isadd">
				<span class="lbl_content">增加</span>
			</label>
			<label class="frm_radio_label">
				<input type="radio" class="frm_radio" value="0" name="isadd">
				<span class="lbl_content">减少</span>
			</label>
		</div>
	</div>
	
	<div class="frm_control_group">                        
		<div class="frm_controls">
			<div class="frm_controls_hint group">
				<span class="frm_input_box"><input type="text" name="quantitynum" class="frm_input js_value" onkeyup="value=value.replace(/[^1234567890]+/g,'')"></span>
				<span class="frm_hint"> 积分</span>
			</div>
			<p class="frm_tips fail"></p>
		</div>
	</div>
	<!--增减库存 end-->
</div></div>
        <div class="popover_bar">
			<button type="button" class="btn btn-primary btn_confirm">确 定</button>&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-white c-close">取 消</button>
        </div>
        
    </div>
    <i class="popover_arrow popover_arrow_out"></i>
    <i class="popover_arrow popover_arrow_in"></i>
</div>

	<div class="modal inmodal" tabindex="-1" role="dialog"  id="rechargeMoney_pop">
		<div class="modal-dialog" style="margin: 150px auto;">
			<div class="modal-content animated bounceInRight">
				<div class="modal-header" style="padding: 15px;">
				 <button class="close _close" type="button"><span style="font-size: 35px;">×</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">会员充值</h4>
				</div>
				<div class="modal-body">
				    <div style="color:green;font-size: 22px;text-align: center;" class="ppname">哈哈哈哈</div>
					<label class="font-noraml">充值金额：</label>
					<input type="text" class="form-control" id="rechargeMoney" placeholder="填写充值金额（元）" value="" onkeyup="value=value.replace(/[^1234567890]+/g,'')">
					<input type="hidden"  id="rechargeuid" value="0">

				</div>
					<div class="modal-footer">
                    <button type="button" class="btn  btn-primary" onclick=""> 确 认 </button>
                </div>
				</div>
			</div>
		</div>
	</div>

</body>

 <script>
 function is_mobile(){
		var ua = navigator.userAgent.toLowerCase();
		if ((ua.match(/(iphone|ipod|android|ios|ipad|mobile)/i))){
				return true;
		}else{
			return false;
		}
	}

 	if(is_mobile()){
	  $('.row .col-lg-12').css('padding','1px');
	  $('.float-e-margins .ibox-content').css('padding','15px 5px 20px 5px');
	  $('.nav-tabs li a').css('padding','10px');
  }

 $(document).ready(function(){
   $('.ui-table-list').footable();
   $('#rechargeMoney_pop ._close').click(function(){
       $('#rechargeMoney_pop').hide();
	   	$('#rechargeMoney_pop .ppname').text('');
		$('#rechargeMoney_pop #rechargeuid').val('0');
	   $('.modal-backdrop').remove();
    });
  });


	function qyChaXun(vv){
		var nums=$('#qyChaXun').val()
	    var furl='http://'+window.location.host+'/merchants.php?m=User&c=memberLoc&a=mbCardSet&cdid=<?php echo $cdid;?>&nums='+nums;
		window.location.href=furl;
	}

  function rechargeMoney(obj,uid){
	    var pname=$(obj).parent().siblings('.pname').text();
		pname=$.trim(pname);
		$('#rechargeMoney_pop .ppname').text(pname);
		$('#rechargeMoney_pop #rechargeuid').val(uid);
        $('body').append('<div class="modal-backdrop in"></div>');
        $('#rechargeMoney_pop').show();
  }

	$(document).on('click',function(e){
		   var target = $(e.target);
		   var quantityobj=target.closest(".js_modify_quantity");
		   if(quantityobj.size()!=0){
			   actid=quantityobj.data('actionid');
			   numObj=quantityobj.siblings('span');
			   var offsetpx=quantityobj.offset();
			   $('#quantitypopover').css('position','absolute').css('left',offsetpx.left-141).css('top',offsetpx.top+5).css('zIndex','100').show();
		     }else if(target.closest("#quantitypopover").size()==0){
			    actid=0;numObj='';
		        $("#quantitypopover").hide();
		   }
		});

		$("#quantitypopover .c-close").click(function(){
			  actid=0;numObj='';
		     $("#quantitypopover").hide();
		});

		$("#quantitypopover .btn_confirm").click(function(){
			var datas = {uiid:actid};
			var qtype = $('.frm_control_group input:checked').val();
			var qmun = $('.frm_control_group input[name="quantitynum"]').val();
			    qmun=parseInt(qmun);
			if(!(qmun > 0)){
			   $('.frm_control_group input[name="quantitynum"]').focus();
			   return false;
			}
			datas.qtype=qtype; /***1增加0减少****/
			datas.qmun=qmun;
		    if(actid>0 && qmun>0){
		     $("#quantitypopover").hide();
				actid=0;
				$.ajax({
				url: "?m=User&c=memberLoc&a=mbCardIntegral&cdid=<?php echo $cdid;?>",
				type: "POST",
				dataType: "json",
				data:datas,
				success: function(res){
					if(!res.error){
						if(numObj){
						     numObj.text(res.data);
						}
						numObj='';
						swal({
							title: "修改成功",
								text: "修改成功",
								type: "success"
							});
					}else{
						swal({
								title: "修改失败",
								text: res.msg,
								type: "error"
							}, function () {
								//window.location.reload();
							});
					}
				}
				});
			}
		});
      /****充值金额***/
	  var ispost=false;
		$("#rechargeMoney_pop .btn-primary").click(function(){
		  if(ispost){
		     return true;
		  }
		   var money = $.trim($("#rechargeMoney").val());
		   money=parseInt(money);
		   var uiid = $.trim($("#rechargeuid").val());
		   uiid=parseInt(uiid);
		   if(money>0 && uiid>0){
			   ispost=true;
		       	$.ajax({
				url: "?m=User&c=memberLoc&a=mbCardRecharge&cdid=<?php echo $cdid;?>",
				type: "POST",
				dataType: "json",
				data:{money:money,uiid:uiid},
				success: function(res){
					 ispost=false;
					 $("#rechargeMoney_pop ._close").click();
					if(!res.error){
						swal({
							title: "温馨提示",
								text: "充值成功",
								type: "success"
							}, function () {
								window.location.reload();
							});
					}else{
						swal({
								title: "温馨提示",
								text: "充值失败",
								type: "error"
							}, function () {
								window.location.reload();
							});
					}
				   }
				});
		   }else{
				swal({
					title: "温馨提示",
					text: "充值金额必须大于零的正数",
					type: "error"
				});
		   }
		});

   /****删除客户*****/
  function deltheItem(obj,uiid){
	swal({
		title: "您确定要删除此会员",   
		text: "删除后此会员的相关数据将都会被删除，请谨慎操作！",
		type: "warning",   
		showCancelButton: true,   
		confirmButtonText: "确定删除",   
		cancelButtonText: "取消删除",   
		closeOnConfirm: true,   
		closeOnCancel: true 
	}, function(isConfirm){
		if (isConfirm) {
			$.ajax({
			url: "?m=User&c=memberLoc&a=delmember&cdid=<?php echo $cdid;?>",
			type: "POST",
			dataType: "json",
			data:{uiid:uiid},
			success: function(res){ 
				if(!res.error){
					$(obj).parent().parent('tr').remove();
					swal({
						title: "温馨提示",
							text: "删除成功！",
							type: "success"
						});
				}else{
					swal({
							title: "温馨提示",
							text: "删除失败！",
							type: "error"
						});
				}
			   }
			});
		} 
	});
  
  }
 </script>
 

</html>