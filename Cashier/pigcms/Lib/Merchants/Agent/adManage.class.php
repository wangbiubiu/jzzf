<?php
bpBase::loadAppClass('common', 'Agent', 0);
bpBase::loadOrg('common_page');

class adManage_controller extends common_controller{
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 广告列表
     */
    public function adlist()
    {
        //显示此代理下的所有广告
        $obj=new model();
        $aid=$_SESSION['my_Cashier_Agent']['aid'];
        $sql="select * from cqcjcm_cashier_adlist as a join cqcjcm_cashier_merchants as b where a.ad_mid=b.mid and a.ad_aid={$aid}";
        $result=$obj->selectBySql($sql);
        //显示视图
        include $this->showTpl();
    }

    /*
     * 搜索此代理下的广告
     */
    public function search()
    {
        $data=$_POST['data'];
        $obj=new model();
        $aid=$_SESSION['my_Cashier_Agent']['aid'];
        $sql="select * from cqcjcm_cashier_adlist as a join cqcjcm_cashier_merchants as b where a.ad_mid=b.mid and a.ad_aid={$aid} and company like '%{$data}%'";
        $result=$obj->selectBySql($sql);
        //显示视图
        include $this->showTpl('adlist');
    }

    /*
     * 删除广告
     */
    public function del()
    {
        $result=M('cashier_adlist')->delete(array('ad_id'=>$_POST['id']));
        if($result){
            return $this->dexit(array('error'=>'0'));
        }
        else{
            return $this->dexit(array('error'=>'1'));
        }
    }
    /*
     * 添加广告
     */
    public function addAd()
    {
        //代理商ID
        $aid=$_SESSION['my_Cashier_Agent']['aid'];
        //查询代理商名下所有商户
        $shanghu=M('cashier_merchants')->select(array('aid'=>$aid),'company,mid');
        //查出地址信息
        $districts = M('cashier_district')->select(array('fid' => '0'), '*', '', 'id ASC');
        //查询经营行业
        $category = M("cashier_wechat_category")-> select("id>0");
        //广告提交
        if(IS_POST){

            //变量赋值
            $data['ad_mid']=$_POST['shanghu'];
            $data['ad_aid']=$aid;
            $data['ad_shenaddress']=$_POST['shenaddress'];
            $data['ad_shiaddress']=$_POST['shiaddress'];
            $data['ad_quaddress']=$_POST['quaddress'];
            $data['ad_hangye']=$_POST['categoryId'];
            $data['ad_tfstarttime']=$_POST['startTime'];
            $data['ad_tfendtime']=$_POST['endTime'];
            $data['ad_sxstarttime']=$_POST['startTime1'];
            $data['ad_sxendtime']=$_POST['endTime1'];
            $data['img1']=$_POST['file1'];
            $data['img2']=$_POST['file2'];
            $data['link1']=$_POST['link1'];
            $data['link2']=$_POST['link2'];
            //开始上传广告数据
            $result=M('cashier_adlist')->insert($data);
            $this->successTip('广告添加成功', '?m=Agent&c=adManage&a=adlist');

        }

        //显示视图
        include $this->showTpl();
    }

    /*
     * 上传图片
     */
    public function uploadImg()
    {
        if (!empty($_FILES)) {
            $return = $this->oldUploadFile('png');
            if ($return['error'] > 0) {
                $this->dexit(array('error' => 1, 'msg' => $return['data']));
            } else {
                $filesinfo = $return['data']['0'];
                $this->dexit(array('error' => 0, 'msg' => 'OK', 'fileUrl' => $return['imgurl'] . $filesinfo['savename'], 'originalfilename' => $filesinfo['name'], 'fileSize' => $filesinfo['size']));
            }
        }
    }
    /*
     * 更新广告
     */
    public function updateAd()
    {

        if(IS_POST){
            //代理商ID
            $aid=$_SESSION['my_Cashier_Agent']['aid'];
            //变量赋值
            $data['ad_mid']=$_POST['shanghu'];
            $data['ad_shenaddress']=$_POST['shenaddress'];
            $data['ad_shiaddress']=$_POST['shiaddress'];
            $data['ad_quaddress']=$_POST['quaddress'];
            $data['ad_hangye']=$_POST['categoryId'];
            $data['ad_tfstarttime']=$_POST['startTime'];
            $data['ad_tfendtime']=$_POST['endTime'];
            $data['ad_sxstarttime']=$_POST['startTime1'];
            $data['ad_sxendtime']=$_POST['endTime1'];
            $data['img1']=$_POST['file1'];
            $data['img2']=$_POST['file2'];
            $data['link1']=$_POST['link1'];
            $data['link2']=$_POST['link2'];

            //开始更新广告数据
            $result=M('cashier_adlist')->update($data,array('ad_id'=>$_POST['adid'],'ad_aid'=>$aid));
            $this->successTip('广告更新成功', '?m=Agent&c=adManage&a=adlist');
        }
        else{

            //广告信息
            $obj=new model();
            $sql="select * from cqcjcm_cashier_adlist as a join cqcjcm_cashier_merchants as b where a.ad_mid=b.mid and a.ad_id={$_GET['id']}";
            $result=$obj->selectBySql($sql);
            //查出地址信息
            $districts = M('cashier_district')->select(array('fid' => '0'), '*', '', 'id ASC');
            $cityfid=M('cashier_district')->select(array('fullname'=>$result[0]['ad_shenaddress']));
            $qufid=M('cashier_district')->select(array('fullname'=>$result[0]['ad_shiaddress']));
            //市
            $districts_city = M('cashier_district')->select(array('fid' => $cityfid[0]['id']), '*', '', 'id ASC');
            //区
            $districts_area=M('cashier_district')->select(array('fid' => $qufid[0]['id']), '*', '', 'id ASC');
            //查询经营行业
            $category = M("cashier_wechat_category")-> select("id>0");
            //显示视图
            include $this->showTpl();
        }


    }
}