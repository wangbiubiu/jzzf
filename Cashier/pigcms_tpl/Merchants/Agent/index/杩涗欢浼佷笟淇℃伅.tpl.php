<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>代理商|首页</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
        <link   href="http://cashier.b0.upaiyun.com/pigcms_static/plugins/css/datapicker/datepicker3.css" rel="stylesheet">
<!--<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>-->
<!-- Data picker -->
<script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
</head>
<style>
.clearfix:after {
    height: 0;
    content: " ";
    display: block;
    overflow: hidden;
    clear: both;
}
.clearfix {
    zoom: 1;/*IE低版本浏览器不支持after伪类所以要加这一句*/
}
.fl{ float: left;}
ul li{ list-style: none;}
a{text-decoration: none;}
.qiye{ width: 1080px; margin: 0 auto;  padding:30px;}
.qiye>p>label{ color: #929292;}
.qiye>p>span{ display: inline-block; width: 150px; height: 2px; background: #f3f3f3;}
.qiye>p>label>i{ display: inline-block; font-style: inherit; margin-right: 10px; width: 30px; height: 30px; border-radius: 50%; border: 1px solid #f3f3f3; text-align: center; line-height: 30px;}
.qiye>p>label:nth-child(1)>i{ background: #1483D8;color: #fff; }
.qiye>p>label:nth-child(1){ color: #333333;}
.qiye>div,.qiye>h2{
 width: 600px;
 margin: 40px auto;	
}
.qiye>h2>span{font-size: 15px;
    color: gray;
    margin-left: 10px;}
.qiye>div>div>label{ width: 170px; text-align: right; margin-right: 10px; font-size: 14px;}
.qiye>div>div{ margin: 30px 0; }
.qiye>div>div>label>span{ color:red;}
.qiye>div>div>input[type="text"]{ width: 400px; height: 30px;}
.qiye>div>div>select{ width: 130px; height: 30px;}
.tupshangchuan{ position: relative;}
.tupshangchuan>p{cursor: pointer;}
.tupshangchuan>p>img{ width: 117px; height: 117px;}
.tupshangchuan>input{ position: absolute; left: 0px ;top: 0px;width: 117px; height: 117px; opacity: 0;filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0);}
</style>
<body>
    <div id="wrapper">
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
         <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>首页</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Agent</a>
                        </li>
                        <li>
                            <a>Index</a>
                        </li>
                        <li class="active">
                            <strong>首页</strong>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight" >
                <div style="background: #FFFFFF; width: 100%; padding-bottom: 30px;">
                    <div class="qiye">
                    	<p>
                    		<label><i>1</i>填写商家信息</label>
                    		<span></span>
                    		<label><i>2</i>填写银行信息</label>
                    		<span></span>
                    		<label><i>3</i>填写经营信息</label>
                    		<span></span>
                    		<label><i>4</i>提交成功</label>
                    	</p>
                    	<h2>企业信息<span>按照证书上的内容逐字填写</span></h2>
                    	<div>
                    		
                    			<div><label><span>*</span>证件类型:</label>
                    				<span><input class="ptyezz" type="radio" name="Businesslicense" checked>普通营业执照</span>
                    				<span><input class="szhy" type="radio" name="Businesslicense">多证合一营业执照</span>
                    			</div>
                    			<div><label><span>*</span>企业名称:</label><input type="text" name=""></div>
                    			<div><label><span>*</span>注册号:</label><input type="text" name=""></div>
                    			<div><label><span>*</span>单位所在地:</label>
                    			<select>
                    				<option>-----选择省份----</option>
                    			</select>
                    			<select>
                    				<option>-----选择城市----</option>
                    			</select>
                    			<select>
                    				<option>-----选择区/县----</option>
                    			</select>
                    		</div>
                    		<div>
                    			<label><span>*</span>住所:</label><input type="text">
                    		</div>
                    		<div class="clearfix">
                    			<label class="fl"><span>*</span>经营范围:</label>
                    			<textarea class="fl" style="width: 400px; height: 200px; resize: none;"></textarea>
                    		</div>
                    		<div  class="input-daterange">
	                           	<label><span>*</span>营业期限:</label>
								<input type="text" value=""  class="datestart" placeholder="YYYY-MM-DD" style="width: 200px;" >
								<input type="checkbox" value="" name="Long-term" class="Long-term">长期
	                        </div>
	                           
		                    <div class="clearfix">
								<label class="fl"><span>*</span>上传营业执照：</label>
								<div class="fl" style="width: 400px;">
									<p>仅支持中国大陆地区的工商营业执照，且必须在有效期内。</p>
									<p>格式要求：原件照、原件扫描件或复印件加盖公章的扫描件， 支持jpg，jpeg，png，bmp格式文件，单个文件不超过 <span style="color:red;">5</span> MB。</p>
									<div class="tupshangchuan">
										<p>
											<img src="./Cashier/pigcms_static/image/sctp.png">
										</p>
										<input type="file" />
									</div>
								</div>
							</div>
								
							<div class="zijg">
                    			<label><span>*</span>组织机构代码:</label><input type="text">
                    		</div>
							
							<div class="clearfix zijg">
									<label class="fl"><span>*</span>上传授组织机构代码证：</label>
									<div class="fl" style="width: 400px;">
										<div class="tupshangchuan">
											<p>
												<img src="./Cashier/pigcms_static/image/sctp.png">
											</p>
											<input type="file" />
										</div>
									</div>
							</div>	
							
						</div>
                    	<h2>法定代表人信息</h2>
                    	<div>
                    		<div><label><span>*</span>法定代表人归属地:</label><input type="text"></div>
                    		<div><label><span>*</span>法定代表人姓名:</label><input type="text"></div>
                    		
                    		<div>
                    			<label><span>*</span>身份证类型:</label>
                    			<span><input type="radio" name="DocumentType" checked >二代身份证</span>
                    			<span><input type="radio" name="DocumentType">临时身份证</span>
                    		</div>
                    		<div><label><span>*</span>身份证号:</label><input type="text" name=""></div>
                    		<div  class="input-daterange">
	                           	<label><span>*</span>证件有效期:</label>
								<input type="text" value=""  class="datestart" placeholder="YYYY-MM-DD" style="width: 200px;" >
                                <input type="checkbox" value="" name="Long-term" class="Long-term">长期
                            </div>
                           
	                        <div class="clearfix">
								<label class="fl"><span>*</span>上传法人身份证：</label>
								<div class="fl">
									<p>上传身份证正面和背面</p>
									<div class="tupshangchuan">
										<p>
											<img src="./Cashier/pigcms_static/image/sctp.png">
										</p>
										<input type="file" />
									</div>
								</div>
							</div>
	                        
	                        <div>
                    			<label><span>*</span>填写人身份:</label>
                    			<span><input type="radio" name="RepresentativePerson" class="fr" checked>我是法定代表人</span>
                    			<span><input type="radio" name="RepresentativePerson" class="dlr">我是代理人</span>
                    		</div>
	                    </div>	
	                    <div class="dailiren" style="display: none;">
                    		<h2>代理人信息</h2>
                    		<div><label><span>*</span>代理人姓名:</label><input type="text"></div>
                    		<div>
                    			<label><span>*</span>身份证类型:</label>
                    			<span><input type="radio" name="card-id" checked>二代身份证</span>
                    			<span><input type="radio" name="card-id">临时身份证</span>
                    		</div>
                    		<div><label><span>*</span>身份证号:</label><input type="text" name=""></div>
                    		<div  class="input-daterange">
	                           	<label><span>*</span>证件有效期:</label>
								<input type="text" value=""  class="datestart" placeholder="YYYY-MM-DD" style="width: 200px;" >
                                <input type="checkbox" value="" name="Long-term" class="Long-term">长期
                            </div>
                           
	                        <div class="clearfix">
								<label class="fl"><span>*</span>上传经营者身份证：</label>
								<div class="fl">
									<p>上传身份证正面和背面</p>
									<div class="tupshangchuan">
										<p>
											<img src="./Cashier/pigcms_static/image/sctp.png">
										</p>
										<input type="file" />
									</div>
								</div>
							</div>
	                     	
	                     	<div class="clearfix">
								<label class="fl"><span>*</span>企业委托书扫描照片：</label>
								<div class="fl">
									<div class="tupshangchuan">
										<p>
											<img src="./Cashier/pigcms_static/image/sctp.png">
											
										</p>
										<input type="file" />
									</div>
								</div>
							</div>
	                   </div>
	                    <div>
	                       <button style="width: 100px; height: 35px; background: #108ee9; margin-left: 40%; border-radius: 5px;color: #ffffff; border: none;">下一步</button>
	                    </div>
                
              		</div>
                
           
                
            
            </div>
    </div>
   <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
   	<script type="text/javascript">
                $(document).ready(function() {
                    $('.datestart ').datepicker({
                        keyboardNavigation: false,
                        forceParse: false,
                        format: "yyyy-mm-dd",
                        autoclose: true
                    });
//                  $('#datestart').datepicker({
//                      keyboardNavigation: false,
//                      forceParse: false,
//                      format: "yyyy-mm",
//                      autoclose: true
//                  });
//               GetChartData('smcount','linecountChart','canvasdesc');
       });
    </script>
<script>
           	$(".Long-term").click(function(){
		     	if($(this).is(":checked")){
		     		$(this).parent().children(".datestart").attr("disabled", true);
 				}else{
		     		$(this).parent().children(".datestart").attr("disabled", false);
		     }
		     });
				     
	     	$(".ptyezz").click(function(){
	     		$(".zijg").show();
	     	});
	       $(".szhy").click(function(){
	     		$(".zijg").hide();
	     	});
		     	
	     	$(".fr").click(function(){
	     		$(".dailiren").hide();
	     	});
	        $(".dlr").click(function(){
		   		$(".dailiren").show();
		   	});
</script>
</body>
</html>