
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>员工信息</title>
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>


    <!-- FooTable -->
    <link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
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
	
	.tit ul li{ float: left; padding: 0 3%; list-style: none; color: #b1bac8; cursor: pointer; height: 30px; line-height: 30px;}
	.tit ul li:hover{ color: #8f99a7;}
	.cont{ background: #FFFFFF; color: #000000 !important;}
	.bd_nr>td{ line-height: 30px !important; height:30px !important; padding: 10px 0px 0px !important;}
	.bd_nr>td>button{ padding: 0 10px; margin: 0 10px; border: none; border-radius: 5px; height:30px; color: #FFFFFF;}
	.yc{display: none;}
	.tit_h4{ background: #f2f2f2; height: 40px; line-height: 40px; padding: 0 20px; width: 100%;margin:0px !important;}
	.tit_h4 span{ color: #676a6c; font-weight: normal;}
	.tit_h4 a{ color: #44b549; font-weight: normal;}
	.jbxi_bg>div{border-top: 1px solid #f2f2f2; padding: 20px 0; margin: 0px !important;float: left; width: 100%;}
	.jbxi_bg>div>label{ width: 100px; text-align: right; float: left; margin-right: 30px;}
	.jbxi_bg>div>p>label{padding-top: 5px;}
	.jbxi_bg>div>p>input{border: none;}
	.form-control{
    width: 80%;
}
.footable-odd {
    background-color: #ffffff;
}
.sl{background: #ebebed; border-bottom: 1px solid #EEEEEE;border-top: 1px solid #EEEEEE; height: 40px; line-height: 40px; text-align: right;}
.sl>span{margin-right: 40px;}
.fl{float: left;}
.fr{ float: right;}

.ewm{ margin-top:70px; height: 373px; position: relative;}
.ewm>dl{ float: left; margin: 0 20px;}
.ewm>dl:nth-child(2){ position: absolute; bottom: -20px;left: 280px;}
.ewm>dl:nth-child(3){ position: absolute; bottom: -20px;left: 460px;}
.ewm>dl>dd>img{width: 100%; height: auto;}
.ewm>dl>dt{ margin-top: 20px;}
.ewm>dl>dt>a{ display: block; width: 120px; height: 30px; line-height: 30px; text-align: center; color: #FFFFFF; background: #36a9e0; border-radius: 5px; margin: 0 auto;}

.tj{position: absolute; bottom: -55px; left: 50%; width: 70px; height: 30px; margin-left: -35px; background: #4EBE53; border-radius: 5px; border: none; color: #FFFFFF;}	
</style>
</head>

<body>

    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>

        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>员工列表</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>门店列表</a>
                        </li>
                        <li>
                            <a>门店信息管理</a>
                        </li>
                        <li>
                        	<a>店员列表</a>
                        </li>
                        <li class="active">
                            <strong>店员信息管理</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="tit">
            		<ul class="clearfix " style="margin-bottom: 0px; padding-left: 16px;">
            			<li class="cont">基本信息</li>
            			<li>订单</li>
            			<li>微信支付</li>
            		</ul>
            	</div>
            	
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                    	<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：基本信息
                        -->
                    	<div class="ibox-content" style="border-top:none;">
                    		
                    		  <div class="panel-body" style="padding: 0px; ">
                                <div class="form-horizontal form-border jbxi_bg" style="width: 100%; margin: 0 auto; border: 1px solid #EEEEEE;">
                                	<h4 class="tit_h4"><span>店员基本本信息</span><a style="float: right;" href="/merchants.php?m=User&c=merchant&a=assistantedito">编辑</a></h4>
                                    <div class="form-group clearfix">
                                        <label>昵称</label>
                                        <p><?php echo $row['username']?>去去去</p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label>用户级别</label>
                                        <p><?php if($row['level']==1){ echo "店长";}else{echo "店员";}?></p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label >用户名</label>
                                        <p><?php echo $row['account']?></p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label>收款权限</label>
                                        <p><?php if($row['is_receivables']==1){ echo "有";}else{echo "无";}?></p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label>退款权限</label>
                                        <p><?php if($row['is_refund']==1){ echo "有";}else{echo "无";}?></p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label>隶属门店</label> 
                                        <p><?php echo $store;?></p>
                                    </div>
                                </div>


                            </div>
                    	</div>
                    	
                    	
                    <!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：订单
                        -->
                       <div class="ibox-content yc" style="border-top:none">
                            <form><label>
                                                  店员名称
                            <input type="text"  id="filter" placeholder="输入店员名称" style="width: 160px; height: 30px;">
                            <button style=" background: #44b549; border: none; padding: 0 10px; border-radius: 5px; height: 30px; color: #FFFFFF;">搜索</button>
                            </label></form>
							<div  class="employersDelAll" >
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter style="margin-bottom: 0px;">
                                <thead>
                                <tr>
                                    <th style="text-align: center;"  data-hide="phone">序号</th>
                                    <th  style="text-align: center;">交易单号</th>
                                    <th style="text-align: center;" data-hide="phone">金额</th>
                                    <th style="text-align: center;" data-hide="phone">支付状态</th>
                                    <th style="text-align: center;" data-hide="phone">交易时间</th>
                                    <th style="text-align: center;" data-hide="phone">交易类型</th>
                                    <th style="text-align: center;" data-hide="phone">付款方式</th>
                                    <th style="text-align: center;" data-hide="phone">所属门店</th>
                                    <th style="text-align: center;" data-hide="phone">操作</th>
                                </tr>
                                </thead>
                                <tbody class="js-list-body-region" id="table-list-body">
									
										<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>1</td>
												<td>014565154879525487</td>
												<td>56.8</td>
												<td>付款完成</td>
												<td>2016-9-25 10:23:54</td>
												<td>微信支付</td>
												<td>条码支付</td>
												<td>康庄美地店</td>
												<td>
													<p>
														<button class="btn btn-sm btn-info" style="background: #44b549;">详情</button>
													</p>
												</td>	
										</tr>
										<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>1</td>
												<td>014565154879525487</td>
												<td>56.8</td>
												<td>付款完成</td>
												<td>2016-9-25 10:23:54</td>
												<td>微信支付</td>
												<td>条码支付</td>
												<td>康庄美地店</td>
												<td>
													<p>
														<button class="btn btn-sm btn-info" style="background: #44b549;">详情</button>
													</p>
												</td>	
										</tr>
										<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>1</td>
												<td>014565154879525487</td>
												<td>56.8</td>
												<td>付款完成</td>
												<td>2016-9-25 10:23:54</td>
												<td>微信支付</td>
												<td>条码支付</td>
												<td>康庄美地店</td>
												<td>
													<p>
														<button class="btn btn-sm btn-info" style="background: #44b549;">详情</button>
													</p>
												</td>	
										</tr>
								</tbody>
                            </table>
                            <p class="sl"><span>成交笔数:3</span><span>成交金额：45854</span></p>
							</div>
                        </div>
                        
                    <!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：微信支付
                        -->
                        <div class="ibox-content yc" style="border-top:none;">
                    		
                    		  <div class="panel-body" style="padding: 0px; ">
                                <form class="form-horizontal form-border jbxi_bg clearfix" style="width: 100%; margin: 0 auto; border: 1px solid #EEEEEE; position: relative;">
                                	<h4 class="tit_h4"><span>固定二维码位置</span></h4>
                                    <div class="form-group clearfix">
                                        <label>商户显示名称</label>
                                        <p><input type="text" placeholder="输入商户名称"></p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label>门店显示名称</label>
                                        <p><input type="text" placeholder="输入商户名称"></p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label >店员显示名称</label>
                                        <p><input type="text" placeholder="输入商户名称"></p>
                                    </div>
                                    <button class="tj">提交</button>
                                </form>
								<div class="ewm clearfix">
									<dl>
										<dd><img src="./Cashier/pigcms_static/image/fkc.jpg"></dd>
										<dt><a href="#">下载付款二维码</a></dt>
									</dl>
									<dl>
										<dd><img src="./Cashier/pigcms_static/image/ewm.jpg"></dd>
										<dt><a href="#">下载付款二维码</a></dt>
									</dl>
									<dl>
										<dd><img src="./Cashier/pigcms_static/image/ewm.jpg"></dd>
										<dt><a href="#">下载通知二维码</a></dt>
									</dl>
								</div>

                            </div>
                    	</div>
                    	<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：end
                        -->
                        
                    </div>
                </div>
            </div>
        </div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
     </div>
    </div>
    <script>
    	$(".tit>ul>li").click(function(){
    		var index=$(this).index();
    		var web = $(this).text();
    		$(".active>strong").html("店员"+web)
    		$(this).addClass("cont")
    		$(this).siblings().removeClass("cont");
    		$(".ibox>div").eq(index).show();
    		$(".ibox>div").eq(index).siblings().hide();
    	});
    </script>
    
    
    
	<div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog modal-lg">
        	<div class="modal-content">
            	<div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加员工</h4>
                </div>
                <div class="modal-body clearfix">
					<form id="employersForm" class="form" action="?m=User&c=merchant&a=employersAdd" method="post">
						<div class="col-lg-12">
							<div class="ibox">
                        		<div class="ibox-title">
                           			<h5>账户信息</h5>
                        		</div>
                        		<div class="ibox-content">
                            		<div class="form-group">
										<label><span class="mustInput">*</span>员工名称:<span class="f999">(20字以内)</span></label>
										<input type="text"  id="username" placeholder="请输入员工名称" name="username" class="form-control required" aria-required="true">
									</div>
									<div class="form-group">
										<label><span class="mustInput">*</span>登录账号:</label>
										<input type="text" id="account" placeholder="请输入登录账号" name="account" class="form-control required"aria-required="true">
									</div>
									<div class="form-group">
										<label><span class="mustInput">*</span>手机号:</label>
										<input type="tel" id="phone" placeholder="请输入员工的手机号" name="phone" class="form-control required" aria-required="true">
									</div>
									<div class="form-group">
										<label><span class="mustInput">*</span>邮箱:</label>
										<input type="email" id="email" placeholder="请输入邮箱" name="email" class="form-control required" aria-required="true">
									</div>
									<div class="form-group">
										<label><span class="mustInput">*</span>密码:</label>
										<input type="password" id="password" placeholder="请输入密码(6到20个字符)" name="password" class="form-control required" aria-required="true">
									</div>
									<div class="form-group">
										<label><span class="mustInput">*</span>确认密码:<span class="f999"></span></label>
										<input type="password" id="confirm" placeholder="" name="confirm" class="form-control required" aria-required="true">
									</div>
									<div class="form-group">
										<label><span class="mustInput"></span>门店选择：<span class="f999"></span></label>
										<?php if(empty($StoreInfo)){?>
										 <div style="margin-top:10px">您还没有门店，请去门店管理里去创建吧。<br/>如果您不选门店，员工账号登录进来将可以看见所有的支付订单和卡券，会员卡<div>
										<?php }else{?>
										 <select name="storeid" class="form-control" style="z-index:999">
										  <option value="0">不选择门店</option>
										  <?php foreach($StoreInfo as $svv){?>
										   <option  value="<?php echo $svv['id'];?>" ><?php echo $svv['business_name'].$svv['branch_name']?></option>
										  <?php }?>
										 </select>
										<div style="margin-top:10px">如果您不选门店，员工账号登录进来将可以看见所有的支付订单和卡券，会员卡<div>
										<?php }?>
									</div>

                        		</div>
                    		</div>
						</div>
						<div class="col-lg-12">
							<div class="ibox">
                    	    	<div class="ibox-title">
                    	       		<h5>权限设置</h5>
                    	    	</div>
                    	    	<div class="ibox-content">
                    	        	<div id="permission_list">
										<?php foreach($authority as $key=>$val){ ?>
											<div class="part_item">
												<div class="part_item_t">
													<p><b><input type="checkbox" class="checkAll"><?php echo $val['Des'];unset($val['Des']);?></b></p>
												</div>
												<div class="part_item_b">
													<?php foreach($val as $k=>$v){?>
														<p><input type="checkbox" name="authority[]" value="<?php echo 'Merchants/User/'.$key.'/'.$k;?>"><?php echo $v; ?></p>
													<?php } ?>
												</div>
											</div>
										<?php } ?>
									</div>
                    	    	</div>
                    		</div>
						</div>
					</form>
               	</div>

                <div class="modal-footer">
                	<button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                	<button type="button" class="btn btn-primary formSubmit">保存</button>
                </div>
          	</div>
        </div>
    </div>
	<a href="javascript:void(0)" class="employersEditJump"  data-toggle="modal" data-target="#myModal6" data-toggle="tooltip" data-placement="left" title="" data-original-title="员工信息编辑" style="display: none;">员工信息编辑</a>
	<div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog modal-lg">
        	<div class="modal-content">
            	<div class="modal-header">
				 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">员工信息编辑</h4>
                </div>
                <div class="modal-body clearfix">
					<div class="col-lg-12">
					</div>
               	</div>
				<div class="modal-footer">
                	<button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                </div>
          	</div>
        </div>
     </div>
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

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
			employers.init();
        });
		!function(a,b){
			var employers = employers || {};
			employers.init = function(){
				var c = employers;
				b('.footable').footable();
				b('.i-checks').iCheck({
                	checkboxClass: 'icheckbox_square-green',
                	radioClass: 'iradio_square-green',
            	});
				b('#check_box').on('ifChanged', function(){
					c.selectall('id[]','check_box');
				});
				b('.info_del_all').click(function(){
					c.delAll();
				});
				b('.part_item .checkAll').click(function(){
					var checkItems = b(this).parents('.part_item_t').siblings('.part_item_b').find('p').find('input[name="authority[]"]');
					if (b(this).is(':checked') == false) {
						checkItems.each(function(ke,el){
							$(el).iCheck('uncheck');
						});
					}else{
						checkItems.each(function(ke,el){
							$(el).iCheck('check');
						});
					}
				});
				jQuery.extend(jQuery.validator.messages, {
  					required: "必填字段",
  					remote: "请修正该字段",
  					email: "请输入正确格式的电子邮件",
  					equalTo: "请再次输入相同的值",
  					maxlength: jQuery.validator.format("请输入一个长度最多是 {0} 的字符串"),
  					minlength: jQuery.validator.format("请输入一个长度最少是 {0} 的字符串"),
				});
				b('#employersForm').validate({
                    errorPlacement: function (error, element){
                            element.before(error);
                    },
                    rules: {
                        confirm: {
                            equalTo: "#password"
                        },
						account: {
							minlength: 4
						},
						password: {
							minlength: 4
						}
                    }
                });
				b('.formSubmit').click(function(){
					if(b('#account').val() != ''){
						$.post('?m=User&c=merchant&a=checkAccount',{account:b('#account').val()},function(re){
							if(re.status == 0){
								b('#account').addClass('error');
								swal("错误", re.msg+" :)", "error");
							}else if(re.status == 1){
								b('#employersForm').submit();
							}
						},'json');
					}else{
						b('#employersForm').submit();
					}
				});
				b('.status-checkbox').change(function(){
					var i = b(this).attr('data-id'),s = b(this).is(':checked') ? 1 : 0;
					$.post('?m=User&c=merchant&a=field',{eid:i,status:s},function(re){
						if(re.status == 0){
							swal("错误", re.msg+" :)", "error");
						}
					},'json');
				});
				b('.employersDel').click(function(){
					var c = b(this);
					swal({
        				title: "是否删除这条数据?",
        				text: "删除数据后将无法恢复，确认要删除吗！",
        				type: "warning",
                   	 	confirmButtonColor: "#DD6B55",
                   	 	confirmButtonText: "删除",
                    	cancelButtonText: "取消",
                    	closeOnConfirm: false,
                    	showCancelButton: true,
    				}, function (){
						$.post('?m=User&c=merchant&a=employersDel',{eid:c.attr('data-id')},function(re){
							if(re.status == 0){
								swal("错误", re.msg+" :)", "error");
							}else{
								swal("成功", re.msg+" :)", "success");
								c.parents('tr').remove();
								b('.footable').footable();
							}
						},'json');
    				});
				});
				b('.employersEdit').click(function(){
					c.edit(b(this).attr('data-id'));
				});
			};
			employers.selectall = function(name,id){
				var checkItems = b('input[name="'+name+'"]');
				if ($("#"+id).is(':checked') == false) {
					checkItems.each(function(ke,el){
						$(el).iCheck('uncheck');
					});
				}else{
					checkItems.each(function(ke,el){
						$(el).iCheck('check');
					});
				}
			}
			employers.delAll = function(){
				swal({
        			title: "是否删除选中?",
        			text: "删除数据后将无法恢复，确认要删除吗！",
        			type: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "删除",
                    cancelButtonText: "取消",
                    closeOnConfirm: false,
                    showCancelButton: true,
    			}, function (){
					var checkItems = b('input[name="id[]"]'),c = false;
			
					checkItems.each(function(ke,el){
						if($(el).is(':checked') == true){
							c = true;
						}
					});
					if(c == false){
						swal("错误", "你至少需要选中一项 :)", "error");
						return false;
					}
					$('.employersDelAll').submit();
    			});
			}
			employers.edit = function(data){
				var $data = b('#employersEditTpl').html().replace('{($eid)}',data);
				b('#myModal6').find('.modal-content .modal-body').find('.col-lg-12').html($data);
				b('.employersEditJump').click();
				employers.iframeRresponsible();
				var index = window.setTimeout(function(){
					$(window).resize();
				},200);
			}
			employers.iframeRresponsible = function(){
				var $allObjects = $("iframe, object, embed"),
        		$fluidEl = $("figure");

   	 			$allObjects.each(function() {
        			$(this)
           			 // jQuery .data does not work on object/embed elements
            		.attr('data-aspectRatio', this.height / this.width)
            		.removeAttr('height')
            		.removeAttr('width');
    			});
   		 		$(window).resize(function() {
        			var newWidth = $fluidEl.width();
        			$allObjects.each(function() {
        			    var $el = $(this);
        			    $el
        			    .width(newWidth)
        			    .height(newWidth * $el.attr('data-aspectRatio'));
        			});
    			}).resize();
			}
			a.employers = employers;
		}(window,jQuery);
    </script>
</body>
</html>