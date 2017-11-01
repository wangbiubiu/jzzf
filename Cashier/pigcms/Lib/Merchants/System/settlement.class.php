<?php
//总后台统计管理
bpBase::loadAppClass('common', 'System', 0);
class settlement_controller extends common_controller
{
    public function __construct()
    {
        parent::__construct();

        $this->model=M('cashier_apply');
    }

    //代理结算
    public function aset(){
        $getdata = $this->clear_html($_GET);
        $where = " status='4' ";
        if ($getdata['name']) {
            $where .= " AND name like '%" . $getdata['name'] . "%'";
        }
        $start = ((isset($getdata['start']) ? strtotime($getdata['start']." 00:00:00") :0));
        $end = ((isset($getdata['end']) ? strtotime($getdata['end']." 23:59:59") : 0));

        if (0 < $start) {
            $where .= ' AND addtime>=' . $start;
        }
        if (0 < $end) {
            $where .= ' AND addtime<=' . $end;
        }
        bpBase::loadOrg('common_page');
        $_count = M('cashier_agent_commission')->count($where);
        $p = new Page($_count, 15);
        $pagebar = $p->show(2);
        $rows = M('cashier_agent_commission')->select($where, '*', "$p->firstRow,$p->listRows",'addtime desc');

        foreach ($rows as &$v) {
            //查询商户银行信息
            $bank = M('cashier_bank')->get_one(array('aid'=>$v['aid']));
            $v['banktruename'] = $bank['customerName'];
            $v['bankname'] = $bank['settBankNo'];
            $v['bankcardnum'] = $bank['acctNo'];
            $v['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
        }
        $this->assign('rows',$rows);
        $this->assign('pagebar',$pagebar);
        $this->assign('getdata',$getdata);
        $this->assign('type',1);
        $this->display();
    }

    //代理商已划账
    public function adebit(){
        $getdata = $this->clear_html($_GET);
        $where = " status='2' ";
        if ($getdata['name']) {
            $where .= " AND name like '%" . $getdata['name'] . "%'";
        }
        $start = ((isset($getdata['start']) ? strtotime($getdata['start']." 00:00:00") : 0));
        $end = ((isset($getdata['end']) ? strtotime($getdata['end']." 23:59:59") : 0));

        if (0 < $start) {
            $where .= ' AND addtime>=' . $start;

        }
        if (0 < $end) {
            $where .= ' AND addtime<=' . $end;

        }
        bpBase::loadOrg('common_page');
        $_count = M('cashier_agent_commission')->count($where);
        $p = new Page($_count, 15);
        $pagebar = $p->show(2);
        $rows = M('cashier_agent_commission')->select($where, '*', "$p->firstRow,$p->listRows","addtime DESC");
        $total = 0;
        foreach ($rows as &$v) {
            //查询商户银行信息
            $bank = M('cashier_bank')->get_one(array('aid'=>$v['aid']));
            $v['banktruename'] = $bank['customerName'];
            $v['bankname'] = $bank['settBankNo'];
            $v['bankcardnum'] = $bank['acctNo'];
            $v['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
            $total += $v['count_deposit'];
        }
        $total?$total:$total=0;
        $this->assign('row',$rows);
        $this->assign('type',2);
        $this->assign('total',$total);
        $this->assign('page',$pagebar);
        $this->assign('data',$getdata);
        $this->display('adebit');
    }

    //修改结算记录
    public function aedit(){
        $getdata = $this->clear_html($_GET);
        if(empty($getdata['id'])){
            $this->errorTip('操作失败！', $_SERVER['HTTP_REFERER']);
        }
        else{
            $bank = M('cashier_agent_commission')->get_one(array('id'=>$getdata['id']));

            $this -> assign("bank",$bank);
            $this->display();
        }
    }
    /**
     * 修改代理商冲正
     */
    //获取结算修改提交的数据、
    public function aettx(){
        $id = $_POST['id'];
        $money = $_POST['money'];
        M('cashier_agent_commission')->update(['count_deposit'=>$money],'id='.$id);
        $this->errorTip('修改成功！',"/merchants.php?m=System&c=settlement&a=aset");
    }

    /**
     * 代理商 提现 划账部分
     */
    public function agentdeposit(){
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $huazhangmoney = $_POST['huazhangmoney'];
        $record = M('cashier_agent_commission')->get_one('id='.$id,'*');
//        根据查出的代理商id 查出代理商银行卡号 和身份证信息
        $d=M('cashier_bank')->select(['aid'=>$record['aid']],'*');
        if(empty($record)){
            $this->dexit(array('errcode'=>0,'msg'=>'申请提现记录不存在!'));
        }
//        elseif($record['status'] != 4){
//            $this->dexit(array('errcode'=>0,'msg'=>'提现记录不能重复处理!'));
//        }
        else{
            require_once("./MinShengBank.class.php");//本地
            $bank = new MinShengBank();
            $aid = $record['aid'];//商家编号
            $amount = $huazhangmoney;//申请代付金额
            $dmount = $record['count_deposit'];//代付金额
//            $d = json_decode($record['txt'],true);
            $array = [
                'productId' => "0201",//0201-普通代付；0203-额度代付；0205-信用代付；0211-广东省内代付；（较少使用）；0213-全国代付；（较少使用）
                'orderNo' => date('YmdHis') . SYS_TIME . mt_rand(11111111, 99999999),//订单编号
                'notifyUrl' => "http://".$_SERVER['SERVER_NAME'],//异步地址
                'transAmt' => $amount*100,//订单金额,单位为分*100为元
                'isCompay' => 0,//对公对私标识
                'phoneNo' => $d['phoneNo']?:"",//手机号码，不必填
                'customerName' => $d['customerName'],//账户名
                'cerdType' => $d['cerdType']?:"",//证件类型，不必填
                'cerdId' => $d['cerdId']?:"",//证件号，不必填
                'settBankNo' => $d['settBankNo']?:"",//清算行号 产品0211、0213时必须填写
                'accBankNo' => $d['accBankNo']?:"",//开户行号 产品 0213全国代付时必须填写
                'accBankName' => $d['accBankName']?:"",//开户行名称 产品0211、0213，如accBankNo、settBankNo无法填写时，则必须填写该字段
                'bankType' => $d['bankType']?:"",//银行类别 产品0211、0213，如accBankNo、settBankNo无法填写时，则必须填写该字段
                'addrName' => $d['addrName']?:"",//地区名称 产品0211、0213，如accBankNo、settBankNo无法填写时，则必须填写该字段
                'busiType' => $d['busiType']?:"",//业务类型 产品0211、0213时填写
                'acctNo' => $d['acctNo'],//银行卡号
                'note' => $d['note']?:"",//备注，不必填
            ];
            $str = ($bank -> daifu($array));
//            $str['respCode'] = "0000" ;
//            $str['respDesc'] = "交易成功";
            if($str['respCode'] == "0000" && $str['respDesc'] == "交易成功"){
                if($amount<=$dmount){

                    //修改划账金额
                    M('cashier_agent_commission')->update(array("count_deposit"=>$dmount-$amount),array("aid"=>$aid,"status"=>4,'count_deposit'=>$dmount));
                     //查出代理商 还剩多少金额没有划账 如果金额为0就把所有状态更改
                    $data=M('cashier_agent_commission')->select(['aid'=>$aid,'status'=>4],'*');
                    if ($data[0]['count_deposit']<=0) {
                        M('cashier_agent_commission')->update(["status"=>2],["aid"=>$aid,"status"=>3]);
                        M('cashier_agent_commission')->delete(["aid"=>$aid,"status"=>4]);
                    }

                }
                $this->dexit(array('errcode'=>1,'msg'=>'划账成功!'));
            }
            else{
                $this->dexit(array('errcode'=>0,'errmsg'=>$str['respDesc']));
            }
        }
    }
    //提现
    public function cash(){
        $data = $_POST;
        if(!empty($data)){
            $bank = M('cashier_platform_bank')->get_one(array('id'=>1),'*');
            if(empty($bank)){
                $data2 = $data;
                $data2['id'] = 1;
                unset($data2['transAmt']);
                $result = M('cashier_platform_bank')->insert($data2);
                if(empty($result)){
                    die("error!");
                }
            }
            else{
                M('cashier_platform_bank')->update($data,array("id"=>1));
            }
            require_once("./MinShengBank.class.php");
            $bank = new MinShengBank();
            $data['orderNo'] = date("YmdHis").rand(10000,99999);
            $data['notifyUrl'] = "http://".$_SERVER['SERVER_NAME']."/";
            $data['note'] = "平台提现";//备注
            $data2 = $data;
            $data2['time'] = date("Y-m-d H:i:s");
            unset($data2['notifyUrl']);
            unset($data2['note']);
            $re = M("cashier_platform_cash") -> insert($data2);
            if($re){
                $data['transAmt'] *= 100;
                $data['productId'] = "0201";//0201-普通代付；0203-额度代付；0205-信用代付；0211-广东省内代付；（较少使用）；0213-全国代付；（较少使用）
                $str = ($bank -> daifu($data));
//                $str['respCode'] = "0000" ;
//                $str['respDesc'] = "交易成功";
                if($str['respCode'] == "0000" && $str['respDesc'] == "交易成功"){
                    $result = M('cashier_platform_cash')->update(array("status"=>1),array("orderNo"=>$data['orderNo']));//修改代付状态
                    $this->errorTip('划账成功！', $_SERVER['HTTP_REFERER']);
                }
                else{
                    $this->errorTip('划账失败！', $_SERVER['HTTP_REFERER']);
                }
            }
            else{
                $this->errorTip('划账失败！', $_SERVER['HTTP_REFERER']);
            }
        }
        $bank = M('cashier_platform_bank')->get_one(array('id'=>1),'*');
        $this -> assign("bank",$bank);
        $this->display();
    }
    //提现记录
    public function cashlist(){
        $data = $this->clear_html($_GET);
        $where = "1";
        if($data['txt']){
            $txt = $data['txt'];
            $where .= " AND (customerName LIKE '%$txt%' OR acctNo LIKE '%$txt%' OR phoneNo LIKE '%$txt%')";
        }
        if($data['start']){
            $start = $data['start']." 00:00:00";
        }
        else{
            $data['start'] = date("Y-m-d");
            $start = date("Y-m-d 00:00:00");
        }
        if($data['end']){
            $end = $data['end']." 23:59:59";
        }
        else{
            $data['end'] = date("Y-m-d");
            $end = date("Y-m-d 23:59:59");
        }
        $where .= " AND time >= '$start' AND time <= '$end'";
        bpBase::loadOrg('common_page');
        $_count = $rows = M("cashier_platform_cash")->count($where);
        $p = new Page($_count, 15);
        $pagebar = $p->show(2);
        $rows = M("cashier_platform_cash") -> select($where,"*","$p->firstRow,$p->listRows","id DESC");
        $order_sql = "SELECT sum(transAmt) FROM `cqcjcm_cashier_platform_cash` where ".$where;
        $sum = M('cashier_platform_cash')->selectBySql($order_sql);
        $total = $sum[0]["sum(transAmt)"];
        $this -> assign("total",$total);
        $this -> assign("rows",$rows);
        $this -> assign("data",$data);
        $this->assign('pagebar',$pagebar);
        $this -> display();
    }
    //代理商已划账
    public function debit(){
        $getdata = $this->clear_html($_GET);
        $where = " type='1' AND status='1' ";
        if ($getdata['name']) {
            $where .= " AND name like '%" . $getdata['name'] . "%'";
        }
        $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
        $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));

        if (0 < $start) {
            $where .= ' AND addtime>=' . $start;

        }
        if (0 < $end) {
            $where .= ' AND addtime<=' . $end;

        }
        bpBase::loadOrg('common_page');
        $_count = $this->model->count($where);
        $p = new Page($_count, 15);
        $pagebar = $p->show(2);
        $rows = $this->model->select($where, '*', "$p->firstRow,$p->listRows",'addtime desc');
        foreach ($rows as &$v) {
            $agent = M('cashier_agent')->get_one(array('aid'=>$v['settleid']),'bankcard');
            $json = json_decode($agent['bankcard'],true);
            $v['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
            $v['owner'] = $json['owner'];
            $v['bankname'] = $json['bankname'];
            $v['bankid'] = $json['bankid'];
            $total += $v['money'];
        }
        $total?$total:$total=0;
        $this->assign('row',$rows);
        $this->assign('type',2);
        $this->assign('total',$total);
        $this->assign('page',$pagebar);
        $this->assign('data',$getdata);
        $this->display('aset');
    }
    //代理商划账
    public function setdebit(){
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $record = $this->model->get_one('id='.$id,'*');
        if(empty($record)){
            $this->dexit(array('errcode'=>0,'msg'=>'申请提现记录不存在!'));
        }
        //查询代理商信息
        $agent = M('cashier_agent')->get_one(array('aid'=>$record['settleid']),'account,bankcard');
        $bankcard = json_decode($agent['bankcard'],true);
        $str = $bankcard['bankname'].' ('.substr($bankcard['bankid'],-4).') '.$bankcard['owner'];
        if($this->model->update(array('status'=>1),'id='.$id)){
            $price = $record['money'];
            $url = $this->SiteUrl.'/admin.php';
            bpBase::loadOrg('Email');
            $email = new Email();
            $subject = "重庆云极付有限公司打款通知";//设置邮箱标题
            $address = $agent['account'];//需要发送的邮箱地址
            $content = <<<ETC
                <div style="width: 80%; background: #FFFFFF;">
        			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
        			<p style="padding-left:30px;">你申请的提现金额: $price ,已转账到: $str ,请注意查收</p>
        		</div>
ETC;
            $res = $email->send_email($address,$subject,$content);
            $this->dexit(array('errcode'=>1,'msg'=>'划账成功!'));
        }else{
            $this->dexit(array('errcode'=>0,'msg'=>'划账失败!'));
        }
    }

    //商户结算
    public function mset(){
        $getdata = $this->clear_html($_GET);
        $where = " status='0' ";
        if ($getdata['name']) {
            $where .= " AND username like '%" . $getdata['name'] . "%'";
        }
        $start = ((isset($getdata['start']) ? strtotime($getdata['start']." 00:00:00") :0));
        $end = ((isset($getdata['end']) ? strtotime($getdata['end']." 23:59:59") : 0));

        if (0 < $start) {
            $where .= ' AND addtime>=' . $start;
        }
        if (0 < $end) {
            $where .= ' AND addtime<=' . $end;
        }
        bpBase::loadOrg('common_page');
        $_count = M('cashier_msettlement')->count($where);
        $p = new Page($_count, 15);
        $pagebar = $p->show(2);
        $rows = M('cashier_msettlement')->select($where, '*', "$p->firstRow,$p->listRows",'addtime desc');
        foreach ($rows as &$v) {
            //查询商户银行信息
            $bank = M('cashier_bank')->get_one(array('mid'=>$v['mid']));
            $v['banktruename'] = $bank['customerName'];
            $v['bankname'] = $bank['settBankNo'];
            $v['bankcardnum'] = $bank['acctNo'];
            $v['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
        }
        $this->assign('rows',$rows);
        $this->assign('pagebar',$pagebar);
        $this->assign('getdata',$getdata);
        $this->assign('type',1);
        $this->display();
    }
    //修改结算记录
    public function medit(){
        $getdata = $this->clear_html($_GET);
        if(empty($getdata['id'])){
            $this->errorTip('操作失败！', $_SERVER['HTTP_REFERER']);
        }
        else{
            $bank = M('cashier_msettlement')->get_one(array('id'=>$getdata['id']));
            $this -> assign("bank",$bank);
            $this->display();
        }
    }
    //获取结算修改提交的数据、
    public function settx(){
        $id = $_POST['id'];
        $money = $_POST['money'];
        $msettlement = M('cashier_msettlement')->get_one(array('id'=>$id));
        $msettlement['money'] = round($money,2);
        $mid = $msettlement['mid'];
        $bank = M('cashier_bank')->get_one(array('mid'=>$mid));
        $data = json_decode($msettlement['txt'],true);
        $txt = array(
            "commission" => $data['commission'],
            "amount" => $money,
            "phoneNo" =>  $bank['phoneNo'],
            "customerName" =>  $bank['customerName'],
            "cerdType" =>  $bank['cerdType'],
            "cerdId" =>  $bank['cerdId'],
            "settBankNo" => $bank['settBankNo'],
            "accBankNo" => $bank['accBankNo'],
            "accBankName" => $bank['accBankName'],
            "bankType" => $bank['bankType'],
            "addrName" => $bank['addrName'],
            "busiType" => $bank['busiType'],
            "acctNo" =>  $bank['acctNo'],
            "isCompay" => $bank['isCompay'],
        );
        $msettlement['txt'] = json_encode($txt, JSON_UNESCAPED_UNICODE);
        M('cashier_msettlement')->update($msettlement,'id='.$id);
        $this->errorTip('修改成功！',"/merchants.php?m=System&c=settlement&a=mset");
    }
    //商户已划账
    public function mdebit(){
        $getdata = $this->clear_html($_GET);
        $where = " status='1' ";
        if ($getdata['name']) {
            $where .= " AND username like '%" . $getdata['name'] . "%'";
        }
        $start = ((isset($getdata['start']) ? strtotime($getdata['start']." 00:00:00") : 0));
        $end = ((isset($getdata['end']) ? strtotime($getdata['end']." 23:59:59") : 0));

        if (0 < $start) {
            $where .= ' AND addtime>=' . $start;

        }
        if (0 < $end) {
            $where .= ' AND addtime<=' . $end;

        }
        bpBase::loadOrg('common_page');
        $_count = M('cashier_msettlement')->count($where);
        $p = new Page($_count, 15);
        $pagebar = $p->show(2);
        $rows = M('cashier_msettlement')->select($where, '*', "$p->firstRow,$p->listRows","addtime DESC");
        $total = 0;
        foreach ($rows as &$v) {
            //查询商户银行信息
            $bank = M('cashier_bank')->get_one(array('mid'=>$v['mid']));
            $v['banktruename'] = $bank['customerName'];
            $v['bankname'] = $bank['settBankNo'];
            $v['bankcardnum'] = $bank['acctNo'];
            $v['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
            $total += $v['money'];
        }
        $total?$total:$total=0;
        $this->assign('row',$rows);
        $this->assign('type',2);
        $this->assign('total',$total);
        $this->assign('page',$pagebar);
        $this->assign('data',$getdata);
        $this->display('mdebit');
    }

    //商户划账
    public function setmdebit(){
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $record = M('cashier_msettlement')->get_one('id='.$id,'*');
        if(empty($record)){
            $this->dexit(array('errcode'=>0,'msg'=>'申请提现记录不存在!'));
        }
        if(M('cashier_msettlement')->update(array('status'=>1),'id='.$id)){
            $this->dexit(array('errcode'=>0,'msg'=>'划账失败!'));
            exit;
            //查询代理商信息
            $agent = M('cashier_merchants')->get_one(array('mid'=>$record['mid']),'username');
            //查询商户银行信息
            $bank = M('cashier_bank')->get_one(array('mid'=>$v['mid']));
            $str = $bank['bankname'].' ('.substr($bank['bankcardnum'],-4).') '.$bank['banktruename'];
            $price = $record['money'];
            $url = $this->SiteUrl.'/index.php';
            bpBase::loadOrg('Email');
            $email = new Email();
            $subject = "重庆云极付有限公司打款通知";//设置邮箱标题
            $address = $agent['username'];//需要发送的邮箱地址
            $content = <<<ETC
                <div style="width: 80%; background: #FFFFFF;">
        			<h1 style="font-weight: normal; width: 100%;  font-size: 18px;">尊敬的顾客:您好</h1>
        			<p style="padding-left:30px;">你申请的提现金额: $price ,已转账到: $str ,请注意查收</p>
        		</div>
ETC;
            $res = $email->send_email($address,$subject,$content);
            $this->dexit(array('errcode'=>1,'msg'=>'划账成功!'));
        }else{
            $this->dexit(array('errcode'=>0,'msg'=>'划账失败!'));
        }
    }
    public function banksetmdebit(){
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $huazhangmoney = $_POST['huazhangmoney'];
        // $ss=M('cashier_wxcoupon_receive')->insert(array("openid"=>$huazhangmoney),true);
        // exit();
//        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $record = M('cashier_msettlement')->get_one('id='.$id,'*');
        if(empty($record)){
            $this->dexit(array('errcode'=>0,'msg'=>'申请提现记录不存在!'));
        }
        elseif($record['status'] != 0){
            $this->dexit(array('errcode'=>0,'msg'=>'提现记录不能重复处理!'));
        }
        else{
           $whichtype=M('cashier_merchants')->get_one(array('mid'=>$record['mid']),'mtype');
           $whichtype=current($whichtype);
           if($whichtype==2)
           {
               require_once("./MinShengBank.class.php");//本地
               $bank = new MinShengBank();
               $mid = $record['mid'];//商家编号
               $amount = $huazhangmoney;//申请代付金额
               $dmount = $record['money'];//代付金额
               $d = json_decode($record['txt'],true);
               if($d['isCompay']=='0'){
                   $productId='0201';
               }
               else{
                   $productId='0213';
               }
               $array = [
                   'productId' => $productId,//0201-普通代付；0203-额度代付；0205-信用代付；0211-广东省内代付；（较少使用）；0213-全国代付；（较少使用）
                   'orderNo' => date('YmdHis') . SYS_TIME . mt_rand(11111111, 99999999),//订单编号
                   'notifyUrl' => "http://".$_SERVER['SERVER_NAME'],//异步地址
                   'transAmt' => $amount*100,//订单金额,单位为分*100为元
                   'isCompay' => $d['isCompay'],//对公对私标识
                   'phoneNo' => $d['phoneNo']?:"",//手机号码，不必填
                   'customerName' => $d['customerName'],//账户名
                   'cerdType' => $d['cerdType']?:"",//证件类型，不必填
                   'cerdId' => $d['cerdId']?:"",//证件号，不必填
                   'settBankNo' => $d['settBankNo']?:"",//清算行号 产品0211、0213时必须填写
                   'accBankNo' => $d['accBankNo']?:"",//开户行号 产品 0213全国代付时必须填写
                   'accBankName' => $d['accBankName']?:"",//开户行名称 产品0211、0213，如accBankNo、settBankNo无法填写时，则必须填写该字段
                   'bankType' => $d['bankType']?:"",//银行类别 产品0211、0213，如accBankNo、settBankNo无法填写时，则必须填写该字段
                   'addrName' => $d['addrName']?:"",//地区名称 产品0211、0213，如accBankNo、settBankNo无法填写时，则必须填写该字段
                   'busiType' => $d['busiType']?:"",//业务类型 产品0211、0213时填写
                   'acctNo' => $d['acctNo'],//银行卡号
                   'note' => $d['note']?:"",//备注，不必填
               ];
               
               $str = $bank -> daifu($array);
               //            $str['respCode'] = "0000" ;
               //            $str['respDesc'] = "交易成功";
               if($str['respCode'] == "0000" && $str['respDesc'] == "交易成功"){
                   if($amount<$dmount){
               
                       //修改划账金额
                       $hzmoney=M('cashier_msettlement')->update(array("money"=>$dmount-$amount),array("mid"=>$mid,"status"=>0,'money'=>$dmount));
               
                       // 查询商家申请提现信息
                       $msettlement = M('cashier_msettlement')->get_one(array('id'=>$id));
               
                       // 获取商家ID
                       $mid = $msettlement['mid'];
               
                       // 查询商家银行卡信息
                       $bank = M('cashier_bank')->get_one(array('mid'=>$mid));
               
                       // json解码商家提现信息字段txt
                       $data = json_decode($msettlement['txt'],true);
               
                       $txt = array(
                           "commission" => $data['commission'],
                           "amount" => $amount,
                           "phoneNo" =>  $bank['phoneNo'],
                           "customerName" =>  $bank['customerName'],
                           "cerdType" =>  $bank['cerdType'],
                           "cerdId" =>  $bank['cerdId'],
                           "settBankNo" => $bank['settBankNo'],
                           "accBankNo" => $bank['accBankNo'],
                           "accBankName" => $bank['accBankName'],
                           "bankType" => $bank['bankType'],
                           "addrName" => $bank['addrName'],
                           "busiType" => $bank['busiType'],
                           "acctNo" =>  $bank['acctNo'],
                           "isCompay" => $bank['isCompay'],
                       );
               
                       //新增划账记录
                       $addjl=M('cashier_msettlement')->insert(array("mid"=>$mid,"username"=>$record['username'],"addtime"=>time(),"money"=>$amount,"money2"=>$record['money2'],"status"=>1,"txt"=>$txt),array("id"=>$id));
                   }
               
                   $result = M('cashier_msettlement')->update(array("status"=>1,"addtime"=>time()),array("mid"=>$mid,"status"=>0,'money'=>$dmount));//修改提现状态
                   $this->dexit(array('errcode'=>1,'msg'=>'划账成功!'));
               }
               if($str['respCode'] == "P000"||$str['respCode'] == "9999"||$str['respCode'] == "9997"){
                   $chaxun=$bank->queryOrder($str['orderNo'],$str['orderTime']);
                   if ($chaxun['respCode']=="0000"&&$chaxun['origRespCode']="0000"){
                       if($amount<$dmount){
               
                           //修改划账金额
                           $hzmoney=M('cashier_msettlement')->update(array("money"=>$dmount-$amount),array("mid"=>$mid,"status"=>0,'money'=>$dmount));
               
                           // 查询商家申请提现信息
                           $msettlement = M('cashier_msettlement')->get_one(array('id'=>$id));
               
                           // 获取商家ID
                           $mid = $msettlement['mid'];
               
                           // 查询商家银行卡信息
                           $bank = M('cashier_bank')->get_one(array('mid'=>$mid));
               
                           // json解码商家提现信息字段txt
                           $data = json_decode($msettlement['txt'],true);
               
                           $txt = array(
                               "commission" => $data['commission'],
                               "amount" => $amount,
                               "phoneNo" =>  $bank['phoneNo'],
                               "customerName" =>  $bank['customerName'],
                               "cerdType" =>  $bank['cerdType'],
                               "cerdId" =>  $bank['cerdId'],
                               "settBankNo" => $bank['settBankNo'],
                               "accBankNo" => $bank['accBankNo'],
                               "accBankName" => $bank['accBankName'],
                               "bankType" => $bank['bankType'],
                               "addrName" => $bank['addrName'],
                               "busiType" => $bank['busiType'],
                               "acctNo" =>  $bank['acctNo'],
                               "isCompay" => $bank['isCompay'],
                           );
               
                           //新增划账记录
                           $addjl=M('cashier_msettlement')->insert(array("mid"=>$mid,"username"=>$record['username'],"addtime"=>time(),"money"=>$amount,"money2"=>$record['money2'],"status"=>1,"txt"=>$txt),array("id"=>$id));
                       }
                       $result = M('cashier_msettlement')->update(array("status"=>1,"addtime"=>time()),array("mid"=>$mid,"status"=>0,'money'=>$dmount));//修改提现状态
                       $this->dexit(array('errcode'=>1,'msg'=>'划账成功!'));
                   }
                   else{
                       $this->dexit(array('errcode'=>0,'errmsg'=>$str['respDesc']));
                   }
               }
               else{
                   $this->dexit(array('errcode'=>0,'errmsg'=>$str['respDesc']));
               }
           }else if ($whichtype==3)
           {
               $mid = $record['mid'];//商家编号
               $qrcode=M('cashier_qrcode')->get_one(array('mid'=>$mid),'qrcode_id');
               $qrcode=$qrcode['qrcode_id'];
               $bank=M('cashier_bank')->get_one(array('mid'=>$mid));
               $amount = $huazhangmoney;//申请代付金额
               $dmount = $record['money'];//代付金额
               $rmount=$amount<=$dmount?$amount:$dmount;
               $url = 'http://pay.51jihua.net/merchants.php?m=pay&c=jhzdf&a=jdf';  //调用接口的平台服务地址
               $post_string = array(
                   'ewmid'=>$qrcode
                   ,'acct_id'=>$bank['cerdId']
                   ,'acct_name'=>$bank['customerName']
                   ,'mobile'=>$bank['phoneNo']
                   ,'amount'=>$rmount
                   ,'bank_settle_no'=>$bank['settBankNo']
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
                   
                   $this->dexit(array('errcode'=>1,'msg'=>'划账成功!'));
               }else
               {
                   $this->dexit(array('errcode'=>0,'errmsg'=>$str['respDesc']));
               }
               curl_close($ch);
           }            
        }
    }


    //data2Excel导出excel文件
    public function data2Excel(){
        $getdata = $this->clear_html($_GET);


        $data =array();
        $i==0;
        switch ($getdata['type']) {
            case 'agent':
                $where = array('status'=>0,'type'=>1);
                $agent = $this->model->select($where,'*');

                foreach ($agent as $K => $v) {
                    $data[$i]['name'] = $v['name'];
                    $data[$i]['money'] = $v['money'];
                    $data[$i]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
                    $data[$i]['status'] = '未划账';
                    $i++;
                }
                $title = array('代理商','金额','发起提现时间','状态');
                $filename = '代理商未划账表'.date('Y-m-d H',time()).'.xls';
                break;
            case 'agentb':
                $where = array('status'=>1,'type'=>1);
                $agentb = $this->model->select($where,'*');
                foreach ($agentb as $K => $v) {

                    $data[$i]['name'] = $v['name'];
                    $data[$i]['money'] = $v['money'];
                    $data[$i]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
                    $data[$i]['status'] = '已划账';
                    $i++;

                }

                $title = array('代理商','金额','发起提现时间','状态');
                $filename = '代理商已划账表'.date('Y-m-d H',time()).'.xls';
                break;
            case 'mch':
                $where = array('status'=>0);
                $mch = M('cashier_msettlement')->select($where,'*');
                foreach ($mch as $K => $v) {
                    $data[$i]['name'] = $v['username'];
                    $data[$i]['money'] = $v['money'];
                    $data[$i]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
                    $data[$i]['status'] = '未划账';
                    $i++;
                }
                $title = array('商户','金额','发起提现时间','状态');
                $filename = '商户未划账表'.date('Y-m-d H',time()).'.xls';
                break;
            case 'mchb':
                $where = array('status'=>1);
                $mchb = M('cashier_msettlement')->select($where,'*');

                foreach ($mchb as $K => $v) {
                    $data[$i]['name'] = $v['username'];
                    $data[$i]['money'] = $v['money'];
                    $data[$i]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
                    $data[$i]['status'] = '已划账';
                    $i++;
                }


                $title = array('商户','金额','发起提现时间','状态');
                $filename = '商户已划账表'.date('Y-m-d H',time()).'.xls';
                break;

            default:
                $data=array();
                $title='';
                $filename='空文件.xls';
                break;
        }
        //导出
        $this->ExportTable($data,$title,$filename);
    }
    //商户银行卡
    public function mbank(){
        $getdata = $this->clear_html($_GET);
        $where = " mid!=0 ";
        if ($getdata['mid']) {
            $where .= " AND mid = '" . $getdata['mid'] . "'";

        }
        bpBase::loadOrg('common_page');
        $_count = M("cashier_bank")->count($where);
        $p = new Page($_count, 15);
        $pagebar = $p->show(2);

        $bank = M("cashier_bank")->select( $where,'*', "$p->firstRow,$p->listRows",'id desc');
        $total = count($bank);
        foreach($bank as $k => $b){
            $mid = $b['mid'];
            $shop = M("cashier_merchants") -> get_one(array("mid"=>$mid),"*");

            $bank[$k]['company'] = $shop['company'];
        }
        $this -> assign("bank",$bank);
        $this -> assign("page",$pagebar);
        $this -> assign("total",$total);
        $this -> display("mbank");
    }


    //代理银行卡
    public function abank(){
        $getdata = $this->clear_html($_GET);

        $where = " aid!=0 ";
        if ($getdata['aid']) {

            $where .= " AND aid = '" . $getdata['aid'] . "'";

        }

        bpBase::loadOrg('common_page');
        $_count = M("cashier_bank")->count($where);
        $p = new Page($_count, 15);
        $pagebar = $p->show(2);

        $bank = M("cashier_bank")->select( $where,'*', "$p->firstRow,$p->listRows",'id desc');
        $total = count($bank);
        foreach($bank as $k => $b){
            $aid = $b['aid'];
            $shop = M("cashier_agent") -> get_one(array("aid"=>$aid),"*");

            $bank[$k]['uname'] = $shop['uname'];
        }
        $this -> assign("bank",$bank);
        $this -> assign("page",$pagebar);
        $this -> assign("total",$total);
        $this -> display("abank");
    }

    public function setmbank(){
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if(empty($id)){
            $this->dexit(array('errcode'=>0,'msg'=>'数据错误，请刷新后再试!'));
        }
        $bank = M("cashier_bank") -> get_one(array("id"=>$id),"*");
        if(empty($bank)){
            $this->dexit(array('errcode'=>0,'msg'=>'数据不存在，请刷新后再试!'));
        }
        $data = array();
        $data['bank'] = 1;
        $data['bankmsg'] = "";
        $r = M("cashier_bank") -> update($data,array("id"=>$id));
        if($r){
            $this->dexit(array('errcode'=>1,'msg'=>'审核通过!'));
        }else{
            $this->dexit(array('errcode'=>0,'msg'=>'操作失败!'));
        }
    }
    public function setmbank2(){
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $bankmsg = isset($_POST['bankmsg']) ? $_POST['bankmsg'] : "";
        if(empty($id)){
            $this->dexit(array('errcode'=>0,'msg'=>'数据错误，请刷新后再试!'));
        }
        if(empty($bankmsg)){
            $this->dexit(array('errcode'=>0,'msg'=>'数据错误，必须填写失败原因!'.$bankmsg));
        }
        $bank = M("cashier_bank") -> get_one(array("id"=>$id),"*");
        if(empty($bank)){
            $this->dexit(array('errcode'=>0,'msg'=>'数据不存在，请刷新后再试!'));
        }
        $data = array();
        $data['bank'] = 2;
        $data['bankmsg'] = $bankmsg;
        $r = M("cashier_bank") -> update($data,array("id"=>$id));
        if($r){
            $this->dexit(array('errcode'=>1,'msg'=>'操作成功!'));
        }else{
            $this->dexit(array('errcode'=>0,'msg'=>'操作失败!'));
        }
    }
    public function card(){
        $id = $_GET['id'];
        $bank = M("cashier_bank") -> get_one(array("id"=>$id),"*");
        $this -> assign("bank",$bank);
        $this -> display();
    }

    //划账选择银行卡
    public function banklist(){
        $mid = $_GET['mid'];
        $bank = M("cashier_bank") -> select(array("mid"=>$mid),"*");
        $this -> dexit($bank);
    }

    //生成划账单
    public function orderlist(){
        $id=$_POST['id'];
        $mid=$_POST['mid'];
        $money2=$_POST['money2'];
        $bankid=$_POST['bankid'];
        $commission_sql="SELECT commission
          FROM `cqcjcm_cashier_merchants`
          WHERE mid={$mid}";
        $commission = M('cashier_merchants')->selectBySql($commission_sql);
        $bank = M('cashier_bank')->get_one(['id'=>$bankid], "*");
        $data['commission'] = $commission[0]['commission'];//费率
        $data['amount'] = $money2;//需结算的金额
        $data['phoneNo'] = $bank['phoneNo'];
        $data['customerName'] = $bank['customerName'];
        $data['cerdType'] = $bank['cerdType'];
        $data['cerdId'] = $bank['cerdId'];
        $data['settBankNo'] = $bank['settBankNo2'];
        $data['accBankNo'] = $bank['accBankNo'];
        $data['accBankName'] = $bank['accBankName'];
        $data['bankType'] = $bank['bankType'];
        $data['addrName'] = $bank['addrName'];
        $data['busiType'] = $bank['busiType'];
        $data['acctNo'] = $bank['acctNo'];
        $data['isCompay'] = $bank['isCompay'];
        $mset = json_encode($data, JSON_UNESCAPED_UNICODE);
        $result = M('cashier_msettlement')->update(['txt'=>$mset],['id'=>$id]);
        if($result){
            echo "划账单添加成功";
        }
    }


    //鐢宠鎻愮幇璁板綍
    public function cashapply(){
        if($_GET['action']=='success')
        {
            $getdata = $this->clear_html($_GET);
            $where = " status='2'";
            if ($getdata['name']) {
                $where .= " AND username like '%" . $getdata['name'] . "%'";
            }
            $start = ((isset($getdata['start']) ? strtotime($getdata['start']." 00:00:00") :0));
            $end = ((isset($getdata['end']) ? strtotime($getdata['end']." 23:59:59") : 0));
    
            if (0 < $start) {
                $where .= ' AND addtime>=' . $start;
            }
            if (0 < $end) {
                $where .= ' AND addtime<=' . $end;
            }
            bpBase::loadOrg('common_page');
            $_count = M('cashier_msettlement')->count($where);
            $p = new Page($_count, 15);
            $pagebar = $p->show(2);
            $rows = M('cashier_another')->select($where, '*', "$p->firstRow,$p->listRows",'addtime desc');
                 $sum_money=0;
                	foreach ($rows as $v) {
                        $sum_money+=$v['money'];
                	}
        	$this->assign('sum_money',$sum_money);
            $this->assign('rows',$rows);
            $this->assign('pagebar',$pagebar);
            $this->assign('getdata',$getdata);
            //     	$this->assign('type',1);
            $this->display();
        }else
        {
            $getdata = $this->clear_html($_GET);
            $where = " status='1'";
            if ($getdata['name']) {
                $where .= " AND username like '%" . $getdata['name'] . "%'";
            }
            $start = ((isset($getdata['start']) ? strtotime($getdata['start']." 00:00:00") :0));
            $end = ((isset($getdata['end']) ? strtotime($getdata['end']." 23:59:59") : 0));
    
            if (0 < $start) {
                $where .= ' AND addtime>=' . $start;
            }
            if (0 < $end) {
                $where .= ' AND addtime<=' . $end;
            }
            bpBase::loadOrg('common_page');
            $_count = M('cashier_msettlement')->count($where);
            $p = new Page($_count, 15);
            $pagebar = $p->show(2);
            $rows = M('cashier_another')->select($where, '*', "$p->firstRow,$p->listRows",'addtime desc');
            $sum_money=0;
                	foreach ($rows as $v) {
                        $sum_money+=$v['money'];
                	}
            $this->assign('rows',$rows);
            $this->assign('pagebar',$pagebar);
            $this->assign('getdata',$getdata);
            //     	$this->assign('type',1);
            $this->display();
        }
         
    }
    
}


?>