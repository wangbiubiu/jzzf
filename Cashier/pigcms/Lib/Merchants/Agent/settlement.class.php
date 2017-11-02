<?php

bpBase::loadAppClass('common', 'Agent', 0);
bpBase::loadOrg('common_page');

class settlement_controller extends common_controller
{

    private $SalesmanDb;
    protected $aid;
    public $id;
    public $arr;

    public function __construct()
    {
        parent::__construct();
        $this->aid = $_SESSION['my_Cashier_Agent']['aid'];
    }


    public function index()
    {
//        时间转化每月1开始   到 每月月底
        $start = strtotime("-1 months", strtotime(date('Y-m-01 00:00:00', strtotime(date("Y-m-d")))));//上一月开始时间
       
       $end =  strtotime(date('Y-m-01 00:00:00', strtotime(date("Y-m-d"))));//上一月月底时间
//        var_dump(date('y-m-d',$end));die;
        $date = date('Ym', strtotime('-1 month'));
        if (time() > $end) {
            $result = M('cashier_agent_commission')->select(['aid' => $this->aid, 'date' => $date], '*');

            if (empty($result)) {
//        1.查出 代理商的商家费率
                $agent = M('cashier_agent')->select(['aid' => $this->aid], 'commission,alicommission,ancommission,analicommission,wxcommission,qqcommission');

//        2查出 商家的 MId 微信费率 和 支付宝费率
//        $shanjiaSQL="select mid,mtype,commission,alicommission from cqcjcm_cashier_merchants where aid =$this->aid";
                $merchant = M('cashier_merchants')->select(['aid' => $this->aid], 'mid,company,mtype,commission,alicommission,qqcommission');
//        dump($merchant);exit();
                $teiwxyongjing = 0;//特约 商户微信佣金
                $teialiyongjing = 0;//特约 商户支付宝佣金
                $yinwxyongjing = 0;//银行 商户微信佣金
                $yinaliyongjing = 0;//银行 支付宝佣金
                $jhzwxyongjing=0;//金海哲用户微信佣金
                $jhzqqyongjing=0;//金海哲用户qq佣金
                $jinhaizhe=[];//金海哲用户
                $count_money = 0;
                $contributings = [];//特约商户
                $bankings = [];//银行商户
                foreach ($merchant as $v) {
                    if ($v['mtype'] == 1) {//等于一表示特约商户

                        $wxrate = $v['commission'] - $agent[0]['commission'];//计算出代理商的微信 佣金费率
                        
                        $alirate = $v['alicommission'] - $agent[0]['alicommission'];//计算出代理商的支付宝 佣金费率
//                拼接查出微信 的sql
                        $wxsql = "mid={$v['mid']} AND ispay=1 AND pay_way='weixin' AND paytime > {$start} AND paytime<{$end}";
//                拼接查出 支付宝的sql
                        $alisql = "mid={$v['mid']} AND ispay=1 AND pay_way='alipay' AND paytime > {$start} AND paytime<{$end}";

//                查出门店下微信的所有支付流水
                        $wxliushui = M('cashier_order')->select($wxsql, 'round(sum(income),2)as income ');
                        $count_money = $count_money + $wxliushui[0]['income'];
                        //查出微信的所有价格保存到数组中
//                if (!empty($wxliushui[0]['income'])) {
                        $contributing = ['company' => $v['company'], 'wx_money' => $wxliushui[0]['income'], 'type' => '1', 'mid' => $v['mid']];
//                }
                        //累计相加 出微信佣金
                        $teiwxyongjing = $teiwxyongjing + $wxliushui[0]['income'] * $wxrate;
//                查出门店下支付宝的所有支付流水
                        $aliliushui = M('cashier_order')->select($alisql, 'round(sum(income),2)as income ');
                        $count_money = $count_money + $aliliushui[0]['income'];

                        $contributings[] = [
                            'company' => $contributing['company'],
                            'wx_money' => $contributing['wx_money'],
                            'wxrate' => $wxrate,
                            'wx_brokerage' => $contributing['wx_money'] * $wxrate,
                            'alirate' => $alirate,
                            'ali_money' => $aliliushui[0]['income'],
                            'ali_brokerage' => $aliliushui[0]['income'] * $alirate,
                            'type' => $contributing['type'],
                            'mid' => $contributing['mid']
                        ];

                        //累计相加 出支付宝佣金
                        $teialiyongjing = $teialiyongjing + $aliliushui[0]['income'] * $alirate;
                    } else if($v['mtype']==2){

//                银行直连商户
                        $wxrate = $v['commission'] - $agent[0]['ancommission'];//计算出代理商的微信 佣金费率
                        $alirate = $v['alicommission'] - $agent[0]['analicommission'];//计算出代理商的支付宝 佣金费率
//                拼接查出微信 的sql
                        $wxsql = "mid={$v['mid']} AND ispay=1 AND pay_way='weixin' AND paytime > {$start} AND paytime<{$end}";

//                拼接查出 支付宝的sql
                        $alisql = "mid={$v['mid']} AND ispay=1 AND pay_way='alipay' AND paytime > {$start} AND paytime<{$end}";
//                查出门店下微信的所有支付流水
                        $wxliushui = M('cashier_order')->select($wxsql, 'round(sum(income),2)as income ');
                        $count_money = $count_money + $wxliushui[0]['income'];
//                if (!empty($wxliushui[0]['income'])) {
                        //查出微信的所有价格保存到数组中
                        $banking = ['company' => $v['company'], 'wx_money' => $wxliushui[0]['income'], 'type' => '2', 'mid' => $v['mid']];
//                }
                        //累计相加 出微信佣金
                        $yinwxyongjing = $yinwxyongjing + $wxliushui[0]['income'] * $wxrate;
//                查出门店下支付宝的所有支付流水
                        $aliliushui = M('cashier_order')->select($alisql, 'round(sum(income),2)as income ');
                        $count_money = $count_money + $aliliushui[0]['income'];
                        $bankings[] = [
                            'company' => $banking['company'],
                            'wx_money' => $banking['wx_money'],
                            'wxrate' => $wxrate,
                            'wx_brokerage' => $banking['wx_money'] * $wxrate,
                            'alirate' => $alirate,
                            'ali_money' => $aliliushui[0]['income'],
                            'ali_brokerage' => $aliliushui[0]['income'] * $alirate,
                            'type' => $banking['type'],
                            'mid' => $banking['mid']
                        ];
                        //累计相加 出支付宝佣金
                        $yinaliyongjing = $yinaliyongjing + $aliliushui[0]['income'] * $alirate;

                    }else if($v['mtype']==3){

//                银行直连商户
                        $wxrate = $v['commission'] - $agent[0]['wxcommission'];//计算出代理商的微信 佣金费率
                        $qqrate = $v['qqcommission'] - $agent[0]['qqcommission'];//计算出代理商的qq 佣金费率
//                拼接查出微信 的sql
                        $wxsql = "mid={$v['mid']} AND ispay=1 AND pay_way='weixin' AND paytime > {$start} AND paytime<{$end}";

//                拼接查出 qq的sql
                        $qqsql = "mid={$v['mid']} AND ispay=1 AND pay_way='qq' AND paytime > {$start} AND paytime<{$end}";
//                查出门店下微信的所有支付流水
                        $wxliushui = M('cashier_order')->select($wxsql, 'round(sum(income),2)as income ');
                        $count_money = $count_money + $wxliushui[0]['income'];
//                if (!empty($wxliushui[0]['income'])) {
                        //查出微信的所有价格保存到数组中
                        $banking = ['company' => $v['company'], 'wx_money' => $wxliushui[0]['income'], 'type' => '2', 'mid' => $v['mid']];
//                }
                        //累计相加 出微信佣金
                        $jhzwxyongjing = $jhzwxyongjing + $wxliushui[0]['income'] * $wxrate;
//                查出门店下qq的所有支付流水
                        $qqliushui = M('cashier_order')->select($qqsql, 'round(sum(income),2)as income ');
                        $count_money = $count_money + $qqliushui[0]['income'];
                        $jinhaizhe[] = [
                            'company' => $banking['company'],
                            'wx_money' => $banking['wx_money'],
                            'wxrate' => $wxrate,
                            'wx_brokerage' => $banking['wx_money'] * $wxrate,
                            'qqrate' => $qqrate,
                            'qq_money' => $qqliushui[0]['income'],
                            'qq_brokerage' => $qqliushui[0]['income'] * $qqrate,
                            'type' => $banking['type'],
                            'mid' => $banking['mid']
                        ];
                        //累计相加 出qq佣金
                        $jhzqqyongjing = $jhzqqyongjing + $qqliushui[0]['income'] * $qqrate;

                    }
                }
                //总提现金额
                $counts = $teiwxyongjing + $teialiyongjing + $yinwxyongjing + $yinaliyongjing+$jhzwxyongjing+$jhzqqyongjing;
//        合并 数据
                $array = array_merge($contributings, $bankings,$jinhaizhe);
//        }
//        把计算出的所有数据 存入数据表中
//        1先查询出aid对于的数据 如果没有 就进行保存
                $name = M('cashier_agent')->select(['aid' => $this->aid], 'uname');
//            if (empty($res)) {
                $data['aid'] = $this->aid;
                $data['name'] = $name[0]['uname'];
                $data['count_turnover'] = $count_money;
                $data['count_deposit'] = $counts;
                $data['status'] = 1;
                $data['date'] = $date;
                M('cashier_agent_commission')->insert($data);
                $id = mysql_insert_id();
                $arr = [];
                foreach ($array as $value) {
                    $arr[] = [
                        'acid' => $id,
                        'company' => $value['company'],
                        'wx_money' => empty($value['wx_money']) ? 0 : $value['wx_money'],
                        'wxrate' => $value['wxrate'],
                        'wx_brokerage' => $value['wx_brokerage'],
                        'ali_money' => empty($value['ali_money']) ? 0 : $value['ali_money'],
                        'alirate' => $value['alirate'],
                        'ali_brokerage' => $value['ali_brokerage'],
                        'qq_money' => empty($value['qq_money']) ? 0 : $value['qq_money'],
                        'qqrate' => $value['qqrate'],
                        'qq_brokerage' => $value['qq_brokerage'],
                        'type' => $value['type'],
                        'mid' => $value['mid'],
                        'date' => $date
                    ];
                }
                foreach ($arr as $v) {
                    M('cashier_agent_commission_info')->insert($v);
                }
            }
        }

//        查出代理商的佣金 除开本月 以外没有提现的  佣金
        $date = date('Ym', strtotime('-1 month'));
        $sql = "aid=$this->aid AND status=1  AND date <= $date OR aid=$this->aid AND status=3 AND date <= $date ";//拼接sql语句
        $datas = M('cashier_agent_commission')->select($sql, '*');
            $ids=[];
        if (!empty($datas)) {
            foreach ($datas as $v) {
                $ids[] = $v['id'];
            }
            $id = implode(',', $ids);
        }
//        统计数据元素个数
        $aid = $this->aid;
        //查出代理商提现的数据
        $date = date('Ym', strtotime('-1 month'));
        $sql = "aid=$this->aid AND status=2 AND date <= $date";//拼接sql语句
//        $deposit = M('cashier_agent_commission')->select($sql, '*');

//        $sqlToNow = "SELECT SUM(agent_price) as total FROM ".$this->tablepre."cashier_order WHERE mid IN (select mid from ".$this->tablepre."cashier_merchants where aid = {$this->aid})  and ispay=1 AND `agent_stm` = 0 and paytime<".strtotime(date('Y-m-d',time()));
//        $sqlTo0 = "SELECT SUM(agent_price) as total FROM ".$this->tablepre."cashier_order WHERE mid IN (select mid from ".$this->tablepre."cashier_merchants where aid = {$this->aid})  and ispay=1 AND `agent_stm` = 0";

        $obj = new model();
//        $result['Now']= $obj->selectBySql($sqlToNow);
//
//        $result['zero']= $obj->selectBySql($sqlTo0);


        $count = M('cashier_agent_commission')->count($sql);

        $page = new page($count, 5);
        $p = $page->show();
        $limitStr = $page->firstRow . ',' . $page->listRows;

        $deposit = M('cashier_agent_commission')->get_all('*', '', $sql, 'id desc', $limitStr);
//        dump($deposit);exit();
//        $sumMoney = M('cashier_agent_commission')->select($sql, 'sum(money) as sum');

        include $this->showTpl();

    }

