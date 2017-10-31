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
                <h2>上传银行卡信息<span style="margin-left: 10px;color:#f00;font-size: 14px;"></span></h2>
                <button class="btn btn-primary" style="margin-left: 20px; margin-bottom: 20px;" id="add_bankcard"><i class="fa fa-plus"></i> 添加银行卡</button>
                <table class="ui-table ui-table-list" data-page-size="20" style="padding: 0px;">
                    <thead class="js-list-header-region tableFloatingHeaderOriginal">
                    <tr class="widget-list-header">
                        <th>开户名</th>
                        <th>开户银行</th>
                        <th>银行卡号</th>
                        <th>审核状态</th>
                        <th>结算默认银行卡</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody class="js-list-body-region" id="table-list-body">
                    <?php foreach ($banklist as $vo) { ?>
                        <tr class="widget-list-item">
                            <td><?php echo $vo['customerName'] ?></td>
                            <td>
                                <?php
                                    if($vo['isCompay']==0){
                                    switch($vo['settBankNo']){
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
                                            echo "其他银行";
                                            break;
                                    }
                                    }
                                    else{
                                        switch($vo['settBankNo2']){
                                            case "102100099996":
                                                echo '工商银行';
                                                break;
                                            case "103100000026":
                                                echo '农业银行';
                                                break;
                                            case "104100000004":
                                                echo '中国银行';
                                                break;
                                            case "105100000017":
                                                echo '建设银行';
                                                break;
                                            case "308584000013":
                                                echo '招商银行';
                                                break;
                                            case "301290000007":
                                                echo '交通银行';
                                                break;
                                            case "305100000013":
                                                echo '民生银行';
                                                break;
                                            case "302100011000":
                                                echo '中信银行';
                                                break;
                                            case "303100000006":
                                                echo '光大银行';
                                                break;
                                            case "309391000011":
                                                echo '兴业银行';
                                                break;
                                            case "313100000013":
                                                echo '北京银行';
                                                break;
                                            case "306581000003":
                                                echo '广发银行';
                                                break;
                                            case "304100040000":
                                                echo '华夏银行';
                                                break;
                                            case "307584007998":
                                                echo '平安银行';
                                                break;
                                            case "325290000012":
                                                echo '上海银行';
                                                break;
                                            case "310290000013":
                                                echo '浦发银行';
                                                break;
                                            case "403100000004":
                                                echo '邮储银行';
                                                break;
                                        }
                                    }
                                ?>
                                </td>
                            <td><?php echo $vo['acctNo'] ?></td>
                            <td><?php if($vo['bank']==0) echo '未审核'; else echo '已通过审核'?></td>
                            <td><?php if($vo['adefalut']==1) echo "<lable style='color:darkgreen; font-size: 20px;;'>√</lable>";?></td>
                            <td>
                                <a class="btn btn-sm btn-info" href="/merchants.php?m=User&c=settlement&a=bank&id=<?php echo $vo['id'] ?>" style="vertical-align: top; background: #36a9e0;">查看 </a>
                                <a class="btn btn-sm btn-info adefalut" data-id="<?php echo $vo['id'] ?>" href="" style="vertical-align: top; background: #36a9e0;">设为默认</a>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>

    <?php include RL_PIGCMS_TPL_PATH . APP_NAME . '/' . ROUTE_MODEL . '/public/footer.tpl.php'; ?>
                <script>
                    $("#add_bankcard").click(function () {
                        window.location.href="/merchants.php?m=User&c=settlement&a=addbank";
                    });
                    $(".adefalut").click(function () {
                        var id= $(this).data('id');
                        $.ajax({
                            url:"/merchants.php?m=User&c=settlement&a=defalutBankCard",
                            type:"post",
                            data:{
                                id:id
                            },
                            success:function (re) {
                                window.location.reload();
                            }
                        })
                    })
                </script>
</body>
</html>