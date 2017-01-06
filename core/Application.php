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
		$this->request = new Request;
		$this->router = new Router( $this->request );
		return $this->router->handle();
	}
	
	/*
	 * command - execute a command, assuming it's defined
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.5
	 */
	public function command( $args ) {
		// get the command
		$call = $this->getCommand( $args[1] );
		
		// if it couldn't find it, dump and exit
		if( $call === false ) {
			printf("Command not found\n");
			exit();
		}
		
		// call the thing the command says to call.
		$class = $call['class'];
		$method = $call['method'];
		$class = new $class;
		$class->$method( $args );
		
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
	/*
	 * getCommand - load the commands file from the project
	 *
	 * @author Martin Sheeks <martin.sheeks@gmail.com>
	 * @version 1.0.5
	 */
	private function getCommand( $do )
	{
		// get the config file
		$filePath = __DIR__ . '/../../../../commands.yml';
		$yamlString = file_get_contents( $filePath );
		// load the yaml content
		$config = [];
		$commands = Yaml::parse( $yamlString );
		$args = explode(':', $do );
		//find the command requested
		foreach( $args as $part ) {
			if( isset( $commands[ $part ] ) ) {
				$commands = $commands[ $part ];
			} else {
				return false;
			}
		}
		return $commands;
	}
}