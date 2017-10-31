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
     <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="//res.layui.com/layui/dist/css/layui.css"  media="all">
    
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

        <form class="layui-form" action="">
  <div class="layui-form-item">
    <label class="layui-form-label">单行输入框</label>
    <div class="layui-input-block">
      <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
    </div>
  </div>
</form>
        
                <form id="form1" method="post" enctype="multipart/form-data" action="merchants.php?m=User&c=settlement&a=addbank2">
                   
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
                   
                    <p>
                        <!--<input type="submit" name="sub" value="提交" />-->
                        <button type="submit" class="btn">提交</button>
                    </p>
                </form>
            </div>
        </div>
    </div>


   
</body>
</html>


















































<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="//res.layui.com/layui/dist/css/layui.css"  media="all">
  <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
          
<blockquote class="layui-elem-quote layui-text">
  鉴于小伙伴的普遍反馈，先温馨提醒两个常见“问题”：1. <a href="/doc/base/faq.html#form" target="_blank">为什么select/checkbox/radio没显示？</a> 2. <a href="/doc/modules/form.html#render" target="_blank">动态添加的表单元素如何更新？</a>
</blockquote>
              
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend>表单集合演示</legend>
</fieldset>
 
<form class="layui-form" action="">
  <div class="layui-form-item">
    <label class="layui-form-label">单行输入框</label>
    <div class="layui-input-block">
      <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">验证必填项</label>
    <div class="layui-input-block">
      <input type="text" name="username" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
    </div>
  </div>
  
  <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">验证手机</label>
      <div class="layui-input-inline">
        <input type="tel" name="phone" lay-verify="phone" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-inline">
      <label class="layui-form-label">验证邮箱</label>
      <div class="layui-input-inline">
        <input type="text" name="email" lay-verify="email" autocomplete="off" class="layui-input">
      </div>
    </div>
  </div>
  
  <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">多规则验证</label>
      <div class="layui-input-inline">
        <input type="text" name="number" lay-verify="required|number" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-inline">
      <label class="layui-form-label">验证日期</label>
      <div class="layui-input-inline">
        <input type="text" name="date" id="date" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-inline">
      <label class="layui-form-label">验证链接</label>
      <div class="layui-input-inline">
        <input type="tel" name="url" lay-verify="url" autocomplete="off" class="layui-input">
      </div>
    </div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">验证身份证</label>
    <div class="layui-input-block">
      <input type="text" name="identity" lay-verify="identity" placeholder="" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">自定义验证</label>
    <div class="layui-input-inline">
      <input type="password" name="password" lay-verify="pass" placeholder="请输入密码" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">请填写6到12位密码</div>
  </div>
  
  <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">范围</label>
      <div class="layui-input-inline" style="width: 100px;">
        <input type="text" name="price_min" placeholder="￥" autocomplete="off" class="layui-input">
      </div>
      <div class="layui-form-mid">-</div>
      <div class="layui-input-inline" style="width: 100px;">
        <input type="text" name="price_max" placeholder="￥" autocomplete="off" class="layui-input">
      </div>
    </div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">单行选择框</label>
    <div class="layui-input-block">
      <select name="interest" lay-filter="aihao">
        <option value=""></option>
        <option value="0">写作</option>
        <option value="1" selected="">阅读</option>
        <option value="2">游戏</option>
        <option value="3">音乐</option>
        <option value="4">旅行</option>
      </select>
    </div>
  </div>
  
  
  <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">分组选择框</label>
      <div class="layui-input-inline">
        <select name="quiz">
          <option value="">请选择问题</option>
          <optgroup label="城市记忆">
            <option value="你工作的第一个城市">你工作的第一个城市</option>
          </optgroup>
          <optgroup label="学生时代">
            <option value="你的工号">你的工号</option>
            <option value="你最喜欢的老师">你最喜欢的老师</option>
          </optgroup>
        </select>
      </div>
    </div>
    <div class="layui-inline">
      <label class="layui-form-label">搜索选择框</label>
      <div class="layui-input-inline">
        <select name="modules" lay-verify="required" lay-search="">
          <option value="">直接选择或搜索选择</option>
          <option value="1">layer</option>
          <option value="2">form</option>
          <option value="3">layim</option>
          <option value="4">element</option>
          <option value="5">laytpl</option>
          <option value="6">upload</option>
          <option value="7">laydate</option>
          <option value="8">laypage</option>
          <option value="9">flow</option>
          <option value="10">util</option>
          <option value="11">code</option>
          <option value="12">tree</option>
          <option value="13">layedit</option>
          <option value="14">nav</option>
          <option value="15">tab</option>
          <option value="16">table</option>
          <option value="17">select</option>
          <option value="18">checkbox</option>
          <option value="19">switch</option>
          <option value="20">radio</option>
        </select>
      </div>
    </div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">联动选择框</label>
    <div class="layui-input-inline">
      <select name="quiz1">
        <option value="">请选择省</option>
        <option value="浙江" selected="">浙江省</option>
        <option value="你的工号">江西省</option>
        <option value="你最喜欢的老师">福建省</option>
      </select>
    </div>
    <div class="layui-input-inline">
      <select name="quiz2">
        <option value="">请选择市</option>
        <option value="杭州">杭州</option>
        <option value="宁波" disabled="">宁波</option>
        <option value="温州">温州</option>
        <option value="温州">台州</option>
        <option value="温州">绍兴</option>
      </select>
    </div>
    <div class="layui-input-inline">
      <select name="quiz3">
        <option value="">请选择县/区</option>
        <option value="西湖区">西湖区</option>
        <option value="余杭区">余杭区</option>
        <option value="拱墅区">临安市</option>
      </select>
    </div>
    <div class="layui-form-mid layui-word-aux">此处只是演示联动排版，并未做联动交互</div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">复选框</label>
    <div class="layui-input-block">
      <input type="checkbox" name="like[write]" title="写作">
      <input type="checkbox" name="like[read]" title="阅读" checked="">
      <input type="checkbox" name="like[game]" title="游戏">
    </div>
  </div>
  
  <div class="layui-form-item" pane="">
    <label class="layui-form-label">原始复选框</label>
    <div class="layui-input-block">
      <input type="checkbox" name="like1[write]" lay-skin="primary" title="写作" checked="">
      <input type="checkbox" name="like1[read]" lay-skin="primary" title="阅读">
      <input type="checkbox" name="like1[game]" lay-skin="primary" title="游戏" disabled="">
    </div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">开关-默认关</label>
    <div class="layui-input-block">
      <input type="checkbox" name="close" lay-skin="switch" lay-text="ON|OFF">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">开关-默认开</label>
    <div class="layui-input-block">
      <input type="checkbox" checked="" name="open" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">单选框</label>
    <div class="layui-input-block">
      <input type="radio" name="sex" value="男" title="男" checked="">
      <input type="radio" name="sex" value="女" title="女">
      <input type="radio" name="sex" value="禁" title="禁用" disabled="">
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">普通文本域</label>
    <div class="layui-input-block">
      <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">编辑器</label>
    <div class="layui-input-block">
      <textarea class="layui-textarea layui-hide" name="content" lay-verify="content" id="LAY_demo_editor"></textarea>
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
 
