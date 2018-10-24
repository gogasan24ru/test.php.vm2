<?php

class Singleton {
	private static $instance = [];
	private static $db;
	private static $id;

	private function __construct($id,$cnf)
	{
		self::$id=$id;
		self::$db=mysqli_connect($cnf['host'],
			$cnf['username'],
			$cnf['password'],
			$cnf['database']);//, $opt['port'], $opt['socket']);
	}
	public static function getInstance($id,$cnf)
	{
		if (!isset(self::$instance[$id]))
		{
			self::$instance[$id] = new Singleton($id,$cnf);
		}
		return self::$instance[$id];
	}
}
