<?php
if (!function_exists('pages')) {
function pages($total, $page, $pageSize, $url)
{
	$str = '';

	if ($pageSize < $total) {
		if ($total % $pageSize) {
			$totalPage = intval($total / $pageSize) + 1;
		}
		 else {
			$totalPage = intval($total / $pageSize);
		}

		$str .= '<div style="padding:10px;">';
		$str .= '<table id="spContents" cellspacing="0" border="0" border="0" style="width:100%;border-collapse:collapse;"><tr style="height:25px;"><td valign="middle">';
		$nextPageNum = $page + 1;
		$prePageNum = $page - 1;
		$nextStr = '&nbsp;&nbsp;<a href="' . $url . 'page=' . $nextPageNum . '" style="text-decoration:none;"><img title="下一页" src="' . PIGCMS_STATIC_PATH . 'images/arrow_next.gif" style="border-width:0px;" />&nbsp;下一页</a>&nbsp;&nbsp;<a href="' . $url . 'page=' . $totalPage . '" style="text-decoration:none;"><img title="末页" src="' . PIGCMS_STATIC_PATH . 'images/arrow_last.gif" style="border-width:0px;" />&nbsp;末页</a>';
		$preStr = '<a href="' . $url . 'page=1" style="text-decoration:none;"><img title="首页" src="' . PIGCMS_STATIC_PATH . 'images/arrow_first.gif" style="border-width:0px;" />&nbsp;首页</a>&nbsp;&nbsp;<a href="' . $url . 'page=' . $prePageNum . '" style="text-decoration:none;"><img title="上一页" src="' . PIGCMS_STATIC_PATH . 'images/arrow_prev.gif" style="border-width:0px;" />&nbsp;上一页</a>';

		if ($page < 2) {
			$preStr = '<img title="首页" src="' . PIGCMS_STATIC_PATH . 'images/arrow_first_d.gif" style="border-width:0px;" />&nbsp;<span style="color:gray;">首页</span>&nbsp;&nbsp;<img title="上一页" src="' . PIGCMS_STATIC_PATH . 'images/arrow_prev_d.gif" style="border-width:0px;" />&nbsp;<span style="color:gray;">上一页</span>';
		}
		 else if (($totalPage - 1) < $page) {
			$nextStr = '&nbsp;&nbsp;<img title="下一页" src="' . PIGCMS_STATIC_PATH . 'images/arrow_next_d.gif" style="border-width:0px;" />&nbsp;<span style="color:gray;">下一页</span>&nbsp;&nbsp;<img title="末页" src="' . PIGCMS_STATIC_PATH . 'images/arrow_last_d.gif" style="border-width:0px;" />&nbsp;<span style="color:gray;">末页</span>';
		}


		$str .= $preStr . $nextStr . '</td><td style="text-align:right;" valign="top">';
		$pageOption = '';
		$i = 1;

		while ($i < ($totalPage + 1)) {
			if ($i != $page) {
				$pageOption .= '<option value="' . $i . '">' . $i . '</option>';
			}
			 else {
				$pageOption .= '<option value="' . $i . '" selected>' . $i . '</option>';
			}

			++$i;
		}

		$str .= '共' . $total . '条记录&nbsp;&nbsp;当前页<select onchange="window.location.href=\'' . $url . 'page=\'+this.value+\'\'">' . $pageOption . '</select>';
		$str .= '</table>';
		$str .= '</div>';
	}
	 else {
		$str .= '<div style="padding:10px;text-align:right">共' . $total . '条记录</div>';
	}

	return $str;
}
}


if (!function_exists('foregroundPage')) {
function foregroundPage($total, $currentPage, $pageSize, $prefix = '', $suffix = '', $firstPageUrl = '')
{
	if ($pageSize) {
		if ($total % $pageSize) {
			$totalPage = intval($total / $pageSize) + 1;
		}
		 else {
			$totalPage = intval($total / $pageSize);
		}
	}


	$option = '';
	$i = 1;

	while ($i < ($totalPage + 1)) {
		if (intval($currentPage) != $i) {
			$option .= '<option value="' . $i . '">第' . $i . '页</option>';
		}
		 else {
			$option .= '<option value="' . $i . '" selected>第' . $i . '页</option>';
		}

		++$i;
	}

	$prePage = $currentPage - 1;
	$nextPage = $currentPage + 1;

	if ($firstPageUrl) {
		$first = '<a href="' . $firstPageUrl . '">首页</a>';
	}
	 else {
		$first = '<a href="' . $prefix . '1' . $suffix . '">首页</a>';
	}

	$pre = '<a href="' . $prefix . $prePage . $suffix . '">上一页</a>';
	$next = '<a href="' . $prefix . $nextPage . $suffix . '">下一页</a>';
	$last = '<a href="' . $prefix . $totalPage . $suffix . '">尾页</a>';

	if ($currentPage == 1) {
		$first = '';
		$pre = '';
	}


	if ($currentPage == $totalPage) {
		$next = '';
		$last = '';
	}


	if (1 < $totalPage) {
		return '<div id="page"><span>转到&nbsp;<select onchange="window.location.href=\'' . $prefix . '\'+this.value+\'' . $suffix . '\'" size="1">' . $option . '</select></span>共' . $total . '条 <font color="#FF0000">' . $currentPage . '</font>/' . $totalPage . '页　　' . $first . ' ' . $pre . ' ' . $next . ' ' . $last . ' </div>';
	}


	return '';
}
}


