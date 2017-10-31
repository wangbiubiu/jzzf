
<?php
bpBase::loadAppClass('common', 'User', 0);
class settlement_controller extends common_controller
{


    public function __construct()
    {

        parent::__construct();
        $this->model = M('cashier_order');
    }

 //金海哲商户申请提现
    public function addorder()
    {
        if(IS_POST)
        {
            $mid = $this->mid;//商家编号
            $qrcode=M('cashier_qrcode')->get_one(array('mid'=>$mid),'qrcode_id');
            $qrcode=$qrcode['qrcode_id'];
            $amount = $huazhangmoney;//申请代付金额
            $dmount = $record['money'];//代付金额
            $rmount=$amount<=$dmount?$amount:$dmount;
            $url = 'http://pay.51jihua.net/merchants.php?m=pay&c=jhzdf&a=jdf';  //调用接口的平台服务地址
            $post_string = array(
                'ewmid'=>$qrcode
                ,'acct_id'=>$_POST['acct_id']
                ,'acct_name'=>$_POST['acct_name']
                ,'mobile'=>$_POST['mobile']
                ,'amount'=>$_POST['amount']
                ,'bank_settle_no'=>$_POST['bank_settle_no']
            );
             
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            $result = curl_exec($ch);
            $lastobj=json_decode($result,true);
            if($lastobj['msg']['code']==2000)
            {
                if($amount<$dmount){
                    //修改划账金额
                    $hzmoney=M('cashier_msettlement')->update(array("money"=>$dmount-$amount),array("mid"=>$mid,"status"=>0,'money'=>$dmount));
                    //新增划账记录
                    $addjl=M('cashier_msettlement')->insert(array("mid"=>$mid,"username"=>$record['username'],"addtime"=>time(),"money"=>$amount,"money2"=>$record['money2'],"status"=>1,"txt"=>''),array("id"=>$id));
                }else
                {
                    $result = M('cashier_msettlement')->update(array("status"=>1,"addtime"=>time()),array("mid"=>$mid,"status"=>0,'money'=>$dmount));//修改提现状态
                }
                 
                $this->dexit(array('errcode'=>1,'msg'=>'申请提现成功!'));
            }else
            {
                $this->dexit(array('errcode'=>0,'errmsg'=>$str['respDesc']));
            }
            curl_close($ch);
        }else 
        {
            include $this->showTpl("");
        }
        
    }
    //商户申请结算
    public function index()
    {
        //查询出商家未对账的所有订单
        $time = strtotime(date('Y-m-d 00:00:00',time()));

        $bank = M('cashier_bank')->get_one('mid='.$this->mid,"*");
        $bank2 = $bank;
        if(empty($bank)){//没有设置银行信息
            $bank = 0;
        }
        elseif($bank['bank'] == "0"){//银行信息未审核
            $bank = 1;
        }
        elseif($bank['bank'] == 2){//审核失败
            $bankmsg = $bank['bankmsg'];
            $bank = 2;
        }
        else{
            $bank = 3;
        }

        //提现记录
        $where = 'mid='.$this->mid;
        $getdata = $this->clear_html($_GET);
        if(!empty($getdata['start'])){
            $start = strtotime(date($getdata['start']." 00:00:00",time()));
            $where .= " AND addtime >= '$start'";
        }
        if(!empty($getdata['end'])){
            $start = strtotime(date($getdata['end']." 23:59:59",time()));
            $where .= " AND addtime <= '$start'";
        }
        if(!empty($getdata['status'])){
            $status = $getdata['status'] - 1;
            $where .= " AND status = '$status'";
        }

        $_count = M('cashier_msettlement')->count($where);
        bpBase::loadOrg('common_page');
        $p = new Page($_count, 10);
        $pagebar = $p->show(2);
        $rows = M('cashier_msettlement')->select($where,"*",$p->firstRow . ',' . $p->listRows,"id DESC");
        $sum_money = 0;
        foreach ($rows as $rk => $v){
            $sum_money += $v['money'];
            $bank3 = json_decode($v['txt'],true);
            $rows[$rk]['bank'] = $bank3;
        }
        $sqlObj = new model();
        $time = date('Y-m-d',time());
        $t = strtotime($time);
        $t1 = $t-86400;
        $t2 = $t+86400;
        $sql = "SELECT SUM(`goods_price`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t ." AND `paytime`>=".$t1.' AND mid='.$this->mid;
//        echo $sql;
        $sql2 = "SELECT SUM(`goods_price`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t2 ." AND `paytime`>=".$t.' AND mid='.$this->mid;
        //昨日交易金额
        $money = $sqlObj->get_varBySql($sql,'num');
        //今日
        $money2 = $sqlObj->get_varBySql($sql2,'num');
//         $total[0]['money']=123;$order_money[0]['money']=120;
        if($this -> isMobile()){
            include $this->showTpl("indexwap");
        }
        else{
            include $this->showTpl();
        }
    }
    //ajax提现
    public function withdrawals(){
        $postdata = $this->clear_html($_POST);
        $bank = M('cashier_bank')->get_one('mid='.$this->mid);
        if(!$bank){
            $this->dexit(array('code'=>0,'msg'=>'请先填写银行卡信息!'));
        }


        //今日之前的可提现金额
        $where = array(
            'ispay'=>1,
            'state'=>1,
            'mid'=>$this->mid,
            'refund'=>array('neq',2),
            'mchtype'=>2,
            //'paytime'=>array('elt',$postdata['time']),
        );
        $order_money = $this->model->select($where,'SUM(`income`) as money');

        if($order_money[0]['money'] - 3 <= 0){
            $this->dexit(array('code'=>0,'msg'=>'提现金额不能小于3'));
        }


        if(intval($order_money[0]['money']) == intval($postdata['money'])){

            $data = array(
                'mid'=>$this->mid,
                'username'=> $this->merchant['company'],
                'addtime'=>time(),
                'money'=>$postdata['money'] - 3,
            );
            $result = M('cashier_msettlement')->insert($data,1);

            if($result){
                $where = array(
                    'ispay'=>1,
                    'state'=>1,
                    'mid'=>$this->mid,
                    'refund'=>array('neq',2),
                    'mchtype'=>2,
                    //'paytime'=>array('elt',$postdata['time']),
                );

                $re =  M('cashier_order')->update(array('state'=>2),$where);
                if($re){
                    $this->dexit(array('code'=>1,'msg'=>'申请成功'));
                }
            }else{
                $this->dexit(array('code'=>0,'msg'=>'申请失败'));
            }
        }else{
            $this->dexit(array('code'=>0,'msg'=>'金额有误'));
        }

    }
    /*     * ****银行卡配置******* */

