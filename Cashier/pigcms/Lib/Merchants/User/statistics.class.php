<?php

bpBase::loadAppClass('common', 'User', 0);
class statistics_controller extends common_controller
{
	private $merchantsDb;

	public function __construct()
	{
		parent::__construct();
		bpBase::loadOrg('checkFunc');
		$checkFunc = new checkFunc();

		if (!function_exists('dsbig3joishdgfhg798rqw4fqnkhffq')) {
			exit('error-4');
		}


		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->authorityControl(array('getchart', 'GetwxUserInfoFromSys', 'export_excel_zip', 'exportExcel'));
	}

	public function index()
	{
		$today = date('Y-m-d');
		$aweekago = date('Y-m-d', strtotime('-1 week'));
		$todaym = date('Y-m');
		$aYearagom = date('Y-m', strtotime('-6 month'));
		$stores = M('cashier_stores')->select(array('mid' => $this->mid));

		if (0 < $this->storeid) {
			$t = array();

			foreach ($stores as $store ) {
				if ($this->storeid == $store['id']) {
					$t[] = $store;
				}

			}

			$stores = $t;
		}


		include $this->showTpl();
	}

	public function orderLists()
	{
               
		$getdata = $this->clear_html($_GET);
		$cfr = ((isset($getdata['cfr']) ? intval($getdata['cfr']) : 0));
		$whereStr = 'ordr.ispay="1"';
		$wherecStr = 'ispay="1" AND mid=' . $this->mid;

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
                    default :
			
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
				$wherecStr .= ' AND paytime<=' . $end;
				$whereStr .= ' AND ordr.paytime<=' . $end;
			}


			bpBase::loadOrg('common_page');
			$orderDb = M('cashier_order');
			$db_config = loadConfig('db');
			$tablepre = $db_config['default']['tablepre'];
			unset($db_config);

			if (0 < $this->storeid) {
				$wherecStr .= ' AND storeid=' . $this->storeid;
			}
                        

			$_count = $orderDb->count($wherecStr);
			$p = new Page($_count, 20);
			$pagebar = $p->show(2);
			$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid;
                        //$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid';
			if (0 < $this->storeid) {
				$sqlStr = $sqlStr . ' AND ordr.storeid=' . $this->storeid;
			}


