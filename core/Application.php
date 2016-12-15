<?php

namespace Homebrew\Core;

use Symfony\Component\Yaml\Yaml;

use Homebrew\Core\Request;
use Homebrew\Core\Router;
use Homebrew\Core\ExceptionHandler as Exception;
use Homebrew\Database\Driver as Database;

/**
 * Application Class - The core class of the Homebrew application. Handles instantiation and execution of all further requests.
 *
 * @author Martin Sheeks <martin.sheeks@gmail.com>
 * @version 1.0.4
 *
 */
class Application {

	/*
	 * @var Request $request;
	 */
	protected $request 		= null;
	
	/*
	 * @var Router $router
	 */
	protected $router 		= null;
	
	/*
	 * @var Response $response
	 */
	protected $response		= null;
	
	/*
	 * @var DatabaseDriver $database
	 */
	protected $database 	= null;
	
	/*
	 * @var array $config
	 */
	protected $config 		= null;
	
	/*
	 * @var ExceptionHandler $exception
	 */
	protected $exception	= null;
	
	/*
	 * __construct
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	public function __construct() {
		
		//setup the exception handler
		$this->exception = new Exception;
		
		//load our config file and setup the request and database as needed
		$this->loadConfig();
		$this->request = new Request;
		if( config('database.enabled') == true ) {
			$this->database = new Database;
		}
	}

	/*
	 * load - loads the router given the current request and handles returning a response
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	public function load() {
		$this->router = new Router( $this->request );
		return $this->router->handle();
	}

	/*
	 * loadConfig - load the config file from the project
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.4
	 */
	private function loadConfig()
	{
		// get the config file
		$filePath = __DIR__ . '/../../../../config.yml';
		$yamlString = file_get_contents( $filePath );

		// load the yaml content
		$config = [];
		$config = Yaml::parse( $yamlString );

		// set the class variable
		$this->config = $config;

		// set a global variable to be used by the config() helper
		global $app_config;
		$app_config = $config;
	}
}