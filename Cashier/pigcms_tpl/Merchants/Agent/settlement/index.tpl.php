
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>代理商|我的结算</title>
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>


    <!-- FooTable -->
    <link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
		<link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/cashier.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
<script
	src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
<!-- Data picker -->
<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
	<style>
		.ibox{
		 	border: 1px solid #e7eaec;
		}
		.part_item {
  			background: none repeat scroll 0 0 #fff;
  			border: 1px solid #ccc;
  			border-radius: 5px;
  			padding-bottom: 15px;
  			margin-bottom: 10px;
		}
		.form .part_item p {
  			display: inline-block;
  			font-size: 14px;
  			overflow: hidden;
  			padding: 10px 20px 0;
  			text-overflow: ellipsis;
  			white-space: nowrap;
		}
		.part_item_b {
  			border-top: 1px solid #ccc;
  			margin-top: 10px;
		}
		.form .part_item p.active {
  			color: #f87b00;
		}
		.part_item input {
  			font-size: 14px;
  			margin-bottom: 2px;
  			margin-right: 5px;
		}
		.pagination{
			margin:0px;
		}
		.mustInput {
  			color: red;
  			margin-right: 5px;
		}
		@media (min-width: 768px){
			.form .part_item p {
				width: 37%;
			}
		}
		@media (min-width: 992px){
			.form .part_item p {
				width: 24%;
			}
		}
	.form-control, .single-line{width: 50%;}
	
	.ibox {
    border: 1px solid #e7eaec;
    border-top: none;
}
	
	.tit ul li{ float: left; padding: 0 3%; list-style: none; color: #b1bac8; cursor: pointer; height: 40px; line-height: 40px;}
	.tit ul li:hover{ color: #8f99a7;}
	.cont{ background: #FFFFFF; color: #000000 !important;}
	.bd_nr>td{ line-height: 30px !important; height:30px !important; padding: 10px 0px 0px !important;}
	.bd_nr>td>button{ padding: 0 10px; margin: 0 10px; border: none; border-radius: 5px; height:30px; color: #FFFFFF;}
	.yc{display: none;}
	.tit_h4{ background: #f2f2f2; height: 40px; line-height: 40px; padding: 0 20px; width: 100%;margin:0px !important;}
	.tit_h4 span{ color: #676a6c; font-weight: normal;}
	.tit_h4 a{ color: #44b549; font-weight: normal;}
	.jbxi_bg>div{border-top: 1px solid #f2f2f2; padding: 20px 0; margin: 0px !important;}
	.jbxi_bg>div label{ display: block; width: 100px; text-align: right;height: 30px; line-height: 30px; overflow: hidden; float: left;}
	.jbxi_bg>div>p{margin-left: 20px; width: 50%; height: 30px; line-height: 30px; overflow: hidden; text-overflow: ellipsis;float: left;}
	.form-control{
    width: 80%;
}
.footable-odd {
    background-color: #ffffff;
}
h3{ width: 100%; height: 40px; line-height: 40px; border-bottom: 1px solid #f2f2f2; border-top: 3px solid #B5D6FD; font-size: 18px; background: #FFFFFF; margin: 0px; padding-left: 10px; font-weight: normal;}
th{ font-size: 16px }
.sl{background: #ebebed; border-bottom: 1px solid #EEEEEE;border-top: 1px solid #EEEEEE; height: 40px; line-height: 40px; text-align: right;}
.sl>span{margin-right: 40px;}
.fl{float: left;}
.fr{ float: right;}

.whz{color: red;}
.yhz{color: green;}
tbody>tr>td{ padding: 10px 0 !important;}
	</style>
</head>

<body>

    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>

        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>代理结算</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Agent</a>
                        </li>
                        <li>
                            <a>代理中心</a>
                        </li>
                       
                        <li class="active">
                            <strong>我的结算</strong>

                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	
            	
                <div class="col-lg-12">
                    <div class="ibox float-e-margins" style="position: relative">
                          <h3>我的结算 </h3>
<!--                        --><?php //if ($datas[0]['status']==1):?>
<!--                        <button style="position: absolute;right: 170px;top: 3px;background: #008fd3;height: 38px;width: 90px;font-size: 18px" class="btn btn-sm btn-info deposit" value="--><?php //echo $id?><!--"  aid="--><?php //echo $aid?><!--" >申请提现</button>-->
<!--                        --><?php //endif;?>
<!--                        --><?php //if ($datas[0]['status']==3):?>
<!--                            <button style="position: absolute;right: 170px;top: 3px;background: #008fd3;height: 38px;width: 90px;font-size: 18px" class="btn btn-sm btn-info "  >审核中</button>-->
<!--                        --><?php //endif;?>
                         <div class="ibox-content" style="border-top:none; margin-bottom:20px">
					<div class="employersDelAll" >
							
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter="#filter" style="border: 1px solid #f2f2f2;">
                                <thead>
                                <tr style="background: #f2f2f2">
                                    <th style="text-align: center;"  data-hide="phone">日期</th>
                                    <th  style="text-align: center;">月总流水</th>
                                    <th style="text-align: center;" data-hide="phone">月佣金金额</th>
                                    <th style="text-align: center;">查看</th>
<!--                                    <th style="text-align: center;" data-hide="phone">操作</th>-->
                                </tr>
                                </thead>
                                <tbody class="js-list-body-region" id="table-list-body">
                                <?php $count_turnover=0 ;$count_deposit=0;?>
                                <?php foreach ($datas as $v):?>
										<tr class="widget-list-item bd_nr" style="text-align: center;">
                                            <?php $count_turnover=$count_turnover+$v['count_turnover'] ?>
                                            <?php $count_deposit=$count_deposit+$v['count_deposit'] ?>
                                            <td><?php echo $v['date'] ?></td>

												<td><?php echo $v['count_turnover'] ?></td>

												<td><?php echo $v['count_deposit'] ?></td>
                                            <td>
                                                <a class="btn btn-sm btn-info" href="?m=Agent&c=settlement&a=info&id=<?php echo $v['id'];?>">查看详情</a>
                                            </td>
<!--												<td>-->
<!--													<p>-->
<!--                                                        --><?php //if ($v['status']==1):?>
<!--                                                         <button class="btn btn-sm btn-info deposit"  style="background: #008fd3;" value="--><?php //echo $v['id']?><!--" aid="--><?php //echo $v['aid']?><!--" )">申请提现</button>-->
<!--													    --><?php //endif;?>
<!--                                                        --><?php //if ($v['status']==3):?>
<!--                                                            <button class="btn btn-sm btn-info"  style="background: #008fd3;" " )">提现审核中</button>-->
<!--                                                        --><?php //endif;?>
<!--                                                    </p>-->
<!--												</td>-->
												
										</tr>
                                     <?php endforeach; ?>
                                <tr class="widget-list-item bd_nr" style="text-align: center;">
                                    <td>合计</td>
                                    <td><?php echo $count_turnover?></td>

                                    <td><?php echo $count_deposit?></td>


                                    <td>
                                        <?php if ($datas[0]['status']==1):?>
                                            <button style="background: #008fd3;height: 38px;width: 90px;font-size: 18px" class="btn btn-sm btn-info deposit" value="<?php echo $id?>"  aid="<?php echo $aid?>" >申请提现</button>
                                        <?php endif;?>
                                        <?php if ($datas[0]['status']==3):?>
                                            <button style="background: #008fd3;height: 38px;width: 90px;font-size: 18px" class="btn btn-sm btn-info "  >审核中</button>
                                        <?php endif;?>
                                    </td>

                                </tr>

								</tbody>
                            </table>
                            <p style="color: red;">注:申请提现单笔扣提现手续费3元</p>
							</div>
                        </div>
                    <!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：已划账
                        -->
                        <h3>提现记录</h3>
                       <div class="ibox-content" >
                            
							<div class="employersDelAll" >
								
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter style="margin-bottom: 0px;">
                                <thead>
                                <tr style="background: #f2f2f2">
                                    <th style="text-align: center;"  data-hide="phone">日期</th>
                                    <th  style="text-align: center;">当月流水</th>
                                    <th  style="text-align: center;">金额</th>
                                    <th style="text-align: center;"  data-hide="phone">提现日期</th>
                                    <th style="text-align: center;" data-hide="phone">状态</th>
                                </tr>
                                </thead>
                                <tbody class="js-list-body-region" id="table-list-body">
                                <?php $money=0?>
									<?php if(!empty($deposit)){ foreach ($deposit as $ssk => $ssv): ?>
                                        <?php $money=$money+ $ssv['count_deposit']; ?>
									
										<tr class="widget-list-item bd_nr" style="text-align: center;">
                                                <td><?php echo date($ssv['date']); ?></td>

												<td><?php echo $ssv['count_turnover']; ?></td>
                                                <td><?php echo $ssv['count_deposit']; ?></td>
                                            <td><?php echo date('Y-m-d H:i:s',$ssv['addtime']); ?></td>
												<td><span class="<?php if ($ssv['status']==3){echo 'w';}else{echo 'y';} ?>hz"><?php if ($ssv['status']==3){echo '审核中';}else{echo '已划账';} ?></span></td>
												
												
										</tr>
											
									<?php endforeach ?>
									<?php } ?>	
								</tbody>
                            </table>
                            <p style="text-align: right; padding-right: 150px; height: 50px; background: #f2f2f2; line-height: 50px;">合计提现金额:<?php echo $money ?></p>
							</div>
                        </div>
             			<?php echo $p;?>
                        
                    </div>
                </div>
            </div>
        </div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
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
    <script>
    	$(".tit>ul>li").click(function(){
    		var index=$(this).index();
    		var web = $(this).text();
    		$(".active>strong").html(web)
    		$(this).addClass("cont")
    		$(this).siblings().removeClass("cont");
    		$(".ibox>div").eq(index).show();
    		$(".ibox>div").eq(index).siblings().hide();
    	});
    </script>
    
	
	<script type="text/html" id="employersEditTpl">
		<figure>
              <iframe width="425" height="349" src="?m=User&c=merchant&a=employersEdit&eid={($eid)}" frameborder="0"></iframe>
        </figure>
	</script>

    <!-- FooTable -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all.min.js"></script>
	
	<!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
	
	<!-- Jquery Validate -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/validate/jquery.validate.min.js"></script>

<script>
//申请提现
$(function () {
    $('.deposit').click(function () {

        var id=$(this).val();
        var aid=$(this).attr('aid');
        $.post('/merchants.php?m=Agent&c=settlement&a=deposit',{id:id,aid:aid},function (data) {
            if (data.status == 1) {
                swal({
                    title: data.error,
//            text: "确认提交",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    closeOnConfirm: false,
                    closeOnCancel: true
                },function (isConfirm) {
                    if(isConfirm){
                        window.location.reload();
                    }
                });

            }else {
                swal({
                    title: data.error,
//            text: "确认提交",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonText: "确定",
                    cancelButtonText: "取消",
                    closeOnConfirm: false,
                    closeOnCancel: true
                })
            }

        },'json')
    })
})

</script>
</body>
</html>