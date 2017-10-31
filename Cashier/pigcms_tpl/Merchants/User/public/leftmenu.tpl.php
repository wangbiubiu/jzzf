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
                    
                 <li <?php if (ROUTE_CONTROL == 'index' && ROUTE_ACTION == 'sindex') echo 'class="active"'; ?>>
                     <a href="/merchants.php?m=User&c=index&a=sindex"><i class="fa fa-home"></i> <span class="nav-label">首页</span><span class="label label-info pull-right"></span></a>
                 </li>
                <li <?php if (ROUTE_CONTROL == 'count') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-line-chart"></i> <span class="nav-label">商户统计</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'count') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'count' && ROUTE_ACTION == 'index') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=count&a=index">商户统计</a></li>
                        <li <?php if (ROUTE_CONTROL == 'count' && ROUTE_ACTION == 'store') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=count&a=store">门店统计</a></li>
                    </ul> 
                </li>
                <li <?php if (ROUTE_CONTROL == 'merchant' && ROUTE_ACTION == 'storefront') echo 'class="active"'; ?>>
                    <a href="/merchants.php?m=User&c=merchant&a=storefront"><i class="fa fa-gears"></i> <span class="nav-label">门店管理</span><span class="label label-info pull-right">NEW</span></a>
                </li>
                <?php if ($this->merchant['mtype']!=1){ ?>
                <li <?php if (ROUTE_CONTROL == 'settlement') echo 'class="active"'; ?>>
                    <a href=""><i class="fa fa-line-chart"></i> <span class="nav-label">结算管理</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'count') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'settlement' && ROUTE_ACTION == 'index') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=settlement&a=index">我的结算</a></li>
                        <li <?php if (ROUTE_CONTROL == 'settlement' && ROUTE_ACTION == 'bank') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=settlement&a=banklist">银行卡设置</a></li>
                        <?php $mid=current($_SESSION['my_Cashier_Merchant']);$data=M('cashier_merchants')->get_one(array('mid'=>$mid));$mtype=$data['mtype'];if($mtype==3){?>
                        <li><a href="/merchants.php?m=User&c=settlement&a=addorder">用户申请提现</a></li><?php }?>
                    </ul>
                </li>
                    <?php }?>
<!--                <li --><?php //if (ROUTE_CONTROL == 'merchant' && ROUTE_ACTION == 'employers') echo 'class="active"'; ?><!-->
<!--                    <a href="/merchants.php?m=User&c=merchant&a=employers"><i class="glyphicon glyphicon-home"></i> <span class="nav-label">物业缴费</span><span class="label label-info pull-right">NEW</span></a>-->
<!--                </li>-->
<!--               <li <?php if (ROUTE_CONTROL == 'wxCoupon') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-money"></i> <span class="nav-label">卡卷管理</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'wxCoupon') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'wxCoupon' && ROUTE_ACTION == 'index') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=wxCoupon&a=index">卡卷列表</a></li>
                        <li <?php if (ROUTE_CONTROL == 'wxCoupon' && ROUTE_ACTION == 'consumeCard') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=wxCoupon&a=consumeCard">核销卡卷</a></li>
                    </ul>
                </li>-->
