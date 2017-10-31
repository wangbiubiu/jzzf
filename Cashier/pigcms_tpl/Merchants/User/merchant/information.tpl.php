
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

	.tit_h4{ height: 40px; line-height: 40px; padding: 0 20px; width: 100%;margin:0px !important;}
	.tit_h4 span{ color: #676a6c; font-weight: normal;}
	.tit_h4 a{ color: #44b549; font-weight: normal;}
	.jbxi_bg>div{border-top: 1px solid #f2f2f2; padding: 20px 0; margin: 0px !important;float: left; width: 100%;}
	.jbxi_bg>div>label{ width: 100px; text-align: right; float: left; margin-right: 30px;}
	.jbxi_bg>div>div>label{padding-top: 5px;}
	.jbxi_bg>div>div>input{border: none;}
	.form-control{
    width: 80%;
}
.footable-odd {
    background-color: #ffffff;
}
.bc{position: absolute; bottom: -55px; left: 50%; width: 70px; height: 30px; margin-left: -35px; background: #4EBE53; border-radius: 5px; border: none; color: #FFFFFF;}
.menu_controls>div>label{ float: left; display: inline-block; width: 120px; text-align: right; margin-right: 10px}
.menu_controls>div>select{ width: 200px;    float: left; margin-right: 10px}
.menu_controls>input{width: 200px}
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
                        <li class="active">
                            <strong>编辑基本信息</strong>
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
                    	<!--
                        	作者：2721190987@qq.com
                        	时间：2016-10-20
                        	描述：基本信息
                        -->
                    	<div class="ibox-content" style="border-top:none;">
                    		
                    		  <div class="panel-body" style="padding: 0px; ">
                                      <form action="?m=User&c=merchant&a=information" method="post" class="form-horizontal form-border jbxi_bg clearfix" style="width: 80%; margin: 0 auto 60px;position: relative; border: 1px solid #EEEEEE;">
                                	<h4 class="tit_h4"><span>基本信息</span></h4>
                                    <div class="form-group clearfix">
                                        <label class="control-label">名称</label>
                                        <div>
                                            <input type="hidden" name="sid" value="<?php echo $store['id'] ?>">
                                            <input type="text" name="business_name" value="<?php echo $store['business_name'];?>" class="form-control" placeholder="输入店名">
                                        </div>
                                    </div>
<!--                                    <div class="form-group clearfix">
                                        <label class="control-label">地址</label>
                                        <div>
                                            <input type="text" class="form-control" placeholder="输入地址">
                                        </div>
                                    </div>-->
                                    <div class="frm_controls menu_controls clearfix" style="margin-right:10px;"> 
                                        <div class="clearfix">
                                        <label>地址</label>
                                        <select name="provinceid" id="provinceS" class="form-control province" onchange="GetCity();">
                                            <option value="0">请选择</option>
                                            <?php foreach ($districts as $avv){?>
                                                <option value="<?php echo $avv['id'];?>" <?php if($avv['id'] == $store['provinceid']){ echo 'selected="selected"';}?> data-fullname="<?php echo $avv['fullname']?>" data-lng="" data-lat=""><?php echo $avv['fullname']?></option>
                                           <?php }?> 
                                        </select>
                                        
                                        <select name="cityid" id="cityS" class="form-control province" onchange="GetDistrict();">
                                            <option value="0">请选择</option>
                                            <?php foreach ($cityname as $avv){?>
                                                <option value="<?php echo $avv['id'];?>" <?php if($avv['id'] == $store['cityid']){ echo 'selected="selected"';}?> data-fullname="<?php echo $avv['fullname']?>" data-lng="" data-lat=""><?php echo $avv['fullname']?></option>
                                           <?php }?> 
                                        </select>
                                       
                                        <?php if ($countyname){?>
                                        <select name="districtid" id="districtS" class="form-control province" onchange="GetCircle();">
                                            <option value="0">请选择</option>
                                            <?php foreach ($countyname as $avv){?>
                                                <option value="<?php echo $avv['id'];?>" <?php if($avv['id'] == $store['districtid']){ echo 'selected="selected"';}?> data-fullname="<?php echo $avv['fullname']?>" data-lng="" data-lat=""><?php echo $avv['fullname']?></option>
                                           <?php }?> 
                                        </select>
                                        <?php }?>
                                        <span class="tishi" style="color: red; display: none;"></span>
                                        </div>
                                        <div class="clearfix">
                                        <label  style="margin-top: 10px;">详细地址</label>
                                        <div style="margin-top: 10px;"><input style=" border:1px solid #f2f2f2; width: 200px;"  name="address" value="<?php echo $store['address']?>" class="form-control" type="text" placeholder="输入详细地址"><span style="color: red; display: none;"></span></div>
                                        </div>      
                                        <input name="provincename" id="provinceinfo" type="hidden" value=""/>
                                        <input name="cityname" id="cityinfo" type="hidden"  value=""/> 
                                        <input name="districtname" id="districtinfo" type="hidden"  value=""/> 
                                       
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="control-label">电话</label>
                                        <div>
                                            <input type="text" name="telephone" value="<?php echo $store['telephone']?>" class="form-control" placeholder="输入联系方式">
                                        </div>
                                    </div>

<!--                                    <div class="form-group clearfix">
                                        <label class="control-label">备注</label>
                                        <div>
                                            <input type="text"   class="form-control" placeholder="休闲娱乐">
                                        </div>
                                    </div>-->
                                    <button class="bc">保存</button>
                                </form>


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
    
    
     <script>
         
         function GetCity(){
            
	 var obj= $('#provinceS');
         var provinceid=obj.val();
	 var provincename=obj.find("option:selected").data('fullname');
	 var lng=obj.find("option:selected").data('lng');
	 var lat=obj.find("option:selected").data('lat');
	 $('#provinceinfo').val(provincename);
	 
	 var cityHtml='&nbsp;&nbsp;&nbsp;<select name="cityid" id="cityS" class="form-control" onchange="GetDistrict();"><option value="0" >请选择</option>'
	 $.post('?m=User&c=merchant&a=GetDistrict',{districtid:provinceid},function(ret){
	   if(ret.data){
	      $.each(ret.data,function(nn,vv){
		     cityHtml+='<option value="'+vv.id+'" data-fullname="'+vv.fullname+'" data-lng="'+vv.lng+'" data-lat="'+vv.lat+'" >'+vv.fullname+'</option>';
		  });
		  cityHtml+='</select>';
		  $('#cityS').remove();
		  $('#districtS').remove();
		  $('#circleS').remove();
                  $('input[name="cityname"]').val('');
                  $('input[name="districtname"]').val('');
		  obj.after(cityHtml);
	   }
	 },'JSON');
  }

 function GetDistrict(){
 	 var obj= $('#cityS');
         var cityid=obj.val();
	 var cityname=obj.find("option:selected").data('fullname');
	 var lng=obj.find("option:selected").data('lng');
	 var lat=obj.find("option:selected").data('lat');
	 $('#cityinfo').val(cityname);
	
	 var cityHtml='&nbsp;&nbsp;&nbsp;<select name="districtid" id="districtS" class="form-control" onchange="GetCircle();"><option value="0">请选择</option>'
	 $.post('?m=User&c=merchant&a=GetDistrict',{districtid:cityid},function(ret){
	   if(ret.data){
	      $.each(ret.data,function(nn,vv){
		     cityHtml+='<option value="'+vv.id+'" data-fullname="'+vv.fullname+'" data-lng="'+vv.lng+'" data-lat="'+vv.lat+'" >'+vv.fullname+'</option>';
		  });
		  cityHtml+='</select>';
		  $('#districtS').remove();
		  $('#circleS').remove();
                  $('input[name="districtname"]').val('');
		  obj.after(cityHtml);
	   }
		
	 },'JSON');
 }
 function GetCircle(){
	var obj= $('#districtS');
	var districtid=obj.val();
	var districtname=obj.find("option:selected").data('fullname');
	var lng=obj.find("option:selected").data('lng');
	var lat=obj.find("option:selected").data('lat');
   $('#districtinfo').val(districtname);
   //init(lat,lng,17);
    
 }
 </script>
</body>
</html>