			$sqlStr = $sqlStr . ' AND ' . $whereStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
			//$sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
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
                        break;
		}
                include $this->showTpl();
	}

	public function exportExcel()
	{
		$getdata = $this->clear_html($_POST);
		$cfr = ((isset($getdata['cfr']) ? intval($getdata['cfr']) : 0));
		$whereStr = 'ordr.ispay="1"';
		$wherecStr = 'ispay="1" AND mid=' . $this->mid;
                
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

                    default :
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
				$wherecStr .= ' AND paytime<=' . $end;
				$whereStr .= ' AND ordr.paytime<=' . $end;
			}


			bpBase::loadOrg('common_page');
			$orderDb = M('cashier_order');
			$db_config = loadConfig('db');
			$tablepre = $db_config['default']['tablepre'];
			unset($db_config);

			if (0 < $this->storeid) {
				$wherecStr .= ' AND storeid=' . $this->storeid;
			}


			$ztotal = $orderDb->count($wherecStr);
			$limitstr = '';
			$flag = 0;
			$mct = 0;
			$max = 5000;
			$page = ((!empty($getdata['page']) ? intval($getdata['page']) : 1));

			if ($max < $ztotal) {
				$tmp = ($page - 1) * $max;
				$limitstr = $tmp . ',' . $max;
				$mct = ceil($ztotal / $max);
				$mct = ((0 < $mct ? $mct : 0));

				if ($ztotal < ($page * $max)) {
					$flag = 1;
				}

			}


			$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid;

			if (0 < $this->storeid) {
				$sqlStr = $sqlStr . ' AND ordr.storeid=' . $this->storeid;
			}


			$sqlStr = $sqlStr . ' AND ' . $whereStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC';

			if (!empty($limitstr)) {
				$sqlStr .= ' LIMIT ' . $limitstr;
			}


			$sqlObj = new model();
			$neworder = $sqlObj->selectBySql($sqlStr);

			if (!empty($neworder)) {
				$neworder = $this->ProcssOdata($neworder, $this->mid);
				bpBase::loadOrg('phpexcel/PHPExcel');
				$objExcel = new PHPExcel();
				$objProps = $objExcel->getProperties();
				$objProps->setCreator('收银台数据表格');
				$objProps->setTitle('收银台数据表格');
				$objProps->setSubject('收银台数据表格');
				$objProps->setDescription('收银台数据表格');
				$objExcel->setActiveSheetIndex(0);
				$objExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
				$objExcel->getActiveSheet()->getColumnDimension('B')->setWidth(28);
				$objExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
				$objExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
				$objExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
				$objExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
				$objExcel->getActiveSheet()->getColumnDimension('G')->setWidth(14);
				$objExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
				$objExcel->getActiveSheet()->getColumnDimension('I')->setWidth(14);
				$objExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
				$objActSheet = $objExcel->getActiveSheet();
				$objActSheet->setCellValue('A1', '标号');
				$objActSheet->setCellValue('B1', '付款人');
				$objActSheet->setCellValue('C1', '付款时间');
				$objActSheet->setCellValue('D1', '付款金额');
				$objActSheet->setCellValue('E1', '付款理由');
				$objActSheet->setCellValue('F1', '付款来源');
				$objActSheet->setCellValue('G1', '退款情况');
				$objActSheet->setCellValue('H1', '对账情况');
				$objActSheet->setCellValue('I1', '收款门店');
				$objActSheet->setCellValue('J1', '收款人');
				$nn = 2;

				foreach ($neworder as $ovv ) {
					$objActSheet->setCellValueExplicit('A' . $nn, $ovv['id'], PHPExcel_Cell_DataType::TYPE_STRING);
					$pname = '未知客户';

					if (!empty($ovv['nickname'])) {
						$pname = $ovv['nickname'];
					}
					 else if (!empty($ovv['truename'])) {
						$pname = htmlspecialchars_decode($ovv['truename'], ENT_QUOTES);
					}
					 else if (!empty($ovv['openid'])) {
						$pname = $ovv['openid'];
					}


					$objActSheet->setCellValue('B' . $nn, $pname);
					$paytime = ((0 < $ovv['paytime'] ? $ovv['paytime'] : $ovv['add_time']));
					$paytime = date('Y-m-d H:i:s', $paytime);
					$objActSheet->setCellValue('C' . $nn, $paytime);
					$objActSheet->setCellValueExplicit('D' . $nn, $ovv['goods_price'], PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->setCellValueExplicit('E' . $nn, htmlspecialchars_decode($ovv['goods_name'], ENT_QUOTES), PHPExcel_Cell_DataType::TYPE_STRING);
					$comefrom = '本平台 ';

					if ($ovv['comefrom'] == 1) {
						$comefrom = '微信营销 ';
					}
					 else if ($ovv['comefrom'] == 2) {
						$comefrom = '电商平台 ';
					}
					 else if ($ovv['comefrom'] == 3) {
						$comefrom = 'O2O平台 ';
					}
					 else if ($ovv['comefrom'] == 4) {
						$comefrom = 'APP客户端 ';
					}


					if ($ovv['pay_way'] == 'alipay') {
						$comefrom .= '支付宝支付';
					}
					 else if ($ovv['pay_way'] == 'weixin') {
						$comefrom .= '微信支付';
					}
					 else {
						$comefrom .= '其他支付';
					}

					$objActSheet->setCellValue('F' . $nn, $comefrom);
					$refundStr = '';

					if ($ovv['refund'] == 2) {
						$refundStr = '已退款';
					}
					 else if ($ovv['refund'] == 3) {
						$refundStr = '退款失败';
					}
					 else {
						$refundStr = '已支付';
					}

					$objActSheet->setCellValue('G' . $nn, $refundStr);
					$duizStr = '无';

					if ($ovv['mchtype'] == 2) {
						if ($ovv['state'] == 2) {
							$duizStr = '已对账';
						}
						 else {
							$duizStr = '未对账';
						}
					}


					$objActSheet->setCellValue('H' . $nn, $duizStr);
					$objActSheet->setCellValue('I' . $nn, $ovv['storename']);
					$objActSheet->setCellValue('J' . $nn, $ovv['optername']);
					++$nn;
				}

				if ($max < $ztotal) {
					$filename = 'orderpay_' . $this->mid . '_' . date('Ymd') . '_' . $page . '.xls';
				}
				 else {
					$filename = 'orderpay_' . $this->mid . date('YmdHi') . '.xls';
				}

				$getupload_dir = '/upload/exportfile/' . $this->mid . '/';

				if (defined('ABS_UPLOAD_PATH')) {
					$getupload_dir = ABS_UPLOAD_PATH . $getupload_dir;
				}


				$upload_dir = '.' . $getupload_dir;

				if (!is_dir($upload_dir)) {
					mkdir($upload_dir, 511, true);
				}


				$filepath = $upload_dir . $filename;
				$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
				$objWriter->save($filepath);
			}

		}
	}

	public function export_excel_zip()
	{
		$page = intval($_POST['page']);
		$zip = new ZipArchive();
		$filename = 'orderpay_' . $this->mid . date('YmdHis') . '.zip';
		$getupload_dir = '/upload/exportfile/' . $this->mid . '/';

		if (defined('ABS_UPLOAD_PATH')) {
			$getupload_dir = ABS_UPLOAD_PATH . $getupload_dir;
		}


		$upload_dir = '.' . $getupload_dir;
		$zipname = $upload_dir . $filename;

		if (!file_exists($zipname)) {
			$zip->open($zipname, ZipArchive::OVERWRITE);
			$i = 1;

			while ($i <= $page) {
				$tmp = $upload_dir . 'orderpay_' . $this->mid . '_' . date('Ymd') . '_' . $i . '.xls';
				$zip->addFile($tmp, 'xlsfile' . $i . '.xls');
				++$i;
			}

			$zip->close();
		}


		$this->dexit(array('error' => 0, 'p' => $page, 'fileurl' => $getupload_dir . $filename));
	}

	public function fans()
	{
		bpBase::loadOrg('common_page');
		$fansDb = M('cashier_fans');
		$where = array('mid' => $this->mid);
		$_count = $fansDb->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$fansarr = $fansDb->select($where, '*', $p->firstRow . ',' . $p->listRows, 'totalfee DESC,id DESC');
		$getwxuser = array(
			'user_list' => array()
			);
		$tmpdata = array();

		foreach ($fansarr as $kk => $vv ) {
			$tmpdata[$vv['openid']] = $vv;
			if (empty($vv['nickname']) || empty($vv['headimgurl'])) {
				$getwxuser['user_list'][$kk] = array('openid' => $vv['openid'], 'lang' => 'zh-CN');
			}

		}

		$fansarr = $tmpdata;
		unset($tmpdata);
		$nowxinfoOpenid = array();

		if (!empty($getwxuser['user_list'])) {
			bpBase::loadOrg('wxCardPack');
			$wx_user = M('cashier_payconfig')->getwxuserConf($this->mid);
			$wxCardPack = new wxCardPack($wx_user, $this->mid);
			$access_token = $wxCardPack->getToken();
			$UserInfoList = $wxCardPack->GetwxUserInfoList($access_token, json_encode($getwxuser));

			if (isset($UserInfoList['user_info_list'])) {
				$fansDb = M('cashier_fans');

				foreach ($UserInfoList['user_info_list'] as $uvv ) {
					if ($uvv['subscribe'] == 1) {
						$wxuserinfo = array('is_subscribe' => $uvv['subscribe'], 'nickname' => $uvv['nickname'], 'sex' => $uvv['sex'], 'province' => $uvv['province'], 'city' => $uvv['city'], 'country' => $uvv['country'], 'headimgurl' => $uvv['headimgurl'], 'groupid' => $uvv['groupid']);
						$fansDb->update($wxuserinfo, array('openid' => $uvv['openid'], 'mid' => $this->mid));
						$fansarr[$uvv['openid']] = array_merge($fansarr[$uvv['openid']], $wxuserinfo);
					}
					 else {
						$nowxinfoOpenid[] = $uvv['openid'];
					}
				}
			}


			if (!empty($nowxinfoOpenid)) {
			}

		}


		include $this->showTpl();
	}

	public function getchart()
	{
		$nowtime = time();
		$typ = trim($_POST['typ']);
		$dstart = trim($_POST['dstart']);
		$dend = trim($_POST['dend']);
		$storeid = intval($_POST['store_id']);
		$orderDb = M('cashier_order');
		$totalmoney = $refund = $income = 0;
		$output = array();

		switch ($typ) {
		case 'date':
			$startime = $nowtime - (7 * 24 * 3600);
			$starttime = strtotime($dstart);
			!0 < $starttime && ($starttime = $startime);
			$endtime = strtotime($dend);

			if (!0 < $endtime) {
				$endtime = $nowtime;
			}
			 else {
				$endtime = $endtime + (23 * 3600) + (59 * 60) + 30;
			}

			$xkey1 = $xkey2 = array();
			$s = $starttime;

			while ($s <= $endtime) {
				$datekey = date('m-d', $s);
				$xkey1[$datekey] = 0;
				$s = $s + (23 * 3600) + (59 * 60) + 29;
			}

			$xkey2 = $xkey1;
			$wherestr = 'mid=' . $this->mid . ' AND  paytime >' . $starttime . ' AND paytime <=' . $endtime . ' AND  ispay=1';

			if (0 < $this->storeid) {
				$wherestr = $wherestr . ' AND storeid=' . $this->storeid;
			}
			 else if (0 < $storeid) {
				$wherestr = $wherestr . ' AND storeid=' . $storeid;
			}


			$fieldstr = 'sum(goods_price) as price,paytime,FROM_UNIXTIME(paytime,"%m-%d") as perdate';
			$tmpdatas = $orderDb->select($wherestr, $fieldstr, '', 'paytime ASC', 'perdate');

			foreach ($tmpdatas as $tvv ) {
				$xkey1[$tvv['perdate']] = $tvv['price'];
				$totalmoney += $tvv['price'];
			}

			$output['idx1'] = array_values($xkey1);
			$wherestr = 'mid=' . $this->mid . ' AND  paytime >' . $starttime . ' AND paytime <=' . $endtime . ' AND  ispay=1 AND refund=2';

			if (0 < $this->storeid) {
				$wherestr = $wherestr . ' AND storeid=' . $this->storeid;
			}
			 else if (0 < $storeid) {
				$wherestr = $wherestr . ' AND storeid=' . $storeid;
			}


			$fieldstr = 'sum(goods_price) as price,paytime,FROM_UNIXTIME(paytime,"%m-%d") as perdate';
			$tmprefund = $orderDb->select($wherestr, $fieldstr, '', 'paytime ASC', 'perdate');

			foreach ($tmprefund as $fvv ) {
				$xkey2[$fvv['perdate']] = $fvv['price'];
				$refund += $fvv['price'];
			}

			$output['idx2'] = array_values($xkey2);
			$xkey3 = array();

			foreach ($xkey1 as $kk => $vv ) {
				$xkey3[$kk] = $vv - $xkey2[$kk];
				$income += $xkey3[$kk];
			}

			$output['idx3'] = array_values($xkey3);
			$expand = array('tt' => $totalmoney, 'rf' => $refund, 'ic' => $income);
			break;

		case 'month':
			$todaym = date('Y-m') . '-01';
			$aYearagom = date('Y-m', strtotime('-6 month'));
			$starttime = strtotime($dstart . '-01');

			if (!0 < $starttime) {
				$starttime = strtotime($todaym);
			}


			$t = date('t', $dend);
			$endtime = strtotime($dend);

			if (!0 < $endtime) {
				$endtime = $nowtime;
			}
			 else {
				$endtime = strtotime($dend . '-' . $t . ' 23:59:59');
			}

			$xkey1 = $xkey2 = array();
			$s = $starttime;

			while ($s <= $endtime) {
				$datekey = date('Y-m', $s);
				$xkey1[$datekey] = 0;
				$s = $s + (31 * 24 * 3600) + 3600;
			}

			$xkey2 = $xkey1;
			$wherestr = 'mid=' . $this->mid . ' AND  paytime >' . $starttime . ' AND paytime <=' . $endtime . ' AND  ispay=1';

			if (0 < $this->storeid) {
				$wherestr = $wherestr . ' AND storeid=' . $this->storeid;
			}
			 else if (0 < $storeid) {
				$wherestr = $wherestr . ' AND storeid=' . $storeid;
			}


			$fieldstr = 'sum(goods_price) as price,paytime,FROM_UNIXTIME(paytime,"%Y-%m") as perdate';
			$tmpdatas = $orderDb->select($wherestr, $fieldstr, '', 'paytime ASC', 'perdate');

			foreach ($tmpdatas as $tvv ) {
				$xkey1[$tvv['perdate']] = $tvv['price'];
				$totalmoney += $tvv['price'];
			}

			$output['idx1'] = array_values($xkey1);
			$wherestr = 'mid=' . $this->mid . ' AND  paytime >' . $starttime . ' AND paytime <=' . $endtime . ' AND  ispay=1 AND refund=2';

			if (0 < $this->storeid) {
				$wherestr = $wherestr . ' AND storeid=' . $this->storeid;
			}
			 else if (0 < $storeid) {
				$wherestr = $wherestr . ' AND storeid=' . $storeid;
			}


			$fieldstr = 'sum(goods_price) as price,paytime,FROM_UNIXTIME(paytime,"%Y-%m") as perdate';
			$tmprefund = $orderDb->select($wherestr, $fieldstr, '', 'paytime ASC', 'perdate');

			foreach ($tmprefund as $fvv ) {
				$xkey2[$fvv['perdate']] = $fvv['price'];
				$refund += $fvv['price'];
			}

			$output['idx2'] = array_values($xkey2);
			$xkey3 = array();

			foreach ($xkey1 as $kk => $vv ) {
				$xkey3[$kk] = $vv - $xkey2[$kk];
				$income += $xkey3[$kk];
			}

			$output['idx3'] = array_values($xkey3);
			$expand = array('tt' => $totalmoney, 'rf' => $refund, 'ic' => $income);
			break;

		case 'smcount':
			$startime = $nowtime - (7 * 24 * 3600);
			$starttime = strtotime($dstart);
			!0 < $starttime && ($starttime = $startime);
			$endtime = strtotime($dend);

			if (!0 < $endtime) {
				$endtime = $nowtime;
			}
			 else {
				$endtime = $endtime + (23 * 3600) + (59 * 60) + 30;
			}

			$xkey1 = $xkey2 = $xkey3 = $xkey4 = array();
			$s = $starttime;

			while ($s <= $endtime) {
				$datekey = date('m-d', $s);
				$xkey1[$datekey] = 0;
				$s = $s + (23 * 3600) + (59 * 60) + 29;
			}

			$xkey3 = $xkey4 = $xkey2 = $xkey1;
			$wherestr1 = 'mid=' . $this->mid . ' AND  add_time >' . $starttime . ' AND add_time <=' . $endtime . ' AND pay_way="weixin" AND pay_type="micropay" ';

			if (0 < $this->storeid) {
				$wherestr1 = $wherestr1 . ' AND storeid=' . $this->storeid;
			}
			 else if (0 < $storeid) {
				$wherestr1 = $wherestr1 . ' AND storeid=' . $storeid;
			}


			$wherestr2 = 'mid=' . $this->mid . ' AND  add_time >' . $starttime . ' AND add_time <=' . $endtime . ' AND pay_way="weixin" AND pay_type!="micropay" ';

			if (0 < $this->storeid) {
				$wherestr2 = $wherestr2 . ' AND storeid=' . $this->storeid;
			}
			 else if (0 < $storeid) {
				$wherestr2 = $wherestr2 . ' AND storeid=' . $storeid;
			}


			$fieldstr = 'count(id) as perC,add_time,FROM_UNIXTIME(add_time,"%m-%d") as perdate';
			$tmpdatas1 = $orderDb->select($wherestr1, $fieldstr, '', 'add_time ASC', 'perdate');

			foreach ($tmpdatas1 as $cvv ) {
				(0 < $cvv['perC']) && $xkey1[$cvv['perdate']] = $cvv['perC'];
				$micropay += $cvv['perC'];
			}

			$output['idx1'] = array_values($xkey1);
			$tmpdatas2 = $orderDb->select($wherestr2, $fieldstr, '', 'add_time ASC', 'perdate');

			foreach ($tmpdatas2 as $cvv ) {
				(0 < $cvv['perC']) && $xkey2[$cvv['perdate']] = $cvv['perC'];
				$no_micropay += $cvv['perC'];
			}

			$output['idx2'] = array_values($xkey2);
			!0 < $micropay && ($micropay = 0);
			!0 < $no_micropay && ($no_micropay = 0);
			$wherestr1 = 'mid=' . $this->mid . ' AND  add_time >' . $starttime . ' AND add_time <=' . $endtime . ' AND pay_way="alipay" AND pay_type="bar_code" ';

			if (0 < $this->storeid) {
				$wherestr1 = $wherestr1 . ' AND storeid=' . $this->storeid;
			}
			 else if (0 < $storeid) {
				$wherestr1 = $wherestr1 . ' AND storeid=' . $storeid;
			}


			$wherestr2 = 'mid=' . $this->mid . ' AND  add_time >' . $starttime . ' AND add_time <=' . $endtime . ' AND pay_way="alipay" AND pay_type!="bar_code" ';

			if (0 < $this->storeid) {
				$wherestr2 = $wherestr2 . ' AND storeid=' . $this->storeid;
			}
			 else if (0 < $storeid) {
				$wherestr2 = $wherestr2 . ' AND storeid=' . $storeid;
			}


			$fieldstr = 'count(id) as perC,add_time,FROM_UNIXTIME(add_time,"%m-%d") as perdate';
			$tmpdatas1 = $orderDb->select($wherestr1, $fieldstr, '', 'add_time ASC', 'perdate');
			$barcodep = $no_barcodep = 0;

			foreach ($tmpdatas1 as $cvv ) {
				(0 < $cvv['perC']) && $xkey3[$cvv['perdate']] = $cvv['perC'];
				$barcodep += $cvv['perC'];
			}

			$output['idx3'] = array_values($xkey3);
			$tmpdatas2 = $orderDb->select($wherestr2, $fieldstr, '', 'add_time ASC', 'perdate');

			foreach ($tmpdatas2 as $cvv ) {
				(0 < $cvv['perC']) && $xkey4[$cvv['perdate']] = $cvv['perC'];
				$no_barcodep += $cvv['perC'];
			}

			$output['idx4'] = array_values($xkey4);
			!0 < $barcodep && ($barcodep = 0);
			!0 < $no_barcodep && ($no_barcodep = 0);
			$expand = array('microC' => $micropay, 'nomicroC' => $no_micropay, 'barcodep' => $barcodep, 'nobarcodep' => $no_barcodep);
			break;

			break;
		}
	}

	public function otherpie()
	{
		$today = date('Y-m-d');
		$aweekago = date('Y-m-d', strtotime('-1 week'));
		$orderDb = M('cashier_order');
		$wherestr = 'mid=' . $this->mid . ' AND pay_way ="weixin" AND pay_type="micropay" AND comefrom="0"';
		$aliwherestr = 'mid=' . $this->mid . ' AND pay_way ="alipay" AND pay_type="bar_code" AND comefrom="0"';

		if (0 < $this->storeid) {
			$wherestr = $wherestr . ' AND storeid=' . $this->storeid;
			$aliwherestr = $aliwherestr . ' AND storeid=' . $this->storeid;
		}


		$mt_wxcount = $orderDb->count($wherestr);
		$mt_alicount = $orderDb->count($aliwherestr);
		$wherestr = 'mid=' . $this->mid . '  AND pay_way ="weixin" AND pay_type !="micropay" AND comefrom="0"';
		$aliwherestr = 'mid=' . $this->mid . ' AND pay_way ="alipay" AND pay_type!="bar_code" AND comefrom="0"';

		if (0 < $this->storeid) {
			$wherestr = $wherestr . ' AND storeid=' . $this->storeid;
			$aliwherestr = $aliwherestr . ' AND storeid=' . $this->storeid;
		}


		$wt_wxcount = $orderDb->count($wherestr);
		$wt_alicount = $orderDb->count($aliwherestr);
		$entirearr = array('local' => 0, 'other' => 0, 'refund' => 0);
		$wherestr = 'mid=' . $this->mid . ' AND ispay=1 AND comefrom="0"';

		if (0 < $this->storeid) {
			$wherestr = $wherestr . ' AND storeid=' . $this->storeid;
		}


		$tmpprice = $orderDb->get_one($wherestr, 'sum(goods_price) as tprice');
		(0 < $tmpprice['tprice']) && $entirearr['local'] = $tmpprice['tprice'];
		$wherestr = 'mid=' . $this->mid . ' AND ispay=1 AND comefrom !="0"';

		if (0 < $this->storeid) {
			$wherestr = $wherestr . ' AND storeid=' . $this->storeid;
		}


		$tmpprice = $orderDb->get_one($wherestr, 'sum(goods_price) as tprice');
		(0 < $tmpprice['tprice']) && $entirearr['other'] = $tmpprice['tprice'];
		$stores = M('cashier_stores')->select(array('mid' => $this->mid));

		if (0 < $this->storeid) {
			$t = array();

			foreach ($stores as $store ) {
				if ($this->storeid == $store['id']) {
					$t[] = $store;
				}

			}

			$stores = $t;
		}


		include $this->showTpl();
	}

	public function GetwxUserInfoFromSys($jsonData)
	{
		$url = 'http://test.me.cc/cgi-bin/user/info/batchget?access_token=' . $wxAccessToken . '&lang=zh_CN';
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}
}


?>