if (!function_exists('showMessage')) {
function showMessage($tip, $url, $interval = 2000, $titleTip = 1, $errorTip = 0)
{
	if (!function_exists('fgShowMessage_ext')) {
		$seconds = $interval / 1000;

		if ($titleTip) {
			$metaTitle = $tip . '_' . SITE_NAME;
		}
		 else {
			$metaTitle = SITE_NAME;
		}

		if (!$errorTip) {
			$iconUrl = 'pigcms_static/images/face-smile.png';
		}
		 else {
			$iconUrl = 'pigcms_static/images/face-sad.png';
		}

		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n\t\t" . '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n\t\t" . '<head>' . "\n" . '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n" . '<title>' . $metaTitle . '</title>' . "\n" . '<script>' . "\n\t" . ' window.onload = function(){' . "\n\t\t" . ' setTimeout(function(){' . "\n\t\t\t" . ' window.location.href=\'' . $url . '\';' . "\n\t\t" . ' },' . $interval . ');' . "\n\t" . ' }' . "\n" . '</script>' . "\n" . '</head>' . "\n" . '<body id="body">' . "\n" . '<style>' . "\n" . 'body {margin:0;padding:0;background:#f8f8f8}' . "\n" . 'div { font-size:12px;}' . "\n" . 'a:link {COLOR: #0a4173; text-decoration:none;}' . "\n" . 'a:visited {COLOR: #0a4173; text-decoration:none;}' . "\n" . 'a:hover {COLOR: #1274ba; text-decoration:none;}' . "\n" . 'a:active {COLOR: #1274ba; text-decoration:none;}' . "\n" . '</style>' . "\n" . '<div style="background:#fff;font-size:14px;width:600px; margin:60px auto; line-height:48px;height:48px;text-align:center;padding:60px 30px;border:5px solid #f3f3f3">' . "\n\t" . '<img src = "' . $iconUrl . '" align="absmiddle" />&nbsp;&nbsp;' . $tip . ' <span style="font-size:12px;color:#999">' . $seconds . '秒后将自动跳转，如果您的浏览器不能跳转</span> <a style="font-size:12px;" href="' . $url . '">请点击</a></span>' . "\n" . '</div>' . "\n" . '</body>' . "\n" . '</html>';
	}
	 else {
	 	

		fgShowMessage_ext($tip, $url, $interval);
	}
}
}

function mobilePages($total, $currentPage, $pageSize, $prefix = '', $suffix = '', $firstPageUrl = '')
{
	if ($pageSize) {
		if ($total % $pageSize) {
			$totalPage = intval($total / $pageSize) + 1;
		}
		 else {
			$totalPage = intval($total / $pageSize);
		}
	}
	if ($totalPage) {
		$prePage = $currentPage - 1;
		$nextPage = $currentPage + 1;
		if (($currentPage == 1) || ($totalPage == 1)) {
			$prePageStr = '<span class="up disable">上一页</span>';
		}
		 else {
			$prePageStr = '<a class="up" href="' . $prefix . $prePage . $suffix . '">上一页</a>';
		}

		if (($currentPage == $totalPage) || ($totalPage == 1)) {
			$nextPageStr = '<span class="down disable">下一页</span>';
		}
		 else {
			$nextPageStr = '<a class="down" href="' . $prefix . $nextPage . $suffix . '">下一页</a>';
		}

		return '<div id="divPager" class="page"><div class="page_hand">' . $prePageStr . '<span class="page_count"><b>' . $currentPage . '</b>/' . $totalPage . '页</span>' . $nextPageStr . '</div></div>';
	}

}


?>