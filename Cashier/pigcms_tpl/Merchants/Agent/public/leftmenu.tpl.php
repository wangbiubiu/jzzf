<nav role="navigation" class="navbar-default navbar-static-side">
        <div class="sidebar-collapse">
            <ul id="side-menu" class="nav metismenu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> 
                    <span>

                <?php if (!empty($this->agents['logo'])) { ?>
                    <img src="<?php echo $this->agents['logo'];?>" class="img-circle" alt="image" height="70px" width="70px">
                <?php } else{ ?>
                    <img src="http://cashier.b0.upaiyun.com/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image" height="70px" width="70px">
                <?php } ?> 
                </span>

                
                   
                        <a href="javascript:;" class="dropdown-toggle">
                        <span class="block m-t-xs" >
                             <strong class="font-bold">
                            <?php if(!empty($this->agents['uname'])): ?>
                            <?php echo $this->agents['uname']; ?>
                            <?php else: echo$this->agents['account'] ?>
                            <?php endif ?>	
	 						</strong>
                        </span> 
                        </a> 

                    </div>
					
                </li>

				<li <?php if(ROUTE_CONTROL=='index' && ROUTE_ACTION=='index') echo 'class="active"';?>>
                    <a href="?m=Agent&c=index&a=index"><i class="fa fa-home"></i> <span class="nav-label">首页</span><span class="label label-info pull-right"></span></a>
                </li>
				
				<li <?php if(ROUTE_CONTROL=='statistics' ) echo 'class="active"';?>>

                    <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">统计管理</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='statistics') echo 'in';?>">

                        <li <?php if(ROUTE_CONTROL=='statistics' && ROUTE_ACTION=='forSalesman') echo 'class="active"';?>><a href="/merchants.php?m=Agent&c=statistics&a=forSalesman">业务员统计</a></li>
						<li <?php if(ROUTE_CONTROL=='statistics' && ROUTE_ACTION=='forMerchants') echo 'class="active"';?>><a href="/merchants.php?m=Agent&c=statistics&a=forMerchants">商户统计</a></li>
                    </ul>
                </li>

				<li <?php if(ROUTE_CONTROL=='merchant') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-wrench"></i> <span class="nav-label">商户中心</span></a>

                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='manchant') echo 'in';?>">

						<li <?php if(ROUTE_CONTROL=='merchant' && ROUTE_ACTION=='index') echo 'class="active"';?>><a href="/merchants.php?m=Agent&c=merchant&a=index">商户列表</a></li>
                    </ul>
                </li>
	
				<li <?php if(ROUTE_CONTROL=='salesman') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">业务员中心</span></a>

                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='salesman') echo 'in';?>">

					    <li <?php if(ROUTE_CONTROL=='salesman' && ROUTE_ACTION=='index' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=Agent&c=salesman&a=index">业务员列表</a></li>
                        
                    </ul>
                </li>

                <li <?php if(ROUTE_CONTROL=='settlement') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-wechat"></i> <span class="nav-label">结算中心</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='cashier') echo 'in';?>">
					    <li <?php if(ROUTE_CONTROL=='settlement' && ROUTE_ACTION=='index' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=Agent&c=settlement&a=index&type=1">我的结算</a></li>
					    <li <?php if(ROUTE_CONTROL=='settlement' && ROUTE_ACTION=='forSaler' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=Agent&c=settlement&a=yourInfo&aid=<?php echo $this->aid;?>">我的银行卡</a></li>
                        <li <?php if(ROUTE_CONTROL=='settlement' && ROUTE_ACTION=='forSaler' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=Agent&c=settlement&a=forSaler&type=1">业务员结算</a></li>
                    </ul>
                </li>

                </li>                          
            </ul>
        </div>
    </nav>