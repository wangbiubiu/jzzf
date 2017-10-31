<?php
//加密方式：Ioncube 7.X/8.X/9.X加密，代码还原率98+%以上。
//此程序由【找源码】http://Www.ZhaoYuanMa.Com (VIP会员功能）在线逆向还原，QQ：7530782 
?>
<?php
final class db_factory
{
	static 	private $db_factory;
	protected $db_config = array();
	protected $db_list = array();

	public function __construct()
	{
	}

	static public function get_instance($db_config = '')
	{
		if (db_factory::$db_factory == '') {
			db_factory::$db_factory = new db_factory();
		}


		if (($db_config != '') && ($db_config != db_factory::$db_factory->db_config)) {
			db_factory::$db_factory->db_config = array_merge($db_config, db_factory::$db_factory->db_config);
		}


		return db_factory::$db_factory;
	}

	public function get_database($db_config_name)
	{
		if (!isset($this->db_list[$db_config_name]) || !is_object($this->db_list[$db_config_name])) {
			$this->db_list[$db_config_name] = $this->connect($db_config_name);
		}


		return $this->db_list[$db_config_name];
	}

	public function connect($db_config_name)
	{
		$object = NULL;

		switch ($this->db_config[$db_config_name]['type']) {
		case 'mysql':
			bpBase::loadSysClass('mysql', '', 0);
			$object = new mysql();
			break;

		case 'mysqli':
			$object = bpBase::loadSysClass('mysqli');
			break;

		case 'access':
			$object = bpBase::loadSysClass('db_access');
			break;

			bpBase::load_sys_class('mysql', '', 0);
			$object = new mysql();
		}

		$object->open($this->db_config[$db_config_name]);
		return $object;
	}

	protected function close()
	{
		foreach ($this->db_list as $db ) {
			$db->close();
		}
	}

	public function __destruct()
	{
		$this->close();
	}
}


?>