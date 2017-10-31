
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>收银台 | 员工列表</title>
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
	.jbxi_bg>div{border-top: 1px solid #f2f2f2; padding: 20px 0; margin: 0px !important;}
	.jbxi_bg>div label{ display: block; width: 100px; text-align: right;height: 30px; line-height: 30px; overflow: hidden; float: left;}
	.jbxi_bg>div>p{margin-left: 20px; width: 50%; height: 30px; line-height: 30px; overflow: hidden; text-overflow: ellipsis;float: left;}
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
	</style>
</head>

<body>

    <div id="wrapper">
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>

        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>代理商信息管理</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>代理中心</a>
                        </li>
                        <li>
                            <a>代理列表</a>
                        </li>
                        <li class="active">
                            <strong>代理商信息管理</strong>
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
            			<li>业务员</li>
            			<li>商户</li>
            			
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
                                	<h4 class="tit_h4"><span>基本信息</span><a style="float: right;" href="#">编辑</a></h4>
                                    <div class="form-group clearfix">
                                        <label>代理商名称</label>
                                        <p>撒范德萨的</p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label>用户名</label>
                                        <p>撒范德萨的</p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label >佣金返点</label>
                                        <p>50%</p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label>联系人</label>
                                        <p>撒范德萨的</p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label>联系电话</label>
                                        <p>撒范德萨的</p>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label>服务热线</label>
                                        <p>023-565656565</p>
                                    </div>
                                </div>


                            </div>
                    	</div>
                    	
                    	<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：业务员
                        -->
                                                 
                         <div class="ibox-content yc" style="border-top:none">
                            <label>
                                                 业务员名称
                            <input type="text"  id="filter" placeholder="输入业务员名称" style="width: 160px; height: 30px;">
                            <button style=" background: #44b549; border: none; padding: 0 20px; border-radius: 5px; height: 30px; color: #FFFFFF;">搜索</button>
                             <button style=" background: #44b549; border: none; padding: 0 20px; border-radius: 5px; height: 30px; color: #FFFFFF;">导出到excel</button>
                            </label>
							<div class="employersDelAll" >
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter>
                                <thead>
                                <tr>
                                    <th style="text-align: center;"  data-hide="phone">序号</th>
                                    <th  style="text-align: center;">登录账号</th>
                                    <th style="text-align: center;" data-hide="phone">业务员名称</th>
                                    <th style="text-align: center;" data-hide="phone">佣金返点</th>
                                    <th style="text-align: center;" data-hide="phone">添加时间</th>
                                    <th style="text-align: center;" data-hide="phone">操作</th>
                                </tr>
                                </thead>
                                <tbody class="js-list-body-region" id="table-list-body">
									
										<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>1</td>
												<td>Jason</td>
												<td>沈万三</td>
												<td>50%</td>
												<td>2016-10-25</td>
												<td>
													<p>
														<a href="#"><button class="btn btn-sm btn-info" style="background: #008fd3;">详情</button></a>
													</p>
												</td>
												
										</tr>
									<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>1</td>
												<td>Jason</td>
												<td>沈万三</td>
												<td>50%</td>
												<td>2016-10-25</td>
												<td>
													<p>
														<a href="#"><button class="btn btn-sm btn-info" style="background: #008fd3;">详情</button></a>
													</p>
												</td>
												
										</tr>
								</tbody>
                            </table>
							</div>
                        </div>
                    <!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：商户
                        -->
                       <div class="ibox-content yc" style="border-top:none">
                            <label>
                                                商户名称
                            <input type="text"  id="filter" placeholder="输入商户名称" style="width: 160px; height: 30px;">
                            <button style=" background: #44b549; border: none; padding: 0 20px; border-radius: 5px; height: 30px; color: #FFFFFF;">搜索</button>
                             <button style=" background: #44b549; border: none; padding: 0 20px; border-radius: 5px; height: 30px; color: #FFFFFF;">导出到excel</button>
                            </label>
							<div class="employersDelAll" >
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter>
                                <thead>
                                <tr>
                                    <th style="text-align: center;"  data-hide="phone">商户ID</th>
                                    <th  style="text-align: center;">登录账号</th>
                                    <th style="text-align: center;" data-hide="phone">业务员名称</th>
                                    <th style="text-align: center;" data-hide="phone">佣金返点</th>
                                    <th style="text-align: center;" data-hide="phone">添加时间</th>
                                    <th style="text-align: center;" data-hide="phone">操作</th>
                                </tr>
                                </thead>
                                <tbody class="js-list-body-region" id="table-list-body">
									
										<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>1</td>
												<td>Jason</td>
												<td>沈万三</td>
												<td>50%</td>
												<td>2016-10-25</td>
												<td>
													<p>
														<a href="#"><button class="btn btn-sm btn-info" style="background: #008fd3;">详情</button></a>
													</p>
												</td>
												
										</tr>
									<tr class="widget-list-item bd_nr" style="text-align: center;">
												<td>1</td>
												<td>Jason</td>
												<td>沈万三</td>
												<td>50%</td>
												<td>2016-10-25</td>
												<td>
													<p>
														<a href="#"><button class="btn btn-sm btn-info" style="background: #008fd3;">详情</button></a>
													</p>
												</td>
												
										</tr>
								</tbody>
                            </table>
							</div>
                        </div>
                        
                    <!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：打印机
                        -->
                        
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