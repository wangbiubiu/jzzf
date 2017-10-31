<?php

if(PHP_VERSION > '5.1'){
    @date_default_timezone_set('Asia/Shanghai');
}
/************************MySQL settings**************************/
define('TABLE_PREFIX','');
//define('GAME_TABLE_PREFIX','wechat_');
define('CHARSET','utf-8');
define('DB_CHARSET','utf-8');

/************************程序 settings**************************/
define('PIGCMS_KEY','pigcmso2oCashier');

/***********************App对接极光通知配置*************************/
/* define('JPUSH_AppKey','2dd1f4103e70e30d4c116611');//打小票机器
define('JPUSH_MasterSecret','3b9c8f881162ec21780ea3a2');
 */
/************************又拍云 settings*******************************/
define('upload_type',1); // 0为本地上传 1为又拍云 
define('up_bucket','chenyun');
define('up_form_api_secret','rY7h9T/vwffDcQN4tLtJWtn9If4=');
define('up_username','chenyun');
define('up_password','lomos516626');
define('up_domainname','chenyun.b0.upaiyun.com');
define('up_exts','jpeg,jpg,png,mp3,gif');
define('up_size','102400000');

/*************加密配置**********************/
//define('File_Service_Key','5ac00722405fbe0607e8cbc5b09ee009');/*****http://test1.pigcms.cn：5ac00722405fbe0607e8cbc5b09ee009*****/
define('File_Emergent_Mode','0');
/* define('File_Server_Topdomain','pigcms.cn');
define('OrderPrint_ServerUrl','http://up.pigcms.cn/'); */

?>