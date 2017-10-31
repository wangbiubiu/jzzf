<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活动列表</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no" />
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/base.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/swiper.min.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/font-awesome.min.css">
<link rel="stylesheet" href="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/css/style.css">
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/jquery-2.1.4.min.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/swiper.jquery.min.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/iscroll.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/activity.js"></script>
<script src="{pg:$smarty.const.PIGCMS_TPL_STATIC_PATH}wap/js/layer/layer.js"></script>
<style>
#content{margin-bottom: 70px;}
</style>
</head>
<body>
	<div class="userHeader">
		<a class="back" href="javascript:;" onclick="window.history.back();">返回</a>
		<h2>活动列表</h2>
	</div>
	<section class="navBox pageSliderHide">
		<ul>
			<li class="dropdown-toggle caret category" data-nav="category"><span class="nav-head-name">{pg:$title}</span></li>
			<li class="dropdown-toggle caret sort" data-nav="sort"><span class="nav-head-name">默认排序</span></li>
		</ul>
		<div class="dropdown-wrapper">
			<div class="dropdown-module">
				<div class="scroller-wrapper">
					<div id="dropdown_scroller" class="dropdown-scroller" >
						<div>
							<ul>
								<li class="category-wrapper">
									<ul class="dropdown-list">
										<li data-category-id="all" class="active" onClick="list_location($(this));return false;">
											<span data-name="全部分类">全部分类</span>
										</li>
										<li data-category-id="crowdfunding" onClick="list_location($(this));return false;" class=" ">
											<span data-name="微众筹">微众筹</span>
										</li>
										<li data-category-id="seckill_action" onClick="list_location($(this));return false;" class=" ">
											<span data-name="微秒杀">微秒杀</span>
										</li>
										<li data-category-id="unitary" onClick="list_location($(this));return false;" class=" ">
											<span data-name="一元夺宝">一元夺宝</span>
										</li>
										<li data-category-id="bargain" onClick="list_location($(this));return false;" class=" ">
											<span data-name="微砍价">微砍价</span>
										</li>
										<li data-category-id="cutprice" onClick="list_location($(this));return false;" class=" ">
											<span data-name="降价拍">降价拍</span>
										</li>
										<li data-category-id="lottery" onClick="list_location($(this));return false;" class=" ">
											<span data-name="抽奖专场">抽奖专场</span>
										</li>
									</ul>
								</li>
								<li class="sort-wrapper">
									<ul class="dropdown-list">
										<li data-sort-id="asc" class="active" onClick="list_location($(this));return false;"><span data-name="默认排序">默认排序</span></li>
										<li data-sort-id="desc"  onclick="list_location($(this));return false;"><span data-name="最新发布">最新发布</span></li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
					<div id="dropdown_sub_scroller" class="dropdown-sub-scroller">
						<div></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="listBox specialItem">
		<ul id="content">
			<li class="pro_shop" style="display: none">
 				<div class="home-tuan-list js-store-list">
					<p class="clickMore"><a href="javascript:;" id="mypageid" data-pageid="2">查看更多</a></p>
				</div>
			</li>
		</ul>
	</section>
	{pg:include file="$tplHome/Wap/public/footer.tpl.php"}
</body>
<script type="text/javascript">
var table_name = '{pg:$table_name}', order = '{pg:$order}';
getAjaxList('{pg:$table_name}', 1);
</script>
</html>