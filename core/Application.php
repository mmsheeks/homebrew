<?php

namespace Homebrew\Core;

use Symfony\Component\Yaml\Yaml;

use Homebrew\Core\Request;
use Homebrew\Core\Router;
use Homebrew\Database\Driver as Database;

class Application {

	protected $request 	= null;
	protected $router 	= null;
	protected $response	= null;
	protected $database = null;
	protected $config 	= null;
	
	public function __construct() {
		$this->loadConfig();
		$this->request = new Request;
		if( config('database.enabled') == true ) {
			$this->database = new Database;
		}
	}

	public function load() {
		$this->router = new Router( $this->request );
		return $this->router->handle();
	}

	private function loadConfig()
	{
		$filePath = __DIR__ . '/../../../../config.yml';
		$config = [];

		$config = Yaml::parse( file_get_contents( $filePath ) );

		$this->config = $config;

		global $app_config;
		$app_config = $config;
	}
}