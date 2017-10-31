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
		.labela{ font-size: 17px;margin: 0 0 10px 5px;}
		.labela span i{color:green;}
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
                    <h2>会员卡管理</h2>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-12">
            	    <div class="ibox float-e-margins">
					<label class="font-noraml labela"><span>会员卡号：<i><?php echo $memberno;?></i></span>&nbsp;&nbsp;&nbsp;
					<span>所属会员卡：<i><?php echo $thisCard['cardname'];?></i></span>&nbsp;&nbsp;&nbsp;
					<span>会员昵称：<i><?php echo (!empty($UserInfo['truename']) ? $UserInfo['truename']:(!empty($UserInfo['nickname']) ? $UserInfo['nickname']:$UserInfo['openid']));?></i></span>
					</label>
					<!--<form class="col-lg-6">
							<div class="form-group">
							<label class="font-noraml">会员卡号：</label>
							<input type="text" class="form-control" id="qyChaXun" placeholder="输入会员卡号搜索" value="<?php echo $numstr;?>">
							&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" style="width:70px;" onclick="qyChaXun()">查 询</a>
						</div>
					</form>--->

	<div class="ibox-title clearfix">
		<ul> 
			<li style="width: 150px;"><a  href="/merchants.php?m=User&c=memberLoc&a=payRecord&cdid=<?php echo $cdid;?>&memberno=<?php echo $memberno;?>" class="btn btn-outline btn-primary"> 会员卡消费记录 </a></li> 
			<li><a  href="" class="btn btn-primary"> 线下交易记录 </a></li> 
		</ul> 
   </div>
<div class="ibox-content"> 
	
   <div class="app__content js-app-main page-cashier">
    <div>
      <!-- 实时交易信息展示区域 --> 
      <div class="cashier-realtime"> 
       <div class="realtime-title-block clearfix"> 
        <h3 class="realtime-title">线下交易列表</h3> 
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
            <th data-hide="phone">日期</th> 
			<th data-hide="phone">交易金额</th> 
			<th data-hide="phone">所获积分</th> 
			<th data-hide="phone">交易说明</th> 
            <th data-hide="phone">交易类型</th> 
            <th>操作</th>
           </tr>
          </thead>
          <tbody class="js-list-body-region" id="table-list-body">
		   <?php if(!empty($locmbpayrecord)){
		      foreach($locmbpayrecord as $kvv){
		   ?>
           <tr class="widget-list-item">
            <td><?php echo $kvv['id'];?></td>
			<td><?php echo date('Y-m-d H:i:s',$kvv['addtime']);?></td>
			<td><?php echo $kvv['expense'];?></td> 
			<td><?php $opt='';if($kvv['score']>0) $opt='+'; echo $opt.$kvv['score'];?></td> 

            <td><?php echo $kvv['notes'];?></td> 
           
           <td> <?php if($kvv['cat'] == 2){echo '积分换券';}elseif($kvv['cat'] == 3){echo '后台赠送';}
		   elseif($kvv['cat'] == 4){echo '使用礼品券';}elseif($kvv['cat'] == 1){echo '签到积分';}
		   elseif($kvv['cat'] == 5){echo '会员充值';}elseif($kvv['cat'] == 6){echo '开卡赠送';}else{echo '消费获取积分';}
		   ?>
		   </td> 

            <td>
			<button class="btn btn-sm btn-danger" onclick="deltheItem(this,<?php echo $kvv['id'];?>);"><strong> 删 &nbsp; 除 </strong></button>
			</td>
           </tr>
		   <?php }}else{?>
		   <tr class="widget-list-item"><td colspan="11">暂无记录</td></tr>
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
  });


   /****删除客户*****/
  function deltheItem(obj,piid){
	swal({
		title: "您确定要删除此条记录！",   
		text: "",
		type: "warning",   
		showCancelButton: true,   
		confirmButtonText: "确定删除",   
		cancelButtonText: "取消删除",   
		closeOnConfirm: true,   
		closeOnCancel: true 
	}, function(isConfirm){
		if (isConfirm) {
			$.ajax({
			url: "?m=User&c=memberLoc&a=deluserecord&cdid=<?php echo $cdid;?>",
			type: "POST",
			dataType: "json",
			data:{piid:piid},
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