<!DOCTYPE html>
<html>
<head>
    <title>会员信息</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
	<link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
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
			padding:3px;
		}
		.fa-paste{
			margin-right:7px;
			padding: 0px;
		}
		.dz-preview{
			display:none;
		}
		.ibox-title ul{ list-style: outside none none !important; margin: 0; padding: 0;}
		.ibox-title li { float: left;width: 30%; }
		#commonpage {float: right;margin-bottom: 10px;}
		#table-list-body .btn-st{background-color: #337ab7;border-color: #2e6da4;cursor:auto;}
		#select_Cardtype .i-checks label{cursor: pointer;}
		#ewmPopDiv .modal-body{text-align: center;}
	.modal-footer {text-align: center;}
	.modal-footer .btn {padding: 7px 30px;}
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
                    <h2>会员信息</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>wxCoupon</a>
                        </li>
                        <li class="active">
                            <strong>wxCardList</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-12">
            	    <div class="ibox float-e-margins">
            	        <div class="ibox-title clearfix">
						<ul class="nav"> 
						<li><button class="btn btn-primary" id="pop_add_card"><i class="fa fa-plus"></i> 创建新会员卡 </button></li> 
						</ul> 
            	     </div>
<div class="ibox-content"> 
   <nav class="ui-nav clearfix"> 
    <!--<div class="pull-right common-helps-entry"> 
     <a href="" target="_blank"> <span class="help-icon"></span> 查看【收银台】使用教程 </a> 
    </div>--->
   </nav> 
   <div class="app__content js-app-main page-cashier">
    <div>
      <!-- 实时交易信息展示区域 --> 
      <div class="cashier-realtime"> 
       <div class="realtime-title-block clearfix"> 
        <h1 class="realtime-title">会员信息列表</h1> 
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
            <th data-hide="phone">会员卡名称</th>
			<th data-hide="phone">会员昵称</th>
            <th data-hide="phone">会员头像</th> 
            <th data-hide="phone">状态</th>
			<th data-hide="phone">核销码</th>
			<th data-hide="phone">领取时间</th>
			<th data-hide="phone">核销时间</th>
			<th data-hide="phone">操作</th>
           </tr>
          </thead>
          <tbody class="js-list-body-region" id="table-list-body">
		   <?php if(!empty($wxReceiveUser)){
		      foreach($wxReceiveUser as $rvv){
		   ?>
           <tr class="widget-list-item">
            <td><?php echo $rvv['id'];?></td>
			<td><?php echo $rvv['cardtitle'];?></td> 
            <td><?php echo $rvv['nickname'];?></td> 
            <td><img src="<?php echo $rvv['headimgurl'];?>" style="width: 60px;height:60px;"></td> 
			<td><?php if($rvv['isdel']==1){ echo '<span class="btn btn-sm btn-primary">已删除</span>';}elseif($rvv['status']>0){ echo '<span class="btn btn-sm btn-primary">已核销</span>';}else{ echo '<span class="btn btn-sm btn-danger">已领取</span>';}?></td>
			<td><?php echo $rvv['cardcode'];?></td>
			<td><?php echo date('Y-m-d H:i:s',$rvv['addtime']);?></td>
			<td><?php if($rvv['consumetime']>0) echo date('Y-m-d H:i:s',$rvv['consumetime']);?></td>
			<td class="footable-visible footable-last-column">
			<button onclick="show_detail(<?php echo $rvv['id'];?>);" class="btn btn-sm btn-primary"><strong>查看详情 </strong></button>
			<a class="btn btn-sm btn-primary"  href="?m=User&c=wxCoupon&a=bonus&id=<?php echo $rvv['id'];?>" style="vertical-align:top;"> 积分操作详情 </a> 
			<a class="btn btn-sm btn-primary"  href="?m=User&c=wxCoupon&a=paycell&id=<?php echo $rvv['id'];?>" style="vertical-align:top;">支付记录 </a> 
			</td>
           </tr>
		   <?php }}else{?>
		   <tr class="widget-list-item"><td colspan="10">暂无会员信息</td></tr>
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
    
    
    
    	<div class="modal inmodal" tabindex="-1"  id="wxApi_Setting">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				
				<div class="modal-header">
                    <button type="button" class="close _close"><span>×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">会员详情</h4>
                </div>
				<div class="modal-body">
					<div class="setting_rows">
						<div id="wxActionBox" class="wxpay_box">
						</div>
					</div>
				</div>
				<div class="modal-footer">
                    <button type="button" class="btn btn-primary _close">关闭</button>
                </div>
			</div>
		</div>
	</div>
	
	
</body>
<!-- iCheck -->
<script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
<script>
$(document).ready(function(){
	if ($(this).width() < 769) {
		$('.float-e-margins .ibox-title').hide();
	} else {
		$('.float-e-margins .ibox-title').show();
	}
	$('.ui-table-list').footable();
	$("#pop_add_card").click(function(){
		window.location.href="?m=User&c=wxCoupon&a=card";
	});


	$("#wxApi_Setting ._close").click(function(){
		$('#wxApi_Setting').hide();
		$('#wxApi_Setting .wxtoken').val('');
		$('#wxApi_Setting .aeskey').val('');
		$('.modal-backdrop').remove();
	});
});

	function show_detail(id){
		$.ajax({
			url: "?m=User&c=wxCoupon&a=membercardinfo",
			type: "POST",
			dataType: "json",
			data:{id:id},
			success: function(res){
				if(!res.errcode){
					var html = '';
					$.each(res.data, function(i, da){
						html += '<div class="form-group">';
						html += '<label>' + da.title + '：</label>';
						html += '<label>' + da.value + '</label>';
						html += '</div>';
					});
					$('#wxActionBox').html(html);
					var winW=$(window).width();
					if(winW<750){
					   $('#wxApi_Setting .modal-dialog').css('width','92%');
					}else{
					   $('#wxApi_Setting .modal-dialog').width(280);
					}
					$('body').append('<div class="modal-backdrop in"></div>');
					$('#wxApi_Setting').show();
				} else {
					swal({
        					title: "查看详情失败",
        					text: res.errmsg,
        					type: "error"
    					});
				}
			}
		});
	}
</script>
 
</html>