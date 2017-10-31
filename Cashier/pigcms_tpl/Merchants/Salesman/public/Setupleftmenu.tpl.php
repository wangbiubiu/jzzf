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
                             </span>
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
				
                
				<li <?php if(ROUTE_CONTROL=='pay') echo 'class="active"';?>>
                    <a href="/merchants.php?m=Salesman&c=pay&a=SetAccount"><i class="fa fa-gears"></i> <span class="nav-label">账户设置</span></a>
                </li>

				<li <?php if(ROUTE_CONTROL=='pfpay') echo 'class="active"';?>>
                    <a href="/merchants.php?m=Salesman&c=pfpay&a=security"><i class="fa fa-wrench"></i> <span class="nav-label">安全设置</span></a>
                </li>
				
                <!-- 
                <li <?php if(ROUTE_CONTROL=='modify') echo 'class="active"';?>>
                    <a href="/merchants.php?m=Salesman&c=modify&a=setinfo"><i class="fa fa-wechat"></i> <span class="nav-label">设置</span></a>
                </li>   
                 -->           
            </ul>
        </div>
    </nav>