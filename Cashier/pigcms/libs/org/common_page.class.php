<?php
class Page
{
	public $firstRow;
	public $nowPage;
	public $totalPage;
	public $totalRows;
	public $page_rows;

	public function __construct($totalRows, $listRows)
	{
		$this->totalRows = $totalRows;
		$this->nowPage = ((!empty($_GET['page']) ? intval($_GET['page']) : 1));
		$this->listRows = $listRows;
		$this->totalPage = ceil($totalRows / $listRows);

		if (($this->totalPage < $this->nowPage) && (0 < $this->totalPage)) {
			$this->nowPage = $this->totalPage;
		}


		$this->firstRow = $listRows * ($this->nowPage - 1);
	}

	public function show($type = 1)
	{
		if ($this->totalRows == 0) {
			return false;
		}


		$now = $this->nowPage;
		$total = $this->totalPage;
		$url = $_SERVER['REQUEST_URI'] . ((strpos($_SERVER['REQUEST_URI'], '?') ? '' : '?'));
		$parse = parse_url($url);

		if (isset($parse['query'])) {
			parse_str($parse['query'], $params);
			unset($params['page']);
			$url = $parse['path'] . '?' . http_build_query($params);
		}


		if (strpos(strrev($url), '?') === 0) {
			$url .= 'page=';
		}
		 else {
			$url .= '&page=';
		}

		$str = '<div class="col-sm-6" id="commonpage"><div id="editable_paginate" class="dataTables_paginate paging_simple_numbers"><ul class="pagination"><li id="editable_previous" class="paginate_button previous"  ><span id="row_count">' . $now . ' / ' . $total . ' 页 ' . (($type == 1 ? '&nbsp;&nbsp;' : '&nbsp;&nbsp;&nbsp;&nbsp;')) . '</span></li>';

		if (1 < $now) {
			$str .= '<li id="editable_previous" class="paginate_button previous"  >' . "\r\n\t\t\t\t" . '<a href="' . $url . ($now - 1) . '">上一页</a>' . "\r\n\t\t\t" . '</li>';
		}


		if (($now != 1) && (4 < $now) && (6 < $total)) {
			$str .= '<li class="paginate_button "  ><a href="' . $url . '1">1</a></li><li class="paginate_button "  ><a href="">...</a></li>';
		}


		$i = 1;

		while ($i <= 5) {
			if ($now <= 1) {
				$page = $i;
			}
			 else if (($total - 1) < $now) {
				$page = ($total - 5) + $i;
			}
			 else {
				$page = ($now - 3) + $i;
			}

			if (($page != $now) && (0 < $page)) {
				if ($page <= $total) {
					$str .= '<li class="paginate_button"><a href="' . $url . $page . '">' . $page . '</a></li>';
				}
				 else {
					break;
				}
			}
			 else if ($page == $now) {
				$str .= '<li class="paginate_button active"  ><a href="">' . $page . '</a></li>';
			}


			++$i;
		}

		if (($total != $now) && ($now < ($total - 5)) && (10 < $total)) {
			$str .= '<li class="paginate_button"><a href="">...</a></li><li class="paginate_button active"  ><a href="' . $url . $total . '">' . $total . '</a></li>';
		}


		if ($now != $total) {
			$str .= '<li class="paginate_button next"   id="editable_next"><a href="' . $url . ($now + 1) . '">下一页</a></li>';
		}


		$str .= '</ul></div></div>';
		return ($this->listRows < $this->totalRows ? $str : '');
	}
}


?>