    public function info()
    {
        $id = $_GET['id'];
//        查出提现代理商对应的门店消费记录
        $result = M('cashier_agent_commission_info')->select(['acid' => $id], '*');
        include $this->showTpl();
    }


//    Excel导出

    public function data2Excell()
    {
        $acid = $_GET['acid'];
        $rows = M('cashier_agent_commission_info')->select(['acid' => $acid], '*');
        $data = array();
        foreach ($rows as $k => $v) {
            $data[$k]['date'] = $v['date'];
            $data[$k]['company'] = $v['company'];
            $data[$k]['type'] = $v['type'] == 1 ? '特约商户' : '银行直连';
            $data[$k]['wx_money'] = $v['wx_money'];
            $data[$k]['wxrate'] = $v['wxrate'] * 100;
            $data[$k]['wx_brokerage'] = $v['wx_brokerage'];
            $data[$k]['ali_money'] = $v['ali_money'];
            $data[$k]['alirate'] = $v['alirate'] * 100;
            $data[$k]['ali_brokerage'] = $v['ali_brokerage'];
            $data[$k]['count'] = $v['wx_brokerage'] + $v['ali_brokerage'];
        }
        $title = array('日期', '代理商门店名称', '商户类型', '微信流水', '微信结算率', '微信有效佣金', '支付宝流水', '支付宝结算率', '支付宝有效佣金', '佣金合计');
        $filename = '代理商佣金清单列表' . date('Y-m-d') . '.xls';
        $this->ExportTable($data, $title, $filename);


    }


    public function forSaler()
    {

        $getdata = $this->clear_html($_GET);


        if ($getdata['type'] == 1) {

            $where = '`status`= 1';
        }

        if ($getdata['type'] == 2) {

            $where = '`status`= 2';
        }

        if ($getdata['username']) {

            $where .= ' AND username LIKE "%' . $getdata['username'] . '%"';
        }

        if (!empty($getdata['start']) && !empty($getdata['end'])) {
            $where .= " AND addtime >= " . date('Ym',strtotime($getdata['start']));
            $where .= ' AND addtime <= ' . date('Ym',strtotime($getdata['end']));
        }

//        根据aid 查出代理商下的业务员id 和佣金比例
        $salesman=M('cashier_salesmans')->select(['aid'=>$this->aid],'id,commission,username');
//        在根据业务员id 查出商家的mid
        $salesmans=[];
        foreach ($salesman as $value){
            $result=M('cashier_merchants')->select(['sid'=>$value['id']],'mid');

            foreach ($result as $v){
                $arr[]=$v['mid'];
            }
            $salesmans[]=[
                'sid'=>$value['id'],
                'mid'=>empty($arr)?'0': implode(',',$arr),
                'commission'=>$value['commission'],
                'username'=>$value['username'],
                'aid'=>$this->aid
            ];
            unset($arr);
        }
//        根据查出的mid 查出代理商详细表下的商户的支流水佣金并计算出业务员的佣金
        $date = date('Ym', strtotime('-1 month'));
        $money=[];
        foreach ($salesmans as $v){
            $sql="mid IN({$v['mid']}) AND date=$date";
            $res=M('cashier_agent_commission_info')->select($sql,'*');
            foreach ($res as $values){
                $money[]=[
                    'username'=>$v['username'],
                    'company'=>$values['company'],
                    'commission'=>$v['commission'],
                    'count_money'=>$values['wx_brokerage']+$values['ali_brokerage'],
                    'money'=>($values['wx_brokerage']+$values['ali_brokerage'])*$v['commission'],
                    'addtime'=>$values['date'],
                    'status'=>1,
                    'mid'=>$values['mid'],
                    'aid'=>$v['aid']
                ];
            }
        }
//        把统计的数据存入业务员的提现表中
        foreach ($money as $v){
            $sql="mid={$v['mid']} AND status={$v['status']} AND addtime={$v['addtime']} OR mid={$v['mid']} AND status=2 AND addtime={$v['addtime']}";
            $data=M('cashier_apply')->select($sql,'*');
            if (empty($data)) {
                M('cashier_apply')->insert($v);
            }
        }
        if ($getdata['type']==1) {
            //        查出未划账业务员佣金
            $datas=M('cashier_apply')->select(['status'=>1,'addtime'=>$date,'aid'=>$this->aid],'*');
        }else{
            //        查出未划账业务员佣金
            $sql="$where AND aid=".$this->aid;
            $_count = M('cashier_apply')->count($where);
            $page = new page($_count, 8);
            $p = $page->show();
//            $limitStr = $page->firstRow . ',' . $page->listRows;
            $datas = M('cashier_apply')->select($sql, '*', $page->firstRow . ',' . $page->listRows, 'id DESC');
        }


        include $this->showTpl();
    }

