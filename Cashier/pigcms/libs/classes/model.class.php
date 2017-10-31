<?php

bpBase::loadSysClass('db_factory', '', 0);
class model
{
	protected $db_config = '';
	protected $db_setting = 'default';
	protected $db = '';
	protected $table_name = '';
	public $db_tablepre = '';

	public function __construct()
	{
		if (!$this->db_config) {
			$this->db_config = loadConfig('db');
		}


		if (!isset($this->db_config[$this->db_setting])) {
			$this->db_setting = 'default';
		}

 
		$this->table_name = $this->db_config[$this->db_setting]['tablepre'] . $this->table_name;
               
		$this->db_tablepre = $this->db_config[$this->db_setting]['tablepre'];
		$this->db = db_factory::get_instance($this->db_config)->get_database($this->db_setting);
	}

	final public function select($where = '', $data = '*', $limit = '', $order = '', $group = '', $key = '')
	{

		if (is_array($where)) {
			$where = $this->sqls($where);
		}
                
		return $this->db->select($data, $this->table_name, $where, $limit, $order, $group, $key);

	}

	final public function selectBySql($sql, $key = '')
	{
		return $this->db->selectBySql($sql, $key = '');
	}

	final public function listinfo($where = '', $order = '', $page = 1, $pagesize = 20, $key = '', $urlrule = '', $array = array())
	{
		$where = to_sqls($where);
		$this->number = $this->count($where);

		if (0 < $page) {
			$page = max(intval($page), 1);
			$offset = $pagesize * ($page - 1);
			$this->pages = pages($this->number, $page, $pagesize, $urlrule, $array);
		}


		$array = array();

		if (0 < $this->number) {
			if (0 < $page) {
				return $this->select($where, '*', $offset . ', ' . $pagesize, $order, '', $key);
			}


			return $this->select($where, '*', '', $order, '', $key);
		}


		return array();
	}

	final public function get_all($data = '*', $from = '', $where = '', $order = '', $limit = '')
	{
		if (!$from) {
			$from = $this->table_name;
		}


		$sql = 'SELECT ' . $data . ' FROM ' . $from;

		if ($where) {
			$where = to_sqls($where);
			$sql .= ' WHERE ' . $where;
		}
		if ($order) {
			$sql .= ' ORDER BY ' . $order;
		}
		if ($limit) {
			$limitNums = explode(',', $limit);
			$sql .= ' LIMIT ' . intval($limitNums[0]) . ',' . $limitNums[1];
		}


		$arr = $this->selectBySql($sql);
		return $arr;
	}

	final public function get_results($data = '*', $from = '', $where = '', $order = '', $limit = '')
	{
		$arr = $this->get_all($data, $from, $where, $order, $limit);
		return array2Objects($arr);
	}

	final public function get_resultsBySql($sql)
	{
		$arr = $this->selectBySql($sql);
		return array2Objects($arr);
	}

	final public function get_resultsBySqlInArr($sql)
	{
		$arr = $this->selectBySql($sql);
		return $arr;
	}

	final public function get_one($where = '', $data = '*', $order = '', $group = '')
	{
		if (is_array($where)) {
			$where = $this->sqls($where);
		}


		return $this->db->get_one($data, $this->table_name, $where, $order, $group);               
	}

	final public function get_var($where = '', $data = '*', $order = '', $group = '')
	{
		$rt = $this->get_one($where, $data, $order, $group);
		return $rt[$data];
	}

	final public function get_varBySql($sql, $coumn)
	{
		$arr = $this->selectBySql($sql);
		return $arr[0][$coumn];
	}

	final public function get_row($where = '', $data = '*', $order = '', $group = '')
	{
		if (is_array($where)) {
			$where = $this->sqls($where);
		}


		$res = $this->db->get_one($data, $this->table_name, $where, $order, $group);
		$obj = NULL;

		if ($res) {
			foreach ($res as $k => $v ) {
				$obj->$k = $v;
			}
		}


		return $obj;
	}

	final public function query($sql)
	{
		return $this->db->query($sql);
	}

	final public function insert($data, $return_insert_id = false, $replace = false)
	{
		
		return $this->db->insert($data, $this->table_name, $return_insert_id, $replace);
	}

	final public function getPK()
	{
		return $this->db->getPK($this->table_name);
	}

	final public function update($data, $where = '')
	{
		if (is_array($where)) {
			$where = $this->sqls($where);
		}


		return $this->db->update($data, $this->table_name, $where);
	}

	final public function delete($where)
	{
		if (is_array($where)) {
			$where = $this->sqls($where);
		}


		return $this->db->delete($this->table_name, $where);
	}

	final public function count($where = '')
	{
		$r = $this->get_one($where, 'COUNT(*) AS num');
		return $r['num'];
	}

	final public function sqls($where, $font = ' AND ')
	{
		if (is_array($where)) {
			$sql = '';

			foreach ($where as $key => $val ) {
				$whereStr = $this->parseWhereItem($this->parseKey($key), $val);
				$sql .= (($sql ? ' ' . $font . ' ' . $whereStr . ' ' : ' ' . $whereStr));
			}

			return $sql;
		}


		return $where;
	}

