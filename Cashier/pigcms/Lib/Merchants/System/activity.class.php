<?php

bpBase::loadAppClass('common', 'System', 0);
class activity_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();
		bpBase::loadOrg('common_page');
	}

	public function crowdfunding()
	{
		$keyword = ((isset($_GET['keyword']) ? htmlspecialchars(trim($_GET['keyword'])) : ''));
		$where = (($keyword ? '`name` LIKE \'%' . $keyword . '%\'' : ''));
		$this->assign('keyword', $keyword);
		$db = M('crowdfunding');
		$_count = $db->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id desc');
		$result = array();
		$ids = $pre = '';

		foreach ($lists as $l ) {
			$temp = array();
			$temp['title'] = $l['name'];
			$temp['pic'] = $l['pic'];
			$temp['price'] = $l['fund'];
			$temp['original_price'] = 0;
			$temp['endtime'] = (($l['start'] ? date('Y-m-d H:i:s', $l['start'] + ($l['day'] * 86400)) : ''));
			$temp['id'] = $l['id'];
			$ids .= $pre . $l['id'];
			$pre = ',';
			$result[] = $temp;
		}
                
		$this->formatData($ids, $result, 'crowdfunding');
		$this->assign('title', '微众筹');
		$this->assign('table_name', 'crowdfunding');
		$this->assign('pagebar', $pagebar);
		$this->assign('lists', $result);
		$this->display('activity');
	}

	public function seckill()
	{
		$now = time();
		$keyword = ((isset($_GET['keyword']) ? htmlspecialchars(trim($_GET['keyword'])) : ''));
		$where = (($keyword ? '`action_name` LIKE \'%' . $keyword . '%\' AND action_sdate<\'' . $now . '\' AND action_edate>\'' . $now . '\'' : ' action_sdate<\'' . $now . '\' AND action_edate>\'' . $now . '\''));
		$this->assign('keyword', $keyword);
		$db = M('seckill_action');
		$_count = $db->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows, 'action_id desc');
		$result = array();
		$ids = $pre = '';

		foreach ($lists as $l ) {
			$temp = array();
			$temp['title'] = $l['action_name'];
			$temp['pic'] = $l['action_header_img'];
			$temp['price'] = 0;
			$temp['endtime'] = date('Y-m-d H:i:s', $l['action_edate']);
			$temp['id'] = $l['action_id'];
			$ids .= $pre . $l['action_id'];
			$pre = ',';
			$result[] = $temp;
		}

		if ($ids) {
			$shop_lists = M('seckill_base_shop')->select('shop_open=0 AND action_id IN (' . $ids . ')', '*', '', 'shop_id DESC', 'action_id');
			$temp_list = array();

			foreach ($shop_lists as $shop ) {
				$temp_list[$shop['action_id']] = $shop;
			}

			foreach ($result as &$rs ) {
				$rs['price'] = ((isset($temp_list[$rs['id']]['shop_price']) ? $temp_list[$rs['id']]['shop_price'] : 0));
				$rs['original_price'] = 0;
				$rs['title'] = ((isset($temp_list[$rs['id']]['shop_name']) ? $temp_list[$rs['id']]['shop_name'] : $rs['title']));
			}
		}


		$this->formatData($ids, $result, 'seckill_action');
		$this->assign('title', '微秒杀');
		$this->assign('table_name', 'seckill_action');
		$this->assign('pagebar', $pagebar);
		$this->assign('lists', $result);
		$this->display('activity');
	}

	public function unitary()
	{
		$keyword = ((isset($_GET['keyword']) ? htmlspecialchars(trim($_GET['keyword'])) : ''));
		$where = (($keyword ? '`name` LIKE \'%' . $keyword . '%\' AND `state`=1' : '`state`=1'));
		$this->assign('keyword', $keyword);
		$db = M('unitary');
		$_count = $db->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id desc');
		$result = array();
		$ids = $pre = '';

		foreach ($lists as $l ) {
			$temp = array();
			$temp['title'] = $l['name'];
			$temp['pic'] = $l['logopic'];
			$temp['price'] = $l['price'];
			$temp['original_price'] = $l['price'];
			$temp['endtime'] = (($l['endtime'] ? date('Y-m-d H:i:s', $l['endtime']) : ''));
			$temp['id'] = $l['id'];
			$ids .= $pre . $l['id'];
			$pre = ',';
			$result[] = $temp;
		}

		$this->formatData($ids, $result, 'unitary');
		$this->assign('title', '一元夺宝');
		$this->assign('table_name', 'unitary');
		$this->assign('pagebar', $pagebar);
		$this->assign('lists', $result);
		$this->display('activity');
	}

	public function bargain()
	{
		$keyword = ((isset($_GET['keyword']) ? htmlspecialchars(trim($_GET['keyword'])) : ''));
		$where = (($keyword ? '`name` LIKE \'%' . $keyword . '%\'' : ''));
		$this->assign('keyword', $keyword);
		$db = M('bargain');
		$_count = $db->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows, 'pigcms_id desc');
		$result = array();
		$ids = $pre = '';

		foreach ($lists as $l ) {
			$temp = array();
			$temp['title'] = $l['name'];
			$temp['pic'] = $l['logoimg1'];
			$temp['price'] = $l['minimum'];
			$temp['original_price'] = $l['original'];
			$temp['endtime'] = '';
			$temp['id'] = $l['pigcms_id'];
			$ids .= $pre . $l['pigcms_id'];
			$pre = ',';
			$result[] = $temp;
		}

		$this->formatData($ids, $result, 'bargain');
		$this->assign('title', '微砍价');
		$this->assign('table_name', 'bargain');
		$this->assign('pagebar', $pagebar);
		$this->assign('lists', $result);
		$this->display('activity');
	}

	public function cutprice()
	{
		$now = time();
		$keyword = ((isset($_GET['keyword']) ? htmlspecialchars(trim($_GET['keyword'])) : ''));
		$where = (($keyword ? '`name` LIKE \'%' . $keyword . '%\' AND starttime<\'' . $now . '\'' : 'starttime<\'' . $now . '\''));
		$this->assign('keyword', $keyword);
		$db = M('cutprice');
		$_count = $db->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows, 'pigcms_id desc');
		$result = array();
		$ids = $pre = '';

		foreach ($lists as $l ) {
			$temp = array();
			$temp['title'] = $l['name'];
			$temp['pic'] = $l['logoimg1'];
			$temp['price'] = $l['stopprice'];
			$temp['original_price'] = $l['original'];
			$temp['endtime'] = '';
			$temp['id'] = $l['pigcms_id'];
			$ids .= $pre . $l['pigcms_id'];
			$pre = ',';
			$result[] = $temp;
		}

		$this->formatData($ids, $result, 'cutprice');
		$this->assign('title', '降价拍');
		$this->assign('table_name', 'cutprice');
		$this->assign('pagebar', $pagebar);
		$this->assign('lists', $result);
		$this->display('activity');
	}

	public function auction()
	{
	}

	public function lottery()
	{
		$now = time();
		$keyword = ((isset($_GET['keyword']) ? htmlspecialchars(trim($_GET['keyword'])) : ''));
		$where = (($keyword ? '`title` LIKE \'%' . $keyword . '%\' AND `statdate`<\'' . $now . '\' AND `enddate`>=\'' . $now . '\'' : '`statdate`<\'' . $now . '\' AND `enddate`>=\'' . $now . '\''));
		$this->assign('keyword', $keyword);
		$db = M('lottery');
		$_count = $db->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id desc');
		$result = array();
		$ids = $pre = '';

		foreach ($lists as $l ) {
			$temp = array();
			$temp['title'] = $l['title'];
			$temp['pic'] = $l['starpicurl'];
			$temp['price'] = $l['fist'];
			$temp['original_price'] = 0;
			$temp['endtime'] = date('Y-m-d H:i:s', $l['enddate']);
			$temp['id'] = $l['id'];
			$ids .= $pre . $l['id'];
			$pre = ',';
			$result[] = $temp;
		}

		$this->formatData($ids, $result, 'lottery');
		$this->assign('title', '抽奖专场');
		$this->assign('table_name', 'lottery');
		$this->assign('pagebar', $pagebar);
		$this->assign('lists', $result);
		$this->display('activity');
	}

	private function formatData($ids, &$data, $table_name)
	{
		if ($ids) {
			$tlist = M('cashier_activity')->select('activity_id IN (' . $ids . ') AND table_name=\'' . $table_name . '\'');
			$list = array();

			foreach ($tlist as $row ) {
				$list[$row['activity_id']] = $row;
			}

			foreach ($data as &$d ) {
				$d['selected'] = ((isset($list[$d['id']]) ? 1 : 0));
			}
		}

	}

	public function addActivity()
	{
		$activity_id = ((isset($_POST['actid']) ? intval($_POST['actid']) : 0));
		$selected = ((isset($_POST['selected']) ? intval($_POST['selected']) : 1));
		$table_name = ((isset($_POST['table_name']) ? htmlspecialchars($_POST['table_name']) : ''));
		$actDB = M('cashier_activity');
		$where = array('activity_id' => $activity_id, 'table_name' => $table_name);

		$activity = $actDB->get_one($where);

		if (empty($activity)) {
			$data = array();

			switch ($table_name) {
			case 'crowdfunding':
				if ($l = M('crowdfunding')->get_one(array('id' => $activity_id))) {
					$data['title'] = $l['name'];
					$data['token'] = $l['token'];
					$data['pic'] = $l['pic'];
					$data['price'] = $l['fund'];
					$data['original_price'] = 0;
					$data['endtime'] = $l['start'] + ($l['day'] * 86400);
				}


				break;

			case 'seckill_action':
				if ($l = M('seckill_action')->get_one(array('action_id' => $activity_id))) {
					$shops = M('seckill_base_shop')->select('shop_open=0 AND action_id=' . $activity_id, '*', '0,1', 'shop_id DESC');
					$data['title'] = ((isset($shops[0]['shop_name']) ? $shops[0]['shop_name'] : $l['title']));
					$data['token'] = $l['action_token'];
					$data['pic'] = $l['action_header_img'];
					$data['price'] = ((isset($shops[0]['shop_price']) ? $shops[0]['shop_price'] : 0));
					$data['original_price'] = 0;
					$data['endtime'] = $l['action_edate'];
				}


				break;

			case 'unitary':
				if ($l = M('unitary')->get_one(array('id' => $activity_id))) {
					$data['title'] = $l['name'];
					$data['token'] = $l['token'];
					$data['pic'] = $l['logopic'];
					$data['price'] = $l['price'];
					$data['original_price'] = $l['price'];
					$data['endtime'] = $l['endtime'];
				}


				break;

			case 'bargain':
				if ($l = M('bargain')->get_one(array('pigcms_id' => $activity_id))) {
					$data['title'] = $l['name'];
					$data['token'] = $l['token'];
					$data['pic'] = $l['logoimg1'];
					$data['price'] = $l['minimum'];
					$data['original_price'] = $l['original'];
					$data['endtime'] = 0;
				}


				break;

			case 'cutprice':
				if ($l = M('cutprice')->get_one(array('pigcms_id' => $activity_id))) {
					$data['title'] = $l['name'];
					$data['token'] = $l['token'];
					$data['pic'] = $l['logoimg1'];
					$data['price'] = $l['stopprice'];
					$data['original_price'] = $l['original'];
					$data['endtime'] = 0;
				}


				break;

			case 'lottery':
				if ($l = M('lottery')->get_one(array('id' => $activity_id))) {
					$data['title'] = $l['title'];
					$data['token'] = $l['token'];
					$data['pic'] = $l['starpicurl'];
					$data['price'] = $l['fist'];
					$data['original_price'] = 0;
					$data['type'] = $l['type'];
					$data['endtime'] = $l['enddate'];
				}


				break;
                            
				if ($data) {
					$data['table_name'] = $table_name;
					$data['activity_id'] = $activity_id;
					$actDB->insert($data);
				}

			}
		}
		 else {
		}
	}

	public function myactivity()
	{
		$keyword = ((isset($_GET['keyword']) ? htmlspecialchars(trim($_GET['keyword'])) : ''));
		$where = (($keyword ? '`title` LIKE \'%' . $keyword . '%\'' : ''));
		$this->assign('keyword', $keyword);
		$db = M('cashier_activity');
		$_count = $db->count($where);
		$p = new Page($_count, 20);
		$pagebar = $p->show(2);
		$lists = $db->select($where, '*', $p->firstRow . ',' . $p->listRows, 'id asc');
		$result = array();
		$ids = $pre = '';
		$title_array = array('crowdfunding' => '微众筹', 'seckill_action' => '微秒杀', 'unitary' => '一元夺宝', 'bargain' => '微砍价', 'cutprice' => '降价拍', 'lottery' => '抽奖专场');
		$type_array = array(1 => '大转盘', 2 => '刮刮卡', 3 => '优惠券', 4 => '水果机', 5 => '砸金蛋', 6 => '微调研', 7 => '走鹊桥', 8 => '摁死情侣', 9 => '吃月饼', 10 => '九宫格');

		foreach ($lists as &$l ) {
			$l['endtime'] = (($l['endtime'] ? date('Y-m-d H:i:s', $l['endtime']) : ''));
			$l['typename'] = (($l['table_name'] == 'lottery' ? $type_array[$l['type']] : $title_array[$l['table_name']]));
		}

		$this->assign('title', '正在进行的活动');
		$this->assign('pagebar', $pagebar);
		$this->assign('lists', $lists);
		$this->display();
	}

	public function delact()
	{
		$id = ((isset($_GET['id']) ? intval($_GET['id']) : 0));

		if (empty($id)) {
			$this->dexit(array('errcode' => 1, 'errmsg' => '参数错误'));
		}


		M('cashier_activity')->delete(array('id' => $id));
		$this->dexit(array('errcode' => 0, 'errmsg' => '删除成功'));
	}
}


?>