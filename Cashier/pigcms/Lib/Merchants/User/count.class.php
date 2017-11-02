<?php

bpBase::loadAppClass('common', 'User', 0);

class count_controller extends common_controller
{
    public function __construct()
    {
        parent::__construct();

    }
    //商户统计
    public function index()
    {
        $getdata = $this->clear_html($_GET);
//        dump($getdata);exit();
        $username = M('cashier_merchants')->select(['username' => $_SESSION['USERNAME']], 'mtype');
        $whereStr = 'ordr.ispay="1" AND ordr.mid=' . $this->mid;
        $wherecStr = 'ispay="1" AND mid=' . $this->mid;
        if (!empty($getdata['start'])) {
            //指定查询日期查询 开始时间
            if ($username[0]['mtype'] == 2) {
                //判断是否是大商户 大商户的查询时间是23:00  到第二天的23:00
                $start = ((isset($getdata['start']) ? strtotime($getdata['start'] . '-1 day 23:00:00') : 0));
                $getdatastart = date('Y-m-d H:i:s', strtotime($getdata['start'] . '23:00:00'));
                $_SESSION['SHTimeStart'] = date('Y-m-d H:i:s',strtotime($getdata['start'] . '-1 day 23:00:00'));
            } else {
                //不是大商户
                $start = ((isset($getdata['start']) ? strtotime($getdata['start'] . ' 00:00:00') : 0));
                $getdatastart = date($getdata['start'] . ' 00:00:00', time());
                $_SESSION['SHTimeStart'] = $getdata['start'] . ' 00:00:00';
            }
        } else {
            //没有指定时间的时候
            if ($username[0]['mtype'] == 2) {//判断是否是大商户 大商户的查询时间是23:00  到第二天的23:00
                $getdatastart = date($getdata['start'] . ' 23:00:00', time());
                $start = strtotime(date('Y-m-d 23:00:00', strtotime('-1 day')));
                $_SESSION['SHTimeStart'] = strtotime(date('Y-m-d 23:00:00', strtotime('-1 day')));
            } else {
                $getdatastart = date($getdata['start'] . ' 00:00:00', time());
                $start = strtotime(date('Y-m-d 00:00:00', time()));
                $_SESSION['SHTimeStart'] = date('Y-m-d 00:00:00', time());
            }

        }
        if (!empty($getdata['end'])) {
//            结束时间
//            指定时间大商户
            if ($username[0]['mtype'] == 2) {
                //判断是否是大商户 大商户的查询时间是23:00  到第二天的23:00
                $end = ((isset($getdata['end']) ? strtotime($getdata['end'] . " 22:59:59") : 0));
                $getdataend = $getdata['end'] . " 22:59:59";
                $_SESSION['SHTimeEnd'] = $getdata['end'] . " 22:59:59";
            } else {
//                不是大商户的
                $end = ((isset($getdata['end']) ? strtotime($getdata['end'] . " 23:59:59") : 0));
                $getdataend = $getdata['end'] . " 23:59:59";
                $_SESSION['SHTimeEnd'] = $getdata['end'] . " 23:59:59";
            }

        } else {
            if ($username[0]['mtype'] == 2) {//结束时间是当天晚上23:00结束
                $getdataend = date('Y-m-d 22:59:59', time());
                $end = strtotime(date('Y-m-d 22:59:59', time()));
                $_SESSION['SHTimeEnd'] = date('Y-m-d 22:59:59', time());
            } else {//不是大商户的不变
                $getdataend = date('Y-m-d 23:59:59', time());
                $end = strtotime(date('Y-m-d 23:59:59', time()));
                $_SESSION['SHTimeEnd'] = date('Y-m-d 23:59:59', time());
            }
        }

        $this->isMonthAcross($getdatastart, $getdataend);
        if (0 < $start) {
            $wherecStr .= ' AND paytime>=' . $start;
            $whereStr .= ' AND ordr.paytime>=' . $start;
        }
        if (0 < $end) {
            if ($_SESSION['SHTimeEnd']) {
//                $end+=86400;
            }
            $wherecStr .= ' AND paytime<' . $end;
            $whereStr .= ' AND ordr.paytime<' . $end;
        }

        if ($getdata['type']) {
            $wherepay = " AND pay_way='" . $getdata['type'] . "'";
            $_SESSION['SHType'] = $getdata['type'];
        } elseif (!empty($_GET['page']) && !empty($_SESSION['SHType'])) {
            $wherepay = " AND pay_way='" . $_SESSION['SHType'] . "'";
            $getdata['type'] = $_SESSION['SHType'];
        } else {
            $wherepay = "";
            $_SESSION['SHType'] = null;
        }
        bpBase::loadOrg('common_page');
        $orderDb = M('cashier_order');
        $db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
        unset($db_config);
        $_count = $orderDb->count($wherecStr . $wherepay);
        $p = new Page($_count, 10);
        $pagebar = $p->show(2);
        $sqlStr = 'SELECT ordr.*,s.business_name,s.branch_name FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_stores AS s ON ordr.storeid=s.id where ' . $whereStr . $wherepay;
        $sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
        $sqlObj = new model();
        $neworder = $sqlObj->selectBySql($sqlStr);
        //统计zz
        //微信统计
        $sql1 = "SELECT SUM(`goods_price`) as count FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr . ' AND ordr.pay_way="weixin"';
        $weixin = $sqlObj->get_varBySql($sql1, 'count');
        $income_sql = "SELECT SUM(`income`) as count FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr . ' AND ordr.pay_way="weixin"';
        $weixin_income = $sqlObj->get_varBySql($income_sql, 'count') ?: 0;
        if (!$weixin) {
            $weixin = 0;
        }
        //支付宝统计
        $sql2 = "SELECT SUM(`goods_price`) as count FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr . ' AND ordr.pay_way="alipay"';
        $alipay = $sqlObj->get_varBySql($sql2, 'count');
        $income_sql2 = "SELECT SUM(`income`) as count FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr . ' AND ordr.pay_way="alipay"';
        $alipay_income = $sqlObj->get_varBySql($income_sql2, 'count') ?: 0;
        if (!$alipay) {
            $alipay = 0;
        }
        //qq统计
        $sql4 = "SELECT SUM(`goods_price`) as count FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr . ' AND ordr.pay_way="qq"';
        $qq = $sqlObj->get_varBySql($sql4, 'count');
        $income_sql4 = "SELECT SUM(`income`) as count FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr . ' AND ordr.pay_way="qq"';
        $qq_income = $sqlObj->get_varBySql($income_sql4, 'count') ?: 0;
        if (!$qq) {
            $qq = 0;
        }
        $mtype=M('cashier_merchants')->get_one(array('mid'=>$this->mid));
        $mtype=$mtype['mtype'];
        
        //总金额统计
        $sql3 = "SELECT SUM(`goods_price`) as count FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr;
        $total = $sqlObj->get_varBySql($sql3, 'count');
        $income_sql3 = "SELECT SUM(`income`) as count FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr;
        $total_income = $sqlObj->get_varBySql($income_sql3, 'count') ?: 0;
        if (!$total) {
            $total = 0;
        }
        $sub_merchant = M("cashier_merchants")->get_one(array("mid" => $this->mid), "sub_merchant,mtype");
        if ($sub_merchant['mtype'] == 2 && $sub_merchant['sub_merchant'] != 1) {
            $sub = true;
        } else {
            $sub = false;
        }
        if ($this->isMobile()) {
            include $this->showTpl("indexwap");
        } else {
            include $this->showTpl();
        }
    }


