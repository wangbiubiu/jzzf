<?php
	/**
	 * 2015-08-11 Brooke
	 * 用户权限控制
	 * @param 第一列为项目名称 大小写不限制，为了美观最好大写
	 * @return Array
	 */
	 return array(
	 	'Merchants' => array(
			'User' => array(
				/*'Pay'=> array(
					'Config|Field' => '支付设置',
					'Des'=> '在线支付设置'
				),*/
				'Cashier'=> array(
                    'Index' => '收银台首页',
                    'PayRecord'=> '收款记录',
                    'EwmRecord'=> '二维码生成记录',
                    'DelOrderByid'=> '订单删除',
                    'WxRefund'=> '退款',
                    'payment'=> '刷卡支付页',
                    'wxSmRefund'=> '扫码退款',
                    'Des'=> '微信收银台'
                ),
				'alicashier'=>array(
					'Index' => '收银台首页',
					'payRecord'=> '收款记录',
					'ewmRecord'=> '二维码生成记录',
					'aliRefund'=> '退款',
					'alipayment'=> '条码支付页',
					'aliSmRefund'=> '扫码退款',
					'Des'=> '支付宝收银台'
				),
				/*'Merchant'=> array(
					'Employers' => '员工列表',
					'EmployersAdd' => '添加员工',
					'EmployersAppemd' => '编辑员工',
					'Field' => '修改员工登陆状态',
					'EmployersDel|EmployersDelAll' => '删除员工',
					'employersEdit' => '编辑',
					'Des'=> '商家设置'
				),*/
					'statistics'=> array(
					'orderLists'=>'收款记录',
					'index' => '收入数据统计',
					'fans' => '粉丝支付统计',
					'otherpie' => '概况统计',
					'Des'=> '数据统计'
				),
					'wxCoupon'=> array(
					'index' => '卡券管理',
					'createKq|docreateKq' => '创建卡券',
					'card|docreateKq'=>'创建会员卡',
					'delCardByid' => '卡券删除',
					'ModifyStock'=>'卡券库存修改',
					'wxReceiveList' => '卡券消费列表',
					'consumeCard' => '卡券核销',
					'cardindex' => '微信会员卡',
					'wxCardList'=>'会员信息',
					'paycell'=>'卡券支付记录',
					'bonus'=>'会员卡积分记录',
					'Des'=> '卡券设置'
				),
                                        'modify'=>array(
                                        'setPwd'=>'账户设置',
                                        'setElo'=>'店员设置',
                                        'setConf'=>'配置设置',
                                        'Des'=> '店长权限'
                                ),
				'Des'=> '用户界面操作',
			)
		),
	     'Salesman'=>array(
	         'Cashier'=> array(
					'Index' => '收银台首页',
					'PayRecord'=> '收款记录',
					'EwmRecord'=> '二维码生成记录',
					'DelOrderByid'=> '订单删除',
					'WxRefund'=> '退款',
					'payment'=> '刷卡支付页',
					'wxSmRefund'=> '扫码退款',
					'Des'=> '微信收银台'
				),
				'alicashier'=>array(
					'Index' => '收银台首页',
					'payRecord'=> '收款记录',
					'ewmRecord'=> '二维码生成记录',
					'aliRefund'=> '退款',
					'alipayment'=> '条码支付页',
					'aliSmRefund'=> '扫码退款',
					'Des'=> '支付宝收银台'
				),
				/*'Merchant'=> array(
					'Employers' => '员工列表',
					'EmployersAdd' => '添加员工',
					'EmployersAppemd' => '编辑员工',
					'Field' => '修改员工登陆状态',
					'EmployersDel|EmployersDelAll' => '删除员工',
					'employersEdit' => '编辑',
					'Des'=> '商家设置'
				),*/
					'statistics'=> array(
					'orderLists'=>'收款记录',
					'index' => '收入数据统计',
					'fans' => '粉丝支付统计',
					'otherpie' => '概况统计',
					'Des'=> '数据统计'
				),
					'wxCoupon'=> array(
					'index' => '卡券管理',
					'createKq|docreateKq' => '创建卡券',
					'card|docreateKq'=>'创建会员卡',
					'delCardByid' => '卡券删除',
					'ModifyStock'=>'卡券库存修改',
					'wxReceiveList' => '卡券消费列表',
					'consumeCard' => '卡券核销',
					'cardindex' => '微信会员卡',
					'wxCardList'=>'会员信息',
					'paycell'=>'卡券支付记录',
					'bonus'=>'会员卡积分记录',
					'Des'=> '卡券设置'
				),
                'modify'=>array(
                    'setPwd'=>'账户设置',
                    'setElo'=>'店员设置',
                    'setConf'=>'配置设置',
                    'Des'=> '店长权限'
                ),
				'Des'=> '用户界面操作',
			),

	 );
?>