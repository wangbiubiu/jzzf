<?php

bpBase::loadAppClass('common', 'System', 0);
class index_controller extends common_controller
{

    public function __construct()
	{
		parent::__construct();
               $this->model = M('cashier_order');
	}
        //总后台首页
	public function index()
	{

            $time = date('Y-m-d',time());
            $t = strtotime($time);
            $t1 = $t-86400;
            $t2 = $t+86400;
            //昨日交易笔数

            $number = $this->model->count(" ispay='1' AND `paytime` < ". $t ." AND `paytime`>=".$t1);
            //sql = "SELECT SUM(`income`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND  `paytime` < ". $t ." AND `paytime`>=".$t1;
            $sql = "SELECT SUM(`income`) as num FROM ".$this->tablepre."cashier_order where `paytime` between $t1 and $t and ispay='1'";
            //昨日交易金额
            $money = $this->model->get_varBySql($sql,'num')?:0;

            //今日
            //$number2 = $this->model->count(" ispay='1' AND `paytime` < ". $t2 ." AND `paytime`>=".$t);
            $number2 = $this->model->count(" `paytime` between $t and $t2 and ispay='1'");
            $sql2 = "SELECT SUM(`income`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t2 ." AND `paytime`>=".$t;
            $money2 = $this->model->get_varBySql($sql2,'num')?:0;
             
            //月累计交易总金额
            $mtime = strtotime(date('Y-m-1',time()));
            $total_sql =  "SELECT SUM(`income`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND paytime >= ".$mtime." AND paytime < ".time();
            $total_money =  $this->model->get_varBySql($total_sql,'num')?:0;
            //月累计交易笔数
            $total_num = $this->model->count(" ispay='1'  AND paytime >= ".$mtime." AND paytime < ".time());
           
            //商户数量
            $m_num = M('cashier_merchants')->count();
            //门店数量
            //$s_num = M('cashier_stores')->count();
            $sql_count = "SELECT count(*) as num FROM ".$this->tablepre."cashier_merchants as m JOIN ".$this->tablepre."cashier_stores as r ON m.mid=r.mid ";
            
            $obj = new model();
            //查询条数
            $s_num= $obj->get_varBySql($sql_count, 'num');
            
           
            
            //系统公告
            $notice = M('cashier_notice')->select('','*','10',' id desc');
            foreach($notice as &$v){
                $v['addtime'] = date('Y-m-d',$v['addtime']);
            }
            $this->assign('notice',$notice);
            
            $this->assign('number',$number);
            $this->assign('money',$money);
            $this->assign('number2',$number2);
            $this->assign('money2',$money2);
            $this->assign('total_money',$total_money);
            $this->assign('total_num',$total_num);
            $this->assign('m_num',$m_num);
            $this->assign('s_num',$s_num);

            $this->display('index');

		//header('location:?m=System&c=index&a=merLists');
	}
        public function notice(){
            $id = isset($_GET['id'])?intval($_GET['id']):0;
            $row = M('cashier_notice')->get_one(array('id'=>$id));
            $row['addtime'] = date('Y-m-d',$row['addtime']);
            $row['content'] = htmlspecialchars_decode($row['content']);
            $this->assign('row',$row);
            $this->display();
	}
        //添加公告
        public function addNotice(){
            if(IS_POST){
                 $data =$_POST;
                 $data['addtime'] = time();
                 $re = M('cashier_notice')->insert($data,1);
                 if($re){
                     $this->dexit(array('errcode'=>1,'msg'=>'添加成功'));
                 }else{
                     $this->dexit(array('errcode'=>0,'msg'=>'添加失败'));
                 }

            }else{
                $this->display();
            }  
        }
        //删除公告
        public function delNotice(){
            if(IS_POST){
                 $id =$_POST['id'];
                 $re = M('cashier_notice')->delete(array('id'=>$id));
                 if($re){
                     $this->dexit(array('code'=>1,'msg'=>'删除成功'));
                 }else{
                     $this->dexit(array('code'=>0,'msg'=>'删除失败'));
                 }
            }
        }
        