    //商户自助退款
    public function tuikuan()
    {
        //订单id
        $id=$_POST['id'];

        //商户mid
        $mid=$_POST['mid'];

        //退款金额
        $money=$_POST['rendermoney'];

        //获取订单支付信息
        $paytime=M('cashier_order')->select(array('id'=>$id),'*');

        //实际支付金额
        $rendermoney=$paytime[0]['goods_price']-$money;

        //民生银行退款参数
        $data=array(
            'orderDate'=>$paytime[0]['paytime'],//原商品订单的日期yyyyMMdd
            'orderNo'=>$paytime[0]['order_id'],//原交易商户订单号
            'returnUrl'=>'https://pay.yunjifu.net/',
            'notifyUrl' =>'https://pay.yunjifu.net/',
            'transAmt'=>$money*100,//申请退货金额，单位为分
            'refundReson'=>"退款"//退货原因
        );

        //引用民生银行接口文件
        require_once("./MinShengBank.class.php");

        //实例化
        $bank = new MinShengBank();
        //请求退款
        $res=$bank->refundOrder($data);
        //判断是否退款成功
        if($res['respCode']=='0000'){
            M('cashier_order')->update(array('refund'=>2,'income'=>$rendermoney),array('id'=>$id));
            echo json_encode($res);
        }
        else{
            $res=$bank->queryOrder($paytime[0]['order_id'],$paytime[0]['paytime']);
            if($res['origRespCode']=='0000'&&$res['respCode']==='0000'){
                M('cashier_order')->update(array('refund'=>2,'income'=>$rendermoney),array('id'=>$id));
                echo json_encode($res);
            }
        }

    }


