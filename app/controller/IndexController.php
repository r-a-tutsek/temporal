<?php

class Index {
	
	private static $instance = null;
	
	private function __construct() {
		
	}

	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new Index();
		}
		return self::$instance;
	}
	
	public function login($request) {
		
	}
}

?>