    // 填写银行卡信息
//    public function yourInfo () {
//
//        if (IS_POST) {
//            $postdata = $this->clear_html($_POST);
//
//            if  (!$this->isIDcardNumber($postdata['idcard'])){
//                    $this->errorTip('不是有效的身份证!!');
//            }
//            $idcard['idcard'] = $postdata['idcard'];
//
//            if  (!$postdata['myidA']){
//                    $this->errorTip('请上传身份证正面图');
//            }
//            $idcard['cardA'] = $postdata['myidA'];
//
//            if  (!$postdata['myidB']){
//                    $this->errorTip('请上传身份证反面图');
//            }
//            $idcard['cardB'] = $postdata['myidB'];
//
//            if  (!$postdata['idAndBank']){
//                    $this->errorTip('请上传手拿身份证和银行卡正面图');
//            }
//            $idcard['idAndBankcard'] = $postdata['idAndBank'];
//
//            $data['idcard'] = json_encode($idcard);
//
//            if  (!$postdata['owner']){
//                    $this->errorTip('请填写持卡人');
//            }
//            $bankcard['owner'] = $postdata['owner'];
//
//            if  (!$postdata['bankname']){
//                    $this->errorTip('请填写开户银行名称详细到开户支行');
//            }
//            $bankcard['bankname'] = $postdata['bankname'];
//
//            if  (!$postdata['bankid']){
//                    $this->errorTip('请填写银行卡账号');
//            }
//            $bankcard['bankid'] = $postdata['bankid'];
//
//            if  (!$postdata['bankcardA']){
//                    $this->errorTip('请上传银行卡正面图');
//            }
//            $bankcard['cardA'] = $postdata['bankcardA'];
//
//            if  (!$postdata['bankcardB']){
//                    $this->errorTip('请上传银行卡反面图');
//            }
//            $bankcard['cardB'] = $postdata['bankcardB'];
//
//            $data['bankcard'] = json_encode($bankcard,JSON_UNESCAPED_UNICODE);
//            $res = M('cashier_agent')->update($data,array('aid'=>$this->aid));
//            if ( $res ) {
//             $this->successTip('数据保存成功');
//            }
//
//        }


//        if (IS_GET){
//           $getdata =  $this->clear_html($_GET);
//
//           $getdata = M('cashier_agent')->get_one(array('aid'=>$getdata['aid']),'bankcard,idcard');
//           $bankcard = json_decode($getdata['bankcard'],true);
//           $idcard = json_decode($getdata['idcard'],true);
//
//        }
//        include $this->showTpl();
//
//    }
    /*     * ****银行卡配置******* */

    public function yourInfo()
    {

        if (IS_POST) {
            //dump($_POST); die();

            $data['isCompay'] = $_POST['isCompay'];
            $data['phoneNo'] = $_POST['phoneNo'];
            $data['customerName'] = $_POST['customerName'];
            $data['cerdType'] = $_POST['cerdType'];
            $data['cerdId'] = $_POST['cerdId'];
            $data['accBankNo'] = $_POST['accBankNo'];
            $data['accBankName'] = $_POST['accBankName'];
            $data['bankType'] = $_POST['bankType'];
            $data['acctNo'] = $_POST['acctNo'];
            $data['settBankNo'] = $_POST['settBankNo'];


            //图片
            $data['imgzheng'] = $_POST['constructLeanIDList'][0];
            $data['imgfan'] = $_POST['constructLeanList'][0];

            $data['shouimg'] = $_POST['contactList'][0];
            $data['bankzheng'] = $_POST['cunstructIDList'][0];
            $data['bankfan'] = $_POST['landUseIdList'][0];

            if ($data['imgzheng'] == '' || $data['imgfan'] == "" || $data['shouimg'] == "" || $data['bankzheng'] == "" || $data['bankfan'] == "") {

                $this->errorTip('请上传完身份证或银行卡的图片!');


            }
            //$data = $this->clear_html($_POST);

            //$this->dexit(array('code' => 0, 'msg' => json_encode($data)));

            $data['bank_img'] = serialize($data['bank_img']);


            $cashier_bankDb = M('cashier_bank');

            $bankArr = $cashier_bankDb->get_one(array('aid' => $this->aid), '*');


            if (empty($bankArr)) {

                $data['aid'] = $this->aid;

                if ($cashier_bankDb->insert($data, true)) {
                    $this->errorTip('上传成功，等待管理员审核！');

                } else {
                    $this->errorTip('设置失败!');
                }
            } else {
                $data['bank'] = 0;
                $data['bankmsg'] = "";
                if ($cashier_bankDb->update($data, array('aid' => $this->aid))) {
                    $this->errorTip('修改成功，等待管理员审核!');
                } else {
                    $this->errorTip('修改失败!');
                }
            }
        } else {
            $bank = M('cashier_bank')->get_one(array('aid' => $this->aid));
            //dump($bank); die();

            if (!empty($bank)) {
                $bank['bank_img'] = unserialize($bank['bank_img']);
            }
            if ($this->isMobile()) {
                include $this->showTpl("bankwap");
            } else {
                include $this->showTpl();
            }
        }
    }

    //  是否是身份证
    public function isIDcardNumber($idCardNumber = '')
    {

        $patten = "/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$|^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/";

        return preg_match($patten, $idCardNumber);
    }

    //判断是否为手机
    function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia',
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
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
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

