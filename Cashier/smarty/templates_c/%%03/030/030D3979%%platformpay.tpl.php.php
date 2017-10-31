<?php /* Smarty version 2.6.18, created on 2016-10-27 09:27:18
         compiled from D:%5Ctest%5Cpay%5Cpay%5CCashier%5C./pigcms_tpl/Merchants/System/index/platformpay.tpl.php */ ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台 | 平台代支付列表</title>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/header.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<link href="<?php echo @PIGCMS_TPL_STATIC_PATH; ?>
wxCoupon/wxCoupon.css" rel="stylesheet">
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
	<link href="<?php echo @RL_PIGCMS_STATIC_PATH; ?>
plugins/css/footable/footable.core.css" rel="stylesheet">
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/iCheck/custom.css" rel="stylesheet">
	<script src="<?php echo @RlStaticResource; ?>
plugins/js/footable/footable.all2.min.js"></script>
	<script src="<?php echo @RlStaticResource; ?>
plugins/js/iCheck/icheck.min.js"></script>
	<link href="<?php echo @RlStaticResource; ?>
plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="<?php echo @RlStaticResource; ?>
plugins/js/datapicker/bootstrap-datepicker.js"></script>
	<style type="text/css">
	#listfootable .fa-edit{ color: #3DA142;font-size: 20px;}
	#listfootable .tips{ color: #3DA142;cursor: pointer;}
	#listfootable .tips span{ display: none;} 
	#listfootable .prelative .form-control {
    display: none;
    vertical-align: middle;
    width: auto;
	height: 30px;
	padding: 3px 10px;
 }
   #datepicker  input,#usertoname {border-radius: 7px;height: 35px;display: inline-block;width:220px;margin-bottom:1px; float: none;}
   #datepicker{margin-top:15px;}
	</style>
</head>
<body>
    <div id="wrapper">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/leftmenu.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/top.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>管理后台</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>System</a>
                        </li>
                        <li>
                            <a>index</a>
                        </li>
                        <li class="active">
                            <strong>平台代支付列表</strong>
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
                        <div class="ibox-title">
                            <h5>平台代支付列表</h5>
							<span class="pull-right" style="margin-right: 15px;">总收款：<?php echo $this->_tpl_vars['income']; ?>
 元 &nbsp;&nbsp;总退款：<?php echo $this->_tpl_vars['refund']; ?>
 元&nbsp;&nbsp;总结余：<?php echo $this->_tpl_vars['surplus']; ?>
 元
							</span>
                        </div>
                        <div class="ibox-content">
						<div class="alert alert-warning">
						温馨提示：请配置好微信支付配置
						 </div>
						 		<div class="form-group input-group"  id="myFormAct">
								 <form method="get" action="">
								    <span><label class="font-noraml">支付类型选择：</label>
										<select class="form-control m-b" style="width:200px;display:inline-block;float:none;height:auto;" onchange="qyChaXun()" name="pty">
										<option value="0">请选择</option>
										<option value="1" <?php if (( $this->_tpl_vars['paytype'] == 1 )): ?>selected="selected"<?php endif; ?>>微信支付</option>
										<option value="2" <?php if (( $this->_tpl_vars['paytype'] == 2 )): ?>selected="selected"<?php endif; ?>>支付宝支付</option>
										</select></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<span><label class="font-noraml">商户名称筛选：</label>
										<select class="form-control m-b" style="width:200px;display:inline-block;float:none;height:auto;" onchange="qyChaXun(this.value)" id="mid">
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
									<select class="form-control m-b" style="width:200px;display:inline-block;float:none;height:auto;" onchange="qyChaXun(this.value)" id="midd">
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
										
										<div id="datepicker" class="input-daterange">
											<label class="font-noraml">选择日期</label>&nbsp;&nbsp;&nbsp;
											<input type="text" value="<?php echo $this->_tpl_vars['starttime']; ?>
" name="stime" class="input-sm form-control" id="datestart" placeholder="开始时间">
											&nbsp;<span> T O </span>&nbsp; 
											<input type="text" value="<?php echo $this->_tpl_vars['endtime']; ?>
" name="etime" class="input-sm form-control" id="dateend" placeholder="结束时间"> 
											&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" style="width:70px;" onclick="qyChaXun()">查 询</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--<a class="btn btn-primary"  style="width:80px;" href="javascript:;" onclick="exportExcel();">导 出</a>-->
										</div>

										</form>
								</div>
                            <table class="footable table table-stripped" data-page-size="30" id="listfootable">
                                <thead>
                                <tr>
									<th>商户名称</th>
									<th data-hide="phone">商户账号</th>
									<th>付款人</th>
									<th data-hide="phone">付款时间</th>
									<th data-hide="phone">付款金额(元)</th>
									<th data-hide="phone">支付类型</th>
									<th data-hide="phone">支付/退款情况</th>
								   </tr>
                                </thead>
								  <tbody>
									<?php if (! empty ( $this->_tpl_vars['merOderInfo'] )): ?>
									 <?php unset($this->_sections['vv']);
