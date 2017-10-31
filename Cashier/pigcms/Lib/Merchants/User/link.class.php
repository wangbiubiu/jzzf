<?php

bpBase::loadAppClass('common', 'User', 0);
class link_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$info = $this->clear_html($_GET);
		$data['token'] = $info['token'];
		$data['hmuch'] = 'all';
		$result = $this->httpRequest(urldecode($info['url']) . '/index.php?g=Home&m=Links&a=index&auth=1', 'POST', $data);

		if ($result[0] == 200) {
			$re = json_decode($result[1], true);

			if ($re['status'] == 1) {
				$data = $re['data'];
				include $this->showTpl();
			}
			 else if ($re['status'] == 0) {
				echo $re['msg'];
			}

		}
		 else {
			echo $result[1];
		}
	}

	public function detailed()
	{
		$data = $this->clear_html($_GET);
		$url = urldecode($data['url']);
		unset($data['m']);
		unset($data['c']);
		unset($data['a']);
		unset($data['url']);
		$result = $this->httpRequest(urldecode($url) . '/index.php?g=Home&m=Links&a=detailed', 'POST', $data);

		if ($result[0] == 200) {
			$re = json_decode($result[1], true);

			if (isset($re['status']) && ($re['status'] == 0)) {
				echo $re['msg'];
			}
			 else {
				$retult = $result[1];
				preg_match('/<h4>([\\s\\S]+)<script>/U', $retult, $content);

				if (!empty($content[1])) {
					$content = '<h4>' . $content[1];
					$this->showTpl();
					$content = str_replace(array('{siteUrl}', '&wecha_id={wechat_id}', './tpl/Home'), array($url, '', urldecode($url) . '/tpl/Home'), $content);
					preg_match_all('/<a href=[\'\\"]?([^\'\\" ]+).*?>/', $content, $re);

					if ($re[1]) {
						foreach ($re[1] as $val ) {
							$links = $this->parseUrl($val);

							if (!empty($links)) {
								$link = array(url => $url);

								if (isset($links['pid'])) {
									$link['module'] = $links['a'];
									$link['token'] = $data['token'];
								}


								unset($links['g']);
								unset($links['m']);
								unset($links['a']);
								$link = array_merge($link, $links);
								$link = '?m=User&c=link&a=detailed&' . http_build_query($link);
								$content = str_replace($val, $link, $content);
							}

						}
					}


					include $this->showTpl();
				}
				 else {
					echo '获取内容失败';
				}
			}
		}
		 else {
			echo $result[1];
		}
	}

	public function parseUrl($url)
	{
		$data = parse_url($url);
		$return = array();

		if (isset($data['host'])) {
			$return['host'] = $data['scheme'] . '://' . $data['host'];
		}


		if (isset($data['query'])) {
			foreach (explode('&', $data['query']) as $key => $val ) {
				$data = explode('=', $val);
				$return[$data[0]] = $data[1];
			}
		}


		return $return;
	}
}


?>