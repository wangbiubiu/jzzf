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
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php if (!empty($this->merchant['company'])) {
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
           
            
            <!-- 从这里开始判断 是商户端 还是员工端  -->
            <?php if (!($this->eid > 0)) { ?>
               
                 <?php if($this->merchant['mtype'] == '1'){?>
                 <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'payconfig') echo 'class="active"'; ?>>
                     <a href="/merchants.php?m=User&c=pay&a=payconfig"> <span class="nav-label">支付设置</span><span class="label label-info pull-right"></span></a>
                 </li>
                 <?php }?>
                 <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'ModifyPwd') echo 'class="active"'; ?>>
                     <a href="/merchants.php?m=User&c=pay&a=ModifyPwd"> <span class="nav-label">账户设置</span><span class="label label-info pull-right"></span></a>
                 </li>
                 <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'printset') echo 'class="active"'; ?>>
                     <a href="/merchants.php?m=User&c=pay&a=printset"> <span class="nav-label">硬件设置</span><span class="label label-info pull-right"></span></a>
                 </li>
                 
                 <?php if($this->merchant['mtype'] == '1'){?>
                     <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'go2Regeist' ||  ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'showReg' || ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'regMerchantInfo' || ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'examine') echo 'class="active"'; ?>>
                        <a href="/merchants.php?m=User&c=pay&a=go2Regeist"> <span class="nav-label">进件管理</span><span class="label label-info pull-right"></span></a>
                     </li>
                 <?php }else if($this->merchant['mtype'] == '2'){?>
                     <!--<li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'bank') echo 'class="active"'; ?>>
                        <a href="/merchants.php?m=User&c=pay&a=bank"> <span class="nav-label">银行卡管理</span><span class="label label-info pull-right"></span></a>
                     </li>-->
                 <?php }?>
                 
                

            <?php }else{?>
                  <?php if ( $_SESSION['E_LEVEL']  == 1 ) { ?>
                 <li <?php if (ROUTE_CONTROL == 'modify' && ROUTE_ACTION == 'setPwd') echo 'class="active"'; ?>>
                     <a href="/merchants.php?m=User&c=modify&a=setPwd"> <span class="nav-label">账户设置</span><span class="label label-info pull-right"></span></a>
                 </li>
                 <?php if(!isset($this->employer) && $this->employer['level'] != '1'){?>
                     <li <?php if (ROUTE_CONTROL == 'modify' && ROUTE_ACTION == 'setElo') echo 'class="active"'; ?>>
                         <a href="/merchants.php?m=User&c=modify&a=setElo"> <span class="nav-label">店员设置</span><span class="label label-info pull-right"></span></a>
                     </li>
                     <li <?php if (ROUTE_CONTROL == 'modify' && ROUTE_ACTION == 'setConf') echo 'class="active"'; ?>>
                         <a href="/merchants.php?m=User&c=modify&a=setConf"> <span class="nav-label">配置设置</span><span class="label label-info pull-right"></span></a>
                     </li>
                 <?php }?>
                  <?php } ?>
            <?php }?>
        </ul>

    </div>
</nav>