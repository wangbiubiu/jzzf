<?php

bpBase::loadSysClass('model', '', 0);
class cashier_stores_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_stores';
		parent::__construct();
	}

	public function GetStores($where, $state = 3, $field = '*')
	{
		if ($state != 'nogo') {
			if (is_array($where)) {
				$where['available_state'] = $state;
			}
			 else {
				$where .= ' AND available_state=' . $state;
			}
		}


		$datas = $this->select($where, $field, '', '');
		return $datas;
	}

	public function updateDiscount($data, $storeids, $mid, $isstoreid = false)
	{
		if (empty($storeids)) {
			return false;
		}


		$poi_ids = '';
		$pre = '';

		if (!$isstoreid) {
			foreach ($storeids as $poi ) {
				$poi_ids .= $pre . '\'' . $poi . '\'';
				$pre = ',';
			}

			if (empty($poi_ids)) {
				return false;
			}

		}


		$keys = array_keys($data);

		foreach ($keys as $key ) {
			if (!in_array($key, array('discount', 'least_cost', 'reduce_cost'))) {
				unset($data[$key]);
			}

		}

		if (empty($data)) {
			return false;
		}
		if ($isstoreid) {
			$stores = $this->select('id IN (' . $storeids . ') AND mid=' . $mid);
		}
		 else {
			$stores = $this->select('poi_id IN (' . $poi_ids . ') AND mid=' . $mid);
		}

		$condition = array();

		foreach ($stores as $store ) {
			if (isset($data['reduce_cost']) && isset($data['least_cost']) && ($store['reduce_cost'] < $data['reduce_cost'])) {
				$condition[$store['id']] = array('reduce_cost' => $data['reduce_cost'], 'least_cost' => $data['least_cost']);
			}


			if (isset($data['discount']) && (($store['discount'] <= 0) || ($data['discount'] < $store['discount']))) {
				if (is_array($condition[$store['id']])) {
					$condition[$store['id']]['discount'] = $data['discount'];
				}
				 else {
					$condition[$store['id']] = array('discount' => $data['discount']);
				}
			}

		}

		foreach ($condition as $id => $updatedata ) {
			$this->update($updatedata, array('id' => $id, 'mid' => $mid));
		}
	}

	public function get_list_by_condition($where, $order, $lat = 0, $lng = 0, $page = 1, $pagesize = 10)
	{
		$fields = array('fsortid', 'sortid', 'provinceid', 'cityid', 'circleid');
		$condition_where = 'isshow="1"';

		if (!empty($where) && is_array($where)) {
			foreach ($where as $key => $value ) {
				if (!in_array($key, $fields)) {
					continue;
				}


				$condition_where .= ' AND `' . $key . '`=\'' . $value . '\'';
			}
		}
		 else if (!empty($where)) {
			$condition_where .= ' AND ' . $where;
		}


		$juli = '';
		$flage = false;

		switch ($order) {
		case 'avg_price-asc':
			$order = '`avg_price` ASC, `id` DESC';
			break;

		case 'avg_price-desc':
			$order = '`avg_price` DESC, `id` DESC';
			break;

		case 'discount-asc':
			$order = '`discount` ASC, `id` DESC';
			$flage = true;
			break;

		case 'discount-desc':
			$order = '`discount` DESC, `id` DESC';
			break;

		case 'reduce_cost-asc':
			$order = '`reduce_cost` ASC, `id` DESC';
			break;

		case 'reduce_cost-desc':
			$order = '`reduce_cost` DESC, `id` DESC';
			break;

		case 'juli':

			$juli = ', ROUND(6378.137 * 2 * ASIN(SQRT(POW(SIN((' . $lat . '*PI()/180-`latitude`*PI()/180)/2),2)+COS(' . $lat . '*PI()/180)*COS(`latitude`*PI()/180)*POW(SIN((' . $lng . '*PI()/180-`longitude`*PI()/180)/2),2)))*1000) AS juli';
			$order = 'juli asc';
			break;
			$start = ($page - 1) * $pagesize;
/*可能存在bug, 将此后代码到:switch 的结束大括号代码移到switch的结束外面 */
			$data = (($juli ? '*' . $juli : '*'));
			$lists = $this->select($condition_where, $data, $start . ', ' . $pagesize, $order);
			$mids = array();
			$sortids = array();

			foreach ($lists as &$v ) {
				$v['photo_list'] = unserialize($v['photo_list']);
				$v['shoplogo'] = ((!empty($v['photo_list']) ? ((isset($v['photo_list'][0]['local_img']) ? $v['photo_list'][0]['local_img'] : $v['photo_list'][0]['photo_url'])) : ''));
				unset($v['photo_list']);
				$v['receivenum'] = 0;
				$v['juli'] = ROUND(6378.1379999999999 * 2 * ASIN(SQRT(POW(SIN(((($lat * PI()) / 180) - (($v['latitude'] * PI()) / 180)) / 2), 2) + (COS(($lat * PI()) / 180) * COS(($v['latitude'] * PI()) / 180) * POW(SIN(((($lng * PI()) / 180) - (($v['longitude'] * PI()) / 180)) / 2), 2)))) * 1000);
				$v['juli'] = ((1000 < $v['juli'] ? number_format($v['juli'] / 1000, 1) . 'km' : (($v['juli'] < 100 ? '<100m' : $v['juli'] . 'm'))));

				if (!in_array($v['mid'], $mids)) {
					$mids[] = $v['mid'];
				}


				if (!in_array($v['sortid'], $sortids)) {
					$sortids[] = $v['sortid'];
				}

			}
		}

		$receivenums = array();

		if ($mids) {
			$wx_coupons = M('cashier_wxcoupon')->select('status=1 AND isdel=0 AND mid IN (' . implode(',', $mids) . ')');

			foreach ($wx_coupons as $wx ) {
				$poi_id_array = explode(',', $wx['poi_ids']);

				foreach ($poi_id_array as $poi_id ) {
					if (isset($receivenums[$poi_id])) {
						$receivenums[$poi_id] += $wx['receivenum'];
					}
					 else {
						$receivenums[$poi_id] = $wx['receivenum'];
					}
				}
			}
		}


		$category_list = array();

		if ($sortids) {
			$categorys = M('cashier_category')->select('is_hide=0 AND id IN (' . implode(',', $sortids) . ')');

			foreach ($categorys as $category ) {
				$category_list[$category['id']] = $category['name'];
			}
		}


		$tmpArr = array();

		foreach ($lists as $kk => $l ) {
			$lists[$kk]['receivenum'] = ((isset($receivenums[$l['poi_id']]) ? $receivenums[$l['poi_id']] : 0));
			$lists[$kk]['category_name'] = ((isset($category_list[$l['sortid']]) ? $category_list[$l['sortid']] : '其他类型'));
			if ($flage && !0 < $l['discount']) {
				$tmpArr[] = $l;
				unset($lists[$kk]);
			}

		}

		if (!empty($tmpArr)) {
			foreach ($tmpArr as $tvv ) {
				$lists[] = $tvv;
			}
		}


		$count = $this->count($condition_where);
		$nextpage = ((($start + $pagesize) < $count ? $page + 1 : 0));
		return array('list' => $lists, 'nextpage' => $nextpage);
	}
}


?>