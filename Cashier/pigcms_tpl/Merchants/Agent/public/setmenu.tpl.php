<nav role="navigation" class="navbar-default navbar-static-side">
        <div class="sidebar-collapse">
            <ul id="side-menu" class="nav metismenu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
					   <?php if(!empty($this->agent['logo'])){?>
                            <img src="<?php echo $this->agent['logo'];?>" class="img-circle" alt="image" height="70px" width="70px">
							<?php }elseif(defined('RESOURCEURL')){?>
							  <img src="<?php echo RESOURCEURL;?>/pigcms_tpl/Agent/Static/images/profile_small.jpg" class="img-circle" alt="image">
							<?php }elseif(defined('ABS_UPLOAD_PATH')){ ?>
							  <img src=".<?php echo ABS_UPLOAD_PATH;?>/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
							<?php }else{?>
								<img src="./pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" style="width: 45px;height: 45px;">
							<?php }?>
                             </span>
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">
	 						<?php if(!empty($this->agent['uname'])){ echo $this->agent['uname'];}?></strong>
                             </span> <span class="text-muted text-xs block">
							 <?php if(!empty($this->Salesman) && isset($this->Salesman['account'])){
							     $tmpname=!empty($this->Salesman['username']) ? $this->Salesman['username'] :$this->Salesman['account'];
								 echo $tmpname;
							 }else{
							   		echo 'My cashier';
							 }?>
							 </span></span> 
						</a>
                 
                    </div>
					<div class="logo-element" style="text-align: center;">
					<?php if(!empty($this->agent['logo'])){?>
                            <img src="<?php echo $this->agent['logo'];?>" class="img-circle" style="width: 45px;height: 45px;">
							<?php }elseif(defined('RESOURCEURL')){?>
							  <img src="<?php echo RESOURCEURL;?>/pigcms_tpl/Agent/Static/images/profile_small.jpg" class="img-circle" alt="image">
							<?php }elseif(defined('ABS_UPLOAD_PATH')){ ?>
							  <img src=".<?php echo ABS_UPLOAD_PATH;?>/pigcms_tpl/Agent/Static/images/profile_small.jpg" class="img-circle" alt="image">
							<?php }else{?>
								<img src="./pigcms_tpl/Agent/Static/images/profile_small.jpg" class="img-circle" style="width: 45px;height: 45px;">
							<?php }?>
					</div>
                </li>

<!-- 业务员 -->
<?php if ( isset($this->Salesman) && !empty($this->Salesman['account']) ) { ?> 
				<li <?php if(ROUTE_CONTROL=='index' && ROUTE_ACTION=='index') echo 'class="active"';?>>
                    <a href="/merchants.php?m=Agent&c=index&a=index"><i class="fa fa-home"></i> <span class="nav-label">首页</span><span class="label label-info pull-right"></span></a>
                </li>

				<li <?php if(ROUTE_CONTROL=='statistics') echo 'class="active"';?>>
                    <a href="/merchants.php?m=agent&c=statistics&a=forSaler"><i class="fa fa-gears"></i> <span class="nav-label">商户统计</span><span class="label label-info pull-right">NEW</span></a>
                </li>

				<li <?php if(ROUTE_CONTROL=='merchants') echo 'class="active"';?>>
                    <a href="/merchants.php?m=agent&c=merchant&a=merchantList"><i class="fa fa-wrench"></i> <span class="nav-label">商户列表</span><span class="label label-info pull-right">NEW</span></a>
                </li>
				<li <?php if(ROUTE_CONTROL=='settlement') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">结算中心</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='salesman') echo 'in';?>">
					    <li <?php if(ROUTE_CONTROL=='settlement' && ROUTE_ACTION=='index' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=agent&c=settlement&a=forMe">我的结束</a></li>
					     <li <?php if(ROUTE_CONTROL=='settlement' && ROUTE_ACTION=='forMerchant' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=agent&c=settlement&a=myMerchant">商户结算</a></li>
                    </ul>
                </li>
                <li <?php if(ROUTE_CONTROL=='modify') echo 'class="active"';?>>
                    <a href="/merchants.php?m=agent&c=modify&a=setinfo"><i class="fa fa-wechat"></i> <span class="nav-label">设置</span><span class="label label-info pull-right">NEW</span></a>
                </li>				
<!-- 代理商 -->				
<?php }else{ ?>
				<li <?php if(ROUTE_CONTROL=='index' && ROUTE_ACTION=='index') echo 'class="active"';?>>
                    <a href="/merchants.php?m=Agent&c=index&a=index"><i class="fa fa-home"></i> <span class="nav-label">首页</span><span class="label label-info pull-right"></span></a>
                </li>

				<li <?php if(ROUTE_CONTROL=='agent') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">统计管理</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='agent') echo 'in';?>">

                        <li <?php if(ROUTE_CONTROL=='statistics' && ROUTE_ACTION=='forSalesman') echo 'class="active"';?>><a href="/merchants.php?m=agent&c=statistics&a=forSalesman">业务员统计</a></li>
						<li <?php if(ROUTE_CONTROL=='agent' && ROUTE_ACTION=='forMerchants') echo 'class="active"';?>><a href="/merchants.php?m=agent&c=statistics&a=forMerchants">商户统计</a></li>
                    </ul>
                </li>

				<li <?php if(ROUTE_CONTROL=='manchant') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-wrench"></i> <span class="nav-label">商户中心</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='manchant') echo 'in';?>">
						<li <?php if(ROUTE_CONTROL=='merchants' && ROUTE_ACTION=='index') echo 'class="active"';?>><a href="/merchants.php?m=agent&c=merchant&a=index">商户列表</a></li>
                    </ul>
                </li>
	
				<li <?php if(ROUTE_CONTROL=='salesman') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">业务员中心</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='salesman') echo 'in';?>">
					    <li <?php if(ROUTE_CONTROL=='salesman' && ROUTE_ACTION=='index' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=agent&c=salesman&a=index">业务员列表</a></li>
                    </ul>
                </li>
                <li <?php if(ROUTE_CONTROL=='cashier') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-wechat"></i> <span class="nav-label">结算中心</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='cashier') echo 'in';?>">
					    <li <?php if(ROUTE_CONTROL=='settlement' && ROUTE_ACTION=='index' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=agent&c=settlement&a=index&type=1">我的结束</a></li>
					    <li <?php if(ROUTE_CONTROL=='settlement' && ROUTE_ACTION=='forSaler' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=agent&c=settlement&a=forSaler&type=1">业务员结算</a></li>
					     <li <?php if(ROUTE_CONTROL=='settlement' && ROUTE_ACTION=='forMerchant' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=agent&c=settlement&a=forMerchant&type=1">商户结算</a></li>
                    </ul>
                </li>
<?php } ?>                
            </ul>
        </div>
    </nav>