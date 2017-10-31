				<style type="text/css">
					.page-heading{ padding: 10px;}
					.dh_nav ul dl {width: 20%; float: left; text-align:center;  margin-bottom: 0px}
					.dh_nav ul dl a dt{ margin-top: 10px; font-weight:normal; color: #333333}
				</style>
				
                 <div class="col-lg-12 dh_nav">
                	<ul>
                		<dl>
	                		<a href="/merchants.php?m=User&c=cashier&a=payment&type=1">
	                			<dd>
		                			<i class="imgxz"><img src="./Cashier/pigcms_static/image/<?php if ($_GET['type']==='1') echo 1;?>1.png"></i>
	                			</dd>
	                			<dt>扫码收银</dt>
	                		</a>
                		</dl>
                		<dl>
                			<a href="/merchants.php?m=User&c=cashier&a=payment&type=2">
	                			<dd>
	                			<i class="imgmxz"><img src="./Cashier/pigcms_static/image/<?php if ($_GET['type']==='2') echo 2;?>2.png"></i>
	                			
	                			</dd>
	                			<dt>扫码退款</dt>
                			</a>
                		</dl>
                		<dl>
                			<a href="/merchants.php?m=User&c=cashier&a=index">
	                			<dd>
	                			<i class="imgmxz"><img src="./Cashier/pigcms_static/image/<?php if (ROUTE_ACTION==='index') echo 3;?>3.png"></i>
	                			</dd>
	                			<dt>二维码收款</dt>
	                		</a>
                		</dl>
                		<dl>
                		<a href="/merchants.php?m=User&c=statistics&a=orderLists">
                			<dd>
                			<i class="imgmxz"><img src="./Cashier/pigcms_static/image/<?php if (ROUTE_CONTROL==='statistics') echo 4;?>4.png"></i>
                			</dd>
                			<dt>收款记录</dt>
                		</a>
                		</dl>
                		<dl>
                			<a href="/merchants.php?m=User&c=wxCoupon&a=consumeCard">
	                			<dd>
	                			<i class="imgmxz"><img src="./Cashier/pigcms_static/image/<?php if (ROUTE_CONTROL==='wxCoupon') echo 5;?>5.png"></i>
	            
	                			</dd>
	                			<dt>核销卡券</dt>
	                		</a>
                		</dl>
                	</ul>
                </div>