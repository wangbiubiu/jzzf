<nav role="navigation" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse">
        <ul id="side-menu" class="nav metismenu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <?php if (!empty($this->merchant['logo'])) { ?>
                            <img src="<?php echo $this->merchant['logo']; ?>" class="img-circle" alt="image" height="70px" width="70px">
                        <?php } elseif (defined('RESOURCEURL')) { ?>
                            <img src="<?php echo RESOURCEURL; ?>/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
                        <?php } elseif (defined('ABS_UPLOAD_PATH')) { ?>
                            <img src=".<?php echo ABS_UPLOAD_PATH; ?>/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
                        <?php } else { ?>
                            <img src="./pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" style="width: 45px;height: 45px;">
                        <?php } ?>
                    </span>
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php if (!empty($this->merchant['wxname'])) {
                            echo $this->merchant['company'];
                        } else {
                            echo 'My Cashier';
                        } ?></strong>
                            </span> <span class="text-muted text-xs block">
                                <?php
                                if (!empty($this->employer) && isset($this->employer['account'])) {
                                    $tmpname = !empty($this->employer['username']) ? $this->employer['username'] : $this->employer['account'];
                                    echo $tmpname;
                                } else {
                                    echo $this->merchant['weixin'];
                                }
                                ?>

                                <!--<b class="caret"></b>--></span> </span> </a>
                    <!--<ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>-->
                </div>
                <div class="logo-element" style="text-align: center;">
                    <?php if (!empty($this->merchant['logo'])) { ?>
                        <img src="<?php echo $this->merchant['logo']; ?>" class="img-circle" style="width: 45px;height: 45px;">
                    <?php } elseif (defined('RESOURCEURL')) { ?>
                        <img src="<?php echo RESOURCEURL; ?>/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
                    <?php } elseif (defined('ABS_UPLOAD_PATH')) { ?>
                        <img src=".<?php echo ABS_UPLOAD_PATH; ?>/pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" alt="image">
                    <?php } else { ?>
                        <img src="./pigcms_tpl/Merchants/Static/images/profile_small.jpg" class="img-circle" style="width: 45px;height: 45px;">
                    <?php } ?>
                </div>
            </li>
           
                 <li <?php if (ROUTE_CONTROL == 'manager' && ROUTE_ACTION == 'index') echo 'class="active"'; ?>>
                     <a href="/merchants.php?m=User&c=manager&a=index"><i class="fa fa-home"></i> <span class="nav-label">首页</span><span class="label label-info pull-right"></span></a>
                 </li>
                <li <?php if (ROUTE_CONTROL == 'manager' && ROUTE_ACTION == 'ShopownerCount' || ROUTE_CONTROL == 'manager' && ROUTE_ACTION == 'CashierCount') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-line-chart"></i> <span class="nav-label">统计管理</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'manager' && ROUTE_ACTION == 'ShopownerCount' || ROUTE_CONTROL == 'manager' && ROUTE_ACTION == 'CashierCount') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'manager' && ROUTE_ACTION == 'ShopownerCount') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=manager&a=ShopownerCount">店长统计</a></li>
                        <li <?php if (ROUTE_CONTROL == 'manager' && ROUTE_ACTION == 'CashierCount') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=manager&a=CashierCount">收银员统计</a></li>
                    </ul> 
                </li>
                <li <?php if (ROUTE_CONTROL == 'manager' && ROUTE_ACTION == 'StaffManagement') echo 'class="active"'; ?>>
                     <a href="/merchants.php?m=User&c=manager&a=StaffManagement"><i class="fa fa-gears"></i> <span class="nav-label">收银员管理</span></a>
                </li>
               

        </ul>

    </div>
</nav>