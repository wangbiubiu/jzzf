<?php /* Smarty version 2.6.18, created on 2016-10-27 09:27:23
         compiled from D:%5Ctest%5Cpay%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/pfpay/applyMoney.tpl.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'D:\\test\\pay\\pay\\Cashier\\./pigcms_tpl/Merchants/System/pfpay/applyMoney.tpl.php', 131, false),)), $this); ?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>收银台 | 对账申请</title>
	 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<!-- DROPZONE -->
	<link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="<?php echo @RL_PIGCMS_STATIC_PATH; ?>
plugins/css/footable/footable.core.css" rel="stylesheet">
	
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="<?php echo @RlStaticResource; ?>
plugins/js/datapicker/bootstrap-datepicker.js"></script>
	<style>
		.ibox-title h5 {
  			margin: 10px 0 0px;
		}
		select.form-control {
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
	#usertoname {border-radius: 7px;display: inline-block;float: none;height: 35px;margin-bottom: 1px;width: 220px;}
	.icon_edit .fa-pencil{ font-size: 25px; margin-left: 7px;}
	.frm_control_group::after{padding-bottom:0px;}
	</style>
</head>

<body>

    <div id="wrapper">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/leftmenu.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div id="page-wrapper" class="gray-bg">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/top.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>对账申请</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>pfpay</a>
                        </li>
                        <li class="active">
                            <strong>对账申请</strong>
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
            	            <h5 style="margin: 10px 0 0px;">对账申请</h5>
            	        </div>

            	        <div class="ibox-content">
							<div class="alert alert-warning">
							   这里可以修改商户对账申请处理的进程，点击申请状态的铅笔标识来做修改状态<br/>
							   以便商家在收银台申请对账页面及时看到他的申请处理状况
								</div>	
							<div class="form-group input-group"  id="myFormAct">
							 <form method="get" action="">
								<span><label class="font-noraml">商户名称筛选：</label>
									<select class="form-control m-b" style="width:200px;display:inline-block;float:none;" onchange="qyChaXun(this.value)" id="mid">
									<?php if (! empty ( $this->_tpl_vars['merInfos'] )): ?>
									<option value="0">请选择</option>
									<?php unset($this->_sections['mvv']);
$this->_sections['mvv']['name'] = 'mvv';
$this->_sections['mvv']['loop'] = is_array($_loop=$this->_tpl_vars['merInfos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mvv']['show'] = true;
$this->_sections['mvv']['max'] = $this->_sections['mvv']['loop'];
$this->_sections['mvv']['step'] = 1;
$this->_sections['mvv']['start'] = $this->_sections['mvv']['step'] > 0 ? 0 : $this->_sections['mvv']['loop']-1;
if ($this->_sections['mvv']['show']) {
    $this->_sections['mvv']['total'] = $this->_sections['mvv']['loop'];
    if ($this->_sections['mvv']['total'] == 0)
        $this->_sections['mvv']['show'] = false;
} else
    $this->_sections['mvv']['total'] = 0;
if ($this->_sections['mvv']['show']):

            for ($this->_sections['mvv']['index'] = $this->_sections['mvv']['start'], $this->_sections['mvv']['iteration'] = 1;
                 $this->_sections['mvv']['iteration'] <= $this->_sections['mvv']['total'];
                 $this->_sections['mvv']['index'] += $this->_sections['mvv']['step'], $this->_sections['mvv']['iteration']++):
$this->_sections['mvv']['rownum'] = $this->_sections['mvv']['iteration'];
$this->_sections['mvv']['index_prev'] = $this->_sections['mvv']['index'] - $this->_sections['mvv']['step'];
$this->_sections['mvv']['index_next'] = $this->_sections['mvv']['index'] + $this->_sections['mvv']['step'];
$this->_sections['mvv']['first']      = ($this->_sections['mvv']['iteration'] == 1);
$this->_sections['mvv']['last']       = ($this->_sections['mvv']['iteration'] == $this->_sections['mvv']['total']);
?>
									<option value="<?php echo $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['mid']; ?>
" <?php if (( $this->_tpl_vars['mid'] == $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['mid'] )): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['wxname']; ?>
</option>
									<?php endfor; endif; ?>
									<?php endif; ?>
									</select></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<span><label class="font-noraml">商户账号筛选：</label>
								<select class="form-control m-b" style="width:200px;display:inline-block;float:none;" onchange="qyChaXun(this.value)" id="midd">
									<?php if (! empty ( $this->_tpl_vars['merInfos'] )): ?>
									<option value="0">请选择</option>
									<?php unset($this->_sections['mvv']);
$this->_sections['mvv']['name'] = 'mvv';
$this->_sections['mvv']['loop'] = is_array($_loop=$this->_tpl_vars['merInfos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mvv']['show'] = true;
$this->_sections['mvv']['max'] = $this->_sections['mvv']['loop'];
$this->_sections['mvv']['step'] = 1;
$this->_sections['mvv']['start'] = $this->_sections['mvv']['step'] > 0 ? 0 : $this->_sections['mvv']['loop']-1;
if ($this->_sections['mvv']['show']) {
    $this->_sections['mvv']['total'] = $this->_sections['mvv']['loop'];
    if ($this->_sections['mvv']['total'] == 0)
        $this->_sections['mvv']['show'] = false;
} else
    $this->_sections['mvv']['total'] = 0;
if ($this->_sections['mvv']['show']):

            for ($this->_sections['mvv']['index'] = $this->_sections['mvv']['start'], $this->_sections['mvv']['iteration'] = 1;
                 $this->_sections['mvv']['iteration'] <= $this->_sections['mvv']['total'];
                 $this->_sections['mvv']['index'] += $this->_sections['mvv']['step'], $this->_sections['mvv']['iteration']++):
$this->_sections['mvv']['rownum'] = $this->_sections['mvv']['iteration'];
$this->_sections['mvv']['index_prev'] = $this->_sections['mvv']['index'] - $this->_sections['mvv']['step'];
$this->_sections['mvv']['index_next'] = $this->_sections['mvv']['index'] + $this->_sections['mvv']['step'];
$this->_sections['mvv']['first']      = ($this->_sections['mvv']['iteration'] == 1);
$this->_sections['mvv']['last']       = ($this->_sections['mvv']['iteration'] == $this->_sections['mvv']['total']);
?>
									<option value="<?php echo $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['mid']; ?>
" <?php if (( $this->_tpl_vars['mid'] == $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['mid'] )): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['merInfos'][$this->_sections['mvv']['index']]['username']; ?>
</option>
									<?php endfor; endif; ?>
									<?php endif; ?>
									</select></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<span><label class="font-noraml">商户账号：</label>
									<input type="text" value="<?php echo $this->_tpl_vars['uname']; ?>
" name="uname" class="input form-control"   placeholder="输入商户账号筛选" id="usertoname">
									</span>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a class="btn btn-primary" style="width:70px;" onclick="qyChaXun()">查 询</a>
						
									</form>
							</div>

						<table  class="table table-striped table-bordered table-hover" data-page-size="20" style="padding: 0px;">
						<thead class="js-list-header-region tableFloatingHeaderOriginal">
							<tr class="widget-list-header">
							<th data-hide="phone" width="5%">编号</th>
							<th data-hide="phone">商家名称</th>
							<th data-hide="phone">商家账号</th>
							<th data-hide="phone" width="15%">标题</th>
							<th data-hide="phone" width="15%">申请时间段</th>
							<th data-hide="phone" width="15%">申请状态</th>
							<th data-hide="phone">申请说明</th>
							<th data-hide="phone" width="12%">申请添加时间</th>
							</tr>
							</thead>
							<tbody class="js-list-body-region" id="table-list-body">
							<?php if (! empty ( $this->_tpl_vars['applyRecord'] )): ?>
							 <?php $_from = $this->_tpl_vars['applyRecord']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
            	                <tr>
            	                    <td><?php echo $this->_tpl_vars['row']['id']; ?>
</td>
									<td><?php if (! empty ( $this->_tpl_vars['row']['wxname'] )): ?><?php echo $this->_tpl_vars['row']['wxname']; ?>
<?php else: ?><?php echo $this->_tpl_vars['row']['weixin']; ?>
<?php endif; ?></td>
									<td><?php echo $this->_tpl_vars['row']['username']; ?>
</td>
									<td><?php echo $this->_tpl_vars['row']['atitle']; ?>
</td>
									<td><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['starttime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
 &nbsp; 到 &nbsp; <?php echo ((is_array($_tmp=$this->_tpl_vars['row']['endtime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</td>
									<td><span><?php echo $this->_tpl_vars['statusStr'][$this->_tpl_vars['row']['status']]; ?>
</span>

									<a data-actionid="<?php echo $this->_tpl_vars['row']['id']; ?>
" data-actmid="<?php echo $this->_tpl_vars['row']['mid']; ?>
" href="javascript:;" class="icon_edit js_modify_status" title="状态修改"><i class="fa fa-pencil"></i></a>
									</td>

            	                    <td><?php echo $this->_tpl_vars['row']['remark']; ?>
</td>
									<td><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['addtime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</td>
            	                </tr>
								<?php endforeach; endif; unset($_from); ?>
								<?php else: ?>
								<tr><td colspan="6">您还没有对账申请记录</td></tr>
								<?php endif; ?>
								</tbody> 
            	            </table>

            	        </div>
            	    </div>
					<?php echo $this->_tpl_vars['pagebar']; ?>

            	</div>
            </div>
        </div>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
    </div>

<div class="popover" id="changeStatus">
    <div class="popover_inner">
		<div class="popover_content">
		<p style="font-weight: bold;color: #22911B;text-align: center;">对账申请处理状态</p>
		<div class="pop_store">
		
			<div class="frm_control_group">
				<div class="frm_controls">
					<select class="form-control m-b" id="astatus" style="margin:10px 0 0 20px">
					<option value="0">未处理</option>
					<option value="1">已查看</option>
					<option value="2">核算中</option>
					<option value="3">核对完成</option>
					<option value="4">准备汇款</option>
					<option value="5">已添加汇款记录</option>
					<option value="6">已处理完成</option>
					</select>
				</div>
			</div>
		
		</div>
		</div>

		<div class="popover_bar">
			<button type="button" class="btn btn-primary btn_confirm">确 定</button>&nbsp;&nbsp;&nbsp;
			<button type="button" class="btn btn-white c-close">取 消</button>
		</div>

    </div>
    <i class="popover_arrow popover_arrow_out"></i>
    <i class="popover_arrow popover_arrow_in"></i>
</div>

    <script type="text/javascript">
		 function qyChaXun(middd){
		   if(typeof(middd)!='undefined'){
			 var qyStr='';
			 $('#usertoname').val('');
			 
			 mid=parseInt(middd);
		   }else{
			   var qyStr=$('#myFormAct form').serialize();
			   var mid=$('#mid').val();
			   mid=parseInt(mid);
			   var midd=$('#midd').val();
			   midd=parseInt(midd);
			   if(midd>0){
				 mid=midd;
			   }
		   }
		   mid=mid >0 ? mid :0;

		   var furl='http://'+window.location.host+'/merchants.php?m=System&c=pfpay&a=applyMoney&mid='+mid;
		   if(qyStr){
			 furl=furl+'&'+qyStr;
		   }
		   window.location.href=furl;
		}   
	function delofItem(idd,obj){
	 	swal({
		  title: "温馨提示",
		  text: "您确认要删除此项吗？",
		  type: "success"
		 }, function () {
		     $.post('?m=User&c=pfpay&a=delItem',{idd:idd},function(ret){
			     if(!ret.error){
				   $(obj).parent('td').parent('tr').remove();
				 }else{
				 	swal({
					  title: "温馨提示",
					  text: "删除失败！",
					  type: "error"
					 });
				 }
			 },'JSON');
		});
	}

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

	 var actid=miid=0,numObj='';
	$(document).on('click',function(e){
		   var target = $(e.target);
		   var statusobj=target.closest(".js_modify_status");
		   if(statusobj.size()!=0){
			   actid=statusobj.data('actionid');
			   miid=statusobj.data('actmid');
			   numObj=statusobj.siblings('span');
			   var offsetpx=statusobj.offset();
			   $('#changeStatus').css('position','absolute').css('left',offsetpx.left-141).css('top',offsetpx.top+5).css('zIndex','100').show();
		     }else if(target.closest("#changeStatus").size()==0){
			    actid=miid=0;numObj='';
		        $("#changeStatus").hide();
		   }
		});

		$("#changeStatus .c-close").click(function(){
			  actid=miid=0;numObj='';
		     $("#changeStatus").hide();
		});

		$("#changeStatus .btn_confirm").click(function(){
			var datas = {id:actid,mid:miid};
			var astatus=$('#astatus').val();
			astatus=parseInt(astatus);
			datas.astatus=astatus;
		    if(actid>0){
		     $("#changeStatus").hide();
				actid=miid=0;
				$.ajax({
				url: "?m=System&c=pfpay&a=changeStatus",
				type: "POST",
				dataType: "json",
				data:datas,
				success: function(res){
					if(!res.error){
						if(numObj){
						     numObj.html(res.data);
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
    </script>

</body>

</html>