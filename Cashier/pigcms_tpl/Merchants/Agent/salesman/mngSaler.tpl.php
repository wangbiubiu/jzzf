 
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>代理商|业务员信息管理</title>
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
	
	
	.form-control{
    width: 80%;
}
.footable-odd {
    background-color: #ffffff;
}

.fl{float: left;}
.fr{ float: right;}
.edit{ border: 1px solid #f2f2f2;}
.edit-title{background: #f2f2f2; height: 40px; line-height: 40px; padding: 0 20px; width: 100%;margin:0px !important; font-weight: normal; font-size: 18px;}
.edit-title a{ color: #44b549; font-weight: normal;float: right;}
.edit>div{ border-bottom: 1px solid #f2f2f2; height: 40px; line-height: 40px;}
.edit>div>label{ width: 95px; text-align: right; display: inline-block; margin-right: 20px;}
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
                    <h2>业务员信息管理</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Agent</a>
                        </li>
                        <li>
                            <a>业务员中心</a>
                        </li>
                       <li>
                            <a>业务员列表</a>
                        </li>
                       
                        <li class="active">
                            <strong>业务员信息管理</strong>
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
                                <li <?php if(!isset($_GET['page'])){ echo 'class="cont"';} ?>>基本信息</li>
            			<li <?php if(isset($_GET['page'])){ echo 'class="cont"';} ?>>商户</li>
            		</ul>
            	</div>
            	
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                                                                
                        <div class="ibox-content" style="border-top:none; <?php if(isset($_GET['page'])){echo 'display:none;';}?>" >
                            
							<div class="employersDelAll" >
                           		<div class="edit">
                           			<h2 class="edit-title">基本信息<a href="?m=agent&c=salesman&a=setSaler&sid=<?php echo $saler['id'];?>">编辑</a></h2>
                           			
                           			<div>
                           				<label>姓名</label>
                           				<span><?php echo $saler['username'];?></span>
                           			</div>
                           			<div>
                           				<label>用户名</label>
                           				<span><?php echo $saler['account'];?></span>
                           			</div>
                           			<div>
                           				<label>佣金返点</label>
                           				<span><?php echo $saler['commission'] * 100 . "%";?></span>
                           			</div>
                           			<div>
                           				<label>联系电话</label>
                           				<span><?php echo $saler['phone'];?></span>
                           			</div>
                           		</div>
							</div>
                        </div>
					 <div class="ibox-content yc" style="border-top:none;<?php if(isset($_GET['page'])){echo 'display:block;';}?>" >
							<div class="employersDelAll" >
                            <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="10" data-filter=#filter style="margin-bottom: 0px;">
                                <thead>
                                <tr>
                                    <th style="text-align: center;"  data-hide="phone">商户ID</th>
                                    <th  style="text-align: center;">登录账号</th>
                                    <th style="text-align: center;" data-hide="phone">商户名称</th>
                                     <th style="text-align: center;" data-hide="phone">签约费率</th>
                                      <th style="text-align: center;" data-hide="phone">手机号码</th>
                                       <th style="text-align: center;" data-hide="phone">座机号码</th>
                                </tr>
                                </thead>
                                <tbody class="js-list-body-region" id="table-list-body">
									
								<?php if (!empty($merchant)){foreach ($merchant as $kk => $vv){ ?>
										<tr class="widget-list-item bd_nr" style="text-align: center;">
											<td><?php echo $vv['mid']; ?></td>
											<td><?php echo $vv['username']; ?></td>
											<td><?php echo $vv['company']; ?></td>
											<td><?php echo $vv['commission'] * 100 .'%'; ?></td>
											<td><?php echo $vv['phone']; ?></td>
											<td><?php echo $vv['tel']; ?></td>
										</tr>
								<?php }} ?>	

								</tbody>
                            </table>
                          
							</div>
							<div style="float: right;width: 100%;height: 50px;margin-top: 20px;"><?php echo $p; ?></div>
								 
                        </div>
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


 <script type="text/javascript">
if(mobilecheck()){
$("#side-menu li").click(function () {
   $("#side-menu li").find('.nav-second-level').css('display','none');
   $(this).find('.nav-second-level').css('display','block').css('min-width','140px');
 });
}
	if(navigator.userAgent.indexOf("AlipayClient")!=-1){
	    $('#shou-kuan').attr('href','/merchants.php?m=User&c=alicashier&a=alipayment&type=1');
		$('#tui-kuan').attr('href','/merchants.php?m=User&c=alicashier&a=alipayment&type=2');
	}
</script> 
<script type="text/javascript">
		        $(document).ready(function() {
					$('#datepicker .input-sm').datepicker({
		                keyboardNavigation: false,
		                forceParse: false,
						format: "yyyy-mm-dd",
		                autoclose: true
		            });
					$('#ymdatepicker .input-sm').datepicker({
		                keyboardNavigation: false,
		                forceParse: false,
						format: "yyyy-mm",
		                autoclose: true
		            });
		           
				 GetChartData('smcount','linecountChart','canvasdesc');
				$('#dataselect .btn-primary').click(function(){
					GetChartData('smcount','linecountChart','canvasdesc');
				});
		});
    </script>
    <script>
   	/******导出处理********/
var tipshtm='';
var excellock=false;
function exportExcel(){
   if(excellock){
		$('#Export_excel_pop').show();
		$('body').append('<div class="modal-backdrop in"></div>');
	    return false;
	}
	excellock=true;
  $('#Export_excel_pop ul').html('<li style="padding-top:20px;">正在导出您的数据，请稍等......</li>');
  $('#Export_excel_pop').show();
  $('body').append('<div class="modal-backdrop in"></div>');


  var fromData=$('form').serialize();
      $.post('/merchants.php?m=agent&c=salesman&a=exportExcel', fromData, function(resp){
			 if (resp.error){
				 alert(resp.msg);
				 return false;
			 } else {
				if(resp.tt>0){
				  tipshtm="<li>已经导出1到5000数据......."+
				   "<li id='extpage_1'>正在为您导出5001到10000条数据......</li>";
					$('#Export_excel_pop ul').append(tipshtm);
				  Run_Export_excel(2);
				}else{
				  tipshtm="<li>数据导出完成&nbsp;&nbsp;&nbsp;<a href='"+resp.fileurl+"'>下载<a></li>"
				  $('#Export_excel_pop ul').append(tipshtm);
				  excellock=false;
				}
			 }                                     	
        }, 'json');
   
    return false;
}



 
function Run_Export_excel(page){
	 var fromData=$('form').serialize();
	 fromData=fromData+'&page='+page;
      $.post('/merchants.php?m=User&c=statistics&a=exportExcel', fromData, function(resp){
			 if (resp.error){
			 } else {
				var tmp= resp.p +1;
				var idxs=(page-1);
				if(!resp.flag && (tmp<=resp.tt)){
				  var mc1=5000*idxs +1;
				  var mc2=5000*page;
				  var mc3=5000*tmp;
				   $('#extpage_'+idxs).html('已经导出'+mc1+'到'+mc2+'数据.......');
					mc2=mc2+1;
				    tipshtm="<li id='extpage_"+page+"'>正在为您导出"+mc2+"到"+mc3+"条数据......</li>";
					$('#Export_excel_pop ul').append(tipshtm);
				    Run_Export_excel(tmp);
				}else{
				  tipshtm="<li id='extpage_end'>完成导出,正在为你打包导出的文件......</li>";
				  $('#Export_excel_pop ul').append(tipshtm);
				    if(true){
				    $.post('/merchants.php?m=User&c=statistics&a=export_excel_zip', {page:resp.p}, function(rest){
				         if (rest.error){
							return false;
							} else {
									 tipshtm="<li>打包完成。&nbsp;&nbsp;&nbsp;<a href='"+rest.fileurl+"'>下 载<a></li>";
								    $('#Export_excel_pop ul').append(tipshtm);
									excellock=false;
							}
				    }, 'json');
					}
				}
				 //window.location.reload();
			 }                                     	
        }, 'json');
}

   </script>
</body>
</html>