<!--                <li <?php if (ROUTE_CONTROL == 'pay') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-wrench"></i> <span class="nav-label">账户设置</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'pay') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'config') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=pay&a=config">支付设置</a></li>
                        <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'ModifyPwd') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=pay&a=ModifyPwd">修改密码</a></li>
                        <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'printset') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=pay&a=printset">硬件设置</a></li>                        
                    </ul>
                </li>-->
                
                
   <!--         
                <li <?php if (ROUTE_CONTROL == 'merchant') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">商家设置</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'merchant') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'merchant' && ROUTE_ACTION == 'employers') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=merchant&a=employers">员工管理</a></li>
                        <li <?php if (ROUTE_CONTROL == 'merchant' && ROUTE_ACTION == 'storefront') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=merchant&a=storefront">门店管理</a></li>
                         <?php if ($this->merchant['thirduserid']) { ?>
                            <li <?php if (ROUTE_CONTROL == 'merchant' && (ROUTE_ACTION == 'menu' || ROUTE_ACTION == 'addmenu')) echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=merchant&a=menu">商家导航</a></li>
                         <?php } ?>
                    </ul>
                </li>
                <li <?php if (ROUTE_CONTROL == 'pay') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-wrench"></i> <span class="nav-label">配置设置</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'pay') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'config') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=pay&a=config">支付配置</a></li>
                        <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'printset') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=pay&a=printset">打印配置</a></li>
                    </ul>
                </li>

       
                <li <?php if (ROUTE_CONTROL == 'cashier') echo 'class="active"'; ?>>
                     <a href="#"><i class="fa fa-wechat"></i> <span class="nav-label">微信收银台</span><span class="label label-info pull-right">NEW</span></a> 
                    <a href="#"><i class="fa  fa-ioxhost"></i> <span class="nav-label">收银台</span><span class="label label-info pull-right">NEW</span></a> 
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'cashier') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'cashier' && ROUTE_ACTION == 'payment' && $type == 1) echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=cashier&a=payment&type=1">扫码收银</a></li>
                        <li <?php if (ROUTE_CONTROL == 'cashier' && ROUTE_ACTION == 'payment' && $type == 2) echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=cashier&a=payment&type=2">扫码退款</a></li>
                         
                            <li <?php if (ROUTE_CONTROL == 'cashier' && ROUTE_ACTION == 'index') echo 'class="active"'; ?> id="cashier_index"><a href="/merchants.php?m=User&c=cashier&a=index">二维码收款</a></li>
                            <li <?php if (ROUTE_CONTROL == 'cashier' && ROUTE_ACTION == 'ewmRecord') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=cashier&a=ewmRecord">二维码记录</a></li>
                            <li <?php if (ROUTE_CONTROL == 'cashier' && (ROUTE_ACTION == 'payRecord' || ROUTE_ACTION == 'odetail')) echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=statistics&a=orderLists&cfr=0&pty=weixin">收款记录</a></li>
                         
                    </ul>
                </li>
                 
                <li <?php if (ROUTE_CONTROL == 'alicashier') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-laptop"></i> <span class="nav-label">支付宝收银台</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'alicashier') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'alicashier' && ROUTE_ACTION == 'alipayment' && $type == 1) echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=alicashier&a=alipayment&type=1">扫码收银</a></li>
                        <li <?php if (ROUTE_CONTROL == 'alicashier' && ROUTE_ACTION == 'alipayment' && $type == 2) echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=alicashier&a=alipayment&type=2">扫码退款</a></li>
                        <li <?php if (ROUTE_CONTROL == 'alicashier' && ROUTE_ACTION == 'index') echo 'class="active"'; ?> id="alicashier_index"><a href="/merchants.php?m=User&c=alicashier&a=index">二维码收款</a></li>
                        <li <?php if (ROUTE_CONTROL == 'alicashier' && ROUTE_ACTION == 'ewmRecord') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=alicashier&a=ewmRecord">二维码记录</a></li>
                        <li <?php if (ROUTE_CONTROL == 'alicashier' && (ROUTE_ACTION == 'payRecord' || ROUTE_ACTION == 'odetail')) echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=statistics&a=orderLists&cfr=0&pty=alipay">收款记录</a></li>
                    </ul>
                </li>
             
                <li <?php if (ROUTE_CONTROL == 'statistics') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-line-chart"></i> <span class="nav-label">数据统计</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'statistics') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'statistics' && ROUTE_ACTION == 'orderLists') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=statistics&a=orderLists">收款记录</a></li>
                        <li <?php if (ROUTE_CONTROL == 'statistics' && ROUTE_ACTION == 'index') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=statistics&a=index">商家收支</a></li>
                        <li <?php if (ROUTE_CONTROL == 'statistics' && ROUTE_ACTION == 'otherpie') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=statistics&a=otherpie">概况统计</a></li>
                        <li <?php if (ROUTE_CONTROL == 'statistics' && ROUTE_ACTION == 'fans') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=statistics&a=fans">粉丝支付排行</a></li>
                    </ul>
                </li>
                <li <?php if (ROUTE_CONTROL == 'pfpay') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa  fa-ioxhost"></i> <span class="nav-label">平台对账</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'pfpay') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'pfpay' && ROUTE_ACTION == 'platformpay') echo 'class="active"'; ?> ><a href="/merchants.php?m=User&c=pfpay&a=platformpay">代收对账</a></li>

                        <li <?php if (ROUTE_CONTROL == 'pfpay' && ROUTE_ACTION == 'applyBalance') echo 'class="active"'; ?> ><a href="/merchants.php?m=User&c=pfpay&a=applyBalance">申请对账</a></li>

                        <li <?php if (ROUTE_CONTROL == 'pfpay' && ROUTE_ACTION == 'remittance') echo 'class="active"'; ?> ><a href="/merchants.php?m=User&c=pfpay&a=remittance">平台汇款</a></li>
                    </ul>

                </li>

                <li <?php if (ROUTE_CONTROL == 'memberLoc') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">本站会员管理</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'memberLoc') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'memberLoc' && ROUTE_ACTION != 'sycset') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=memberLoc&a=index">本站会员卡</a></li>
                        <li <?php if (ROUTE_CONTROL == 'memberLoc' && ROUTE_ACTION == 'sycset') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=memberLoc&a=sycset">积分同步</a></li>
                        <li><a href="/merchants.php?m=User&c=merchant&a=menu&cf=card">幻灯片设置</a></li>
                    </ul>
                </li>
                 
                <li <?php if (ROUTE_CONTROL == 'wxCoupon') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-money"></i> <span class="nav-label">微信卡券</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'wxCoupon') echo 'in'; ?>">
                        <li <?php if (ROUTE_CONTROL == 'wxCoupon' && ROUTE_ACTION == 'index') echo 'class="active"'; ?> id="wxCoupon_index"><a href="/merchants.php?m=User&c=wxCoupon&a=index">卡券管理</a></li>
                        <li <?php if (ROUTE_CONTROL == 'wxCoupon' && ROUTE_ACTION == 'consumeCard') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=wxCoupon&a=consumeCard">核销卡券</a></li>
                        <li <?php if (ROUTE_CONTROL == 'wxCoupon' && ROUTE_ACTION == 'wxReceiveList') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=wxCoupon&a=wxReceiveList">卡券消费列表</a></li>
                        <li <?php if (ROUTE_CONTROL == 'wxCoupon' && ROUTE_ACTION == 'cardindex') echo 'class="active"'; ?> id="wxCoupon_cardindex"><a href="/merchants.php?m=User&c=wxCoupon&a=cardindex">微信会员卡</a></li>
                        <li <?php if (ROUTE_CONTROL == 'wxCoupon' && ROUTE_ACTION == 'wxCardList') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=wxCoupon&a=wxCardList">会员信息</a></li>
                    </ul>
                </li>-->
