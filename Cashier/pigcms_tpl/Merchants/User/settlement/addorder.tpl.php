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

.radioddd{width:20px;}
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
                <h2>请填写提现信息<span style="margin-left: 10px;color:#f00;font-size: 14px;"></span></h2>
                <form id="form1" method="post" enctype="multipart/form-data" action="merchants.php?m=User&c=settlement&a=addorder">
                   
                 
                    <div>
                        <label id="ckrxm"><i>*</i>持卡人姓名：</label>
                        <input type="text" name="acct_name" value="" placeholder="必填">
                    </div>
                    <div id="ylsjh">
                        <label><i>*</i>银行预留手机号：</label>
                        <input type="text" name="mobile" value="" placeholder="必填" >
                    </div>

                    <div id="khyh">
                        <label><i>*</i>提现金额：</label>
                        <input type="text" name="amount" value="" placeholder="必填">
                    </div>
                    <div>
                        <label><i>*</i>银行卡号：</label>
                        <input type="text" name="acct_id" value="" placeholder="必填">
                    </div>
                    <div>
                        <label>是否是对公账户</label>否<input type='radio' class='radioddd' name='bank_settle_no' checked id='one' value='0'>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是<input type='radio' class='radioddd' name='bank_settle_no' id='two'>
                    </div>
                    <div id='isornot' style='display:none'>
                        <label>开户行号：</label>
                        <input type="text"  id='bbq'  value="" placeholder='必填'>
                        
                    </div>
                    <p>
                        <!--<input type="submit" name="sub" value="提交" />-->
                        <button type="submit" class="btn" id='sub'>提交</button>
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
    
$('#two').click(function(){
	$('#isornot').show();
})
$('#one').click(function(){
	$('#isornot').hide();
})
     $('#sub').click(function(){
	$('#two').val($('#bbq').val());
         })
    </script>
</body>
</html>