    public function upfile()
    {

        if (IS_POST) {
            if (!empty($_FILES)) {

                $return = $this->oldUploadFile('card', $_GET['mid']);

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


    public function applyM()
    {
        if (!IS_POST) return false;
        $postdata = $this->clear_html($_POST);

        // 检测是否配置了银行卡信息
        $agent = M('cashier_agent')->get_one(array('aid' => $this->aid), '*');

        if (!$agent['idcard'] || !$agent['bankcard']) {

            $data['url'] = 'merchants.php?m=Agent&c=settlement&a=yourInfo&aid=' . $this->aid;
            echo json_encode($data);
            exit;

        }
        //检查传入的数据是否正确

        $obj = new model();
        // 判断接收数据是否与实际相符
        $sqlNow = 'SELECT SUM(agent_price) AS sum from ' . $this->tablepre . 'cashier_order WHERE  mid IN (SELECT mid FROM ' . $this->tablepre . 'cashier_merchants WHERE aid =' . $this->aid . ') AND ispay = 1 AND paytime <' . $postdata['time'] . ' AND agent_stm = 0';

        $check = $obj->selectBySql($sqlNow);


        if ($check[0]['sum'] == $postdata['money']) {
            if ($postdata['money'] - 3 > 0) {
                $whereSet = 'mid IN (select  mid from ' . $this->tablepre . 'cashier_merchants where aid =' . $this->aid . ') AND ispay = 1';

                $sql = 'UPDATE ' . $this->tablepre . 'cashier_order set `agent_stm` = 1 WHERE ' . $whereSet;

                if ($obj->selectBySql($sql)) {

                    $getName = $obj->selectBySql('select uname from ' . $this->tablepre . 'cashier_agent where aid =' . $this->aid);

                    if ($postdata['money'] - 3 > 0) {

                    }
                    $data = array(
                        'settleid' => $this->aid,
                        'money' => $postdata['money'] - 3,
                        'name' => $getName[0]['uname'],
                        'addtime' => time(),
                        'type' => 1,
                        'status' => 0
                    );


                    $result = M('cashier_apply')->insert($data, 1);


                    if ($result > 0) {
                        $respose['status'] = 1;
                        $respose['msg'] = '申请成功, 提现记录生成,请刷新页面查看';

                    } else {
                        $respose['status'] = 2;
                        $respose['msg'] = '申请成功, 提现记录生成出错';
                    }
                }
            } else {
                $respose['status'] = 2;
                $respose['msg'] = '提现金额必须大于3元';
            }


        } else {
            $respose['status'] = 0;
            $respose['msg'] = '服务器忙....';
        }
        $this->dexit($respose);

    }


// 导出excel
    public function data2Excel()
    {

        $getdata = $this->clear_html($_GET);
        $obj = new model();
        if ($getdata['type'] == 1) {

            $SQL = 'SELECT * FROM ' . $this->tablepre . 'cashier_apply where settleid IN (select id from ' . $this->tablepre . 'cashier_salesmans where aid = ' . $this->aid . ') AND status = 0 AND type=2';


        } else {

            $SQL = 'SELECT * FROM ' . $this->tablepre . 'cashier_apply where  status = 2 AND aid='.$this->aid ;
        }
        $apply = $obj->selectBySql($SQL);
        $data = array();
        foreach ($apply as $k => $v) {
            $data[$k]['username'] = $v['username'];
            $data[$k]['company'] = $v['company'];
            $data[$k]['count_money'] = $v['count_money'];
            $data[$k]['commission'] = $v['commission']*100;
            $data[$k]['addtime'] =  $v['addtime'];
            $data[$k]['money'] = $v['money'];
            $data[$k]['status'] = $v['status']==2 ? '已划账' : '未划账';
        }

        $title = array( '业务员','商家名称','代理商佣金','业务员佣金率', '结算日期', '金额', '状态');
        $filename = '业务员划账表' . date('Y-m-d H', time()) . '.xls';
        $this->ExportTable($data, $title, $filename);


    }

//划账
    public function remite()
    {
        $postdata = $this->clear_html($_POST);
        $respose = M('cashier_apply')->update(['status' => 2], ['id' => $postdata['id']]);
        if ($respose) {
           echo json_encode(['status'=>1,'msg'=>'划账成功']);
        } else {
            echo json_encode(['status'=>0,'msg'=>'划账失败']);
        }
    }


    /*------------------------------------------------------------------------------*/
    public function test()
    {
        $this->fan = M('cashier_fans');

        $authority = $this->authorityList('Merchants/User');
        $testemp = $this->fan->select(array('mid' => 22, 'sex' => 1));
        print_r($testemp);
        die;

        $this->select();

        include $this->showTpl();
    }

    public function employers()
    {

        $authority = $this->authorityList('Merchants/User');

        $employees = $this->employeeDb->select(array('mid' => $this->mid));

        $StoreInfo = $this->getStoreInfo(false);
        include $this->showTpl();
    }

    public function employersAdd()
    {


        if (IS_POST) {
            $data = $this->clear_html($_POST);
            if ($data['password'] != $data['confirm']) {
                $this->errorTip('两次输入密码不一致！', $_SERVER['HTTP_REFERER']);
                exit;
            }

            $data['mid'] = $this->mid;
            $data['salt'] = mt_rand(111111, 999999);
            $data['password'] = md5(md5($data['password'] . '_' . $data['salt']) . $data['salt']);
            $data['authority'] = !empty($data['authority']) ? implode(',', $data['authority']) : '';
            unset($data['confirm']);
            if ($this->employeeDb->insert($data, 1)) {
                $this->successTip('添加员工账号成功！', $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $this->errorTip('添加员工账号失败！', $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }

    public function checkAccount()
    {

        if (IS_POST) {
            $data = $this->clear_html($_POST);
            if ($this->employeeDb->get_one(array('account' => $data['account']), 'eid,account')) {
                echo json_encode(array('status' => 0, 'msg' => '登录账号已存在'));
            } else {
                echo json_encode(array('status' => 1, 'msg' => '验证成功'));
            }
        }
    }

    public function field()
    {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $return = $this->_setField($this->employeeDb, $data);
            echo json_encode($return);
            exit;
        }
    }

    public function employersDelAll()
    {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $return = $this->_delAll($this->employeeDb, $data['id']);
            if ($return['status'] == '1') {
                $this->successTip($return['msg'], $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $this->errorTip($return['msg'], $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }

    public function employersDel()
    {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $return = $this->_del($this->employeeDb, $data['eid']);
            exit(json_encode($return));
        }
    }

    public function employersEdit()
    {
        if (IS_GET) {
            $data = $this->clear_html($_GET);
            $authority = $this->authorityList('Merchants/User');
            $employee = $this->employeeDb->get_one(array('eid' => $data['eid']));
            $employee['authority'] = explode(',', $employee['authority']);
            $StoreInfo = $this->getStoreInfo(false);
            include $this->showTpl();
        }
    }

    public function employersAppemd()
    {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $employee = $this->employeeDb->get_one(array('eid' => $data['eid']), 'eid,account,salt');

            if ($data['account'] != $employee['account']) {
                if ($this->employeeDb->get_one(array('account' => $data['account']), 'eid,account')) {
                    $this->errorTip('登录账号已存在！', $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }
            if ($data['password'] == '') {
                unset($data['password']);
            } elseif ($data['password'] != $data['confirm']) {
                $this->errorTip('两次输入密码不一致！', $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $data['password'] = md5(md5($data['password'] . '_' . $employee['salt']) . $employee['salt']);
            }
            unset($data['confirm']);

            $data['authority'] = !empty($data['authority']) ? implode(',', $data['authority']) : '';
            if ($this->_save($this->employeeDb, $data)) {
                $this->successTip('修改员工账号成功！', $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $this->errorTip('修改员工账号失败！', $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }

    /*     * ***门店管理***** */

    public function storefront()
    {
        $cashier_storesDb = M('cashier_stores');
        bpBase::loadOrg('common_page');
        $wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
        if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $this->mid) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
            $wx_user = $wx_user['submchinfo'];
        }
        $where = array('mid' => $this->mid, 'appid' => $wx_user['appid']);
        unset($wx_user);
        $_count = $cashier_storesDb->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $stores = $cashier_storesDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
        foreach ($stores as $kk => $vv) {
            if ($vv['available_state'] == 2) {
                $stores[$kk]['statusstr'] = "<font>审核中</font>";
            } elseif ($vv['available_state'] == 3) {
                $stores[$kk]['statusstr'] = "<font color='green'>已审核</font>";
            } elseif ($vv['available_state'] == 4) {
                $stores[$kk]['statusstr'] = "<font color='red'>未通过</font>";
            } elseif ($vv['available_state'] == 1) {
                $stores[$kk]['statusstr'] = "系统错误";
            } else {
                $stores[$kk]['statusstr'] = "等待微信审核";
            }
        }
        $wx_user = M('cashier_payconfig')->get_wx_info($this->mid);
        $getWxStore = true;
        if (!empty($wx_user) && (($wx_user['pfpaymid'] > 0) || ($wx_user['proxymid'] > 0))) {
            $getWxStore = false;
        }
        include $this->showTpl();
    }

    /*     * ***门店管理***** */

    public function getWxStore()
    {
        bpBase::loadOrg('wxCardPack');
        $wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
        if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $this->mid) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
            $wx_user = $wx_user['submchinfo'];
        }
        $wxCardPack = new wxCardPack($wx_user, $this->mid);
        $access_token = $wxCardPack->getToken();
        $wxShoplist = $wxCardPack->wxGetPoiList($access_token);
        $shopnum = 0;
        $nodata = true;
        if ($wxShoplist && !empty($wxShoplist['business_list'])) {
            $shopnum = $wxShoplist['total_count'];
            $nodata = $this->execinsertData($wxShoplist['business_list'], $wx_user['appid']);
            if ($shopnum > 49) {
                for ($i = 50; $i <= $shopnum;) {
                    $limitStr = '{"begin":' . $i . ',"limit":50}';
                    $wxShoplist = $wxCardPack->wxGetPoiList($access_token, $limitStr);
                    $nodata = $this->execinsertData($wxShoplist['business_list'], $wx_user['appid']);
                    $i = $i + 50;
                }
            }
            if (!$nodata) {
                $this->dexit(array('error' => 0));
            }
        }
        $this->dexit(array('error' => 1));
    }

    /*     * **创建门店** */

    public function createStore()
    {
        $categorys = M('cashier_category')->select(array('fid' => '0', 'is_hide' => '0'), '*', '', 'id ASC');
        $districts = M('cashier_district')->select(array('fid' => '0'), '*', '', 'id ASC');
        include $this->showTpl();
    }

    /*     * ******获取城市或区域信息******* */

    public function GetDistrict()
    {
        $districtid = isset($_POST['districtid']) ? trim($_POST['districtid']) : 0;
        if ($districtid > 0) {
            $districts = M('cashier_district')->select(array('fid' => $districtid), '*', '', 'id ASC');
            $this->dexit(array('error' => 0, 'data' => !empty($districts) ? $districts : ''));
        }
        $this->dexit(array('error' => 1, 'data' => ''));
    }

    /*     * ******获取子目录信息******* */

    public function GetCategory()
    {
        $cid = isset($_POST['cid']) ? trim($_POST['cid']) : 0;
        if ($cid > 0) {
            $categorys = M('cashier_category')->select(array('fid' => $cid, 'is_hide' => '0'), '*', '', 'id ASC');
            $this->dexit(array('error' => 0, 'data' => !empty($categorys) ? $categorys : ''));
        }
        $this->dexit(array('error' => 1, 'data' => ''));
    }

    /*     * ******添加门店******* */

    public function addShop()
    {

        $datas = $this->clear_html($_POST);
        $datas = $this->FiltrationData($datas);
        $toJsonsarr = array('business' => array());
        $baseInfo = array();
        $baseInfo['sid'] = $this->mid;
        $baseInfo['business_name'] = $datas['business_name'];
        $baseInfo['branch_name'] = $datas['branch_name'];
        $tmpArea = $this->GetAreaInfo($datas['pos_id']);
        $baseInfo['province'] = $tmpArea['province']['fullname'];
        $baseInfo['city'] = $tmpArea['city']['fullname'];
        $baseInfo['district'] = $tmpArea['district']['fullname'];
        $baseInfo['address'] = $datas['address'];
        $baseInfo['telephone'] = $datas['telephone'];
        $baseInfo['categories'] = $datas['categories'];
        $baseInfo['offset_type'] = 1;
        $baseInfo['longitude'] = $datas['longitude'];
        $baseInfo['latitude'] = $datas['latitude'];
        $baseInfo['photo_list'] = $datas['photo_list'];
        $baseInfo['special'] = $datas['special'];
        $baseInfo['open_time'] = $datas['open_time'];
        $baseInfo['avg_price'] = $datas['avg_price'];
        $baseInfo['recommend'] = $datas['recommend'];
        $baseInfo['introduction'] = $datas['desc'];

        foreach ($datas['photo_list'] as $ikk => $ivv) {
            $datas['photo_list'][$ikk]['local_img'] = $datas['photo_img'][$ikk];
        }
        $wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
        if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $this->mid) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
            $wx_user = $wx_user['submchinfo'];
        }
        $localArr = array('mid' => $this->mid, 'business_name' => $datas['business_name'],
            'branch_name' => $datas['branch_name'], 'telephone' => $datas['telephone'],
            'longitude' => $datas['longitude'], 'latitude' => $datas['latitude'],
            'starttime' => $datas['starttime'], 'endtime' => $datas['endtime'],
            'avg_price' => $datas['avg_price'], 'address' => $datas['address'],
            'photo_list' => !empty($datas['photo_list']) ? serialize($datas['photo_list']) : '',
            'fsortid' => $datas['categoryid0'], 'sortid' => $datas['categoryid1'],
            'circleid' => 0, 'cityid' => $tmpArea['city']['id'],
            'provinceid' => $tmpArea['province']['id'], 'cityname' => $tmpArea['city']['fullname'],
            'provincename' => $tmpArea['province']['fullname'], 'introduction' => $datas['desc'],
            'recommend' => $datas['recommend'], 'special' => $datas['special'],
            'districtid' => $tmpArea['district']['id'], 'districtname' => $tmpArea['district']['fullname'],
            'available_state' => 0, 'offset_type' => 1, 'comefrom' => 0, 'addtime' => SYS_TIME,
            'appid' => $wx_user['appid']
        );
        $storesDb = M('cashier_stores');
        $insertid = $storesDb->insert($localArr, True);
        if ($insertid > 0) {
            $baseInfo['sid'] = $this->mid . '_' . $insertid;
            $toJsonsarr['business']['base_info'] = $baseInfo;
            $postwxJsonstr = $this->ArrayToJsonstr($toJsonsarr);
            unset($baseInfo);
            bpBase::loadOrg('wxCardPack');
            $wxCardPack = new wxCardPack($wx_user, $this->mid);
            $access_token = $wxCardPack->getToken();
            $rets = $wxCardPack->wxCardShop($access_token, $postwxJsonstr);
            if (!$rets['errcode']) {
                $this->dexit(array('error' => 0, 'msg' => '数据提交成功，请静待审核'));
            } else {
                $storesDb->delete(array('id' => $insertid, 'mid' => $this->mid));
                $this->dexit(array('error' => 1, 'msg' => $rets['errcode'] . '：' . $rets['errmsg']));
            }
        }
        $this->dexit(array('error' => 1, 'msg' => '数据保存失败！'));
    }

    public function storedetail()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $store = M('cashier_stores')->get_one(array('id' => $id, 'mid' => $this->mid));
        if (empty($store))
            $this->errorTip('不存在的门店', '/merchants.php?m=User&c=merchant&a=storefront');
        $photo_list = unserialize($store['photo_list']);
        $photo_list = $photo_list ? $photo_list : array();
        $date_str = date('H:i', $store['starttime']) . '-' . date('H:i', $store['endtime']);
//     	echo "<pre/>";
//     	print_r($photo_list);die;
        $categorys = M('cashier_category')->select("id IN ({$store['fsortid']}, {$store['sortid']})");
        $catestr = '';
        foreach ($categorys as $category) {
            if ($category['fid']) {
                $catestr .= ',' . $category['name'];
            } else {
                $catestr = $category['name'] . $catestr;
            }
        }
        include $this->showTpl();
    }

    public function storedel()
    {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $employee = M('cashier_employee')->select(array('storeid' => $id, 'mid' => $this->mid));
        if ($employee)
            $this->dexit(array('errcode' => 1, 'errmsg' => '给门店已经分配给' . $employee[0]['username'] . '管理，如要删除，先取消' . $employee[0]['username'] . '的管理！'));
        $storeDB = M('cashier_stores');
        $store = $storeDB->get_one(array('id' => $id, 'mid' => $this->mid));
        if (empty($store))
            $this->dexit(array('errcode' => 1, 'errmsg' => '不存在的门店'));
        $wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
        if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $this->mid) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
            $wx_user = $wx_user['submchinfo'];
        }
        bpBase::loadOrg('wxCardPack');
        $wxCardPack = new wxCardPack($wx_user, $this->mid);
        $access_token = $wxCardPack->getToken();
        $res = $wxCardPack->delShop($access_token, json_encode(array('poi_id' => $store['poi_id'])));
        if (empty($res['errcode'])) {
            $storeDB->delete(array('id' => $id, 'mid' => $this->mid));
        }
        $this->dexit($res);
    }

    /*     * **门店本地删除**** */

    public function store2del()
    {

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $employee = M('cashier_employee')->select(array('storeid' => $id, 'mid' => $this->mid));
        if ($employee)
            $this->dexit(array('errcode' => 1, 'errmsg' => '给门店已经分配给' . $employee[0]['username'] . '管理，如要删除，先取消' . $employee[0]['username'] . '的管理！'));
        $storeDB = M('cashier_stores');
        $store = $storeDB->get_one(array('id' => $id, 'mid' => $this->mid));
        if (empty($store))
            $this->dexit(array('errcode' => 1, 'errmsg' => '不存在的门店'));
        if ($storeDB->delete(array('id' => $id, 'mid' => $this->mid))) {
            $this->dexit(array('errcode' => 0, 'errmsg' => '删除成功'));
        }
        $this->dexit(array('errcode' => 1, 'errmsg' => '删除成功'));
    }

    private function ArrayToJsonstr($array)
    {
        $tmpJosnStr = '{';
        foreach ($array as $key => $val) {
            $tmpJosnStr .= '"' . $key . '":';
            if ($key == 'categories') {
                $tmpJosnStr .= $val . ',';
            } elseif ($key == 'photo_list') {
                $tmpJosnStr .= json_encode($val) . ',';
            } elseif (is_array($val)) {
                $tmpJosnStr .= $this->ArrayToJsonstr($val) . ',';
            } else {
                if (is_numeric($val) && ($key != 'telephone')) {
                    $tmpJosnStr .= $val . ',';
                } elseif (is_bool($val)) {
                    $tmpJosnStr .= $val ? 'true,' : 'false,';
                } elseif (empty($val)) {
                    $tmpJosnStr .= '"",';
                } else {
                    $tmpJosnStr .= '"' . $val . '",';
                }
            }
        }
        $tmpJosnStr = rtrim($tmpJosnStr, ',');
        $tmpJosnStr .= '}';
        return $tmpJosnStr;
    }

    private function FiltrationData($datas)
    {
        if (empty($datas['business_name'])) {
            $this->dexit(array('error' => 1, 'msg' => '门店名称必须填写'));
        }
        if (empty($datas['branch_name'])) {
            $this->dexit(array('error' => 1, 'msg' => '门店名称必须填写'));
        }
        if (empty($datas['latitude']) || empty($datas['longitude'])) {
            $this->dexit(array('error' => 1, 'msg' => '地理位置经纬度为空，请点击地图定位获取！'));
        }
        if (empty($datas['pos_id'])) {
            $this->dexit(array('error' => 1, 'msg' => '没有定位，请点击地图定位！'));
        }
        if (empty($datas['address'])) {
            $this->dexit(array('error' => 1, 'msg' => '详细地址没有填写，你可以点击地图定位获取！'));
        }
        if (empty($datas['telephone'])) {
            $this->dexit(array('error' => 1, 'msg' => '联系电话没有填写！'));
        }
        if (empty($datas['categoryid0info']) || empty($datas['categoryid1info'])) {
            $this->dexit(array('error' => 1, 'msg' => '请重新选择类目！'));
        } else {
            $categoryidname = explode('-', $datas['categoryid0info']);
            $datas['categoryid0name'] = $categoryidname['1'];
            $datas['categories'] = array($categoryidname['1']);
            $categoryidname = explode('-', $datas['categoryid1info']);
            $datas['categoryid1name'] = $categoryidname['1'];
            $datas['categories'][] = $categoryidname['1'];
            $datas['categories'] = '["' . implode(',', $datas['categories']) . '"]';
        }

        if (empty($datas['photo_list'])) {
            $this->dexit(array('error' => 1, 'msg' => '门店图片至少请上传一张！'));
        } else {
            foreach ($datas['photo_list'] as $kk => $vv) {
                $datas['photo_list'][$kk] = array('photo_url' => $vv);
            }
        }

        if (empty($datas['open_time']) || !strpos($datas['open_time'], ':') || !strpos($datas['open_time'], '-')) {
            $this->dexit(array('error' => 1, 'msg' => '营业时间必须按格式填写上！'));
        } else {
            $nowTimeStr = date('Y-m-d');
            $open_time = explode('-', $datas['open_time']);
            $datas['starttime'] = !empty($open_time['0']) ? strtotime($nowTimeStr . ' ' . $open_time['0']) : 0;
            $datas['endtime'] = !empty($open_time['1']) ? strtotime($nowTimeStr . ' ' . $open_time['1']) : 0;
        }
        $avg_price = intval($datas['avg_price']);
        if (!($avg_price > 0)) {
            $this->dexit(array('error' => 1, 'msg' => '人均价格必须按要求填写！'));
        }
        $datas['avg_price'] = $avg_price;

        if (empty($datas['special'])) {
            $this->dexit(array('error' => 1, 'msg' => '特色服务必须填写！'));
        }
        return $datas;
    }

    private function GetAreaInfo($sid = '')
    {
        $tmpInfo = false;
        if (!empty($sid)) {
            $districtDb = M('cashier_district');
            $tmpdistrict = $districtDb->get_one(array('sid' => $sid), '*');
            if (!empty($tmpdistrict)) {
                $tmpInfo = array('district' => array('id' => $tmpdistrict['id'], 'fullname' => $tmpdistrict['fullname']));
                $tmpdistrict = $districtDb->get_one(array('id' => $tmpdistrict['fid']), '*');
                $tmpInfo['city'] = array('id' => $tmpdistrict['id'], 'fullname' => $tmpdistrict['fullname']);
                if ($tmpdistrict['fid'] > 0) {
                    $tmpdistrict = $districtDb->get_one(array('id' => $tmpdistrict['fid']), '*');
                    $tmpInfo['province'] = array('id' => $tmpdistrict['id'], 'fullname' => $tmpdistrict['fullname']);
                } else {
                    $tmpInfo['province'] = array('id' => $tmpdistrict['id'], 'fullname' => $tmpdistrict['fullname']);
                }
            }
        }
        return $tmpInfo;
    }

    private function execinsertData($datas, $appid = '')
    {
        $mid = $this->mid;
        $nodata = true;
        $cashier_storesDb = M('cashier_stores');
        foreach ($datas as $svv) {
            $svv['sid'] > 0 && $mid = $svv['base_info']['sid'];
            $poi_id = isset($svv['base_info']['poi_id']) ? $svv['base_info']['poi_id'] : '';
            $available_state = $svv['base_info']['available_state'];
            if (!empty($poi_id) && $available_state == 3) {
                $nodata = false;
                $timeStr = $svv['base_info']['open_time'];
                $starttime = $endtime = 0;
                $nowStr = date('Y-m-d');
                if (!empty($timeStr)) {
                    $timeStr = explode('-', $timeStr);
                    !empty($timeStr['0']) && $starttime = strtotime($nowStr . ' ' . $timeStr['0']);
                    !empty($timeStr['1']) && $endtime = strtotime($nowStr . ' ' . $timeStr['1']);
                }
                $categories = $svv['base_info']['categories']['0'];
                $categories = explode(',', $categories); /*                 * *待处理** */

                $fid = 0;
                $fsortid = $sortid = 0;
                foreach ($categories as $name) {
                    if ($category = M('cashier_category')->get_one(array('fid' => $fid, 'name' => $name))) {
                        $fid = $category['id'];
                        if (empty($fsortid)) {
                            $fsortid = $fid;
                        } else {
                            $sortid = $fid;
                        }
                    }
                }
                $provinceid = $cityid = $districtid = 0;

                $province = M('cashier_district')->get_one(array('fullname' => $svv['base_info']['province']));
                $provinceid = isset($province['id']) ? $province['id'] : 0;
                $city = M('cashier_district')->get_one(array('fullname' => $svv['base_info']['city']));
                $cityid = isset($city['id']) ? $city['id'] : 0;
                $district = M('cashier_district')->get_one(array('fullname' => $svv['base_info']['district'], 'fid' => $cityid));
                $districtid = isset($district['id']) ? $district['id'] : 0;
                $getupload_dir = "/upload/merchant/" . $this->mid . "/" . date('Ymd') . '/';
                if (defined('ABS_UPLOAD_PATH'))
                    $getupload_dir = ABS_UPLOAD_PATH . $getupload_dir;
                $upload_dir = "." . $getupload_dir;
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                if (!empty($svv['base_info']['photo_list'])) {
                    foreach ($svv['base_info']['photo_list'] as $ikk => $ivv) {
                        $imgpath = $getupload_dir . 's' . $poi_id . substr($ivv['photo_url'], -30, 10) . $ikk . '.jpg';
                        $imgarr = $this->httpRequest($ivv['photo_url'], 'GET');
                        if (isset($imgarr['1']) && !empty($imgarr['1'])) {
                            file_put_contents('.' . $imgpath, $imgarr['1']);
                            $svv['base_info']['photo_list'][$ikk]['local_img'] = $imgpath;
                        }
                    }
                }
                $inserDatas = array('mid' => $this->mid, 'poi_id' => $poi_id,
                    'business_name' => $svv['base_info']['business_name'],
                    'branch_name' => $svv['base_info']['branch_name'],
                    'telephone' => $svv['base_info']['telephone'],
                    'longitude' => $svv['base_info']['longitude'],
                    'latitude' => $svv['base_info']['latitude'],
                    'starttime' => $starttime,
                    'endtime' => $endtime,
                    'fsortid' => $fsortid,
                    'sortid' => $sortid,
                    'provinceid' => $provinceid,
                    'cityid' => $cityid,
                    'districtid' => $districtid,
                    'avg_price' => $svv['base_info']['avg_price'],
                    'address' => $svv['base_info']['address'],
                    'photo_list' => !empty($svv['base_info']['photo_list']) ? serialize($svv['base_info']['photo_list']) : '',
                    'cityname' => $svv['base_info']['city'],
                    'provincename' => $svv['base_info']['province'],
                    'offset_type' => $svv['base_info']['offset_type'],
                    'introduction' => $svv['base_info']['introduction'],
                    'recommend' => $svv['base_info']['recommend'],
                    'special' => $svv['base_info']['special'],
                    'districtname' => $svv['base_info']['district'],
                    'available_state' => $available_state,
                    'comefrom' => 1,
                    'addtime' => SYS_TIME,
                    'appid' => $appid
                );
                $tmpstore = $cashier_storesDb->get_one(array('mid' => $this->mid, 'poi_id' => $poi_id), 'id,mid,poi_id');
                if (!empty($tmpstore)) {
                    $cashier_storesDb->update($inserDatas, array('id' => $tmpstore['id']));
                } else {
                    $cashier_storesDb->insert($inserDatas, True);
                }
            }
        }

        return $nodata;
    }

    private function authorityList($data = '')
    {
        $authority = loadConfig('authority');
        $info = explode('/', $data);
        $result = $this->dataOut($authority, $info);
        unset($result['Des']);
        return $result;
    }

    private function dataOut($data, $goal)
    {
        foreach ($goal as $key => $val) {
            $data = $data[$goal[$key]];
        }
        return $data;
    }

    public function applyMerchant()
    {
        $wxCardPack = $this->wxHandle();
        $access_token = $wxCardPack->getToken();
        $res = $wxCardPack->GetSubCategroy($access_token);
        $data = array();
        foreach ($res['category'] as $rowset) {
            $temp = array('key' => $rowset['primary_category_id'], 'value' => $rowset['category_name']);

            foreach ($rowset['secondary_category'] as $row) {
                $temp['list'][$row['secondary_category_id']] = array('key' => $row['secondary_category_id'], 'value' => $row['category_name']);
            }
            $data[$rowset['primary_category_id']] = $temp;
        }
        $merchantDB = M('cashier_sub_merchant');
        $submerchant = $merchantDB->get_one(array('mid' => $this->mid), '*');

        $readonly = ($submerchant && $submerchant['status'] == 1) ? 'readonly' : '';
        if (isset($submerchant['end_time']) && $submerchant['end_time']) {
            $submerchant['end_time'] = date('Y-m-d', $submerchant['end_time']);
        }

        include $this->showTpl();
    }

    public function apply()
    {
        $data = $this->clear_html($_POST);
        if (empty($data['brand_name']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '商家名称不能为空'));
        if (empty($data['logo_url']) && empty($data['logo_url_local']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '商家LOGO不能为空'));
        if (empty($data['primary_category_id']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '请选所属类目'));
        if (empty($data['secondary_category_id']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '请选子类目'));
        if (empty($data['end_time']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '截止时间不能为空'));
        if (empty($data['protocol']) && empty($data['protocol_local']))
            $this->dexit(array('errcode' => 1, 'errmsg' => '请上传授权函'));

        $wxCardPack = $this->wxHandle();

        $access_token = $wxCardPack->getToken();
        $trimstr = DIRECTORY_SEPARATOR . 'Cashier' . DIRECTORY_SEPARATOR;

        //提交logo
        if (empty($data['logo_url']) && $data['logo_url_local']) {
            $wximgpath = str_replace($trimstr, '', ABS_PATH) . ltrim($data['logo_url_local'], '.');
            $wxlogimg = $wxCardPack->wxCardUpdateImg($access_token, $wximgpath);
            if (isset($wxlogimg['url']) && !empty($wxlogimg['url'])) {
                $data['logo_url'] = $wxlogimg['url'];
            } else {
                $this->dexit($wxlogimg);
            }
        }
        //提交授权书
        if (empty($data['protocol']) && $data['protocol_local']) {
            $wximgpath = str_replace($trimstr, '', ABS_PATH) . ltrim($data['protocol_local'], '.');
            $wxlogimg = $wxCardPack->wxUploadFile($access_token, array('media' => '@' . $wximgpath, 'type' => 'image'));
            if (isset($wxlogimg['media_id']) && !empty($wxlogimg['media_id'])) {
                $data['protocol'] = $wxlogimg['media_id'];
            } else {
                $this->dexit($wxlogimg);
            }
        }

//     	$submitData['info'] = array('brand_name' => $data['brand_name'], 'logo_url' => $data['logo_url'], 'primary_category_id' => $data['primary_category_id'], 'secondary_category_id' => $data['secondary_category_id'], 'protocol' => $data['protocol'], 'end_time' => strtotime($data['end_time']));

        $merchantDB = M('cashier_sub_merchant');
        $subMerchant = $merchantDB->get_one(array('mid' => $this->mid), '*');
//     	if ($subMerchant && $subMerchant['merchant_id']) {
//     		$submitData['info']['merchant_id'] = $subMerchant['merchant_id'];
//     	}
        $jsonData = '{"info":{';
        if ($subMerchant && $subMerchant['merchant_id']) {
            $jsonData .= '"merchant_id":' . $subMerchant['merchant_id'] . ',';
        }
        $jsonData .= '"brand_name":"' . $data['brand_name'] . '", "logo_url":"' . $data['logo_url'] . '", "protocol":"' . $data['protocol'] . '", "end_time":' . strtotime($data['end_time']) . ', "primary_category_id":' . $data['primary_category_id'] . ', "secondary_category_id":' . $data['secondary_category_id'] . '}}';

        $apply = $wxCardPack->CreateSubMerchant($access_token, $jsonData);
        if (empty($apply['errcode'])) {
            $saveData = $apply['info'];
            $saveData['status'] = $saveData['status'] == 'CHECKING' ? 0 : ($saveData['status'] == 'APPROVED' ? 1 : ($saveData['status'] == 'REJECTED' ? 2 : 3));
            $saveData['logo_url'] = $data['logo_url_local'];
            $saveData['protocol'] = $data['protocol_local'];
            $saveData['brand_name'] = $data['brand_name'];
            $saveData['mid'] = $this->mid;
            $info_config = loadConfig('info');
            $saveData['fmid'] = $info_config['SYSTEM_WEIXIN_CONFIG_ID'];
            //更改申请状态
            M('cashier_merchants')->update(array('apply' => 2), array('mid' => $this->mid));
            if ($subMerchant) {
                $merchantDB->update($saveData, array('mid' => $this->mid));
            } else {
                $merchantDB->insert($saveData, array('mid' => $this->mid));
            }
        }
        $this->dexit($apply);
    }

    public function cancelapply()
    {
        if (M('cashier_merchants')->update(array('apply' => 2), array('mid' => $this->mid))) {
            $this->dexit(array('errcode' => 0, 'errmsg' => '取消成功'));
        } else {
            $this->dexit(array('errcode' => 1, 'errmsg' => '取消失败，稍后重试'));
        }
    }

    public function selectapply()
    {
        $merchantDB = M('cashier_sub_merchant');
        if ($submerchant = $merchantDB->get_one(array('mid' => $this->mid), '*')) {
            $wxCardPack = $this->wxHandle();
            $access_token = $wxCardPack->getToken();
            $info = $wxCardPack->GetSubMerchant($access_token, json_encode(array('merchant_id' => $submerchant['merchant_id'])));
            if (empty($info['errcode'])) {
                $return = array('errcode' => 0);
                $apply = -1;
                $status = -1;
                switch ($info['info']['status']) {
                    case 'CHECKING'://审核中
                        $apply = 2;
                        $status = 0;
                        $return['errmsg'] = '审核中';
                        break;
                    case 'APPROVED'://审核通过
                        $apply = 3;
                        $status = 1;
                        $return['errmsg'] = '审核通过';
                        break;
                    case 'REJECTED'://被驳回
                        $apply = 4;
                        $status = 2;
                        $return['errmsg'] = '审核被驳回';
                        break;
                    case 'EXPIRED'://协议已过期
                        $apply = 5;
                        $status = 3;
                        $return['errmsg'] = '协议已过期';
                        break;
                }
                if ($apply != -1 && $status != -1) {
                    $merchantDB->update(array('status' => $status), array('mid' => $this->mid));
                    M('cashier_merchants')->update(array('apply' => $apply), array('mid' => $this->mid));
                }
                $this->dexit($return);
            } else {
                $this->dexit($info);
            }
        }
        $this->dexit(array('errcode' => 1, 'errmsg' => '您还没有申请子商户'));
    }

    public function uploadIcon()
    {
        if (!empty($_FILES)) {
            $return = $this->oldUploadFile('mercahnt', $this->mid);
            if (isset($return['data']) && !empty($return['data'])) {
                $imgpath = $return['data']['0']['savepath'] . $return['data']['0']['savename'];
                $this->dexit(array('error' => 0, 'icon' => $imgpath));
            }
        }
        $this->dexit(array('error' => 1, 'msg' => ''));
    }

//    public function uploadImg() {
//        if (!empty($_FILES)) {
//            $return = $this->oldUploadFile('mercahnt', $this->mid);
//            if (isset($return['data']) && !empty($return['data'])) {
//                $imgpath = $return['data']['0']['savepath'] . $return['data']['0']['savename'];
//                $trimstr = DIRECTORY_SEPARATOR . 'Cashier' . DIRECTORY_SEPARATOR;
//                $wximgpath = str_replace($trimstr, '', ABS_PATH) . ltrim($imgpath, '.');
//
//                $wxCardPack = $this->wxHandle();
//                $access_token = $wxCardPack->getToken();
//
//                $wxlogimg = $wxCardPack->wxCardUpdateImg($access_token, $wximgpath);
//
//                if (isset($wxlogimg['url']) && !empty($wxlogimg['url'])) {
//                    $this->dexit(array('error' => 0, 'wxlogurl' => $wxlogimg['url'], 'localimg' => $imgpath));
//                } else {
//                    $tmpmsg = isset($wxlogimg['errcode']) ? $wxlogimg['errcode'] : '';
//                    isset($wxlogimg['errmsg']) && $tmpmsg = $tmpmsg . ":" . $wxlogimg['errmsg'];
//                    if (!empty($tmpmsg)) {
//                        $this->dexit(array('error' => 1, 'msg' => $tmpmsg));
//                    }
//                }
//            }
//        }
//        $this->dexit(array('error' => 1, 'msg' => ''));
//    }

    public function uploadFile()
    {
        if (!empty($_FILES)) {
            $return = $this->oldUploadFile('mercahnt', $this->mid);
            if (isset($return['data']) && !empty($return['data'])) {
                $imgpath = $return['data']['0']['savepath'] . $return['data']['0']['savename'];
                $trimstr = DIRECTORY_SEPARATOR . 'Cashier' . DIRECTORY_SEPARATOR;
                $wximgpath = str_replace($trimstr, '', ABS_PATH) . ltrim($imgpath, '.');
                $wxCardPack = $this->wxHandle();
                $access_token = $wxCardPack->getToken();
                $wxlogimg = $wxCardPack->wxUploadFile($access_token, array('media' => '@' . $wximgpath, 'type' => 'image'));
                if (isset($wxlogimg['media_id']) && !empty($wxlogimg['media_id'])) {
                    $this->dexit(array('error' => 0, 'media_id' => $wxlogimg['media_id'], 'localimg' => $imgpath));
                } else {
                    $tmpmsg = isset($wxlogimg['errcode']) ? $wxlogimg['errcode'] : '';
                    isset($wxlogimg['errmsg']) && $tmpmsg = $tmpmsg . ":" . $wxlogimg['errmsg'];
                    if (!empty($tmpmsg)) {
                        $this->dexit(array('error' => 1, 'msg' => $tmpmsg));
                    }
                }
            }
        }
        $this->dexit(array('error' => 1, 'msg' => ''));
    }

    private function wxHandle()
    {
        bpBase::loadOrg('wxCardPack');
        $wx_user = M('cashier_payconfig')->get_wx_info($this->mid);
        $wxCardPack = new wxCardPack($wx_user, $this->mid);
        return $wxCardPack;
    }

    private function returnname($data, &$sourceData)
    {
        if (!empty($data['fid'])) {
            $sourceData[$data['fid']]['isdel'] = 1;
            $data = array('name' => $sourceData[$data['fid']]['name'] . ',' . $data['name'], 'fid' => $sourceData[$data['fid']]['fid']);
            return $this->returnname($data, $sourceData);
        } else {
            return $data['name'];
        }
    }

    public function refreshCategroy()
    {

        $lists = M('cashier_category')->select();
        $id_key_list = array();
        foreach ($lists as $row) {
            $row['isdel'] = 0;
            $id_key_list[$row['id']] = $row;
        }

        $categroy_all = array();
        foreach ($lists as $l) {
            $categroy_all[$l['id']] = $this->returnname($l, $id_key_list);
        }

        $category_list = array();
        foreach ($id_key_list as $r) {
            if (empty($r['isdel']))
                $category_list[] = $categroy_all[$r['id']];
        }
        $wxCardPack = $this->wxHandle();
        $access_token = $wxCardPack->getToken();
        $res = $wxCardPack->GetApplyProtocol($access_token);
        $old = array();
        foreach ($res['category_list'] as $row) {
            if (in_array($row, $category_list))
                continue;
            $temp = explode(',', $row);
            $index = '';
            foreach ($temp as $k => $val) {
                $lastindex = $index;
                $index .= $val;
                if (!isset($old[$index])) {
                    $fid = isset($old[$lastindex]) && $old[$lastindex] ? $old[$lastindex] : 0;
                    $id = M('cashier_category')->insert(array('fid' => $fid, 'name' => $val), true);
                    $old[$index] = $id;
                }
            }
        }
    }

    public function menu()
    {
        $cf = isset($_GET['cf']) ? trim($_GET['cf']) : '';
        $whereArr = array('mid' => $this->mid, 'ishd' => 0);
        if ($cf == 'card') {
            $whereArr['ishd'] = 1;
        }
        $lists = M('cashier_menu')->select($whereArr);
        include $this->showTpl();
    }

    public function addmenu()
    {
        $id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
        $cf = isset($_GET['cf']) ? trim($_GET['cf']) : '';
        $where = array('id' => $id, 'mid' => $this->mid);
        $cashier_menu_db = M('cashier_menu');
        $menu = $cashier_menu_db->get_one($where);
        if (IS_POST) {
            $data = array('mid' => $this->mid);
            $data['sort'] = isset($_POST['sort']) ? intval($_POST['sort']) : 0;
            $data['is_hide'] = isset($_POST['is_hide']) ? intval($_POST['is_hide']) : 0;
            $data['name'] = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
            $data['icon'] = isset($_POST['icon']) ? htmlspecialchars($_POST['icon']) : '';
            $data['url'] = isset($_POST['url']) ? htmlspecialchars($_POST['url']) : '';
            $ishd = isset($_POST['cf']) ? trim($_POST['cf']) : '';
            if ($ishd == 'card') {
                $data['ishd'] = 1;
            }
            if (empty($data['name']))
                $this->dexit(array('errcode' => 1, 'errmsg' => '菜单名称不能为空'));
            if ($menu) {
                $cashier_menu_db->update($data, $where);
            } else {
                $cashier_menu_db->insert($data);
            }
            $this->dexit(array('errcode' => 0, 'errmsg' => 'ok'));
        } else {
            $url_array = parse_url($_SERVER['HTTP_REFERER']);
            $host_url = $url_array['scheme'] . '://' . $url_array['host'];
            include $this->showTpl();
        }
    }

    public function delmenu()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        M('cashier_menu')->delete(array('id' => $id, 'mid' => $this->mid));
        $this->dexit(array('errcode' => 1, 'errmsg' => 'ok'));
    }

    public function chnagehide()
    {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $is_hide = isset($_POST['is_hide']) ? intval($_POST['is_hide']) : 0;
        M('cashier_menu')->update(array('is_hide' => $is_hide), array('id' => $id, 'mid' => $this->mid));
        exit();
    }

    /*     * *****支付优惠***收银台里最没意思的功能-_-***** */

    public function payreduce()
    {
        $payreduceDb = M('cashier_payreduce');
        bpBase::loadOrg('common_page');
        $where = array('mid' => $this->mid);
        $_count = $payreduceDb->count($where);
        $p = new Page($_count, 20);
        $pagebar = $p->show(2);
        $payreduce = $payreduceDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
        include $this->showTpl();
    }

    public function dopayreduce()
    {
        $data = $this->clear_html($_POST);
        $idd = 0;
        if (isset($data['idd'])) {
            $idd = !empty($data['idd']) ? intval($data['idd']) : 0;
            unset($data['idd']);
        }
        if (empty($data['ntitle'])) {
            $this->dexit(array('error' => 1, 'errmsg' => '标题必须填写！'));
        }

        if (empty($data['fullprice']) || !is_numeric($data['fullprice'])) {
            $this->dexit(array('error' => 1, 'errmsg' => '使用门槛金额必须要填写！'));
        }

        if (empty($data['minprice']) || !is_numeric($data['minprice'])) {
            $this->dexit(array('error' => 1, 'errmsg' => '减价金额区间最低金额必须要填写！'));
        }

        if (!empty($data['maxprice']) && is_numeric($data['maxprice']) && ($data['maxprice'] <= $data['minprice'])) {
            $this->dexit(array('error' => 1, 'errmsg' => '减价金额区间最高金额必须大于最低金额，或者可以不填写'));
        }

        $data['starttime'] = !empty($data['starttime']) ? strtotime($data['starttime']) : 0;
        $data['starttime'] = $data['starttime'] > 0 ? $data['starttime'] : 0;

        $data['endtime'] = !empty($data['endtime']) ? strtotime($data['endtime']) : 0;
        $data['endtime'] = $data['endtime'] > 0 ? $data['endtime'] + 86399 : 0;
        $data['ptypewx'] = !empty($data['ptypewx']) ? intval($data['ptypewx']) : 0;
        $data['ptypeali'] = !empty($data['ptypeali']) ? intval($data['ptypeali']) : 0;
        $payreduceDb = M('cashier_payreduce');
        if ($idd > 0) {
            if ($payreduceDb->update($data, array('id' => $idd, 'mid' => $this->mid))) {
                $this->dexit(array('error' => 0, 'errmsg' => '修改成功！'));
            } else {
                $this->dexit(array('error' => 1, 'errmsg' => '修改失败！'));
            }
        } else {
            $data['mid'] = $this->mid;
            $data['addtime'] = SYS_TIME;
            if ($payreduceDb->insert($data, true)) {
                $this->dexit(array('error' => 0, 'errmsg' => '添加成功！'));
            } else {
                $this->dexit(array('error' => 1, 'errmsg' => '添加失败！'));
            }
        }
    }

    public function delReduce()
    {
        $idd = intval($_POST['iid']);
        $payreduceDb = M('cashier_payreduce');
        if ($idd > 0) {
            if ($payreduceDb->delete(array('id' => $idd, 'mid' => $this->mid))) {
                $this->dexit(array('error' => 0, 'errmsg' => '删除成功！'));
            }
        }
        $this->dexit(array('error' => 1, 'errmsg' => '删除失败！'));
    }

    /*     * ***获取一条数据**** */

    public function getonereduce()
    {
        $idd = intval($_POST['iid']);
        if ($idd > 0) {
            $payreduceDb = M('cashier_payreduce');
            $payreduce = $payreduceDb->get_one(array('id' => $idd, 'mid' => $this->mid), '*');
            if (!empty($payreduce)) {
                $payreduce['starttimeStr'] = $payreduce['starttime'] > 0 ? date('Y-m-d', $payreduce['starttime']) : '';
                $payreduce['endtimeStr'] = $payreduce['endtime'] > 0 ? date('Y-m-d', $payreduce['endtime']) : '';
                $this->dexit(array('error' => 0, 'errmsg' => 'OK', 'data' => $payreduce));
            }
        }
        $this->dexit(array('error' => 1, 'errmsg' => '获取数据失败！'));
    }


    /**
     * 代理商 提现
     */
    public function deposit()
    {

//        接受提现数据
        $aid = $_POST['aid'];
        $id = explode(',', $_POST['id']);
        $month = strtotime(date('Y-m-16 00:00:00', strtotime(date("Y-m-d"))));//固定每月15号以后才能提现
        //判断日期是否到
        if (time() < $month) {
            echo json_encode(['status' => 0, 'error' => '提现日期还未到 每月16号方可以提现!']);
            exit();
        }
//        根据aid查看银行卡配置信息
        $res = M('cashier_bank')->select(['aid' => $aid, 'bank' => 1], '*');
        if (empty($res)) {
            echo json_encode(['status' => 0, 'error' => '银行卡信息没有通过审核或者银行卡资料没有填写!']);
            exit();
        }
//        根据提现id 查出代理商提现有多少钱必须大于10元才能提现
        $money = 0;
        foreach ($id as $v) {
            $result = M('cashier_agent_commission')->select(['id' => $v], 'count_deposit');
            $money = $money + $result[0]['count_deposit'];
        }
        if ($money < 10) {
            echo json_encode(['status' => 0, 'error' => '提现金额必须大于10元!']);
            exit();
        }

        //如果银行卡资料正常 就把提现状态更改
        foreach ($id as $v) {
            $data = M('cashier_agent_commission')->update(['status' => 3, 'addtime' => time()], ['id' => $v]);
        }
        if ($data) {
            //        根基id把代理商数据全部查出来统计提现金额
            $moneys = 0;
            $count_money = 0;
            foreach ($id as $v) {
                $str = M('cashier_agent_commission')->select(['id' => $v], '*');
                $count_money = $count_money + $str[0]['count_turnover'];
                $moneys = $moneys + $str[0]['count_deposit'];
                $arr = [
                    'aid' => $str[0]['aid'],
                    'name' => $str[0]['name'],
                    'addtime' => $str[0]['addtime'],
                    'count_turnover' => $count_money,
                    'count_deposit' => $moneys-3,
                    'status' => 4,
                ];
            }
            M('cashier_agent_commission')->insert($arr);

            echo json_encode(['status' => 1, 'error' => '提现成功 正在努力审核中!']);
            exit();
        }
        echo json_encode(['status' => 0, 'error' => '提现失败 正在努力查看原因!']);
    }
}


?>