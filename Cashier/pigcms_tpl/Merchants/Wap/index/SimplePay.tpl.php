<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/base.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/swiper.min.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/font-awesome.min.css">
    <link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/style.css">
	<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
	<style>
	#youhuitype{color:green;}
	#shopidSelect{border:none;width: 85%;background-color: #fff;}
	</style>
<body style="zoom: 1; padding-bottom: 0px;">
<div class="userHeader">
    <a class="back" href="javascript:;" onclick="window.history.back();">返回</a>
    <h2>快速买单</h2>
</div>
<div class="dDanInfo">
    <img src="{pg:$UserInfo.headimgurl}" alt="No Image">
    <h3>{pg:$UserInfo.nickname}</h3>
</div>
<form id="payForm" name="payform" action="?m=Wap&c=index&a=wxTopay" method="POST">
<div class="dMform">
    <div class="row">
        <span>消费总额：</span>
        <div class="rightInput">
            <input type="text" placeholder="询问服务员后输入（元）" onkeyup="value=value.replace(/[^1234567890\.]+/g,'')" id="TotalMoney" name="totalmoney" value=''>
        </div>
    </div>
	{pg:if !empty($storesArr)}
	<div class="row">
        <span>消费门店</span>
        <div class="rightInput">
			 <span>{pg:$storesArr.business_name}{pg:$storesArr.branch_name}</span>
			<input type="hidden" name="store_id" value="{pg:$storesArr.id}">
        </div>
    </div>
	{pg:/if}
	<div id="BcyyhMoney" {pg:if in_array($cardinfo.card_type,array(0,1,3)) OR ($cardinfo.card_type eq 5 AND !isset($cardinfo.kqexpand.discount))} style="display:none;" {pg:/if}>
    <p class="tipThis">输入不参与优惠金额(没有可以不填)</p>
    <div class="row">
        <span>不参与优惠金额：</span>
        <div class="rightInput">
            <input type="text" placeholder="询问服务员后输入（元）" onkeyup="value=value.replace(/[^1234567890\.]+/g,'')" id="BcyMoney" name="bcymoney" value=''>
        </div>
    </div>
    </div>
	<div class="row">
        <span>付款备注</span>
        <div class="rightInput">
            <input type="text" placeholder="请务必填写" name="goods_describe">
        </div>
    </div>
</div>
<input type="hidden" name="paymoney" id="paymoney" value="0">
<input type="hidden" name="mid" id="mid" value="{pg:$mid}">
<input type="hidden" name="receiveid" id="receiveid" value="{pg:$receiveid}">
<input type="hidden" name="cardid" id="cardid" value="{pg:$cardid}">
<input type="hidden" name="storeid" id="storeid" value="{pg:$store_id}">
</form>
<div class="dMrow setRow">

	{pg:if !$havecard AND $Rcount gt 0 }
    <div class="row" onclick="goCardList();">
        <em>未使用<i class="arrowThis"></i></em>
        <span>使用优惠券<i>{pg:$Rcount}张可用</i></span>
    </div>
	{pg:/if}
    <div class="row" style="position:initial;font-size: 15px;{pg:if !$havecard} display:none;{pg:/if}">
	  <p><span id="cardtypeStr">{pg:$cardinfo.card_typeStr}</span>
	  <span id="youhuitype">
	  {pg:if $cardtype eq 2}
	   打 <span class="type2">{pg:$cardinfo.kqexpand.discount} 折</span>
	  {pg:elseif $cardtype eq 4}
	   满 <span class="type4_1">{pg:$cardinfo.kqexpand.least_cost}</span> 减免 <span class="type4_2">{pg:$cardinfo.kqexpand.reduce_cost}</span>
	  {pg:elseif $cardtype eq 5 AND isset($cardinfo.kqexpand.discount)}
	  打 <span class="type5">{pg:$cardinfo.kqexpand.discount} 折</span>
	  {pg:/if}
	  </span>
	  </p>
	  <p style="width: 96%;margin-top: 10px;" id="desctext">说明：{pg:$desc}</p>
    </div>
    <div class="row payMoney">
        <em>￥<i id="toPayMoney">0</i><s> 元</s></em>
        <span>实付金额</span>
    </div>

    <div class="row subBtn">
        <a class="abtn" href="javascript:;" onclick="sureTopay();"> 微信支付</a>
    </div>
