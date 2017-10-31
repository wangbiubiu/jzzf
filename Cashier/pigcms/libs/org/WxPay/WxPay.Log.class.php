<?php
interface ILogHandler
{
	public function write($msg);
}

class CLogFileHandler implements ILogHandler
{
	private $handle;

	public function __construct($file = '')
	{
		$this->handle = fopen($file, 'a');
	}

	public function write($msg)
	{
		fwrite($this->handle, $msg, 4096);
	}

	public function __destruct()
	{
		fclose($this->handle);
	}
}

class Log
{
	private $handler;
	private $level = 15;
	static 	private $instance;

	private function __construct()
	{
	}

	private function __clone()
	{
	}

	static public function Init($handler = NULL, $level = 15)
	{
		if (!self::$instance instanceof self) {
			self::$instance = new self();
			self::$instance->__setHandle($handler);
			self::$instance->__setLevel($level);
		}


		return self::$instance;
	}

	private function __setHandle($handler)
	{
		$this->handler = $handler;
	}

	private function __setLevel($level)
	{
		$this->level = $level;
	}

	static public function DEBUG($msg)
	{
		self::$instance->write(1, $msg);
	}

	static public function WARN($msg)
	{
		self::$instance->write(4, $msg);
	}

	static public function ERROR($msg)
	{
		$debugInfo = debug_backtrace();
		$stack = '[';

		foreach ($debugInfo as $key => $val ) {
			if (array_key_exists('file', $val)) {
				$stack .= ',file:' . $val['file'];
			}


			if (array_key_exists('line', $val)) {
				$stack .= ',line:' . $val['line'];
			}


			if (array_key_exists('function', $val)) {
				$stack .= ',function:' . $val['function'];
			}

		}

		$stack .= ']';
		self::$instance->write(8, $stack . $msg);
	}

	static public function INFO($msg)
	{
		self::$instance->write(2, $msg);
	}

	private function getLevelStr($level)
	{
		switch ($level) {
		case 1:
			return 'debug';
		case 2:
			return 'info';
		case 4:
			return 'warn';
		case 8:
			return 'error';
		}
	}

	protected function write($level, $msg)
	{
		if (($level & $this->level) == $level) {
			$msg = '[' . date('Y-m-d H:i:s') . '][' . $this->getLevelStr($level) . '] ' . $msg . "\n";
			$this->handler->write($msg);
		}

	}
}


?>