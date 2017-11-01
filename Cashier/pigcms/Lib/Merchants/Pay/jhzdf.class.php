<?php
bpBase::loadAppClass('base', '', 0);
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27
 * Time: 11:00
 */
class jhzdf_controller extends base_controller{
    private function jzzdf($acct_id,$acct_name,$mobile,$amount,$order_id,$rows,$bank_settle_no,$balance,$bankname,$astrict){

        error_reporting(E_ALL^E_NOTICE^E_WARNING);
        header("Content-Type: text/html; charset=utf8");
        $uploadConfig = loadConfig('jhz');


        $public_key = $uploadConfig['public_key'];
        // 密钥必须按照以下格式
        $private_key = $uploadConfig['private_key'];

        $pay_url = $uploadConfig['df_url'];

        // 请求数据赋值SFTTEST
        $data = "";
        $data['merchant_no'] = $uploadConfig['merchantNo']; //商户号
        $data['acct_id'] = $acct_id;   //卡号
        $data['acct_name'] = $acct_name;   //持卡人
        $data['mobile'] = $mobile;     //手机号码
        $data['acct_type'] = '21001';   //21001借记卡  21002信用卡
        $data['amount'] = $amount;//金额（分）
        $data['amount_type'] = 'CNY';//业务编号
        $data['memo'] = '商家提现';   //摘要
        $data['product_type'] = '11001';//11002额度代付   11001余额代付
        $data['request_no'] = $order_id ?: '22' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(time(), 2); //流水
        $data['version'] = '1.0';
        $data['bank_name']=$bankname;
        if($bank_settle_no!=0){
            $data['bank_settle_no']=$bank_settle_no;
        }//联行号

        $keyx ='600f66cab4754c19a1dd5e2bfa8b6406';//MD5值 【需要于商户对接人员拿】
        $signature = 'acct_id='.$data['acct_id'].'&acct_name='.$data['acct_name'].'&acct_type='.$data['acct_type'].'&amount='.$data['amount'].'&amount_type='.$data['amount_type'].'&memo='.$data['memo'].'&merchant_no='.$data['merchant_no'].'&mobile='.$data['mobile'].'&product_type='.$data['product_type'].'&request_no='.$data['request_no'].'&version='.$data['version'];
        //        echo $signature;exit;
        $sign_md5 = md5($signature."&key=".$keyx);
        //        echo 'MD5：'.$sign_md5;exit;
        $signature2 =urldecode(stripslashes($signature."&sign=".$sign_md5));
        $pr_key ='';
        if(openssl_pkey_get_private($private_key)){
            $pr_key = openssl_pkey_get_private($private_key);

        }else{

        }
        $pu_key = '';
        if(openssl_pkey_get_public($public_key)){
            $pu_key = openssl_pkey_get_public($public_key);

        }else{

        }
        $sign = '';
        openssl_sign($signature2,$sign,$pr_key);
        openssl_free_key($pr_key);
        $sign = base64_encode($sign);
        $data['sign'] = $sign;

        $ch = curl_init();
        //        if(!$flag)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_URL, $pay_url);
        $response =  curl_exec($ch);
        //  echo '请求成功：'.$response;
        curl_close($ch);

        $res=json_decode($response,TRUE);
        //        var_dump($res);exit;
        //        $res= array( "cipher_data"=>
        //                         "BJp1UDMR0QU%2FsJ1%2FP5F7SsD%2FEib4X24Yi9Rd3bXwRlhnh3TzLcO9x0CZmgVDO6DWXaX9UHEYIHIAC5Efh%2BfzpvqMfMxwovBs6QcJTQsSjz2iQKDTYO5pYUfMjAjC97IbLl3SfPbd7mu%2FnS%2FOrhvgorM0W%2Fy1aukYRreQrb5Hy8MCbcEC29bGyI%2BzUVyF9gFXxhLfzgssdAURn4MPTITqlx%2BaGt59X0lC5%2FEMXD%2FBeKQy7mSlTJO1mr5PrCWysDuaP0jj5CRGwMofWl2425TJGrPPl1oyAnz7WhOGhqjlQerVWHvkqzVHNq%2FWXuweWFaFlibiRPTVjvP3%2FQc4gXH%2Fey6fSNH8hHqxxx%2BXHrM%2B2EtvGa%2B1j0cfv5rk8uvtRzyc%2BGBdWN%2B%2BhlilwSGiY%2BEXdZI5GQ5Njoe8hUeq2bzxnLivvDno4uMAR7PrN%2BHtJjCdH6VzRgUX%2BuZn9ROdXRiI%2BtPN0pypF%2FJMv3wefnyWAG0Beb6AOYSz2xJfhpkOpAiW",
        //                     "retCode"=>
        //                         "12000",
        //                     "retMsg"=>
        //                         "请求代付成功");
        //        插入表格数据
        $info = array(
            "mid"=>$rows['mid'],
            "order_id"=>$order_id,
            "name"=>$acct_name,
            "bank"=>$acct_id,
            "money"=>$rows['amount'],
            "phone"=>$mobile,
            "memo"=>"商家提现",
            "bank_settle_no"=>$bank_settle_no,
            "addtime"=>date("Ymd",time()),
            "paytime"=>time(),
            "bank_name"=>$bankname,
            "remark"=>json_encode(["balance"=>$astrict['balance'],"balance_start"=>$astrict['balance_start'],"balance_end"=>$astrict['balance_end'],"balance_count"=>$astrict['balance_count']]),
        );


        //        把返回的参数与需要添加的数据传入该方法
        if($res['retCode']==12000){
            $this->response($res,$info,$balance,$rows['amount']);

        }else{
            $alert=$this->msg($res['retCode']);
            echo "<script language=javascript>alert('$alert');history.back();</script>";
//            echo $this->msg($res['retCode']);
            exit();
        }


        $response=iconv("GBK","UTF-8",$response);
        $response=stripslashes($response);
        $str = $response;
        //转成Array
        $arr = json_decode($str,true);
        $resultsign=$arr['cipher_data'];
        $resultsign=urldecode($resultsign);
        $resultsign=base64_decode($resultsign);
        $orig_dec_str ='';
        for($i=0;$i<strlen($resultsign)/128;$i++)
        {
            $datas=substr($resultsign,$i*128,128);
            openssl_private_decrypt($datas,$decrypt,$pr_key);
            $orig_dec_str.=$decrypt;
        }
        $arrs = json_decode($orig_dec_str,true);
        $signs=$arrs['sign'];
        unset($arrs['sign']);

        $original_str=stripslashes(json_encode($arrs));
        //        echo '--------------------------------------验签--------------------------------------------------------';
        //拼接
        $strs= urldecode(http_build_query($arrs));
        //验签
    }



