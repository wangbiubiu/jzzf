<nav role="navigation" class="navbar-default navbar-static-side">
        <div class="sidebar-collapse">
            <ul id="side-menu" class="nav metismenu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>



					       <?php if(!empty($this->salesmans['logo'])){?>
                                <img src="<?php echo $this->salesmans['logo'];?>" class="img-circle" alt="image" height="70px" width="70px">
							<?php }else{?>
							     <img src="http://cashier.b0.upaiyun.com/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
							<?php } ?>
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="clear"> <span class="block m-t-xs"></span> 
                            <span class="text-muted text-xs block">
                           
							 <?php if(!empty($this->salesmans) && isset($this->salesmans['account'])){
							     $tmpname=!empty($this->salesmans['username']) ? $this->salesmans['username'] : $this->salesmans['account'];
								 echo $tmpname;
							 }else{
							   		echo 'My cashier';
							 }?>
							 </span>
						</a>
                 
                    </div>
					
                </li>

<!-- 业务员 -->
				<li <?php if(ROUTE_CONTROL=='index' && ROUTE_ACTION=='index') echo 'class="active"';?>>
                    <a href="/merchants.php?m=Salesman&c=index&a=index"><i class="fa fa-home"></i> <span class="nav-label">首页</span><span class="label label-info pull-right"></span></a>
                </li>

				<li <?php if(ROUTE_CONTROL=='statistics') echo 'class="active"';?>>
                    <a href="/merchants.php?m=Salesman&c=statistics&a=forSaler"><i class="fa fa-gears"></i> <span class="nav-label">商户统计</span></a>
                </li>

				<li <?php if(ROUTE_CONTROL=='merchant') echo 'class="active"';?>>
                    <a href="/merchants.php?m=Salesman&c=merchant&a=merchantList"><i class="fa fa-wrench"></i> <span class="nav-label">商户列表</span></a>
                </li>
				<li <?php if(ROUTE_CONTROL=='settlement') echo 'class="active"';?>>
                    <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">结算中心</span></a>
                    <ul class="nav nav-second-level collapse <?php if(ROUTE_CONTROL=='salesman') echo 'in';?>">
					    <li <?php if(ROUTE_CONTROL=='settlement' && ROUTE_ACTION=='index' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=Salesman&c=settlement&a=SalesmanForMe">我的结算</a></li>
                        <li <?php if(ROUTE_CONTROL=='settlement' && ROUTE_ACTION=='yourInfo' && $type==1) echo 'class="active"';?>><a href="/merchants.php?m=Salesman&c=settlement&a=yourInfo">我的银行卡</a></li>
					    
                    </ul>
                </li>
            </ul>
        </div>
    </nav>