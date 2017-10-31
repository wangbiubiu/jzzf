<?php
//总后台统计管理
bpBase::loadAppClass('common', 'System', 0);
class author_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();
	}
        //管理员列表
        public function admin(){
            $this->display();
        }
         //添加管理员
        public function addm(){
            $this->display();
        }
       //角色列表
        public function role(){
             $this->display();
        }
        //添加角色
        public function addrole(){
             $this->display();
        }
	
}


?>