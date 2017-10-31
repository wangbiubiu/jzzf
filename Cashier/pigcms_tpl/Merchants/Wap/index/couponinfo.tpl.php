<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{pg:$title}详情</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no" />
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/base.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/swiper.min.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/font-awesome.min.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/style.css">
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
<body style="background-color: #FFFFFF;">
	<section class="tabMod mt15">
		<div class="bd">
			<div class="home-tuan-list js-store-list" data-type="default" style="margin-left: 10px;">
				<div class="cnt" style="height: auto;">{pg:$title}详情</div>
				<div>
					<div class="wrap">
						<div class="wrap2">
							<div class="content">
								<div class="gift">
									<em style="color: #888;">优惠说明</em><em style="color: #000;">{pg:$coupon.show_note}</em>
								</div>
								<div class="gift">
									<em style="color: #888;">有效日期</em><em style="color: #000;">{pg:$coupon.begin_timestamp} 至  {pg:$coupon.end_timestamp}</em>
								</div>
								<div class="gift">
									<em style="color: #888;">电&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;话</em><em style="color: #000;"><a href="tel:{pg:$coupon.kqcontent.service_phone}" style="color:#33bf82">{pg:$coupon.kqcontent.service_phone}</a></em>
								</div>
								<div class="gift">
									<em style="color: #888;">使用须知</em><em style="color: #000;">{pg:$coupon.kqcontent.description}</em>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>