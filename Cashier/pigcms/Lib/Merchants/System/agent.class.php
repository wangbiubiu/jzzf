<?php

//总后台统计管理
bpBase::loadAppClass('common', 'System', 0);

class agent_controller extends common_controller {

    public function __construct() {
        parent::__construct();
        $this->model = M('cashier_agent');
    }

    //代理中心列表
    public function index() {
        $data = $this->clear_html($_GET);
        if ($data) {
            $where = " uname like '%" . $data['uname'] . "%'";
        }

        bpBase::loadOrg('common_page');
        $_count = $this->model->count($where);
        $p = new Page($_count, 10);
        $pagebar = $p->show(2);
        $rows = $this->model->select($where, '*', "$p->firstRow,$p->listRows","aid DESC");
        foreach ($rows as &$v) {
            $v['add_time'] = date('Y-m-d', $v['add_time']);
        }
        $this->assign('data', $data);
        $this->assign('pagebar', $pagebar);
        $this->assign('rows', $rows);
        $this->display();
    }


    //Excel导出

    public function data2Excel () {
        $rows = $this->model->get_all('*','','','aid desc');
        $data = array();
        foreach ($rows as $k => $v) {
           $data[$k]['account'] = $v['account'];
           $data[$k]['uname'] = $v['uname'];
           $data[$k]['commission'] = $v['commission'];
           $data[$k]['alicommission'] = $v['alicommission'];
           $data[$k]['add_time'] = date('Y-m-d',$v['add_time']);
           $data[$k]['account'] = $v['account'];
        }
        $title = array('账户名称','代理名称','微信佣金返点','支付宝佣金返点','添加时间');
        $filename = '代理商清单列表'.date('Y-m-d').'.xls';
        $this->ExportTable($data,$title,$filename);

        

    }
    //添加代理商
    public function add() {

        if (IS_POST) {
            $data = $this->clear_html($_POST);
//            dump($data);exit();
            $uname = M('cashier_agent')->get_one("`uname`='" . $data['uname'] . "'");
            $account =  M('cashier_agent')->get_one("`account`='" . $data['account'] . "'");
            $pwd = $data['password'];
            if ($uname) {
                $this->errorTip('代理商名称已存在！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if ($account) {
                $this->errorTip('登录账号已存在！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!$data['uname']) {
                $this->errorTip('代理商名称不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!$data['account']) {
                $this->errorTip('账号不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            if(!preg_match($pattern,$data['account'])){
                $this->errorTip('账号邮箱格式不正确！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!$data['password']) {
                $this->errorTip('密码不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            if (strlen($data['password'])<6 || strlen($data['password'])>16) {
                $this->errorTip('密码长度为6-16位！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if ($data['password'] != $data['repassword']) {
                $this->errorTip('两次输入密码不一致！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!$data['phone']) {
                $this->errorTip('手机号码不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!preg_match("/^1[34578]\d{9}$/", $data['phone'])) {
                $this->errorTip('手机号码格式不正确！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if(isset($data['mtype'])==false){
                $this->errorTip('佣金类型不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
//         if (!$data['alicommission']) {
//            $this->errorTip('支付宝佣金不能为空！', $_SERVER['HTTP_REFERER']);
//          exit;
//         }
//        if (!$data['commission']) {
//         $this->errorTip('微信佣金不能为空！', $_SERVER['HTTP_REFERER']);
//         exit;
//           }

//            if (!$data['alicommission']) {
//                $this->errorTip('一清支付宝佣金不能为空！', $_SERVER['HTTP_REFERER']);
//                exit;
//            }
//            if (!$data['ancommission']) {
//                $this->errorTip('二清微信佣金不能为空！', $_SERVER['HTTP_REFERER']);
//                exit;
//            }
//             if (!$data['analicommission']) {
//                $this->errorTip('二清支付宝佣金不能为空！', $_SERVER['HTTP_REFERER']);
//                exit;
//            }
            if (!$data['contacts']) {
                $this->errorTip('联系人不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            if (!$data['corporate']) {
                $this->errorTip('公司名称不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!$data['address']) {
                $this->errorTip('详细地址不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!$data['provincename']) {
                $this->errorTip('省份不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!$data['cityname']) {
                $this->errorTip('城市不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            if($this->Getdir($data['cityid']) && !$data['countyname']){
                 $this->errorTip('地区不能为空！', $_SERVER['HTTP_REFERER']);
                 exit;
            }

            if (isset($data['mtype'][0]) && isset($data['mtype'][1])) {
                $mtype =array_sum($data['mtype']);
                unset($data['mtype']);
            }else{
                $mtype = $data['mtype'][0];
                unset($data['mtype']);
            }
            $data['mtype']=$mtype;
            $data['commission'] = $data['commission']/100;
            $data['alicommission'] = $data['alicommission']/100;
//            $data['alicommission'] = $data['alicommission']/100;
            $data['ancommission'] = $data['ancommission']/100;
            $data['analicommission'] = $data['analicommission']/100;
            $data['qqcommission'] = $data['qqcommission']/100;
            $data['wxcommission'] = $data['wxcommission']/100;
            $data['add_time'] = time();
            $data['salt'] = mt_rand(111111, 999999);
            $data['password'] = md5(md5($data['password'] . '_' . $data['salt']) . $data['salt']);
            unset($data['repassword']);
             if (M('cashier_agent')->insert($data, 1)) {
                 $url = $this->SiteUrl.'/agent.php';
                 bpBase::loadOrg('Email');
                 $email = new Email();
                 $subject = "极致支付平台代理商注册成功通知";//设置邮箱标题
                 $address = $data['account'];//需要发送的邮箱地址 
                 $content = <<<ETC
                 <div style="width: 80%; background: #FFFFFF;">
        			<h1 style="font-weight: normal; text-align: center; width: 100%; border-bottom: 1px solid #F3F3F3;">欢迎注册极致支付代理商平台</h1>
        			<div style="padding: 0 30px;">账号注册成功<span>登录地址：$url </span></div>
        			<p style="padding: 0 30px;">我们已向你的邮箱 $address 发送邮件,登录帐号:$address,登录密码: $pwd </p>
        		</div>
ETC;
                 $res = $email->send_email($address,$subject,$content);
                 
                 $this->successTip('添加代理商账号成功！', "/merchants.php?m=System&c=agent&a=index");
                 exit;
             } else {
                 $this->errorTip('添加代理商账号失败！', $_SERVER['HTTP_REFERER']);
                 exit;
             }
        } else {
            $districts = M('cashier_district')->select(array('fid' => '0'), '*', '', 'id ASC');
            $teWx=M('cashier_wxrebate')->select(['id'=>1],'rebate');//查出特约商户 微信结算费率
            $teAli=M('cashier_wxrebate')->select(['id'=>2],'rebate');//查出特约商户 支付宝结算费率
            $yinWx=M('cashier_wxrebate')->select(['id'=>3],'rebate');//查出银行直连 微信结算费率
            $yinAli=M('cashier_wxrebate')->select(['id'=>4],'rebate');//查出银行直连 支付宝结算费率
            $jhzwxs=M('cashier_wxrebate')->select(['id'=>9],'rebate');//查出金海哲 微信结算费率
            $jhzqqs=M('cashier_wxrebate')->select(['id'=>10],'rebate');//查出金海哲 qq结算费率
            $teWx = explode(",",$teWx[0]['rebate']);
            $teAli = explode(",",$teAli[0]['rebate']);
            $yinWx = explode(",",$yinWx[0]['rebate']);
            $yinAli = explode(",",$yinAli[0]['rebate']);
            $jhzwxs = explode(",",$jhzwxs[0]['rebate']);
            $jhzqqs = explode(",",$jhzqqs[0]['rebate']);
            $this->assign('teWx',$teWx);
            $this->assign('teAli',$teAli);
            $this->assign('yinWx',$yinWx);
            $this->assign('yinAlis',$yinAli);
            $this->assign('jhzwxs',$jhzwxs);
            $this->assign('jhzqqs',$jhzqqs);
            $this->assign("districts", $districts);
            $this->display();
//            include $this->showTpl('add');
        }
    }

    //管理
    public function see() {
        $aid = $this->clear_html($_GET['aid']);
        $row = $this->model->get_one('aid=' . $aid);
        $data=M('cashier_wxrebate')->select(['id'=>8],'rebate');
        $array = explode(",",$data[0]['rebate']);
        $this->assign('data',$array);
        $this->assign('row', $row);
        $this->display();
    }

    //编辑
    public function edit() {
        if(IS_POST){
            $data = $this->clear_html($_POST);

            $uname = M('cashier_agent')->get_one("`uname`='" . $data['uname'] . "' AND aid<>".$data['aid']);
            $account =  M('cashier_agent')->get_one("`account`='" . $data['account'] . "' AND aid<>".$data['aid']);
            if ($uname) {
                $this->errorTip('代理商名称已存在！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if ($account) {
                $this->errorTip('登录账号已存在！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!$data['uname']) {
                $this->errorTip('代理商名称不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!$data['account']) {
                $this->errorTip('账号不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            if(!preg_match($pattern,$data['account'])){
                $this->errorTip('账号邮箱格式不正确！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if($data['checkbox']==1){
                if (!$data['password']) {
                    $this->errorTip('密码不能为空！', $_SERVER['HTTP_REFERER']);
                    exit;
                }

                if (strlen($data['password'])<6 || strlen($data['password'])>16) {
                    $this->errorTip('密码长度为6-16位！', $_SERVER['HTTP_REFERER']);
                    exit;
                }
                if ($data['password'] != $data['repassword']) {
                    $this->errorTip('两次输入密码不一致！', $_SERVER['HTTP_REFERER']);
                    exit;
                }
                $data['salt'] = mt_rand(111111, 999999);
                $data['password'] = md5(md5($data['password'] . '_' . $data['salt']) . $data['salt']);
                unset($data['repassword']);
                unset($data['checkbox']);
            }  else {
                unset($data['password']);
                unset($data['repassword']);
            }
            if (!$data['phone']) {
                $this->errorTip('手机号码不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!preg_match("/^1[34578]\d{9}$/", $data['phone'])) {
                $this->errorTip('手机号码格式不正确！', $_SERVER['HTTP_REFERER']);
                exit;
            }
//            if (!$data['commission']) {
//                $this->errorTip('佣金不能为空！', $_SERVER['HTTP_REFERER']);
//               exit;
//           }
//            if (!$data['alicommission']) {
//                $this->errorTip('一清支付宝佣金不能为空！', $_SERVER['HTTP_REFERER']);
//                exit;
//            }
//            if (!$data['ancommission']) {
//                $this->errorTip('二清微信佣金不能为空！', $_SERVER['HTTP_REFERER']);
//                exit;
//            }
//            if (!$data['analicommission']) {
//                $this->errorTip('二清支付宝佣金不能为空！', $_SERVER['HTTP_REFERER']);
//                exit;
//            }
            if (!$data['contacts']) {
                $this->errorTip('联系人不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (!$data['corporate']) {
                $this->errorTip('公司名称不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if ($data['mtype0']&&((!$data['commission'])or(!$data['alicommission']))) {
                $this->errorTip('请选择特约商户对应费率', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if ($data['mtype1']&&((!$data['ancommission'])or(!$data['analicommission']))) {
                $this->errorTip('请选择银行直连对应费率', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if ($data['mtype2']&&((!$data['wxcommission'])or(!$data['qqcommission']))) {
                $this->errorTip('请选择金海哲对应费率', $_SERVER['HTTP_REFERER']);
                exit;
            }
            if (isset($data['mtype0'])==false&&isset($data['mtype1'])==false&&isset($data['mtype2'])==false) {
                $this->errorTip('商户类型不能为空！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            
//             //把商户类型相加  如果等于三  商户类型都有
//             if (isset($data['mtype'][0]) && isset($data['mtype'][1])) {
//                 $mtype =array_sum($data['mtype']);
//                 unset($data['mtype']);
//             }else{
//                 $mtype = $data['mtype'][0];
//                 unset($data['mtype']);
//             }
//             $data['mtype']=$mtype;
// //            判断商户类型 如果等于1 就把 银行直连的费率清0
//             if ($data['mtype']==1) {
// //                银行直连 清空
//                 $data['analicommission']=0;
//                 $data['ancommission']=0;
//             }
//             if ($data['mtype']==2){
//  //                特约 清空
//                 $data['alicommission']=0;
//                 $data['commission']=0;
//             }
            if(!$data['mtype0'])
            {
                $data['alicommission']=0;
                $data['commission']=0;
            }
            if(!$data['mtype1'])
            {
                $data['analicommission']=0;
                $data['ancommission']=0;
            }
            if(!$data['mtype2'])
            {
                $data['qqcommission']=0;
                $data['wxcommission']=0;
            }
//             var_dump($data);die;
            $data['mtype']=$data['mtype0']+$data['mtype1']+$data['mtype2'];
            unset($data['mtype0']);unset($data['mtype1']);unset($data['mtype2']);
            $data['commission']=$data['commission']/100;
            $data['alicommission']=$data['alicommission']/100;
            $data['ancommission']=$data['ancommission']/100;
            $data['analicommission']=$data['analicommission']/100;
            $data['qqcommission']=$data['qqcommission']/100;
            $data['wxcommission']=$data['wxcommission']/100;
             if (M('cashier_agent')->update($data, 'aid='.$data['aid'])) {
                 $this->successTip('修改成功！',"/merchants.php?m=System&c=agent&a=index");
                 exit;
             } else {
                 $this->errorTip('修改失败！', $_SERVER['HTTP_REFERER']);
                 exit;
             }
           
        }  else {
            $aid = isset($_GET['aid']) ? intval($_GET['aid']) : 0;
            $row = $this->model->get_one('aid='.$aid);
            $districts = M('cashier_district')->select(array('fid' => '0'), '*', '', 'id ASC');//查出地址信息
            $teWx=M('cashier_wxrebate')->select(['id'=>1],'rebate');//查出特约商户 微信结算费率
            $teAli=M('cashier_wxrebate')->select(['id'=>2],'rebate');//查出特约商户 支付宝结算费率
            $yinWx=M('cashier_wxrebate')->select(['id'=>3],'rebate');//查出银行直连 微信结算费率
            $yinAli=M('cashier_wxrebate')->select(['id'=>4],'rebate');//查出银行直连 支付宝结算费率
            $jhzwxs=M('cashier_wxrebate')->select(['id'=>9],'rebate');//查出金海哲微信结算费率
            $jhzqqs=M('cashier_wxrebate')->select(['id'=>10],'rebate');//查出金海哲qq结算费率
            $teWx = explode(",",$teWx[0]['rebate']);
            $teAli = explode(",",$teAli[0]['rebate']);
            $yinWx = explode(",",$yinWx[0]['rebate']);
            $yinAli = explode(",",$yinAli[0]['rebate']);
            $jhzwxs = explode(",",$jhzwxs[0]['rebate']);
            $jhzqqs = explode(",",$jhzqqs[0]['rebate']);
            $this->assign('teWx',$teWx);
            $this->assign('teAli',$teAli);
            $this->assign('yinWx',$yinWx);
            $this->assign('yinAli',$yinAli);
            $this->assign('jhzwxs',$jhzwxs);
            $this->assign('jhzqqs',$jhzqqs);

            $this->assign("districts", $districts);
            $this->assign("row",$row);
            $this->display();    
        }
        
    }
    
    /**
     * 删除代理商
     */
     public function agentdel() {

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
       
        $agent = M('cashier_agent')->get_one(array('aid' => $id));
        if (empty($agent)){
            $this->dexit(array('errcode' => 0, 'errmsg' => '代理商不存在!'));
        }
        if (M('cashier_agent')->delete(array('aid' => $id))) {
             $this->dexit(array('errcode' => 1, 'errmsg' => '删除成功'));
        }  else {
            $this->dexit(array('errcode' => 0, 'errmsg' => '删除失败'));
        }
       
    }
    /*     * ******获取城市或区域信息******* */
    //判断是否有第三级
    public function Getdir($fid) {

      $districts = M('cashier_district')->select(array('fid' => $fid), '*', '', 'id ASC');
      if ($districts){
          return true;
      }else{
          return false;
      }
    }
    
    public function GetDistrict() {
        $districtid = isset($_POST['districtid']) ? trim($_POST['districtid']) : 0;
        if ($districtid > 0) {
            $districts = M('cashier_district')->select(array('fid' => $districtid), '*', '', 'id ASC');
            $this->dexit(array('error' => 0, 'data' => !empty($districts) ? $districts : ''));
        }
        $this->dexit(array('error' => 1, 'data' => ''));
    }

    /*     * ******获取子目录信息******* */

    public function GetCategory() {
        $cid = isset($_POST['cid']) ? trim($_POST['cid']) : 0;
        if ($cid > 0) {
            $categorys = M('cashier_category')->select(array('fid' => $cid, 'is_hide' => '0'), '*', '', 'id ASC');
            $this->dexit(array('error' => 0, 'data' => !empty($categorys) ? $categorys : ''));
        }
        $this->dexit(array('error' => 1, 'data' => ''));
    }
    
    
    //查询银行卡信息
	public function getAgentBank()
	{
            $aid = intval($_POST['aidd']);
            if (0 < $aid) {
                    $tmpbank = M('cashier_agent')->get_one(array('aid' => $aid), 'bankcard,idcard');
                    
                    if (!empty($tmpbank['bankcard']) && !empty($tmpbank['idcard']) && is_array($tmpbank)) {
                        $tmpbank['bankcard'] = json_decode($tmpbank['bankcard'],true);
                        $tmpbank['idcard'] = json_decode($tmpbank['idcard'],true);
                        $this->dexit(array('error' => 0, 'msg' => '', 'data' => $tmpbank));
                    }
            }
            $this->dexit(array('error' => 1, 'msg' => ''));
	}

}

?>