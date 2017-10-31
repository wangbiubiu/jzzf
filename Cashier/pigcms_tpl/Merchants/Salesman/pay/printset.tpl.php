
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>收银台 | 打印配置</title>
	 <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
    <!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/iCheck/icheck.min.js"></script>
	<!-- DROPZONE -->
	<link href="<?php echo RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/footable/footable.all.min.js"></script>
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
	</style>
</head>

<body>

    <div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>打印配置</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>Pay</a>
                        </li>
                        <li class="active">
                            <strong>printset</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
            	<div class="col-lg-10">
            	    <div class="ibox float-e-margins">
            	        <div class="ibox-title clearfix">
            	            <h5 style="margin: 10px 0 0px;">打印配置</h5>
            	        </div>
            	        <div class="ibox-content">
						<div class="alert alert-warning">
							温馨提示：
							1、如果开启了打印机，并且配置好打印机相关配置，系统将在客户成功付款后打印出小票<br/>
							<strong style="color:red;">2、特别提醒：您必须要有台小票打印机</strong>
						 </div>
						 <button  class="btn  btn-primary" style="margin-bottom: 15px;" data-toggle="modal" data-target="#addPrintSet"><i class="fa fa-plus"></i> 添加打印机</button>
						<table class="ui-table ui-table-list table table-striped" data-page-size="100" style="padding: 0px;">
						<thead class="js-list-header-region tableFloatingHeaderOriginal">
							<tr class="widget-list-header">
							<th>开关</th>
							<th>描述</th>
							<th data-hide="phone">门店</th>
							<th data-hide="phone">绑定手机号</th>
							<th data-hide="phone">终端号</th>
							<th>操作</th>
							</tr>
							</thead>
							<tbody class="js-list-body-region" id="table-list-body">
							 <?php if(!empty($printcfgArr)){
							     foreach($printcfgArr as $pkk=>$pvv){
							 ?>
            	                <tr>
            	                    <td style="padding-top:10px;"><input type="checkbox" <?php if($pvv['isopen'] == 1){ echo 'checked="checked"'; }?>  class="i-checks isopenoff" value="<?php echo $pvv['id'];?>" >&nbsp;&nbsp;开启/关闭</td>
            	                    <td style="padding-top: 10px;" class="printStatus">打印机 （<span>
									<?php if($pvv['isopen']==1){ ?>
									<font color="green">已开启</font>
									<?php }else{?>
									<font color="red">已关闭</font>
									<?php }?>
									</span>）</td>
									<td><?php if(($pvv['store_id']>0) && is_array($StoreInfo) && isset($StoreInfo[$pvv['store_id']])){ echo $StoreInfo[$pvv['store_id']]['business_name'].$StoreInfo[$pvv['store_id']]['branch_name'];}else{ echo '无';}?></td>
									<td><?php echo $pvv['cellphone'];?></td>
									<td><?php echo $pvv['terminalnum'];?></td>
            	                    <td><button class="btn btn-info " type="button" data-toggle="modal" onclick="GetThisCfg(<?php echo $pvv['id'];?>);"><i class="fa fa-paste"></i>打印相关配置</button></td>
            	                </tr>
								<?php }}else{?>
								<tr><td colspan="7">您还没有添加打印机，请添加一台</td></tr>
								<?php }?>
								</tbody> 
            	            </table>
            	        </div>
            	    </div>
            	</div>
            </div>
        </div>
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>


	<div class="modal inmodal" tabindex="-1"  id="printSetting" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				
				<div class="modal-header">
                    <button type="button" class="close _close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">打印机配置</h4>
                </div>
				<div class="modal-body">
				<form action="" method="post" enctype="multipart/form-data">
					<div class="setting_rows">
						<div id="printConfigBox" class="wxpay_box">
						<input type="hidden" id="printcfgid" name="cfgid" value="0">
							<div class="form-group cellphone">
								<label>绑定手机号：</label>
								<input type="text" placeholder="小票打印机的手机卡号码" value="<?php if(!empty($printcfg)){ echo $printcfg['cellphonem'];}?>" class="form-control config1" readonly="readonly">
								<input type="hidden" placeholder="小票打印机的手机卡号码" value="<?php if(!empty($printcfg)){ echo $printcfg['cellphone'];}?>" class="form-control config2" name="cellphone">
							</div>
							<div class="form-group terminalnum">
								<label>终端号：</label>
								<input type="text" placeholder="小票打印机终端号" value="<?php if(!empty($printcfg)){ echo $printcfg['terminalnumm'];}?>" class="form-control config1" readonly="readonly">
								<input type="hidden" placeholder="小票打印机终端号" value="<?php if(!empty($printcfg)){ echo $printcfg['terminalnum'];}?>" class="form-control config2"  name="terminalnum">
							</div>
							<div class="form-group mkey">
								<label>密钥：</label>
								<input type="text" placeholder="密钥key" value="<?php if(!empty($printcfg)){ echo $printcfg['mkeym'];}?>" class="form-control config1" readonly="readonly">
								<input type="hidden" placeholder="密钥key" value="<?php if(!empty($printcfg)){ echo $printcfg['mkey'];}?>" class="form-control config2" name="mkey">
							</div>
							<div class="form-group pnum">
								<label>打印份数：</label><span>（1到10份内）</span>
								<input type="text" placeholder="打印份数" <?php if(!empty($printcfg)){ echo 'value="'.$printcfg['pnum'].'"';}else{ echo 'value="1"';}?> class="form-control" name="pnum" onkeyup="value=value.replace(/[^1234567890]/g,'')">
							</div>
							<div class="form-group store_id">
								<label>选择店面：</label>
								<select class="form-selectcontrol" name="store_id">
								<option value="0">不选门店</option>
								<?php if(!empty($StoreInfo)){
								    foreach($StoreInfo as $svv){
								?>
								<option <?php if($svv['id']==$storeid){echo 'selected="selected"';}?> value="<?php echo $svv['id'];?>"><?php echo $svv['business_name'].$svv['branch_name'];?></option>
								<?php } } ?>
								</select>
							</div>

							<div class="form-group pformat">
								<label>打印格式：</label><span>（请不要改动冒号后面的变量）</span>
								<textarea placeholder="打印格式说明" class="form-control" rows="8" name="pformat"><?php if(!empty($printcfg)){ echo $printcfg['pformat'];}else{?>
商家名称：{#mername#}
店铺名称：{#storename#}
消费者：{#user#}
消费描述：{#paydesc#}
下单时间：{#buytime#}
消费金额：￥{#mprice#}
订单号：{#orderid#}
支付方式：{#paytype#}
打印时间：{#printtime#}
※※※※※※※※※※※※※※※※
谢谢惠顾，欢迎再次光临！
								<?php }?>
								</textarea>
							</div>

						</div>
					</div>
					</form>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-white _close" data-dismiss="modal">取消</button>
                  <button type="button" class="btn btn-primary btn-confirm">确定</button>
                </div>
			</div>
		</div>
	</div>



	<div class="modal inmodal in" tabindex="-1"  id="addPrintSet" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				
				<div class="modal-header">
                    <button type="button" class="close _close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加打印机</h4>
                </div>
				<div class="modal-body">
				<form action="" method="post" enctype="multipart/form-data">
					<div class="setting_rows">
						<div id="addprintConfigBox" class="wxpay_box">
							<div class="form-group">
								<label>绑定手机号：</label>
								<input type="text" placeholder="小票打印机的手机卡号码" value="" class="form-control" name="cellphone">
							</div>
							<div class="form-group">
								<label>终端号：</label>
								<input type="text" placeholder="小票打印机终端号" value="" class="form-control" name="terminalnum">
							</div>
							<div class="form-group">
								<label>密钥：</label>
								<input type="text" placeholder="密钥key" value="" class="form-control config1" name="mkey">
							</div>
							<div class="form-group">
								<label>打印份数：</label><span>（1到10份内）</span>
								<input type="text" placeholder="打印份数" value="1" class="form-control" name="pnum" onkeyup="value=value.replace(/[^1234567890]/g,'')">
							</div>
							<div class="form-group">
								<label>选择店面：</label>
								<select class="form-selectcontrol" name="store_id">
								<option value="0">不选门店</option>
								<?php if(!empty($StoreInfo)){
								    foreach($StoreInfo as $svv){
								?>
								<option value="<?php echo $svv['id'];?>"><?php echo $svv['business_name'].$svv['branch_name'];?></option>
								<?php } } ?>
								</select>
							</div>

							<div class="form-group">
								<label>打印格式：</label><span>（请不要改动冒号后面的变量）</span>
								<textarea placeholder="打印格式说明" class="form-control" rows="8" name="pformat">
商家名称：{#mername#}
店铺名称：{#storename#}
消费者：{#user#}
消费描述：{#paydesc#}
下单时间：{#buytime#}
消费金额：￥{#mprice#}
订单号：{#orderid#}
支付方式：{#paytype#}
打印时间：{#printtime#}
※※※※※※※※※※※※※※※※
谢谢惠顾，欢迎再次光临！
								</textarea>
							</div>
						</div>
					</div>
					</form>
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                  <button type="button" class="btn btn-primary btn-confirm">确定</button>
                </div>
			</div>
		</div>
	</div>


    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green'
            });
			$('.ui-table-list').footable();
			$('.isopenoff').on('ifChanged', function(){
				if($(this).is(':checked')){
					var is_open = 1;
				}else{
					var is_open = 0;
				}
				var idd=$(this).val();
				var __this=$(this);
				$.post('?m=User&c=pay&a=SetPrintCfgV',{isopen:is_open,cfgid:idd},function(ret){
				   if(ret.error){
				      swal("保存失败", '请重新尝试一次' , "error");
				   }else{
				      if(is_open==1){
						 __this.parent().parent('td').siblings('.printStatus').find('span').html('<font color="green">已开启</font>');
					     swal("保存成功", '打印功能开启成功！' , "success");
					  }else{
						   __this.parent().parent('td').siblings('.printStatus').find('span').html('<font color="red">已关闭</font>');
					      swal("保存成功", '打印功能关闭成功！' , "success");
					  }
				   }
				},'JSON');
			});

			$('#printSetting .btn-confirm').click(function(){
				var pConfigData = $('#printSetting').find('form').serialize();
				$.post('?m=User&c=pay&a=printScfg',pConfigData,function(result){
					if(!result.error){
						swal({
        					title: "成功",
        					text: result.msg,
        					type: "success"
    					}, function () {
        					window.location.reload();
   						});
					}else{
						swal("失败", result.msg , "error");
					}
					$('#printSetting').hide();
					$('.modal-backdrop').remove();;
					$('#printConfigBox input').val('');
				},'json');

			});

		$('#addPrintSet .btn-confirm').click(function(){
			var pConfigData = $('#addPrintSet').find('form').serialize();
			$.post('?m=User&c=pay&a=addPrintCfg',pConfigData,function(result){
				if(!result.error){
					swal({
						title: "添加成功",
						text: result.msg,
						type: "success"
					}, function () {
						window.location.reload();
					});
				}else{
					swal("添加成功", result.msg , "error");
				}
			},'json');
		});

		 $('#printSetting ._close').click(function(){
			$('#printSetting').hide();
		    $('.modal-backdrop').remove();;
			$('#printConfigBox input').val('');
			$('body').css('padding-right','0px').removeClass('modal-open');
		 });
      });

		function GetThisCfg(cfgid){
		   if(cfgid>0){
				$.post('?m=User&c=pay&a=getPrintCfg',{cfgid:cfgid},function(result){
					if(!result.error){
					  $('#printcfgid').val(result.data.id);
					  
					  $('#printConfigBox .cellphone .config1').val(result.data.cellphonem);
					  $('#printConfigBox .cellphone .config2').val(result.data.cellphone);

					  $('#printConfigBox .terminalnum .config1').val(result.data.terminalnumm);
					  $('#printConfigBox .terminalnum .config2').val(result.data.terminalnum);

					  $('#printConfigBox .mkey .config1').val(result.data.mkeym);
					  $('#printConfigBox .mkey .config2').val(result.data.mkey);

					  $('#printConfigBox .pnum input').val(result.data.pnum);
					  $('#printConfigBox .store_id select').val(result.data.store_id);
					  $('#printConfigBox .pformat textarea').val(result.data.pformat);
					  $('body').css('padding-right','20px').addClass('modal-open');
					  $('#printSetting').show();
					  $('body').append('<div class="modal-backdrop in"></div>');
					}else{
						swal("修改失败！", result.msg , "error");
					}
				},'json');  
		   }
		}

		function htmlToArray(data){
			data = data.split('&');
			var info = {};
			$.each(data,function(k,v){
				v = v.replace('%5D','').split('=');
				var s = v[0].split('%5B');
				typeof(info[s[0]]) == 'undefined' && (info[s[0]] = {}),info[s[0]][s[1]] = v[1];
			});
			return info;
		}


    
    $('#printConfigBox .config1').click(function(){
	   $(this).hide().siblings('.config2').prop('type','text').focus();
	});
    $('#printConfigBox .config2').blur(function(){
		var value=$.trim($(this).val());
		if(value){
			$(this).prop('type','hidden').siblings('.config1').val(value.toXingStr()).show();
		}else{
		   $(this).val('');
		}
	});

	String.prototype.toXingStr=function(){
	   var returnStr='';
	   var lenstr=this.length;
	   if(lenstr>4){
	    var xingLen=lenstr-4;
		 for(i=0;i<lenstr;i++){
			if(i<2 || xingLen==0){
			  returnStr+=this.charAt(i);
			}else{
			  returnStr+='*';
			  --xingLen;
			}
		 }
	   }else{
	     for(i=0;i<lenstr;i++){
			  returnStr+='*';
		 }
	   }

        return returnStr;
	}
    </script>

</body>

</html>