<?php }else { ?>
    <!--					<li <?php if (ROUTE_CONTROL == 'pay') echo 'class="active"'; ?>>
                    <a href="#"><i class="fa fa-wrench"></i> <span class="nav-label">配置设置</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'pay') echo 'in'; ?>">
                                                <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'poskey') echo 'class="active"'; ?>><a href="/merchants.php?m=User&c=pay&a=poskey">POS机Key</a></li>
                    </ul>
                </li>-->
                
                 <li <?php if (ROUTE_CONTROL == 'index' && ROUTE_ACTION == 'index') echo 'class="active"'; ?>>
                  <a href="/merchants.php?m=User&c=index&a=index"> <span class="nav-label">首页</span><span class="label label-info pull-right"></span></a>
                </li>
<!-- 店长部分start -->

            <?php if ( $_SESSION['E_LEVEL'] == 1) { ?>

<!--                <li <?php if (ROUTE_CONTROL == 'Modify' && ROUTE_ACTION == 'setPwd') echo 'class="active"'; ?>>
                    <a href="/merchants.php?m=User&c=Modify&a=setPwd"> <span class="nav-label">账户设置</span><span class="label label-info pull-right"></span></a>
                </li>
                <li <?php if (ROUTE_CONTROL == 'Modify' && ROUTE_ACTION == 'setElo' ) echo 'class="active"'; ?>>
                    <a href="/merchants.php?m=User&c=Modify&a=setElo"> <span class="nav-label">店员设置</span><span class="label label-info pull-right"></span></a>
                </li>
                <li <?php if (ROUTE_CONTROL == 'Modify' && ROUTE_ACTION == 'setConf') echo 'class="active"'; ?>>
                    <a href="/merchants.php?m=User&c=Modify&a=setConf"> <span class="nav-label">配置设置</span><span class="label label-info pull-right"></span></a>
                </li>-->
            <?php } ?>
