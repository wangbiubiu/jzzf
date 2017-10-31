<?php

	ini_set("display_errors", "Off");
	if(!file_exists('./Cashier/upload/png/'.date('Ymd', time()).'/'.date('Ymd', time()))){
		mkdir('./Cashier/upload/png/'.date('Ymd', time()).'/'.date('Ymd', time()), 0755,true);
	}
	define('ABS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'Cashier'.DIRECTORY_SEPARATOR);
	define('PIGCMS_CORE_PATH','./pigcms/');
	define('PIGCMS_CORE_PATH_FOLDER','./Cashier/pigcms/');

	define('PIGCMS_TPL_PATH','./pigcms_tpl/');
	define('PIGCMS_TPL_PATH_FOLDER','./Cashier/pigcms_tpl/');

	
	define('PIGCMS_TPL_PATH_PLUGINS','./Cashier/pigcms_static/plugins/');//css ,js文件路径
	define('PIGCMS_TPL_PATH_IMAGE','./Cashier/pigcms_static/image/');//image文件路径
	define('WX_MESSAGE_PAY_ID','1Z9OTmsEHTpq7eq7n_6RIsMWdW-ZQm-SEMJXggWlqIw');//支付成功通知模版消息
	

	
	
	define('PIGCMS_STATIC_PATH','./pigcms_static/');
	define('PIGCMS_STATIC_PATH_FOLDER','./Cashier/pigcms_static/');
	define('ABS_UPLOAD_PATH','/Cashier');/**独立作为站时不要配置此项或者配置成空''*****/
	define('APP_NAME','Merchants');
	define('DEBUG',true);
	define('GZIP',true);
	
	include ABS_PATH.'config'.DIRECTORY_SEPARATOR.'config.inc.php';
	include ABS_PATH.PIGCMS_CORE_PATH.'base.php';
	bpBase::creatApp();
?>