    public function bank() {

        if (IS_POST) {
        	//dump($_POST); die();
      	
     $data['isCompay']=$_POST['isCompay'];
     $data['phoneNo']=$_POST['phoneNo'];
     $data['customerName']=$_POST['customerName'];
     $data['cerdType']=$_POST['cerdType'];
     $data['cerdId']=$_POST['cerdId'];
     $data['accBankNo']=$_POST['accBankNo'];
     $data['accBankName']=$_POST['accBankName'];
     $data['bankType']=$_POST['bankType'];
     $data['acctNo']=$_POST['acctNo'];
     $data['settBankNo']=$_POST['settBankNo'];
     $data['settBankNo2']=$_POST['settBankNo2'];
     $data['busiType']='00800';

     
    //图片
     $data['imgzheng']=$_POST['constructLeanIDList'][0];
     $data['imgfan']=$_POST['constructLeanList'][0];
     
     $data['shouimg']=$_POST['contactList'][0];
     $data['bankzheng']=$_POST['cunstructIDList'][0];
     $data['bankfan']=$_POST['landUseIdList'][0];
     if($data['isCompay']==0){
         if ($data['imgzheng'] == '' || $data['imgfan']=="" || $data['shouimg']=="" ||  $data['bankzheng']=="" ||  $data['bankfan']=="" ) {
             $this->errorTip('请上传完身份证或银行卡的图片!');
         }
     }
     else{
         if ($data['imgzheng'] == '' && $data['bankzheng']=="") {
             $this->errorTip('请上传完上传三证合一执照或开户许可证!');
         }
     }
              
            $data['bank_img'] = serialize($data['bank_img']);
         
            
            $cashier_bankDb = M('cashier_bank');
            
            $bankArr = $cashier_bankDb->get_one(array('mid' => $this->mid), '*');
            
            
            if (empty($bankArr)) {
            	
                $data['id'] =$_POST['id'];
                
                if ($cashier_bankDb->insert($data, true)) {
                    $this->errorTip('上传成功，等待管理员审核！');
                    
                } else {
                    $this->errorTip('设置失败!');
                }
            } else {
                $data['bank'] = 0;
                $data['bankmsg'] = "";
                if ($cashier_bankDb->update($data, array('id' =>$_POST['id']))) {
                    $this->errorTip('修改成功，等待管理员审核!');
                } else {
                    $this->errorTip('修改失败!');
                }
            }
        }else{
            $bank = M('cashier_bank')->get_one(array('id'=>$_GET['id']));
            
            if(!empty($bank)){
                $bank['bank_img'] = unserialize($bank['bank_img']);
            }
            if($this -> isMobile()){
                include $this->showTpl("bankwap");
            }
            else{
                include $this->showTpl();
            }
        }
    }
//处理上传图片
  public function uploadImg()
    {

        if (IS_POST) {
            if (!empty($_FILES)) {

                $return = $this->oldUploadFile('png', $_GET['mid']);

                if ($return['error'] > 0) {
                    $this->dexit(array('error' => 1, 'msg' => $return['data']));
                } else {
                    $filesinfo = $return['data']['0'];
                    $this->dexit(array('error' => 0, 'msg' => 'OK', 'fileUrl' => $return['imgurl'] . $filesinfo['savename'], 'originalfilename' => $filesinfo['name'], 'fileSize' => $filesinfo['size']));
                }
            }
            $this->dexit(array('error' => 1, 'msg' => '没有上传文件！'));
        }

    }