	protected function parseWhereItem($key, $val)
	{
		$whereStr = '';
		$comparison = array('eq' => '=', 'neq' => '<>', 'gt' => '>', 'egt' => '>=', 'lt' => '<', 'elt' => '<=', 'notlike' => 'NOT LIKE', 'like' => 'LIKE', 'in' => 'IN', 'notin' => 'NOT IN');

		if (is_array($val)) {
			if (is_string($val[0])) {
				if (preg_match('/^(EQ|NEQ|GT|EGT|LT|ELT)$/i', $val[0])) {
					$whereStr .= $key . ' ' . $comparison[strtolower($val[0])] . ' ' . $this->parseValue($val[1]);
				}
				 else if (preg_match('/^(NOTLIKE|LIKE)$/i', $val[0])) {
					if (is_array($val[1])) {
						$likeLogic = ((isset($val[2]) ? strtoupper($val[2]) : 'OR'));
						$likeStr = $comparison[strtolower($val[0])];
						$like = array();

						foreach ($val[1] as $item ) {
							$like[] = $key . ' ' . $likeStr . ' ' . $this->parseValue($item);
						}

						$whereStr .= '(' . implode(' ' . $likeLogic . ' ', $like) . ')';
					}
					 else {
						$whereStr .= $key . ' ' . $comparison[strtolower($val[0])] . ' ' . $this->parseValue($val[1]);
					}
				}
				 else if ('exp' == strtolower($val[0])) {
					$whereStr .= ' (' . $key . ' ' . $val[1] . ') ';
				}
				 else if (preg_match('/IN/i', $val[0])) {
					if (isset($val[2]) && ('exp' == $val[2])) {
						$whereStr .= $key . ' ' . strtoupper($val[0]) . ' ' . $val[1];
					}
					 else {
						if (is_string($val[1])) {
							$val[1] = explode(',', $val[1]);
						}


						$zone = implode(',', $this->parseValue($val[1]));
						$whereStr .= $key . ' ' . strtoupper($val[0]) . ' (' . $zone . ')';
					}
				}
				 else if (preg_match('/BETWEEN/i', $val[0])) {
					$data = ((is_string($val[1]) ? explode(',', $val[1]) : $val[1]));
					$whereStr .= ' (' . $key . ' ' . strtoupper($val[0]) . ' ' . $this->parseValue($data[0]) . ' AND ' . $this->parseValue($data[1]) . ' )';
				}
				 else {
					throw_exception(L('_EXPRESS_ERROR_') . ':' . $val[0]);
				}
			}
			 else {
				$count = count($val);

				if (in_array(strtoupper(trim($val[$count - 1])), array('AND', 'OR', 'XOR'))) {
					$rule = strtoupper(trim($val[$count - 1]));
					$count = $count - 1;
				}
				 else {
					$rule = 'AND';
				}

				$i = 0;

				while ($i < $count) {
					$data = ((is_array($val[$i]) ? $val[$i][1] : $val[$i]));

					if ('exp' == strtolower($val[$i][0])) {
						$whereStr .= '(' . $key . ' ' . $data . ') ' . $rule . ' ';
					}
					 else {
						$op = ((is_array($val[$i]) ? $comparison[strtolower($val[$i][0])] : '='));
						$whereStr .= '(' . $key . ' ' . $op . ' ' . $this->parseValue($data) . ') ' . $rule . ' ';
					}

					++$i;
				}

				$whereStr = substr($whereStr, 0, -4);
			}
		}
		 else {
			$whereStr .= $key . ' = ' . $this->parseValue($val);
		}

		return $whereStr;
	}

	protected function parseKey(&$key)
	{
		return $key;
	}

	protected function parseValue($value)
	{
		if (is_string($value)) {
			$value = '\'' . $this->escapeString($value) . '\'';
		}
		 else if (isset($value[0]) && is_string($value[0]) && (strtolower($value[0]) == 'exp')) {
			$value = $this->escapeString($value[1]);
		}
		 else if (is_array($value)) {
			$value = array_map(array($this, 'parseValue'), $value);
		}
		 else if (is_bool($value)) {
			$value = (($value ? '1' : '0'));
		}
		 else if (is_null($value)) {
			$value = 'null';
		}


		return $value;
	}

	public function escapeString($str)
	{
		return addslashes($str);
	}

	final public function affected_rows()
	{
		return $this->db->affected_rows();
	}

	final public function get_primary()
	{
		return $this->db->get_primary($this->table_name);
	}

	final public function get_fields($table_name = '')
	{
		if (empty($table_name)) {
			$table_name = $this->table_name;
		}
		 else {
			$table_name = $this->db_tablepre . $table_name;
		}

		return $this->db->get_fields($table_name);
	}

	final public function table_exists($table)
	{
		return $this->db->table_exists($this->db_tablepre . $table);
	}

	public function field_exists($field)
	{
		$fields = $this->db->get_fields($this->table_name);
		return array_key_exists($field, $fields);
	}

	final public function list_tables()
	{
		return $this->db->list_tables();
	}

	final public function fetch_array()
	{
		$data = array();

		while ($r = $this->db->fetch_next()) {
			$data[] = $r;
		}

		return $data;
	}

	final public function version()
	{
		return $this->db->version();
	}
}


?>