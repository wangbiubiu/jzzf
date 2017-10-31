<?php /* Smarty version 2.6.18, created on 2017-10-27 10:07:50
         compiled from C:%5CUsers%5CAdministrator%5CDesktop%5Clll%5CCashier%5C./pigcms_tpl/Merchants/System/public/leftmenu.tpl2.php */ ?>
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

           
            <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'ModifyPwd'): ?> class="active" <?php endif; ?>>
                <a href="/merchants.php?m=System&c=pay&a=ModifyPwd"><i class="fa fa-unlock-alt"></i> <span class="nav-label">账户设置</span><span class="label label-info pull-right"></span></a>
            </li>
             <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'config'): ?> class="active" <?php endif; ?>>
                <a href="/merchants.php?m=System&c=pay&a=config"><i class="fa fa-unlock-alt"></i> <span class="nav-label">支付配置</span><span class="label label-info pull-right"></span></a>
            </li>
            <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'rebate'): ?> class="active" <?php endif; ?>>
                <a href="/merchants.php?m=System&c=pay&a=rebate"><i class="fa fa-unlock-alt"></i> <span class="nav-label">费率配置</span><span class="label label-info pull-right"></span></a>
            </li>
            <li <?php if (ROUTE_CONTROL == 'pay' && ROUTE_ACTION == 'TemplateImage'): ?> class="active" <?php endif; ?>>
                <a href="/merchants.php?m=System&c=pay&a=TemplateImage"><i class="fa fa-unlock-alt"></i> <span class="nav-label">模版图片上传</span><span class="label label-info pull-right"></span></a>
            </li>
        </ul>

    </div>
</nav>