
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>代理商|商户设置</title>
  <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>


    <!-- FooTable -->
    <link href="<?php echo  RL_PIGCMS_STATIC_PATH;?>plugins/css/footable/footable.core.css" rel="stylesheet">
  <link href="<?php echo $this->RlStaticResource;?>plugins/css/iCheck/custom.css" rel="stylesheet">
  <style>
  label i {color:#f00;margin-right: 10px; font-style: normal;}
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

  .tit_h4{ height: 40px; line-height: 40px; padding: 0 20px; width: 100%;margin:0px !important;}
  .tit_h4 span{ color: #676a6c; font-weight: normal;}
  .tit_h4 a{ color: #44b549; font-weight: normal;}
  .jbxi_bg>div{border-top: 1px solid #f2f2f2; padding: 20px 0; margin: 0px !important;float: left; width: 100%;}
  .jbxi_bg>div>label{ width: 100px; text-align: right; float: left; margin-right: 30px;}
  .jbxi_bg>div>div>label{padding-top: 5px;}
  .jbxi_bg>div>div>input{border: none;}
  .form-control{
    width: 80%;
}
.footable-odd {
    background-color: #ffffff;
}
.bc{position: absolute; bottom: -55px; left: 50%; width: 70px; height: 30px; margin-left: -35px; background: #4EBE53; border-radius: 5px; border: none; color: #FFFFFF;}
.shangjia_tit{border-bottom:2px solid #f2f2f2 ; margin-bottom: 0px; padding-left: 20px; background: #FFFFFF; width: 100%; height: 50px; line-height: 50px; text-align: left; border-top:3px solid #d9e6e9 ;font-size: 18px;}
.form-control{display: inline-block;}
  </style>
}
</head>

<body>

    <div id="wrapper">
  <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL. '/public/leftmenu.tpl.php';?>

        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>商户列表</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Agent</a>
                        </li>
                        <li>
                            <a>代理中心</a>
                        </li>
                        <li>
                            <a>代理列表</a>
                        </li>
                        <li class="active">
                            <strong>修改商户</strong>
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
                      <!--
                          作者：2721190987@qq.com
                          时间：2016-10-20
                          描述：基本信息
                        -->
                        <p class="shangjia_tit">编辑商户</p>
                      <div class="ibox-content" style="border-top:none;">
                        
                          <div class="panel-body" style="padding: 0px; ">
                              <form class="form-horizontal form-border jbxi_bg clearfix" style="display:none;width: 95%; margin: 0 auto 60px; position: relative; border: 1px solid #EEEEEE;" action="?m=Agent&c=merchant&a=createMerchant" method="post">
                                  <div class="form-group clearfix">
                                      <label class=" control-label"><i>*</i>商户类型</label>
                                      <div>
                                          <!--<select name="mtype" id="mtype" style="margin-top: 5px;">
                                              <option value=''>请选择商户类型</option>
                                              <option value='1'>特约商户</option>
                                              <option value='2'>银行直连</option>
                                          </select>-->
                                      </div>
                                  </div>
                                  <div class="form-group clearfix">
                                      <label class=" control-label"><i>*</i>商户名</label>
                                      <div>
                                          <input type="text" class="form-control" value="<?php echo $merchant['company']; ?>" placeholder="请输入公司全称" name='company'>
                                      </div>
                                  </div>
                                  <div class="form-group clearfix">
                                      <label class=" control-label"><i>*</i>登录账号</label>
                                      <div>
                                          <input type="text" class="form-control" value="<?php echo $merchant['username']; ?>" placeholder="建议使用邮箱账号" name='username'>
                                      </div>
                                  </div>
                                  <div class="form-group clearfix">
                                      <?php if(!empty($merchant['mid'])) { ?>
                                          <?php echo '<label class=" control-label">修改密码</label><input type="checkbox" id="xuanzhe2" style="margin-top: 13px;" name="changePwd" />' ?>
                                      <?php } ?>

                                      <div class="mima" style="display: none; margin-left: 50px;">
                                          <label><i>*</i>新密码<input type="password" placeholder="输入新密码" name='password' style="height: 30px; width: 150px; margin-left: 10px;border: none"></label><br />
                                          <label><i>*</i>新密码<input type="password" placeholder="输入新密码" name='password2' style="height: 30px; width: 150px; margin-left: 10px;border: none"></label>
                                      </div>
                                  </div>
                                  <div class="form-group clearfix rebateAclear" style="display:none">
                                      <label class=" control-label"><i>*</i>微信费率</label>
                                      <select name="commission">
                                          <?php foreach ($cashier_wxrebate_wx as $v){?>
                                              <option value="<?php echo $v; ?>" ><?php echo $v;?> %</option>
                                          <?php }?>
                                      </select>
                                  </div>
                                  <div class="form-group clearfix rebateAclear" style="display:none">
                                      <label class=" control-label"><i>*</i>支付宝费率</label>
                                      <select name="alicommission">
                                          <?php foreach ($cashier_wxrebate_ali as $v){?>

                                              <option value="<?php echo $v; ?>" ><?php echo $v;?> %</option>
                                          <?php }?>
                                      </select>
                                  </div>
                                  <div class="form-group clearfix rebateAn" style="display:none">
                                      <label class=" control-label"><i>*</i>子商户费率</label>
                                      <select name="commission_an">
                                          <?php foreach ($cashier_wxrebate_an as $v){?>

                                              <option value="<?php echo $v; ?>" ><?php echo $v;?> %</option>
                                          <?php }?>
                                      </select>
                                  </div>
                                  <div class="form-group clearfix">
                                      <label class=" control-label"><i>*</i>联系人</label>
                                      <div>
                                          <input type="text" class="form-control" value="<?php echo $merchant['username']; ?>" placeholder="联系人" name='realname'>
                                      </div>
                                  </div>
                                  <div class="form-group clearfix">
                                      <label class=" control-label"><i>*</i>联系电话</label>
                                      <div>
                                          <label><input type="text"  placeholder="" value="<?php echo $merchant['username']; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')" name="phone"></label>

                                          <label><i>*</i>座机号码
                                              <input type="text" placeholder="023" style="width: 60px; text-align: center; height24px" value="023" onkeyup="this.value=this.value.replace(/\D/g,'')" name='telPrefix'>
                                              <input type="text" height="30" onkeyup="this.value=this.value.replace(/\D/g,'')" style="margin-left: 10px;" name='tel'>
                                          </label>
                                      </div>
                                  </div>
                                  <!-- 3级联动 -->
                                  <div class="frm_control_row clearfix">
                                      <label class=" control-label"><i>*</i>地址</label>
                                      <div class="frm_controls menu_controls" style="margin-right:10px;">
                                          <select id="provinceS" onchange="GetCity();"  style="float: left; height: 30px" name="province">
                                              <option value="0">请选择</option>
                                              <?php foreach($districts as $akk=>$avv){?>
                                                  <option value="<?php echo $avv['id']?>" data-fullname="<?php echo $avv['fullname']?>" data-lng="<?php echo $avv['lng']?>" data-lat="<?php echo $avv['lat']?>"><?php echo $avv['fullname']?></option>
                                              <?php }?>
                                          </select>



                                          <div class="search_c" style="float: left;margin-left:10px">
                                              <input autocomplete="off" type="text" placeholder="输入详细地址" name='detailAddress' style="height: 30px ;width:300px;">
                                          </div>

                                          <input name="provinceinfo" id="provinceinfo" type="hidden" value=""/>
                                          <input name="cityinfo" id="cityinfo" type="hidden"  value=""/>
                                          <input name="districtinfo" id="districtinfo" type="hidden"  value=""/>
                                      </div>
                                  </div>
                                  <!-- 3级联动 -->
                                  <div class="form-group clearfix">
                                      <label class="control-label"><i>*</i>分配</label>
                                      <div>
                                          <label>业务员：
                                              <select name="saler">
                                                  <option value='0'>请选择业务员</option>
                                                  <?php foreach ($salers as $k=>$v):?>
                                                      <option value="<?php echo $v['id'] ?>" ><?php echo $v['username']; ?></option>
                                                  <?php endforeach ?>
                                              </select>
                                          </label>
                                      </div>
                                  </div>

                                  <div class="form-group clearfix" style="display:none">
                                      <label class="control-label"><i>*</i>是否为子商户</label>
                                      <div>
                                          是：<input type='radio' name='sub_merchant' value='1'/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          否：<input type='radio' name='sub_merchant' value='0' checked="checked"/>
                                      </div>
                                  </div>
                                  <button class="bc">提交</button>
                              </form>

                              <form class="form-horizontal form-border jbxi_bg clearfix" style="width: 95%; margin: 0 auto 60px; position: relative; border: 1px solid #EEEEEE;" action="?m=Agent&c=merchant&a=createMerchant" method="post">
                                     <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>商户类型</label>
                                        <div>
                                            <select name="mtype" id="mtype" style="margin-top: 5px;">
                                                <option value='1' <?php if($merchant['mtype']==1){echo 'selected="selected"';}?>>特约商户</option>
                                                <option value='2' <?php if($merchant['mtype']==2){echo 'selected="selected"';}?>>银行直连</option>
                                                <option value='3' <?php if($merchant['mtype']==3){echo 'selected="selected"';}?>>金海哲（支付）</option>
                                            </select>
<!--                                            <input type="text" value="--><?php //if($merchant['mtype']==1){echo '特约商户';}else{echo '银行直连';} ?><!--" class="form-control" readonly>-->

                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>商户名</label>
                                        <div>
                                            <input type="text" class="form-control" placeholder="请输入公司全称" name='company' value='<?php echo $merchant['company']; ?>'>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>登录账号</label>
                                        <div>
                                            <input type="text" class="form-control" placeholder="建议使用邮箱账号" name='username' value='<?php echo $merchant['username']; ?>' >
                                        </div>
                                    </div>

            
                                    <div class="form-group clearfix">
                                        <?php if(!empty($merchant['mid'])) { ?>
                                        <?php echo '<label class=" control-label">修改密码</label><input type="checkbox" id="xuanzhe" style="margin-top: 13px;" name="changePwd" />' ?>
                                        <?php } ?>
                                       
                                        <div class="mima" style="display: none; margin-left: 50px;">
                                            <label><i>*</i>新密码<input type="password" placeholder="输入新密码" name='password' style="height: 30px; width: 150px; margin-left: 10px;border: none"></label><br />
                                            <label><i>*</i>新密码<input type="password" placeholder="输入新密码" name='password2' style="height: 30px; width: 150px; margin-left: 10px;border: none"></label>
                                        </div>
                                    </div>
                                    <script>
                                    $("#xuanzhe").click(function(){
                                    if($(this).is(':checked')){
                                    $(".mima").show();
                                    }else{
                                    $(".mima").hide();
                                    }
                                    })
                                    </script>
                                    <div class="form-group clearfix rebateAclear" style="<?php if($merchant['mtype']==2){echo 'display:none';}?>">
                                        <label class=" control-label"><i>*</i>微信费率</label>
                                        <select name="commission">
                                            <?php foreach ($cashier_wxrebate_wx as $v){?>
                                                <option value="<?php echo $v; ?>" <?php if($merchant['commission'] == $v){echo 'selected="selected"';}?>><?php echo $v;?> %</option>
                                            <?php }?>    
                                        </select>
                                    </div>
                                  <div class="form-group clearfix rebateAclear" style="<?php if($merchant['mtype']==2){echo 'display:none';}?>">
                                        <label class=" control-label"><i>*</i>支付宝费率</label>
                                        <select name="alicommission">
                                            <?php foreach ($cashier_wxrebate_ali as $v){?>
                                                <option value="<?php echo $v; ?>" <?php if($merchant['alicommission'] == $v){echo 'selected="selected"';}?>><?php echo $v;?> %</option>
                                            <?php }?>    
                                        </select>
                                    </div>

                                      <div class="form-group clearfix rebateAn" style="<?php if($merchant['mtype']==1){echo 'display:none';}?>">
                                          <label class=" control-label"><i>*</i>子商户费率</label>
                                          <select name="commission_an">
                                              <?php foreach ($cashier_wxrebate_an as $v){?>
                                                  <option value="<?php echo $v; ?>" <?php if($merchant['commission'] == $v){echo 'selected="selected"';}?>><?php echo $v;?> %</option>
                                              <?php }?>
                                          </select>
                                      </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>联系人</label>
                                        <div>
                                           <input type="text" class="form-control" placeholder="联系人" name='realname' value='<?php echo $merchant['realname']; ?>' />
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class=" control-label"><i>*</i>联系电话</label>
                                        <div>
                                            <label>手机号码<input type="text" name="phone" value="<?php echo $merchant['phone']; ?>" ></label>

                                             <label><i>*</i>座机号码
                                              <input type="text" placeholder="023" style="width: 60px; text-align: center; height:30px" value="<?php echo $merchant['telPrefix']; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')" name='telPrefix'>
                                              <input type="text" height="30" onkeyup="this.value=this.value.replace(/\D/g,'')" style="margin-left: 10px;" name='tel' value='<?php echo $merchant['tel']; ?>'>
                                            </label>
                                        </div>
                                    </div>
                                <!-- 3级联动 -->
                                     <div class="frm_control_row clearfix"> 
                                      <label class=" control-label"><i>*</i>地址</label>
                                      <div class="frm_controls menu_controls" style="margin-right:10px;"> 
                                      <select id="provinceS"onchange="GetCity();"  style="float: left; height: 30px" name="province">
                                      <option value="0">请选择</option>
                                          <?php foreach($districts as $akk=>$avv){?>
                                               
                                              <option value="<?php echo $avv['id']?>" data-fullname="<?php echo $avv['fullname']?>" <?php if($merchants_data['province'] && $merchants_data['province'] == $avv['id']){echo 'selected = "selected"';}?> ><?php echo $avv['fullname']?></option>
                               
                                          <?php }?>
                                       </select>
                                   <?php if($merchants_data['city']){?>    
                                         
                                       <select name="city" id="cityS" style="width:126px;float: left;margin-left:10px;height: 30px" onchange="GetDistrict();">
                                            <?php foreach ($districts_city as $k => $v){?>
                                                <option value="<?php echo $v['id']?>" data-fullname="<?php echo $v['fullname']?>" <?php if($merchants_data['city'] && $merchants_data['city'] == $v['id']){echo 'selected = "selected"';}?> ><?php echo $v['fullname'];?></option>
                                            <?php }?>    
                                       </select>
                                           
                                   <?php }?>
                                   <?php if($merchants_data['area']){?>      
                                       <select name="area" id="districtS" style="width:126px;float: left; height: 30px;margin-left:10px" onchange="GetCircle();">
                                            <?php foreach ($districts_area as $key => $val){?>
                                                <option value="<?php echo $val['id']?>" data-fullname="<?php echo $val['fullname']?>" <?php if($merchants_data['area'] && $merchants_data['area'] == $val['id']){echo 'selected = "selected"';}?> ><?php echo $val['fullname'];?></option>
                                            <?php } ?>
                                       </select>
                                       
                                    <?php }?>    
                                        
                                        <div class="search_c" style="float: left;margin-left:10px">
                                        <input autocomplete="off" type="text" placeholder="输入详细地址" name='detailAddress' style="height: 30px ;width:300px;" value="<?php if($merchants_data['address']){echo $merchants_data["address"];}?>">
                                        </div>

                                       <input name="provinceinfo" id="provinceinfo" type="hidden" value="<?php echo $merchant['fullprovice'] ?>"/>
                                       <input name="cityinfo" id="cityinfo" type="hidden"  value="<?php echo $merchant['fullcity'] ?>"/> 
                                       <input name="districtinfo" id="districtinfo" type="hidden"  value="<?php echo $merchant['fullarea'] ?>"/> 
                                   <?php if($mid){?>
                                        <input name="mid"  type="hidden"  value="<?php echo $mid;?>"/> 
                                   <?php }?>
                                    </div>
                                    </div>
                                  <!-- 3级联动 -->

                                    <div class="form-group clearfix">
                                        <label class="control-label"><i>*</i>分配</label>
                                        <div>
                                          <label>业务员：
                                            <select name="saler">
                                            <option value="0">请选择业务员</option>
                                            <?php foreach ($salers as $k=>$v):?>

                                            <option value="<?php echo $v['id'] ?>" <?php if($v['id']==$merchant['sid']){echo 'selected';} ?> ><?php echo $v['username']; ?></option>
                                            <?php endforeach ?>
                                            </select>
                                          </label>
                                        </div>
                                    </div>

                                  <div class="form-group clearfix" style="<?php if($merchant['mtype']==1){echo 'display:none';} ?>" id="subMerch">
                                      <label class="control-label"><i>*</i>是否为子商户</label>
                                      <div>
                                          是：<input type='radio' name='sub_merchant' value='1' <?php if($merchant['sub_merchant'] == 1){echo 'checked="checked"';} ?>/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                          否：<input type='radio' name='sub_merchant' value='0' <?php if($merchant['sub_merchant'] == 0){echo 'checked="checked"';} ?>/>
                                      </div>
                                  </div>
                                    <input type="hidden" name="mid" value="<?php echo $merchant['mid'] ?>">
                                    <button class="bc">提交</button>
                                </form>


                            </div>
                      </div>
                      <!--
                          作者：2721190987@qq.com
                          时间：2016-10-20
                          描述：end
                        -->
                




                    </div>
                </div>
            </div>
        </div>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
     </div>
    </div>
   
  
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

    <!-- Page-Level Scripts -->
    <script>



  function GetCity(){

   var obj= $('#provinceS');
  var provinceid=obj.val();
   var provincename=obj.find("option:selected").data('fullname');
   $('#provinceinfo').val(provincename);

   var cityHtml='&nbsp;&nbsp;&nbsp;<select name="city" id="cityS" style="width:126px;float: left;margin-left:10px;height: 30px" onchange="GetDistrict();"><option value="0">请选择</option>'
   $.post('?m=Agent&c=merchant&a=GetDistrict',{districtid:provinceid},function(ret){
    console.log();
     if(ret.data){
        $.each(ret.data,function(nn,vv){
         cityHtml+='<option value="'+vv.id+'" data-fullname="'+vv.fullname+'" data-lng="'+vv.lng+'" data-lat="'+vv.lat+'" >'+vv.fullname+'</option>';
      });
      cityHtml+='</select>';
      $('#cityS').remove();
      $('#districtS').remove();
      $('#circleS').remove();
      obj.after(cityHtml);
     }
   },'JSON');
  }

 function GetDistrict(){
   var obj= $('#cityS');
     var cityid=obj.val();
   var cityname=obj.find("option:selected").data('fullname');
   $('#cityinfo').val(cityname);
   var cityHtml='&nbsp;&nbsp;&nbsp;<select  id="districtS" style="width:126px;float: left; height: 30px;margin-left:10px" onchange="GetCircle();"><option value="0">请选择</option>'
   $.post('?m=Agent&c=merchant&a=GetDistrict',{districtid:cityid},function(ret){
     if(ret.data){
        $.each(ret.data,function(nn,vv){
          console.log(nn);
         cityHtml+='<option value="'+vv.fullname+'" data-fullname="'+vv.fullname+'"  >'+vv.fullname+'</option>';
      });
      cityHtml+='</select>';
      $('#districtS').remove();
      $('#circleS').remove();
      obj.after(cityHtml);
     } 
   },'JSON');
 }
 function GetCircle(){
  var obj= $('#districtS');
  var districtid=obj.val();
  var districtname=obj.find("option:selected").data('fullname');
  var lng=obj.find("option:selected").data('lng');
  var lat=obj.find("option:selected").data('lat');
   $('#districtinfo').val(districtname);

 }

        $(document).ready(function() {
      employers.init();
        });
    !function(a,b){
      var employers = employers || {};
      employers.init = function(){
        var c = employers;
        b('.footable').footable();
        b('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green',
              });
        b('#check_box').on('ifChanged', function(){
          c.selectall('id[]','check_box');
        });
        b('.info_del_all').click(function(){
          c.delAll();
        });
        b('.part_item .checkAll').click(function(){
          var checkItems = b(this).parents('.part_item_t').siblings('.part_item_b').find('p').find('input[name="authority[]"]');
          if (b(this).is(':checked') == false) {
            checkItems.each(function(ke,el){
              $(el).iCheck('uncheck');
            });
          }else{
            checkItems.each(function(ke,el){
              $(el).iCheck('check');
            });
          }
        });
        jQuery.extend(jQuery.validator.messages, {
            required: "必填字段",
            remote: "请修正该字段",
            email: "请输入正确格式的电子邮件",
            equalTo: "请再次输入相同的值",
            maxlength: jQuery.validator.format("请输入一个长度最多是 {0} 的字符串"),
            minlength: jQuery.validator.format("请输入一个长度最少是 {0} 的字符串"),
        });
        b('#employersForm').validate({
                    errorPlacement: function (error, element){
                            element.before(error);
                    },
                    rules: {
                        confirm: {
                            equalTo: "#password"
                        },
            account: {
              minlength: 4
            },
            password: {
              minlength: 4
            }
                    }
                });
        b('.formSubmit').click(function(){
          if(b('#account').val() != ''){
            $.post('?m=Agent&c=merchant&a=checkAccount',{account:b('#account').val()},function(re){
              if(re.status == 0){
                b('#account').addClass('error');
                swal("错误", re.msg+" :)", "error");
              }else if(re.status == 1){
                b('#employersForm').submit();
              }
            },'json');
          }else{
            b('#employersForm').submit();
          }
        });
        b('.status-checkbox').change(function(){
          var i = b(this).attr('data-id'),s = b(this).is(':checked') ? 1 : 0;
          $.post('?m=User&c=merchant&a=field',{eid:i,status:s},function(re){
            if(re.status == 0){
              swal("错误", re.msg+" :)", "error");
            }
          },'json');
        });
        b('.employersDel').click(function(){
          var c = b(this);
          swal({
                title: "是否删除这条数据?",
                text: "删除数据后将无法恢复，确认要删除吗！",
                type: "warning",
                      confirmButtonColor: "#DD6B55",
                      confirmButtonText: "删除",
                      cancelButtonText: "取消",
                      closeOnConfirm: false,
                      showCancelButton: true,
            }, function (){
            $.post('?m=User&c=merchant&a=employersDel',{eid:c.attr('data-id')},function(re){
              if(re.status == 0){
                swal("错误", re.msg+" :)", "error");
              }else{
                swal("成功", re.msg+" :)", "success");
                c.parents('tr').remove();
                b('.footable').footable();
              }
            },'json');
            });
        });
        b('.employersEdit').click(function(){
          c.edit(b(this).attr('data-id'));
        });
      };
      employers.selectall = function(name,id){
        var checkItems = b('input[name="'+name+'"]');
        if ($("#"+id).is(':checked') == false) {
          checkItems.each(function(ke,el){
            $(el).iCheck('uncheck');
          });
        }else{
          checkItems.each(function(ke,el){
            $(el).iCheck('check');
          });
        }
      }
      employers.delAll = function(){
        swal({
              title: "是否删除选中?",
              text: "删除数据后将无法恢复，确认要删除吗！",
              type: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "删除",
                    cancelButtonText: "取消",
                    closeOnConfirm: false,
                    showCancelButton: true,
          }, function (){
          var checkItems = b('input[name="id[]"]'),c = false;
      
          checkItems.each(function(ke,el){
            if($(el).is(':checked') == true){
              c = true;
            }
          });
          if(c == false){
            swal("错误", "你至少需要选中一项 :)", "error");
            return false;
          }
          $('.employersDelAll').submit();
          });
      }
      employers.edit = function(data){
        var $data = b('#employersEditTpl').html().replace('{($eid)}',data);
        b('#myModal6').find('.modal-content .modal-body').find('.col-lg-12').html($data);
        b('.employersEditJump').click();
        employers.iframeRresponsible();
        var index = window.setTimeout(function(){
          $(window).resize();
        },200);
      }
      employers.iframeRresponsible = function(){
        var $allObjects = $("iframe, object, embed"),
            $fluidEl = $("figure");

          $allObjects.each(function() {
              $(this)
                 // jQuery .data does not work on object/embed elements
                .attr('data-aspectRatio', this.height / this.width)
                .removeAttr('height')
                .removeAttr('width');
          });
          $(window).resize(function() {
              var newWidth = $fluidEl.width();
              $allObjects.each(function() {
                  var $el = $(this);
                  $el
                  .width(newWidth)
                  .height(newWidth * $el.attr('data-aspectRatio'));
              });
          }).resize();
      }
      a.employers = employers;
    }(window,jQuery);
  !function(win, $){
      $('#mtype').change(function(){
          if($(this).val() ==1){
              $(".rebateAclear").css('display','block');
              $(".rebateAn").css('display','none');
              $('#subMerch').css('display','none');
          } else {
              $(".rebateAn").css('display','block');
              $(".rebateAclear").css('display','none');
              $('#subMerch').css('display','block');
          }
      })
  }(window, jQuery)
    </script>
</body>
</html>