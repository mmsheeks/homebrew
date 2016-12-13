<?php

namespace Homebrew\Core;

use Homebrew\Core\Request;
use Homebrew\Core\Router;
use Homebrew\Database\Driver as Database;

class Application {

	protected $request 	= null;
	protected $router 	= null;
	protected $response	= null;
	protected $database = null;
	
	public function __construct() {
		$this->request = new Request;
		$this->database = new Database;
	}

	public function load() {
		$this->router = new Router( $this->request );
		return $this->router->handle();
	}
}