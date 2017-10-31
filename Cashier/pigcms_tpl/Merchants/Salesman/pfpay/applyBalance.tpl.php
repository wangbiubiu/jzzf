
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>收银台 | 对账申请</title>
	 <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<!-- DROPZONE -->
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
							温馨提示：
							1、请在这里添加申请对账记录，总后台系统管理员会看到，并更新对账进程！<br/>
						 </div>
						 <button  class="btn  btn-primary" style="margin-bottom: 15px;" data-toggle="modal" data-target="#applyBalance"><i class="fa fa-plus"></i> 对账申请添加</button>

						<table  class="table table-striped table-bordered table-hover" data-page-size="20" style="padding: 0px;">
						<thead class="js-list-header-region tableFloatingHeaderOriginal">
							<tr class="widget-list-header">
							<th data-hide="phone" width="5%">编号</th>
							<th data-hide="phone" width="20%">标题</th>
							<th data-hide="phone" width="15%">申请时间段</th>
							<th data-hide="phone" width="10%">申请状态</th>
							<th data-hide="phone" width="31%">申请说明</th>
							<th data-hide="phone" width="12%">申请添加时间</th>
							<th width="7%">操作</th>
							</tr>
							</thead>
							<tbody class="js-list-body-region" id="table-list-body">
							 <?php if(!empty($pfapplyrecord)){
							     foreach($pfapplyrecord as $pkk=>$pvv){
							 ?>
            	                <tr>
            	                    <td><?php echo $pvv['id'];?></td>
									<td><?php echo $pvv['atitle'];?></td>
									<td><?php echo date('Y-m-d',$pvv['starttime']).'&nbsp; 到 &nbsp;'.date('Y-m-d',$pvv['endtime']);?></td>
									<td><?php echo $statusStr[$pvv['status']];?></td>

            	                    <td><?php echo $pvv['remark'];?></td>
									<td><?php echo date('Y-m-d H:i:s',$pvv['addtime']);?></td>
									<td><button class="btn" onclick="delofItem(<?php echo $pvv['id'];?>,this)"> 删 除 </button></td>
            	                </tr>
								<?php }}else{?>
								<tr><td colspan="8">您还没有对账申请记录</td></tr>
								<?php }?>
								</tbody> 
            	            </table>

            	        </div>
            	    </div>
					<?php echo $pagebar;?>
            	</div>
            </div>
        </div>
	<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>


	<div class="modal inmodal" tabindex="-1"  id="applyBalance" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
				
				<div class="modal-header">
                    <button type="button" class="close _close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">申请记录添加</h4>
                </div>
				<div class="modal-body">
				<form action="" method="post" enctype="multipart/form-data">
					<div class="setting_rows">
						<div id="inputBox" class="wxpay_box">
							<div class="form-group">
								<label>标题：</label>
								<input type="text" placeholder="申请标题" value="" class="form-control" name="atitle">
							</div>
							<div class="form-group">
								<label>要申请对账的开始日期：</label>
								<input type="text" placeholder="开始时间" value="" class="form-control" name="starttime" id="starttime">
							</div>
							<div class="form-group ">
								<label>要申请对账的结束日期：</label>
								<input type="text" placeholder="结束时间" value="<?php echo date('Y-m-d');?>" class="form-control" name="endtime" id="endtime">
							</div>

							<div class="form-group remark">
								<label>申请说明：</label><span></span>
								<textarea placeholder="需要特别说明的文字请填写在这里" class="form-control" rows="5" name="remark"></textarea>
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

    <script>
        $(document).ready(function(){
			
			$('#starttime').datepicker({
				keyboardNavigation: false,
				forceParse: false,
				format: "yyyy-mm-dd",
				autoclose: true
			});
			$('#endtime').datepicker({
				keyboardNavigation: false,
				forceParse: false,
				format: "yyyy-mm-dd",
				autoclose: true
			});

		$('#applyBalance .btn-confirm').click(function(){
			var atitle=$('#inputBox input[name="atitle"]').val();
			atitle=$.trim(atitle);
			if(!atitle){
				swal({
					title: "温馨提示",
					text: "标题不能为空！",
					type: "error"
				});
				return false;
			}
			var starttime=$('#inputBox input[name="starttime"]').val();
			starttime=$.trim(starttime);
			if(!starttime){
				swal({
					title: "温馨提示",
					text: "申请对账的开始日期不能为空",
					type: "error"
				});
				return false;
			}
			var endtime=$('#inputBox input[name="endtime"]').val();
			endtime=$.trim(endtime);
			if(!endtime){
				swal({
					title: "温馨提示",
					text: "申请对账的结束日期不能为空",
					type: "error"
				});
				return false;
			}

			var postData = $('#applyBalance').find('form').serialize();
			$.post('?m=User&c=pfpay&a=applyIng',postData,function(result){
				if(!result.error){
					swal({
						title: "温馨提示",
						text: "添加成功！",
						type: "success"
					},function(){
					   window.location.reload();
					});
				  $('#applyBalance .modal-header ._close').click();
				}else{
					swal("温馨提示", result.msg , "error");
				}
			},'json');
		});

      });
   
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
    </script>

</body>

</html>