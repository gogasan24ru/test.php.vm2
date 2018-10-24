<?php

class Singleton {
	private static $instance = [];
	private static $db;
	private static $id;
	private static $storage = [];

	private function __construct($id,$cnf)
	{
		self::$id=$id;
		self::$db=mysqli_connect($cnf['host'],
			$cnf['username'],
			$cnf['password'],
			$cnf['database']);
		self::loadStorage($id);
	}

	public function dump_storage()
	{
		var_dump(self::$storage);
	}

	public function get($path)
	{
		$path_items=explode('\\',$path);
		$ret=self::$storage;
		foreach ($path_items as $item)
		{
			$ret=$ret[$item];
		}
		return $ret;
	}

	public function set($path,$data)
	{

	}

	private function loadStorage($id)
	{
                $q='SELECT storage FROM users WHERE id='.$id;
                $storage=self::querySingle($q)['storage'];
                self::$storage=
                        unserialize(htmlspecialchars_decode($storage));
                if(!is_array(self::$storage))
                {
                        //guess no such entry or storage damaged (why?)
                        self::$storage=Array();
                        self::uploadStorage();
                }
	}

	private function uploadStorage()
	{
		$ser=htmlspecialchars(serialize(self::$storage));
		$q="INSERT INTO users ".
			" (id, storage) ".
			" VALUES ".
			" ( ".self::$id.",\"".$ser."\")".
			" ON DUPLICATE KEY UPDATE ".
			" storage = \"".$ser."\"";
		self::$db->query($q);
	}

	private function querySingle($q)
	{
		$q=self::$db->query($q);
		$ret=$q->fetch_array(MYSQLI_ASSOC);
		$q->free();
		return $ret;
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
