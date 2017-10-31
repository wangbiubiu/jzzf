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
.qiye>p>label:nth-child(1)>i,.qiye>p>span:nth-child(2),.qiye>p>label:nth-child(3)>i,.qiye>p>span:nth-child(4),.qiye>p>label:nth-child(5)>i{ background: #1483D8;color: #fff; }
.qiye>p>label:nth-child(1),.qiye>p>label:nth-child(3),.qiye>p>label:nth-child(5){ color: #333333;}
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
.tsys{color:#f60;}
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
                    	<h2>联系人信息</h2>
                    	<div>                    		
                    			<div><label><span>*</span>姓名:</label><input type="text" name=""></div>
                    			<div><label><span>*</span>电子邮箱:</label><input type="text" name=""></div>
                    			<div><label><span>*</span>手机号码:</label>
                    				<input type="text" name="" style="width: 180px; margin-right: 10px;">
                    				<input type="submit" value="获取验证码" style="width: 120px; height: 30px;">
                    			</div>
                    		<div>
                    			<label><span>*</span>手机验证码:</label><input type="text">
                    		</div>
                    	</div>
                    	<h2>经营信息</h2>
                    	<div>
                    		
                    		<div><label><span>*</span>经营类目:</label>
                    			<select>
                    				<option></option>
                    			</select>
                    			<select>
                    				<option></option>
                    			</select>
                    			<select class="BusinessCategory">
                    				<option>1</option>
                    				<option>2</option>
                    				<option>机票代理人</option>
                    				<option>机票平台</option>
                    				<option>快递服务</option>
                    				<option>物流货运服务</option>
                    				<option>葡萄酒生产商</option>
                    				<option>其他酒类生产商</option>
                    				<option>公共事业（电、气、水）</option>
                    				<option>公共事业-电力缴费</option>
                    				<option>公共事业-煤气缴费</option>
                    				<option>公共事业-自来水缴费</option>
                    				<option>典当行</option>
                    				<option>保险直销（代扣）</option>
                    				<option>电话接入直销</option>
                    				<option>电话外呼直销</option>
                    				<option>旅游相关服务直销</option>
                    				<option>目录直销平台</option>
                    				<option>上门直销（直销员）</option>
                    				<option>直销</option>
                    				<option>直销代理</option>
                    				<option>烟花爆竹</option>
                    				<option>酒类</option>
                    				<option>烟草/雪茄</option>
                    				<option>电信运营商</option>
                    				<option>话费充值与缴费</option>
                    				<option>计算机软件</option>
                    				<option>视频点播</option>
                    				<option>休闲游戏</option>
                    				<option>健身和运动俱乐部</option>
                    				<option>公立医院</option>
                    				<option>眼镜店</option>
                    				<option>医学及牙科实验室</option>
                    				<option>法律咨询和律师事务所</option>
                    				<option>化工产品</option>
                    				<option>药物</option>
                    				<option>医疗器械</option>
                    			</select>
                    		</div>
                    		
                    		<div class="clearfix">
								<label class="fl">上传经营资质：</label>
								<div class="fl" style="width:400px;">
									<p><span class="tstis">根据你的经营内容上传对应的资质许可证(选填)</span><a style="margin-left: 10px;" href="https://cshall.alipay.com/enterprise/knowledgeDetail.htm?knowledgeId=201602066235">了解资质要求</a></p>
									<div class="tupshangchuan">
										<p>
											<img src="./Cashier/pigcms_static/image/sctp.png">
										</p>
										<input type="file" />
									</div>
								</div>
							</div>
                    		
                    		<div class="clearfix">
								<label class="fl"><span>*</span>店铺招牌：</label>
								<div class="fl">
									<p>上传<span class="tsys">1</span>张店铺招牌照片,需清晰展示完整的招牌</p>
									<div class="tupshangchuan">
										<p>
											<img src="./Cashier/pigcms_static/image/sctp.png">
										</p>
										<input type="file" />
									</div>
								</div>
							</div>
							
							<div class="clearfix">
								<label class="fl"><span>*</span>店铺内景：</label>
								<div class="fl">
									<p>上传<span class="tsys">3</span>张店铺内景照片,需体现真实的经营内容</p>
									<div class="tupshangchuan">
										<p>
											<img src="./Cashier/pigcms_static/image/sctp.png">
										</p>
										<input type="file" />
									</div>
								</div>
							</div>
                           
	                    <div>
	                       <button style="width: 100px; height: 35px; background: #108ee9; margin-left: 35%; border-radius: 5px;color: #ffffff; border: none;">下一步</button>
	                        <button style="width: 100px; height: 35px; background: #ffffff; margin-left: 20px; border-radius: 5px;color: #333333; border: none; border: 1px solid #E0E0E0;">上一步</button>
	                    </div>
                
              		</div>
                
           
                
            
            </div>
    </div>
    <script>
    	$(".BusinessCategory").change(function(){
    		var checkText=$(".BusinessCategory").find("option:selected").text();
			if(checkText== '机票代理人' || checkText == "机票平台"){
				$(".tstis").text("根据您选择的经营类目，请提供:《中国民用航空运输销售代理业务资格认可证书》，或经营范围包含“代售机票业务”");
				$(".tstis").addClass("tsys");
			}else if(checkText=="快递服务"){
				$(".tstis").text("根据您选择的经营类目，请提供:《快递业务经营许可证》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="物流货运服务"){
				$(".tstis").text("根据您选择的经营类目，请提供:陆运：《道路运输经营许可证》;空运：《IATA航空货代资质》;海运：《有船无船承运业务经营资格登记证》");
				$(".tstis").addClass("tsys");
			}else if(checkText =="葡萄酒生产商" || checkText == "其他酒类生产商"){
				$(".tstis").text("根据您选择的经营类目，请提供:《酒类经营许可证》或《酒类销售许可证》");			
				$(".tstis").addClass("tsys");
			}else if(checkText=="公共事业（电、气、水）"){
				$(".tstis").text("根据您选择的经营类目，请提供:如非实际水、电、煤等机构来签约，则需要提供水电煤服务提供商授权资质");
				$(".tstis").addClass("tsys");
			}else if(checkText=="公共事业-电力缴费"){
				$(".tstis").text("根据您选择的经营类目，请提供:如非实际电力机构来签约，则需要提供电力服务提供商授权资质");
				$(".tstis").addClass("tsys");
			}else if(checkText=="公共事业-煤气缴费"){
				$(".tstis").text("根据您选择的经营类目，请提供:如非实际煤气机构来签约，则需要提供煤气服务提供商授权资质");
				$(".tstis").addClass("tsys");
			}else if(checkText=="公共事业-自来水缴费"){
				$(".tstis").text("根据您选择的经营类目，请提供:如非实际自来水机构来签约，则需要提供自来水服务提供商授权资质");
				$(".tstis").addClass("tsys");
			}else if(checkText=="典当行"){
				$(".tstis").text("根据您选择的经营类目，请提供:营业执照经营范围明确包含相关内容，或提供《典当经营许可证》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="保险直销（代扣）" || checkText=="电话接入直销" || checkText=="电话外呼直销" || checkText=="旅游相关服务直销" || checkText=="目录直销平台" || checkText=="上门直销（直销员）" || checkText=="直销" || checkText=="直销代理"){
				$(".tstis").text("根据您选择的经营类目，请提供:直销商户授权书、直销员资质或业务代理资质");
				$(".tstis").addClass("tsys");
			}else if(checkText=="烟花爆竹"){
				$(".tstis").text("根据您选择的经营类目，请提供:如果签约当面付需要提供资质，提供《烟花爆竹经营（批发）许可证》或《烟花爆竹经营批发(含进出口）许可证》、《烟花爆竹经营（零售）许可证》、《烟花爆竹安全生产许可证》，其他产品不允许签约");
				$(".tstis").addClass("tsys");
			}else if(checkText=="酒类"){
				$(".tstis").text("根据您选择的经营类目，请提供:《酒类经营许可证》或《酒类销售许可证》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="烟草/雪茄"){
				$(".tstis").text("根据您选择的经营类目，请提供:如果签约当面付需要提供资质，提供《烟草专卖生产企业许可证》、《烟草专卖零售许可证》或《烟草专卖批发企业许可证》，其他产品不允许签约");
				$(".tstis").addClass("tsys");
			}else if(checkText=="电信运营商" || checkText=="话费充值与缴费"){
				$(".tstis").text("根据您选择的经营类目，请提供:如非电信、联通、移动等运营商签约，则需要提供与运营商的合作协议");
				$(".tstis").addClass("tsys");
			}else if(checkText=="计算机软件"){
				$(".tstis").text("根据您选择的经营类目，请提供:如经营内容包含安全软件，则需要提供《计算机信息系统安全专用产品销售许可证》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="视频点播"){
				$(".tstis").text("根据您选择的经营类目，请提供:《网-络文化经营许可证》且营业执照经营范围明确包含相关内容");
				$(".tstis").addClass("tsys");
			}else if(checkText=="休闲游戏" || checkText=="网络游戏点卡、渠道代理" || checkText=="网游运营商（含网页游戏）" || checkText=="网游周边服务、交易平台" || checkText=="游戏系统商"){
				$(".tstis").text("根据您选择的经营类目，请提供:如为棋牌、捕鱼类游戏，则需要提供提交《网络文化经营许可证》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="健身和运动俱乐部"){
				$(".tstis").text("根据您选择的经营类目，请提供:《健身器材销售许可证》、《健身器材生成许可证》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="公立医院" || checkText=="社区医疗服务机构、诊所等" || checkText=="手足病医疗服务" || checkText=="眼科医疗服务" || checkText=="正骨医生"){
				$(".tstis").text("根据您选择的经营类目，请提供:《医疗机构执业许可证》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="眼镜店"){
				$(".tstis").text("根据您选择的经营类目，请提供:如经营内容包含美瞳或者隐形眼镜，则需要提供《第三类医疗器械销售资质》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="医学及牙科实验室" || checkText=="牙科医生"){
				$(".tstis").text("根据您选择的经营类目，请提供:《牙科执业许可证》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="法律咨询和律师事务所"){
				$(".tstis").text("根据您选择的经营类目，请提供:《律师事务所执业许可证》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="化工产品"){
				$(".tstis").text("根据您选择的经营类目，请提供:如出售的化工产品为危险化学品，需提供危险化学品经营备案证明");
				$(".tstis").addClass("tsys");
			}else if(checkText=="药品、药品经营者（批发商）" || checkText=="药物"){
				$(".tstis").text("根据您选择的经营类目，请提供:《药品经营许可证》或《互联网药品交易服务证》");
				$(".tstis").addClass("tsys");
			}else if(checkText=="医疗器械" || checkText=="助听器" || checkText=="康复和身体辅助用品"){
				$(".tstis").text("根据您选择的经营类目，请提供:《医疗器械经营企业许可证》");
				$(".tstis").addClass("tsys");
			}else{
				$(".tstis").text("根据你的经营内容上传对应的资质许可证(选填)");
				$(".tstis").removeClass("tsys");
			}
    	}); 
    </script>
    
    
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

</body>
</html>