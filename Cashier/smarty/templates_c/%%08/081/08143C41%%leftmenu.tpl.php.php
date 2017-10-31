<?php /* Smarty version 2.6.18, created on 2016-07-27 15:52:27
         compiled from D:%5Cxinban%5Cpay.haocangpin.net%5CCashier%5C./pigcms_tpl/Merchants/System/public/leftmenu.tpl.php */ ?>
<nav role="navigation" class="navbar-default navbar-static-side">
        <div class="sidebar-collapse">
            <ul id="side-menu" class="nav metismenu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
							<i class="fa fa-cogs" style="font-size:60px;color:#1ab394;"></i>
                         </span>
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $this->_tpl_vars['adminuser']['account']; ?>
</strong>
                             </span> <span class="text-muted text-xs block">收银台管理后台</span> </span> </a>
                    </div>
					<div class="logo-element" style="text-align: center;">
						<i class="fa fa-cogs" style="font-size:50px;color:#1ab394;"></i>
							
					</div>
                </li>
				<li <?php if (ROUTE_CONTROL == 'index' && ROUTE_ACTION != 'ModifyPwd'): ?> class="active" <?php endif; ?>>
					<a href="#"><i class="fa  fa-puzzle-piece"></i> <span class="nav-label">网站商家</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'index'): ?> in <?php endif; ?>">
                        <li <?php if (ROUTE_CONTROL == 'index' && ROUTE_ACTION == 'merLists'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=index&a=merLists">商家列表</a></li>
						<li <?php if (ROUTE_CONTROL == 'index' && ROUTE_ACTION == 'storeLists'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=index&a=storeLists">店铺列表</a></li>
                        <li <?php if (ROUTE_CONTROL == 'index' && ROUTE_ACTION == 'affiliate'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=index&a=affiliate">设置微信特约商户</a></li>
						<li <?php if (ROUTE_CONTROL == 'index' && ROUTE_ACTION == 'affiliatepay'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=index&a=affiliatepay">特约商户支付列表</a></li>
						<li <?php if (ROUTE_CONTROL == 'index' && ROUTE_ACTION == 'platformpay'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=index&a=platformpay">平台代支付列表</a></li>
                    </ul>

                </li>

				<li <?php if (ROUTE_CONTROL == 'pfpay'): ?> class="active" <?php endif; ?>>
					<a href="#"><i class="fa  fa-ioxhost"></i> <span class="nav-label">商户代收对账</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'pfpay'): ?> in <?php endif; ?>">

						<li <?php if (ROUTE_CONTROL == 'pfpay' && ROUTE_ACTION == 'applyMoney'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=pfpay&a=applyMoney">对账申请</a></li>

						<li <?php if (ROUTE_CONTROL == 'pfpay' && ROUTE_ACTION == 'pfmerLists'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=pfpay&a=pfmerLists">平台代收商家</a></li>
						<li <?php if (ROUTE_CONTROL == 'pfpay' && ROUTE_ACTION == 'platformpay'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=pfpay&a=platformpay">代收对账</a></li>
						<li <?php if (ROUTE_CONTROL == 'pfpay' && ROUTE_ACTION == 'remittance'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=pfpay&a=remittance">对账打款</a></li>
                    </ul>

                </li>
				<li <?php if (in_array ( ROUTE_CONTROL , array ( 'pay' , 'merchant' , 'sysconf' ) )): ?> class="active" <?php endif; ?>>
					<a href="#"><i class="fa fa-cog"></i> <span class="nav-label">系统配置</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (in_array ( ROUTE_CONTROL , array ( 'pay' , 'merchant' , 'sysconf' ) )): ?> in <?php endif; ?>">
					    <li <?php if (ROUTE_CONTROL == 'sysconf' && ROUTE_ACTION == 'index'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=sysconf&a=index">系统配置</a></li>
                        <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'config'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=pay&a=config">支付配置</a></li>
                        <!---<li <?php if (ROUTE_CONTROL == 'merchant' && ROUTE_ACTION == 'index'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=merchant&a=index">店铺分类</a></li>
                        <li <?php if (ROUTE_CONTROL == 'merchant' && ROUTE_ACTION == 'district'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=merchant&a=district">城市列表</a></li>
                        <li <?php if (ROUTE_CONTROL == 'merchant' && ROUTE_ACTION == 'banner'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=merchant&a=banner">首页幻灯</a></li>-->
                    </ul>
                </li>

				<!---<li <?php if (ROUTE_CONTROL == 'activity'): ?> class="active" <?php endif; ?>>
					<a href="#"><i class="fa fa-group"></i> <span class="nav-label">系统活动</span><span class="label label-info pull-right">NEW</span></a>
                    <ul class="nav nav-second-level collapse <?php if (ROUTE_CONTROL == 'activity'): ?> in <?php endif; ?>">
                        <li <?php if (ROUTE_CONTROL == 'activity' && ROUTE_ACTION == 'myactivity'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=activity&a=myactivity">进行中的活动</a></li>
                        <li <?php if (ROUTE_CONTROL == 'activity' && ROUTE_ACTION == 'crowdfunding'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=activity&a=crowdfunding">微众筹</a></li>
                        <li <?php if (ROUTE_CONTROL == 'activity' && ROUTE_ACTION == 'seckill'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=activity&a=seckill">微秒杀</a></li>
                        <li <?php if (ROUTE_CONTROL == 'activity' && ROUTE_ACTION == 'unitary'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=activity&a=unitary">一元夺宝</a></li>
                        <li <?php if (ROUTE_CONTROL == 'activity' && ROUTE_ACTION == 'bargain'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=activity&a=bargain">微砍价</a></li>
                        <li <?php if (ROUTE_CONTROL == 'activity' && ROUTE_ACTION == 'cutprice'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=activity&a=cutprice">降价拍</a></li>
                        <li <?php if (ROUTE_CONTROL == 'activity' && ROUTE_ACTION == 'lottery'): ?> class="active" <?php endif; ?>><a href="/merchants.php?m=System&c=activity&a=lottery">抽奖专场</a></li>
                    </ul>
                </li>--->
				<li <?php if (ROUTE_CONTROL == 'index' && ROUTE_ACTION == 'ModifyPwd'): ?> class="active" <?php endif; ?>>
                    <a href="/merchants.php?m=System&c=index&a=ModifyPwd"><i class="fa fa-unlock-alt"></i> <span class="nav-label">修改密码</span><span class="label label-info pull-right"></span></a>
                </li>
            </ul>

        </div>
    </nav>