	public function ModifyPwd()
	{
		$phone = '';

		if ($this->adminuser['phone']) {
			$phone = str_replace(substr($this->adminuser['phone'], 3, 4), '****', $this->adminuser['phone']);
		}


		$this->assign('phone', $phone);
		$sms_config = loadConfig('sms');
		$issms_config = 0;
		if ($sms_config && isset($sms_config['sms_key']) && !empty($sms_config['sms_key'])) {
			$issms_config = 1;
		}


		$this->assign('is_sms', $issms_config);
		$this->display();
	}
        //商家列表
	public function merLists()
	{
		bpBase::loadOrg('common_page');
		$datas = $this->clear_html($_GET);
		$mid = intval($datas['mid']);
		$uname = trim($datas['uname']);
		$merchantsDb = M('cashier_merchants');
		if ((0 < $mid) || !empty($uname)) {
			$_count = 1;

			if (!0 < $mid && !empty($uname)) {
				$merchant = $merchantsDb->get_one(array('username' => $uname), 'mid,username,wxname');

				if (!empty($merchant) && isset($merchant['mid'])) {
				}
				 else {
				}

				$mid = 0;
			}


			$sqlStr = 'SELECT DISTINCT mer.mid,mer.*,pcf.configData FROM ' . $this->tablepre . 'cashier_merchants as mer LEFT JOIN ' . $this->tablepre . 'cashier_payconfig AS pcf ON mer.mid=pcf.mid  where mer.mid=' . $mid;
		}
		 else {
			$_count = $merchantsDb->count();
			$p = new Page($_count, 20);
			$pagebar = $p->show(2);
			$sqlStr = 'SELECT DISTINCT mer.mid,mer.*,pcf.configData FROM ' . $this->tablepre . 'cashier_merchants as mer LEFT JOIN ' . $this->tablepre . 'cashier_payconfig AS pcf ON mer.mid=pcf.mid  ORDER BY mer.mid DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		}

		$sqlObj = new model();
		$merInfo = $sqlObj->selectBySql($sqlStr);

		foreach ($merInfo as $kk => $vv ) {
			$merInfo[$kk]['configData'] = ((!empty($vv['configData']) ? unserialize(htmlspecialchars_decode($vv['configData'], ENT_QUOTES)) : ''));
		}

		$merchants = $merchantsDb->select(array('isadmin' => '0'), 'mid,username,wxname', '', 'mid DESC');

		if (!empty($merchants)) {
			foreach ($merchants as $mvv ) {
				if ($mvv['mid'] == $mid) {
					$uname = $mvv['username'];
				}

			}
		}


		$this->assign('mid', $mid);
		$this->assign('uname', (!empty($uname) ? $uname : ''));
		$this->assign('totalnum', $_count);
		$this->assign('pagebar', $pagebar);
		$this->assign('merInfo', $merInfo);
		$this->assign('merInfos', $merchants);
		$this->display();
	}

	public function changeStatus()
	{
		$mid = intval($_POST['mid']);
		$status = intval($_POST['stype']);

		if (0 < $mid) {
			$merchantsDb = M('cashier_merchants');

			if ($merchantsDb->update(array('status' => $status), array('mid' => $mid))) {
				$htmldata = '<font color="green">正常</font>';

				if ($status == 2) {
					$htmldata = '<font color="red">禁止登录</font>';
				}


				$this->dexit(array('error' => 0, 'msg' => '修改成功！', 'data' => $htmldata));
			}

		}


		$this->dexit(array('error' => 1, 'msg' => '修改失败了！'));
	}

	public function mdyMerpwd()
	{
		$datas = $this->clear_html($_POST);
		if (empty($datas['rpwdStr']) || empty($datas['mid'])) {
			$this->dexit(array('error' => 1, 'msg' => '参数出错！'));
		}


		$datas['mid'] = intval($datas['mid']);

		if ($this->adminuser['account'] == 'adminroot') {
			$merchantsDb = M('cashier_merchants');
			$theMer = $merchantsDb->get_one(array('mid' => $datas['mid']), '*');

			if (!empty($theMer)) {
				$newpwd = $this->toPassword($datas['rpwdStr'], $theMer['salt']);

				if ($merchantsDb->update(array('password' => $newpwd), array('mid' => $theMer['mid']))) {
					$this->dexit(array('error' => 0, 'msg' => '修改成功！'));
				}

			}

		}


		$this->dexit(array('error' => 1, 'msg' => '你不是超级管理员，不能修改！'));
	}
        //查询银行卡信息
	public function getCashierBank()
	{
		$mid = intval($_POST['midd']);
		if (0 < $mid) {
			$tmpbank = M('cashier_bank')->get_one(array('mid' => $mid), '*');
			if (!empty($tmpbank) && is_array($tmpbank)) {
                                $tmpbank['bank_img'] = unserialize($tmpbank['bank_img']);
				$this->dexit(array('error' => 0, 'msg' => '', 'data' => $tmpbank));
			}
		}
		$this->dexit(array('error' => 1, 'msg' => ''));
	}

	public function storeLists()
	{
		$datas = $this->clear_html($_GET);
		$mid = intval($datas['mid']);
		$uname = trim($datas['uname']);
		bpBase::loadOrg('common_page');
		$storesDb = M('cashier_stores');
		$merchantsDb = M('cashier_merchants');

		if (!0 < $mid && !empty($uname)) {
			$merchant = $merchantsDb->get_one(array('username' => $uname), 'mid,username,wxname');

			if (!empty($merchant) && isset($merchant['mid'])) {
			}
			 else {
			}

			$mid = 0;
		}


		if (0 < $mid) {
			$_count = $storesDb->count(array('mid' => $mid));
		}
		 else {
			$_count = $storesDb->count();
		}

		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$sqlStr = 'SELECT sto.*,mer.username,mer.wxname FROM ' . $this->tablepre . 'cashier_stores as sto LEFT JOIN ' . $this->tablepre . 'cashier_merchants AS mer ON sto.mid=mer.mid';

		if (0 < $mid) {
			$sqlStr .= ' where sto.mid=' . $mid . ' AND mer.mid=' . $mid;
		}


		$sqlStr .= ' ORDER BY sto.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		$sqlObj = new model();
		$storesInfo = $sqlObj->selectBySql($sqlStr);
		$merchants = $merchantsDb->select(array('isadmin' => '0'), 'mid,username,wxname', '', 'mid DESC');
		$merInfos = $mertmpInfos = array();

		if (!empty($merchants)) {
			foreach ($merchants as $mvv ) {
				$merInfos[$mvv['mid']] = $mvv;
				$mertmpInfos[] = $mvv;

				if ($mvv['mid'] == $mid) {
					$uname = $mvv['username'];
				}

			}
		}


		$this->assign('mid', $mid);
		$this->assign('uname', (!empty($uname) ? $uname : ''));
		$this->assign('merInfos', $mertmpInfos);
		$this->assign('totalnum', $_count);
		$this->assign('pagebar', $pagebar);
		$this->assign('storesInfo', $storesInfo);
		$this->display();
	}

	public function mdfysShow()
	{
		$sid = intval($_POST['sid']);

		if (0 < $sid) {
			$storesDb = M('cashier_stores');
			$tmpStore = $storesDb->get_one(array('id' => $sid), '*');

			if (0 < $tmpStore['isshow']) {
				$isshow = 0;
			}
			 else {
				$isshow = 1;
			}

			$storesDb->update(array('isshow' => $isshow), array('id' => $tmpStore['id']));
			$this->dexit(array('error' => 0, 'msg' => '', 'data' => $isshow));
		}

	}

	public function affiliatepay()
	{
		bpBase::loadOrg('common_page');
		$orderDb = M('cashier_order');
		$datas = $this->clear_html($_GET);
		$mid = intval($datas['mid']);
		$dstart = trim($datas['stime']);
		$dend = trim($datas['etime']);
		$pty = intval($datas['pty']);
		$pty = ((0 < $pty ? $pty : 0));
		$uname = trim($datas['uname']);
		$nowtime = time();
		$starttime = ((!empty($dstart) ? strtotime($dstart . ' 23:59:59') : 0));
		$endtime = strtotime($dend);

		if (0 < $starttime) {
			$endtime = ((0 < $endtime ? $endtime : $nowtime));
		}


		$merchantsDb = M('cashier_merchants');

		if (!0 < $mid && !empty($uname)) {
			$merchant = $merchantsDb->get_one(array('username' => $uname), 'mid,username,wxname');

			if (!empty($merchant) && isset($merchant['mid'])) {
			}
			 else {
			}

			$mid = 0;
		}


		$whereStr = 'pmid=' . $this->adminuser['mid'] . ' AND pay_way ="weixin" AND mchtype=1 AND ispay=1';

		if (0 < $starttime) {
			$whereStr .= ' AND paytime>' . $starttime . ' AND paytime<' . $endtime;
		}
		 else if (!0 < $starttime && (0 < $endtime)) {
			$whereStr .= ' AND paytime<' . $endtime;
		}


		$sqlStr = 'SELECT mid,sum(goods_price) as totalmoney FROM ' . $this->tablepre . 'cashier_order where ' . $whereStr . ' GROUP BY mid ORDER BY mid DESC';
		$sqlObj = new model();
		$moneyarr = $sqlObj->selectBySql($sqlStr);
		$sqlStr = 'SELECT mid,sum(goods_price) as totalmoney FROM ' . $this->tablepre . 'cashier_order where ' . $whereStr . ' AND refund=2 GROUP BY mid ORDER BY mid DESC';
		$refundarr = $sqlObj->selectBySql($sqlStr);
		$income = $refund = 0;

		if (0 < $mid) {
			if (!empty($moneyarr)) {
				foreach ($moneyarr as $mvv ) {
					if ($mvv['mid'] == $mid) {
						$income = $mvv['totalmoney'];
					}

				}
			}


			if (!empty($refundarr)) {
				foreach ($refundarr as $rvv ) {
					if ($rvv['mid'] == $mid) {
						$refund = $rvv['totalmoney'];
					}

				}
			}

		}
		 else {
			if (!empty($moneyarr)) {
				foreach ($moneyarr as $mvv ) {
					$income += $mvv['totalmoney'];
				}
			}


			if (!empty($refundarr)) {
				foreach ($refundarr as $rvv ) {
					$refund += $rvv['totalmoney'];
				}
			}

		}

		if (0 < $mid) {
			$whereStr .= ' AND mid=' . $mid;
		}


		$_count = $orderDb->count($whereStr);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$merOderInfo = $orderDb->select($whereStr, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
		$merchants = M('cashier_merchants')->select(array('isadmin' => '0'), 'mid,username,wxname', '', 'mid DESC');
		$merInfos = $mertmpInfos = array();

		if (!empty($merchants)) {
			foreach ($merchants as $mvv ) {
				$merInfos[$mvv['mid']] = $mvv;
				$mertmpInfos[] = $mvv;

				if ($mvv['mid'] == $mid) {
					$uname = $mvv['username'];
				}

			}
		}


		if (!empty($merOderInfo)) {
			foreach ($merOderInfo as $okk => $ovv ) {
				$merOderInfo[$okk]['merwxname'] = $merInfos[$ovv['mid']]['wxname'];
				$merOderInfo[$okk]['username'] = $merInfos[$ovv['mid']]['username'];

				if (!empty($ovv['truename'])) {
					$merOderInfo[$okk]['payneme'] = $ovv['truename'];
				}
				 else if (!empty($ovv['openid'])) {
					$merOderInfo[$okk]['payneme'] = $ovv['openid'];
				}
				 else if (!empty($ovv['p_openid'])) {
					$merOderInfo[$okk]['payneme'] = $ovv['p_openid'];
				}
				 else {
					$merOderInfo[$okk]['payneme'] = '未知';
				}

				$merOderInfo[$okk]['paytimestr'] = ((0 < $ovv['paytime'] ? date('Y-m-d H:i:s', $ovv['paytime']) : date('Y-m-d H:i:s', $ovv['add_time'])));

				if ($ovv['refund'] == 1) {
					$merOderInfo[$okk]['refundstr'] = '退款中...';
				}
				 else if ($ovv['refund'] == 2) {
					$merOderInfo[$okk]['refundstr'] = '已退款';
				}
				 else if ($ovv['refund'] == 3) {
					$merOderInfo[$okk]['refundstr'] = '退款失败';
				}
				 else {
					$merOderInfo[$okk]['refundstr'] = '未退款';
				}
			}
		}


		unset($merInfos);
		$this->assign('merInfos', $mertmpInfos);
		$this->assign('mid', $mid);
		$this->assign('starttime', $dstart);
		$this->assign('endtime', $dend);
		$this->assign('uname', (!empty($uname) ? $uname : ''));
		$this->assign('refund', $refund);
		$this->assign('income', $income);
		$this->assign('surplus', $income - $refund);
		$this->assign('pagebar', $pagebar);
		$this->assign('merOderInfo', $merOderInfo);
		$this->display();
	}

	public function platformpay()
	{
		bpBase::loadOrg('common_page');
		$orderDb = M('cashier_order');
		$datas = $this->clear_html($_GET);
		$mid = intval($datas['mid']);
		$dstart = trim($datas['stime']);
		$dend = trim($datas['etime']);
		$pty = intval($datas['pty']);
		$pty = ((0 < $pty ? $pty : 0));
		$uname = trim($datas['uname']);
		$nowtime = time();
		$starttime = ((!empty($dstart) ? strtotime($dstart . ' 23:59:59') : 0));
		$endtime = strtotime($dend);

		if (0 < $starttime) {
			$endtime = ((0 < $endtime ? $endtime : $nowtime));
		}


		$merchantsDb = M('cashier_merchants');

		if (!0 < $mid && !empty($uname)) {
			$merchant = $merchantsDb->get_one(array('username' => $uname), 'mid,username,wxname');

			if (!empty($merchant) && isset($merchant['mid'])) {
			}
			 else {
			}

			$mid = 0;
		}


		$whereStr = 'pmid=' . $this->adminuser['mid'] . ' AND mchtype=2 AND ispay=1';

		if ($pty == 1) {
			$whereStr = 'pmid=' . $this->adminuser['mid'] . ' AND pay_way="weixin" AND mchtype=2 AND ispay=1';
		}
		 else if ($pty == 2) {
			$whereStr = 'pmid=' . $this->adminuser['mid'] . ' AND pay_way="alipay" AND mchtype=2 AND ispay=1';
		}


		if (0 < $starttime) {
			$whereStr .= ' AND paytime>' . $starttime . ' AND paytime<' . $endtime;
		}
		 else if (!0 < $starttime && (0 < $endtime)) {
			$whereStr .= ' AND paytime<' . $endtime;
		}


		$sqlStr = 'SELECT mid,sum(goods_price) as totalmoney FROM ' . $this->tablepre . 'cashier_order where ' . $whereStr . ' GROUP BY mid ORDER BY mid DESC';
		$sqlObj = new model();
		$moneyarr = $sqlObj->selectBySql($sqlStr);
		$sqlStr = 'SELECT mid,sum(goods_price) as totalmoney FROM ' . $this->tablepre . 'cashier_order where ' . $whereStr . ' AND refund=2 GROUP BY mid ORDER BY mid DESC';
		$refundarr = $sqlObj->selectBySql($sqlStr);
		$income = $refund = 0;

		if (0 < $mid) {
			if (!empty($moneyarr)) {
				foreach ($moneyarr as $mvv ) {
					if ($mvv['mid'] == $mid) {
						$income = $mvv['totalmoney'];
					}

				}
			}


			if (!empty($refundarr)) {
				foreach ($refundarr as $rvv ) {
					if ($rvv['mid'] == $mid) {
						$refund = $rvv['totalmoney'];
					}

				}
			}

		}
		 else {
			if (!empty($moneyarr)) {
				foreach ($moneyarr as $mvv ) {
					$income += $mvv['totalmoney'];
				}
			}


			if (!empty($refundarr)) {
				foreach ($refundarr as $rvv ) {
					$refund += $rvv['totalmoney'];
				}
			}

		}

		if (0 < $mid) {
			$whereStr .= ' AND mid=' . $mid;
		}


		$_count = $orderDb->count($whereStr);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$merOderInfo = $orderDb->select($whereStr, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
		$merchants = $merchantsDb->select(array('isadmin' => '0'), 'mid,username,wxname', '', 'mid DESC');
		$merInfos = $mertmpInfos = array();

		if (!empty($merchants)) {
			foreach ($merchants as $mvv ) {
				$merInfos[$mvv['mid']] = $mvv;
				$mertmpInfos[] = $mvv;

				if ($mvv['mid'] == $mid) {
					$uname = $mvv['username'];
				}

			}
		}


		if (!empty($merOderInfo)) {
			foreach ($merOderInfo as $okk => $ovv ) {
				$merOderInfo[$okk]['merwxname'] = $merInfos[$ovv['mid']]['wxname'];
				$merOderInfo[$okk]['username'] = $merInfos[$ovv['mid']]['username'];

				if (!empty($ovv['truename'])) {
					$merOderInfo[$okk]['payneme'] = $ovv['truename'];
				}
				 else if (!empty($ovv['openid'])) {
					$merOderInfo[$okk]['payneme'] = $ovv['openid'];
				}
				 else if (!empty($ovv['p_openid'])) {
					$merOderInfo[$okk]['payneme'] = $ovv['p_openid'];
				}
				 else {
					$merOderInfo[$okk]['payneme'] = '未知';
				}

				$merOderInfo[$okk]['paytimestr'] = ((0 < $ovv['paytime'] ? date('Y-m-d H:i:s', $ovv['paytime']) : date('Y-m-d H:i:s', $ovv['add_time'])));

				if ($ovv['refund'] == 1) {
					$merOderInfo[$okk]['refundstr'] = '退款中...';
				}
				 else if ($ovv['refund'] == 2) {
					$merOderInfo[$okk]['refundstr'] = '已退款';
				}
				 else if ($ovv['refund'] == 3) {
					$merOderInfo[$okk]['refundstr'] = '退款失败';
				}
				 else {
					$merOderInfo[$okk]['refundstr'] = '未退款';
				}
			}
		}


		unset($merInfos);
		$this->assign('mid', $mid);
		$this->assign('paytype', $pty);
		$this->assign('starttime', $dstart);
		$this->assign('endtime', $dend);
		$this->assign('uname', (!empty($uname) ? $uname : ''));
		$this->assign('refund', $refund);
		$this->assign('income', $income);
		$this->assign('surplus', $income - $refund);
		$this->assign('merInfos', $mertmpInfos);
		$this->assign('pagebar', $pagebar);
		$this->assign('merOderInfo', $merOderInfo);
		$this->display();
	}

	public function mdfyName()
	{
		$postdata = $this->clear_html($_POST);
		$mid = intval($postdata['mid']);
		$wxname = $postdata['wxname'];

		if ((0 < $mid) && !empty($wxname)) {
			if (M('cashier_merchants')->update(array('wxname' => $wxname), array('mid' => $mid))) {
				$this->dexit(array('error' => 0));
			}

		}


		$this->dexit(array('error' => 1));
	}

	public function affiliate()
	{
		bpBase::loadOrg('common_page');
		$merchantsDb = M('cashier_merchants');
		$datas = $this->clear_html($_GET);
		$mid = intval($datas['mid']);
		$uname = trim($datas['uname']);
		if ((0 < $mid) || !empty($uname)) {
			$_count = 1;

			if (!0 < $mid && !empty($uname)) {
				$merchant = $merchantsDb->get_one(array('username' => $uname), 'mid,username,wxname');

				if (!empty($merchant) && isset($merchant['mid'])) {
				}
				 else {
				}

				$mid = 0;
			}


			$sqlStr = 'SELECT DISTINCT mer.mid,mer.username,mer.wxname,pcf.configData,pcf.proxymid,pcf.wxsubmchid FROM ' . $this->tablepre . 'cashier_merchants as mer LEFT JOIN ' . $this->tablepre . 'cashier_payconfig AS pcf ON mer.mid=pcf.mid  where  mer.mid=' . $mid;
		}
		 else {
			$_count = $merchantsDb->count('isadmin !="1"');
			$p = new Page($_count, 20);
			$pagebar = $p->show(2);
			$sqlStr = 'SELECT DISTINCT mer.mid,mer.username,mer.wxname,pcf.configData,pcf.proxymid,pcf.wxsubmchid FROM ' . $this->tablepre . 'cashier_merchants as mer LEFT JOIN ' . $this->tablepre . 'cashier_payconfig AS pcf ON mer.mid=pcf.mid where mer.isadmin !="1" ORDER BY mer.mid DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		}

		$sqlObj = new model();
		$merInfo = $sqlObj->selectBySql($sqlStr);
		$tmpmerInfo = array();

		if ($merInfo) {
			$i = 0;

			foreach ($merInfo as $kk => $vv ) {
				$tmpmerInfo[$i] = $vv;

				if (!empty($vv['configData'])) {
					$tmpcfg = unserialize(htmlspecialchars_decode($vv['configData'], ENT_QUOTES));
					$tmpmerInfo[$i]['wx_appid'] = ((isset($tmpcfg['weixin']) ? $tmpcfg['weixin']['appid'] : ''));
					$tmpmerInfo[$i]['wx_mchid'] = ((isset($tmpcfg['weixin']) ? $tmpcfg['weixin']['mchid'] : ''));
				}
				 else {
					$tmpmerInfo[$i]['wx_appid'] = '';
					$tmpmerInfo[$i]['wx_mchid'] = '';
				}

				unset($tmpmerInfo[$i]['configData']);
				++$i;
			}
		}


		$payConfig = M('cashier_payconfig')->get_one(array('mid' => $this->_mid), 'id,isOpen,configData');
		$sub_mchidarr = array();

		if ($payConfig) {
			if ($payConfig['configData']) {
				$payConfigdata = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
				$sub_mchid = ((isset($payConfigdata['weixin']['sub_mchid']) ? urldecode($payConfigdata['weixin']['sub_mchid']) : ''));

				if (!empty($sub_mchid)) {
					$sub_mchid = trim($sub_mchid);
					$sub_mchid = str_replace(array("\n", "\r"), ',', $sub_mchid);
					$sub_mchid = str_replace('，', ',', $sub_mchid);
					$sub_mchidarr = explode(',', $sub_mchid);
					$tmpmchidarr = array();

					if (!empty($sub_mchidarr)) {
						foreach ($sub_mchidarr as $kk => $vv ) {
							if (!empty($vv)) {
								$tmpmchidarr[] = $vv;
							}

						}

						$sub_mchidarr = $tmpmchidarr;
					}

				}


				unset($payConfig);
			}

		}


		$merchants = $merchantsDb->select(array('isadmin' => '0'), 'mid,username,wxname', '', 'mid DESC');

		if (!empty($merchants)) {
			foreach ($merchants as $mvv ) {
				if ($mvv['mid'] == $mid) {
					$uname = $mvv['username'];
				}

			}
		}


		$this->assign('mid', $mid);
		$this->assign('totalnum', $_count);
		$this->assign('pagebar', $pagebar);
		$this->assign('merInfos', $merchants);
		$this->assign('uname', (!empty($uname) ? $uname : ''));
		$this->assign('merInfo', $tmpmerInfo);
		$this->assign('sub_mchidarr', $sub_mchidarr);
		$this->display();
	}

	public function doModifyPwd()
	{
		$oldpwd = trim($_POST['oldpwd']);
		$newpwd = trim($_POST['newpwd']);
		$new2pwd = trim($_POST['new2pwd']);
		$code = trim($_POST['code']);
		$phone = trim($_POST['phone']);
		$sms_config = loadConfig('sms');
		if ($this->adminuser['phone'] && $sms_config && isset($sms_config['sms_key']) && !empty($sms_config['sms_key'])) {
			$session = $_SESSION['change_password_system_phone'][$this->adminuser['phone']];
			if (!$session && ($session[0] == $code) && (($_SERVER['REQUEST_TIME'] - $session[1]) < 1800)) {
				$this->errorTip('手机验证有误！');
				exit();
			}

		}


		if (empty($oldpwd)) {
			$this->errorTip('旧密码不能为空！');
			exit();
		}


		if (empty($newpwd)) {
			$this->errorTip('新密码不能为空！');
			exit();
		}


		if ($newpwd != $new2pwd) {
			$this->errorTip('两次输入的密码不一致！');
			exit();
		}


		$oldpwd = $this->toPassword($oldpwd, $this->adminuser['salt']);

		if ($oldpwd != $this->adminuser['pwd']) {
			$this->errorTip('旧密码不对！');
			exit();
		}


		$newpwdstr = $this->toPassword($newpwd, $this->adminuser['salt']);
		$updatedata = array('pwd' => $newpwdstr);

		if (!empty($phone) && (strpos($phone, '**') === false)) {
			$updatedata['phone'] = $phone;
		}


		$flage = M('cashier_adminuser')->update($updatedata, array('uid' => $this->adminuser['uid']));

		if ($flage) {
			$_SESSION['change_password_system_phone'][$this->adminuser['phone']] = '';
			$this->successTip('修改成功，请重新登录！', '/merchants.php?m=System&c=index&a=logout');
			exit();
		}
		 else {
			$this->errorTip('密码修改失败！');
			exit();
		}
	}

	public function login()
	{
		$is_sms = 1;
		$sms_config = loadConfig('sms');
		if (!isset($sms_config['sms_key']) || empty($sms_config['sms_key'])) {
			$is_sms = 0;
		}


		$this->assign('is_sms', $is_sms);

		if (IS_POST) {
//		    接收后台登录的账号密码
			$username = $this->clear_html($_POST['username']);
			$password = $this->clear_html($_POST['password']);
			$code = $this->clear_html($_POST['code']);

			if (empty($username)) {
				$this->errorTip('用户名不能为空！');
			}


			if (empty($password)) {
				$this->errorTip('密码不能为空！');
			}


			$adminuserDb = M('cashier_adminuser');
			$tmpU = $adminuserDb->get_one(array('account' => $username), '*');

			if (empty($tmpU)) {
				$this->errorTip('用户不存在！');
			}


			if ($tmpU['phone'] && $is_sms) {
				$session = $_SESSION['login_system_phone'][$tmpU['phone']];
				if (!$session && ($session[0] == $code) && (($_SERVER['REQUEST_TIME'] - $session[1]) < 1800)) {
					$this->errorTip('手机验证有误！');
					exit();
				}

			}


			$password = $this->toPassword($password, $tmpU['salt']);

			if ($password != $tmpU['pwd']) {
				$this->errorTip('密码错误！');
			}


			$_SESSION['my_Cashier_adminuser'] = serialize($tmpU);

			//$adminuserDb->update( array('lastlogintime' => SYS_TIME), array('uid' => $tmpU['uid']) );

			$_SESSION['login_system_phone'][$tmpU['phone']] = '';
			$this->successTip('登录成功！', '/merchants.php?m=System&c=index&a=index');
			exit();
		}


		$this->display();
	}

	public function logout()
	{
		$_SESSION['my_Cashier_adminuser'] = NULL;
		unset($_SESSION['my_Cashier_adminuser']);
		header('Location:?m=System&c=index&a=login');
	}

	public function getCode()
	{
		$login = ((isset($_POST['login']) ? intval($_POST['login']) : 0));

		if ($login) {
			$username = ((isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''));
			$adminuser = M('cashier_adminuser')->get_one(array('account' => $username), '*');

			if (empty($adminuser)) {
				exit(json_encode(array('error' => 1, 'info' => '请您填写您正确的账号')));
			}


			$mobile = $adminuser['phone'];

			if (empty($mobile)) {
				exit(json_encode(array('error' => 1, 'info' => '您该账号还没有绑定手机号，请无视验证，直接点击登录！为了您的账号安全，我们强烈要求您登录后，在修改密码的地方绑定您的手机号！')));
			}


			$index = 'login_system_phone';
			$uid = $adminuser['uid'];
		}
		 else {
			$mobile = $this->adminuser['phone'];
			$index = 'change_password_system_phone';
			$uid = $this->adminuser['uid'];
		}

		$_SESSION[$index][$mobile] = '';
		$string = '0123456789';
		$count = strlen($string) - 1;
		$rand_num = '';
		$i = 0;

		while ($i < 6) {
			$rand_num .= $string[mt_rand(0, $count)];
			++$i;
		}

		$_SESSION[$index][$mobile] = array($rand_num, $_SERVER['REQUEST_TIME']);
		bpBase::loadOrg('Sms');
		$return_status = Sms::sendSms($uid, '您的验证码是：' . $rand_num . '。 此验证码30分钟内有效，请不要把验证码泄露给其他人。如非本人操作，可不用理会！', $mobile);

		if (($return_status == 0) && (strlen($return_status) == 1)) {
			exit(json_encode(array('error' => 0)));
		}
		 else if ($return_status == NULL) {
			exit(json_encode(array('error' => 1, 'info' => '没有购买')));
		}
		 else {
			exit(json_encode(array('error' => 1, 'info' => '短信发送失败,请稍后再试' . $return_status)));
		}
	}

	public function config()
	{
		$sms_config = loadConfig('sms');
		$this->assign('sms', $sms_config);
		$this->display();
	}

	public function saveconfig()
	{
		$data = array();
		$data['sms_sign'] = trim($_POST['sms_sign']);
		$data['sms_key'] = trim($_POST['sms_key']);
		$data['sms_topdomain'] = trim($_POST['sms_topdomain']);
		$config_file = ABS_PATH . 'config' . DIRECTORY_SEPARATOR . 'sms.config.php';
		$fp = fopen($config_file, 'w+');
		fwrite($fp, '<?php ' . "\n" . 'return ' . stripslashes(var_export($data, true)) . ';');
		fclose($fp);
		$this->successTip('配置成功！', '/merchants.php?m=System&c=index&a=config');
	}
}


?>