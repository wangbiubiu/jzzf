<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title></title>
	</head>
	<style>
	body{ font-family: "微软雅黑";}
    .clearfix:after {
        height: 0;
        content: " ";
        display: block;
        overflow: hidden;
        clear: both;
    }
    .clearfix {
        zoom: 1;/*IE低版本浏览器不支持after伪类所以要加这一句*/
    }
		div{ width: 96%; margin-left: 2%; margin-bottom: 20px; margin-top: 20px;}
		div>label{ width: 30%; display: inline-block; font-size: 14px; float:left;}
		div>span{ width:66%; display: inline-block; margin-left: 3%; font-size: 14px;word-break:break-all;float:left;}
	</style>
	<body>
		<div class="clearfix">
			<label>授权令牌:</label><span><?php echo $addalitoken['token'];?></span>
		</div>
		<div class="clearfix">
			<label>ISV返佣ID:</label><span><?php echo $addalitoken['user_id'];?></span>
		</div>
	</body>
</html>
