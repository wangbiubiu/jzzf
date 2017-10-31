<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>门店统计</title>
    <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/header.tpl.php'; ?>
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>wxCoupon/wxCoupon.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource; ?>plugins/css/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource; ?>plugins/css/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo RL_PIGCMS_STATIC_PATH; ?>plugins/css/footable/footable.core.css" rel="stylesheet">
    <link href="<?php echo PIGCMS_TPL_STATIC_PATH; ?>merchant/store_mangecss.css" rel="stylesheet">

    <link href="<?php echo $this->RlStaticResource; ?>plugins/css/dropzone/basic.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource; ?>plugins/css/dropzone/dropzone.css" rel="stylesheet">
    <link href="<?php echo $this->RlStaticResource; ?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">

    <style>
        <script src="<?php echo $this->RlStaticResource; ?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
                                                                                                            <script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/chartJs/Chart.min.js"></script>
        <!-- Data picker -->
        <script src="http://cashier.b0.upaiyun.com/pigcms_static/plugins/js/datapicker/bootstrap-datepicker.js"></script>
                                                                                                                  <script src="<?php echo $this->RlStaticResource; ?>plugins/js/footable/footable.all2.min.js"></script>

                                                                                                                                                                                                                 select.input-sm {
                                                                                                                                                                                                                     height: 35px;
                                                                                                                                                                                                                     line-height: 35px;
                                                                                                                                                                                                                 }

        .float-e-margins .btn-info {
            margin-bottom: 0px;
        }

        .fa-paste {
            margin-right: 7px;
            padding: 0px;
        }

        .dz-preview {
            display: none;
        }

        .ibox-title ul {
            list-style: outside none none !important;
            margin: 0 0 0 10px;
            padding: 0;
        }

        .ibox-title li {
            float: left;
            width: 15%;
        }

        #commonpage {
            float: right;
            margin-bottom: 10px;
        }

        #table-list-body .btn-st {
            background-color: #337ab7;
            border-color: #2e6da4;
            cursor: auto;
        }

        #select_Cardtype .i-checks label {
            cursor: pointer;
        }

        #ewmPopDiv .modal-body {
            text-align: center;
        }

        .modal-footer {
            text-align: center;
        }

        .modal-footer .btn {
            padding: 7px 30px;
        }

        .js_modify_quantity .fa {
            margin-left: 10px;
        }

        #ewmPopDiv .downewm {
            font-size: 14px;
            padding: 15px;
            text-align: center;
        }

        .modal-body {
            padding: 20px 30px 15px;
        }

        #select_Cardtype p {
            margin-bottom: 8px;
        }
        .img_upload_preview_box p{margin:0px;}

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
        .bankCardInfor{
            background: #FFFFFF;
            padding-bottom: 20px;;
        }
        .bankCardInfor>h2{
            font-size: 18px; font-weight: normal; padding: 10px 20px; border-top: 3px solid #6DBFFF;
            border-bottom: 1px solid #f3f3f3;
        }
        .bankCardInfor>form{
            width: 90%;
            border: 1px solid #f3f3f3;
            margin: 40px 5%;

        }
        .bankCardInfor>form>div{
            padding: 20px 0;

        }
        .bankCardInfor>form>h2{ width: 100%; height: 30px; font-size: 16px; line-height: 30px; padding-left: 10px; background: #d9dadc; color: #FFFFFF; margin-top: 0px;}
        .bankCardInfor>form>div>label{ display: inline-block; width: 200px;  text-align: right; margin-right: 10px;}
        .bankCardInfor>form>div>label>i{ color: red; margin-right: 10px;}

        .img_upload_wrp .img_upload_box {
            display: inline-block;
            width: 98px;
            height: 27px;
            margin: 0 10px 10px 0;
            vertical-align: top;
            margin-left: 236px;
        }
        .img_upload_box{float: left;}
        .js_pager{ float: left; }

        .img_upload_box_oper {
            display: block;
            background: #d9dadc;
            border: 1px solid #d9dadc !important;
            width: 100%;
            height: 30px !important;
            text-align: center;
            line-height: 30px;
            color:#777777;
            border-radius: 5px;
            margin-left: 1px;
            margin-left: -208px;

        }
        .img_upload_box{ height: 40px !important }
        .js_pager,.img_upload_box {float: none !important;}
        .js_edit_pic_wrp{height: 98px !important;}
        .img_upload_preview_box p{margin:0px;}

        .bankCardInfor>form>p{width: 120px;margin: 20px auto;}
        .bankCardInfor>form>p>button{ background: #0066CC; width: 120px; height: 30px; border: none; border-radius: 5px; color: #FFFFFF; margin: 0 auto;}
        input,select{border-radius: 3px;border: 1px solid #bbbbbb;height:30px;width:200px;text-indent: 5px;}
        /*新增*/
        .clearfix{
            margin-left: 62px;
        }

        .images{
            margin-left: 120px;;
        }


        .img_upload_wrp .img_upload_box.img_upload_preview_box img{
            margin-left: -231px;
            width: 100%;
            /*margin-top: -27px;*/
        }
        .img_upload_wrp .img_upload_box .img_upload_box_oper{
            margin-top: -3px;
        }
        .xiaokuang{
            width: 126px;
            height: 102px;
            border: #07141E solid;
            margin-top: 4px;
        }


    </style>
<body>
<div id="wrapper">
    <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/leftmenu.tpl.php'; ?>
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/top.tpl.php'; ?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2>银行卡管理</h2>
                <ol class="breadcrumb">
                    <li>
                        <a>User</a>
                    </li>
                    <li>
                        <a>pay</a>
                    </li>
                    <li class="active">
                        <strong>银行卡信息</strong>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row wrapper page-heading iconList" >
            <div class="bankCardInfor">
                <h2>上传银行卡信息<span style="margin-left: 10px;color:#f00;font-size: 14px;">【<?php if(empty($bank)){echo '未设置';}elseif($bank['bank'] == 0){echo '审核中，预计需要1-3个工作日';}elseif($bank['bank']==2){echo '审核失败：'.$bank['bankmsg'];}else{echo '通过审核';} ?>】</span></h2>
                <form id="form1" method="post" enctype="multipart/form-data" action="merchants.php?m=User&c=settlement&a=addbank">
                    <h2>持卡人证件信息</h2>
                    <div>
                        <label><i>*</i>类型：</label>
                        <select name="isCompay">
                            <option value="0" <?php if(!empty($bank) && $bank['isCompay'] == "0"){echo 'selected="selected"';} ?>>个人</option>
                            <option value="1" <?php if(!empty($bank) && $bank['isCompay'] == "1"){echo 'selected="selected"';} ?>>公司</option>
                        </select>
                    </div>

                    <div id="zzlx">
                        <label><i>*</i>证件类型：</label>
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
                    </div>



                    <div>
                        <label id="yyzzhm"><i>*</i>证件号码：</label>
                        <input type="text" name="cerdId" value="<?php echo $bank['cerdId'];?>">
                    </div>
                    <div  id="Realestate" >

                        <p class="clearfix">注：只能上传jpg,png格式小于3M大小的图片</p>
                        <div  class="clearfix">
                            <div style="width: 100px; height:100px; margin-left:265px; margin-bottom: 10px; background-color: #f6f6f6;" class="sfz1img"></div>
                            <div style="float:left ;margin-left: 112px;" id="sfzzm">上传身份证正面图片:</div>
                            <div style="float:left ;">

                                <div id="js_upload_wrp">

                                    <div class="img_upload_wrp group">

                                        <div class="img_upload_box">
                                            <a class="img_upload_box_oper js_upload js_pic_url" id ='constructLeanID' href="javascript:">  上传文件</a>
                                        </div>
                                        <!--<div id="xiaokuang" style="width: 20px; height: 20px; border: #07141E;">
                                            aaa
                                        </div>-->
                                        <div class="js_pager">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="imgtest">
                            <span> 示例：</span>
                            <img width="110px" id="uploadimg1" height="70px" src="./Cashier/pigcms_static/image/model1.jpg"  id="image1"/>
                            <img width="110px" id="uploadimg2" height="70px" src="./Cashier/pigcms_static/image/model2.jpg"  id="image1"/>
                            <img width="110px" id="uploadimg3" height="70px" src="./Cashier/pigcms_static/image/model3.jpg"  id="image1"/>
                        </div>

                        <div class="clearfix" id="sfzfm">
                            <div style="width: 100px; height:100px; margin-left:265px; margin-bottom: 10px; background-color: #f6f6f6;" class="sfz2img"></div>
                            <label style="float:left ;margin-left: 112px;">上传身份证反面图片:</label>
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

                        <div class="clearfix" id="scsfzfm">
                            <div style="width: 100px; height:100px; margin-left:265px; margin-bottom: 10px; background-color: #f6f6f6;" class="sfz3img"></div>
                            <label style="float:left ;margin-left: 112px;">上传手持身份证图片:</label>
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
                    <div>
                        <label id="ckrxm"><i>*</i>持卡人姓名：</label>
                        <input type="text" name="customerName" value="<?php echo $bank['customerName'];?>">
                    </div>
                    <div id="ylsjh">
                        <label><i>*</i>银行预留手机号：</label>
                        <input type="text" name="phoneNo" value="<?php echo $bank['phoneNo'];?>" placeholder="选填">
                    </div>

                    <div id="khyh">
                        <label><i>*</i>开户银行：</label>
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
                    </div>
                    <div id="qshh">
                        <label>开户银行：</label>
                        <select name="settBankNo2">
                            <option value="102100099996">工商银行</option>
                            <option value="103100000026">农业银行</option>
                            <option value="104100000004">中国银行</option>
                            <option value="105100000017">建设银行</option>
                            <option value="301290000007">交通银行</option>
                            <option value="302100011000">中信银行</option>
                            <option value="303100000006">光大银行</option>
                            <option value="304100040000">华夏银行</option>
                            <option value="305100000013">民生银行</option>
                            <option value="306581000003">广发银行</option>
                            <option value="307584007998">平安银行</option>
                            <option value="308584000013">招商银行</option>
                            <option value="309391000011">兴业银行</option>
                            <option value="313100000013">北京银行</option>
                            <option value="325290000012">上海银行</option>
                            <option value="310290000013">上海浦东发展银行</option>
                            <option value="403100000004">中国邮政储蓄银行</option>
                        </select>
                        <i>暂时只支持以上银行</i>
                    </div>
                    <div>
                        <label><i>*</i>银行卡号：</label>
                        <input type="text" name="acctNo" value="<?php echo $bank['acctNo'];?>">

                    </div>
                    <div id="khhh">
                        <label>开户行号：</label>
                        <input type="text" name="accBankNo" value="<?php echo $bank['accBankNo'];?>">
                        <i>不知道可不填</i>

                    </div>

                    <div class="clearfix" id="Realestate" >
                        <div style="width: 100px; height:100px; margin-left:225px; margin-bottom: 10px; background-color: #f6f6f6;" class="sfz4img"></div>
                        <div class="clearfix">
                            <label style="float:left ;margin-left: 1%;" id="yhkzm">上传银行卡正面图片:</label>
                            <!--<span> 示例：
                                  <div id="imgtest">
                                      <img width="50px" height="35px" src="./Cashier/pigcms_static/image/model4.jpg"  id="image1"/>
                                      </div>

                              </span>-->
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
                        <div id="yhkfm">
                            <div style="width: 100px; height:100px; margin-left:150px; margin-bottom: 10px; background-color: #f6f6f6;" class="sfz5img"></div>
                            <div class="clearfix">

                                <label style="float:left ;margin-left: 1%;">上传银行卡背面图片:</label>
                                <!--<span> 示例：
                                      <div id="imgtest">
                                          <img width="50px" height="35px" src="./Cashier/pigcms_static/image/model5.jpg"  id="image1"/>
                                          </div>

                                  </span>-->
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
                    </div>

                    <p>
                        <!--<input type="submit" name="sub" value="提交" />-->
                        <button type="submit" class="btn">提交</button>
                    </p>
                </form>
            </div>
        </div>
    </div>


    <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/footer.tpl.php'; ?>
    <script src="<?php echo $this->RlStaticResource; ?>plugins/js/dropzone/dropzone.js"></script>
    <!-- iCheck -->
    <script src="<?php echo $this->RlStaticResource; ?>plugins/js/iCheck/icheck.min.js"></script>
    <!--start上传图片-->
    <script>


        $(".js_pic_url,.js_pic_url .icon20_common add_gray").dropzone({

            //url: "?m=Agent&c=merchant&a=uploadImg",
            url: "?m=User&c=settlement&a=uploadImg",
            addRemoveLinks: false,
            maxFilesize: 3,
            acceptedFiles: ".jpg,.png,jpeg",
            uploadMultiple: false,
            init: function() {
                this.on("success", function(file,responseText) {
                    var imgtype = this.previewsContainer.id;
                    var rept = $.parseJSON(responseText);
                    var imgHtml='<div style="width: 100px; height:100px; background-color: #d9dadc;"><img src="'+rept.fileUrl+'" height="100px" width="100px"><input name="'+imgtype+'List[]" class="imginput" type="hidden" value="'+rept.fileUrl+'"><p class="img_upload_edit_area js_edit_area"><a class="icon18_common del_gray js_delete" href="javascript:;" onclick="DelthisImg($(this));" ></a></p></div>';

//				//加
//				if (imgtype=='annuxes') {
//					imgHtml =$(this.element).parent().siblings().html() + imgHtml;
//				}

                    // $(this.element).parents(".sfz1img").siblings().html(imgHtml);
                    // 身份证正面图片显示
                    if(imgtype=='constructLeanID'){
                        $(".sfz1img").html(imgHtml);
                    }
                    // 身份证反面图片显示
                    if(imgtype=='constructLean'){
                        $(".sfz2img").html(imgHtml);
                    }
                    // 手持身份证图片显示
                    if(imgtype=='contact'){
                        $(".sfz3img").html(imgHtml);
                    }
                    // 银行卡正面图片显示
                    if(imgtype=='cunstructID'){
                        $(".sfz4img").html(imgHtml);
                    }
                    // 银行卡背面图片显示
                    if(imgtype=='landUseId'){
                        $(".sfz5img").html(imgHtml);
                    }
                });
            }
        });




    </script>

    <!--<script>


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
    </script>-->


    <!--end 7.10-->
    <script>

        $('.btn').click(function () {
            if( $(':input[name="customerName"]').val()==''){
                swal('账户名称不能为空!', "", 'error');
                return false;
            }else if( $(':input[name="cerdId"]').val()==''){
                swal('证件号码不能为空!', "", 'error');
                return false;

            }else if( $(':input[name="acctNo"]').val()==''){
                swal('银行卡号不能为空!', "", 'error');
                return false;
            }
        //          $.post('/merchants.php?m=User&c=settlement&a=bank',$('form').serialize(), function (e) {
        //              if (e.code == 1) {
        //                  swal({
        //                      title: "配置成功",
        //                      text: "",
        //                      type: "success"
        //                  }, function () {
        //                      window.location.reload();
        //                  });
        //              } else {
        //                  swal('配置失败', "", 'error');
        //              }
        //          }, 'json');
        //      });


    </script>

    <!--<script type="text/javascript" src="./Cashier/vendor/ueditor/third-party/jquery-1.10.2.min.js"></script> -->
    <!--<script language="javascript">
    $(function(){

    var size=3.0*$('#image1').width();
    $("#image1").mouseover(function(event) {
    var $target=$(event.target);
    if($target.is('img'))
    {
    $("<img id='tip' src='"+$target.attr("src")+"'>").css({
    "height":size,
    "width":size,
    }).appendTo($("#imgtest"));
    /*将当前所有匹配元素追加到指定元素内部的末尾位置。*/
    }
    }).mouseout(function() {
    $("#tip").remove();/*移除元素*/
    })
    })
    </script> -->
    <style type="text/css">
        #imgtest{  position:absolute;
            top:612px;
            left:700px;
            z-index:1; }
        table{    left:100px;
            font-size:20px; }
    </style>

    <script type="text/javascript">
        // 示例图片经过事件开始
        $("#uploadimg1").mouseover(function () {
            $("#uploadimg1").css({"width":"330","height":"210"});
        });
        $("#uploadimg1").mouseleave(function(){
            $("#uploadimg1").css({"width":"110","height":"70"});
        });
        $("#uploadimg2").mouseover(function () {
            $("#uploadimg2").css({"width":"330","height":"210"});
        });
        $("#uploadimg2").mouseleave(function(){
            $("#uploadimg2").css({"width":"110","height":"70"});
        });
        $("#uploadimg3").mouseover(function () {
            $("#uploadimg3").css({"width":"330","height":"210"});
        });
        $("#uploadimg3").mouseleave(function(){
            $("#uploadimg3").css({"width":"110","height":"70"});
        });
        // 示例图片经过事件结束
    </script>
    <script>
        $(function () {
            if($("select[name='isCompay']").val()==1){
                $("#zzlx").hide();
                $("#addzjlx").hide();
                $("#yyzzhm").html("<i>*</i>统一社会信用代码：");
                $("#addyyzzhm").html("<i>*</i>统一社会信用代码：");
                $("#addsfzzm").html(" 上传三证合一执照： ");
                $("#sfzzm").html(" 上传三证合一执照： ");
                $("#imgtest").hide();
                $("#addsfzfm").hide();
                $("#sfzfm").hide();
                $("#scsfzfm").hide();
                $("#addscsfzfm").hide();
                $("#addckrxm").html("公司名称：");
                $("#ckrxm").html("公司名称：");
                $("#addyhkzm").html("开户许可证：");
                $("#yhkzm").html("开户许可证：");
                $("#addyhkfm").hide();
                $("#yhkfm").hide();
                $("#ylsjh").hide();
                $("#addylsjh").hide();
                $("#addkhhh").show();
                $("#addqshh").show();
            }
            else{
                $("#zzlx").show();
                $("#addzjlx").show();
                $("#yyzzhm").html("<i>*</i>证件号码：");
                $("#addyyzzhm").html("<i>*</i>证件号码：");
                $("#addsfzzm").html("上传身份证正面图片： ");
                $("#sfzzm").html("上传身份证正面图片： ");
                $("#imgtest").show();
                $("#addsfzfm").show();
                $("#sfzfmfm").show();
                $("#scsfzfm").show();
                $("#addscsfz").show();
                $("#addckrxm").html("持卡人姓名：");
                $("#ckrxm").html("持卡人姓名：");
                $("#addyhkzm").html("上传银行卡正面图片：");
                $("#yhkzm").html("上传银行卡正面图片：");
                $("#addyhkfm").show();
                $("#yhkfm").show();
                $("#ylsjh").show();
                $("#addylsjh").show();
                $("#khhh").hide();
                $("#qshh").hide();
            }
        })
        $("select[name='isCompay']").change(function () {
            if($(this).val()==1){
                $("#zzlx").hide();
                $("#addzjlx").hide();
                $("#yyzzhm").html("<i>*</i>统一社会信用代码：");
                $("#addyyzzhm").html("<i>*</i>统一社会信用代码：");
                $("#addsfzzm").html(" 上传三证合一执照： ");
                $("#sfzzm").html(" 上传三证合一执照： ");
                $("#imgtest").hide();
                $("#addsfzfm").hide();
                $("#sfzfm").hide();
                $("#scsfzfm").hide();
                $("#addscsfzfm").hide();
                $("#addckrxm").html("公司名称：");
                $("#ckrxm").html("公司名称：");
                $("#addyhkzm").html("开户许可证：");
                $("#yhkzm").html("开户许可证：");
                $("#addyhkfm").hide();
                $("#yhkfm").hide();
                $("#ylsjh").hide();
                $("#addylsjh").hide();
                $("#addkhhh").show();
                $("#addqshh").show();
                $("#khhh").show();
                $("#qshh").show();
                $("#khyh").hide();
            }
            else{
                $("#zzlx").show();
                $("#addzjlx").show();
                $("#yyzzhm").html("<i>*</i>证件号码：");
                $("#addyyzzhm").html("<i>*</i>证件号码：");
                $("#addsfzzm").html("上传身份证正面图片： ");
                $("#sfzzm").html("上传身份证正面图片： ");
                $("#imgtest").show();
                $("#addsfzfm").show();
                $("#sfzfmfm").show();
                $("#scsfzfm").show();
                $("#addscsfzfm").show();
                $("#addckrxm").html("持卡人姓名：");
                $("#ckrxm").html("持卡人姓名：");
                $("#addyhkzm").html("上传银行卡正面图片：");
                $("#yhkzm").html("上传银行卡正面图片：");
                $("#addyhkfm").show();
                $("#yhkfm").show();
                $("#ylsjh").show();
                $("#addylsjh").show();
                $("#addkhhh").hide();
                $("#addqshh").hide();
                $("#khhh").hide();
                $("#qshh").hide();
                $("#khyh").show();
            }
        })
    </script>
</body>
</html>