    //门店统计
    public function store()
    {
        $getdata = $this->clear_html($_GET);
        $whereStr = 'ispay="1" ';
        $wherecStr = 'ispay="1" AND mid=' . $this->mid;
        //搜索门店
        if ($getdata['branch_name']) {
            $where = " AND business_name like '%" . $getdata['branch_name'] . "%'";
            $_SESSION['SHLike'] = $getdata['branch_name'];
        } elseif (!empty($_GET['page']) && !empty($_SESSION['SHLike'])) {
            $where = " AND business_name like '%" . $_SESSION['SHLike'] . "%'";
        } else {
            $_SESSION['SHLike'] = null;
        }
        if (!empty($getdata['start']) || !empty($getdata['end'])) {
            $this->isMonthAcross($getdata['start'], $getdata['end']);
            $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
            $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));
            $_SESSION['SHTimeStart'] = $getdata['start'];
            $_SESSION['SHTimeEnd'] = $getdata['end'];
        } elseif (!empty($_GET['page']) && (!empty($getdata['start']) || !empty($getdata['end']))) {
            $getdata['start'] = $_SESSION['SHTimeStart'];
            $getdata['end'] = $_SESSION['SHTimeEnd'];
            $this->isMonthAcross($_SESSION['SHTimeStart'], $_SESSION['SHTimeEnd']);
            $start = ((isset($_SESSION['SHTimeStart']) ? strtotime($_SESSION['SHTimeStart']) : 0));
            $end = ((isset($_SESSION['SHTimeEnd']) ? strtotime($_SESSION['SHTimeEnd']) : 0));
        } else {
            $start = strtotime(date('Y-m-d', time()));
            $end = time();
            $_SESSION['SHTimeStart'] = null;
            $_SESSION['SHTimeEnd'] = null;
        }


        if (0 < $start) {
            $whereStr .= ' AND paytime>=' . $start;
        } else {

        }
        if (0 < $end) {
            if ($getdata['end']) {
                $end += 86400;
            }
            $whereStr .= ' AND paytime<' . $end;
        } else {

        }
        bpBase::loadOrg('common_page');
        $orderDb = M('cashier_stores');
        $db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
        unset($db_config);

        $sqlObj = new model();

        $_count = $orderDb->count("isshow='1' AND mid=" . $this->mid . $where);
        $p = new Page($_count, 10);
        $pagebar = $p->show(2);

        $sql = 'SELECT DISTINCT id,id,branch_name,business_name FROM ' . $tablepre . 'cashier_stores where isshow="1" AND mid=' . $this->mid . $where;


        $sql = $sql . ' ORDER BY id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;


        $store = $sqlObj->selectBySql($sql);

        //微信统计

        foreach ($store as $k => &$v) {
            //微信统计
            $wxsumsql = "SELECT SUM(`goods_price`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="weixin" AND storeid=' . $v['id'];
            $v['wxtotal_price'] = $sqlObj->get_varBySql($wxsumsql, 'count') ?: 0;
            $wxnumsql = "SELECT count(*) as num FROM " . $tablepre . 'cashier_order where ' . $whereStr . ' AND pay_way="weixin" AND storeid=' . $v['id'];
            $v['wxcount'] = $sqlObj->get_varBySql($wxnumsql, 'num');
            $wxincomesql = "SELECT SUM(`income`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="weixin" AND storeid=' . $v['id'];
            $v['wxincome'] = $sqlObj->get_varBySql($wxincomesql, 'count') ?: 0;
            
            
            //支付宝统计
            $alisumsql = "SELECT SUM(`goods_price`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="alipay" AND storeid=' . $v['id'];
            $v['alitotal_price'] = $sqlObj->get_varBySql($alisumsql, 'count') ?: 0;
            $alinumsql = "SELECT count(*) as num FROM " . $tablepre . 'cashier_order where ' . $whereStr . ' AND pay_way="alipay" AND storeid=' . $v['id'];
            $v['alicount'] = $sqlObj->get_varBySql($alinumsql, 'num');
            $aliincomesql = "SELECT SUM(`income`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="alipay" AND storeid=' . $v['id'];
            $v['aliincome'] = $sqlObj->get_varBySql($aliincomesql, 'count') ?: 0;
            
            //qq统计
            $qqsumsql = "SELECT SUM(`goods_price`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="qq" AND storeid=' . $v['id'];
            $v['qqtotal_price'] = $sqlObj->get_varBySql($qqsumsql, 'count') ?: 0;
            $qqnumsql = "SELECT count(*) as num FROM " . $tablepre . 'cashier_order where ' . $whereStr . ' AND pay_way="qq" AND storeid=' . $v['id'];
            $v['qqcount'] = $sqlObj->get_varBySql($qqnumsql, 'num');
            $qqincomesql = "SELECT SUM(`income`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="qq" AND storeid=' . $v['id'];
            $v['qqincome'] = $sqlObj->get_varBySql($qqincomesql, 'count') ?: 0;
            //总金额.总笔数.实收金额
            $sum += $v['wxtotal_price'] + $v['alitotal_price']+$v['qqtotal_price'];
            $num += $v['wxcount'] + $v['alicount']+$v['qqcount'];
            $income += $v['wxincome'] + $v['aliincome']+$v['qqincome'];
            unset($v);
        }
        $mtype=M('cashier_merchants')->get_one(array('mid'=>$this->mid));
        $mtype=$mtype['mtype'];
        if ($this->isMobile()) {
            include $this->showTpl("storewap");
        } else {
            include $this->showTpl();
        }
    }


    //门店统计详情
    public function storesdetail()
    {
        $getdata = $this->clear_html($_GET);
        if ($_GET['id']) {
            $this->sismid($_GET['id']);
            $_SESSION['storeid'] = $_GET['id'];
        }
        $whereStr = 'ordr.ispay="1" AND ordr.mid=' . $this->mid . ' AND ordr.storeid=' . $_SESSION['storeid'];
        $wherecStr = 'ispay="1" AND mid=' . $this->mid . ' AND storeid=' . $_SESSION['storeid'];

        if (!empty($getdata['start']) || !empty($getdata['end'])) {
            $this->isMonthAcross($getdata['start'], $getdata['end']);
            $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
            $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));
            $_SESSION['SHTimeStart'] = $getdata['start'];
            $_SESSION['SHTimeEnd'] = $getdata['end'];
        } elseif (!empty($_GET['page']) && (!empty($getdata['start']) || !empty($getdata['end']))) {
            $getdata['start'] = $_SESSION['SHTimeStart'];
            $getdata['end'] = $_SESSION['SHTimeEnd'];
            $this->isMonthAcross($_SESSION['SHTimeStart'], $_SESSION['SHTimeEnd']);
            $start = ((isset($_SESSION['SHTimeStart']) ? strtotime($_SESSION['SHTimeStart']) : 0));
            $end = ((isset($_SESSION['SHTimeEnd']) ? strtotime($_SESSION['SHTimeEnd']) : 0));
        } else {
            $start = strtotime(date('Y-m-d', time()));
            $end = time();
            $getdata['start'] = $_SESSION['SHTimeStart'] = date("Y-m-d", $start);
            $getdata['end'] = $_SESSION['SHTimeEnd'] = date("Y-m-d", $end);
        }


        if (0 < $start) {
            $wherecStr .= ' AND paytime>=' . $start;
            $whereStr .= ' AND ordr.paytime>=' . $start;
        }


        if (0 < $end) {
            if ($getdata['end']) {
                $end += 86400;
            }
            $wherecStr .= ' AND paytime<' . $end;
            $whereStr .= ' AND ordr.paytime<' . $end;
        }
        if ($getdata['type']) {
            $wherepay = " AND pay_way='" . $getdata['type'] . "'";
            $_SESSION['SHType'] = $getdata['type'];
        } elseif (!empty($_GET['page']) && !empty($_SESSION['SHType'])) {
            $wherepay = " AND pay_way='" . $_SESSION['SHType'] . "'";
            $getdata['type'] = $_SESSION['SHType'];
        } else {
            $wherepay = "";
            $_SESSION['SHType'] = null;
        }

        bpBase::loadOrg('common_page');
        $orderDb = M('cashier_order');
        $db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
        unset($db_config);


        $_count = $orderDb->count($wherecStr . $wherepay);
        $p = new Page($_count, 10);
        $pagebar = $p->show(2);
        $sqlStr = 'SELECT ordr.*,e.username FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_employee AS e ON ordr.eid=e.eid where ' . $whereStr . $wherepay;
        $sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;

        $sqlObj = new model();

        $neworder = $sqlObj->selectBySql($sqlStr);
        //统计
        //微信统计
        $sql1 = "SELECT SUM(`goods_price`) as count,SUM(`income`) as income FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr . ' AND ordr.pay_way="weixin"';
        $weixin = $sqlObj->selectBySql($sql1);
        $weixin[0]['count'] ? $weixin['count'] = $weixin[0]['count'] : $weixin['count'] = 0;
        $weixin[0]['income'] ? $weixin['income'] = $weixin[0]['income'] : $weixin['income'] = 0;
        
        //支付宝统计
        $sql2 = "SELECT SUM(`goods_price`) as count,SUM(`income`) as income FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr . ' AND ordr.pay_way="alipay"';
        $alipay = $sqlObj->selectBySql($sql2);
        $alipay[0]['count'] ? $alipay['count'] = $alipay[0]['count'] : $alipay['count'] = 0;
        $alipay[0]['income'] ? $alipay['income'] = $alipay[0]['income'] : $alipay['income'] = 0;

        //qq统计
        $sql4 = "SELECT SUM(`goods_price`) as count,SUM(`income`) as income FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr . ' AND ordr.pay_way="qq"';
        $qqpay = $sqlObj->selectBySql($sql4);
        $qqpay[0]['count'] ? $qqpay['count'] = $qqpay[0]['count'] : $qqpay['count'] = 0;
        $qqpay[0]['income'] ? $qqpay['income'] = $qqpay[0]['income'] : $qqpay['income'] = 0;
        
        $sql3 = "SELECT SUM(`goods_price`) as count,SUM(`income`) as income FROM " . $tablepre . 'cashier_order as ordr where ' . $whereStr;
        $total = $sqlObj->selectBySql($sql3);

        $total[0]['count'] ? $total['count'] = $total[0]['count'] : $total['count'] = 0;
        $total[0]['income'] ? $total['income'] = $total[0]['income'] : $total['income'] = 0;
        $neworder = $this->ProcssOdata($neworder, $this->mid);
        $sub_merchant = M("cashier_merchants")->get_one(array("mid" => $this->mid), "sub_merchant,mtype");
        if ($sub_merchant['mtype'] == 2 && $sub_merchant['sub_merchant'] != 1) {
            $sub = true;
        } else {
            $sub = false;
        }
        $mtype=M('cashier_merchants')->get_one(array('mid'=>$this->mid));
        $mtype=$mtype['mtype'];
        if ($this->isMobile()) {
            $stor = M("cashier_stores")->get_one("id=" . $_SESSION['storeid'], "*");
            $storname = $stor['business_name'] . "&nbsp;" . $stor['branch_name'];
            include $this->showTpl("storesdetailwap");
        } else {
            include $this->showTpl();
        }
    }


    /**
     * 商户统计导出excel
     */

    public function MerchantExcel()
    {
//        dump($_POST);
//        dump($_SESSION);
//        exit;
        $size = 5000;
        $page = isset($_GET['p']) && intval($_GET['p']) ? intval($_GET['p']) : 0;

        if ($page == 0) {
            if (file_exists($this->mid . ".txt")) {
                if (time() - filectime($this->mid . ".txt") < 60 * 10) {
                    die('<script>alert("任务已存在请稍后！");window.location.href="/merchants.php?m=User&c=count&a=index";</script>');
                }
            }
            file_put_contents($this->mid . ".txt", '');
        }

        if (IS_POST || 1) {
            ini_set('memory_limit', '250M');

            $filename = "";
            if (!empty($_SESSION['SHTimeStart']) || !empty($_SESSION['SHTimeEnd'])) {
                $this->isMonthAcross($_SESSION['SHTimeStart'], $_SESSION['SHTimeEnd']);
                $start = ((isset($_SESSION['SHTimeStart']) ? strtotime($_SESSION['SHTimeStart']) : 0));
                $end = ((isset($_SESSION['SHTimeEnd']) ? strtotime($_SESSION['SHTimeEnd']) : 0));
                $filename = $_SESSION['SHTimeStart'] . "至" . $_SESSION['SHTimeEnd'];
                if (0 < $start) {
                    $whereStr .= ' AND ordr.paytime>=' . $start;
                }
                if (0 < $end) {
//                    if($_SESSION['SHTimeEnd']){
//                        $end+=86400;
//                    }
                    $whereStr .= ' AND ordr.paytime<' . $end;
                }
            } else {
                $whereStr = '';
            }
            if (!empty($_SESSION['SHType'])) {
                $wherepay = " AND pay_way='" . $_SESSION['SHType'] . "'";
            } else {
                $wherepay = "";
            }
            $db_config = loadConfig('db');
            $tablepre = $db_config['default']['tablepre'];
            //查询条件
            $whereStr = 'ordr.ispay="1" AND ordr.mid=' . $this->mid . " " . $whereStr . $wherepay;
            //拼装sql
            $sqlStr = 'SELECT ordr.*,s.company,t.business_name,t.branch_name FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_merchants AS s ON ordr.mid=s.mid LEFT JOIN ' . $tablepre . 'cashier_stores AS t ON ordr.storeid=t.id  where ' . $whereStr;
            $sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC LIMIT ' . ($size * $page) . ',' . $size . ' ';
            $sqlStr_num = 'SELECT count(*)as num FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_merchants AS s ON ordr.mid=s.mid LEFT JOIN ' . $tablepre . 'cashier_stores AS t ON ordr.storeid=t.id  where ' . $whereStr;

            $sqlObj = new model();
            $neworder = $sqlObj->selectBySql($sqlStr);
            $sqlnumber = $sqlObj->selectBySql($sqlStr_num);

            //拼装导出excel数据
            $data = array();
            foreach ($neworder as $key => $val) {
//                $data[$key]['id']           = $val['id'];//id
                $data[$key]['order_id'] = '订单号：' . $val['order_id'];//交易单号
                $data[$key]['goods_price'] = $val['goods_price'];//应收金额
                //退款金额
                if ($val['refund'] == '2') {
                    $data[$key]['refund'] = $val['goods_price'] - $val['income'];
                } else {
                    $data[$key]['refund'] = '0.00';
                }
                //实收金额
                $data[$key]['receipts'] = $val['income'];

                $data[$key]['paytime'] = date('Y-m-d H:i:s', $val['paytime']);//交易时间
                //交易类型
                if ($val['pay_way'] == 'weixin') {
                    $data[$key]['pay_way'] = '微信支付';
                } else if ($val['pay_way'] == 'alipay') {
                    $data[$key]['pay_way'] = '支付宝城市';
                }
                $data[$key]['goods_describe'] = $val['goods_describe'];//付款方式
                $data[$key]['extrainfo']=$val['extrainfo'];
                $data[$key]['branch_name'] = $val['business_name'] . ' ' . $val['branch_name'];//门店
                if ($val['refund'] == '2') {
                    $data[$key]['type'] = '已退款';
                } else {
                    $data[$key]['type'] = '正常订单';
                }
            }
//            $title = array('序号','交易单号','应收金额','退款金额','实收金额','交易时间','交易类型','付款方式','门店','退款状态');
            $title = array('交易单号', '应收金额', '退款金额', '实收金额', '交易时间', '交易类型', '付款方式','用户留言', '门店', '退款状态');
            $filename = '商家:【' . $this->merchant['company'] . '】下的交易订单.xls';
            $this->ExportTable($data, $title, $filename, $page, $sqlnumber[0]["num"] / $size);
        }
    }


    /**
     * 门店统计导出excel
     */

    public function StoreExcel()
    {
        if (IS_POST) {
            ini_set('memory_limit', '250M');
            $whereStr = 'ispay="1"';
            $wherecStr = 'ispay="1" AND mid=' . $this->mid;
            if (!empty($_SESSION['SHLike'])) {
                $where = " AND business_name like '%" . $_SESSION['SHLike'] . "%'";
            }
            if (!empty($_SESSION['SHTimeStart']) || !empty($_SESSION['SHTimeEnd'])) {
                $this->isMonthAcross($_SESSION['SHTimeStart'], $_SESSION['SHTimeEnd']);
                $start = ((isset($_SESSION['SHTimeStart']) ? strtotime($_SESSION['SHTimeStart']) : 0));
                $end = ((isset($_SESSION['SHTimeEnd']) ? strtotime($_SESSION['SHTimeEnd']) : 0));
                if (0 < $start) {
                    $whereStr .= ' AND paytime>=' . $start;
                }
                if (0 < $end) {
                    if ($end) {
                        $end += 86400;
                    }
                    $whereStr .= ' AND paytime<' . $end;
                }
            }
            //搜索门店
            bpBase::loadOrg('common_page');
            $orderDb = M('cashier_stores');
            $db_config = loadConfig('db');
            $tablepre = $db_config['default']['tablepre'];
            unset($db_config);

            $sqlObj = new model();

            $sql = 'SELECT DISTINCT id,id,branch_name,business_name FROM ' . $tablepre . 'cashier_stores where isshow="1" AND mid=' . $this->mid . $where;
            $sql = $sql . ' ORDER BY id DESC';
            $store = $sqlObj->selectBySql($sql);

            $i = 0;
            $data = array();
            $mtype=M('cashier_merchants')->get_one(array('mid'=>$_SESSION['mid']));$mtype=$mtype['mtype'];
            foreach ($store as $k => &$v) {
                //微信统计
                $data[$i]['branch_name'] = $v['branch_name'] . ' ' . $v['business_name'];
                $data[$i]['pay'] = '微信支付';
                $wxsumsql = "SELECT SUM(`goods_price`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="weixin" AND storeid=' . $v['id'];
                $data[$i]['total_price'] = $sqlObj->get_varBySql($wxsumsql, 'count') ?: 0;
                $wxnumsql = "SELECT count(*) as num FROM " . $tablepre . 'cashier_order where ' . $whereStr . ' AND pay_way="weixin" AND storeid=' . $v['id'];
                $data[$i]['count'] = $sqlObj->get_varBySql($wxnumsql, 'num');
                $wxincomesql = "SELECT SUM(`income`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="weixin" AND storeid=' . $v['id'];
                $data[$i]['income'] = $sqlObj->get_varBySql($wxincomesql, 'count') ?: 0;
                
                if($mtype!=3){
                    //支付宝统计
                    $i++;
                    $data[$i]['branch_name'] = $v['branch_name'] . ' ' . $v['business_name'];
                    $data[$i]['pay'] = '支付宝';
                    $alisumsql = "SELECT SUM(`goods_price`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="alipay" AND storeid=' . $v['id'];
                    $data[$i]['total_price'] = $sqlObj->get_varBySql($alisumsql, 'count') ?: 0;
                    $alinumsql = "SELECT count(*) as num FROM " . $tablepre . 'cashier_order where ' . $whereStr . ' AND pay_way="alipay" AND storeid=' . $v['id'];
                    $data[$i]['count'] = $sqlObj->get_varBySql($alinumsql, 'num');
                    $aliincomesql = "SELECT SUM(`income`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="alipay" AND storeid=' . $v['id'];
                    $data[$i]['income'] = $sqlObj->get_varBySql($aliincomesql, 'count') ?: 0;
                    $i++;
                }
                 if($mtype==3){                   
                    //qq统计
                    $data[$i]['branch_name'] = $v['branch_name'] . ' ' . $v['business_name'];
                    $data[$i]['pay'] = 'qq';
                    $qqsumsql = "SELECT SUM(`goods_price`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="qq" AND storeid=' . $v['id'];
                    $data[$i]['total_price'] = $sqlObj->get_varBySql($qqsumsql, 'count') ?: 0;
                    $qqnumsql = "SELECT count(*) as num FROM " . $tablepre . 'cashier_order where ' . $whereStr . ' AND pay_way="qq" AND storeid=' . $v['id'];
                    $data[$i]['count'] = $sqlObj->get_varBySql($qqnumsql, 'num');
                    $qqincomesql = "SELECT SUM(`income`) as count FROM " . $tablepre . 'cashier_order  where ' . $whereStr . ' AND pay_way="qq" AND storeid=' . $v['id'];
                    $data[$i]['income'] = $sqlObj->get_varBySql($qqincomesql, 'count') ?: 0;
                    $i++;
                } 
            }
            $title = array('门店名称', '支付方式', '支付金额', '交易笔数', '收入');
            $filename = '商家:【' . $this->merchant['company'] . '】下的所有门店订单统计.xls';
            $this->ExportTable($data, $title, $filename);
        }
    }


    /**
     * 门店统计详情导出excel
     */
    public function StoresdetailExcel()
    {
        $getdata = $this->clear_html($_GET);
        if ($_GET['id']) {
            $_SESSION['storeid'] = $_GET['id'];
        }

        $whereStr = 'ordr.ispay="1" AND ordr.mid=' . $this->mid . ' AND ordr.storeid=' . $_SESSION['storeid'];
        $wherecStr = 'ispay="1" AND mid=' . $this->mid . ' AND storeid=' . $_SESSION['storeid'];

        if (!empty($_SESSION['SHTimeStart']) || !empty($_SESSION['SHTimeEnd'])) {
            $this->isMonthAcross($_SESSION['SHTimeStart'], $_SESSION['SHTimeEnd']);
            $start = ((isset($_SESSION['SHTimeStart']) ? strtotime($_SESSION['SHTimeStart']) : 0));
            $end = ((isset($_SESSION['SHTimeEnd']) ? strtotime($_SESSION['SHTimeEnd']) : 0));
            if (0 < $start) {
                $whereStr .= ' AND ordr.paytime>=' . $start;
            }
            if (0 < $end) {
                if ($_SESSION['SHTimeEnd']) {
                    $end += 86400;
                }
                $whereStr .= ' AND ordr.paytime<' . $end;
            }
        }
        if (!empty($_SESSION['SHType'])) {
            $whereStr .= " AND pay_way='" . $_SESSION['SHType'] . "'";
        }

        bpBase::loadOrg('common_page');
        $orderDb = M('cashier_order');
        $db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
        unset($db_config);
        $sqlStr = 'SELECT ordr.*,e.username FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_employee AS e ON ordr.eid=e.eid where ' . $whereStr;
        $sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC';

        $sqlObj = new model();
        $neworder = $sqlObj->selectBySql($sqlStr);
        $data = array();
        foreach ($neworder as $key => $val) {
            $data[$key]['id'] = $val['id'];//id
            $data[$key]['order_id'] = '订单号：' . $val['order_id'];//交易单号
            $data[$key]['goods_price'] = $val['goods_price'];//应收金额
            //退款金额
            if ($val['refund'] == '2') {
                $data[$key]['refund'] = $val['goods_price'] - $val['income'];
            } else {
                $data[$key]['refund'] = '0.00';
            }
            //实收金额

            $data[$key]['receipts'] = $val['income'];


            $data[$key]['paytime'] = date('Y-m-d H:i:s', $val['paytime']);//交易时间
            //交易类型
            if ($val['pay_way'] == 'weixin') {
                $data[$key]['pay_way'] = '微信支付';
            } else if ($val['pay_way'] == 'alipay') {
                $data[$key]['pay_way'] = '支付宝城市';
            }
            $data[$key]['goods_describe'] = $val['goods_describe'];//付款方式
            $data[$key]['branch_name'] = $val['username'];//门店
            if ($val['refund'] == '2') {
                $data[$key]['type'] = '已退款';
            } else {
                $data[$key]['type'] = '正常订单';
            }
        }
        $employee = M('cashier_stores')->get_one(array('id' => $_SESSION['storeid']), 'business_name,branch_name');
        $title = array('序号', '交易单号', '应收金额', '退款金额', '实收金额', '交易时间', '交易类型', '付款方式', '收银员', '退款状态');
        $filename = '门店:【' . $employee['business_name'] . ' ' . $employee['branch_name'] . '】下的所收银员交易订单.xls';
        $this->ExportTable($data, $title, $filename);

    }

    //判断是否跨月/跨年
    public function isMonthAcross($stime = 0, $etime = 0)
    {
        $stY = date('Y', strtotime($stime));

        $stM = date('m', strtotime($stime));

        $etY = date('Y', strtotime($etime));

        $etM = date('m', strtotime($etime));
        if (!$stime) {
            $this->errorTip('请选择开始时间!');
        }
        if (!$etime) {
            $this->errorTip('请选择结束时间!');
        }
        if ($stY != $etY) {

            $this->errorTip('您的选择的时间不能跨年');

        } else if ($stM != $etM) {

            $this->errorTip('您的选择的时间不能跨月');

        }


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
}


?>