    //判断是否为手机
    function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }

    public function cash(){
        //查询出商家未对账的所有订单
        $time = strtotime(date('Y-m-d 23:59:59',time()));
        $bank = M('cashier_bank')->get_one('mid='.$this->mid,"*");
        $bank2 = $bank;
        if(empty($bank)){//没有设置银行信息
            $bank = 0;
        }
        elseif($bank['bank'] == "0"){//银行信息未审核
            $bank = 1;
        }
        elseif($bank['bank'] == 2){//审核失败
            $bankmsg = $bank['bankmsg'];
            $bank = 2;
        }
        else{
            $bank = 3;
        }
        $where = array("mid"=>$this->mid,"state"=>1,"refund"=>array("neq",2));
        $order_money = M("cashier_order") -> get_one($where,"sum(income)");
        $mer = M('cashier_merchants') -> get_one(array("mid"=>$this->mid),"commission");
        $usermoney = round($order_money['sum(income)']-$order_money['sum(income)']*$mer['commission'],2)?:0;
        $db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
        $sqlStr = "UPDATE " . $tablepre . "cashier_merchants SET money = money + '$usermoney' WHERE mid = ".$this->mid;
        $sqlObj = new model();
        $sqlBool = $sqlObj->selectBySql($sqlStr);
        $usermoney = 0;
        if($sqlBool){
            $re = M('cashier_order')->update(array('state' => 2), $where);
            if($re){
                $mer = M('cashier_merchants') -> get_one(array("mid"=>$this->mid),"money");
                $usermoney = $mer['money'];
            }
        }
        //提现记录
        $where = 'mid='.$this->mid;
        $getdata = $this->clear_html($_GET);
        if(!empty($getdata['start'])){
            $start = strtotime(date($getdata['start']." 00:00:00",time()));
            $where .= " AND addtime >= '$start'";
        }
        else{
            $getdata['start'] = date("Y-m-d",time());
            $start = strtotime(date($getdata['start']." 00:00:00",time()));
            $where .= " AND addtime >= '$start'";
        }
        if(!empty($getdata['end'])){
            $start = strtotime(date($getdata['end']." 23:59:59",time()));
            $where .= " AND addtime <= '$start'";
        }
        else{
            $getdata['end'] = date("Y-m-d",time());
            $start = strtotime(date($getdata['end']." 23:59:59",time()));
            $where .= " AND addtime <= '$start'";
        }
        if(!empty($getdata['status'])){
            $status = $getdata['status'] - 1;
            $where .= " AND status = '$status'";
        }
        $_count = M('cashier_msettlement')->count($where);
        bpBase::loadOrg('common_page');
        $p = new Page($_count, 10);
        $pagebar = $p->show(2);
        $rows = M('cashier_msettlement')->select($where,"*",$p->firstRow . ',' . $p->listRows,"id DESC");
        $sum_money = 0;
        foreach ($rows as $rk => $v){
            $sum_money += $v['money'];
            $bank3 = json_decode($v['txt'],true);
            $rows[$rk]['bank'] = $bank3;
        }

        if($this -> isMobile()){
            include $this->showTpl("cashwap");
        }
        else{
            include $this->showTpl();
        }
    }
    public function iscash(){
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $cashmoney = $data['money'];
            $mer = M('cashier_merchants')->get_one(array("mid" => $this->mid), "*");
            $usermoney = $mer['money'];
            //判断金额
            if(empty($cashmoney)){
                $this->errorTip('请输入提现金额！',"/merchants.php?m=User&c=settlement&a=cash");
            }
            if($cashmoney > $usermoney){
                $this->errorTip('提现金额不能大于您的余额！',"/merchants.php?m=User&c=settlement&a=cash");
            }
            if($cashmoney < 5){
                $this->errorTip('提现金额不能小于5元！',"/merchants.php?m=User&c=settlement&a=cash");
            }
            //判断银行卡
            $bank = M('cashier_bank')->get_one('mid='.$this->mid,"*");
            $bank2 = $bank;
            if(empty($bank)){//没有设置银行信息
                $this->errorTip('请先设置银行卡信息！',"/merchants.php?m=User&c=settlement&a=bank");
            }
            elseif($bank['bank'] == "0"){//银行信息未审核
                $this->errorTip('银行信息未审核！',"/merchants.php?m=User&c=settlement&a=bank");
            }
            elseif($bank['bank'] == 2){//审核失败
                $bankmsg = $bank['bankmsg'];
                $this->errorTip('银行审核失败['.$bankmsg.']！',"/merchants.php?m=User&c=settlement&a=bank");
            }
            //创建代付订单
            $commission = $mer['commission'];
            $money2 = $cashmoney - 3;//收款-手续费
            $mset = array();
            $mset['mid'] = $this->mid;
            $mset['addtime'] = time();
            $mset['username'] = $mer['company'];
            $mset['money'] = $money2;//提现金额（已扣除手续费）
            $mset['money2'] = $cashmoney;//收款金额
            $mset['status'] = 0;
            $data =array();
            $data['commission'] = $commission;//费率
            $data['amount'] = $money2;//需结算的金额
            $data['phoneNo'] = $bank['phoneNo'];
            $data['customerName'] = $bank['customerName'];
            $data['cerdType'] = $bank['cerdType'];
            $data['cerdId'] = $bank['cerdId'];
            $data['settBankNo'] = $bank['settBankNo'];
            $data['accBankNo'] = $bank['accBankNo'];
            $data['accBankName'] = $bank['accBankName'];
            $data['bankType'] = $bank['bankType'];
            $data['addrName'] = $bank['addrName'];
            $data['busiType'] = $bank['busiType'];
            $data['acctNo'] = $bank['acctNo'];
            $data['isCompay'] = $bank['isCompay'];
            $mset['txt'] = json_encode($data, JSON_UNESCAPED_UNICODE);
            $result = M('cashier_msettlement')->insert($mset);

            if($result){
                //开始结算
                require_once("./MinShengBank.class.php");//本地
                $bank = new MinShengBank();
                $data['orderNo'] = date("YmdHis",time()).mt_rand(10000,99999);
                $data['transAmt'] = $money2*100;//需结算的金额
                $data['productId'] = "0201";
                $data['notifyUrl'] = "http://".$_SERVER['SERVER_NAME']."/";
                $str = $bank -> daifu($data);
                //$str['respCode'] = "0000" ;
                //$str['respDesc'] = "交易成功";
                file_put_contents('./banknotify3.txt',json_encode($str));
                if($str['respCode'] == "0000" && $str['respDesc'] == "交易成功"){
                    M('cashier_wxcoupon_receive')->insert(array("openid"=>'打款成功',"give_openId"=>serialize($str)),true);//测试是否执行
                    $result = M('cashier_msettlement')->update(array("status"=>1,"orderNo"=>$str['orderNo']),array("mid"=>$this->mid,"status"=>0,'money'=>$money2));//修改提现状态
                    $db_config = loadConfig('db');
                    $tablepre = $db_config['default']['tablepre'];
                    $sqlStr = "UPDATE " . $tablepre . "cashier_merchants SET money = money - '$cashmoney' WHERE mid = ".$this->mid;
                    $sqlObj = new model();
                    $sqlBool = $sqlObj->selectBySql($sqlStr);
                    $this->errorTip('提现成功！',"/merchants.php?m=User&c=settlement&a=cash");
                }else{
                    if($str['respCode'] == "P000"||$str['respCode'] == "9997"||$str['respCode'] == "9999"){
                        $result = M('cashier_msettlement')->update(array("orderNo"=>$str['orderNo']),array("mid"=>$this->mid,"status"=>0,'money'=>$money2));//修改民生银行商品订单号
                        $db_config = loadConfig('db');
                        $tablepre = $db_config['default']['tablepre'];
                        $sqlStr = "UPDATE " . $tablepre . "cashier_merchants SET money = money - '$cashmoney' WHERE mid = ".$this->mid;
                        $sqlObj = new model();
                        $sqlBool = $sqlObj->selectBySql($sqlStr);
                        $data1['orderDate']=$str['orderDate'];
                        $data1['orderNo']=$str['orderNo'];
                        $chaxun = $bank -> queryOrder($data1);
                        if($chaxun['origRespCode']=='0000'){
                            $result = M('cashier_msettlement')->update(array("status"=>1,"orderNo"=>$str['orderNo']),array("mid"=>$this->mid,"status"=>0,'money'=>$money2));//修改提现状态
                        }
                        else{
                            M('cashier_wxcoupon_receive')->insert(array("openid"=>'打款失败',"give_openId"=>serialize($str)),true);//测试是否执行
                            $result = M('cashier_msettlement')->update(array("status"=>2),array("mid"=>$this->mid,"status"=>0,'money'=>$money2));//修改提现失败状态
                            $db_config = loadConfig('db');
                            $tablepre = $db_config['default']['tablepre'];
                            $sqlStr = "UPDATE " . $tablepre . "cashier_merchants SET money = money + '$cashmoney' WHERE mid = ".$this->mid;
                            $sqlObj = new model();
                            $sqlBool = $sqlObj->selectBySql($sqlStr);
                            $this->errorTip('系统繁忙！',"/merchants.php?m=User&c=settlement&a=cash");
                        }
                    }
                    else{
                        M('cashier_wxcoupon_receive')->insert(array("openid"=>'打款失败',"give_openId"=>serialize($str)),true);//测试是否执行
                        $result = M('cashier_msettlement')->update(array("status"=>2),array("mid"=>$this->mid,"status"=>0,'money'=>$money2));//修改提现失败状态
                        $this->errorTip('系统繁忙！',"/merchants.php?m=User&c=settlement&a=cash");
                    }
                }
            }
        }
        else{
            $this->errorTip('系统繁忙！',"/merchants.php?m=User&c=settlement&a=cash");
        }
    }

    //银行卡列表
    public function banklist()
    {
        $banklist=M('cashier_bank')->select(["mid"=>$this->mid]);
        include $this->showTpl("banklist");
    }
    
    public function banklist2()
    {
//         $banklist=M('cashier_bank')->select(["mid"=>$this->mid]);
        $banklist=M('cashier_another')->select(['mid'=>$this->mid]);
        include $this->showTpl("banklist2");
    }
    //添加银行卡
    public function addbank()
    {
        if (IS_POST) {
            $data['isCompay']=$_POST['isCompay'];
            $data['phoneNo']=$_POST['phoneNo'];
            $data['customerName']=$_POST['customerName'];
            $data['cerdType']=$_POST['cerdType'];
            $data['cerdId']=$_POST['cerdId'];
            $data['accBankNo']=$_POST['accBankNo'];
            $data['accBankName']=$_POST['accBankName'];
            $data['bankType']=$_POST['bankType'];
            $data['acctNo']=$_POST['acctNo'];
            $data['settBankNo']=$_POST['settBankNo'];
            $data['settBankNo2']=$_POST['settBankNo2'];
            $data['busiType']='00800';
            //图片
            $data['imgzheng']=$_POST['constructLeanIDList'][0];
            $data['imgfan']=$_POST['constructLeanList'][0];

            $data['shouimg']=$_POST['contactList'][0];
            $data['bankzheng']=$_POST['cunstructIDList'][0];
            $data['bankfan']=$_POST['landUseIdList'][0];
            if($data['isCompay']==0){
                if ($data['imgzheng'] == '' || $data['imgfan']=="" || $data['shouimg']=="" ||  $data['bankzheng']=="" ||  $data['bankfan']=="" ) {
                    $this->errorTip('请上传完身份证或银行卡的图片!');
                }
            }
            else{
                if ($data['imgzheng'] == '' && $data['bankzheng']=="") {
                    $this->errorTip('请上传完上传三证合一执照或开户许可证!');
                }
            }

            $data['bank_img'] = serialize($data['bank_img']);


            $cashier_bankDb = M('cashier_bank');

            $bankArr = $cashier_bankDb->get_one(array('mid' => $this->mid), '*');
            $data['mid'] = $this->mid;
            if($bankArr){
                if ($cashier_bankDb->insert($data, true)) {
                    $this->errorTip('上传成功，等待管理员审核！');

                } else {
                    $this->errorTip('设置失败!');
                }
            }
            else{
                $data['adefalut']='1';
                if ($cashier_bankDb->insert($data, true)) {
                    $this->errorTip('上传成功，等待管理员审核！');

                } else {
                    $this->errorTip('设置失败!');
                }
            }
        }
        include $this->showTpl("addbank");
    }

    //添加银行卡
    public function addbank2()
    {
        
        if (IS_POST) {
           $_POST['mid']=$this->mid;
           $_POST['order_id']=time().SYS_TIME;
           $_POST['status']=1;
           $_POST['name'];
        }
        include $this->showTpl("addbank2");
    }
    
    //设置默认银行卡
    public function defalutBankCard()
    {
        $data['adefalut']='1';
        M('cashier_bank')->update(['adefalut'=>0],['mid'=>$this->mid]);
        $result= M('cashier_bank')->update($data, array('id' =>$_POST['id']));
        if($result){
            $data1['error']='0';
        }
        else{
            $data1['error']='1';
        }
        $this->dexit($data1);
    }
    /**
     * 导出excel表格
     */
    public function data2Excel() {

        $getdata=$_GET;

        $stats=strtotime(date('Y-m-01',time()));//开始时间strtotime($getdata['start'] . '-1 day 23:00:00')
       $end= time() ; //结束时间

        $where='mid='.$this->mid;
        if (empty($getdata['stats'])) {
            $where.=' AND addtime >'.$stats;
        }else{
            $where.=' AND addtime >'.strtotime($getdata['stats']);
        }
        if (empty($getdata['end'])) {
            $where.=' AND addtime <'.$end;
        }else{
            $where.=' AND addtime <'.strtotime($getdata['end']);
        }

        $rows = M('cashier_msettlement')->select($where,"*");

        $data=[];
        foreach ($rows as $k => $v) {
            $data[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
            $data[$k]['bank'] = $this->banks(json_decode($v['txt'])->settBankNo);
            $data[$k]['block'] = json_decode($v['txt'])->acctNo;
            $data[$k]['name'] .= json_decode($v['txt'])->customerName;
            $data[$k]['money2'] .= $v['money2'];
            $data[$k]['money'] .= $v['money'];
            $data[$k]['status'] .= $v['status']?'已划账':'未划账';
        }
        $title = array('提现时间','开户银行','银行卡号','开户姓名','收款金额','提现金额','提现状态');
        $filename = '商户结算列表'.date('Y-m-d',time()).'.xls';

        $this->ExportTables($data,$title,$filename);

    }
    public function banks($data)
    {
        switch($data){
            case "ICBC":
                return '工商银行';
                break;
            case "ABC":
                return '农业银行';
                break;
            case "BOC":
                return '中国银行';
                break;
            case "CCB":
                return '建设银行';
                break;
            case "CMB":
                return '招商银行';
                break;
            case "BOCM":
                return '交通银行';
                break;
            case "CMBC":
                return '民生银行';
                break;
            case "CNCB":
                return '中信银行';
                break;
            case "CEBB":
                return '光大银行';
                break;
            case "CIB":
                return '兴业银行';
                break;
            case "BOB":
                return '北京银行';
                break;
            case "GDB":
                return '广发银行';
                break;
            case "HXB":
                return '华夏银行';
                break;
            case "PAB":
                return '平安银行';
                break;
            case "BOS":
                return '上海银行';
                break;
            case "BOHC":
                return '渤海银行';
                break;
            case "BOJ":
                return '江苏银行';
                break;
            case "SPDB":
                return '浦发银行';
                break;
            case "PSBC":
                return '邮储银行';
                break;
        };
    }
}


?>