    public function response($astrict,$info,$balance,$money){
        //返回流水
        //        $requestNo=$response['requestNo']?:"";
        //        $info['request_no']=$requestNo;
        //返回状态
        $info['status']=2;
        //        返回备注
        //        $remark=$response['msg']?:"";
        //        $info['remark']=$remark;
        //返回签名
        //        $sign=$response['sign']?:"";
        //        $info['sign']=$sign;
        //        返回交易类型
        //        $product_type=$response['product_type']?:"";
        //        $info['product_type']=$product_type;
        $this->addanother($info);

        if($info['status'] == 2){
            $astrict['count']=$astrict['count']+1;
            $astrict['balance_count']=$astrict['balance_count']+$money;
            $upmoney['balance']=$balance-($info['money']+3);
            $upmoney['mid']=$info['mid'];
            $otherinfo =$this->updateastrict($upmoney);
        }
        if(!empty($otherinfo) && $otherinfo){
            echo "<script language=javascript>alert('提现成功!');window.location.href='http://b.jizhipay.com/merchants.php?m=User&c=settlement&a=index';</script>";
            exit();
        }else{
            echo "<script language=javascript>alert('提现失败!');history.back();</script>";
            exit();
        }
    }

    public function addanother($info){

        if (M('cashier_another')->insert($info,true)) {
            return true;
            exit();
        }
        return FALSE;
    }

    public function updateastrict($upmoney){
        if (M('cashier_another_astrict')->update($upmoney,array('mid'=>$upmoney['mid']))) {
            return true;
            exit();
        }
        return FALSE;
    }

    /**
     *商户调用接口
     * ewmid二维码id
     * acct_id银行卡
     * acct_name姓名
     * mobile手机号
     * amount钱
     */