<!-- 示例-970 -->
<ins class="adsbygoogle" style="display:inline-block;width:970px;height:90px" data-ad-client="ca-pub-6111334333458862" data-ad-slot="3820120620"></ins>
  
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
  <legend>方框风格的表单集合</legend>
</fieldset>
<form class="layui-form layui-form-pane" action="">
  <div class="layui-form-item">
    <label class="layui-form-label">长输入框</label>
    <div class="layui-input-block">
      <input type="text" name="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">短输入框</label>
    <div class="layui-input-inline">
      <input type="text" name="username" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
    </div>
  </div>
  
  <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">日期选择</label>
      <div class="layui-input-block">
        <input type="text" name="date" id="date1" autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-inline">
      <label class="layui-form-label">行内表单</label>
      <div class="layui-input-inline">
        <input type="text" name="number" autocomplete="off" class="layui-input">
      </div>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">密码</label>
    <div class="layui-input-inline">
      <input type="password" name="password" placeholder="请输入密码" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">请务必填写用户名</div>
  </div>
  
  <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">范围</label>
      <div class="layui-input-inline" style="width: 100px;">
        <input type="text" name="price_min" placeholder="￥" autocomplete="off" class="layui-input">
      </div>
      <div class="layui-form-mid">-</div>
      <div class="layui-input-inline" style="width: 100px;">
        <input type="text" name="price_max" placeholder="￥" autocomplete="off" class="layui-input">
      </div>
    </div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">单行选择框</label>
    <div class="layui-input-block">
      <select name="interest" lay-filter="aihao">
        <option value=""></option>
        <option value="0">写作</option>
        <option value="1" selected="">阅读</option>
        <option value="2">游戏</option>
        <option value="3">音乐</option>
        <option value="4">旅行</option>
      </select>
    </div>
  </div>
  
  <div class="layui-form-item">
    <label class="layui-form-label">行内选择框</label>
    <div class="layui-input-inline">
      <select name="quiz1">
        <option value="">请选择省</option>
        <option value="浙江" selected="">浙江省</option>
        <option value="你的工号">江西省</option>
        <option value="你最喜欢的老师">福建省</option>
      </select>
    </div>
    <div class="layui-input-inline">
      <select name="quiz2">
        <option value="">请选择市</option>
        <option value="杭州">杭州</option>
        <option value="宁波" disabled="">宁波</option>
        <option value="温州">温州</option>
        <option value="温州">台州</option>
        <option value="温州">绍兴</option>
      </select>
    </div>
    <div class="layui-input-inline">
      <select name="quiz3">
        <option value="">请选择县/区</option>
        <option value="西湖区">西湖区</option>
        <option value="余杭区">余杭区</option>
        <option value="拱墅区">临安市</option>
      </select>
    </div>
  </div>
  <div class="layui-form-item" pane="">
    <label class="layui-form-label">开关-开</label>
    <div class="layui-input-block">
      <input type="checkbox" checked="" name="open" lay-skin="switch" lay-filter="switchTest" title="开关">
    </div>
  </div>
  <div class="layui-form-item" pane="">
    <label class="layui-form-label">单选框</label>
    <div class="layui-input-block">
      <input type="radio" name="sex" value="男" title="男" checked="">
      <input type="radio" name="sex" value="女" title="女">
      <input type="radio" name="sex" value="禁" title="禁用" disabled="">
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">文本域</label>
    <div class="layui-input-block">
      <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
    </div>
  </div>
  <div class="layui-form-item">
    <button class="layui-btn" lay-submit="" lay-filter="demo2">跳转式提交</button>
  </div>
</form>
          
<script src="//res.layui.com/layui/dist/layui.js" charset="utf-8"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
layui.use(['form', 'layedit', 'laydate'], function(){
  var form = layui.form
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  
  //日期
  laydate.render({
    elem: '#date'
  });
  laydate.render({
    elem: '#date1'
  });
  
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 5){
        return '标题至少得5个字符啊';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });
  
  //监听指定开关
  form.on('switch(switchTest)', function(data){
    layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
      offset: '6px'
    });
    layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
  });
  
  //监听提交
  form.on('submit(demo1)', function(data){
    layer.alert(JSON.stringify(data.field), {
      title: '最终的提交信息'
    })
    return false;
  });
  
  
});
</script>

</body>
</html>