<!-- 店长部分end -->


                <li <?php if (ROUTE_CONTROL == 'cashier' && ROUTE_ACTION == 'payment' && $type == 1) echo 'class="active"'; ?>>
                    <a href="/merchants.php?m=User&c=cashier&a=payment&type=1"> <span class="nav-label">扫码收银</span><span class="label label-info pull-right"></span></a>
                </li>
                <li <?php if (ROUTE_CONTROL == 'cashier' && ROUTE_ACTION == 'payment' && $type == 2) echo 'class="active"'; ?>>
                    <a href="/merchants.php?m=User&c=cashier&a=payment&type=2"> <span class="nav-label">扫码退款</span><span class="label label-info pull-right"></span></a>
                </li>
                <li <?php if (ROUTE_CONTROL == 'cashier' && ROUTE_ACTION == 'index') echo 'class="active"'; ?>>
                    <a href="/merchants.php?m=User&c=cashier&a=index"> <span class="nav-label">二维码收款</span><span class="label label-info pull-right"></span></a>
                </li>
                <li <?php if (ROUTE_CONTROL == 'statistics' && ROUTE_ACTION == 'orderLists') echo 'class="active"'; ?>>
                    <a href="/merchants.php?m=User&c=statistics&a=orderLists"> <span class="nav-label">收款记录</span><span class="label label-info pull-right"></span></a>
                </li>
                <li <?php if (ROUTE_CONTROL == 'wxCoupon' && ROUTE_ACTION == 'consumeCard') echo 'class="active"'; ?>>
                    <a href="/merchants.php?m=User&c=wxCoupon&a=consumeCard"> <span class="nav-label">核销卡券</span><span class="label label-info pull-right"></span></a>
                </li>
<?php } ?>



            <?php if (!empty($this->merchant['thirduserid']) && ($this->merchant['source'] == 1) && !($this->eid > 0)) { ?>
                <li>
                    <a href="/merchants.php?m=User&c=index&a=goPigCms"><i class="fa fa-fast-backward"></i> <span class="nav-label">返回营销系统</span><span class="label label-info pull-right"></span></a>
                </li>
            <?php } ?>

<?php if (!($this->eid > 0)) { ?>
<!--                <li <?php if (ROUTE_CONTROL == 'index' && ROUTE_ACTION == 'ModifyPwd') echo 'class="active"'; ?>>
                    <a href="/merchants.php?m=User&c=index&a=ModifyPwd"><i class="fa fa-unlock-alt"></i> <span class="nav-label">修改密码</span><span class="label label-info pull-right"></span></a>
                </li>-->
<?php } ?>
        </ul>

    </div>
</nav>