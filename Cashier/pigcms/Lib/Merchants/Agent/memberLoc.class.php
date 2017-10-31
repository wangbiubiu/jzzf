<?php

bpBase::loadAppClass('common', 'User', 0);
class memberLoc_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();
		bpBase::loadOrg('checkFunc');
		$checkFunc = new checkFunc();

		if (!function_exists('dsbig3joishdgfhg798rqw4fqnkhffq')) {
			exit('error-4');
		}


		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->authorityControl(array('index', 'getCardTotal', 'getMemberTotal', 'getNumberOpenid', 'get_UserInfo', 'checkCard', 'qrcode'));
	}

	public function index()
	{
		$locmbcardDb = M('cashier_locmbcard');
		$cardsinfo = $locmbcardDb->select(array('mid' => $this->mid, 'isdel' => '0'), '*', '', '');

		if (!empty($cardsinfo)) {
			foreach ($cardsinfo as $kk => $vv ) {
				$cardsinfo[$kk]['cardnums'] = $this->getCardTotal($vv['id']);
				$cardsinfo[$kk]['membernums'] = $this->getMemberTotal($vv['id']);
			}
		}


		include $this->showTpl();
	}

	private function getCardTotal($cdid)
	{
		$_count = M('cashier_locmbnumber')->count(array('mid' => $this->mid, 'cdid' => $cdid));
		return (0 < $_count ? $_count : 0);
	}

	private function getMemberTotal($cdid)
	{
		$_count = M('cashier_locmbnumber')->count(array('mid' => $this->mid, 'cdid' => $cdid, 'is_bind' => 1));
		return (0 < $_count ? $_count : 0);
	}

	public function createCard()
	{
		$cardcommon = M('cashier_wxcoupon_common')->get_one(array('mid' => $this->mid), '*');

		if (empty($cardcommon)) {
			$cardcommon = array('mid' => $this->mid, 'logurl' => '');
		}


		$cdid = intval($_GET['cdid']);
		$locmbcardDb = M('cashier_locmbcard');
		$cardinfo = $locmbcardDb->get_one(array('id' => $cdid, 'mid' => $this->mid, 'isdel' => '0'), '*');

		if (empty($cardinfo)) {
			$cardcommon['mclogo'] = $cardcommon['logurl'];
			$cardcommon['id'] = 0;
			$cardinfo = $cardcommon;
			$cardinfo['cardname'] = '';
			$cardinfo['miniscore'] = 0;
			$cardinfo['bgstyle'] = '/Cashier/pigcms_static/image/cardbg/card_bg05.png';
			$cardinfo['diybg'] = '/Cashier/pigcms_static/image/cardbg/card_bg05.png';
			$cardinfo['cardinfo'] = '';
			$cardinfo['tipmsg'] = '线下会员卡，方便携带收藏，永不挂失';
			$cardinfo['vipnamecolor'] = '#121212';
			$cardinfo['numbercolor'] = '#000000';
			$cardinfo['everyday'] = 1;
			$cardinfo['xreward'] = 1;
			$cardinfo['integralrule'] = '';
			$cardinfo['welfaretitle'] = '';
			$cardinfo['welfareinfo'] = '';
			$cardinfo['ischeck'] = 0;
			$cardinfo['donate_intro'] = '';
			$cardinfo['isdonate'] = 0;
		}


		$locimgpath = '';

		if (defined('ABS_UPLOAD_PATH')) {
			$locimgpath = ABS_UPLOAD_PATH;
		}


		$sms_config = loadConfig('sms');
		$issms_config = 0;

		if (!empty($sms_config) && isset($sms_config['sms_key']) && !empty($sms_config['sms_key'])) {
			$issms_config = 1;
		}


		include $this->showTpl();
	}

	public function createCarding()
	{
		$postdata = $this->clear_html($_POST);
		$cdid = intval($postdata['cdid']);
		$locmbcardDb = M('cashier_locmbcard');

		if (empty($postdata['diybg'])) {
			$postdata['diybg'] = $postdata['bgstyle'];
		}


		if (empty($postdata['cardname'])) {
			$this->dexit(array('error' => 1, 'msg' => '会员卡的名称必须填写！'));
		}


		unset($postdata['cdid']);
		unset($postdata['isdiybg']);
		$sms_config = loadConfig('sms');
		if (empty($sms_config) || !isset($sms_config['sms_key']) || empty($sms_config['sms_key'])) {
			$postdata['ischeck'] = 0;
		}


		if (0 < $cdid) {
			$cardinfo = $locmbcardDb->get_one(array('id' => $cdid, 'mid' => $this->mid, 'isdel' => '0'), '*');

			if (empty($cardinfo)) {
				$this->dexit(array('error' => 1, 'msg' => '会员卡信息不存在！'));
			}


			if ($locmbcardDb->update($postdata, array('id' => $cardinfo['id'], 'mid' => $this->mid))) {
				$this->dexit(array('error' => 0, 'msg' => '修改成功！'));
			}

		}
		 else {
			$postdata['mid'] = $this->mid;
			$postdata['addtime'] = SYS_TIME;

			if ($locmbcardDb->insert($postdata, true)) {
				$this->dexit(array('error' => 0, 'msg' => '保存成功！'));
			}

		}

		$this->dexit(array('error' => 1, 'msg' => '处理失败！'));
	}

	public function delCard()
	{
		$cdid = intval($_POST['cdid']);

		if (0 < $cdid) {
			if (M('cashier_locmbcard')->update(array('isdel' => 1), array('id' => $cdid, 'mid' => $this->mid))) {
				$this->dexit(array('error' => 0, 'msg' => '删除成功！'));
			}

		}


		$this->dexit(array('error' => 1, 'msg' => '删除失败！'));
	}

	public function donate()
	{
		$cdid = intval($_GET['cdid']);

		if (0 < $cdid) {
			$locmbcardDb = M('cashier_locmbcard');
			$cardinfo = $locmbcardDb->get_one(array('id' => $cdid, 'mid' => $this->mid, 'isdel' => '0'), '*');

			if (empty($cardinfo)) {
				$this->errorTip('会员卡不存在哦', $_SERVER['HTTP_REFERER']);
				exit();
			}


			$locmbdonateDb = M('cashier_locmbdonate');
			$donateinfo = $locmbdonateDb->get_one(array('cdid' => $cdid, 'mid' => $this->mid), '*');

			if (empty($donateinfo)) {
				$donateinfo = array();
			}


			include $this->showTpl();
		}
		 else {
			$this->errorTip('会员卡不存在', $_SERVER['HTTP_REFERER']);
			exit();
		}
	}

	public function donateSet()
	{
		$postdata = $this->clear_html($_POST);
		$postdata['minmoney'] = ((0 <= $postdata['minmoney'] ? $postdata['minmoney'] : 0));
		$postdata['maxmoney'] = ((0 <= $postdata['maxmoney'] ? $postdata['maxmoney'] : 0));
		$postdata['donatemoney'] = ((0 <= $postdata['donatemoney'] ? $postdata['donatemoney'] : 0));

		if (0 < $postdata['cdid']) {
			$locmbdonateDb = M('cashier_locmbdonate');
			$tmpArr = $locmbdonateDb->get_one(array('cdid' => $postdata['cdid'], 'mid' => $this->mid), '*');

			if (empty($tmpArr)) {
				$postdata['mid'] = $this->mid;

				if ($locmbdonateDb->insert($postdata, true)) {
					$this->dexit(array('error' => 0, 'msg' => '保存成功！'));
				}

			}
			 else {
				$cdid = $postdata['cdid'];
				unset($postdata['cdid']);

				if ($locmbdonateDb->update($postdata, array('cdid' => $cdid, 'mid' => $this->mid))) {
					$this->dexit(array('error' => 0, 'msg' => '保存成功了！'));
				}

			}
		}


		$this->dexit(array('error' => 1, 'msg' => '保存失败！'));
	}

	public function notice()
	{
		$cdid = intval($_GET['cdid']);

		if (0 < $cdid) {
			$locmbcardDb = M('cashier_locmbcard');
			$cardinfo = $locmbcardDb->get_one(array('id' => $cdid, 'mid' => $this->mid, 'isdel' => '0'), '*');

			if (empty($cardinfo)) {
				$this->errorTip('会员卡不存在哦', $_SERVER['HTTP_REFERER']);
				exit();
			}


			$locmbnoticeDb = M('cashier_locmbnotice');
			bpBase::loadOrg('common_page');
			$whereArr = array('mid' => $this->mid, 'cdid' => $cdid);
			$_count = $locmbnoticeDb->count($whereArr);
			$p = new Page($_count, 20);
			$pagebar = $p->show(2);
			$mbnotices = $locmbnoticeDb->select($whereArr, '*', $p->firstRow . ',' . $p->listRows, 'id DESC');
			include $this->showTpl();
		}
		 else {
			$this->errorTip('会员卡不存在', $_SERVER['HTTP_REFERER']);
			exit();
		}
	}

	public function createNotice()
	{
		$cdid = intval($_GET['cdid']);

		if (0 < $cdid) {
			$locmbcardDb = M('cashier_locmbcard');
			$cardinfo = $locmbcardDb->get_one(array('id' => $cdid, 'mid' => $this->mid, 'isdel' => '0'), '*');

			if (empty($cardinfo)) {
				$this->errorTip('会员卡不存在哦', $_SERVER['HTTP_REFERER']);
				exit();
			}


			$locmbnoticeDb = M('cashier_locmbnotice');
			$ntid = intval($_GET['ntid']);
			$noticeTmp = $locmbnoticeDb->get_one(array('id' => $ntid, 'cdid' => $cdid, 'mid' => $this->mid), '*');
			include $this->showTpl();
		}
		 else {
			$this->errorTip('会员卡不存在', $_SERVER['HTTP_REFERER']);
			exit();
		}
	}

	public function noticeSet()
	{
		$postdata = $this->clear_html($_POST);

		if (empty($postdata['ntitle'])) {
			$this->dexit(array('error' => 1, 'msg' => '通知标题必须填写哦'));
		}


		if (empty($postdata['endtime'])) {
			$this->dexit(array('error' => 1, 'msg' => '截止日期必须填写哦'));
		}


		if (0 < $postdata['cdid']) {
			$locmbcardDb = M('cashier_locmbcard');
			$tmpArr = $locmbcardDb->get_one(array('id' => $postdata['cdid'], 'mid' => $this->mid, 'isdel' => '0'), '*');

			if (empty($tmpArr)) {
				$this->dexit(array('error' => 1, 'msg' => '会员卡不存在'));
			}
			 else {
				$cdid = $postdata['cdid'];
				$ntid = intval($postdata['ntid']);
				unset($postdata['ntid']);
				$postdata['endtime'] = strtotime($postdata['endtime']);
				$locmbnoticeDb = M('cashier_locmbnotice');

				if (0 < $ntid) {
					$noticeTmp = $locmbnoticeDb->get_one(array('id' => $ntid, 'cdid' => $cdid, 'mid' => $this->mid), '*');
					unset($postdata['cdid']);

					if (!empty($noticeTmp)) {
						if ($locmbnoticeDb->update($postdata, array('id' => $ntid, 'cdid' => $cdid, 'mid' => $this->mid))) {
							$this->dexit(array('error' => 0, 'msg' => '修改成功！'));
						}
						 else {
							$this->dexit(array('error' => 1, 'msg' => '修改失败！'));
						}
					}
					 else {
						$this->dexit(array('error' => 1, 'msg' => '修改的信息不存在！'));
					}
				}
				 else {
					$postdata['mid'] = $this->mid;
					$postdata['addtime'] = SYS_TIME;

					if ($locmbnoticeDb->insert($postdata, true)) {
						$this->dexit(array('error' => 0, 'msg' => '保存成功！'));
					}
					 else {
						$this->dexit(array('error' => 1, 'msg' => '保存失败！'));
					}
				}
			}
		}


		$this->dexit(array('error' => 1, 'msg' => '保存失败！'));
	}

	public function delNotice()
	{
		$cdid = intval($_POST['cdid']);
		$ntid = intval($_POST['ntid']);

		if (M('cashier_locmbnotice')->delete(array('mid' => $this->mid, 'id' => $ntid, 'cdid' => $cdid))) {
			$this->dexit(array('error' => 0, 'msg' => '删除成功！'));
		}


		$this->dexit(array('error' => 1, 'msg' => '删除失败！'));
	}

	public function createGift()
	{
		$cdid = intval($_GET['cdid']);

		if (0 < $cdid) {
			$locmbcardDb = M('cashier_locmbcard');
			$cardinfo = $locmbcardDb->get_one(array('id' => $cdid, 'mid' => $this->mid, 'isdel' => '0'), '*');

			if (empty($cardinfo)) {
				$this->errorTip('会员卡不存在哦', $_SERVER['HTTP_REFERER']);
				exit();
			}


			$giftsTmp = M('cashier_locmbgifts')->get_one(array('cdid' => $cdid, 'mid' => $this->mid), '*');
		}
		 else {
			$this->errorTip('会员卡不存在', $_SERVER['HTTP_REFERER']);
			exit();
		}

		include $this->showTpl();
	}

	public function savegift()
	{
		$postdata = $this->clear_html($_POST);
		$cdid = intval($postdata['cdid']);

		if (0 < $cdid) {
			$locmbgiftsDb = M('cashier_locmbgifts');
			$giftsTmp = $locmbgiftsDb->get_one(array('cdid' => $cdid, 'mid' => $this->mid), '*');
			$postdata['starttime'] = ((!empty($postdata['starttime']) ? strtotime($postdata['starttime'] . ' 00:00:01') : 0));
			!0 < $postdata['starttime'] && ($postdata['starttime'] = strtotime(date('Y-m-d 00:00:01')));
			$postdata['endtime'] = ((!empty($postdata['endtime']) ? strtotime($postdata['endtime'] . ' 23:59:59') : 0));
			!0 < $postdata['endtime'] && ($postdata['endtime'] = 0);
			$postdata['gtype'] = 0;

			if (empty($giftsTmp)) {
				$postdata['mid'] = $this->mid;

				if ($locmbgiftsDb->insert($postdata, true)) {
					$this->dexit(array('error' => 0, 'msg' => '保存成功！'));
				}


				$this->dexit(array('error' => 1, 'msg' => '保存失败！'));
			}
			 else {
				unset($postdata['cdid']);

				if ($locmbgiftsDb->update($postdata, array('id' => $giftsTmp['id'], 'mid' => $this->mid))) {
					$this->dexit(array('error' => 0, 'msg' => '修改成功！'));
				}


				$this->dexit(array('error' => 1, 'msg' => '修改失败！'));
			}
		}
		 else {
			$this->dexit(array('error' => 1, 'msg' => '会员卡不存在'));
		}
	}

	public function memberCard()
	{
		$cdid = intval($_GET['cdid']);

		if (0 < $cdid) {
			$locmbcardDb = M('cashier_locmbcard');
			$cardinfo = $locmbcardDb->get_one(array('id' => $cdid, 'mid' => $this->mid, 'isdel' => '0'), '*');

			if (empty($cardinfo)) {
				$this->errorTip('会员卡不存在哦', $_SERVER['HTTP_REFERER']);
				exit();
			}


			$locmbnoticeDb = M('cashier_locmbnumber');
			bpBase::loadOrg('common_page');
			$whereArr = array('mid' => $this->mid, 'cdid' => $cdid);
			$_count = $locmbnoticeDb->count($whereArr);
			$p = new Page($_count, 20);
			$pagebar = $p->show(2);
			$y_count = $locmbnoticeDb->count('mid=' . $this->mid . ' AND cdid=' . $cdid . ' AND openid!=""');
			$locmbnumber = $locmbnoticeDb->select($whereArr, '*', $p->firstRow . ',' . $p->listRows, 'id ASC');
			include $this->showTpl();
		}
		 else {
			$this->errorTip('会员卡不存在', $_SERVER['HTTP_REFERER']);
			exit();
		}
	}

	public function createCnum()
	{
		$cdid = intval($_GET['cdid']);

		if (0 < $cdid) {
			$locmbcardDb = M('cashier_locmbcard');
			$cardinfo = $locmbcardDb->get_one(array('id' => $cdid, 'mid' => $this->mid, 'isdel' => '0'), '*');

			if (empty($cardinfo)) {
				$this->errorTip('会员卡不存在哦', $_SERVER['HTTP_REFERER']);
				exit();
			}


			$locmbnumberDb = M('cashier_locmbnumber');
			$lastnum = $locmbnumberDb->get_one(array('cdid' => $cdid, 'mid' => $this->mid), '*', 'id DESC');
			include $this->showTpl();
		}
		 else {
			$this->errorTip('会员卡不存在', $_SERVER['HTTP_REFERER']);
			exit();
		}
	}

	public function createCnumSet()
	{
		$postdata = $this->clear_html($_POST);
		$numstart = intval($postdata['numstart']);
		$numend = intval($postdata['numend']);
		$maxCardNum = ($numend - $numstart) + 1;
		$cdid = intval($postdata['cdid']);
		$locmbcardDb = M('cashier_locmbcard');
		$cardinfo = $locmbcardDb->get_one(array('id' => $cdid, 'mid' => $this->mid, 'isdel' => '0'), '*');

		if (empty($cardinfo)) {
			$this->errorTip('会员卡不存在哦', $_SERVER['HTTP_REFERER']);
			exit();
		}


		if (300 < $maxCardNum) {
			$this->errorTip('每次只能创建300张卡号', $_SERVER['HTTP_REFERER']);
			exit();
		}


		if ($maxCardNum < 2) {
			$this->errorTip('结束卡号值必须大于起始卡号值', $_SERVER['HTTP_REFERER']);
			exit();
		}


		$locmbnumberDb = M('cashier_locmbnumber');
		$tmpNum = 0;
		$tmpArr = array('cdid' => $cardinfo['id'], 'mid' => $this->mid);
		$nm = 0;

		while ($nm < $maxCardNum) {
			$tmpNum = $numstart + $nm;
			$tmpArr['numstr'] = $postdata['numprefix'] . $tmpNum;

			if ($locmbnumberDb->insert($tmpArr, true)) {
			}
			 else {
				$locmbnumberDb->insert($tmpArr, true);
			}

			++$nm;
		}

		$this->errorTip('创建成功！', '/merchants.php?m=User&c=memberLoc&a=memberCard&cdid=' . $cdid);
	}

	public function delCardnum()
	{
		$ids = $this->clear_html($_POST['cnumid']);
		$cdid = $this->clear_html($_POST['cdid']);

		if (!empty($ids) && (0 < $cdid)) {
			if (M('cashier_locmbnumber')->delete('id in(' . $ids . ') AND cdid=' . $cdid . ' AND mid=' . $this->mid)) {
				$this->dexit(array('error' => 0, 'msg' => '删除成功！'));
			}
			 else {
				$this->dexit(array('error' => 1, 'msg' => '删除失败！'));
			}
		}


		$this->dexit(array('error' => 1, 'msg' => '删除出错！'));
	}

	public function mbCardSet()
	{
		$numstr = trim($_GET['nums']);
		$cdid = intval($_GET['cdid']);
		$whereArr = array('mid' => $this->mid, 'cdid' => $cdid, 'is_bind' => 1);

		if (!empty($numstr)) {
			$whereArr['numstr'] = $numstr;
		}


		$locmbnumberDb = M('cashier_locmbnumber');
		$a_count = $locmbnumberDb->count($whereArr);
		$memberArr = array();

		if (0 < $a_count) {
			bpBase::loadOrg('common_page');
			$p = new Page($a_count, 20);
			$pagebar = $p->show(2);
			$locmbnumber = $locmbnumberDb->select($whereArr, '*', $p->firstRow . ',' . $p->listRows, 'id  DESC');
			$newnumberArr = array();
			$openidArr = array();
			$openidSql = '';

			foreach ($locmbnumber as $vv ) {
				$newnumberArr[$vv['openid']] = $vv;
				$openidArr[] = $vv['openid'];
			}

			$openidArr = array_unique($openidArr);

			foreach ($openidArr as $opvv ) {
				$openidSql .= '\'' . $opvv . '\',';
			}

			$openidSql = rtrim($openidSql, ',');
			$userinfoDb = M('cashier_userinfo');
			$userinfoS = $userinfoDb->select('mid=' . $this->mid . ' AND openid in(' . $openidSql . ')', '*', '', '');
			$memberArr = array();

			foreach ($userinfoS as $ukk => $uvv ) {
				$memberArr[$ukk] = $uvv;

				if (isset($newnumberArr[$uvv['openid']])) {
					$memberArr[$ukk]['numstr'] = $newnumberArr[$uvv['openid']]['numstr'];
				}
				 else {
					$memberArr[$ukk]['numstr'] = '';
				}
			}
		}


		include $this->showTpl();
	}

	private function getNumberOpenid($cdid, $memberno)
	{
		$locmbnumber = M('cashier_locmbnumber')->get_one(array('mid' => $this->mid, 'cdid' => $cdid, 'numstr' => $memberno, 'is_bind' => 1));
		return $locmbnumber;
	}

	private function get_UserInfo($openid)
	{
		return M('cashier_userinfo')->get_one(array('openid' => $openid, 'mid' => $this->mid), '*');
	}

	private function checkCard($cdid)
	{
		$locmbcard = M('cashier_locmbcard')->get_one(array('id' => $cdid, 'mid' => $this->mid, 'isdel' => '0'));

		if (empty($locmbcard)) {
			$this->errorTip('会员卡不存在！');
			exit();
		}


		$locmbcard['cardname'] = htmlspecialchars_decode($locmbcard['cardname'], ENT_QUOTES);
		$locmbcard['cardinfo'] = htmlspecialchars_decode($locmbcard['cardinfo'], ENT_QUOTES);
		$locmbcard['cardinfo'] = str_replace(PHP_EOL, '<br/>', $locmbcard['cardinfo']);
		$locmbcard['tipmsg'] = htmlspecialchars_decode($locmbcard['tipmsg'], ENT_QUOTES);
		$locmbcard['integralrule'] = htmlspecialchars_decode($locmbcard['integralrule'], ENT_QUOTES);
		$locmbcard['integralrule'] = str_replace(PHP_EOL, '<br/>', $locmbcard['integralrule']);
		$locmbcard['welfaretitle'] = htmlspecialchars_decode($locmbcard['welfaretitle'], ENT_QUOTES);
		$locmbcard['welfareinfo'] = htmlspecialchars_decode($locmbcard['welfareinfo'], ENT_QUOTES);
		$locmbcard['welfareinfo'] = str_replace(PHP_EOL, '<br/>', $locmbcard['welfareinfo']);
		return $locmbcard;
	}

	public function payRecord()
	{
		$cdid = intval($_GET['cdid']);
		$memberno = trim($_GET['memberno']);
		$thisCard = $this->checkCard($cdid);
		$numberArr = $this->getNumberOpenid($cdid, $memberno);
		$openid = ((!empty($numberArr) ? $numberArr['openid'] : ''));
		$UserInfo = $this->get_UserInfo($openid);
		$locmbpayrecordDb = M('cashier_locmbpayrecord');
		bpBase::loadOrg('common_page');
		$whereArr = array('mid' => $this->mid, 'cdid' => $cdid, 'openid' => $openid);
		$_count = $locmbpayrecordDb->count($whereArr);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$locmbpayrecord = $locmbpayrecordDb->select($whereArr, '*', $p->firstRow . ',' . $p->listRows, 'createtime DESC');
		include $this->showTpl();
	}

	public function delpayrecord()
	{
		$cdid = intval($_GET['cdid']);
		$piid = intval($_POST['piid']);

		if ((0 < $cdid) && (0 < $piid)) {
			if (M('cashier_locmbpayrecord')->delete(array('id' => $piid, 'mid' => $this->mid, 'cdid' => $cdid))) {
				$this->dexit(array('error' => 0, 'msg' => '删除成功！'));
			}

		}


		$this->dexit(array('error' => 1, 'msg' => '删除失败！'));
	}

	public function offExpense()
	{
		$cdid = intval($_GET['cdid']);
		$memberno = trim($_GET['memberno']);
		$thisCard = $this->checkCard($cdid);
		$numberArr = $this->getNumberOpenid($cdid, $memberno);
		$openid = ((!empty($numberArr) ? $numberArr['openid'] : ''));
		$UserInfo = $this->get_UserInfo($openid);
		$locmbuserecordDb = M('cashier_locmbuserecord');
		bpBase::loadOrg('common_page');
		$whereArr = array('mid' => $this->mid, 'cdid' => $cdid, 'openid' => $openid);
		$_count = $locmbuserecordDb->count($whereArr);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$locmbpayrecord = $locmbuserecordDb->select($whereArr, '*', $p->firstRow . ',' . $p->listRows, 'addtime DESC');
		include $this->showTpl();
	}

	public function deluserecord()
	{
		$cdid = intval($_GET['cdid']);
		$piid = intval($_POST['piid']);

		if ((0 < $cdid) && (0 < $piid)) {
			if (M('cashier_locmbuserecord')->delete(array('id' => $piid, 'mid' => $this->mid, 'cdid' => $cdid))) {
				$this->dexit(array('error' => 0, 'msg' => '删除成功！'));
			}

		}


		$this->dexit(array('error' => 1, 'msg' => '删除失败！'));
	}

	public function mbCardIntegral()
	{
		$cdid = intval($_GET['cdid']);
		$uiid = intval($_POST['uiid']);
		$qtype = intval($_POST['qtype']);
		$qmun = intval($_POST['qmun']);

		if ((0 < $uiid) && (0 < $qmun) && (0 < $cdid)) {
			$insetdata = array('mid' => $this->mid, 'cdid' => $cdid, 'storeid' => $this->storeid, 'cat' => 3, 'expense' => 0, 'usecount' => 1, 'notes' => '后台赠送', 'eid' => $this->eid, 'addtime' => SYS_TIME);
			$userinfoDb = M('cashier_userinfo');
			$userinfo = $userinfoDb->get_one(array('id' => $uiid, 'mid' => $this->mid), '*');
			$insetdata['openid'] = $userinfo['openid'];
			$updateData = array();

			if ($qtype == 1) {
				$insetdata['score'] = $qmun;
				$updateData['total_score'] = $userinfo['total_score'] + $qmun;
				$updateData['locwxscore'] = $userinfo['locwxscore'] + $qmun;
			}
			 else if ($userinfo['total_score'] < $qmun) {
				$insetdata['score'] = -$userinfo['total_score'];
				$updateData['total_score'] = 0;
				$updateData['locwxscore'] = 0;
			}
			 else {
				$insetdata['score'] = -$qmun;
				$updateData['total_score'] = $userinfo['total_score'] - $qmun;
				$updateData['locwxscore'] = $userinfo['locwxscore'] - $qmun;
			}

			M('cashier_locmbuserecord')->insert($insetdata, true);

			if ($userinfoDb->update($updateData, array('id' => $userinfo['id'], 'mid' => $this->mid))) {
				$locmbsync = M('cashier_locmbsync')->get_one(array('mid' => $this->mid));

				if (!empty($locmbsync) && (0 < $locmbsync['issync'])) {
					$this->updateWxMemberCardIntegral($this->mid, $userinfo['openid'], $updateData['total_score'], 0);
				}


				$this->dexit(array('error' => 0, 'msg' => '积分修改成功', 'data' => $updateData['total_score']));
			}


			$this->dexit(array('error' => 1, 'msg' => '积分修改失败'));
		}


		$this->dexit(array('error' => 1, 'msg' => '请求出错！'));
	}

	public function mbCardRecharge()
	{
		$cdid = intval($_GET['cdid']);
		$uiid = intval($_POST['uiid']);
		$money = intval($_POST['money']);

		if ((0 < $cdid) && (0 < $uiid) && (0 < $money)) {
			$userinfoDb = M('cashier_userinfo');
			$userinfo = $userinfoDb->get_one(array('id' => $uiid, 'mid' => $this->mid), '*');
			$balance = $userinfo['balance'] + $money;

			if ($userinfoDb->update(array('balance' => $balance), array('id' => $userinfo['id'], 'mid' => $this->mid))) {
				$insertdata = array('ordid' => 0, 'orderdesc' => '后台手动充值', 'paytype' => 'cardRecharge', 'createtime' => SYS_TIME, 'paytime' => SYS_TIME, 'price' => $money, 'mid' => $this->mid, 'openid' => $userinfo['openid'], 'type' => '0', 'paid' => 1, 'cdid' => $cdid, 'storeid' => $this->storeid, 'eid' => $this->eid);
				M('cashier_locmbpayrecord')->insert($insertdata, true);
				$this->dexit(array('error' => 0, 'msg' => '充值成功！'));
			}


			$this->dexit(array('error' => 1, 'msg' => '充值失败！'));
		}


		$this->dexit(array('error' => 1, 'msg' => '请求出错！'));
	}

	public function delmember()
	{
		$cdid = intval($_GET['cdid']);
		$uiid = intval($_POST['uiid']);

		if ((0 < $cdid) && (0 < $uiid)) {
			$userinfoDb = M('cashier_userinfo');
			$userinfo = $userinfoDb->get_one(array('id' => $uiid, 'mid' => $this->mid), '*');

			if ($userinfoDb->delete(array('id' => $uiid, 'mid' => $this->mid))) {
				M('cashier_locmbpayrecord')->delete(array('openid' => $userinfo['openid'], 'mid' => $this->mid));
				M('cashier_locmbuserecord')->delete(array('openid' => $userinfo['openid'], 'mid' => $this->mid));
				M('cashier_locmbsign')->delete(array('openid' => $userinfo['openid'], 'mid' => $this->mid));
				M('cashier_locmbnumber')->delete(array('openid' => $userinfo['openid'], 'mid' => $this->mid));
				$this->dexit(array('error' => 0, 'msg' => '删除成功！'));
			}

		}


		$this->dexit(array('error' => 1, 'msg' => '删除失败！'));
	}

	public function sycset()
	{
		$wxvipCard = M('cashier_wxcoupon')->get_one(array('mid' => $this->mid, 'card_type' => 5, 'isdel' => '0'), 'id,mid,card_title,card_id,status,' . "\t" . 'store_ids', 'id DESC');
		$msgtip = '';
		$locmbsync = array('issync' => 0);
		$locmbsyncDb = M('cashier_locmbsync');

		if (!empty($wxvipCard) && is_array($wxvipCard)) {
			$locmbcard = M('cashier_locmbcard')->get_one(array('mid' => $this->mid, 'isdel' => '0'), '*', 'id DESC');

			if (!empty($locmbcard) && is_array($locmbcard)) {
				$locmbsync = $locmbsyncDb->get_one(array('mid' => $this->mid));
			}
			 else {
				$msgtip = '您还没有创建本站会员卡，请点击本站会员卡进行创建。';
			}
		}
		 else {
			$msgtip = '您还没有创建微信会员卡，请点击微信卡券下面的微信会员卡进行创建。';
		}

		if (IS_POST && isset($_POST['issync'])) {
			if (!empty($msgtip)) {
				$this->errorTip('授权失败，商家的微信信息配置不正确！');
				exit();
			}


			if (!empty($locmbsync)) {
				if ($locmbsyncDb->update(array('issync' => intval($_POST['issync'])), array('id' => $locmbsync['id'], 'mid' => $this->mid))) {
					$this->successTip('保存成功！');
					exit();
				}

			}
			 else {
				$insertdata = array('mid' => $this->mid, 'issync' => intval($_POST['issync']));

				if ($locmbsyncDb->insert($insertdata, true)) {
					$this->successTip('保存成功！');
					exit();
				}

			}
		}
		 else {
			include $this->showTpl();
		}
	}

	public function updateWxMemberCardIntegral($mid, $openid, $bonusjf = 0, $ischang = 0, $cardid = '')
	{
		if ((0 < $mid) && !empty($openid)) {
			$whereArr = array('outerid' => $mid, 'openid' => $openid, 'cardtype' => 5);

			if (!empty($cardid)) {
				$whereArr['cardid'] = $cardid;
			}


			$receivewxcard = M('cashier_wxcoupon_receive')->get_one($whereArr, '*', 'id  DESC');

			if (!empty($receivewxcard) && !empty($receivewxcard['cardcode'])) {
				bpBase::loadOrg('wxCardPack');
				$wx_user = M('cashier_payconfig')->getwxuserConf($mid);

				if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $mid)) {
					$wx_user = $wx_user['submchinfo'];
				}


				$wxCardPack = new wxCardPack($wx_user, $mid);
				$access_token = $wxCardPack->getToken();
				$postwxjsonData = '{"card_id":"' . $receivewxcard['cardid'] . '","code":"' . $receivewxcard['cardcode'] . '"}';
				$wxUserInfo = $wxCardPack->MemberCardUserInfo($access_token, $postwxjsonData);

				if (!empty($wxUserInfo) && isset($wxUserInfo['bonus'])) {
					if ($ischang == 0) {
						$jsonData = '{"code": "' . $receivewxcard['cardcode'] . '","card_id":"' . $receivewxcard['cardid'] . '","bonus": ' . $bonusjf . '}';
					}
					 else if (($ischang == 1) && ($wxUserInfo['bonus'] < $bonusjf)) {
						$jsonData = '{"code": "' . $receivewxcard['cardcode'] . '","card_id":"' . $receivewxcard['cardid'] . '","bonus": ' . $bonusjf . '}';
					}
					 else if ($ischang == 2) {
						$jsonData = '{"code": "' . $receivewxcard['cardcode'] . '","card_id":"' . $receivewxcard['cardid'] . '","add_bonus":' . $bonusjf . '}';
					}


					if (isset($jsonData) && !empty($jsonData)) {
						$res = $wxCardPack->UpdateUserCard($access_token, $jsonData);
						if ($res && is_array($res) && isset($res['result_bonus'])) {
							return array('wxcardbonus' => $res['result_bonus'], 'wxbalance' => $res['result_balance'], 'openid' => $res['openid']);
						}


						return false;
					}

				}

			}

		}


		return true;
	}

	public function qrcode()
	{
		bpBase::loadOrg('phpqrcode');
		new QRimage(350, 350);
		$isdwd = ((isset($_GET['dwd']) ? intval(trim($_GET['dwd'])) : 0));
		$url = $this->SiteUrl . '/merchants.php?m=Wap&c=vcard&a=index&mid=' . $this->mid;

		if (0 < $isdwd) {
			$fname = 'Your-Card-code-image-' . $this->mid . date('Y-m-d') . '.png';
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Content-Type:application/force-download');
			header('Content-type: image/png');
			header('Content-Type:application/download');
			header('Content-Disposition: attachment; filename=' . $fname);
			header('Content-Transfer-Encoding: binary');
			QRcode::png($url, false, 'H', 10, 1);
		}
		 else {
			Header('Content-type: image/jpeg');
			QRcode::png($url);
		}
	}
}


?>