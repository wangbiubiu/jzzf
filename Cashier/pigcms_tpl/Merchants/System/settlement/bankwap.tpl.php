<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>账户设置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link href="<?php echo $this->RlStaticResource;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo RL_PIGCMS_STATIC_PATH;?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource;?>plugins/css/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/animate_new.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/style.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH;?>css/app.css" rel="stylesheet">
    <!-- Mainly scripts -->
    <script src="<?php echo $this->RlStaticResource;?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="/Cashier/pigcms_static/plugins/layer/layer.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>js/inspinia.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/pace/pace.min.js"></script>
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo PIGCMS_TPL_STATIC_PATH;?>index/pay/scripts/jquery.qrcode.min.js"></script>
    <!----开放式头部，请在自己的页面加上--</head>-->
    <style type="text/css">
        body{padding: 0;margin: 0;font-size: 14px;background-color: #fff;color:#333;}
        a{text-decoration: none;}
        input[type='text']{width: 100%;height: 48px;border: none;text-indent: 10px;padding: 0;}
        select{border: none;width: 100%;height: 48px;}
        
         .images{
      	margin-left: 50px;;
      }
      
    </style>
</head>
<body>
<div style="width: 100%;height: 50px;line-height: 50px;background-color: #008fd3;">
    <a href="/merchants.php?m=User&c=index&a=sindex" onclick="" style="color:#fff;padding:0 20px 0 10px;display: inline-block;">< 返回</a>
</div>
<div style="margin: 0;">
    <?php if(!empty($bank) && ($bank['bank'] == 0 || $bank['bank'] == 1)){?>
    <div class="showbank">
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                类型：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <span style="margin-left: 10px;"></span><?php if(!empty($bank) && $bank['isCompay'] == "0"){echo '个人';}else{echo '公司';}?>
            </div>
        </div>
        
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                证件类型：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <span style="margin-left: 10px;"></span><?php
                switch($bank['cerdType']){
                    case "01":
                        echo '身份证';
                        break;
                    case "02":
                        echo '军官证';
                        break;
                    case "03":
                        echo '护照';
                        break;
                    case "04":
                        echo '回乡证';
                        break;
                    case "05":
                        echo '台胞证';
                        break;
                    case "06":
                        echo '警官证';
                        break;
                    case "07":
                        echo '士兵证';
                        break;
                    case "99":
                        echo '其它证件';
                        break;
                }
                ?>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                证件号码：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" name="cerdId" value="<?php echo $bank['cerdId'];?>" readonly="readonly">
            </div>
        </div>
         <div class="images">
                        	<img width="75px;" height="65px;" src="<?php echo $bank['imgzheng'] ?>">
                        	<img width="75px;" height="65px;" src="<?php echo $bank['imgfan'] ?>">
                        	<img width="75px;" height="65px;" src="<?php echo $bank['shouimg'] ?>">
                           
                        					
                        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 28%;text-align: right;">
                预留手机号：
            </div>
            <div style="float:left;width: 65%;margin-right: 5%;">
                <input type="text" name="phoneNo" value="<?php echo $bank['phoneNo'];?>" placeholder="选填" readonly="readonly">
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                开户姓名：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" name="customerName" value="<?php echo $bank['customerName'];?>" readonly="readonly">
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                开户银行：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <span style="margin-left: 10px;"></span>
                <?php
                switch($bank['settBankNo']){
                    case "ICBC":
                        echo '工商银行';
                        break;
                    case "ABC":
                        echo '农业银行';
                        break;
                    case "BOC":
                        echo '中国银行';
                        break;
                    case "CCB":
                        echo '建设银行';
                        break;
                    case "CMB":
                        echo '招商银行';
                        break;
                    case "BOCM":
                        echo '交通银行';
                        break;
                    case "CMBC":
                        echo '民生银行';
                        break;
                    case "CNCB":
                        echo '中信银行';
                        break;
                    case "CEBB":
                        echo '光大银行';
                        break;
                    case "CIB":
                        echo '兴业银行';
                        break;
                    case "BOB":
                        echo '北京银行';
                        break;
                    case "GDB":
                        echo '广发银行';
                        break;
                    case "HXB":
                        echo '华夏银行';
                        break;
                    case "PAB":
                        echo '平安银行';
                        break;
                    case "BOS":
                        echo '上海银行';
                        break;
                    case "BOHC":
                        echo '渤海银行';
                        break;
                    case "BOJ":
                        echo '江苏银行';
                        break;
                    case "SPDB":
                        echo '浦发银行';
                        break;
                    case "PSBC":
                        echo '邮储银行';
                        break;
                    case "":
                        echo '其他银行';
                        break;
                }
                ?>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                银行卡号：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" name="acctNo" value="<?php echo $bank['acctNo'];?>" readonly="readonly">
            </div>
        </div>
        <div class="images">
                        	<img width="75px;" height="65px;" src="<?php echo $bank['bankzheng'] ?>">
                        	<img width="75px;" height="65px;" src="<?php echo $bank['bankfan'] ?>">
                        	
                           
                        					
                        </div>
        <?php if(empty($bank) || $bank['bank'] != 0){?>
            <div style="width: 100%;padding: 20px 0 0;text-align: center;background-color: #fff;">
                <input type="button" value="修改" onclick="$('.showbank').hide();$('.editbank').show();" class="btn2" style="width: 50%;height: 40px;border: none;background-color: #008fd3;color:#fff;"/>
            </div>
        <?php } ?>
    </div>
    <form method="post" class="editbank" style="display: none;" enctype="multipart/form-data">
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                类型：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <?php if(!empty($bank) && $bank['bank'] == 0){ ?>
                    <span style="margin-left: 10px;"></span><?php if(!empty($bank) && $bank['isCompay'] == "0"){echo '个人';}else{echo '公司';}?>
                <?php }else{ ?>
                    <select name="isCompay">
                        <option value="0" <?php if(!empty($bank) && $bank['isCompay'] == "0"){echo 'selected="selected"';} ?>>个人</option>
                        <option value="1" <?php if(!empty($bank) && $bank['isCompay'] == "1"){echo 'selected="selected"';} ?>>公司</option>
                    </select>
                <?php } ?>
            </div>
        </div>
       
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                证件类型：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <?php if(!empty($bank) && $bank['bank'] == 0){ ?>
                    <span style="margin-left: 10px;"></span><?php
                    switch($bank['cerdType']){
                        case "01":
                            echo '身份证';
                            break;
                        case "02":
                            echo '军官证';
                            break;
                        case "03":
                            echo '护照';
                            break;
                        case "04":
                            echo '回乡证';
                            break;
                        case "05":
                            echo '台胞证';
                            break;
                        case "06":
                            echo '警官证';
                            break;
                        case "07":
                            echo '士兵证';
                            break;
                        case "99":
                            echo '其它证件';
                            break;
                    }
                    ?>
                <?php }else{ ?>
                    <select name="cerdType">
                        <option value="01" <?php if(!empty($bank) && $bank['cerdType'] == "01"){echo 'selected="selected"';} ?>>身份证</option>
                        <option value="02" <?php if(!empty($bank) && $bank['cerdType'] == "02"){echo 'selected="selected"';} ?>>军官证</option>
                        <option value="03" <?php if(!empty($bank) && $bank['cerdType'] == "03"){echo 'selected="selected"';} ?>>护照</option>
                        <option value="04" <?php if(!empty($bank) && $bank['cerdType'] == "04"){echo 'selected="selected"';} ?>>回乡证</option>
                        <option value="05" <?php if(!empty($bank) && $bank['cerdType'] == "05"){echo 'selected="selected"';} ?>>台胞证</option>
                        <option value="06" <?php if(!empty($bank) && $bank['cerdType'] == "06"){echo 'selected="selected"';} ?>>警官证</option>
                        <option value="07" <?php if(!empty($bank) && $bank['cerdType'] == "07"){echo 'selected="selected"';} ?>>士兵证</option>
                        <option value="99" <?php if(!empty($bank) && $bank['cerdType'] == "99"){echo 'selected="selected"';} ?>>其它证件</option>
                    </select>
                <?php } ?>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                证件号码：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" name="cerdId" value="<?php echo $bank['cerdId'];?>" <?php if(!empty($bank) && $bank['bank'] == 0){echo 'readonly="readonly"';} ?>>
            </div>
        </div>
         <!--start新增上传  添加7.10-->
                       <div  id="Realestate"  style="padding: 10px;line-height: 48px;">
							
							<p class="clearfix">注：只能上传jpg,png格式小于1M大小的图片</p>
							<div  class="clearfix">
								
								
							   <label style="float:left ;margin-left: 5%;">上传身份证正面图片:</label>
								 
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" id ='constructLeanID' href="javascript:">  上传文件</a> 
											</div>
											
											<div class="js_pager">
												<?php if (!empty($reg['constructLeanID'])){  
												
												echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['constructLeanID'].'"/><input name="imgzheng" class="imginput" type="hidden" value="'.$reg['constructLeanID'].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
											 }?>
											</div> 
									   </div>
								  	</div>
								</div>
							</div>
								<!--第二张-->
								
						<div class="clearfix" >
								<label style="float:left ;margin-left: 5%;">上传身份证反面图片:</label>
								
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" id ='constructLean' href="javascript:"> 上传文件 </a> 
											</div>
											<div class="js_pager">
												<?php if (!empty($reg['constructLean'])){ for ($i=0; $i <count($reg['constructLean']); $i++) { 
												
												echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['constructLean'][$i].'"/><input name="constructLeanList[]" class="imginput" type="hidden" value="'.$reg['constructLean'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
											} }?>
											</div> 
									   </div>
								  	</div>
								</div>
							</div>
							
							<div class="clearfix">
								<label style="float:left ;margin-left: 5%;">上传手持身份证图片:</label>
								<!--<span> 示例：
								  	<div id="imgtest">
								  		<img width="50px" height="35px" src="./Cashier/pigcms_static/image/model3.jpg"  id="image1"/> 
								  		</div>
								  	
								  </span>-->
								<div style="float:left ;">
									<!--新增-->
								
									
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" id='contact' href="javascript:" '>上传文件</a> 
											</div>
											<div class="js_pager">
												<?php if (!empty($reg['contact'])){ for ($i=0; $i <count($reg['contact']); $i++) { 
												
												echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['contact'][$i].'"/><input name="contactList[]" class="imginput" type="hidden" value="'.$reg['contact'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
											} }?>
											</div> 
									   </div>
								  	</div>
								</div>
							</div>
							</div>
         <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 28%;text-align: right;">
                预留手机号：
            </div>
            <div style="float:left;width: 65%;margin-right: 5%;">
                <input type="text" name="phoneNo" value="<?php echo $bank['phoneNo'];?>" placeholder="选填" <?php if(!empty($bank) && $bank['bank'] == 0){echo 'readonly="readonly"';} ?>>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                开户姓名：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" name="customerName" value="<?php echo $bank['customerName'];?>" <?php if(!empty($bank) && $bank['bank'] == 0){echo 'readonly="readonly"';} ?>>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                开户银行：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <?php if(!empty($bank) && $bank['bank'] == 0){ ?>
                    <span style="margin-left: 10px;"></span>
                    <?php
                    switch($bank['settBankNo']){
                        case "ICBC":
                            echo '工商银行';
                            break;
                        case "ABC":
                            echo '农业银行';
                            break;
                        case "BOC":
                            echo '中国银行';
                            break;
                        case "CCB":
                            echo '建设银行';
                            break;
                        case "CMB":
                            echo '招商银行';
                            break;
                        case "BOCM":
                            echo '交通银行';
                            break;
                        case "CMBC":
                            echo '民生银行';
                            break;
                        case "CNCB":
                            echo '中信银行';
                            break;
                        case "CEBB":
                            echo '光大银行';
                            break;
                        case "CIB":
                            echo '兴业银行';
                            break;
                        case "BOB":
                            echo '北京银行';
                            break;
                        case "GDB":
                            echo '广发银行';
                            break;
                        case "HXB":
                            echo '华夏银行';
                            break;
                        case "PAB":
                            echo '平安银行';
                            break;
                        case "BOS":
                            echo '上海银行';
                            break;
                        case "BOHC":
                            echo '渤海银行';
                            break;
                        case "BOJ":
                            echo '江苏银行';
                            break;
                        case "SPDB":
                            echo '浦发银行';
                            break;
                        case "PSBC":
                            echo '邮储银行';
                            break;
                        case "":
                            echo '其他银行';
                            break;
                    }
                    ?>
                <?php }else{ ?>
                    <select name="settBankNo">
                        <option value="ICBC" <?php if(!empty($bank) && $bank['settBankNo'] == "ICBC"){echo 'selected="selected"';} ?>>工商银行</option>
                        <option value="ABC" <?php if(!empty($bank) && $bank['settBankNo'] == "ABC"){echo 'selected="selected"';} ?>>农业银行</option>
                        <option value="BOC" <?php if(!empty($bank) && $bank['settBankNo'] == "BOC"){echo 'selected="selected"';} ?>>中国银行</option>
                        <option value="CCB" <?php if(!empty($bank) && $bank['settBankNo'] == "CCB"){echo 'selected="selected"';} ?>>建设银行</option>
                        <option value="CMB" <?php if(!empty($bank) && $bank['settBankNo'] == "CMB"){echo 'selected="selected"';} ?>>招商银行</option>
                        <option value="BOCM" <?php if(!empty($bank) && $bank['settBankNo'] == "BOCM"){echo 'selected="selected"';} ?>>交通银行</option>
                        <option value="CMBC" <?php if(!empty($bank) && $bank['settBankNo'] == "CMBC"){echo 'selected="selected"';} ?>>民生银行</option>
                        <option value="CNCB" <?php if(!empty($bank) && $bank['settBankNo'] == "CNCB"){echo 'selected="selected"';} ?>>中信银行</option>
                        <option value="CEBB" <?php if(!empty($bank) && $bank['settBankNo'] == "CEBB"){echo 'selected="selected"';} ?>>光大银行</option>
                        <option value="CIB" <?php if(!empty($bank) && $bank['settBankNo'] == "CIB"){echo 'selected="selected"';} ?>>兴业银行</option>
                        <option value="BOB" <?php if(!empty($bank) && $bank['settBankNo'] == "BOB"){echo 'selected="selected"';} ?>>北京银行</option>
                        <option value="GDB" <?php if(!empty($bank) && $bank['settBankNo'] == "GDB"){echo 'selected="selected"';} ?>>广发银行</option>
                        <option value="HXB" <?php if(!empty($bank) && $bank['settBankNo'] == "HXB"){echo 'selected="selected"';} ?>>华夏银行</option>
                        <option value="PSBC" <?php if(!empty($bank) && $bank['settBankNo'] == "PSBC"){echo 'selected="selected"';} ?>>邮储银行</option>
                        <option value="SPDB" <?php if(!empty($bank) && $bank['settBankNo'] == "SPDB"){echo 'selected="selected"';} ?>>浦发银行</option>
                        <option value="PAB" <?php if(!empty($bank) && $bank['settBankNo'] == "PAB"){echo 'selected="selected"';} ?>>平安银行</option>
                        <option value="BOS" <?php if(!empty($bank) && $bank['settBankNo'] == "BOS"){echo 'selected="selected"';} ?>>上海银行</option>
                        <option value="BOHC" <?php if(!empty($bank) && $bank['settBankNo'] == "BOHC"){echo 'selected="selected"';} ?>>渤海银行</option>
                        <option value="BOJ" <?php if(!empty($bank) && $bank['settBankNo'] == "BOJ"){echo 'selected="selected"';} ?>>江苏银行</option>
                        <option value="" <?php if(!empty($bank) && $bank['settBankNo'] == ""){echo 'selected="selected"';} ?>>其他银行</option>
                    </select>
                <?php } ?>
            </div>
        </div>
        <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
            <div style="float:left;width: 24%;text-align: right;">
                银行卡号：
            </div>
            <div style="float:left;width: 70%;margin-right: 5%;">
                <input type="text" name="acctNo" value="<?php echo $bank['acctNo'];?>" <?php if(!empty($bank) && $bank['bank'] == 0){echo 'readonly="readonly"';} ?>>
            </div>
        </div>
        <div class="clearfix" id="Realestate" >
							<div class="clearfix">
								<label style="float:left ;margin-left: 5%;">上传银行卡正面图片:</label>
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" id='cunstructID'  href="javascript:"> 上传文件</a> 
											</div>
											<div class="js_pager">
												<?php if (!empty($reg['cunstructID'])){ for ($i=0; $i <count($reg['cunstructID']); $i++) { 
												
												echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['cunstructID'][$i].'"/><input name="cunstructIDList[]" class="imginput" type="hidden" value="'.$reg['cunstructID'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
											} }?>
											</div> 
									   </div>
								  	</div>
								</div>
							</div>
							<div class="clearfix">
								<label style="float:left ;margin-left: 5%;">上传银行卡背面图片:</label>
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" id='landUseId' href="javascript:"> 上传文件</a> 
											</div>
											<div class="js_pager">
												<?php if (!empty($reg['landUseId'])){ for ($i=0; $i <count($reg['landUseId']); $i++) { 
												
												echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['landUseId'][$i].'"/><input name="landUseIdList[]" class="imginput" type="hidden" value="'.$reg['landUseId'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
											} }?>
											</div> 
									   </div>
								  	</div>
								</div>
							</div>
						</div>
						<!--end-->
        <?php if(empty($bank) || $bank['bank'] != 0){?>
            <div style="width: 100%;padding: 20px 0 0;text-align: center;background-color: #fff;">
                <input type="submit" value="修改" class="btn" style="width: 50%;height: 40px;border: none;background-color: #008fd3;color:#fff;"/>
            </div>
        <?php } ?>
    </form>
</div>
<?php }else{ ?>
    <div>
        <form method="post" action="merchants.php?m=User&c=settlement&a=bank" enctype="multipart/form-data">
            <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
                <div style="float:left;width: 24%;text-align: right;">
                    类型：
                </div>
                <div style="float:left;width: 70%;margin-right: 5%;">
                    <?php if(!empty($bank) && $bank['bank'] == 0){ ?>
                        <span style="margin-left: 10px;"></span><?php if(!empty($bank) && $bank['isCompay'] == "0"){echo '个人';}else{echo '公司';}?>
                    <?php }else{ ?>
                        <select name="isCompay">
                            <option value="0" <?php if(!empty($bank) && $bank['isCompay'] == "0"){echo 'selected="selected"';} ?>>个人</option>
                            <option value="1" <?php if(!empty($bank) && $bank['isCompay'] == "1"){echo 'selected="selected"';} ?>>公司</option>
                        </select>
                    <?php } ?>
                </div>
            </div>
           
            <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
                <div style="float:left;width: 24%;text-align: right;">
                    证件类型：
                </div>
                <div style="float:left;width: 70%;margin-right: 5%;">
                    <?php if(!empty($bank) && $bank['bank'] == 0){ ?>
                        <span style="margin-left: 10px;"></span><?php
                        switch($bank['cerdType']){
                            case "01":
                                echo '身份证';
                                break;
                            case "02":
                                echo '军官证';
                                break;
                            case "03":
                                echo '护照';
                                break;
                            case "04":
                                echo '回乡证';
                                break;
                            case "05":
                                echo '台胞证';
                                break;
                            case "06":
                                echo '警官证';
                                break;
                            case "07":
                                echo '士兵证';
                                break;
                            case "99":
                                echo '其它证件';
                                break;
                        }
                        ?>
                    <?php }else{ ?>
                        <select name="cerdType">
                            <option value="01" <?php if(!empty($bank) && $bank['cerdType'] == "01"){echo 'selected="selected"';} ?>>身份证</option>
                            <option value="02" <?php if(!empty($bank) && $bank['cerdType'] == "02"){echo 'selected="selected"';} ?>>军官证</option>
                            <option value="03" <?php if(!empty($bank) && $bank['cerdType'] == "03"){echo 'selected="selected"';} ?>>护照</option>
                            <option value="04" <?php if(!empty($bank) && $bank['cerdType'] == "04"){echo 'selected="selected"';} ?>>回乡证</option>
                            <option value="05" <?php if(!empty($bank) && $bank['cerdType'] == "05"){echo 'selected="selected"';} ?>>台胞证</option>
                            <option value="06" <?php if(!empty($bank) && $bank['cerdType'] == "06"){echo 'selected="selected"';} ?>>警官证</option>
                            <option value="07" <?php if(!empty($bank) && $bank['cerdType'] == "07"){echo 'selected="selected"';} ?>>士兵证</option>
                            <option value="99" <?php if(!empty($bank) && $bank['cerdType'] == "99"){echo 'selected="selected"';} ?>>其它证件</option>
                        </select>
                    <?php } ?>
                </div>
            </div>
            <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
                <div style="float:left;width: 24%;text-align: right;">
                    证件号码：
                </div>
                <div style="float:left;width: 70%;margin-right: 5%;">
                    <input type="text" name="cerdId" value="<?php echo $bank['cerdId'];?>" <?php if(!empty($bank) && $bank['bank'] == 0){echo 'readonly="readonly"';} ?>>
                </div>
            </div>
            <!--start新增上传  添加7.10-->
                       <div  id="Realestate" >
							
							<p class="clearfix">注：只能上传jpg,png格式小于1M大小的图片</p>
							<div  class="clearfix">
								
								
							   <label style="float:left ;margin-left: 5%;">上传身份证正面图片:</label>
								 
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" id ='constructLeanID' href="javascript:">  上传文件</a> 
											</div>
											
											<div class="js_pager">
												<?php if (!empty($reg['constructLeanID'])){  
												
												echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['constructLeanID'].'"/><input name="imgzheng" class="imginput" type="hidden" value="'.$reg['constructLeanID'].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
											 }?>
											</div> 
									   </div>
								  	</div>
								</div>
							</div>
								<!--第二张-->
								
						<div class="clearfix" >
								<label style="float:left ;margin-left: 5%;">上传身份证反面图片:</label>
								
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" id ='constructLean' href="javascript:"> 上传文件 </a> 
											</div>
											<div class="js_pager">
												<?php if (!empty($reg['constructLean'])){ for ($i=0; $i <count($reg['constructLean']); $i++) { 
												
												echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['constructLean'][$i].'"/><input name="constructLeanList[]" class="imginput" type="hidden" value="'.$reg['constructLean'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
											} }?>
											</div> 
									   </div>
								  	</div>
								</div>
							</div>
							
							<div class="clearfix">
								<label style="float:left ;margin-left: 5%;">上传手持身份证图片:</label>
								<!--<span> 示例：
								  	<div id="imgtest">
								  		<img width="50px" height="35px" src="./Cashier/pigcms_static/image/model3.jpg"  id="image1"/> 
								  		</div>
								  	
								  </span>-->
								<div style="float:left ;">
									<!--新增-->
								
									
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" id='contact' href="javascript:" '>上传文件</a> 
											</div>
											<div class="js_pager">
												<?php if (!empty($reg['contact'])){ for ($i=0; $i <count($reg['contact']); $i++) { 
												
												echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['contact'][$i].'"/><input name="contactList[]" class="imginput" type="hidden" value="'.$reg['contact'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
											} }?>
											</div> 
									   </div>
								  	</div>
								</div>
							</div>
							</div>
			 <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
                <div style="float:left;width: 28%;text-align: right;">
                    预留手机号：
                </div>
                <div style="float:left;width: 65%;margin-right: 5%;">
                    <input type="text" name="phoneNo" value="<?php echo $bank['phoneNo'];?>" placeholder="选填" <?php if(!empty($bank) && $bank['bank'] == 0){echo 'readonly="readonly"';} ?>>
                </div>
            </div>
            <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
                <div style="float:left;width: 24%;text-align: right;">
                    开户姓名：
                </div>
                <div style="float:left;width: 70%;margin-right: 5%;">
                    <input type="text" name="customerName" value="<?php echo $bank['customerName'];?>" <?php if(!empty($bank) && $bank['bank'] == 0){echo 'readonly="readonly"';} ?>>
                </div>
            </div>				
            <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
                <div style="float:left;width: 24%;text-align: right;">
                    开户银行：
                </div>
                <div style="float:left;width: 70%;margin-right: 5%;">
                    <?php if(!empty($bank) && $bank['bank'] == 0){ ?>
                        <span style="margin-left: 10px;"></span>
                        <?php
                        switch($bank['settBankNo']){
                            case "ICBC":
                                echo '工商银行';
                                break;
                            case "ABC":
                                echo '农业银行';
                                break;
                            case "BOC":
                                echo '中国银行';
                                break;
                            case "CCB":
                                echo '建设银行';
                                break;
                            case "CMB":
                                echo '招商银行';
                                break;
                            case "BOCM":
                                echo '交通银行';
                                break;
                            case "CMBC":
                                echo '民生银行';
                                break;
                            case "CNCB":
                                echo '中信银行';
                                break;
                            case "CEBB":
                                echo '光大银行';
                                break;
                            case "CIB":
                                echo '兴业银行';
                                break;
                            case "BOB":
                                echo '北京银行';
                                break;
                            case "GDB":
                                echo '广发银行';
                                break;
                            case "HXB":
                                echo '华夏银行';
                                break;
                            case "PAB":
                                echo '平安银行';
                                break;
                            case "BOS":
                                echo '上海银行';
                                break;
                            case "BOHC":
                                echo '渤海银行';
                                break;
                            case "BOJ":
                                echo '江苏银行';
                                break;
                            case "SPDB":
                                echo '浦发银行';
                                break;
                            case "PSBC":
                                echo '邮储银行';
                                break;
                            case "":
                                echo '其他银行';
                                break;
                        }
                        ?>
                    <?php }else{ ?>
                        <select name="settBankNo">
                            <option value="ICBC" <?php if(!empty($bank) && $bank['settBankNo'] == "ICBC"){echo 'selected="selected"';} ?>>工商银行</option>
                            <option value="ABC" <?php if(!empty($bank) && $bank['settBankNo'] == "ABC"){echo 'selected="selected"';} ?>>农业银行</option>
                            <option value="BOC" <?php if(!empty($bank) && $bank['settBankNo'] == "BOC"){echo 'selected="selected"';} ?>>中国银行</option>
                            <option value="CCB" <?php if(!empty($bank) && $bank['settBankNo'] == "CCB"){echo 'selected="selected"';} ?>>建设银行</option>
                            <option value="CMB" <?php if(!empty($bank) && $bank['settBankNo'] == "CMB"){echo 'selected="selected"';} ?>>招商银行</option>
                            <option value="BOCM" <?php if(!empty($bank) && $bank['settBankNo'] == "BOCM"){echo 'selected="selected"';} ?>>交通银行</option>
                            <option value="CMBC" <?php if(!empty($bank) && $bank['settBankNo'] == "CMBC"){echo 'selected="selected"';} ?>>民生银行</option>
                            <option value="CNCB" <?php if(!empty($bank) && $bank['settBankNo'] == "CNCB"){echo 'selected="selected"';} ?>>中信银行</option>
                            <option value="CEBB" <?php if(!empty($bank) && $bank['settBankNo'] == "CEBB"){echo 'selected="selected"';} ?>>光大银行</option>
                            <option value="CIB" <?php if(!empty($bank) && $bank['settBankNo'] == "CIB"){echo 'selected="selected"';} ?>>兴业银行</option>
                            <option value="BOB" <?php if(!empty($bank) && $bank['settBankNo'] == "BOB"){echo 'selected="selected"';} ?>>北京银行</option>
                            <option value="GDB" <?php if(!empty($bank) && $bank['settBankNo'] == "GDB"){echo 'selected="selected"';} ?>>广发银行</option>
                            <option value="HXB" <?php if(!empty($bank) && $bank['settBankNo'] == "HXB"){echo 'selected="selected"';} ?>>华夏银行</option>
                            <option value="PSBC" <?php if(!empty($bank) && $bank['settBankNo'] == "PSBC"){echo 'selected="selected"';} ?>>邮储银行</option>
                            <option value="SPDB" <?php if(!empty($bank) && $bank['settBankNo'] == "SPDB"){echo 'selected="selected"';} ?>>浦发银行</option>
                            <option value="PAB" <?php if(!empty($bank) && $bank['settBankNo'] == "PAB"){echo 'selected="selected"';} ?>>平安银行</option>
                            <option value="BOS" <?php if(!empty($bank) && $bank['settBankNo'] == "BOS"){echo 'selected="selected"';} ?>>上海银行</option>
                            <option value="BOHC" <?php if(!empty($bank) && $bank['settBankNo'] == "BOHC"){echo 'selected="selected"';} ?>>渤海银行</option>
                            <option value="BOJ" <?php if(!empty($bank) && $bank['settBankNo'] == "BOJ"){echo 'selected="selected"';} ?>>江苏银行</option>
                            <option value="" <?php if(!empty($bank) && $bank['settBankNo'] == ""){echo 'selected="selected"';} ?>>其他银行</option>
                        </select>
                    <?php } ?>
                </div>
            </div>
            <div style="padding: 0 10px;height: 50px;line-height: 50px;border-bottom: 1px solid #f5f5f5;background-color: #fff;">
                <div style="float:left;width: 24%;text-align: right;">
                    银行卡号：
                </div>
                <div style="float:left;width: 70%;margin-right: 5%;">
                    <input type="text" name="acctNo" value="<?php echo $bank['acctNo'];?>" <?php if(!empty($bank) && $bank['bank'] == 0){echo 'readonly="readonly"';} ?>>
                </div>
            </div>
            <div class="clearfix" id="Realestate" >
							<div class="clearfix">
								<label style="float:left ;margin-left: 5%;">上传银行卡正面图片:</label>
								
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" id='cunstructID'  href="javascript:" >上传文件</a> 
											</div>
											<div class="js_pager">
												<?php if (!empty($reg['cunstructID'])){ for ($i=0; $i <count($reg['cunstructID']); $i++) { 
												
												echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['cunstructID'][$i].'"/><input name="cunstructIDList[]" class="imginput" type="hidden" value="'.$reg['cunstructID'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
											} }?>
											</div> 
									   </div>
								  	</div>
								</div>
							</div>
							<div class="clearfix">
								<label style="float:left ;margin-left: 5%;">上传银行卡背面图片:</label>
								
								<div style="float:left ;">
									<div id="js_upload_wrp">
									   <div class="img_upload_wrp group"> 
											<div class="img_upload_box"> 
												 <a class="img_upload_box_oper js_upload js_pic_url" id='landUseId' href="javascript:"> 上传文件</a> 
											</div>
											<div class="js_pager">
												<?php if (!empty($reg['landUseId'])){ for ($i=0; $i <count($reg['landUseId']); $i++) { 
												
												echo $str = '<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><img  src="'.$reg['landUseId'][$i].'"/><input name="landUseIdList[]" class="imginput" type="hidden" value="'.$reg['landUseId'][$i].'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';
											} }?>
											</div> 
									   </div>
								  	</div>
								</div>
							</div>
						</div>
						<!--end-->
            <?php if(empty($bank) || $bank['bank'] != 0){?>
                <div style="width: 100%;padding: 20px 0 0;text-align: center;background-color: #fff;">
                    <input type="submit" value="提交" class="btn" style="width: 50%;height: 40px;border: none;background-color: #008fd3;color:#fff;"/>
                </div>
            <?php } ?>
        </form>
    </div>
<?php } ?>
<div style="text-align: center;padding: 20px 0;">
    状态：<span style="color:#f00;"><?php if(empty($bank)){echo '未设置';}elseif($bank['bank'] == 0){echo '审核中，预计需要1-3个工作日';}elseif($bank['bank']==2){echo '审核失败：'.$bank['bankmsg'];}else{echo '通过审核';} ?></span>
</div>
<script type="text/javascript">
    $('.btn').click(function () {
        if( $(':input[name="phoneNo"]').val()==''){
            swal('银行预留手机号不能为空!', "", 'error');
            return false;
        }else if( $(':input[name="customerName"]').val()==''){
            swal('账户名称不能为空!', "", 'error');
            return false;
        }else if( $(':input[name="cerdId"]').val()==''){
            swal('证件号码不能为空!', "", 'error');
            return false;
        }else if( $(':input[name="acctNo"]').val()==''){
            swal('银行卡号不能为空!', "", 'error');
            return false;
        }
 //       $.post('/merchants.php?m=User&c=settlement&a=bank',$('form').serialize(), function (e) {
//          if (e.code == 1) {
//              swal({
//                  title: "配置成功",
//                  text: "",
//                  type: "success"
//              }, function () {
//                  window.location.reload();
//              });
//          } else {
//              swal('配置失败', "", 'error');
//          }
//      }, 'json');
//  });
</script>
  <script src="<?php echo $this->RlStaticResource; ?>plugins/js/dropzone/dropzone.js"></script>
    <!-- iCheck -->
   
<script src="<?php echo $this -> RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
             <!--start上传图片-->
<script>	
     $(".js_pic_url,.js_pic_url .icon20_common add_gray").dropzone({
		       
		//url: "?m=Agent&c=merchant&a=uploadImg",
		url: "?m=User&c=settlement&a=uploadImg",
		addRemoveLinks: false,
		maxFilesize: 1,
		acceptedFiles: ".jpg,.png",
		uploadMultiple: false,
		init: function() {
			this.on("success", function(file,responseText) {
				var imgtype = this.previewsContainer.id;
                var rept = $.parseJSON(responseText);
				var  imgHtml='<div class="img_upload_box img_upload_preview_box js_edit_pic_wrp"><input name="'+imgtype+'List[]" class="imginput" type="hidden" value="'+rept.fileUrl+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';

				//加
//				if (imgtype=='annuxes') {
//					imgHtml =$(this.element).parent().siblings().html() + imgHtml;
//				}
	
				$(this.element).parents(".img_upload_box").siblings().html(imgHtml);
			});
		}
	});

    	
  
     
</script>

<script>	
	
	
$(document).on('mouseover mouseout','.img_upload_preview_box',function(event){
	   if(event.type == "mouseover"){
	     $(this).find('p').show();
	   }else if(event.type == "mouseout"){
		$(this).find('p').hide();
		}
	  });

function DelthisImg(obj){

swal({
title: "您确定删除图片！",
text: "",
type: "warning",
showCancelButton: true,
confirmButtonText: "确定",
cancelButtonText: "取消",
closeOnConfirm: true,
closeOnCancel: true
},function(isConfirm){
	if (isConfirm){
		obj.parent('p').parent('.img_upload_preview_box').remove();	
	}
});

}
</script>
</div>
</body>
</html>