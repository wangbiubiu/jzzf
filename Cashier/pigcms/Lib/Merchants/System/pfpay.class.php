<?php

bpBase::loadAppClass('common', 'System', 0);
class pfpay_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		header('location:?m=System&c=pfpay&a=platformpay');
	}

	public function remittance()
	{
		bpBase::loadOrg('common_page');
		$datas = $this->clear_html($_GET);
		$mid = intval($datas['mid']);
		$uname = trim($datas['uname']);
		$merchantsDb = M('cashier_merchants');
		if ((0 < $mid) || !empty($uname)) {
			if (!0 < $mid && !empty($uname)) {
				$merchant = $merchantsDb->get_one(array('username' => $uname), 'mid,username,wxname');

				if (!empty($merchant) && isset($merchant['mid'])) {
				}
				 else {
				}

				$mid = 0;
			}


			$_count = M('cashier_remittance')->count(array('mid' => $mid));
			$p = new Page($_count, 20);
			$pagebar = $p->show(2);
			$sqlStr = 'SELECT DISTINCT remt.id,remt.*,mer.username,mer.wxname,mer.thirduserid,mer.source FROM ' . $this->tablepre . 'cashier_remittance as remt LEFT JOIN ' . $this->tablepre . 'cashier_merchants AS mer ON remt.mid=mer.mid  where remt.mid=' . $mid . ' ORDER BY remt.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		}
		 else {
			$_count = M('cashier_remittance')->count();
			$p = new Page($_count, 20);
			$pagebar = $p->show(2);
			$sqlStr = 'SELECT DISTINCT remt.id,remt.*,mer.username,mer.wxname,mer.thirduserid,mer.source FROM ' . $this->tablepre . 'cashier_remittance as remt LEFT JOIN ' . $this->tablepre . 'cashier_merchants AS mer ON remt.mid=mer.mid ORDER BY remt.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		}

		$sqlObj = new model();
		$merRemittance = $sqlObj->selectBySql($sqlStr);
		$merchants = $merchantsDb->select(array('isadmin' => '0'), 'mid,username,wxname', '', 'mid DESC');

		if (!empty($merchants)) {
			foreach ($merchants as $mvv ) {
				if ($mvv['mid'] == $mid) {
					$uname = $mvv['username'];
				}

			}
		}


		$this->assign('pagebar', $pagebar);
		$this->assign('merInfos', $merchants);
		$this->assign('merRemittance', $merRemittance);
		$this->assign('mid', $mid);
		$this->assign('uname', (!empty($uname) ? $uname : ''));
		$this->assign('totalnum', $_count);
		$this->display();
	}

	public function SaveRecord()
	{
		$datas = $this->clear_html($_POST);
		if (empty($datas['money']) || !is_numeric($datas['money'])) {
			$this->dexit(array('error' => 1, 'msg' => '汇款金额您还没有填写！'));
		}


		$newdata = array('money' => $datas['money'], 'paytime' => SYS_TIME, 'addtime' => SYS_TIME);

		if (!empty($datas['ptime'])) {
			$ptime = strtotime($datas['ptime']);

			if (0 < $ptime) {
				$newdata['paytime'] = $ptime;
			}

		}


		$merchantsDb = M('cashier_merchants');

		if (!empty($datas['mid'])) {
			$mid = intval($datas['mid']);
			$mertemp = $merchantsDb->get_one(array('mid' => $mid), 'mid,username,wxname');

			if (!empty($mertemp)) {
				$newdata['mid'] = $mertemp['mid'];
				$newdata['meraccount'] = $mertemp['username'];
			}
			 else {
				$this->dexit(array('error' => 1, 'msg' => '汇款商家账号不存在！'));
			}
		}
		 else if (!empty($datas['meraccount'])) {
			$mertemp = $merchantsDb->get_one(array('username' => $datas['meraccount']), 'mid,username,wxname');

			if (!empty($mertemp)) {
				$newdata['mid'] = $mertemp['mid'];
				$newdata['meraccount'] = $mertemp['username'];
			}
			 else {
				$this->dexit(array('error' => 1, 'msg' => '汇款商家账号不存在！'));
			}
		}
		 else {
			$this->dexit(array('error' => 1, 'msg' => '汇款商家账号必须填写！'));
		}

		if (M('cashier_remittance')->insert($newdata, 1)) {
			$this->dexit(array('error' => 0, 'msg' => '汇款信息录入成功！'));
		}


		$this->dexit(array('error' => 1, 'msg' => '汇款信息录入失败！'));
	}

	public function delRecord()
	{
		$idd = intval($_POST['idd']);

		if (0 < $idd) {
			if (M('cashier_remittance')->delete(array('id' => $idd))) {
				$this->dexit(array('error' => 0, 'msg' => '删除成功！'));
			}

		}


		$this->dexit(array('error' => 1, 'msg' => '删除失败！'));
	}

	public function pfmerLists()
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


			$sqlStr = 'SELECT DISTINCT mer.mid,mer.*,pcf.configData,pcf.pfpaymid,pcf.pfalipaymid FROM ' . $this->tablepre . 'cashier_merchants as mer LEFT JOIN ' . $this->tablepre . 'cashier_payconfig AS pcf ON mer.mid=pcf.mid  where mer.mid=' . $mid;
		}
		 else {
			$_count = M('cashier_payconfig')->count('(pfpaymid >0 OR pfalipaymid>0)');
			$p = new Page($_count, 20);
			$pagebar = $p->show(2);
			$sqlStr = 'SELECT DISTINCT mer.mid,mer.*,pcf.configData,pcf.pfpaymid,pcf.pfalipaymid FROM ' . $this->tablepre . 'cashier_merchants as mer LEFT JOIN ' . $this->tablepre . 'cashier_payconfig AS pcf ON mer.mid=pcf.mid where (pcf.pfpaymid >0 OR pcf.pfalipaymid>0) ORDER BY mer.mid DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		}

		$sqlObj = new model();
		$merInfo = $sqlObj->selectBySql($sqlStr);

		foreach ($merInfo as $kk => $vv ) {
			if ($vv['isadmin'] == 1) {
				unset($merInfo[$kk]);
				continue;
			}


			$merInfo[$kk]['configData'] = ((!empty($vv['configData']) ? unserialize(htmlspecialchars_decode($vv['configData'], ENT_QUOTES)) : ''));
			$merInfo[$kk]['wxpfpay'] = '';

			if (0 < $vv['pfpaymid']) {
				$merInfo[$kk]['wxpfpay'] = '<font color="green" style="background-color: #E8FFF0;font-size: 15px;">微&nbsp;信</font>';
			}


			$merInfo[$kk]['alipfpay'] = '';

			if (0 < $vv['pfpaymid']) {
				$merInfo[$kk]['alipfpay'] = '<font color="blue" style="background-color: #E8E4FF;font-size: 15px;">支付宝</font>';
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
		$this->assign('uname', (!empty($uname) ? $uname : ''));
		$this->assign('totalnum', $_count);
		$this->assign('pagebar', $pagebar);
		$this->assign('merInfo', $merInfo);
		$this->assign('merInfos', $merchants);
		$this->display();
	}

	public function getCashierBank()
	{
		$mid = intval($_POST['midd']);

		if (0 < $mid) {
			$tmpbank = M('cashier_bank')->get_one(array('mid' => $mid), '*');

			if (!empty($tmpbank) && is_array($tmpbank)) {
				$this->dexit(array('error' => 0, 'msg' => '', 'data' => $tmpbank));
			}

		}


		$this->dexit(array('error' => 1, 'msg' => ''));
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
		$starttime = ((!empty($dstart) ? strtotime($dstart) : 0));
		$endtime = ((!empty($dend) ? strtotime($dend) : 0));

		if (0 < $endtime) {
			$endtime = $endtime + 86399;
		}


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
		$merOderInfo = $orderDb->select($whereStr, '*', $p->firstRow . ',' . $p->listRows, 'id DESC,state DESC');
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

				if ($ovv['state'] == 2) {
					$merOderInfo[$okk]['statestr'] = '<font color="green">已对账</font>';
				}
				 else {
					$merOderInfo[$okk]['statestr'] = '<font color="red">未对账</font>';
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

	public function mdystat()
	{
		$oids = trim($_POST['oids']);
		$oids = rtrim($oids, ',');

		if (!empty($oids)) {
			$whereStr = 'id in (' . $oids . ')';

			if (M('cashier_order')->update(array('state' => 2), $whereStr)) {
				$this->dexit(array('error' => 0));
			}

		}


		$this->dexit(array('error' => 1));
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

	public function applyMoney()
	{
		$mid = intval($_GET['mid']);
		$uname = htmlspecialchars(trim($_GET['uname']), ENT_QUOTES);
		$merchantsDb = M('cashier_merchants');

		if (!0 < $mid && !empty($uname)) {
			$merchant = $merchantsDb->get_one(array('username' => $uname), 'mid,username,wxname');

			if (!empty($merchant) && isset($merchant['mid'])) {
			}
			 else {
			}

			$mid = 0;
		}


		$countWhere = $sqlStrWhere = '';

		if (0 < $mid) {
			$countWhere = 'mid=' . $mid;
			$sqlStrWhere = ' where  par.mid=' . $mid;
		}


		$pfapplyrecordDb = M('cashier_pfapplyrecord');
		$_count = $pfapplyrecordDb->count($countWhere);
		bpBase::loadOrg('common_page');
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$sqlStr = 'SELECT DISTINCT par.mid,par.*,mer.username,mer.wxname,mer.weixin FROM ' . $this->tablepre . 'cashier_pfapplyrecord AS par LEFT JOIN ' . $this->tablepre . 'cashier_merchants AS  mer ON par.mid=mer.mid ' . $sqlStrWhere . ' ORDER BY par.mid  DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
		$sqlObj = new model();
		$applyRecord = $sqlObj->selectBySql($sqlStr);
		$merchants = $merchantsDb->select(array('isadmin' => '0'), 'mid,username,wxname', '', 'mid DESC');

		if (!empty($merchants)) {
			foreach ($merchants as $mvv ) {
				if ($mvv['mid'] == $mid) {
					$uname = $mvv['username'];
				}

			}
		}


		$statusStr = array('<font color="red">未处理</font>', '<font color="orange">已查看</font>', '<font color="green">核算中</font>', '<font color="green">核对完成</font>', '<font color="green">准备汇款</font>', '<font color="green">已添加汇款记录</font>', '<font color="green">已处理完成</font>');
		$this->assign('statusStr', $statusStr);
		$this->assign('mid', $mid);
		$this->assign('uname', (!empty($uname) ? $uname : ''));
		$this->assign('totalnum', $_count);
		$this->assign('applyRecord', $applyRecord);
		$this->assign('pagebar', $pagebar);
		$this->assign('merInfos', $merchants);
		$this->display();
	}

	public function changeStatus()
	{
		$id = intval($_POST['id']);
		$mid = intval($_POST['mid']);
		$astatus = intval($_POST['astatus']);
		$statusStr = array('<font color="red">未处理</font>', '<font color="orange">已查看</font>', '<font color="green">核算中</font>', '<font color="green">核对完成</font>', '<font color="green">准备汇款</font>', '<font color="green">已添加汇款记录</font>', '<font color="green">已处理完成</font>');

		if ((0 < $id) && (0 < $mid)) {
			$pfapplyrecordDb = M('cashier_pfapplyrecord');

			if ($pfapplyrecordDb->update(array('status' => $astatus), array('id' => $id, 'mid' => $mid))) {
				$this->dexit(array('error' => 0, 'msg' => '修改成功！', 'data' => $statusStr[$astatus]));
			}

		}


		$this->dexit(array('error' => 1, 'msg' => '修改失败！'));
	}
}


?>