    public function msg($code){
        if($code==12003){
            return "参数异常,银行卡参数异常！";
            exit();
        }

        if($code==12002){
            return "参数异常,户名参数异常！";
            exit();
        }

        if($code==12004){
            return "参数异常,金额类型参数异常！";
            exit();
        }

        if($code==12009){
            return "总余额不足！";
            exit();
        }

        if($code==12005){
            return "参数异常,代付类型参数异常！";
            exit();
        }

        if($code==12006){
            return "参数异常,账户类型参数异常";
            exit();
        }

        if($code==12007){
            return "参数异常,手机号码参数异常！";
            exit();
        }

        if($code==12008){
            return "请求代付失败！";
            exit();
        }

        if($code==12010){
            return "小于单笔最小代付金额！";
            exit();
        }

        if($code==12011){
            return "大于单笔最大代付金额！";
            exit();
        }

        if($code==12012){
            return "本日额度超限！";
            exit();
        }

        if($code==12013){
            return "本月额度超限！";
            exit();
        }

        if($code==12014){
            return "未找到代付渠道！";
            exit();
        }

        if($code==12015){
            return "用途说明为空！";
            exit();
        }

        if($code==12016){
            return "该时间段不允许交易！";
            exit();
        }

        if($code==12017){
            return "银行预留手机号不能为空！";
            exit();
        }
    }
    public function jdf(){
        //        二维码id
        if (empty($_POST['ewmid'])){
            echo "<script language=javascript>alert('ewmid为空');history.back();</script>";

            exit();
        }
        //4钱
        if(empty($_POST['amount']) or $_POST['amount'] < 5){
            echo "<script language=javascript>alert('最小提现金额为5！');history.back();</script>";

            exit();
        }

        $rows = M('cashier_qrcode')->get_one("qrcode_id='" . $_POST['ewmid'] . "'");

        $astrict=M('cashier_another_astrict')->get_one("mid='" . $rows['mid'] . "'");
        //        资金池
        $upastrict=$astrict['upastrict'];
        //        每日提现上限
        $dayastrict=$astrict['dayastrict'];
        //        商户余额
        $balance=$astrict['balance'];
        //        可提现额度
        $yes_money=$balance-$upastrict;



        if($_POST['amount']>$balance-3){//提现金额大于余额不能提现
            echo "<script language=javascript>alert('提现金额超过余额！');history.back();</script>";
            exit();
        }

        if($astrict ==FALSE){

            echo "<script language=javascript>alert('没有该商户余额信息！');history.back();</script>";
            exit();
        }

        if($balance<$upastrict){//商户余额小于资金池不能提现

            echo "<script language=javascript>alert('余额小于资金池不能提现！');history.back();</script>";
            exit();
        }

        if($_POST['amount']>$yes_money){//提现金额小于可提现额度
            echo "<script language=javascript>alert('超过可提现额度！');history.back();</script>";

            exit();
        }
        if($_POST['amount']>50000){//超过单笔最大提现金额
            echo "<script language=javascript>alert('超过单笔最大提现金额5万！');history.back();</script>";
            exit();
        }
        //        当天时间
        $time=date("Ymd",time());
        $sqlObj = new model();
        $sql = "SELECT SUM(`money`) as count FROM " ."cqcjcm_cashier_another where mid={$rows['mid']} and addtime=$time";
        //        当天提现金额记录
        $when_money = $sqlObj->get_varBySql($sql, 'count');
        $sum_money=$_POST['amount']+$when_money;
        if($sum_money>$dayastrict){//超过每日提现额度

            echo "<script language=javascript>alert('提现金额超过每日提现额度！');history.back();</script>";
            exit();
        }

        /*
         * 左联用户余额表查出商户的mid
         * 判断mid是否存在
         * 判断用户余额是否大于资金池大于就可以提现
         * 中判断提现金额是否大于余额减去资金池金额
         * 大于就返回余额不足
         * 否则可以提现
         * 判断当前用户资金池
         *
         * */

        //1银行卡
        if (empty($_POST['acct_id'])){

            echo "<script language=javascript>alert('银行卡号为空！');history.back();</script>";
            exit();
        }
        if (empty($_POST['bank_name'])){


            echo "<script language=javascript>alert('开户行为空！');history.back();</script>";
            exit();
        }
        //2姓名
        if (empty($_POST['acct_name'])){

            echo "<script language=javascript>alert('姓名为空！');history.back();</script>";
            exit();
        }
        //3手机号
        if (empty($_POST['mobile'])){

            echo "<script language=javascript>alert('手机号为空！');history.back();</script>";
            exit();
        }


        if(!isset($_POST['bank_settle_no'])){

            echo "<script language=javascript>alert('请传递联行号信息！');history.back();</script>";
            exit();
        }
        if ($rows['mid'] && $rows['eid'] && $rows['storesid']){
            //            存入数据库的钱
            $rows['amount'] = $_POST['amount'];
            //            接口传过去的钱
            $info['amount'] = $rows['amount'] * 100;
            //            生成订单
            $orderid = '22' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(time(), 2);
            //            调用接口
            $info['balance']=$balance;
            $this->jzzdf($_POST['acct_id'],$_POST['acct_name'],$_POST['mobile'],$info['amount'],$orderid,$rows,$_POST['bank_settle_no'],$balance,$_POST['bank_name'],$astrict);
        } else {
            echo "<script language=javascript>alert('ewmid不存在！');history.back();</script>";
            exit();
        }
    }
}