$this->_sections['vv']['name'] = 'vv';
$this->_sections['vv']['loop'] = is_array($_loop=$this->_tpl_vars['merOderInfo']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['vv']['show'] = true;
$this->_sections['vv']['max'] = $this->_sections['vv']['loop'];
$this->_sections['vv']['step'] = 1;
$this->_sections['vv']['start'] = $this->_sections['vv']['step'] > 0 ? 0 : $this->_sections['vv']['loop']-1;
if ($this->_sections['vv']['show']) {
    $this->_sections['vv']['total'] = $this->_sections['vv']['loop'];
    if ($this->_sections['vv']['total'] == 0)
        $this->_sections['vv']['show'] = false;
} else
    $this->_sections['vv']['total'] = 0;
if ($this->_sections['vv']['show']):

            for ($this->_sections['vv']['index'] = $this->_sections['vv']['start'], $this->_sections['vv']['iteration'] = 1;
                 $this->_sections['vv']['iteration'] <= $this->_sections['vv']['total'];
                 $this->_sections['vv']['index'] += $this->_sections['vv']['step'], $this->_sections['vv']['iteration']++):
$this->_sections['vv']['rownum'] = $this->_sections['vv']['iteration'];
$this->_sections['vv']['index_prev'] = $this->_sections['vv']['index'] - $this->_sections['vv']['step'];
$this->_sections['vv']['index_next'] = $this->_sections['vv']['index'] + $this->_sections['vv']['step'];
$this->_sections['vv']['first']      = ($this->_sections['vv']['iteration'] == 1);
$this->_sections['vv']['last']       = ($this->_sections['vv']['iteration'] == $this->_sections['vv']['total']);
?>
									  <tr>
									    <td><?php echo $this->_tpl_vars['merOderInfo'][$this->_sections['vv']['index']]['merwxname']; ?>
</td>
									    <td><?php echo $this->_tpl_vars['merOderInfo'][$this->_sections['vv']['index']]['username']; ?>
</td>
									    <td><?php echo $this->_tpl_vars['merOderInfo'][$this->_sections['vv']['index']]['payneme']; ?>
</td>
									   <td><?php echo $this->_tpl_vars['merOderInfo'][$this->_sections['vv']['index']]['paytimestr']; ?>
</td>
									   <td><?php echo $this->_tpl_vars['merOderInfo'][$this->_sections['vv']['index']]['goods_price']; ?>
</td>
									   <td><?php if ($this->_tpl_vars['merOderInfo'][$this->_sections['vv']['index']]['pay_way'] == 'weixin'): ?>微信支付<?php elseif ($this->_tpl_vars['merOderInfo'][$this->_sections['vv']['index']]['pay_way'] == 'alipay'): ?>支付宝支付<?php else: ?>其他支付<?php endif; ?></td>
									   <td>已支付 / <?php echo $this->_tpl_vars['merOderInfo'][$this->_sections['vv']['index']]['refundstr']; ?>
</td>
									  </tr>
									 <?php endfor; endif; ?>
									<?php else: ?>
										   <tr class="widget-list-item"><td colspan="8">暂无特约商家支付信息</td></tr>
									<?php endif; ?>
								   </tbody> 
                            </table>

                        </div>
                    </div>
					 <?php echo $this->_tpl_vars['pagebar']; ?>

                </div>
            </div>
        </div>

			
            </div>
        </div>




	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['tplHome'])."/System/public/footer.tpl.php", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
<script  type="text/javascript">
 $(document).ready(function(){
	$('#listfootable').footable();
		$('#datepicker .input-sm').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		format: "yyyy-mm-dd",
		autoclose: true
	});
 });
  function SelectByMid(vv,typ){
	var furl=window.location.href;
	if(furl.indexOf('mid=')>0){
	   furl=furl.replace(/mid=\d+/,'mid='+vv);
	   furl=furl.replace(/typ=\d+/,'typ='+typ);
	   window.location.href=furl;
	}else{
       window.location.href=furl+'&mid='+vv+'&typ='+typ;
	}
 }

  function SelectPayType(vv){
	var furl=window.location.href;
	if(furl.indexOf('pty=')>0){
	   furl=furl.replace(/pty=\d+/,'pty='+vv);
	   window.location.href=furl;
	}else{
       window.location.href=furl+'&pty='+vv;
	}
 }

function qyChaXun(middd){
   if(typeof(middd)!='undefined'){
	 $('#usertoname').val('');
	 var qyStr=$('form').serialize();
     mid=parseInt(middd);
   }else{
	   var qyStr=$('form').serialize();
	   var mid=$('#mid').val();
	   mid=parseInt(mid);
	   var midd=$('#midd').val();
	   midd=parseInt(midd);
	   if(midd>0){
		 mid=midd;
	   }
   }
   mid=mid >0 ? mid :0;
   var furl='http://'+window.location.host+'/merchants.php?m=System&c=index&a=platformpay&mid='+mid+'&';
   window.location.href=furl+qyStr;
}
</script>
</html>