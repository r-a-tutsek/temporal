<?php 

require 'vendor/autoload.php';
use Klein\Klein;

class Core {

	private static $instance = null;
	private $config;
  
	private function __construct() {
		$this->config = parse_ini_file('config.ini', true);
	}
 
	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new Core();
		}
		return self::$instance;
	}
	
	private function registerControllerAutoloader() {
		spl_autoload_register(function($className) {
			$controllerPath = $this->config['path']['controller'].'\\'.$className.$this->config['autoloader']['controller'].'.php';
			$apiControllerPath = $this->config['path']['controller'].'\\'.$className.$this->config['autoloader']['api_controller'].'.php';
			if(file_exists($controllerPath)) {
				include_once($controllerPath);
			}
			if(file_exists($apiControllerPath)) {
				include_once($apiControllerPath);
			}
		});
	}
	
	private function registerRoutes() {
		$klein = new Klein();
		$klein->respond(function($request, $response, $service) {
			$service->layout($this->config['path']['public'].'/layout.phtml');
		});
		$klein->respond('GET', '/', function ($request, $response, $service) {
			$service->render($this->config['path']['view'].'/index.html');
		});
		$klein->dispatch();
	}
	
	public function run() {
		$this->registerControllerAutoloader();
		$this->registerRoutes();
	}
}