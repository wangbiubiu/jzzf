<?php

bpBase::loadAppClass('common', 'Salesman', 0);
class pfpay_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		header('location:?m=User&c=pfpay&a=platformpay');
	}

	public function remittance()
	{
		bpBase::loadOrg('common_page');
		$remittanceDb = M('cashier_remittance');
		$whereS = array('mid' => $this->mid);
		$_count = $remittanceDb->count($whereS);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$merRemittance = $remittanceDb->select($whereS, '*', $p->firstRow . ',' . $p->listRows, '');
		include $this->showTpl();
	}

	public function platformpay()
	{
		$getdata = $this->clear_html($_GET);
		$cfr = ((isset($getdata['cfr']) ? intval($getdata['cfr']) : 0));
		$whereStr = 'ordr.ispay="1" AND ordr.mchtype=2';
		$wherecStr = 'ispay="1" AND mchtype=2 AND mid=' . $this->mid;

		switch ($cfr) {
		case 1:
			$wherecStr .= ' AND comefrom in(0,4)';
			$whereStr .= ' AND ordr.comefrom in(0,4)';
			break;

		case 2:
			$wherecStr .= ' AND comefrom ="0"';
			$whereStr .= ' AND ordr.comefrom ="0"';
			break;

		case 3:
			$wherecStr .= ' AND comefrom =4';
			$whereStr .= ' AND ordr.comefrom =4';
			break;

		case 4:
			$wherecStr .= ' AND comefrom in(1,2,3)';
			$whereStr .= ' AND ordr.comefrom in(1,2,3)';
			break;

			break;
			$pty = ((isset($getdata['pty']) ? $getdata['pty'] : ''));
			if (($pty == 'weixin') || ($pty == 'alipay')) {
				$wherecStr .= ' AND pay_way="' . $pty . '"';
				$whereStr .= ' AND ordr.pay_way="' . $pty . '"';
			}


			$sid = ((isset($getdata['sid']) ? intval($getdata['sid']) : 0));

			if ((0 < $sid) && !0 < $this->storeid) {
				$wherecStr .= ' AND storeid=' . $sid;
				$whereStr .= ' AND ordr.storeid=' . $sid;
			}


			$eid = ((isset($getdata['eid']) ? intval($getdata['eid']) : 0));

			if (0 < $eid) {
				$wherecStr .= ' AND eid=' . $eid;
				$whereStr .= ' AND ordr.eid=' . $eid;
			}


			$start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
			$end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));

			if (0 < $start) {
				$wherecStr .= ' AND paytime>=' . $start;
				$whereStr .= ' AND ordr.paytime>=' . $start;
			}


			if (0 < $end) {
				$end = $end + 86399;
				$wherecStr .= ' AND paytime<=' . $end;
				$whereStr .= ' AND ordr.paytime<=' . $end;
			}


			bpBase::loadOrg('common_page');
			$orderDb = M('cashier_order');

			if (0 < $this->storeid) {
				$wherecStr .= ' AND storeid=' . $this->storeid;
			}


			$_count = $orderDb->count($wherecStr);
			$refundMoney = $orderDb->get_one($wherecStr . ' AND refund=2', 'mid,sum(goods_price) as totalmoney');

			if (!empty($refundMoney) && !empty($refundMoney['totalmoney'])) {
			}
			 else {
			}

			$refundMoney = 0;
			$noRefundMoney = $orderDb->get_one($wherecStr . ' AND refund!=2', 'mid,sum(goods_price) as totalmoney');

			if (!empty($noRefundMoney) && !empty($noRefundMoney['totalmoney'])) {
			}
			 else {
			}

			$noRefundMoney = 0;
			$dzRefundMoney = $orderDb->get_one($wherecStr . ' AND refund!=2 AND state=2', 'mid,sum(goods_price) as totalmoney');

			if (!empty($dzRefundMoney) && !empty($dzRefundMoney['totalmoney'])) {
			}
			 else {
			}

			$dzRefundMoney = 0;
			$totalMoney = $refundMoney + $noRefundMoney;
			$pfOweMoney = $noRefundMoney - $dzRefundMoney;
			$p = new Page($_count, 20);
			$pagebar = $p->show(2);
			$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $this->tablepre . 'cashier_order as ordr LEFT JOIN ' . $this->tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid;

			if (0 < $this->storeid) {
				$sqlStr = $sqlStr . ' AND ordr.storeid=' . $this->storeid;
			}


			$sqlStr = $sqlStr . ' AND ' . $whereStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
			$sqlObj = new model();
			$neworder = $sqlObj->selectBySql($sqlStr);
			$neworder = $this->ProcssOdata($neworder, $this->mid);

			if (0 < $this->storeid) {
				$allStore = $this->getStoreByid($this->storeid, $this->mid);
			}
			 else {
				$allStore = $this->getAllStore($this->mid);
			}

			$allEmployee = $this->getAllEmployee($this->mid, false, $this->storeid);
		}
	}

	public function applyBalance()
	{
		$pfapplyrecordDb = M('cashier_pfapplyrecord');
		$_count = $pfapplyrecordDb->count(array('mid' => $this->mid));
		bpBase::loadOrg('common_page');
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$pfapplyrecord = $pfapplyrecordDb->select(array('mid' => $this->mid), '*', $p->firstRow . ',' . $p->listRows, '');
		$statusStr = array('<font color="red">未处理</font>', '<font color="orange">已查看</font>', '<font color="green">核算中</font>', '<font color="green">核对完成</font>', '<font color="green">准备汇款</font>', '<font color="green">已添加汇款记录</font>', '<font color="green">已处理完成</font>');
		include $this->showTpl();
	}

	public function applyIng()
	{
		$data = $this->clear_html($_POST);

		if (empty($data['atitle'])) {
			$this->dexit(array('error' => 1, 'msg' => '标题不能为空！'));
		}


		if (empty($data['starttime'])) {
			$this->dexit(array('error' => 1, 'msg' => '申请对账的开始日期不能为空'));
		}


		$data['starttime'] = strtotime($data['starttime']);

		if (empty($data['endtime'])) {
			$this->dexit(array('error' => 1, 'msg' => '申请对账的结束日期不能为空'));
		}


		$data['mid'] = $this->mid;
		$data['endtime'] = strtotime($data['endtime'] . ' 23:59:59');
		$data['addtime'] = SYS_TIME;

		if (M('cashier_pfapplyrecord')->insert($data, true)) {
			$this->dexit(array('error' => 0, 'msg' => '添加成功！'));
		}
		 else {
			$this->dexit(array('error' => 1, 'msg' => '添加失败！'));
		}
	}

	public function delItem()
	{
		$id = intval($_POST['idd']);

		if (0 < $id) {
			if (M('cashier_pfapplyrecord')->delete(array('id' => $id, 'mid' => $this->mid))) {
				$this->dexit(array('error' => 0, 'msg' => '删除成功！'));
			}

		}


		$this->dexit(array('error' => 1, 'msg' => '删除失败了！'));
	}
	
	
	/**
	 * 业务员安全设置
	 */
	
	
	public function security(){
	    if(IS_POST){
	        $oldpwd = trim($_POST['oldpwd']);
	        $newpwd = trim($_POST['newpwd']);
	        $new2pwd = trim($_POST['new2pwd']);
	       
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
	        
	        
	        $oldpwd = $this->toPassword($oldpwd, $this->salesmans['salt']);
	        if ($oldpwd != $this->salesmans['password']) {
	            $this->errorTip('旧密码不对！');
	            exit();
	        }
	        
	        
	        $newpwdstr = $this->toPassword($newpwd, $this->salesmans['salt']);
	        $updatedata = array('password' => $newpwdstr, 'mfypwd' => 1);

	        
	        $flage = M('cashier_salesmans')->update($updatedata, array('id' => $this->salesmans['id']));
	        
	        if ($flage) {
	            $_SESSION['change_password_phone'][$this->salesmans['phone']] = '';
	            $this->successTip('修改成功，请重新登录！', '/merchants.php?m=Salesman&c=index&a=logout');
	            exit();
	        }else {
	            $this->errorTip('密码修改失败！');
	            exit();
	        }
	    }else{
	        include $this->showTpl();
	    }
	}
	
	
	
	
}


?>