</div>
</body>
<script type="text/javascript">
var cardtype=0;
cardtype={pg:$cardtype};
var toPayVar='0';
$('#BcyMoney').val('');
$('#TotalMoney').val('');
$('#toPayMoney').text('0');
$("body").on("input propertychange", "#TotalMoney", function () {
  var tMoney=$(this).val();
  tMoney=parseFloat(tMoney);
  tMoney=tMoney>0 ? tMoney :0;
  var bcyMoney=$('#BcyMoney').val();
  bcyMoney=parseFloat(bcyMoney);
  bcyMoney=bcyMoney>0 ? bcyMoney :0;
  var youhuiMoney=tMoney-bcyMoney;
  cardtype=parseInt(cardtype);
  var tmpPrice=toCalculateMoney(youhuiMoney,cardtype);
	tmpPrice=bcyMoney>0 ? (tmpPrice+bcyMoney):tmpPrice;
	if(tmpPrice>0){
		if(tmpPrice<0.01){
	       toPayVar=0.01;
		 }else{
		   toPayVar=tmpPrice.toFixed(2);
		 }
	 $('#toPayMoney').text(toPayVar);
	 $('#paymoney').val(toPayVar);
	}else{
	 toPayVar='0';
	 $('#paymoney').val('0');
	 $('#toPayMoney').text('0');
	 $('#TotalMoney').focus();
	}
	return false;
});

$("body").on("input propertychange", "#BcyMoney", function () {
  var tMoney=$('#TotalMoney').val();
  tMoney=parseFloat(tMoney);
  tMoney=tMoney>0 ? tMoney :0;
  var bcyMoney=$(this).val();
  bcyMoney=parseFloat(bcyMoney);
  bcyMoney=bcyMoney>0 ? bcyMoney :0;
  var youhuiMoney=tMoney-bcyMoney;
  cardtype=parseInt(cardtype);
  var tmpPrice=toCalculateMoney(youhuiMoney,cardtype);
	tmpPrice=bcyMoney>0 ? (tmpPrice+bcyMoney):tmpPrice;
	if(tmpPrice>0){
	 if(tmpPrice<0.01){
	   toPayVar=0.01;
	 }else{
	   toPayVar=tmpPrice.toFixed(2);
	 }
	 $('#toPayMoney').text(toPayVar);
	 $('#paymoney').val(toPayVar);
	}else{
	   toPayVar='0';
	  $('#paymoney').val('0');
	  $('#toPayMoney').text('0');
	  $('#TotalMoney').focus();
	}
	return false;
});

function toCalculateMoney(mm,tt){
 var returnV=mm;
 switch(tt){
	case 0:

	break;
 	case 1:
	break;
	case 2:
		var discountV=$('#youhuitype .type2').text();
	     discountV=$.trim(discountV);
		 discountV=parseFloat(discountV);
		 returnV=(mm*discountV)/10;
	break;
	case 3:
	break;
	case 4:
		var mPrice=$('#youhuitype .type4_1').text();
		mPrice=parseFloat(mPrice);
	    var rPrice=$('#youhuitype .type4_2').text();
		rPrice=parseFloat(rPrice);
		var tmpM=mm/mPrice;
		var rnum=Math.floor(tmpM);
		returnV=mm-(rnum*rPrice);
	    
	break;
	case 5:
		 if($('#youhuitype .type5').size() >0){
			 var discountV=$('#youhuitype .type5').text();
			 discountV=$.trim(discountV);
			 discountV=parseFloat(discountV);
			 returnV=(mm*discountV)/10;
		 }
	break;
 }
  returnV=parseFloat(returnV);
  return returnV;
}

function sureTopay(){
 var paymoney=$('#paymoney').val();
     paymoney=parseFloat(paymoney);
	 toPayVar=parseFloat(toPayVar);
	 if((paymoney>=0.01) && (paymoney==toPayVar)){
	    document.payform.submit();
	 }else{
	    alert('支付金额不对');
		return false;
	 }
}

function goCardList(){
   window.location.href="/merchants.php?m=Wap&c=index&a=couponlist&id={pg:$store_id}&type=1";
}
</script>
</html>